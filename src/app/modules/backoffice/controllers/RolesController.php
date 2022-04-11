<?php

namespace app\modules\backoffice\controllers;

use app\models\WorkingDayTypes;
use app\models\User;
use app\modules\backoffice\models\AddRoleToUserForm;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * WorkingDayTypeController implements the CRUD actions for WorkingDayTypes model.
 */
class RolesController extends Controller
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
            ]
        );
    }

    public function actionReplaceToUser($userId)
    {
        $user = User::findOne($userId);
        $roles = ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name');
        $addUserRoleForm = new AddRoleToUserForm();

        if ($addUserRoleForm->load($this->request->post()) && $addUserRoleForm->replace($user->id)) {
            return $this->redirect(['/backoffice/user']);
        }

        return $this->render('replace_role_to_user', [
            'model' => $addUserRoleForm,
            'user' => $user,
            'roles' => $roles,
        ]);

    }

    public function actionAddToUser($userId)
    {
        $user = User::findOne($userId);
        $roles = ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name');
        $addUserRoleForm = new AddRoleToUserForm();

        if ($addUserRoleForm->load($this->request->post()) && $addUserRoleForm->save($user->id)) {
            return $this->redirect(['/backoffice/user']);
        }

        return $this->render('add_role_to_user', [
            'model' => $addUserRoleForm,
            'user' => $user,
            'roles' => $roles,
        ]);

    }

}
