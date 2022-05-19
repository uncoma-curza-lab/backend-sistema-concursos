<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%postulations}}`.
 */
class m220519_003351_add_shareid_column_to_postulations_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%postulations}}', 'share_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%postulations}}', 'share_id');
    }
}
