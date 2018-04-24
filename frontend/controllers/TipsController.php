<?php

namespace frontend\controllers;


use Yii;
use yii\helpers\StringHelper;
use common\models\BlogPost;



class TipsController extends \yii\web\Controller
{ 
    public function init() {
        $this->layout   =   'public_main';
    }
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionBuying() {
        $buyingModel      = BlogPost::findAll(['category_id' => 1]);
        //\yii\helpers\VarDumper::dump($buyingModel,4,12);exit;
        if(empty($buyingModel)){
            $buyingModel    =[];
        }
        return $this->render('buying', ['buyingModel' => $buyingModel]);
    }
    
    public function actionSelling() {
        $sellingModel      = BlogPost::findAll(['category_id' => 2]);
        if(empty($sellingModel)){
            $sellingModel    =[];
        }
        return $this->render('selling', ['sellingModel' => $sellingModel]);
    }
}

?>