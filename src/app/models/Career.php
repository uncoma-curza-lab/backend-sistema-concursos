<?php

namespace app\models;

use app\services\SPCService;
use JsonSerializable;

class Career implements JsonSerializable
{
    protected $name;
    protected $code;
    protected $metadata;


    public function __construct(string $name, string $code, array $metadata = [])
    {
        $this->name = $name;
        $this->code = $code;
        $this->metadata = $metadata;
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
            return null;
        }
        // TODO: implement mapper


        $collect = json_decode($careers['data']);
        $collect = array_map(function($career){
            return self::entityMapper($career);
        }, $collect);

        return $collect;
    }

    protected static function entityMapper($data)
    {
        $metadata = [];
        if ($data->plan_vigente) {
            $metadata = [ 'actually_plan' => [
                'id' => $data->plan_vigente->id
            ]];
        }
        $entity = new self(
            $data->nombre,
            $data->id,
            $metadata,
        );
        return $entity;
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
            return self::entityMapper($career);
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

        $rawData = json_decode($departaments['data']);
        return self::entityMapper($rawData);
    }

    public static function getFullData($id)
    {
        $service = new SPCService();
        $departaments = $service->getOne('carrera', $id);

        if ($departaments['code'] >= 400) {
            return null;
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

    public function jsonSerialize()
    {
        return [
            'code' => $this->getCode(),
            'name' => $this->getName(),
            'metadata' => $this->metadata,
        ];

    }
}

