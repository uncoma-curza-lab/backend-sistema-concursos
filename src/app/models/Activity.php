<?php

namespace app\models;

use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user This property is read-only.
 *
 */
class Activity extends Model
{

    const TEACHER_CODE = 'TEACHER';
    const DEPARTMENT_ASSISTANT_CODE = 'DEPARTMENT_ASSISTANT';
    const INSTITUTIONAL_PROYECT_CODE = 'INSTITUTIONAL_PROYECT';

    public $code;
    public $name;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [
                ['code', 'name'],
                'required',
                'requiredValue' => true,
                'message' => 'Requerido'
            ],
            [['code', 'name'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'code' => 'ID',
            'name' => 'Nombre',
        ];
    }

    public static function getLabelsByCode(): array
    {
        return [
            self::TEACHER_CODE => 'Docente',
            self::DEPARTMENT_ASSISTANT_CODE => 'Auxiliar de departamento', 
            self::INSTITUTIONAL_PROYECT_CODE => 'Proyecto Institucional', 
        ];
    }

}
