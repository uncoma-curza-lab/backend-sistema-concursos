<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contest_attached_files}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%contests}}`
 * - `{{%documents_types}}`
 * - `{{%documents_responsibles}}`
 */
class m230310_175526_create_contest_attached_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contest_attached_files}}', [
            'id' => $this->primaryKey(),
            'contest_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'document_type_id' => $this->integer()->notNull(),
            'path' => $this->string(),
            'responsible_id' => $this->integer(),
            'published' => $this->boolean(),
        ]);

        // creates index for column `contest_id`
        $this->createIndex(
            '{{%idx-contest_attached_files-contest_id}}',
            '{{%contest_attached_files}}',
            'contest_id'
        );

        // add foreign key for table `{{%contests}}`
        $this->addForeignKey(
            '{{%fk-contest_attached_files-contest_id}}',
            '{{%contest_attached_files}}',
            'contest_id',
            '{{%contests}}',
            'id',
            'CASCADE'
        );

        // add foreign key for table `{{%documents_types}}`
        $this->addForeignKey(
            '{{%fk-contest_attached_files-document_type_id}}',
            '{{%contest_attached_files}}',
            'document_type_id',
            '{{%documents_types}}',
            'id',
            'CASCADE'
        );

        // add foreign key for table `{{%documents_responsibles}}`
        $this->addForeignKey(
            '{{%fk-contest_attached_files-responsible_id}}',
            '{{%contest_attached_files}}',
            'responsible_id',
            '{{%documents_responsibles}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%contests}}`
        $this->dropForeignKey(
            '{{%fk-contest_attached_files-contest_id}}',
            '{{%contest_attached_files}}'
        );

        // drops index for column `contest_id`
        $this->dropIndex(
            '{{%idx-contest_attached_files-contest_id}}',
            '{{%contest_attached_files}}'
        );

        // drops foreign key for table `{{%documents_types}}`
        $this->dropForeignKey(
            '{{%fk-contest_attached_files-document_type_id}}',
            '{{%contest_attached_files}}'
        );

        // drops foreign key for table `{{%documents_responsibles}}`
        $this->dropForeignKey(
            '{{%fk-contest_attached_files-responsible_id}}',
            '{{%contest_attached_files}}'
        );

        $this->dropTable('{{%contest_attached_files}}');
    }
}
