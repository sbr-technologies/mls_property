<?php

namespace backend\controllers;

use Yii;
use common\models\AgencyImport;
use common\models\Agency;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


class AgencyImportController extends Controller
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
    /**
     * Lists all Agency models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', [
            
        ]);
    }
    
    public function actionCreate(){
        $model    =   new AgencyImport();
        if ($model->load(Yii::$app->request->post()) ) {
            $importAgencyArr  =   $model->import();
            return $this->refresh();
        }else{
            return $this->render('create',['model' => $model]);
        } 
    }

}
