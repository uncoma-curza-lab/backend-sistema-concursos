<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%postulations}}`.
 */
class m211111_032217_create_postulations_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TYPE postulationStatuses AS ENUM ('draft', 'pending', 'accepted', 'rejected')");
        $this->createTable('{{%postulations}}', [
            'id' => $this->primaryKey(),
            'contest_id' => $this->integer()->notNull(),
            'person_id' => $this->integer()->notNull(),
            'status' => $this->getDb()->getSchema()->createColumnSchemaBuilder("postulationStatuses default 'draft' not null"),
            'accepted_term_article22' => $this->boolean()->defaultValue(false),
            'confirm_data' => $this->boolean()->defaultValue(false),
            'files' => $this->text(), // jsonb? .. multiples path
            'meet_date' => $this->dateTime(),
        ]);

        $this->addForeignKey(
            'fk-postulation-person_id',
            'postulations',
            'person_id',
            'persons',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-postulation-contest_id',
            'postulations',
            'contest_id',
            'contests',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%postulations}}');
        $this->execute('DROP TYPE postulationStatuses');
    }
}
