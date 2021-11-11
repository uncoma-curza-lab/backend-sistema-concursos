<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%orientations}}`.
 */
class m211111_032127_create_orientations_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%orientations}}', [
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
        $this->dropTable('{{%orientations}}');
    }
}
