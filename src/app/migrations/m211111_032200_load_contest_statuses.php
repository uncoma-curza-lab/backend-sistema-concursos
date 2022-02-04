<?php

use yii\db\Migration;

class m211111_032200_load_contest_statuses extends Migration
{
    const CONTEST_STATUSES = [
        'draft',
        'published',
        'in_process',
        'dictum',
        'finished',
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        echo "Loading statuses contest ...\n";

        $this->executeFunction(function($table, $status) {
            $this->insert($table, [
                'name' => $status,
                'code' => \Yii::$app->slug->format($status, '-'),
            ]);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "Start delete rows from statuses for contest.\n";
        $this->executeFunction(function($table, $status) {
            $this->delete($table, [
                'code' => \Yii::$app->slug->format($status),
            ]);
        });
        return true;
    }

    private function executeFunction(callable $callback)
    {
        foreach (self::CONTEST_STATUSES as $status) {
            $callback('contest_statuses', $status);
        }

    }

}
