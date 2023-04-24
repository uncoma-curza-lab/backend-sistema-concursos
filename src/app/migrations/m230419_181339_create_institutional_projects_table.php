<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%institutional_projects}}`.
 */
class m230419_181339_create_institutional_projects_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%institutional_projects}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'code' => $this->string()->unique(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%institutional_projects}}');
    }
}
