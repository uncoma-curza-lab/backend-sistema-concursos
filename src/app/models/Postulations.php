<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "postulations".
 *
 * @property int $id
 * @property int $contest_id
 * @property int $person_id
 * @property string|null $files
 * @property string|null $meet_date
 *
 * @property Contests $contest
 * @property Persons $person
 */
class Postulations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'postulations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contest_id', 'person_id'], 'required'],
            [['contest_id', 'person_id'], 'default', 'value' => null],
            [['contest_id', 'person_id'], 'integer'],
            [['files'], 'string'],
            [['meet_date'], 'safe'],
            [['contest_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contests::className(), 'targetAttribute' => ['contest_id' => 'id']],
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => Persons::className(), 'targetAttribute' => ['person_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'contest_id' => 'Contest ID',
            'person_id' => 'Person ID',
            'files' => 'Files',
            'meet_date' => 'Meet Date',
        ];
    }

    /**
     * Gets query for [[Contest]].
     *
     * @return \yii\db\ActiveQuery|ContestsQuery
     */
    public function getContest()
    {
        return $this->hasOne(Contests::className(), ['id' => 'contest_id']);
    }

    /**
     * Gets query for [[Person]].
     *
     * @return \yii\db\ActiveQuery|PersonsQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Persons::className(), ['id' => 'person_id']);
    }

    /**
     * {@inheritdoc}
     * @return PostulationsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PostulationsQuery(get_called_class());
    }
}