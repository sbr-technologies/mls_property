<?php

namespace frontend\controllers;

use yii\web\Response;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\News;
use backend\models\NewsSearch;
use common\models\NewsCategory;
use common\models\Advice;
use common\models\AdviceCategory;
use common\models\AdviceSearch;

use yii\helpers\StringHelper;

class NewsController extends \yii\web\Controller
{ 
    public function init() {
        $this->layout   =   'public_main';
    }
    
    public function actionNewsView($id) {
        $model          = News::findOne($id);
        //\yii\helpers\VarDumper::dump($id); exit;
        return $this->render('news-view', [
            'model' => $model,
        ]);
        
    }
    public function actionIndex($id){
        $newsCategory = NewsCategory::find()->where(['id' => $id])->one();
        $newsDetails = News::find()->where(['news_category_id' => $id])->all();
        if(empty($newsDetails)){
            $newsDetails    =[];
        }
        return $this->render('index',[
            'newsDetails'   => $newsDetails,
            'newsCategory'  =>  $newsCategory,
            ]);
    }
    
    public function actionAdvice($id){
        $adviceCategory = AdviceCategory::find()->where(['id' => $id])->one();
        $adviceDetails = Advice::find()->where(['advice_category_id' => $id])->all();
        if(empty($adviceDetails)){
//            throw new NotFoundHttpException(Yii::t('app', 'Invalid data'));
            $adviceDetails    =[];
        }
        //\yii\helpers\VarDumper::dump($adviceCategory); exit;
        return $this->render('advice',[
            'adviceDetails'   => $adviceDetails,
            'adviceCategory'  =>  $adviceCategory,
            ]);
    }
    
    public function actionAdviceView($id) {
        $model          = Advice::findOne($id);
        //\yii\helpers\VarDumper::dump($id); exit;
        return $this->render('advice-view', [
            'model' => $model,
        ]);
        
    }
    public function actionNewsAdvice(){
        return $this->render('news-advice');
    }
    public function actionNewsDetails(){
        return $this->render('news-details');
    }
}
