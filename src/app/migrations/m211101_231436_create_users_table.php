<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m211101_231436_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'uid' => $this->string()->unique(),
            'password' => $this->string(),
            'timestamp'=> $this->timestamp() ,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
