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
            // no requiere ni usuario ni contraseña para crear usuario??
            'timestamp'=> $this->timestamp() ,
            // La marca de tirmpo no genera el dato automaticamente ??
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
