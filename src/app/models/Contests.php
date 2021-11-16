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
 * @property RemunerationTypes $remunerationType
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
            [['name', 'course_id'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 100],
            [['code'], 'unique'],
            [['area_id'], 'exist', 'skipOnError' => true, 'targetClass' => Areas::className(), 'targetAttribute' => ['area_id' => 'id']],
            [['category_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => CategoryTypes::className(), 'targetAttribute' => ['category_type_id' => 'id']],
            [['orientation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orientations::className(), 'targetAttribute' => ['orientation_id' => 'id']],
            [['remuneration_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => RemunerationTypes::className(), 'targetAttribute' => ['remuneration_type_id' => 'id']],
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
            'name' => 'Name',
            'code' => 'Code',
            'qty' => 'Qty',
            'init_date' => 'Init Date',
            'end_date' => 'End Date',
            'enrollment_date_end' => 'Enrollment Date End',
            'description' => 'Description',
            'remuneration_type_id' => 'Remuneration Type ID',
            'working_day_type_id' => 'Working Day Type ID',
            'course_id' => 'Course ID',
            'category_type_id' => 'Category Type ID',
            'area_id' => 'Area ID',
            'orientation_id' => 'Orientation ID',
        ];
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
        return $this->hasOne(RemunerationTypes::className(), ['id' => 'remuneration_type_id']);
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

    /**
     * {@inheritdoc}
     * @return ContestsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ContestsQuery(get_called_class());
    }
}
