<?php

namespace app\modules\backoffice\controllers;

use app\models\City;
use app\models\Countries;
use app\models\Provinces;
use app\models\search\CitiesSearch;
use app\models\search\ProvincesSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

class CitiesController extends Controller
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
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CitiesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($slug)
    {
        return $this->render('view', [
            'model' => $this->findModel($slug),
        ]);
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new City();

        if ($this->request->isPost) {
            if ($model = City::create($this->request->post())) {
                return $this->redirect(['view', 'slug' => $model->code]);
            }
        } else {
            $model->loadDefaultValues();
        }

        $countryList = ArrayHelper::map(Countries::find()->all(), 'id', 'name');
        return $this->render('create', [
            'model' => $model,
            'countryList' => $countryList,
        ]);
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($slug)
    {
        $model = $this->findModel($slug);
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'slug' => $slug]);
        }


        $countryList = ArrayHelper::map(Countries::find()->all(), 'id', 'name');
        return $this->render('update', [
            'model' => $model,
            'countryList' => $countryList,
        ]);
    }

    /**
     * Deletes an existing Users model.
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
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($slug)
    {
        if (($model = City::find()->getByCode($slug)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('backoffice', 'The requested page does not exist.'));
    }
}
