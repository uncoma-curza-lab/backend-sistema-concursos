<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%notifications}}`.
 */
class m221013_145845_add_url_column_to_notifications_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%notifications}}', 'url', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%notifications}}', 'url');
    }
}
