<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%contest_attached_files}}`.
 */
class m230314_203117_add_timestamp_column_to_contest_attached_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%contest_attached_files}}', 'created_at', $this->dateTime());
        $this->addColumn('{{%contest_attached_files}}', 'published_at', $this->dateTime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%contest_attached_files}}', 'created_at');
        $this->dropColumn('{{%contest_attached_files}}', 'published_at');
    }
}
