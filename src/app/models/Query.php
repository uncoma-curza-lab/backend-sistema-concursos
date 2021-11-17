<?php 

namespace app\models;

use Yii;
use yii\base\Model;

class Query extends Model
{
  public $query;

  public function rules()
  {
    return[
      ['query', 'match', 'pattern'=>'/^[0-9a-z]+$/i', 'message'=>'Solo letras y números']
    ];
  }

  public function attributeLabels()
  {
    return [ 
      "query"=>"Buscar:"
    ];
  }
}
?>