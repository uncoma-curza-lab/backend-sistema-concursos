<?php

use yii\db\Migration;

/**
 * Class m230314_203244_load_documents_types
 */
class m230314_203244_load_documents_types extends Migration
{
    const DOCUMENTS_TYPES = [
        'Nota',
        'Nomina de Inscriptos',
        'Dictamen',
        'Resolución Aprobatoria del Concurso y Comisión Evaluadora',
        'Resolución Aprobatoria del Concurso',
        'Resolución Aprobatoria del Jurado Docente',
        'Resolución Aprobatoria del Jurado Estudiantil',
        'Resolución Ad-Referendum',
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        echo "Loading Documents types...\n";
        foreach (self::DOCUMENTS_TYPES as $type) {
                $this->insert('{{%documents_types}}', [
                    'name' => $type,
                    'code' => \Yii::$app->slug->format($type, '-'),
                ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "Start delete rows from Document types.\n";
        foreach(self::DOCUMENTS_TYPES as $type) {
            $this->delete('{{%documents_types}}', [
                'code' => \Yii::$app->slug->format($type),
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
