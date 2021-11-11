<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%areas}}`.
 */
class m211111_032043_create_areas_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%areas}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%areas}}');
    }
}
