<?php

namespace app\modules\backoffice\controllers;

use app\models\Areas;
use app\models\Career;
use app\models\CategoryTypes;
use app\models\Contests;
use app\models\Course;
use app\models\Departament;
use app\models\Orientations;
use app\models\RemunerationType;
use app\models\search\ContestSearch;
use app\models\WorkingDayTypes;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ContestController implements the CRUD actions for Contests model.
 */
class ContestController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['teach_departament', 'admin'],
                        ],
                    ],
                ],
            ],
        );
    }

    /**
     * Lists all Contests models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ContestSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Contests model.
     * @param int $slug CODE
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($slug)
    {
        return $this->render('view', [
            'model' => Contests::find()->filterQueryBySlug($slug)
                                       ->complete()->one(),
        ]);
    }

    /**
     * Creates a new Contests model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Contests();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'slug' => $model->code]);
            }
        } else {
            $model->loadDefaultValues();
        }
        $props = $this->getRelationLists($model);

        return $this->render('create', [
            'model' => $model,
            'relationships' => $props
        ]);
    }

    /**
     * Updates an existing Contests model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($slug)
    {
        $model = $this->findModel($slug);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'slug' => $model->code]);
        }
        $props = $this->getRelationLists($model);

        return $this->render('update', [
            'model' => $model,
            'relationships' => $props
        ]);
    }

    /**
     * Deletes an existing Contests model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($slug)
    {
        $this->findModel($slug)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Contests model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Contests the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($slug)
    {
        if (($model = Contests::find()->findBySlug($slug)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('backoffice', 'The requested page does not exist.'));
    }

    private function getRelationLists($contest)
    {
        $departaments = Departament::all();
        $workingDayTypeList = ArrayHelper::map(WorkingDayTypes::find()->all(), 'id', 'name');
        $remunerationTypeList = ArrayHelper::map(RemunerationType::find()->all(), 'id', 'name');
        $categoryTypeList = ArrayHelper::map(CategoryTypes::find()->all(), 'id', 'name');
        $orientationList = ArrayHelper::map(Orientations::find()->all(), 'id', 'name');
        $areaList = ArrayHelper::map(Areas::find()->all(), 'id', 'name');

        return [
            'workingDayTypeList' => $workingDayTypeList,
            'remunerationTypeList' => $remunerationTypeList,
            'categoryTypeList' => $categoryTypeList,
            'orientationList' => $orientationList,
            'areaList' => $areaList,
            'departamentList' => $departaments ? ArrayHelper::map($departaments, 'code', 'name') : null,
            'careerList' => $contest->departament_id ? ArrayHelper::map(Career::findByDepartament($contest->departament_id), 'code', 'name') : [],
            'courseList' => $contest->career_id ? ArrayHelper::map(Course::findByCareer($contest->career_id), 'code', 'name') : [],
        ];
    }
}
