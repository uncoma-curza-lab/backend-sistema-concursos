<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%institutional_proyects}}`.
 */
class m230419_181339_create_institutional_proyects_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%institutional_proyects}}', [
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
        $this->dropTable('{{%institutional_proyects}}');
    }
}
