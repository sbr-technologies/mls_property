<?php

namespace frontend\controllers;
use Yii;

use yii\filters\AccessControl;
use yii\web\Response;
use common\models\User;
use common\models\Agency;
use common\models\AgencySearch;
use common\models\Agent;
use common\models\SocialMediaLink;
use common\models\UserConfig;
use common\models\PhotoGallery;
use yii\web\UploadedFile;
use yii\helpers\StringHelper;
use common\models\Team;

use common\components\MailSend;
use common\components\Sms;
use common\models\EmailTemplate;

class AgentController extends \yii\web\Controller
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
        $model          = Agent::findOne($userId);
        $agencyModel    = Agency::findOne($model->agency_id);
        $agentSocialMediaModel = array(); 
        $socialMediaModel = array(); 

        if ($model->agency_id) {
            $agencyModel = Agency::findOne($model->agency_id);
            $socialModel = $agencyModel->socialMedias;
            if (!empty($socialModel)) {
                foreach ($socialModel as $socialKey => $socialVal) {
                    $socialMediaModel[$socialVal->name]['url'] = $socialVal->url;
                }
            }
        } else {
            $agencyModel = new Agency();
        }

        $agentSocialModel = $model->agentSocialMedias;
//        print_r($agentSocialModel);
//        die();
        if (!empty($agentSocialModel)) {
            foreach ($agentSocialModel as $socialKey => $socialVal) {
                $agentSocialMediaModel[$socialVal->name]['url'] = $socialVal->url;
            }
        }

        //\yii\helpers\VarDumper::dump($model); exit;
        return $this->render('profile', [
            'model'                     => $model,
            'agencyModel'               => $agencyModel,
            'socialMediaModel'          => $socialMediaModel,
            'agentSocialMediaModel'     => $agentSocialMediaModel,
            ]
        );
    }
    public function actionAbout(){
        $userId         = Yii::$app->user->id;
        $model          = Agent::findOne($userId);
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
        $model                      = Agent::findOne($userId);
        if ($model->load(Yii::$app->request->post())) {
           //\yii\helpers\VarDumper::dump($model); exit;
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
        $result     = '';
        $photo      = '';
        $media      = '';
        $finalTeamArr = [];
        $imageUrl   =   Yii::getAlias('@web/public_main/images/noimage.jpg');
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $agencyId = Yii::$app->request->get('agency_id');
//            $teamModel   =  new Team();
            $agencyModel = Agency::findOne($agencyId);
            if(!empty($agencyModel->teams)){
                foreach($agencyModel->teams as $team){
                    $finalTeamArr[$team->id] = [$team->name];
                }
            }
           // \yii\helpers\VarDumper::dump(json_encode($finalTeamArr),4,12);exit;
            if(empty($agencyModel)){
                return ['success' => false];
            }
            $socialMediaModel = $agencyModel->socialMedias;
            if(isset($agencyModel->photos[0])){
                $photo  =   $agencyModel->photos[0];
                $imageUrl   =   $photo->getImageUrl(PhotoGallery::THUMBNAIL);
            }
            if(isset($socialMediaModel)){
                $media  =   $socialMediaModel;
            }
        }
        $result = [ 'agency_data' => [
                                'id'                        => $agencyModel->id, 
                                'agencyID'                  => $agencyModel->agencyID, 
                                'value'                     => $agencyModel->name, 
                                'owner_name'                => $agencyModel->owner_name, 
                                'tagline'                   => $agencyModel->tagline,
                                'address1'                  => $agencyModel->street_address,
                                'address2'                  => $agencyModel->street_number, 
                                'country'                   => $agencyModel->country,
                                'state'                     => $agencyModel->state, 
                                'city'                      => $agencyModel->town, 
                                'zip_code'                  => $agencyModel->zip_code,
                                'about'                     => $agencyModel->about,
                                'agency_photo'              => $photo,
                                'calling_code'              => $agencyModel->calling_code,
                                'email'                     => $agencyModel->email,
                                'mobile'                    => $agencyModel->mobile1,
                                'calling_code_fax'          => $agencyModel->calling_code2,
                                'fax'                       => $agencyModel->fax1,
                                'calling_code_mobile2'      => $agencyModel->calling_code3,
                                'mobile2'                   => $agencyModel->mobile2,
                                'calling_code_mobile3'      => $agencyModel->calling_code4,
                                'mobile3'                   => $agencyModel->mobile3,
                                'web_address'               => $agencyModel->web_address,
                                'imageUrl'                  => $imageUrl,
                            ],
                    'social_media'  => $media,
                    'finalTeamJson' => $finalTeamArr,
                ];
           // \yii\helpers\VarDumper::dump($result,4,12); exit;
        return $result;
    }
    
    public function actionUpdateProfile(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $userId                     = Yii::$app->user->id;
        $model                      = Agent::findOne($userId);
        $team                       =  Yii::$app->request->post('Team');
        
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
        $model                      = Agent::findOne($userId);  
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
        $agentTeam                  = Yii::$app->request->post('Agent'); 
        $loopCnt                    = 0;
        $saveCnt                    = 0;
        $id                         = $agencyData['id'];
        $logoUrl = '';
        if(isset($id) && $id != ''){ 
            $model                  = Agency::findOne($id);
            $loopCnt++;
            $user                   =   User::findOne($userId);
            $user->agency_id        =   $id;
            if(!empty($agentTeam)){
                $user->team_id         =  $agentTeam['team_id']; 

            }
            $user->save();
            $saveCnt++;
            if ($model->load(Yii::$app->request->post())) {
                $transaction = Yii::$app->db->beginTransaction();
                $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
                
                if($model->save()){
                    if(!empty($model->imageFiles)){
                        $model->upload(true);
                    }
                    
                    if(!empty($model->photo)){
                        $logoUrl = $model->photo->imageUrl;
                    }
                    
//                    \yii\helpers\VarDumper::dump($agaencySocialData, 4,12); exit;
                    if(!empty($agaencySocialData)){
                        SocialMediaLink::deleteAll(['model_id' => $id,'model' => 'Agency']);
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
                    }
                    if($loopCnt == $saveCnt){
                        $transaction->commit();
                        return ['success' => true, 'agency_id' => $model->id, 'logoUrl' => $logoUrl, 'message' => 'Your Agency Updated successfully']; 
                    }else{
                       return ['success' => false,'errors' => 'Sorry, We are unable to save record'];
                    }

                }else{
                    return ['success' => false,'errors' => $model->errors,'social_errors' => ''];
                }
            }else{
                return ['success' => false,'errors' => $model->errors]; 
            }
        }else{
            $model                      = new Agency(); 
            if($model->load(Yii::$app->request->post())) {
                $transaction = Yii::$app->db->beginTransaction();
                $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
                if($model->save()){
                    if(!empty($model->imageFiles)){
                        $model->upload();
                    }
                    
                    if (!empty($model->photo)) {
                        $logoUrl = $model->photo->imageUrl;
                    }
//                    \yii\helpers\VarDumper::dump($agaencySocialData, 4,12); exit;
                    if(!empty($agaencySocialData)){
                        SocialMediaLink::deleteAll(['model_id' => $id,'model' => 'Agency']);
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
                    }
                    $loopCnt++;
                        $user                   =   User::findOne($userId);
                        $user->agency_id        =   $model->id;
                        $user->team_id          =   1;
                        $user->save();
                    $saveCnt++;
                    
                    if($loopCnt == $saveCnt){
                        /**
                         * Email to addmin
                         */
                        $adminEmails = \yii\helpers\ArrayHelper::getColumn(\common\helpers\UserHelper::admins(), 'email');
                        $template = EmailTemplate::findOne(['code' => 'AGENCY_REGISTER']);
                        $ar['{{%FULL_NAME%}}']      = $user->fullName;
                        $ar['{{%AGENCY_NAME%}}']    = $model->name;
                        $ar['{{%AGENCY_EMAIL%}}']   = $model->email;
//                        \yii\helpers\VarDumper::dump($adminEmails); exit;
                        foreach ($adminEmails as $email){
                            MailSend::sendMail('AGENCY_REGISTER', $adminEmails, $ar);
                        }
                        $transaction->commit();
                        return ['success' => true, 'agency_id' => $model->id, 'message' => 'Your Agency registered successfully']; 
                    }else{
                       return ['success' => false,'errors' => 'Sorry, We are unable to save record'];  
                    }
                }else{
                    return ['success' => false, "message" => \Yii::t('app', "Agency form contains error(s)"), "errors" => $model->errors];
                }
            }else{
                return ['success' => false,'errors' => $model->errors];
            }
        }
    }
    public function actionDeletePhoto($id){
        $photo = PhotoGallery::findOne($id);
        if($photo->delete()){
            echo json_encode(array('status' => 'success', 'message' => 'One image delete successfully'));die();
        }else{
            echo json_encode(array('status' => 'failed', 'message' =>'Sorry, We are unable to process your data'));die();
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
            SocialMediaLink::deleteAll(['model_id' => $userId,'model' => 'Agent']);
            foreach($agaencySocialData as $socialKey => $socailVal){
                //\yii\helpers\VarDumper::dump($socailVal);exit;
                if(isset($socailVal['url']) && $socailVal['url'] !=''){
                    $loopCnt++;
                    $modelName = StringHelper::basename(Agent::className());
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
    
    public function actionTeamlisting(){
        $this->layout   =   'ajax';
        $userId     = Yii::$app->user->id;
        $model      = User::find()->where(['id' => $userId])->one();
        Yii::$app->response->format = Response::FORMAT_JSON;
        $result = [];
        if(!empty($model) && $model->team_id != null){          
            $result = ['value' => $model->team->name];
        }else{
            $result = ['value' => ''];
        }
        return $this->render('teamlisting', ['result' => $result]);
    }
    
    public function actionSearchByNameJson(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $search = Yii::$app->request->get('search');
        $term = $search['term'];
        if($term){
            $agents = Agent::find()->select(['first_name', 'middle_name', 'last_name', 'profile_id', 'agentID'])->where(['LIKE', "CONCAT_WS('',first_name,middle_name,last_name)", '%'. $term. '%', false])->active()->all();
            if(!empty($agents)){
                $rs = [];
                foreach ($agents as $agent){
                    $rs[] = ['id' => $agent->commonName, 'text' => $agent->commonName. ' ('. $agent->agentID. ')'];
                }
                return ['results' => $rs];
            }
        }
        return ['results' => []];
    }
    
    public function actionSearchByNameIdJson(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $search = Yii::$app->request->get('search');
        $parent = Yii::$app->request->get('parent');
        $term = $search['term'];
        $parentWhere = [];
        if($term){
            if($parent){
                $parentWhere = ['LIKE', 'name', '%'. $parent. '%', false];
            }
            $agents = Agent::find()->select(['first_name', 'middle_name', 'last_name', 'profile_id', 'agentID'])->where(['LIKE', 'agentID', '%'. $term. '%', false])->andWhere($parentWhere)->active()->all();
            if(!empty($agents)){
                $rs = [];
                foreach ($agents as $agent){
                    $rs[] = ['id' => $agent->agentID, 'name' => $agent->commonName, 'text' => $agent->agentID. ' ('. $agent->commonName. ')'];
                }
                return ['results' => $rs];
            }
        }
        return ['results' => []];
    }
    
    public function actionPopulateChildrenByNameJson(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $nameStr = Yii::$app->request->post('name');
        $id = substr($nameStr, -10, 9);
        $teamData = ['name' => '', 'id' => ''];
        $officeData = ['name' => '', 'id' => '', 'address' => ['state' => '', 'town' => '', 'area' => '', 'zip_code' => '']];
        if($id){
            $agent = Agent::find()->with('agency')->with('team')->where(['agentID' => $id])->active()->one();
            if(!empty($agent)){
                if($agent->agency_id){
                    $office = $agent->agency;
                    $officeData = ['name' => $office->name, 'id' => $office->agencyID, 'address' => ['state' => $office->state, 'town' => $office->town, 'area' => $office->area, 'zip_code' => $office->zip_code]];
                }
                if($agent->team_id){
                    $team = $agent->team;
                    $teamData = ['name' => $team->name, 'id' => $team->teamID];
                }
                return ['result' => ['id' => $agent->agentID, 'name' => $agent->commonName, 'text' => $agent->agentID. ' ('. $agent->commonName. ')', 'address' => ['state' => $agent->state, 'town' => $agent->town, 'area' => $agent->area, 'zip_code' => $agent->zip_code], 'office' => $officeData, 'team' => $teamData]];
            }
        }
        return ['result' => []];
    }
    
    public function actionPopulateChildrenByIdJson(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        $officeData = ['name' => '', 'id' => '', 'address' => ['state' => '', 'town' => '', 'area' => '', 'zip_code' => '']];
        $teamData = ['name' => '', 'id' => ''];
        if($id){
            $agent = Agent::find()->with('agency')->where(['agentID' => $id])->active()->one();
            if(!empty($agent)){
                if($agent->agency_id){
                    $office = $agent->agency;
                    $officeData = ['name' => $office->name, 'id' => $office->agencyID, 'address' => ['state' => $office->state, 'town' => $office->town, 'area' => $office->area, 'zip_code' => $office->zip_code]];
                }
                if($agent->team_id){
                    $team = $agent->team;
                    $teamData = ['name' => $team->name, 'id' => $team->teamID];
                }
                return ['result' => ['id' => $agent->agentID, 'name' => $agent->commonName, 'text' => $agent->commonName. ' ('. $agent->agentID. ')', 'address' => ['state' => $agent->state, 'town' => $agent->town, 'area' => $agent->area, 'zip_code' => $agent->zip_code], 'office' => $officeData, 'team' => $teamData]];
            }
        }
        return ['result' => []];
    }
    
    public function actionDetailJson(){
        $userId             = Yii::$app->request->get('user_id');
        $model          =   User::findOne($userId);
        Yii::$app->response->format = Response::FORMAT_JSON;
        if(empty($model)){
            throw new \yii\web\NotFoundHttpException('Agent does not exist');
        }
        $result = [
            'status' => true,
            'agent_data' => [
                'agent_id' => $model->agentID,
                'salutation' => $model->salutation,
                'first_name' => $model->first_name,
                'middle_name' => $model->middle_name,
                'last_name' => $model->last_name,
                'short_name' => $model->short_name,
                'gender' => $model->gender,
                'birthday' => $model->birthday,
                'timezone' => $model->timezone,
                'email' => $model->email,
                'short_name' => $model->short_name,
                'occupation' => $model->occupation,
                'calling_code' => $model->calling_code,
                'calling_code2' => $model->calling_code2,
                'calling_code3' => $model->calling_code3,
                'calling_code4' => $model->calling_code4,
                'mobile1' => $model->mobile1,
                'mobile2' => $model->mobile2,
                'mobile3' => $model->mobile3,
                'mobile4' => $model->mobile4,
                'office1' => $model->office1,
                'office2' => $model->office2,
                'office3' => $model->office3,
                'office4' => $model->office4,
                'fax1' => $model->fax1,
                'fax2' => $model->fax2,
                'fax3' => $model->fax3,
                'fax4' => $model->fax4,
            ]
        ];
        return $result;
    }
    
    public function actionViewAddress(){
        $userId             = Yii::$app->request->get('user_id');
        $index             = Yii::$app->request->get('index');
        $model          =   User::findOne($userId);
        return $this->renderAjax('address_fields', ['model' => $model, 'index' => $index]);
    }
    
}
