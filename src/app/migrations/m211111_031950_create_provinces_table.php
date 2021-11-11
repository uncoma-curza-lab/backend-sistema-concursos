<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%provinces}}`.
 */
class m211111_031950_create_provinces_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%provinces}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'code' => $this->string(100)->notNull()->unique(),
            'country_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-province-country_id',
            'provinces',
            'country_id',
            'countries',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%provinces}}');
    }
}
