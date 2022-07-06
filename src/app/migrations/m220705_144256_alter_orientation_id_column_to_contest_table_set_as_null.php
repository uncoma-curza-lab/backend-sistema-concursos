<?php

use yii\db\Migration;

/**
 * Class m220705_144256_alter_orientation_id_column_to_contest_table_set_as_null
 */
class m220705_144256_alter_orientation_id_column_to_contest_table_set_as_null extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%contests}}', 'orientation_id', $this->integer()->null()); 
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%contests}}', 'orientation_id', $this->integer()->notNull()); 
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220705_144256_alter_orientation_id_column_to_contest_table_set_as_null cannot be reverted.\n";

        return false;
    }
    */
}
