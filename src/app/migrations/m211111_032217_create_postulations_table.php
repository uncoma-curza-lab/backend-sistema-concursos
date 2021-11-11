<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%postulations}}`.
 */
class m211111_032217_create_postulations_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%postulations}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%postulations}}');
    }
}
