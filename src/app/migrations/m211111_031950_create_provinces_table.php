<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%provinces}}`.
 */
class m211111_031950_create_provinces_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%provinces}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%provinces}}');
    }
}
