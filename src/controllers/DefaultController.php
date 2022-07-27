<?php

namespace aditiya\easyfilemanager\controllers;

use aditiya\easyfilemanager\models\Easyfilemanager;
use aditiya\easyfilemanager\models\EasyfilemanagerSearch;
use Exception;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for Easyfilemanager model.
 */
class DefaultController extends Controller
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

    public function beforeAction($action)
    {
        $module = Yii::$app->getModule('efm');
        if(!$module->usedemo){
            throw new Exception('Not Allowed');
        }
        return parent::beforeAction($action);
    }

    /**
     * Lists all Easyfilemanager models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new EasyfilemanagerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Easyfilemanager model.
     * @param string $key Key
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($key)
    {
        return $this->render('view', [
            'model' => $this->findModel($key),
        ]);
    }

    /**
     * Creates a new Easyfilemanager model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Easyfilemanager();

        if ($this->request->isPost) {
            // if ($model->load($this->request->post()) && $model->save()) {
            //     return $this->redirect(['view', 'key' => $model->key]);
            // }
            $key = $model->uploadByInstance($model,'file');
            if($key){
                return $this->redirect(['view', 'key' => $key]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Easyfilemanager model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $key Key
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($key)
    {
        $model = $this->findModel($key);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'key' => $model->key]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Easyfilemanager model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $key Key
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($key)
    {
        $this->findModel($key)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Easyfilemanager model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $key Key
     * @return Easyfilemanager the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($key)
    {
        if (($model = Easyfilemanager::findOne(['key' => $key])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('easy_file_manager', 'The requested page does not exist.'));
    }
}
