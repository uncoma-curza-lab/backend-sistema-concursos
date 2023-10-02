<?php

use app\models\DocumentType;
use yii\db\Migration;

/**
 * Class m231002_194825_load_personal_files_documents_types
 */
class m231002_194825_load_personal_files_documents_types extends Migration
{
    const DOCUMENTS_TYPES = [
        DocumentType::DNI => ['name' => 'DNI', 'category' => DocumentType::PERSONAL_FILE_CATEGORY],
        DocumentType::CVAR => ['name' => 'CVar', 'category' => DocumentType::PERSONAL_FILE_CATEGORY],
        DocumentType::OTHER_PERSONAL => ['name' => 'Otro', 'category' => DocumentType::PERSONAL_FILE_CATEGORY],
        DocumentType::CERTIFICATES => ['name' => 'Certificaciones', 'category' => DocumentType::PERSONAL_FILE_CATEGORY],
        DocumentType::ACADEMIC_PERFORMANCE => ['name' => 'Rendimiento Académico', 'category' => DocumentType::PERSONAL_FILE_CATEGORY],
        DocumentType::UNIVERSITY_DEGREE => ['name' => 'Título Universitario', 'category' => DocumentType::PERSONAL_FILE_CATEGORY],
        DocumentType::COLLEGE_DEGREE => ['name' => 'Título Terciario', 'category' => DocumentType::PERSONAL_FILE_CATEGORY],
        DocumentType::NOTE_POSTULATION => ['name' => 'Nota', 'category' => DocumentType::POSTULATION_FILE_CATEGORY],
        DocumentType::PRACTICAL_WORK_PROPOSAL => ['name' => 'Propuesta de Trabajo Práctico', 'category' => DocumentType::POSTULATION_FILE_CATEGORY],
        DocumentType::PROGRAM_PROPOSAL => ['name' => 'Propuesta de Programa', 'category' => DocumentType::POSTULATION_FILE_CATEGORY],
        DocumentType::REGULAR_INSCRIPTION => ['name' => 'Inscripción', 'category' => DocumentType::POSTULATION_FILE_CATEGORY],
        DocumentType::OTHER_POSTULATION => ['name' => 'Otro', 'category' => DocumentType::POSTULATION_FILE_CATEGORY],
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        echo "Loading Documents types...\n";
        foreach (self::DOCUMENTS_TYPES as $code => $type) {
            $this->insert('{{%documents_types}}', [
                'name' => $type['name'],
                'code' => $code,
                'category' => $type['category'],
            ]);
            echo "$code loaded\n";
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "Start delete rows from Document types.\n";
        foreach(self::DOCUMENTS_TYPES as $code => $type) {
            $this->delete('{{%documents_types}}', [
                'code' => $code,
            ]);
            echo "$code deleted\n";
        }

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231002_194825_load_personal_files_documents_types cannot be reverted.\n";

        return false;
    }
    */
}
