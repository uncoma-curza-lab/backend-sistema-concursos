<?php

use yii\db\Migration;

/**
 * Class m230419_164654_add_institutional_proyect_activity_to_activity_enum
 */
class m230419_164654_add_institutional_proyect_activity_to_activity_enum extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        echo "Add INSTITUTIONAL_PROYECT to Activities";
        $addActivity = <<<SQL
            ALTER TYPE activities ADD VALUE 'INSTITUTIONAL_PROYECT';
        SQL;
        $this->execute($addActivity);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "Drop INSTITUTIONAL_PROYECT to Activities is not posible";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230419_164654_add_institutional_proyect_activity_to_activity_enum cannot be reverted.\n";

        return false;
    }
    */
}
