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
            'name' => $this->string(),
            'code' => $this->string(100)->notNull()->unique(),
            'custom_institution' => $this->string(),
            'custom_grade_type' => $this->string(),
            'description' => $this->string(),
            'file_path' => $this->string(), // path to file attach
            'person_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-qualification-person_id',
            'qualifications',
            'person_id',
            'persons',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%qualifications}}');
    }
}
