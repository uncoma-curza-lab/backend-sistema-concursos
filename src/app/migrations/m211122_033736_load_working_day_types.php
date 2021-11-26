<?php

use yii\db\Migration;

/**
 * Class m211122_033736_load_working_day_types
 */
class m211122_033736_load_working_day_types extends Migration
{
    const WORKING_DAY_TYPES =[
        'Parcial',
        'Exclusiva',
        'Simple',
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        echo "Loading working day types...\n";
        $this->executeFunction(function($table, $workingDayType) {
            $this->insert($table, [
                'name' => $workingDayType,
                'code' => \Yii::$app->slug->format($workingDayType, '-'),
            ]);
        });

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "Start delete rows from working day types.\n";
        $this->executeFunction(function($table, $workingDayType) {
            $this->delete($table, [
                'code' => \Yii::$app->slug->format($workingDayType),
            ]);
        });
        return true;
    }

    private function executeFunction(callable $callback) : void
    {
        foreach (self::WORKING_DAY_TYPES as $workingDayType) {
            $callback('working_day_types', $workingDayType);
        }

    }
}
