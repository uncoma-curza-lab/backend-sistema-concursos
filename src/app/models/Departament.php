<?php

namespace app\models;

use app\services\SPCService;
use JsonSerializable;

class Departament implements JsonSerializable
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
        $departaments = $service->getAll('departamento');

        if ($departaments['code'] >= 400) {
            return null;
        }
        // TODO: implement mapper


        $collect = json_decode($departaments['data']);
        $collect = array_map(function($departament){
            $entity = new self(
                $departament->nombre,
                $departament->id
            );
            return $entity;
        }, $collect);

        return $collect;
    }

    public static function find($id)
    {
        $service = new SPCService();
        $departaments = $service->getOne('departamento', $id);

        if ($departaments['code'] >= 400) {
            return null;
        }

        $departamentRawData = json_decode($departaments['data']);
        $departament = new Departament(
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
        ];

    }
}

