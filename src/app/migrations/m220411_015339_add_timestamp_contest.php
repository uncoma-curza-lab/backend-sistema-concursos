<?php

use yii\db\Migration;

/**
 * Class m220411_015339_add_timestamp_contest
 */
class m220411_015339_add_timestamp_contest extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        echo "add timestamps.\n";
        $this->addColumn('{{%contests}}', 'created_at', $this->dateTime());
        $this->addColumn('{{%contests}}', 'updated_at', $this->dateTime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%contests}}', 'created_at');
        $this->dropColumn('{{%contests}}', 'updated_at');
    }
}
