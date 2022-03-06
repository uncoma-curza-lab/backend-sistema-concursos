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
            'last_name' => $this->string()->notNull(), //nullable
            'uid' => $this->string(), // cuil? nullable?
            'dni' => $this->string(),
            'contact_email' => $this->string(),
            'cellphone' => $this->string(),
            'phone' => $this->string(),
            'real_address_city_id' => $this->integer(),
            'real_address_street' => $this->string(),
            'real_address_number' => $this->string(),
            'legal_address_city_id' => $this->integer(),
            'legal_address_street' => $this->string(),
            'legal_address_number' => $this->string(),
            'citizenship' => $this->string(),
            'date_of_birth' => $this->date(),
            'place_of_birth' => $this->integer(),
            'user_id' => $this->integer()->notNull(),
            'validate_date' => $this->dateTime(),
            'is_valid' => $this->boolean()->defaultValue(false),
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

        $this->addForeignKey(
            'fk-person-real_address_city_id',
            'persons',
            'real_address_city_id',
            'cities',
            'id',
        );

        $this->addForeignKey(
            'fk-person-legal_address_city_id',
            'persons',
            'legal_address_city_id',
            'cities',
            'id',
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
