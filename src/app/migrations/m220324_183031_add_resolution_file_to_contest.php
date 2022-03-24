<?php

use yii\db\Migration;

/**
 * Class m220324_183031_add_resolution_file_to_contest
 */
class m220324_183031_add_resolution_file_to_contest extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        echo "m220324_183031_add_resolution_file_to_contest add column.\n";
        $this->addColumn('{{%contest}}', 'resolution_file_path', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220324_183031_add_resolution_file_to_contest start revert.\n";
        $this->dropColumn('{{%contest}}', 'resolution_file_path');

        return true;
    }

}
