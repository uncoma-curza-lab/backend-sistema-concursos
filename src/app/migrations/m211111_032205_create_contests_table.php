<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contestss}}`.
 */
class m211111_032205_create_contests_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contests}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%contests}}');
    }
}
