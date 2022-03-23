<?php

use yii\db\Migration;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * Class m220306_145003_load_cities
 */
class m220306_145003_load_cities extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        echo "Start load cities.\n";
        $this->executeFunction($this->getCities(), function($table, $cities) {
            $this->insert($table, $cities);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "Start delete rows from cities.\n";
        $this->executeFunction($this->getCities(), function($table, $city) {
            $this->delete($table, [
                'code' => $city['code'],
            ]);

        });
        return true;
    }

    private function executeFunction($cities, callable $callback) : void
    {
        foreach ($cities as $id => $city) {
            $province = (new Query)->from('provinces')->where(['=', 'code', $city['provincia']['id']])->one();
            $callback(
                'cities', 
                [
                    'code' =>  $city['id'],
                    'name' => $city['nombre'],
                    'province_id' => $province['id'],
                ]
            );
        }

    }

    private function getCities()
    {
        $cities = file_get_contents(\Yii::$app->getBasePath() .  '/migrations/jsondata/AR/cities.json', 0, null);
        $cities = json_decode($cities, true)['localidades-censales'];
        $cities = ArrayHelper::map(
            $cities,
            'id',
            function($model) {
                return [
                    'id' => $model['id'],
                    'provincia' => $model['provincia'],
                    'nombre' => $model['nombre']
                ];
            });
        return $cities;
    }
}
