<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contestss}}`.
 */
class m211111_032205_create_contests_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contests}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'code' => $this->string(100)->notNull()->unique(),
            'qty' => $this->integer()->defaultValue(1),
            'init_date' => $this->dateTime(),
            'end_date' => $this->dateTime(),
            'enrollment_date_end' => $this->dateTime(),
            'description' => $this->text(),
            'remuneration_type_id' => $this->integer()->notNull(),
            'working_day_type_id' => $this->integer()->notNull(),
            'course_id' => $this->string()->notNull(),
            'category_type_id' => $this->integer()->notNull(),
            'area_id' => $this->integer()->notNull(),
            'orientation_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-contest-remuneration_type_id',
            'contests',
            'remuneration_type_id',
            'remuneration_types',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-contest-working_day_type_id',
            'contests',
            'working_day_type_id',
            'working_day_types',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-contest-category_type_id',
            'contests',
            'category_type_id',
            'category_types',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-contest-area_id',
            'contests',
            'area_id',
            'areas',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-contest-orientation_id',
            'contests',
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
        $this->dropTable('{{%contests}}');
    }
}
