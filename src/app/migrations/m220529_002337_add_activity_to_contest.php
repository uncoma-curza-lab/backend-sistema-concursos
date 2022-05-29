<?php

use yii\db\Migration;

/**
 * Class m220529_002337_add_activity_to_contest
 */
class m220529_002337_add_activity_to_contest extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $createType = <<<SQL
            CREATE TYPE activities AS ENUM ('TEACHER', 'DEPARTMENT_ASSISTANT');
        SQL;
        $createField = <<<SQL
            ALTER TABLE contests ADD activity activities DEFAULT 'TEACHER';
        SQL;
        $this->execute($createType);
        $this->execute($createField);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $deleteField = <<<SQL
            ALTER TABLE contests DROP activity;
        SQL;
        $deleteType = <<<SQL
            DROP TYPE activities;
        SQL;
        $this->execute($deleteField);
        $this->execute($deleteType);
    }

}
