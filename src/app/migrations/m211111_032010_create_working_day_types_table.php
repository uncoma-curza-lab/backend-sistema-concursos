<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%working_day_types}}`.
 */
class m211111_032010_create_working_day_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%working_day_types}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'code' => $this->string()->notNull()->unique(),
            // TODO timestamps
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%working_day_types}}');
    }
}
