<?php

namespace app\models;

use app\services\SPCService;

class Career
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
        $careers = $service->getAll('carrera');

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

    public static function findByDepartament($departamentID)
    {
        $service = new SPCService();
        $careers = $service->getAll('carrera/departamento?id=' . $departamentID);

        if ($careers['code'] >= 400) {
            throw new \Exception('Model error, status:'. $careers['code'] . $careers['data']);
        }

        $collect = json_decode($careers['data']);
        $collect = array_map(function($career){
            $entity = new self($career->nombre, $career->id);
            return $entity;
        }, $collect);
        return $collect;
    }


    public static function find($id)
    {
        $service = new SPCService();
        $departaments = $service->getOne('carrera', $id);

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

    public static function getFullData($id)
    {
        $service = new SPCService();
        $departaments = $service->getOne('carrera', $id);

        if ($departaments['code'] >= 400) {
            throw new \Exception('Model error');
        }

        $departamentRawData = json_decode($departaments['data']);
        return $departamentRawData;

    }

    public function getCode()
    {
        return $this->code;
    }

    public function getName()
    {
        return $this->name;
    }

    public function __get($property)
    {
        switch($property){
        case 'code': 
            return $this->getCode();
        case 'name':
            return $this->getName();

        }

    }
}

