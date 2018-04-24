<?php

namespace frontend\controllers;
use Yii;
use yii\filters\AccessControl;
use yii\web\Response;
use common\models\User;
use common\models\Buyer;
use common\models\SocialMediaLink;
use common\models\UserConfig;
use common\models\AboutBuyer;

use yii\helpers\StringHelper;

use common\models\BuyerWorkSheet;

class BuyerController extends \yii\web\Controller
{ 
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['dashboard', 'index', 'profile', 'about'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionDashboard() {
        $userId = Yii::$app->user->id;
        $model = new User();
        return $this->render('dashboard', ['model' => $model]);
    }
    
    public function actionProfile() { //echo 33;
        $userId                     =   Yii::$app->user->id;
        $workFeatureArr             =   [];
        $workAmenitieArr            =   [];
        $workPropertyTypeArr        =   [];
        $model                      =   Buyer::findOne($userId);
        $buyerSocialMediaModel      =   array();
        if(empty($model)){
            return false;
        }
        $buyerSocialModel               =  $model->buyerSocialMedias;
        $workSheet                      = BuyerWorkSheet::findOne(['user_id' => $model->id]);
        if(empty($workSheet)){
            $workSheet                  =   new BuyerWorkSheet();
        }
       
        if(is_array($buyerSocialModel) && count($buyerSocialModel) > 0){
            foreach($buyerSocialModel as $socialKey => $socialVal){
                $buyerSocialMediaModel[$socialVal->name]['url'] = $socialVal->url;
            }
        }
        //\yii\helpers\VarDumper::dump($workSheetFeatures,4,12); exit;
        return $this->render('profile', [
            'model'                     => $model,
            'buyerSocialMediaModel'     => $buyerSocialMediaModel,
            'workSheet'                 => $workSheet,
            'workFeatureArr'            => $workFeatureArr,
            'workAmenitieArr'           => $workAmenitieArr,
            'workPropertyTypeArr'       => $workPropertyTypeArr,
            ]
        );
    }
    public function actionAbout(){
        $userId         = Yii::$app->user->id;
        $model          = AboutBuyer::find()->where(['user_id' => $userId])->one();
        //\yii\helpers\VarDumper::dump($model);
        if(empty($model)){
            $model          = new AboutBuyer();
        }
        return $this->render('about', [
            'model'                     => $model,
            ]
        );
    }
    public function actionUpdateAbout(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $userId                     = Yii::$app->user->id;
        $model                      = new AboutBuyer();
        $model->user_id             = $userId; 
        $aboutModel                 = AboutBuyer::find()->where(['user_id' => $userId])->one();
        //\yii\helpers\VarDumper::dump($aboutModel); exit;
        if(!empty($aboutModel)){
            $aboutModel->delete();
        }
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                return ['success' => true,'message' => 'Your About has been Updated successfully'];
            }else{
                return ['success' => false,'errors' => $model->errors];
            }
        }else{
            return ['success' => false,'errors' => $model->errors];
        }
    }
    
    public function actionUpdateProfile(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $userId                     = Yii::$app->user->id;
        $model                      = Buyer::findOne($userId);
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                UserConfig::deleteAll(['user_id' => $userId, 'key' => 'profileSetup']);
                return ['success' => true,'message' => 'Your profile Updated successfully'];
            }else{
                return ['success' => false,'errors' => $model->errors];
            }
        }else{
            return ['success' => false,'errors' => $model->errors];
        }
    }
    
    public function actionUpdateAddress(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $userId                     = Yii::$app->user->id;
        $model                      = Buyer::findOne($userId);  
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                return ['success' => true,'message' => 'Your Address Updated successfully'];
               
            }else{
                return ['success' => false,'errors' => $model->errors];
            }
        }else{
            return ['success' => false,'errors' => $model->errors];
        }
    }
    public function actionManageSocial(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $userId                     = Yii::$app->user->id;
        //\yii\helpers\VarDumper::dump($userId);exit;
        $agaencySocialData          = Yii::$app->request->post('SocialMediaLink'); 
        //\yii\helpers\VarDumper::dump($agaencySocialData);exit;
        $loopCnt                    =   0;
        $saveCnt                    =   0;
        $agencyMedia                = new SocialMediaLink();
        ///\yii\helpers\VarDumper::dump($agencyMedia);exit;
        if($agencyMedia->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            SocialMediaLink::deleteAll(['model_id' => $userId,'model' => 'Buyer']);
            foreach($agaencySocialData as $socialKey => $socailVal){
                //\yii\helpers\VarDumper::dump($socailVal);exit;
                if(isset($socailVal['url']) && $socailVal['url'] !=''){
                    $loopCnt++;
                    $modelName = StringHelper::basename(Buyer::className());
                    $agencyMedia                    = new SocialMediaLink();
                    $agencyMedia->model             = $modelName;
                    $agencyMedia->model_id          = $userId;
                    $agencyMedia->name              = $socialKey;
                    $agencyMedia->url               = $socailVal['url'];
                    $agencyMedia->save();
                    $saveCnt++;
                }
            }
            //echo "<pre>"; print_r($loopCnt."++".$saveCnt); echo "<pre>"; exit;
            if($loopCnt == $saveCnt){
                $transaction->commit();
                return ['success' => true,'message' => 'Your Social Media Updated successfully'];
            }else{
               return ['success' => false,'errors' => 'Sorry, We are unable to save record']; 
            }
            
        }else{
            return ['success' => false,'errors' => $model->errors];
        }
       
    }
    public function actionCriteriaWorksheet(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $userId                     = Yii::$app->user->id;
        $loopCnt                    = 0;
        $saveCnt                    = 0;
        $workSheet = BuyerWorkSheet::findOne(['user_id' => $userId]);
        if(empty($workSheet)){
            $workSheet                  =   new BuyerWorkSheet();
            $workSheet->user_id = $userId;
        }
        if ($workSheet->load(Yii::$app->request->post()) && $workSheet->save()) {
            return ['success' => true,'message' => 'Your Work Criteria has been Updated successfully'];
        }else{
            return ['success' => false, 'errors' => $workSheet->errors];
        }
    }
    
    
    
}
