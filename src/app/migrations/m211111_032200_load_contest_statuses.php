<?php

use yii\db\Migration;

class m211111_032200_load_contest_statuses extends Migration
{
    const CONTEST_STATUSES = [
        1 => 'draft',
        2 => 'published',
        3 => 'in_process',
        4 => 'finished',
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        echo "Loading statuses contest ...\n";

        $this->executeFunction(function($table, $key, $status) {
            $this->insert($table, [
                'id' => $key,
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
        $this->executeFunction(function($table, $key, $status) {
            $this->delete($table, [
                'id' => $key,
            ]);
        });
        return true;
    }

    private function executeFunction(callable $callback)
    {
        foreach (self::CONTEST_STATUSES as $key => $status) {
            $callback('contest_statuses', $key, $status);
        }

    }

}
