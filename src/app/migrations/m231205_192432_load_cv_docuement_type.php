<?php

use app\models\DocumentType;
use yii\db\Migration;

/**
 * Class m231205_192432_load_cv_docuement_type
 */
class m231205_192432_load_cv_docuement_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        echo "Loading Document type...\n";
        $this->insert('{{%documents_types}}', [
            'name' => "Curriculum Vitae",
            'code' => DocumentType::CV,
            'category' => DocumentType::PERSONAL_FILE_CATEGORY,
        ]);
        echo DocumentType::CV . " loaded\n";

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "Start delete rows from Document type.\n";
            $this->delete('{{%documents_types}}', [
                'code' => DocumentType::CV,
            ]);
            echo DocumentType::CV . " deleted\n";

        return true;
    }
}
