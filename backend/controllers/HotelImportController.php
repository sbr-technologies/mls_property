<?php

namespace backend\controllers;

use Yii;
use common\models\HotelImport;
use common\models\Hotel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class HotelImportController extends Controller
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
        $model    =   new HotelImport();
        if ($model->load(Yii::$app->request->post()) ) {
            $importHotelArr  =   $model->import();
            return $this->refresh();
        }else{
            return $this->render('create',['model' => $model]);
        } 
    }

}
