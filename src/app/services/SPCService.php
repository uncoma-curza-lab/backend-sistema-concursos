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

    public function getOne(string $endpoint, string $id, array $params = null) : array
    {
        $paramsStr = $this->paramsToStr($params);

        try {
            $response = self::exec(
                $this->url . '/' . $endpoint . '/' . $id . $paramsStr,
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

    public function getLastProgramUrl(int $course_id) : ?string
    {
        $response = $this->getOne('asignatura', $course_id, ['withExport' => '1']);

        if($response['code'] == 200){
            $data = json_decode($response['data']);
            if($data->_links->exports){
                $exports =  (array) $data->_links->exports;
                $keys = array_keys($exports);
                $lentg = count($exports);
                return $exports[$keys[$lentg - 1]]->href;
            }
        }
        return null;
    }

    private function paramsToStr(?array $params) : string
    {
        $paramsStr = '';
        if($params){
            $paramsStr = '?';
            $i = 0;
            foreach ($params as $key => $param) {
                $paramsStr .= $i > 0 ? '&' : '';
                $paramsStr .= $key . '=' . $param;
                $i++;
            }
        }
        return $paramsStr;
    }
}
