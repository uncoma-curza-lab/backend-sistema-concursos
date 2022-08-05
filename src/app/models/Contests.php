<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use app\services\NextcloudService;
use DateTime;

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
 * @property int $share_id
 *
 * @property Areas $area
 * @property CategoryTypes $categoryType
 * @property Orientations $orientation
 * @property Postulations[] $postulations
 * @property RemunerationType $remunerationType
 * @property WorkingDayTypes $workingDayType
 */
class Contests extends ActiveRecord
{
    const SCENARIO_REGULAR = 'regular';
    const SCENARIO_ASSISTANT_DEPARTMENT = 'assistant_department';
    const SCENARIO_OTHERS = 'others';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contests';
    }
    
    public function behaviors() {
        return [
              [
                  'class' => TimestampBehavior::class,
                  'attributes' => [
                      ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                      ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                  ],
              ],
            'FormatDate' => [
                'class' => 'app\behaviors\FormatDate',
                  'attributes' => [
                      'created_at', 'updated_at',
                      'init_date', 'end_date', 'enrollment_date_end'
                  ],
              ],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_ASSISTANT_DEPARTMENT] = ['remuneration_type_id', 'working_day_type_id', 'category_type_id'];
        $scenarios[self::SCENARIO_REGULAR] = ['remuneration_type_id', 'working_day_type_id', 'category_type_id', 'area_id', 'orientation_id'];
        $scenarios[self::SCENARIO_OTHERS] = ['remuneration_type_id', 'working_day_type_id', 'category_type_id', 'area_id', 'orientation_id', 'course_id'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'remuneration_type_id', 'working_day_type_id', 'category_id', 'category_type_id', 'evaluation_departament_id'], 'required'],
            [['remuneration_type_id', 'working_day_type_id', 'category_type_id'], 'required', 'on' => self::SCENARIO_ASSISTANT_DEPARTMENT],
            [['remuneration_type_id', 'working_day_type_id', 'category_type_id', 'area_id', 'orientation_id'], 'required', 'on' => self::SCENARIO_REGULAR],
            [['remuneration_type_id', 'working_day_type_id', 'category_type_id', 'area_id', 'orientation_id', 'course_id'], 'required', 'on' => self::SCENARIO_OTHERS],
            [['qty', 'remuneration_type_id', 'working_day_type_id', 'category_type_id', 'area_id', 'category_id', 'orientation_id'], 'default', 'value' => null],
            [['qty', 'remuneration_type_id', 'working_day_type_id', 'category_type_id', 'category_id', 'area_id', 'orientation_id'], 'integer'],
            [['qty'], 'compare', 'compareValue' => 0, 'operator' => '>'],
            [['init_date', 'end_date', 'enrollment_date_end'], 'validateDates'],
            [[ 'created_at', 'updated_at', 'init_date', 'end_date', 'enrollment_date_end', 'course_id', 'share_id'], 'safe'],
            [['activity', 'description', 'resolution_file_path'], 'string'],
            [['resolution_published'], 'boolean'],
            [['name', 'course_id', 'departament_id', 'evaluation_departament_id', 'career_id'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 100],
            [['activity'], 'in', 'range' => [
              Activity::DEPARTMENT_ASSISTANT_CODE, 
              Activity::TEACHER_CODE, 
            ]],
            [['code'], 'unique'],
            [['area_id'], 'exist', 'skipOnError' => true, 'targetClass' => Areas::className(), 'targetAttribute' => ['area_id' => 'id']],
            [['category_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => CategoryTypes::className(), 'targetAttribute' => ['category_type_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['orientation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orientations::className(), 'targetAttribute' => ['orientation_id' => 'id']],
            [['remuneration_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => RemunerationType::className(), 'targetAttribute' => ['remuneration_type_id' => 'id']],
            [['contest_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => ContestStatus::className(), 'targetAttribute' => ['contest_status_id' => 'id']],
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
            'resolution_file_path' => Yii::t('models/contest', 'resolution_file_path'),
            'resolution_published' => Yii::t('models/contest', 'publish_resolution'),
            'remuneration_type_id' => Yii::t('models/contest', 'remuneration_type'),
            'working_day_type_id' => Yii::t('models/contest', 'working_day_type'),
            'course_id' => Yii::t('models/contest', 'course'),
            'category_id' => Yii::t('models/contest', 'category'),
            'category_type_id' => Yii::t('models/contest', 'category_type'),
            'area_id' => Yii::t('models/contest', 'area'),
            'orientation_id' => Yii::t('models/contest', 'orientation'),
            'career_id' => Yii::t('models/contest', 'career'),
            'departament_id' => Yii::t('models/contest', 'departament'),
            'evaluation_departament_id' => Yii::t('models/contest', 'evaluation_departament'),
            'contest_status_id' => Yii::t('models/contest', 'contest_status'),
            'activity' => Yii::t('models/contest', 'activity'),
            'share_id' => Yii::t('models/contest', 'share_id'),
        ];
    }

    public function validateDates()
    {
        if(strtotime($this->end_date) <= strtotime($this->init_date)){
            $this->addError('end_date','La fecha de fin debe ser mayor a la de inicio');
        }
        if(strtotime($this->init_date) >= strtotime($this->enrollment_date_end)){
            $this->addError('enrollment_date_end','La fecha de fin de la inscripciones debe ser mayor a la de inicio');
        }
    
        if(strtotime($this->end_date) <= strtotime($this->enrollment_date_end)){
            $this->addError('enrollment_date_end','La fecha de fin de la inscripciones debe ser menor a la de fin');
        }
    }

    public function getCareer()
    {
        return Career::find($this->career_id);
    }

    public function getDepartament()
    {
        return Departament::find($this->departament_id);
    }

    public function getEvaluationDepartament()
    {
        return Departament::find($this->evaluation_departament_id);
    }

    public function getCourse()
    {
        return Course::findOne($this->course_id);
    }

    public function getCourseName()
    {
        return $this->hasCourseName() ? $this->getCourse()->name : '';
    }

    public function getAreaName()
    {
        return $this->area ? $this->area->name : '';
    }

    public function getOrientationName()
    {
        return $this->orientation ? $this->orientation->name : '';
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

    public function getContestStatus()
    {
        return $this->hasOne(ContestStatus::className(), ['id' => 'contest_status_id']);
    }

    public function getCategory()
    {
        return $this->hasOne(Categories::class, ['id' => 'category_id']);
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

    public function getPresidents()
    {
        $presidents = [];
        foreach($this->juries as $jurie){
            var_dump(ContestJury::find()->where(['user_id' => $jurie['id']])->one());
            var_dump('<br>');
            if (ContestJury::find()->where('user_id=' . $jurie['id'])->one()->is_president){
                array_push($presidents, $jurie['id']);
            }
        }
        return $presidents;
    }
    /**
     * {@inheritdoc}
     * @return ContestsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ContestsQuery(get_called_class());
    }

    public function generateCode() : void 
    {
        if ($this->code || !$this->name) {
            throw \Exception('exists or invalid');
        }

        $code = \Yii::$app->slug->format($this->name);
        $contest = Contests::find()->getBySlug($code);
        $count = 1;
        while ($contest) {
            $code = \Yii::$app->slug->format($this->name . ' ' . $count);
            $contest = Contests::find()->getBySlug($code);
            $count++;
        }

        $this->code = $code;
    }

    public function isDownloadeableResolution() : bool
    {
        return !is_null($this->resolution_file_path);
    }

    public function canUploadResolution() : bool
    {
        return !$this->isResolutionPublished();
    }

    public function isResolutionPublished() : bool
    {
        return $this->resolution_published;
    }

    public function publishResolution() : bool
    {
        if (!$this->resolution_file_path) {
            return false;
        }
        $this->contest_status_id = ContestStatus::FINISHED;
        return $this->resolution_published = true;
    }

    public function isPostulateAvailable() : bool
    {
        $now = new DateTime();
        $enrollment_date_end = new DateTime($this->enrollment_date_end);

        return $now < $enrollment_date_end;
    }

    public function canPostulate(): bool
    {
        if (!\Yii::$app->user->identity) {
            return false;
        }

        $person = \Yii::$app->user->identity->person;

        return $person->isValid() && $this->isPostulateAvailable()
            && !$person->isPostulatedInContest($this->id);
    }

    public function getResolutionPath(): ?string
    {
        $filepath = Yii::getAlias('@webroot') . '/' . $this->resolution_file_path;
        return $this->resolution_file_path && file_exists($filepath) ?
            $filepath
            :
            null;
    }

    public function beforeSave($insert)
    {
        if ($insert && !$this->code) {
            $this->generateCode();
        }
        return parent::beforeSave($insert);
    }

    public function createConstestFolder() 
    {
        $service = new NextcloudService();
        $response = $service->createFolder(folder: $this->code);
        if($response['code'] < 300){
            return true;
        }else{
            return false;
        }
    }

    public function createContestFolderShare()
    {
        $expireDate = '';
        $folder = $this->code;
        $today = date_create();

        $end_date = date_create($this->end_date);

        $service = new NextcloudService();

        if($today < $end_date){
            $expireDate = date_format($end_date, 'Y-m-d');
            $response = $service->createReadOnlyShare($folder, $expireDate);
        }else{
            date_modify($today, '+3 day');
            $expireDate = date_format($today, 'Y-m-d');
            $response = $service->createReadOnlyShare($folder, $expireDate);
        }

        return $response;
    }

    public function getContestFolderShareUrl(): ?string
    {
        if($this->share_id){
            $service = new NextcloudService();
            $response = $service->getFolderShare($this->share_id);
            if($response['status']){
                return $response['url'];
            }
        }
        return null;
    }

    public function defineScenario()
    {
        switch($this->activity) {
            case Activity::DEPARTMENT_ASSISTANT_CODE:
                $this->scenario = self::SCENARIO_ASSISTANT_DEPARTMENT;
                break;
            default:
                if ($this->categoryType) {
                  if ($this->categoryType->code === 'regulares') {
                    $this->scenario = self::SCENARIO_REGULAR;
                  } else {
                    $this->scenario = self::SCENARIO_OTHERS;
                  }
                } else {
                  $this->scenario = self::SCENARIO_DEFAULT;
                }
                break;
        }
    }

    public function getIntroDetails(): string
    {
        $description = "El Centro Universitario Regional Zona Atlántica de la Universidad Nacional 
        del Comahue comunica que se llama a concurso de";
        if ($this->categoryType->is(CategoryTypes::REGULARES_CODE)){
          return $description . "ingreso, antecedentes y oposición para cubrir cargos docentes regulares.";
        }
        return $description . " antecedentes para cubrir cargos docentes para el año académico en curso.";
    }

    public function setToPublish(): void
    {
        // TODO: qué restricciones tiene publicar el concurso.
        // fecha, el estado actual? qué pasa si está finalizado.
        if (!$this->canPublish()) {
          return;
        }

        $this->contest_status_id = ContestStatus::PUBLISHED;
        $this->save();
    }

    public function canPublish(): bool
    {
        return $this->contest_status_id === ContestStatus::DRAFT;
    }

    public function hasCourseName(): bool
    {
        return $this->activity == Activity::TEACHER_CODE && $this->category_type_id != 3;
    }

    public function isTeacher(): bool
    {
        return $this->activity == Activity::TEACHER_CODE;
    }
}
