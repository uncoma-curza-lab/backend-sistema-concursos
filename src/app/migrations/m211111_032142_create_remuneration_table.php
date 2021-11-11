<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%remuneration}}`.
 */
class m211111_032142_create_remuneration_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%remuneration}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%remuneration}}');
    }
}
