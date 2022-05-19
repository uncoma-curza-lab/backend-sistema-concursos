<?php

namespace app\services;

class NextcludService
{
    use GuzzleTrait;

    protected $baseUrl;
    protected $headers;
    protected $auth;
    protected $dir;

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
        $this->dir = \Yii::$app->params['nextcloud']['dir'];
    }

    public function createFolder(string $folder)
    {
        try{
            $response = self::exec(
                url: $this->baseUrl . "remote.php/dav/files/admin/$this->dir/$folder",
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
    public function createFolderShare(string $pathToFolder, int $permissions, string $expireDate)
    {
        $urlValues = '';
        $path = "/$this->dir/$pathToFolder";
        $shareType = 4;
        $urlValues = "?path=$path&shareType=$shareType&expireDate=$expireDate&permissions=$permissions";

        $this->headers['OCS-APIRequest'] = 'true';

        try{
            $response = self::exec(
                url: $this->baseUrl . "ocs/v1.php/apps/files_sharing/api/v1/shares$urlValues",
                params: [
                    'headers' => $this->headers,
                    'auth' => $this->auth,
                ],
                method: 'POST',
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

}
