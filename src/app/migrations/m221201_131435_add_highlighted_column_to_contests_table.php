<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%contests}}`.
 */
class m221201_131435_add_highlighted_column_to_contests_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%contests}}', 'highlighted', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%contests}}', 'highlighted');
    }
}
