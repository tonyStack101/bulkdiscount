<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class GzService {


    public function __construct()
    {

    }

    /**
     * @param       $url
     * @param array $data
     *
     * @return mixed
     */
    public function getRequest($url, $shop_id , $data = [])
    {
        $client = new Client();
        $headers =  self::getHeaders($shop_id);
        try{
            $response = $client->request( 'GET', "$url",
                [
                    'headers' => $headers,
                    'query' => $data
                ]
            );
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
    public function postRequest($url, $shop_id , $data = [])
    {
        $client = new Client();
        $headers =  self::getHeaders($shop_id);
        try{
            $response = $client->request(
                'POST',
                "$url",
                [
                    'headers' => $headers,
                    'body' => json_encode($data)
                ]);


            return ['status' => true, 'data' => json_decode($response->getBody()->getContents())];

        } catch (ClientException $exception)
        {
            $response = json_decode($exception->getResponse()->getBody()->getContents());
            $message = isset($response->errors->base[0]) ? $response->errors->base[0] : 'Error request';
            return ['status' => false, 'message' => $message, 'response' => $response];
        }
    }

    public function putRequest($url, $shop_id, $data = [])
    {
        $client = new Client();
        $headers =  self::getHeaders($shop_id);
        try{
            $response = $client->request(
                'PUT',
                "$url",
                [
                    'headers' => $headers,
                    'body' => json_encode($data)
                ]);

            return ['status' => true, 'data' => json_decode($response->getBody()->getContents())];

        } catch (ClientException $exception)
        {
            $response = json_decode($exception->getResponse()->getBody()->getContents());
            $message = isset($response->errors->base[0]) ? $response->errors->base[0] : 'Error request';
            return ['status' => false, 'message' => $message];
        }
    }

    public function deleteRequest($url, $shop_id)
    {
        $client = new Client();
        $headers =  self::getHeaders($shop_id);
        try{
            $response = $client->request('DELETE', "$url",
                [
                    'headers' => $headers
                ]);

            return ['status' => true, 'data' => json_decode($response->getBody()->getContents())];
        } catch (\Exception $exception)
        {
            return ['status' => false, 'message' => $exception->getMessage()];
        }

    }

    public function postRequestPartner($url , $data = [])
    {
        $client = new Client();
        try{
            $response = $client->request(
                'POST',
                "$url",
                [
                    'headers' => [
                        'Content-Type' => 'application/json'
                    ],
                    'body' => json_encode($data)
                ]);


            return ['status' => true, 'data' => json_decode($response->getBody()->getContents())];

        } catch (ClientException $exception)
        {
            $response = json_decode($exception->getResponse()->getBody()->getContents());
            $message = isset($response->errors->base[0]) ? $response->errors->base[0] : 'Error request';
            return ['status' => false, 'message' => $message, 'response' => $response];
        }
    }

    public function getHeaders($shop_id){
        return [
            'Content-Type' => 'application/json',
            'Authorization' => json_encode(["shop_id" => $shop_id])
        ];
    }

}