<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\RegForm;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class AdminController extends Controller
{
    public function beforeAction($action)
{
    // your custom code here, if you want the code to run before action filters,
    // which are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessControl

    if(Yii::$app->user->isGuest || Yii::$app->user->identity->admin != 1){
        $this->redirect(['/site/login']);
        return false;

    }

    if (!parent::beforeAction($action)) {
        return false;
    }

    // other custom code here

    return true; // or false to not run the action
}

    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}

