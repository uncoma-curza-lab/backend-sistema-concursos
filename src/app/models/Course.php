<?php

namespace app\models;

use app\services\SPCService;
use JsonSerializable;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "courses".
 *
 * @property int $code
 * @property string|null $name
 * @property string|null $update_date
 */
class Course extends ActiveRecord implements JsonSerializable
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'courses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['update_date'], 'safe'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Code',
            'name' => 'Name',
            'update_date' => 'Update Date',
        ];
    }

    /**
     * Departaments from SPC
     * @throws Exception if empty or error service
     * @return Collection data
     */
    public static function all()
    {
        $service = new SPCService();
        $careers = $service->getAll('asignatura');

        if ($careers['code'] >= 400) {
            return null;
        }
        // TODO: implement mapper


        $collect = json_decode($careers['data']);
        $collect = array_map(function($career){
            $entity = new self();
            $entity->name = $career->nombre;
            $entity->code = $career->id;
            return $entity;
        }, $collect);

        return $collect;
    }

    public static function findByPlan($planID)
    {
        $service = new SPCService();
        $courses = $service->getAll('asignatura/plan?id=' . $planID);

        if ($courses['code'] >= 400) {
            throw new \Exception('Model error, status:'. $courses['code'] . $courses['data']);
        }

        $collect = json_decode($courses['data']);
        $collect = array_map(function($career){
            return self::entityMapper($career);
        }, $collect);
        return $collect;

    }

    public static function entityMapper($data)
    {
        $entity = new self();
        $entity->name = $data->nombre;
        $entity->code = $data->id;
        return $entity;

    }

    public static function findByCareer($careerID)
    {
        $service = new SPCService();
        $career = Career::getFullData($careerID);
        $parse = parse_url($career->plan_vigente->_links->asignaturas->href);
        $path = $parse['path'];
        $query = $parse['query'];
        $cleanPath = str_replace('/api/v1/', '', $path);
        $courses = $service->getAll($cleanPath . '?' . $query);

        if ($courses['code'] >= 400) {
            throw new \Exception('Model error, status:'. $courses['code'] . $courses['data']);
        }

        $collect = json_decode($courses['data']);
        $collect = array_map(function($course){
            $entity = new self();
            $entity->name = $course->nombre;
            $entity->code = $course->id;
            return $entity;
        }, $collect);
        return $collect;
    }


    public static function findBySCPService($id)
    {
        $service = new SPCService();
        $departaments = $service->getOne('asignatura', $id);

        if ($departaments['code'] >= 400) {
            return null;
        }

        $departamentRawData = json_decode($departaments['data']);
        $departament = new self();
        $departament->name = $departamentRawData->nombre;
        $departament->code = $departamentRawData->id;
        return $departament;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getName()
    {
        return $this->name;
    }

    public function jsonSerialize()
    {
        return [
            'code' => $this->getCode(),
            'name' => $this->getName(),
        ];
    }

    public static function saveValue($code){
        $newCourse = self::findBySCPService($code);
        $newCourse->update_date = date('Y-m-d H:i:s');
        $oldCourse = self::findByActiveRecord($code);
        if($oldCourse){
            $oldCourse->update_date = date('Y-m-d H:i:s');
            return ($oldCourse->update()) ? $oldCourse : null;
        }
        return ($newCourse->save()) ? $newCourse : null;
    }

    public static function findOne($code)
    {
        if($code == ''){
            return null;
        }

        $courseByActiveRecord = self::findByActiveRecord($code);
        if($courseByActiveRecord){
            return $courseByActiveRecord;
        }
        
        return self::saveValue($code);
    }
    
    public static function findByActiveRecord($code)
    {
        return static::findByCondition($code)->one();
    }
}
