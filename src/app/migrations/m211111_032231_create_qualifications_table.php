<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%qualifications}}`.
 */
class m211111_032231_create_qualifications_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%qualifications}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%qualifications}}');
    }
}
