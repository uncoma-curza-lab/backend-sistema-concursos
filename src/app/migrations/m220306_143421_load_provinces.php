<?php

use yii\db\Migration;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * Class m220306_143421_load_provinces
 */
class m220306_143421_load_provinces extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        echo "Start load provinces.\n";
        $this->executeFunction($this->getProvinces(), function($table, $province) {
            $this->insert($table, $province);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "Start delete rows from countries.\n";
        $this->executeFunction($this->getProvinces(), function($table, $province) {
            $this->delete($table, [
                'code' => $province['code'],
            ]);

        });
        return true;
    }

    private function executeFunction($provinces, callable $callback) : void
    {
        $argentinaCountry = (new Query)->from('countries')->where(['=', 'code', 'AR'])->one();
        $argentinaID = $argentinaCountry['id'];
        foreach ($provinces as $id => $province) {
            $callback(
                'provinces', 
                [
                    'code' =>  $id,
                    'name' => $province,
                    'country_id' => $argentinaID,
                ]
            );
        }

    }

    private function getProvinces()
    {
        $provinces = file_get_contents(\Yii::$app->getBasePath() .  '/migrations/jsondata/AR/provinces.json', 0, null);
        $provinces = json_decode($provinces, true)['provincias'];
        $provinces = ArrayHelper::map($provinces, 'id', 'nombre');
        return $provinces;
    }
}
