<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%documents_types}}`.
 */
class m230905_213014_add_category_column_to_documents_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%documents_types}}',
            'category',
            $this->string()
        );

        echo "Udating existings rows...\n";
        $this->update(
            '{{%documents_types}}',
            [
                'category' => 'contest-file'
            ],
            'category IS NULL'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(
            '{{%documents_types}}',
            'category'
        );
    }
}
