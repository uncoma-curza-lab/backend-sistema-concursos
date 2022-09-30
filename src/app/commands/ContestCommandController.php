<?php
namespace app\commands;

use app\models\Contests;
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
            $contest->setToInProgress();
            echo $contest->code . "Cambiado a IN_PROCESS \n";
        }

        return ExitCode::OK;

    }
}
