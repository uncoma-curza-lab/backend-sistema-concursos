<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%remuneration}}`.
 */
class m211111_032142_create_remuneration_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%remuneration_types}}', [
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
        $this->dropTable('{{%remuneration_types}}');
    }
}
