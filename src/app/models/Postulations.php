<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

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

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ]
        ];
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
            [['status'], 'string'],
            [['files'], 'string'],
            [['created_at', 'updated_at'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
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
            'created_at' => 'Fecha de registro',
            'updated_at' => 'Fecha de actualización',
            'status' => 'Estado',
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

    public function canApprove()
    {
        return ($this->status === PostulationStatus::DRAFT
            || $this->status === PostulationStatus::PENDING);
        //TODO check user permission
    }

    public function canReject()
    {
        return ($this->status === PostulationStatus::DRAFT
            || $this->status === PostulationStatus::PENDING);
        //TODO check user permission
    }

    public function getStatusDescription()
    {
        //TODO translations
        return PostulationStatus::getTranslation($this->status);
    }


}
