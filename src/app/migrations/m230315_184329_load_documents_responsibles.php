<?php

use yii\db\Migration;

/**
 * Class m230315_184329_add_load_documents_responsibles
 */
class m230315_184329_load_documents_responsibles extends Migration
{
    const DOCUMENTS_RESPONSIBLES = [
        'evaluation-commission' => 'Comisión Evaluadora',
        'teacher-department' => 'Departamento Docente',
        'board' => 'Consejo Directivo',
        'daenery' => 'Decanato',
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        echo "Loading Documents Responsibles...\n";
        foreach (self::DOCUMENTS_RESPONSIBLES as $key => $type) {
                $this->insert('{{%documents_responsibles}}', [
                    'name' => $type,
                    'code' => $key,
                ]);
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "Start delete rows from Document types.\n";
        foreach(self::DOCUMENTS_RESPONSIBLES as $key => $type) {
            $this->delete('{{%documents_responsibles}}', [
                'code' => $key,
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
        echo "m230315_184329_add_load_documents_responsibles cannot be reverted.\n";

        return false;
    }
    */
}
