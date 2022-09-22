<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%notifications}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m220922_151750_create_notifications_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%notifications}}', [
            'id' => $this->primaryKey(),
            'user_to' => $this->integer()->notNull(),
            'message' => $this->text(),
            'read' => $this->boolean()->defaultValue(false),
            'timestamp' => $this->datetime(),
        ]);

        // creates index for column `user_to`
        $this->createIndex(
            '{{%idx-notifications-user_to}}',
            '{{%notifications}}',
            'user_to'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-notifications-user_to}}',
            '{{%notifications}}',
            'user_to',
            '{{%users}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-notifications-user_to}}',
            '{{%notifications}}'
        );

        // drops index for column `user_to`
        $this->dropIndex(
            '{{%idx-notifications-user_to}}',
            '{{%notifications}}'
        );

        $this->dropTable('{{%notifications}}');
    }
}
