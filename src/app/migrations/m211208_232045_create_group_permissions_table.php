<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%group_permissions}}`.
 */
class m211208_232045_create_group_permissions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%group_permissions}}', [
            'id' => $this->primaryKey(),
            'permission_id' => $this->integer()->notNull(),
            'group_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-group_permissions-permission_id',
            'group_permissions',
            'permission_id',
            'permissions',
            'id',
            'NO ACTION',
            'NO ACTION',
        );

        $this->addForeignKey(
            'fk-group_permissions-group_id',
            'group_permissions',
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
        $this->dropTable('{{%group_permissions}}');
    }
}
