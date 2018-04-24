<?php
namespace frontend\controllers;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use common\models\Transaction;
use common\models\TransactionSearch;
use yii\filters\AccessControl;

class TransactionController extends \yii\web\Controller
{ 
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
//                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function init() {
        $this->layout   =   'main';
    }
    
    

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionIndex(){
        $searchModel            =   new TransactionSearch();
        $userId                 =   Yii::$app->user->id;
        $searchModel->user_id   =   $userId;
        $dataProvider           =   $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index',['dataProvider' => $dataProvider, 'userId' => $userId]);
    }

}