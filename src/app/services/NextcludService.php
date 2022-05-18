<?php

namespace app\services;

class NextcludService
{
    use GuzzleTrait;

    protected $baseUrl;
    protected $urlValues;
    protected $headers;
    protected $auth;

    public function __construct()
    {
        $this->baseUrl = \Yii::$app->params['nextcloud']['url'];
        $this->headers = [
            'Content-Type' => 'application/xml',
            'Accept' => 'application/xml',
        ];
        $this->auth = [
            \Yii::$app->params['nextcloud']['username'],
            \Yii::$app->params['nextcloud']['password'],
        ];
    }

    public function createFolder(string $folder)
    {
        $dir = \Yii::$app->params['nextcloud']['dir'];
        try{
            $response = self::exec(
                url: $this->baseUrl . "remote.php/dav/files/admin/$dir/$folder",
                params: [
                    'headers' => $this->headers,
                    'auth' => $this->auth,
                ],
                method: 'MKCOL',
            );

            return [
                'code' => $response->getStatusCode(),
                'data' => simplexml_load_string($response->getBody(),'SimpleXMLElement',LIBXML_NOCDATA),
            ];
        } catch (\Exception $e) {
            return [
                'code' => 500,
                'data' => 'Error en el servidor',
                'messege' => $e->getMessage(),
                'exception' => $e,
            ];

        }


    }
/*
    public function getAll(string $endpoint) : array
    {
        try {
            $response = self::exec(
                $this->baseUrl . '/' . $endpoint,
                null,
                $this->headers,
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

    public function getOne(string $endpoint, string $id) : array
    {
        try {
            $response = self::exec(
                $this->baseUrl . '/' . $endpoint . '/' . $id,
                null,
                $this->headers,
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

    }*/
}
