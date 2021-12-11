<?php

namespace app\models;

use app\services\SPCService;

class Course
{
    protected $name;
    protected $code;


    public function __construct(string $name, string $code)
    {
        $this->name = $name;
        $this->code = $code;
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
            throw new \Exception('Model error');
        }
        // TODO: implement mapper


        $collect = json_decode($careers['data']);
        $collect = array_map(function($career){
            $entity = new self(
                $career->nombre,
                $career->id
            );
            return $entity;
        }, $collect);

        return $collect;
    }

    public static function findByCareer($careerID)
    {
        $service = new SPCService();
        $courses = $service->getAll('carrera/' . $careerID);

        if ($courses['code'] >= 400) {
            throw new \Exception('Model error, status:'. $courses['code'] . $courses['data']);
        }

        $collect = json_decode($courses['data']);
        $collect = array_map(function($course){
            $entity = new self($course->nombre, $course->id);
            return $entity;
        }, $collect);
        return $collect;
    }


    public static function find($id)
    {
        $service = new SPCService();
        $departaments = $service->getOne('asignatura', $id);

        if ($departaments['code'] >= 400) {
            throw new \Exception('Model error');
        }

        $departamentRawData = json_decode($departaments['data']);
        $departament = new self(
            $departamentRawData->nombre,
            $departamentRawData->id
        );
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
}

