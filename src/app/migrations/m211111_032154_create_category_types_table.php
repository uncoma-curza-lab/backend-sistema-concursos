<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category_types}}`.
 */
class m211111_032154_create_category_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%category_types}}', [
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
        $this->dropTable('{{%category_types}}');
    }
}
