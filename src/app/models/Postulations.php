<?php

namespace app\models;

use app\services\NextcloudService;
use DateTime;
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
 * @property int $share_id
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
            ],
        	'FormatDate' => [
            	'class' => 'app\behaviors\FormatDate',
            	'attributes' => ['created_at', 'updated_at'],
            ],
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
            [['contest_id', 'person_id', 'share_id'], 'integer'],
            [['status'], 'string'],
            [['files'], 'string'],
            [['meet_date', 'created_at', 'updated_at'], 'safe'],
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
            'share_id' => 'Share ID',
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
        $loggedUser = Yii::$app->user;
        $roles = array_keys(Yii::$app->authManager->getRolesByUser($loggedUser->id));
        return ($this->status === PostulationStatus::DRAFT ||
            $this->status === PostulationStatus::PENDING) &&
            in_array('admin', $roles) ||
            in_array('teach_departament', $roles);
    }

    public function canReject()
    {
        $loggedUser = Yii::$app->user;
        $roles = array_keys(Yii::$app->authManager->getRolesByUser($loggedUser->id));
        return ($this->status === PostulationStatus::DRAFT ||
            $this->status === PostulationStatus::PENDING) &&
            in_array('admin', $roles) || in_array('teach_departament', $roles);
    }

    public function getStatusDescription()
    {
        //TODO translations
        return PostulationStatus::getTranslation($this->status);
    }

    private function generateFolderName()
    {
        return \Yii::$app->slug->format(
            $this->person->uid . ' ' .
            $this->person->last_name . ' ' . 
            $this->person->first_name);
    }

    public function createPostulationFolder() 
    {
        $pathToFolder = $this->contest->code . '/' . $this->generateFolderName();
        $service = new NextcloudService();
        $response = $service->createFolder($pathToFolder);
        if($response['code'] < 300){
            return true;
        }else{
            return false;
        }
    }

    public function createPostulationFolderShare()
    {
        $expireDate = '';
        $pathToFolder = $this->contest->code . '/' . $this->generateFolderName();
        $today = date_create();

        $enrollment_date_end = date_create($this->contest->enrollment_date_end);

        $service = new NextcloudService();

        if($today < $enrollment_date_end){
            $expireDate = date_format($enrollment_date_end, 'Y-m-d');
            $response = $service->createPublicShare($pathToFolder, $expireDate);
        }else{
            date_modify($today, '+3 day');
            $expireDate = date_format($today, 'Y-m-d');
            $response = $service->createReadOnlyShare($pathToFolder, $expireDate);
        }

        return $response;
    }

    public function getPostulationFolderShare()
    {
        $service = new NextcloudService();
        $response = $service->getFolderShare($this->share_id);
        return $response;
    }

}
