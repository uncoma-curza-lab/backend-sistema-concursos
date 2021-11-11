<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%orientation}}`.
 */
class m211111_032127_create_orientation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%orientation}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%orientation}}');
    }
}
