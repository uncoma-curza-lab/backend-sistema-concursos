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

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220411_015339_add_timestamp_contest cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220411_015339_add_timestamp_contest cannot be reverted.\n";

        return false;
    }
    */
}
