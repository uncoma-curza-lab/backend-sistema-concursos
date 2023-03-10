<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%documents_responsibles}}`.
 */
class m230310_175507_create_documents_responsibles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%documents_responsibles}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'code' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%documents_responsibles}}');
    }
}
