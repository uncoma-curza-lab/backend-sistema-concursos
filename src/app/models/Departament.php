<?php

namespace app\models;

use app\services\SPCService;

class Departament //extends Model
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
            throw new \Exception('Model error');
        }
        // TODO: implement mapper


        $collect = json_decode($departaments['data']);
        $collect = array_map(function($departament){
            $map = [];
            $map['code'] = $departament->id;
            $map['name'] = $departament->nombre;
            return $map;
        }, $collect);

        return $collect;
    }

    public static function find($id)
    {
        $service = new SPCService();
        $departaments = $service->getOne('departamento', $id);

        if ($departaments['code'] >= 400) {
            throw new \Exception('Model error');
        }

        $departamentRawData = json_decode($departaments['data']);
        $departament = new Departament($departamentRawData['name'], $departamentRawData['code']);
        return $departament;
    }
}

