<?php

namespace app\controllers;

use app\models\PersonalFile;
use Yii;
use \yii\web\Controller;
use app\models\search\PersonalFileSearch;

class PersonalFileController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionMyFiles()
    {
        $searchModel = new PersonalFileSearch();
        $dataProvider = $searchModel->search(array_merge(
            [
                'person_id' => Yii::$app->user->identity->person->id
            ],
            $this->request->queryParams
        ));

        $files = PersonalFile::find()->all();

        return $this->render('my_files', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'files' => $files,
        ]);

    }

    public function actionPostulationFiles(int $postulationId)
    {
        return $this->render('index');
    }

}
