<?php

use yii\db\Migration;

/**
 * Class m211122_033322_load_remuneration_types
 */
class m211122_033322_load_remuneration_types extends Migration
{
    const REMUNERATION_TYPES =[
        'Ad-honorem',
        'Rentado',
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        echo "Loading remuneration types...\n";
        $this->executeFunction(function($table, $remunerationType) {
            $this->insert($table, [
                'name' => $remunerationType,
                'code' => \Yii::$app->slug->format($remunerationType, '-'),
            ]);
        });

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "Start delete rows from remuneration types.\n";
        $this->executeFunction(function($table, $remunerationType) {
            $this->delete($table, [
                'code' => \Yii::$app->slug->format($remunerationType),
            ]);
        });
        return true;
    }

    private function executeFunction(callable $callback) : void
    {
        foreach (self::REMUNERATION_TYPES as $remType) {
            $callback('remuneration_types', $remType);
        }

    }
}
