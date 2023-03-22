<?php 
namespace app\models;

use Yii;
use yii\base\Model;

class InscribedContestAttachedFileForm extends Model
{
    public $text;

    public function rules()
    {
        return [
            [['text'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'text' => Yii::t('models/InscribedContestAttachedFileForm', 'text'),
        ];
    }

    public static function getDate()
    {
        $date = '';
        //TODO - date create now
        $today = date_create('2023-03-02');
        $date .= self::getDayNumberName((int) $today->format('d'));
        $date .= ' ';
        $date .= '(' . $today->format('d') . ')';
        $date .= ' de ';
        $date .= self::getMonthName((int) $today->format('m'));
        $date .= ' del año ';
        $date .= $today->format('Y');

        return $date;
    }

    private static function getDayNumberName(int $dayNumber)
    {
        //TODO - Todos los dias
        $dayNumberNames = [
            null, 'primero', 'dos', 'tres', 'cuatro'
        ];

        return $dayNumberNames[$dayNumber];
    }

    private static function getMonthName(int $monthNumber)
    {
        //TODO - Todos los meses
        $monthNames = [
            null, 'Enero', 'Febrero', 'Marzo', 'Abril'
        ];

        return $monthNames[$monthNumber];
    }

}
