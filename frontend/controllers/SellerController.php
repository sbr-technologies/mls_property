<?php

namespace frontend\controllers;
use Yii;
use yii\filters\AccessControl;
use yii\web\Response;
use common\models\User;
use common\models\Agency;
use common\models\AgencySearch;
use common\models\Seller;
use common\models\SocialMediaLink;
use common\models\UserConfig;
use common\models\SellerCompany;
use common\models\AboutSeller;

use yii\helpers\StringHelper;

class SellerController extends \yii\web\Controller
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
    
    public function actionProfile() { 
        $userId         = Yii::$app->user->id;
        $model          = Seller::findOne($userId);
        
        $sellerCompanyModelArr  =   array();
        $sellerSocialMediaModel = array(); 
        if(empty($model)){
            return false;
        }
        $sellerSocialModel    = $model->sellerSocialMedias;
        
        if(is_array($sellerSocialModel) && count($sellerSocialModel) > 0){
            foreach($sellerSocialModel as $socialKey => $socialVal){
                $sellerSocialMediaModel[$socialVal->name]['url'] = $socialVal->url;
            }
        }
        $sellerCompanyModel     =  SellerCompany::find()->where(['user_id' => $userId])->one();
        if(!empty($sellerCompanyModel)){
            $socialModel = SocialMediaLink::find()->where(['model_id' => $sellerCompanyModel->id,'model' => 'SellerCompany'])->all();
        }else{
            $socialModel            =  new SocialMediaLink();
            $sellerCompanyModel     =   new SellerCompany();
        }
//        \yii\helpers\VarDumper::dump($socialModel,4,12);exit;
        if(isset($socialModel) && is_array($socialModel) && count($socialModel) > 0){
            foreach($socialModel as $socialKey => $socialVal){
                $socialMediaModel[$socialVal->name]['url'] = $socialVal->url;
            }
        }else{
           $socialMediaModel = array(); 
        }
        return $this->render('profile', [
            'model'                     => $model,
            'sellerCompanyModel'        => $sellerCompanyModel,
            'socialMediaModel'          => $socialMediaModel,
            'sellerSocialMediaModel'    => $sellerSocialMediaModel
            ]
        );
    }
    public function actionAbout(){
        $userId         = Yii::$app->user->id;
        $model          = AboutSeller::find()->where(['user_id' => $userId])->one();
        //\yii\helpers\VarDumper::dump($model);
        if(empty($model)){
            $model          = new AboutSeller();
        }
        return $this->render('about', [
            'model'                     => $model,
            ]
        );
    }
    public function actionUpdateAbout(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $userId                     = Yii::$app->user->id;
        $model                      = new AboutSeller();
        $model->user_id             = $userId; 
        $aboutModel                 = AboutSeller::find()->where(['user_id' => $userId])->one();
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
    public function actionAgencies(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        //return ['success' => 'abcd']; 
        $agencyModel = new AgencySearch();
        $agencyModel->searchstring = Yii::$app->request->get('q');
        $agencyDataProvider = $agencyModel->search(Yii::$app->request->queryParams);
        
        $result = [];
        foreach ($agencyDataProvider->getModels() as $agency){
           $result[] = ['id' => $agency->id, 'value' => $agency->name];
        }
        return $result;
    }
    
    public function actionAgencyDetails(){
        $result = '';
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $agencyId = Yii::$app->request->get('agency_id');
            $agencyModel = Agency::findOne($agencyId);
            if(empty($agencyModel)){
                return ['success' => false];
            }
            $socialMediaModel = $agencyModel->socialMedias;
        }
        $result = ['agency_data' => ['id' => $agencyModel->id, 'value' => $agencyModel->name, 'owner_name' => $agencyModel->owner_name, 
               'tagline' => $agencyModel->tagline, 'address1' => $agencyModel->address1, 'address2' => $agencyModel->address2, 
               'country' => $agencyModel->country, 'state' => $agencyModel->state, 'city' => $agencyModel->city, 'zip_code' => $agencyModel->zip_code],
            'social_media' => $socialMediaModel];
        
        return $result;
    }
    
    public function actionUpdateProfile(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $userId                     = Yii::$app->user->id;
        $model                      = Seller::findOne($userId);
        //\yii\helpers\VarDumper::dump($model);exit;
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
        $model                      = Seller::findOne($userId);  
        
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
    
    public function actionManageCompany(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $userId                     = Yii::$app->user->id;
        $sellerCompanyData          = Yii::$app->request->post('SellerCompany');
        $sellerSocialData           = Yii::$app->request->post('SocialMediaLink');
        $loopCnt                    =   0;
        $saveCnt                    =   0;
        $id                         = $sellerCompanyData['id'];
        if(isset($id) && $id != ''){
            $model                  = SellerCompany::findOne($id);
            if ($model->load(Yii::$app->request->post())) {
                $transaction = Yii::$app->db->beginTransaction();
                $model->user_id     =   $userId;
                if($model->save()){
                    SocialMediaLink::deleteAll(['model_id' => $id,'model' => 'SellerCompany']);
                    foreach($sellerSocialData as $socialKey => $socailVal){
                        if(isset($socailVal['url']) && $socailVal['url'] !=''){
                            $loopCnt++;
                            $modelName = StringHelper::basename($model->className());
                            $agencyMedia                    = new SocialMediaLink();
                            $agencyMedia->model             = $modelName;
                            $agencyMedia->model_id          = $model->id;
                            $agencyMedia->name              = $socialKey;
                            $agencyMedia->url               = $socailVal['url'];
                            $agencyMedia->save();
                            $saveCnt++;
                        }
                    }
                    if($loopCnt == $saveCnt){
                        $transaction->commit();
                        return ['success' => true,'message' => 'Your Company Updated successfully'];
                    }else{
                       return ['success' => false,'errors' => 'Sorry, We are unable to save record']; 
                    }

                }else{
                    return ['success' => false,'errors' => $model->errors];
                }
            }else{
                return ['success' => false,'errors' => $model->errors];
            }
        }else{
            $model                      = new SellerCompany(); 
            if($model->load(Yii::$app->request->post())) {
                $transaction = Yii::$app->db->beginTransaction();
                $model->user_id     =   $userId;
//                \yii\helpers\VarDumper::dump($model);exit;
                if($model->save()){
                    foreach($sellerSocialData as $socialKey => $socailVal){
                        if(isset($socailVal['url']) && $socailVal['url'] !=''){
                            $loopCnt++;
                            $modelName = StringHelper::basename($model->className());
                            $agencyMedia                    = new SocialMediaLink();
                            $agencyMedia->model             = $modelName;
                            $agencyMedia->model_id          = $model->id;
                            $agencyMedia->name              = $socialKey;
                            $agencyMedia->url               = $socailVal['url'];
                            $agencyMedia->save();
                            $saveCnt++;
                        }
                    }
                    //echo "<pre>"; print_r($loopCnt."++".$saveCnt); echo "<pre>"; exit;
                    if($loopCnt == $saveCnt){
                        $transaction->commit();
                        return ['success' => true,'message' => 'Your Agency Updated successfully'];
                    }else{
                       return ['success' => false,'errors' => 'Sorry, We are unable to save record']; 
                    }
                }else{
                    return ['success' => false,'errors' => $model->errors];
                }
            }else{
                return ['success' => false,'errors' => $model->errors];
            }
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
            SocialMediaLink::deleteAll(['model_id' => $userId,'model' => 'Seller']);
            foreach($agaencySocialData as $socialKey => $socailVal){
                //\yii\helpers\VarDumper::dump($socailVal);exit;
                if(isset($socailVal['url']) && $socailVal['url'] !=''){
                    $loopCnt++;
                    $modelName = StringHelper::basename(Seller::className());
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
}
