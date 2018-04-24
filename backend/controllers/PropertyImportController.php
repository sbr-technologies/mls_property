<?php

namespace backend\controllers;

use Yii;
use common\models\PropertyImport;
use common\models\Property;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\MetricType;
use yii\filters\AccessControl;

class PropertyImportController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
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
        $model    =   new PropertyImport();
        if ($model->load(Yii::$app->request->post()) ) {
            $importPropertyArr  =   $model->import();
            return $this->refresh();
        }else{
            return $this->render('create',['model' => $model]);
        } 
    }

}
