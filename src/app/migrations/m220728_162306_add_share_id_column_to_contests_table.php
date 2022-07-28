<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%contests}}`.
 */
class m220728_162306_add_share_id_column_to_contests_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%contests}}', 'share_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%contests}}', 'share_id');
    }
}
