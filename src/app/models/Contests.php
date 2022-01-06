<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contests".
 *
 * @property int $id
 * @property string|null $name
 * @property string $code
 * @property int|null $qty
 * @property string|null $init_date
 * @property string|null $end_date
 * @property string|null $enrollment_date_end
 * @property string|null $description
 * @property int $remuneration_type_id
 * @property int $working_day_type_id
 * @property string $course_id
 * @property int $category_type_id
 * @property int $area_id
 * @property int $orientation_id
 *
 * @property Areas $area
 * @property CategoryTypes $categoryType
 * @property Orientations $orientation
 * @property Postulations[] $postulations
 * @property RemunerationType $remunerationType
 * @property WorkingDayTypes $workingDayType
 */
class Contests extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contests';
    }
    
    public function behaviors() {
    	return [
        	'FormatDate' => [
            	'class' => 'app\behaviors\FormatDate',
            	'attributes' => ['init_date', 'end_date', 'enrollment_date_end'],
        	],
    	];
	}

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'remuneration_type_id', 'working_day_type_id', 'course_id', 'category_type_id', 'area_id', 'orientation_id'], 'required'],
            [['qty', 'remuneration_type_id', 'working_day_type_id', 'category_type_id', 'area_id', 'orientation_id'], 'default', 'value' => null],
            [['qty', 'remuneration_type_id', 'working_day_type_id', 'category_type_id', 'area_id', 'orientation_id'], 'integer'],
            [['init_date', 'end_date', 'enrollment_date_end'], 'safe'],
            [['description'], 'string'],
            [['name', 'course_id', 'departament_id', 'career_id'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 100],
            [['code'], 'unique'],
            [['area_id'], 'exist', 'skipOnError' => true, 'targetClass' => Areas::className(), 'targetAttribute' => ['area_id' => 'id']],
            [['category_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => CategoryTypes::className(), 'targetAttribute' => ['category_type_id' => 'id']],
            [['orientation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orientations::className(), 'targetAttribute' => ['orientation_id' => 'id']],
            [['remuneration_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => RemunerationType::className(), 'targetAttribute' => ['remuneration_type_id' => 'id']],
            [['working_day_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => WorkingDayTypes::className(), 'targetAttribute' => ['working_day_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('models/contest', 'name'),
            'code' => Yii::t('models/contest', 'code'),
            'qty' => Yii::t('models/contest', 'quantity'),
            'init_date' => Yii::t('models/contest', 'init_date'),
            'end_date' => Yii::t('models/contest', 'end_date'),
            'enrollment_date_end' => Yii::t('models/contest', 'enrollment_date_end'),
            'description' => Yii::t('models/contest', 'description'),
            'remuneration_type_id' => Yii::t('models/contest', 'remuneration_type'),
            'working_day_type_id' => Yii::t('models/contest', 'working_day_type'),
            'course_id' => Yii::t('models/contest', 'course'),
            'category_type_id' => Yii::t('models/contest', 'category_type'),
            'area_id' => Yii::t('models/contest', 'area'),
            'orientation_id' => Yii::t('models/contest', 'orientation'),
            'career_id' => Yii::t('models/contest', 'career'),
            'departament_id' => Yii::t('models/contest', 'departament'),
        ];
    }

    public function getCareer()
    {
        return Career::find($this->career_id);
    }

    public function getDepartament()
    {
        return Departament::find($this->departament_id);
    }

    public function getCourse()
    {
        return Course::find($this->course_id);
    }

    /**
     * Gets query for [[Area]].
     *
     * @return \yii\db\ActiveQuery|AreasQuery
     */
    public function getArea()
    {
        return $this->hasOne(Areas::className(), ['id' => 'area_id']);
    }

    /**
     * Gets query for [[CategoryType]].
     *
     * @return \yii\db\ActiveQuery|CategoryTypesQuery
     */
    public function getCategoryType()
    {
        return $this->hasOne(CategoryTypes::className(), ['id' => 'category_type_id']);
    }

    /**
     * Gets query for [[Orientation]].
     *
     * @return \yii\db\ActiveQuery|OrientationsQuery
     */
    public function getOrientation()
    {
        return $this->hasOne(Orientations::className(), ['id' => 'orientation_id']);
    }

    /**
     * Gets query for [[Postulations]].
     *
     * @return \yii\db\ActiveQuery|PostulationsQuery
     */
    public function getPostulations()
    {
        return $this->hasMany(Postulations::className(), ['contest_id' => 'id']);
    }

    /**
     * Gets query for [[RemunerationType]].
     *
     * @return \yii\db\ActiveQuery|RemunerationTypesQuery
     */
    public function getRemunerationType()
    {
        return $this->hasOne(RemunerationType::className(), ['id' => 'remuneration_type_id']);
    }

    /**
     * Gets query for [[WorkingDayType]].
     *
     * @return \yii\db\ActiveQuery|WorkingDayTypesQuery
     */
    public function getWorkingDayType()
    {
        return $this->hasOne(WorkingDayTypes::className(), ['id' => 'working_day_type_id']);
    }

    public function getContestJuriesRelationship()
    {
        return $this->hasOne(ContestJury::class, ['contest_id' => 'id']);

    }

    public function getJuries()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])->via('contestJuriesRelationship');
    }

    /**
     * {@inheritdoc}
     * @return ContestsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ContestsQuery(get_called_class());
    }
}
