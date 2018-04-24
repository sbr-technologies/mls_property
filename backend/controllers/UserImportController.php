<?php

namespace backend\controllers;

use Yii;
use common\models\UserImport;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;

class UserImportController extends Controller
{
    /**
     * @inheritdoc
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }    
    
    public function actionCreate(){
        
        $model    =   new UserImport();
        
        if ($model->load(Yii::$app->request->post()) ) {
            $importUserArr  =   $model->import();
            return $this->refresh();
        }else{
            return $this->render('create',['model' => $model]);
        } 
        
    }

}
