<?php

use yii\db\Migration;

class m211111_032232_create_area_orientations_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%area_orientations}}', [
            'id' => $this->primaryKey(),
            'area_id' => $this->integer()->notNull(),
            'orientation_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-area_orientations-area_id',
            'area_orientations',
            'area_id',
            'areas',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-area_orientations-orientation_id',
            'area_orientations',
            'orientation_id',
            'orientations',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%qualifications}}');
    }
}
