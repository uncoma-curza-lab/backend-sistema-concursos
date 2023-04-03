<?php

use yii\db\Migration;

/**
 * Class m230314_203244_load_documents_types
 */
class m230314_203244_load_documents_types extends Migration
{
    const DOCUMENTS_TYPES = [
        'note' => 'Nota',
        'inscribed-postulations' => 'Nomina de Inscritos',
        'veredict' => 'Dictamen',
        'approval-resolution-contest-evaluation-commission' => 'Resolución Aprobatoria del Concurso y Comisión Evaluadora',
        'approval-resolution-contest' => 'Resolución Aprobatoria del Concurso',
        'approval-resolution-teaching-jury' => 'Resolución Aprobatoria del Jurado Docente',
        'approval-resolution-student-jury' => 'Resolución Aprobatoria del Jurado Estudiantil',
        'ad-referendum-resolution' => 'Resolución Ad-Referendum',    
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        echo "Loading Documents types...\n";
        foreach (self::DOCUMENTS_TYPES as $code => $type) {
                $this->insert('{{%documents_types}}', [
                    'name' => $type,
                    'code' => $code,
                ]);
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
        echo "m230314_203244_load_documents_types cannot be reverted.\n";

        return false;
    }
    */
}
