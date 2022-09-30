<?php
namespace app\commands;

use app\models\Contests;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class ContestCommandController extends Controller
{
    public function actionSetInProgress()
    {
        $enrollmentDateEndContests = Contests::find()
            ->onlyPublicAndEnrollmentDateEnd()
            ->all();

        foreach ($enrollmentDateEndContests as $contest) {

            $messege = $contest->setToInProgress() ? $contest->code . " Cambiado a IN_PROCESS \n" : $contest->code . " No Cambiado a IN_PROCESS \n";

            echo $messege;
            Yii::info($messege, 'Set-Contest-In-Progress');
        }

        return ExitCode::OK;

    }
}
