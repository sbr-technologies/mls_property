<?php

namespace frontend\controllers;
use Yii;

use yii\web\Response;
use common\models\User;
use common\models\Agency;
use common\models\AgencySearch;
use common\models\HotelOwner;
use common\models\SocialMediaLink;
use common\models\UserConfig;


use yii\helpers\StringHelper;

class HotelOwnerController extends \yii\web\Controller
{ 
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
        $model          = HotelOwner::findOne($userId);
        $agentSocialMediaModel = array(); 
        if(empty($model)){
            return false;
        }
        if($model->agency_id){
            $agencyModel    = Agency::findOne($model->agency_id);
            $agentSocialModel    = $model->agentSocialMedias;
            if(is_array($agentSocialModel) && count($agentSocialModel) > 0){
                foreach($agentSocialModel as $socialKey => $socialVal){
                    $agentSocialMediaModel[$socialVal->name]['url'] = $socialVal->url;
                }
            }
        }else{
            $agencyModel    = new Agency();
            
        }
        
        if(empty($agencyModel)){
            $socialMediaModel = array();
        }
        $socialModel = $agencyModel->socialMedias;
        if(is_array($socialModel) && count($socialModel) > 0){
            foreach($socialModel as $socialKey => $socialVal){
                $socialMediaModel[$socialVal->name]['url'] = $socialVal->url;
            }
        }else{
           $socialMediaModel = array(); 
        }
          
        //\yii\helpers\VarDumper::dump($agentSocialMediaModel); exit;
        return $this->render('profile', [
            'model'                     => $model,
            'agencyModel'               => $agencyModel,
            'socialMediaModel'          => $socialMediaModel,
            'agentSocialMediaModel'     => $agentSocialMediaModel
            ]
        );
    }
    public function actionAbout(){
        $userId         = Yii::$app->user->id;
        $model          = HotelOwner::findOne($userId);
        if(empty($model)){
            return false;
        }
        //\yii\helpers\VarDumper::dump($agentSocialMediaModel); exit;
        return $this->render('about', [
            'model'                     => $model,
            ]
        );
    }
    public function actionUpdateAbout(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $userId                     = Yii::$app->user->id;
        $model                      = HotelOwner::findOne($userId);
        if ($model->load(Yii::$app->request->post())) {
           // \yii\helpers\VarDumper::dump($model); exit;
            if($model->save()){
                return ['success' => true,'message' => 'Your About Updated successfully'];
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
        $model                      = HotelOwner::findOne($userId);
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
        $model                      = HotelOwner::findOne($userId);  
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
    
    public function actionManageAgency(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $userId                     = Yii::$app->user->id;
        $agencyData                 = Yii::$app->request->post('Agency');
        $agaencySocialData          = Yii::$app->request->post('SocialMediaLink'); 
        $loopCnt                    =   0;
        $saveCnt                    =   0;
        $id                         = $agencyData['id'];
        if(isset($id) && $id != ''){
            $model                  = Agency::findOne($id);
            if ($model->load(Yii::$app->request->post())) {
                $transaction = Yii::$app->db->beginTransaction();
                if($model->save()){
                    foreach($agaencySocialData as $socialKey => $socailVal){
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
//                    echo "<pre>"; print_r($loopCnt."++".$saveCnt); echo "<pre>"; exit;
                    if($loopCnt == $saveCnt){
                        $transaction->commit();
                        return ['success' => true,'message' => 'Your Agency Updated successfully'];
                    }else{
                       return ['success' => false,'errors' => 'Sorry, We are unable to save record']; 
                    }

                }else{
                    return ['success' => false,'errors' => $model->errors,'social_errors' => $socialModel->errors];
                }
            }else{
                return ['success' => false,'errors' => $model->errors];
            }
        }else{
            $model                      = new Agency(); 
            if($model->load(Yii::$app->request->post())) {
                $transaction = Yii::$app->db->beginTransaction();
                if($model->save()){
                    foreach($agaencySocialData as $socialKey => $socailVal){
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
            SocialMediaLink::deleteAll(['model_id' => $userId,'model' => 'HotelOwner']);
            foreach($agaencySocialData as $socialKey => $socailVal){
                //\yii\helpers\VarDumper::dump($socailVal);exit;
                if(isset($socailVal['url']) && $socailVal['url'] !=''){
                    $loopCnt++;
                    $modelName = StringHelper::basename(HotelOwner::className());
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
