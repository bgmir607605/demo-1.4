<?php

namespace app\controllers;

use yii\web\UploadedFile;
use Yii;
use app\models\User;
use app\models\Category;
use app\models\Problem;
use app\models\ProblemCreateForm;
use app\models\RegForm;
use app\models\UserSearch;
use app\models\ProblemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * UserController implements the CRUD actions for User model.
 */
class LkController extends Controller
{

    public function beforeAction($action)
    {
        // your custom code here, if you want the code to run before action filters,
        // which are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessControl
    
        if(Yii::$app->user->isGuest){
            $this->redirect(['/site/login']);
            return false;
    
        }
    
        if (!parent::beforeAction($action)) {
            return false;
        }
    
        // other custom code here
    
        return true; // or false to not run the action
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProblemSearch();
        $dataProvider = $searchModel->searchForUser(Yii::$app->request->queryParams, Yii::$app->user->identity->id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Problem::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionCreate()
    {
        $model = new ProblemCreateForm();


        if ($model->load(Yii::$app->request->post())) {
            $model->photoBefore = UploadedFile::getInstance($model, 'photoBefore');
            $newFileName = md5($model->photoBefore->baseName . '.' . $model->photoBefore->extension. time()). '.' . $model->photoBefore->extension;
            $model->photoBefore->saveAs('@app/web/uploads/' . $newFileName);
            $model->photoBefore = $newFileName;
            $model->idUser = Yii::$app->user->identity->id;
            $model->save();
            return $this->redirect(['/lk']);
        }

        $categories = Category::find()->all();
        $categories = ArrayHelper::map($categories, 'id', 'name');
        return $this->render('create', [
            'model' => $model,
            'categories' => $categories,
        ]);
    }


}
