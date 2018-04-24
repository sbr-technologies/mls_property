<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\controllers;

use Yii;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Property;
use frontend\models\PropertySearch;
use common\models\LocationSuggestion;
use yii\web\Response;

use yii\filters\AccessControl;
use common\models\PropertyEnquiery;

use common\models\PropertyLocationLocalInfo;
use common\models\PhotoGallery;
use common\models\MetaTag;
use yii\web\UploadedFile;
use yii\helpers\StringHelper;
//use common\models\RentalPlan;
use yii\helpers\Url;
use common\models\PropertyFeature;
use common\models\PropertyFeatureItem;
use frontend\helpers\AuthHelper;
use frontend\helpers\PropertyHelper;
use common\models\OpenHouse;

use common\models\User;
use common\models\PropertyShowingRequest;


class ShortLetController extends Controller{
    public $context;
//    public function behaviors(){
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['index'],
//                'rules' => [
//                    [
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//            ],
//        ];
//    }
    public function init() {
        parent::init();
        $this->layout   =   'public_main';
        $this->context = ['service_id' => 1, 'user' => Yii::$app->user->identity];
    }
    public function actionIndex(){
        return $this->render('index');
    }
    public function actionPreFriendlyShortLet(){
        return $this->render('pre-friendly-short-let');
    }
    public function actionHomesForShortLet(){
        return $this->render('homes-for-short-let');
    }
    public function actionInUnitLaundryShortLet(){
        return $this->render('in-unit-laundry-short-let');
    }
    
    
}