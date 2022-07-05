<?php

use yii\db\Migration;

/**
 * Class m220705_142130_alter_area_id_column_to_contest_table
 */
class m220705_142130_alter_area_id_column_to_contest_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%contests}}', 'area_id', $this->integer()->null()); 
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%contests}}', 'area_id', $this->integer()->notNull()); 
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220705_142130_alter_area_id_column_to_contest_table cannot be reverted.\n";

        return false;
    }
    */
}
