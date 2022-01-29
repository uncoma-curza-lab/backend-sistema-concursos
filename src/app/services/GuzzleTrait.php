<?php
namespace App\Services;

use GuzzleHttp\Psr7\Response as GuzzleResponse;

trait GuzzleTrait
{
    public static function exec($url, $data = [], array $headers =[], $method = null) : ?GuzzleResponse
    {
        try {
            $client = new \GuzzleHttp\Client([
                'timeout' => 5,
                'connect_timeout' => 5,
            ]);

            $request = [
                'headers' => $headers
            ];

            if (! empty($data) ) {
                $request['json'] = $data;
            }

            $response = $client->request($method, $url, $request);

            return ($response);

        } catch (\GuzzleHttp\Exception\ServerException $e) {
            \Yii::error('Server Exception: ' . $e->getResponse()->getBody()->getContents(), ['user' => \Yii::$app->user]);
            return $e->getResponse();
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            \Yii::error('Client Exception: ' . $e->getResponse()->getBody()->getContents(), ['user' => \Yii::$app->user]);
            return $e->getResponse();
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            throw $e;
        } catch (\Exception $e) {
            \Yii::error($e->getMessage(), ['user' => \Yii::$app->user]);
            throw $e;
        }
    }

}
