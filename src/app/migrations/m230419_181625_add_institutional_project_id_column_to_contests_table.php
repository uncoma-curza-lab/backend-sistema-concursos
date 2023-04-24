<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%contests}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%institutional_projects}}`
 */
class m230419_181625_add_institutional_project_id_column_to_contests_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%contests}}', 'institutional_project_id', $this->integer());

        // add foreign key for table `{{%institutional_projects}}`
        $this->addForeignKey(
            '{{%fk-contests-institutional_project_id}}',
            '{{%contests}}',
            'institutional_project_id',
            '{{%institutional_projects}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%institutional_projects}}`
        $this->dropForeignKey(
            '{{%fk-contests-institutional_project_id}}',
            '{{%contests}}'
        );

        $this->dropColumn('{{%contests}}', 'institutional_project_id');
    }
}
