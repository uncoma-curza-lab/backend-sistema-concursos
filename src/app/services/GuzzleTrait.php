<?php
namespace App\Services;

use GuzzleHttp\Psr7\Response as GuzzleResponse;

trait GuzzleTrait
{
    public static function exec($url, array $params =[], $method = null) : ?GuzzleResponse
    {
        try {
            $client = new \GuzzleHttp\Client([
                'timeout' => self::TIMEOUT ??  5,
                'connect_timeout' => self::TIMEOUT ?? 5,
            ]);

            $request = [];

            if(array_key_exists('headers', $params)){
                $request['headers'] = $params['headers'];
            }
            if(array_key_exists('auth', $params)){
                $request['auth'] = $params['auth'];
            }
            if(array_key_exists('body', $params)){
                $request['body'] = $params['body'];
            }


            $response = $client->request($method, $url, $request);

            return ($response);

        } catch (\GuzzleHttp\Exception\ServerException $e) {
            \Yii::error('Server Exception: ' . $e->getResponse()->getBody()->getContents());
            return $e->getResponse();
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            \Yii::error('Client Exception: ' . $e->getResponse()->getBody()->getContents());
            return $e->getResponse();
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            throw $e;
        } catch (\Exception $e) {
            \Yii::error($e->getMessage());
            throw $e;
        }
    }

}
