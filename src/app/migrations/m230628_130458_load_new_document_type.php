<?php

use yii\db\Migration;

/**
 * Class m230628_130458_load_new_document_type
 */
class m230628_130458_load_new_document_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        echo "Loading Draw Record Document type...\n";
        $this->insert('{{%documents_types}}', [
            'name' => 'Acta Sorteo del Tema',
            'code' => 'draw-record',
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "Deleting Draw Record Document type...\n";
        $this->delete('{{%documents_types}}', [
            'code' => 'draw-record',
        ]);

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230628_130458_load_new_document_type cannot be reverted.\n";

        return false;
    }
    */
}
