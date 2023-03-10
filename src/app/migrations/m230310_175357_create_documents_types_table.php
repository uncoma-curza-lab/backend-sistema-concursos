<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%documents_types}}`.
 */
class m230310_175357_create_documents_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%documents_types}}', [
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
        $this->dropTable('{{%documents_types}}');
    }
}
