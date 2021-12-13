<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contest_juries}}`.
 */
class m211213_213909_create_contest_juries_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contest_juries}}', [
            'id' => $this->primaryKey(),
            'contest_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'is_president' => $this->boolean()->defaultValue(false),
        ]);

        $this->addForeignKey(
            'fk-contest_juries-contest_id',
            'contest_juries',
            'contest_id',
            'contests',
            'id',
            'NO ACTION'
        );

        $this->addForeignKey(
            'fk-contest_juries-user_id',
            'contest_juries',
            'user_id',
            'users',
            'id',
            'NO ACTION'
        );

        $this->createIndex(
            'idx-unique-jury-user',
            'contest_juries',
            'contest_id, user_id',
            true 
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%contest_juries}}');
    }
}
