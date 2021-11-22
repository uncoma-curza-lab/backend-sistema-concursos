<?php

use yii\db\Migration;

/**
 * Class m211121_230744_load_category_types
 */
class m211121_230744_load_category_types extends Migration
{
    const CATEGORY_TYPES = [
        'Suplente',
        'Interinos',
        'Regulares',
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        echo "Loading category types...\n";

        $this->executeFunction(function($table, $categoryType) {
            $this->insert($table, [
                'name' => $categoryType,
                'code' => \Yii::$app->slug->format($categoryType, '-'),
            ]);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "Start truncate table category types.\n";
        $this->executeFunction(function($table, $categoryType) {
            $this->delete($table, [
                'code' => \Yii::$app->slug->format($categoryType),
            ]);
        });
        return true;
    }

    private function executeFunction(callable $callback)
    {
        foreach (self::CATEGORY_TYPES as $categoryType) {
            $callback('category_types', $categoryType);
        }

    }

}
