<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class SpfService {

    /**
     * @var
     */
	private $_shopDomain;

    /**
     * @var
     */
	private $_accessToken;

	public function __construct($shopDomain = '', $accessToken = '')
    {
        /**
         *
         */
        $this->_shopDomain = $shopDomain;
        /**
         *
         */
        $this->_accessToken = $accessToken;
    }

    /**
     * @param string $shopDomain
     * @param string $accessToken
     */
	public function setParameter($shopDomain = '', $accessToken = '') {
		$this->_shopDomain  = ! empty( $shopDomain ) ? $shopDomain : session( 'shopDomain' );
		$this->_accessToken = ! empty( $accessToken ) ? $accessToken : session( 'accessToken' );
	}

    /**
     * @param string $code
     *
     * @return mixed
     */
	public function getAccessToken($code = '' )
	{
	    $client = new Client();
		$data     = array(
			'client_id'     => env('SHOPIFY_API_KEY'),
			'client_secret' => env('SHOPIFY_SECRET_KEY'),
			'code'          => $code
		);
		try{
            $response = $client->post("https://" . $this->_shopDomain . "/admin/oauth/access_token", ['form_params' => $data]);

            $response = json_decode( $response->getBody()->getContents() );

            return $response->access_token;
        } catch (\Exception $exception)
        {
            dd($exception);
            return false;
        }

	}

    /**
     * @param $shopDomain
     *
     * @return string
     */
	public function installURL($shopDomain)
	{
		return 'https://' . $shopDomain . '/admin/oauth/authorize?client_id=' . env( 'SHOPIFY_API_KEY' ) . '&scope=' . implode( ',', config( 'shopify.scopes' ) ) . '&redirect_uri=' . config( 'shopify.redirect_before_install' );
	}

    /**
     * @param null $data
     * @param bool $bypassTimeCheck
     *
     * @return bool
     * @throws \Exception
     */
	public function verifyRequest($data = null, $bypassTimeCheck = false )
	{
		$da = array();
		if ( is_string( $data ) ) {
			$each = explode( '&', $data );
			foreach ( $each as $e ) {
				list( $key, $val ) = explode( '=', $e );
				$da[ $key ] = $val;
			}
		} elseif ( is_array( $data ) ) {
			$da = $data;
		} else {
			throw new \Exception( 'Data passed to verifyRequest() needs to be an array or URL-encoded string of key/value pairs.' );
		}
		
		// Timestamp check; 1 hour tolerance
		if ( ! $bypassTimeCheck ) {
			if ( ( $da['timestamp'] - time() > 3600 ) ) {
				throw new \Exception( 'Timestamp is greater than 1 hour old. To bypass this check, pass TRUE as the second argument to verifyRequest().' );
			}
		}
		
		if ( array_key_exists( 'hmac', $da ) ) {
			// HMAC Validation
			$queryString = http_build_query( array(
				'code'      => $da['code'],
				'shop'      => $da['shop'],
				'timestamp' => $da['timestamp']
			) );
			$match       = $da['hmac'];
			$calculated  = hash_hmac( 'sha256', $queryString, env( 'SHOPIFY_SECRET_KEY' ) );
		} else {
			// MD5 Validation, to be removed June 1st, 2015
			$queryString = http_build_query( array(
				'code'      => $da['code'],
				'shop'      => $da['shop'],
				'timestamp' => $da['timestamp']
			), null, '' );
			$match       = $da['signature'];
			$calculated  = md5( env( 'SHOPIFY_SECRET_KEY' ) . $queryString );
		}
		
		return $calculated === $match;
	}
	
	public function authApp($request)
	{
	    try {
			$verify = $this->verifyRequest($request);
			if ( $verify ) {
				$accessToken = $this->getAccessToken($request['code']);
				
				return $accessToken;
			}
			
			return false;
		} catch ( \Exception $exception ) {
			throw new \Exception( $exception->getMessage() );
		}
	}
	
	/**
	 * @param       $url
	 * @param array $data
	 *
	 * @return mixed
	 */
	public function getRequest($url, $data = [])
	{
		$client = new Client();
		try{
            $this->sendRequest();
            $response = $client->request( 'GET', "https://$this->_shopDomain/admin/$url",
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'X-Shopify-Access-Token' => $this->_accessToken
                    ],
                    'query' => $data
                ]
            );
            $this->sleepWhenApiLimited($response->getHeader('X-Shopify-Shop-Api-Call-Limit'));
            return ['status' => true, 'data' => json_decode($response->getBody()->getContents())];
        } catch (\Exception $exception)
        {
            return ['status' => false, 'message' => $exception->getMessage()];
        }
	}
	
	/**
	 * @param       $url
	 * @param array $data
	 *
	 * @return mixed
	 */
	public function postRequest($url, $data = [])
	{
		$client = new Client();
		try{
            $this->sendRequest();
            $response = $client->request(
                'POST',
                "https://$this->_shopDomain/admin/$url",
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'X-Shopify-Access-Token' => $this->_accessToken
                    ],
                    'body' => json_encode($data)
                ]);
            $this->sleepWhenApiLimited($response->getHeader('X-Shopify-Shop-Api-Call-Limit'));
            return ['status' => true, 'data' => json_decode($response->getBody()->getContents())];

        } catch (ClientException $exception)
        {
            $response = json_decode($exception->getResponse()->getBody()->getContents());
            $message = isset($response->errors->base[0]) ? $response->errors->base[0] : 'Error request';
            return ['status' => false, 'message' => $message, 'response' => $response];
        }
	}

    public function putRequest($url, $data = [])
    {
        $client = new Client();

        try{
            $this->sendRequest();
            $response = $client->request(
                'PUT',
                "https://$this->_shopDomain/admin/$url",
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'X-Shopify-Access-Token' => $this->_accessToken
                    ],
                    'body' => json_encode($data)
                ]);
            $this->sleepWhenApiLimited($response->getHeader('X-Shopify-Shop-Api-Call-Limit'));
            return ['status' => true, 'data' => json_decode($response->getBody()->getContents())];

        } catch (ClientException $exception)
        {
            $response = json_decode($exception->getResponse()->getBody()->getContents());
          
            $message = isset($response->errors->base[0]) ? $response->errors->base[0] : 'Error request';
            return ['status' => false, 'message' => $message];
        }
    }


    /**
     * @param $url
     *
     * @return mixed
     */
	public function deleteRequest($url)
	{
		$client = new Client();
		try{
            $this->sendRequest();
            $response = $client->request('DELETE', "https://$this->_shopDomain/admin/$url",
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'X-Shopify-Access-Token' => $this->_accessToken
                    ]
                ]);
            $this->sleepWhenApiLimited($response->getHeader('X-Shopify-Shop-Api-Call-Limit'));
            return ['status' => true, 'data' => json_decode($response->getBody()->getContents())];
        } catch (\Exception $exception)
        {
            return ['status' => false, 'message' => $exception->getMessage()];
        }

    }
    
    private function sleepWhenApiLimited($data) {
        if(is_array($data) && count($data) > 0) {
            $arrLimit = preg_split("/[ \/]+/", $data[0]);
            if(count($arrLimit) > 1) {
                $currentRequest = (int)$arrLimit[0];
                $totalRequest = (int)$arrLimit[1];
                if($totalRequest && $currentRequest) {
                    // $this->setNumberRequest($this->_shopDomain, $currentRequest);
                    if($totalRequest - $currentRequest <= 5) {

                        $text = 'Stress shop: ' . $this->_shopDomain . ': ' . $data[0];
                        // $this->slackPush(['text' => $text]);

                        sleep(rand(3, 10));
                    }
                }
            }
        }
    }

    private function slackPush($data)
    {
        $client = new Client();
        $client->request('post', 'https://hooks.slack.com/services/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',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode(['text' => json_encode($data)])
            ]
        );
    }

    private function setNumberRequest($shopDomain, $number) {
        Cache::put('reuqest_' . $shopDomain, $number, 1000);
    }

    private function getNumberRequest($shopDomain) {
        return Cache::get('reuqest_' . $shopDomain, 0);
    }

    private function sendRequest() {
        // $numberRequest = $this->getNumberRequest($this->_shopDomain);
        // if(40 - $numberRequest <= 5) {
        //     sleep(rand(3, 10));
        //     $text = 'Stress shop: ' . $this->_shopDomain . ': ' . $numberRequest . '/40';
        //     // $this->slackPush(['text' => $text]);
        //     $numberRequest = $this->getNumberRequest($this->_shopDomain);
        // }
        // $this->setNumberRequest($this->_shopDomain, $numberRequest+1);
    }
}