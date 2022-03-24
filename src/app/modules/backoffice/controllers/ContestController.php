<?php

namespace app\modules\backoffice\controllers;

use app\models\Areas;
use app\models\Career;
use app\models\CategoryTypes;
use app\models\Contests;
use app\models\ContestStatus;
use app\models\ContestsUploadResolutionForm;
use app\models\Course;
use app\models\Departament;
use app\models\Orientations;
use app\models\RemunerationType;
use app\models\search\ContestSearch;
use app\models\WorkingDayTypes;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

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
                    // TODO add rule jury upload file.
                    // TODO add rule for publish resolution teach_departament.
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['teach_departament', 'admin'],
                        ],
                        [
                            'allow' => true,
                            'roles' => ['teach_departament', 'admin', 'jury'],
                            'actions' => ['index', 'view'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['publish-resolution'],
                            'roles' => ['teach_departament'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['upload-resolution'],
                            'roles' => ['uploadResolution'],
                            'roleParams' => function() {
                                return [
                                    'contestSlug' => Yii::$app->request->get('slug'),
                                ];
                            },
                        ],
                        [
                            'allow' => true,
                            'actions' => ['download-resolution'],
                            'roles' => ['isJury'],
                            'roleParams' => function() {
                                return [
                                    'contestSlug' => Yii::$app->request->get('slug'),
                                ];
                            },
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
        }
        //
        //Carga de la descripcion por defecto a travez de archivo HTML
        // 
        ob_start();
        include ("defaultDescription.html");
        $defaultDescription=ob_get_contents();
        ob_end_clean();

        $model->description = $defaultDescription;

        $model->loadDefaultValues();
        
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

    public function actionSetStatus($slug)
    {
        $model = $this->findModel($slug);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        $statuses = ContestStatus::find()->all();
        return $this->render('set_status', [
            'model' => $model,
            'statuses' => ArrayHelper::map($statuses, 'id', function($model) {
                return ContestStatus::getTranslation($model->name);
            }),
        ]);
    }

    public function actionUploadResolution($slug)
    {
        $model = $this->findModel($slug);
        $modelForm = new ContestsUploadResolutionForm($slug);
        $modelForm->resolution_file_path = $model->resolution_file_path;
        // TODO check finish contest?
        //if ($model->isFinish()) {
        //}
        if (\Yii::$app->request->isPost) {
            $modelForm->resolution_file_path = UploadedFile::getInstance($modelForm, 'resolution_file_path');
            if ($modelForm->upload()) {
                // file is uploaded successfully
                return $this->redirect(['index']);
            }
        }
        //if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
        //}

        return $this->render('upload_resolution', [
            'model' => $model,
            'modelForm' => $modelForm,
        ]);
    }

    public function actionDownloadResolution($slug)
    {
        $model = $this->findModel($slug);
        $filepath = Yii::getAlias('@webroot') . '/' . $model->resolution_file_path;
        if ($model->resolution_file_path && file_exists($filepath)) {
            return Yii::$app->response->sendFile($filepath);
        }
        return $this->redirect(['index']);
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

    public function actionPublishResolution($slug)
    {
        $model = $this->findModel($slug);
        if ($model->publishResolution()) {
            $model->save();
        }

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
