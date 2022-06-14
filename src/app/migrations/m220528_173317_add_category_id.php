<?php

use yii\db\Migration;

/**
 * Class m220528_173317_add_category_id
 */
class m220528_173317_add_category_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%contests}}', 'category_id', $this->integer()->unsigned());
        $this->addForeignKey(
            'fk-contest-category_id',
            'contests',
            'category_id',
            'categories',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-contest-category_id', '{{%contests}}');
        $this->dropColumn('{{%contests}}', 'category_id');
    }

}
