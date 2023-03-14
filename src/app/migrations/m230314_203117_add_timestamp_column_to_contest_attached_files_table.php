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
        $this->addColumn('{{%contest_attached_files}}', 'timestamp', $this->dateTime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%contest_attached_files}}', 'timestamp');
    }
}
