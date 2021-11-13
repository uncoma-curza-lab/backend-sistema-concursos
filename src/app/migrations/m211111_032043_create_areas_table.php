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
            'name' => $this->string(),
            'code' => $this->string()->notNull()->unique(),
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
