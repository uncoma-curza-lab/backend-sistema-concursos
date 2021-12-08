<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_groups}}`.
 */
class m211208_231959_create_user_groups_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_groups}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'group_id' => $this->integer()->notNull(),
            // TODO: unique group,user?
        ]);

        $this->addForeignKey(
            'fk-user_groups-user_id',
            'user_groups',
            'user_id',
            'users',
            'id',
            'NO ACTION',
            'NO ACTION',
        );

        $this->addForeignKey(
            'fk-user_groups-group_id',
            'user_groups',
            'group_id',
            'groups',
            'id',
            'NO ACTION',
            'NO ACTION',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_groups}}');
    }
}
