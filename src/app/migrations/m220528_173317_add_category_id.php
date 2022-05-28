<?php

use yii\db\Migration;

/**
 * Class m220528_173317_add_category_id
 */
class m220528_173317_add_category_id extends Migration
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
        echo "m220528_173317_add_category_id cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220528_173317_add_category_id cannot be reverted.\n";

        return false;
    }
    */
}
