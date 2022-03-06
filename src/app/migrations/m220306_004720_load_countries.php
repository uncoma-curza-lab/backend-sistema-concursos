<?php

use yii\db\Migration;
use yii\helpers\FileHelper;

/**
 * Class m220306_004720_load_countries
 */
class m220306_004720_load_countries extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        echo "Start load countries.\n";
        $countries = $this->getCountries();
        $this->executeFunction($countries, function($table, $country) {
            $this->insert($table, $country);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "Start delete rows from countries.\n";
        $this->executeFunction($this->getCountries(), function($table, $country) {
            $this->delete($table, [
                'code' => $country['code'],
            ]);

        });
        return true;
    }

    private function executeFunction($countries, callable $callback) : void
    {
        foreach ($countries as $country) {
            $callback('countries', $country);
        }

    }

    private function getCountries()
    {
        $countries = file_get_contents(\Yii::$app->getBasePath() .  '/migrations/jsondata/countries.json', 0, null);
        $countries = json_decode($countries, true);
        return $countries;
    }
}
