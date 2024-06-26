<?php

namespace app\models;

use app\models\ContestAttachedFile as ModelsContestAttachedFile;
use kartik\mpdf\Pdf;
use Yii;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "contest_attached_files".
 *
 * @property int $id
 * @property int $contest_id
 * @property string $name
 * @property int $document_type_id
 * @property string|null $path
 * @property int|null $responsible_id
 * @property bool|null $published
 *
 * @property Contests $contest
 * @property DocumentsType $documentType
 * @property DocumentsResponsible $responsible
 */
class InscribedContestAttachedFile extends ModelsContestAttachedFile
{

    public function generateAndSave(string $content) : bool
    {
        FileHelper::createDirectory('contest_attached_files/' . $this->contest->code);
        $name = 'contest_attached_files/' . $this->contest->code . '/'
            . Yii::$app->slug->format('inscribed_postulations' . ' ' . date('Y-m-d H:i:s'))
            . '.pdf';
        $mpdf = self::writePdf($content);
        $mpdf->Output($name, 'F');

        if (in_array($name, FileHelper::findFiles('contest_attached_files/' . $this->contest->code . '/'))){
            $this->name = 'Acta Fin de inscripciones';
            $this->document_type_id = DocumentType::getByCode(DocumentType::INSCRIBED_POSTULATIONS)->id;
            $this->responsible_id = DocumentResponsible::getByCode(DocumentResponsible::TEACHER_DEPARTMENT)->id;
            $this->path = $name;
            $this->setSaveOnlyScenario();
            return $this->save();
        }

        return false;

    }

    public static function writePdf(string $content)
    {
        $stylesheet = file_get_contents(\Yii::getAlias('@webroot') . '/css/inscribed_postulations.css');
        $webroot = \Yii::getAlias('@webroot');
        $header = "<img src='$webroot/images/inscribed_note/header.png' alt='header' width='500'>||";
        $sign = "
        <img src='$webroot/images/inscribed_note/stamp.png'  alt='stmp' width='100' style='float: left; margin-left:200'>
        <img src='$webroot/images/inscribed_note/signature.png' alt='signature' width='200' style='float: right; margin-right:50'>
        ";

        $pdf = new Pdf([
          'mode' => '', // leaner size using standard fonts
          'format' => Pdf::FORMAT_A4,
          'orientation' => Pdf::ORIENT_PORTRAIT,
          'marginTop' => 40,
          'marginBottom' => 30,
          'marginLeft' => 20,
          'marginRight' => 10,
        ]);
        $mpdf = $pdf->api;
        $mpdf->SetHeader($header);
        $mpdf->WriteHtml($stylesheet, 1);
        $mpdf->WriteHtml($content, 2);
        $mpdf->WriteHtml($sign, 2);

        return $mpdf;
    }

    public static function getParcedDateToNoteFormat()
    {
        $date = '';
        $today = date_create();
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
        $dayNumberNames = [
            null, 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve', 'diez',
            'once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis', 'diecisiete', 'dieciocho', 'diecinueve', 'veinte',
            'veintiuno', 'veintidós', 'veintitrés', 'veinticuatro', 'veinticinco', 'veintiséis', 'veintisiete', 
            'veintiocho', 'veintinueve', 'treinta', 'treinta y uno'
        ];

        return $dayNumberNames[$dayNumber];
    }

    private static function getMonthName(int $monthNumber)
    {
        $monthNames = [
            null, 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'
        ];

        return $monthNames[$monthNumber];
    }


}
