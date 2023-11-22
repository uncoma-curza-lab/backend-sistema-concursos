<?php

namespace app\services;

use Exception;
use Yii;

/**
 * @deprecated
 */
class NextcloudService
{
    use GuzzleTrait;

    protected $baseUrl;
    protected $headers;
    protected $auth;
    protected $dir;

    const TIMEOUT = 25;
    const PUBLIC_PERMISSION = 31;
    const READ_ONLY_PERMISSION = 1;

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
        $user = $this->auth[0];
        try{
            $response = self::exec(
                url: $this->baseUrl . "remote.php/dav/files/$user/$this->dir/$folder",
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
        } catch (\Throwable $e) {
            Yii::warning($e->getMessage(), 'NextcloudService-creteFolder');

            return [
                'code' => 500,
                'data' => 'Error en el servidor',
                'messege' => $e->getMessage(),
                'exception' => $e,
            ];

        }
    }

    public function createFolderShare(string $pathToFolder, int $permissions, string $publicUpload = 'false', string $expireDate = null): array
    {
        if(!$this->isValidPermission($permissions)){
            throw new Exception('El permiso no es valido');
        }
        $expireDate = ($expireDate != null) ? "&expireDate=$expireDate" : '';
        $urlValues = '';
        $path = "/$this->dir/$pathToFolder";
        $shareType = 3;
        $urlValues = "?path=$path&shareType=$shareType$expireDate&permissions=$permissions&publicUpload=$publicUpload";

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
            $xml = simplexml_load_string($response->getBody());
            
            Yii::info(json_encode($xml), 'NextcloudService-createFolderShare');

            $shareId = (int) $xml->data->id;
            $shareUrl = $xml->data->url;
            if(!$shareId || $response->getStatusCode() > 300){
                Yii::error(json_encode($xml), 'NextcloudService-createFolderShareError');
            }
            return [
                'code' => $response->getStatusCode(),
                'status' => true,
                'shareId' => $shareId,
                'shareUrl' => $shareUrl,
            ];
        } catch (\Throwable $e) {
            Yii::warning($e->getMessage(), 'NextcloudService-createFolderShare');
            return [
                'code' => 500,
                'status' => false,
                'data' => 'Error en el servidor',
                'messege' => $e->getMessage(),
            ];

        }
    }

    public function createPublicShare($path, $expireDate = null): array
    {
        return $this->createFolderShare(
            $path,
            self::PUBLIC_PERMISSION,
            'true',
            $expireDate
        );
    }

    public function createReadOnlyShare($path, $expireDate = null): array
    {
        return $this->createFolderShare(
            $path,
            self::READ_ONLY_PERMISSION,
            'false',
            $expireDate
        );
    }


    private function isValidPermission($permission): bool
    {
        return in_array($permission, [
            self::READ_ONLY_PERMISSION,
            self::PUBLIC_PERMISSION
        ]);
    }

    public function getFolderShare(int $shareId): Array
    {
        $this->headers['OCS-APIRequest'] = 'true';

        try{
            $response = self::exec(
                url: $this->baseUrl . "ocs/v1.php/apps/files_sharing/api/v1/shares/$shareId",
                params: [
                    'headers' => $this->headers,
                    'auth' => $this->auth,
                ],
                method: 'GET',
            );
            $statusCode = simplexml_load_string($response->getBody())->meta->statuscode;
            if($statusCode == 100){
                $url = simplexml_load_string($response->getBody())->data->element->url;
                return [
                    'code' => $statusCode,
                    'status' => true,
                    'url' => $url,
                ];

            }else{
                return [
                    'code' => $statusCode,
                    'status' => false,
                ];

            }
        } catch (\Throwable $e) {
            Yii::warning($e->getMessage(), 'NextcloudService-getFolderShare');
            return [
                'code' => 500,
                'status' => false,
                'data' => 'Error en el servidor',
                'messege' => $e->getMessage(),
            ];

        }

    }
}
