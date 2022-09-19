<?php

class Curl 
{
    static public $url = 'https://jsonplaceholder.typicode.com/';
    private $curl;

    public static function init()
    {
        $class = new self();
        $class->curl = curl_init();
        curl_setopt($class->curl, CURLOPT_RETURNTRANSFER, true);
        return $class;
    }

    public function setopt($url, $id)
    {
        curl_setopt($this->curl, CURLOPT_URL, self::$url . $url . $id);
        return json_decode($this->end());
    }

    public function setoptMethod($url, $method, $params = null)
    {
        curl_setopt_array(
            $this->curl,
            [
                CURLOPT_URL => self::$url . $url,
                CURLOPT_CUSTOMREQUEST => $method,
                CURLOPT_HTTPHEADER => ['Content-type: application/json; charset=UTF-8'],
                CURLOPT_POSTFIELDS =>  $params
            ]
        );
        return  json_decode($this->end());
    }

    public function end()
    {
        $ex = curl_exec($this->curl);
        curl_close($this->curl);
        return $ex;
    }

}