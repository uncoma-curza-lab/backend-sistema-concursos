<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%departaments}}`.
 */
class m211111_032021_create_departaments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%departaments}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%departaments}}');
    }
}
