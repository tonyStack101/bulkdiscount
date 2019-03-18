<?php

namespace App\Services;


use App\Contracts\Services\CurrencyRate;
use GuzzleHttp\Client;

class ApiLayerCurrencyRate implements CurrencyRate
{
    private $_client;

    public function __construct()
    {
        $this->_client = new Client();
    }

    private function url()
    {
        return 'http://apilayer.net/api/live?access_key='.env('CURRENCY_LAYER_API');
    }

    private function file_path()
    {
        return storage_path('json/currency_rate.json');
    }

    public function save()
    {
        $data = $this->_client->request('GET', $this->url());
        $content = json_decode($data->getBody()->getContents());
        if( ! $content->success)
            return false;

        $quotes = $content->quotes;
        $files = $this->file_path();

        $fp = fopen($files, 'w');
        fwrite($fp, json_encode($quotes));
        fclose($fp);

        return true;
    }

    /**
     * Convert to default USD
     *
     * @param $amount
     * @param $currency
     * @return mixed
     */
    public function convertToUsd($amount, $currency)
    {
        $rate = $this->rate($currency);
        if( ! $rate)
            return false;

        return $amount * (1/$rate);
    }


    public function convertFromUsd($amount, $currency)
    {
        $rate = $this->rate($currency);
        if( ! $rate)
            return false;

        return $amount * $rate;
    }

    /**
     * Rate default USD
     * @param $from
     * @param $to
     * @return mixed
     */
    public function rate($from, $to = 'USD')
    {
        try{
            $key = strtoupper($to.$from);
            $content = file_get_contents($this->file_path());
            $content = json_decode($content, true);
            if(array_key_exists($key, $content))
            {
                return $content[$key];
            } else
                return false;
        } catch (\Exception $exception) {
            return false;
        }
    }
}