<?php

namespace aditiya\easyfilemanager\controllers;

use aditiya\easyfilemanager\models\Easyfilemanager;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for Easyfilemanager model.
 */
class FileController extends Controller
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

    /**
     * Lists all Easyfilemanager models.
     *
     * @return string
     */
    public function actionIndex($key)
    {
        $response = Yii::$app->response;
        $efm = Easyfilemanager::findOne(['key'=>$key]);
        if($efm != null){
            $is_allowed = $efm->checkCredential();
            $filepath = $efm->fullFilePath();
            if(is_file($filepath) && $is_allowed){
                return $response->sendFile($filepath,$efm->name,['mimeType'=>$efm->mimetype,'inline'=>true]);
            }
        }
        throw new NotFoundHttpException('file not found');
    }

    public function actionGet($key){
        return $this->actionIndex($key);
    }
}
