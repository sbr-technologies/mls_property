<?php

namespace backend\controllers;

use Yii;
use common\models\HolidayPackageImport;
use common\models\HolidayPackage;
use common\models\HolidayPackageCategory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


class HolidayPackageImportController extends Controller
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
        $model    =   new HolidayPackageImport();
        if ($model->load(Yii::$app->request->post()) ) {
            $importHolidayPackageArr  =   $model->import();
            return $this->refresh();
        }else{
            return $this->render('create',['model' => $model]);
        } 
    }

}
