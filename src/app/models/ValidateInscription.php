<?php
namespace app\models;

use Yii;
use yii\base\Model;

class ValidateInscription extends Model
{
  public $terminos;

  public function rules()
  {
    return [
      ['terminos', 'required', 'message'=>'Debe aceptar los términos.'],
    ];
  }

  public function attributeLabels()
  {
    return [
      'terminos' => 'Términos:',
    ];
  }
}