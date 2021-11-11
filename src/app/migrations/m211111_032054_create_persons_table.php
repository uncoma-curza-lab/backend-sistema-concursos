<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%persons}}`.
 */
class m211111_032054_create_persons_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%persons}}', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string()->notNull(),
            'last_name' => $this->string(), //nullable
            'uid' => $this->string(),
            'dni' => $this->string(),
            'contact_email' => $this->string(),
            'cellphone' => $this->string(),
            'phone' => $this->string(),
            'real_address' => $this->string(),
            'legal_address' => $this->string(),
            'citizenship' => $this->string(),
            'date_of_birth' => $this->date(),
            'place_of_birth' => $this->integer(),
            'user_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-person-place_of_birth',
            'persons',
            'place_of_birth',
            'cities',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-person-user_id',
            'persons',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%persons}}');
    }
}
