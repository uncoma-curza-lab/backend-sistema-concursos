<?php

namespace app\models;

use app\events\UploadResolutionEvent;
use app\helpers\Sluggable;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

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
class ContestsUploadResolutionForm extends Model
{
    public $resolution_file_path;
    public $slug;

    public function __construct($slug)
    {
        parent::__construct();
        $model = Contests::find()->findBySlug($slug);
        if (!$model) {
            throw new \Exception();
        }
        $this->resolution_file_path = $model->resolution_file_path;
        $this->slug = $slug;

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
            [['resolution_file_path'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf'],
            [['resolution_file_path'], 'required'],
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
            'resolution_file_path' => Yii::t('models/contest', 'resolution_file_path'),
            'remuneration_type_id' => Yii::t('models/contest', 'remuneration_type'),
            'working_day_type_id' => Yii::t('models/contest', 'working_day_type'),
            'course_id' => Yii::t('models/contest', 'course'),
            'category_type_id' => Yii::t('models/contest', 'category_type'),
            'area_id' => Yii::t('models/contest', 'area'),
            'orientation_id' => Yii::t('models/contest', 'orientation'),
            'career_id' => Yii::t('models/contest', 'career'),
            'departament_id' => Yii::t('models/contest', 'departament'),
            'evaluation_departament_id' => Yii::t('models/contest', 'evaluation_departament'),
            'contest_status_id' => Yii::t('models/contest', 'contest_status'),
        ];
    }

    public function upload()
    {
        if ($this->validate()) { 
            $name = 'resolutions/'
                . Yii::$app->slug->format($this->resolution_file_path->baseName . ' ' . date('Y-m-d H:i:s'))
                . '.'
                . $this->resolution_file_path->extension;
            $this->resolution_file_path->saveAs($name);
            $model = $this->findModel($this->slug);
            $model->resolution_file_path = $name;
            if (!$model->save()) {
                return false;
            }

            $this->trigger('notify', new UploadResolutionEvent($model));
            return true;

        } else {
            return false;
        }
    }

    protected function findModel($slug)
    {
        if (($model = Contests::find()->findBySlug($slug)) !== null) {
            return $model;
        }

        return null;
    }
}
