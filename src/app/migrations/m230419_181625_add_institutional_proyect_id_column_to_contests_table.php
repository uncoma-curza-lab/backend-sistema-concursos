<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%contests}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%institutional_proyects}}`
 */
class m230419_181625_add_institutional_proyect_id_column_to_contests_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%contests}}', 'institutional_proyect_id', $this->integer());

        // add foreign key for table `{{%institutional_proyects}}`
        $this->addForeignKey(
            '{{%fk-contests-institutional_proyect_id}}',
            '{{%contests}}',
            'institutional_proyect_id',
            '{{%institutional_proyects}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%institutional_proyects}}`
        $this->dropForeignKey(
            '{{%fk-contests-institutional_proyect_id}}',
            '{{%contests}}'
        );

        $this->dropColumn('{{%contests}}', 'institutional_proyect_id');
    }
}
