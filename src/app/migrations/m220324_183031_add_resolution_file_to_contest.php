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
        $this->addColumn('{{%contests}}', 'resolution_file_path', $this->string());
        $this->addColumn('{{%contests}}', 'publish_resolution', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220324_183031_add_resolution_file_to_contest start revert.\n";
        $this->dropColumn('{{%contests}}', 'resolution_file_path');
        $this->dropColumn('{{%contests}}', 'publish_resolution');

        return true;
    }

}
