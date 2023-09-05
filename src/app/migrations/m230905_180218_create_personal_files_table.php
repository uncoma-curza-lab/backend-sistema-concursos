<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%personal_files}}`.
 */
class m230905_180218_create_personal_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%personal_files}}', [
            'id' => $this->primaryKey(),
            'person_id' => $this->integer(),
            'postulation_id' => $this->integer(),
            'document_type_code' => $this->string()->notNull(),
            'path' => $this->string()->notNull(),
            'is_valid' => $this->smallInteger(1),
            'valid_until' => $this->dateTime(),
            'created_at' => $this->dateTime(),
            'validated_at' => $this->dateTime(),
        ]);

        $this->addForeignKey(
            'fk-personal_files-document_type_code',
            '{{%personal_files}}',
            'document_type_code',
            '{{%documents_types}}',
            'code',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-personal_files-person_id',
            '{{%personal_files}}',
            'person_id',
            '{{%persons}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-personal_files-postulation_id',
            '{{%personal_files}}',
            'postulation_id',
            '{{%postulations}}',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-personal_files-document_type_code',
            '{{%personal_files}}'
        );

        $this->dropForeignKey(
            'fk-personal_files-postulation_id',
            '{{%personal_files}}'
        );

        $this->dropForeignKey(
            'fk-personal_files-person_id',
            '{{%personal_files}}'
        );

        $this->dropTable('{{%personal_files}}');
    }
}
