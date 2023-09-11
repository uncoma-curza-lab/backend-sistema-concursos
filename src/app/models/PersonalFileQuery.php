<?php

namespace app\models;

use Yii;

/**
 * This is the ActiveQuery class for [[PersonalFile]].
 *
 * @see PersonalFile
 */
class PersonalFileQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PersonalFile[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PersonalFile|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function loggedUser()
    {
        return $this->where(['=', 'person_id', Yii::$app->user->identity->person->id]);
    }
}