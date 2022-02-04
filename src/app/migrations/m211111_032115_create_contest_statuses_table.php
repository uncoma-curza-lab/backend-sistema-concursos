<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contestss}}`.
 */
class m211111_032115_create_contest_statuses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contest_statuses}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'code' => $this->string(100)->notNull()->unique(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%contest_statuses}}');
    }
}
