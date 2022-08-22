<?php

namespace app\services;

class SPCService
{
    use GuzzleTrait;

    const TIMEOUT = 25;
    protected $url;
    protected $headers;

    public function __construct()
    {
        $this->url = \Yii::$app->params['spc']['url'];
        $this->headers = [
            //'Authorization' => 'Basic ' . $this->token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    public function getAll(string $endpoint) : array
    {
        try {
            $response = self::exec(
                $this->url . '/' . $endpoint,
                ['headers' => $this->headers],
                'GET'
            );

            return [
                'code' => $response->getStatusCode(),
                'data' => $response->getBody()->getContents(),
            ];
        } catch (\Exception $e) {
            return [
                'code' => 500,
                'data' => 'Error en el servidor',
            ];

        }
    }

    public function getOne(string $endpoint, string $id, array $headers = null) : array
    {
        if($headers){
            $this->headers += $headers;
        }

        try {
            $response = self::exec(
                $this->url . '/' . $endpoint . '/' . $id,
                ['headers' => $this->headers],
                'GET'
            );

            return [
                'code' => $response->getStatusCode(),
                'data' => $response->getBody()->getContents(),
            ];
        } catch (\Exception $e) {
            return [
                'code' => 500,
                'data' => 'Error en el servidor',
            ];

        }

    }
}
