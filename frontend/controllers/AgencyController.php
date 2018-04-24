<?php

namespace frontend\controllers;
use Yii;

use yii\data\ActiveDataProvider;
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
use common\models\Property;

use common\components\MailSend;
use common\models\EmailTemplate;
use common\models\Team;
use common\models\AgentSearch;
use common\models\ReviewRating;
use common\models\Recommend;
use common\models\Question;

class AgencyController extends \yii\web\Controller
{
    public function init() {
        parent::init();
        $this->layout   =   'public_main';
    }
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['dashboard', 'index', 'profile', 'about', 'agents'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function actionDashboard() {
        $this->layout               =   'main';
        $userId                     = Yii::$app->user->id;
        $model                      = new User();
        return $this->render('dashboard', ['model' => $model]);
    }
    
    public function actionProfile() {
        $this->layout   =   'main';
        $userId         = Yii::$app->user->id;
        $brokerModel = User::findOne($userId);
        $socialMedia = array();
        $brokerSocialMedia = array();
        if($brokerModel->agency_id){
            $model          = Agency::findOne($brokerModel->agency_id);
            $social = $model->socialMedias;
            if (is_array($social) && count($social) > 0) {
                foreach ($social as $socialKey => $socialVal) {
                    $socialMedia[$socialVal->name]['url'] = $socialVal->url;
                }
            }
        }else{
            $model = new Agency();
        }
        $brokerSocial    = $brokerModel->agentSocialMedias;
        if(is_array($brokerSocial) && count($brokerSocial) > 0){
            foreach($brokerSocial as $socialKey => $socialVal){
                $brokerSocialMedia[$socialVal->name]['url'] = $socialVal->url;
            }
        }
        return $this->render('profile', [
            'model'                     => $model,
            'brokerModel'               => $brokerModel,
            'socialMedia'          => $socialMedia,
            'brokerSocialMedia'     => $brokerSocialMedia,
            ]
        );
    }
    public function actionUpdateProfile(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $userId                     = Yii::$app->user->id;
        $model                      = User::findOne($userId);
        //$team                       =  Yii::$app->request->post('Team');
        $socialMediaData          = Yii::$app->request->post('SocialMediaLink');
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                if(!empty($socialMediaData)){
                    SocialMediaLink::deleteAll(['model_id' => $model->id,'model' => 'Agency']);
                    foreach($socialMediaData as $socialKey => $socailVal){
                        if(isset($socailVal['url']) && $socailVal['url'] !=''){
                            $modelName = StringHelper::basename($model->className());
                            $agencyMedia                    = new SocialMediaLink();
                            $agencyMedia->model             = $modelName;
                            $agencyMedia->model_id          = $model->id;
                            $agencyMedia->name              = $socialKey;
                            $agencyMedia->url               = $socailVal['url'];
                            $agencyMedia->save();
                        }
                    }
                }
                UserConfig::deleteAll(['user_id' => $userId, 'key' => 'profileSetup']);
                return ['success' => true,'message' => 'Your profile Updated successfully'];
            }else{
                return ['success' => false,'errors' => $model->errors];
            }
        }else{
            return ['success' => false,'errors' => $model->errors];
        }
    }
    
    public function actionManageAgency(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $socialMediaData          = Yii::$app->request->post('SocialMediaLink'); 
        $isNew = false;
        $logoUrl = '';
        $user = Yii::$app->user->identity;
        if($user->agency_id){
                $model = $this->findModel($user->agency_id);
        }else{
                $model                      = new Agency(); 
                $isNew = true;
        }
        
        if($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if($model->save()){
                if (empty($user->agency_id)) {
                    $user->agency_id = $model->id;
                    $user->save();
                }
                if(!empty($model->imageFiles)){
                    $model->upload();
                    $logoUrl = $model->photo->imageUrl;
                }
                if(!empty($socialMediaData)){
                    SocialMediaLink::deleteAll(['model_id' => $model->id,'model' => 'Agency']);
                    foreach($socialMediaData as $socialKey => $socailVal){
                        if(isset($socailVal['url']) && $socailVal['url'] !=''){
                            $modelName = StringHelper::basename($model->className());
                            $agencyMedia                    = new SocialMediaLink();
                            $agencyMedia->model             = $modelName;
                            $agencyMedia->model_id          = $model->id;
                            $agencyMedia->name              = $socialKey;
                            $agencyMedia->url               = $socailVal['url'];
                            $agencyMedia->save();
                        }
                    }
                }
                /**
                 * Email to addmin
                 */
                $adminEmails = \yii\helpers\ArrayHelper::getColumn(\common\helpers\UserHelper::admins(), 'email');
                $ar['{{%FULL_NAME%}}']      = $user->fullName;
                $ar['{{%AGENCY_NAME%}}']    = $model->name;
                $ar['{{%AGENCY_EMAIL%}}']   = $model->email;
                if($isNew){
                    foreach ($adminEmails as $email){
                        MailSend::sendMail('AGENCY_REGISTER', $adminEmails, $ar);
                    }
                }
                UserConfig::deleteAll(['user_id' => $user->id, 'key' => 'agencySetup']);
                $transaction->commit();
                return ['success' => true, 'agency_id' => $model->id, 'logoUrl' => $logoUrl, 'message' => ($isNew?'Your Agency registered successfully':'Your Agency updated successfully')]; 
            }else{
                return ['success' => false, "message" => \Yii::t('app', "Agency form contains error(s)"), "errors" => $model->errors];
            }
        }else{
            return ['success' => false,'errors' => $model->errors];
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
    public function actionUpdateAbout(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $userId                     = Yii::$app->user->id;
        $model                      = User::findOne($userId);
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
    public function actionView($slug) {
        $propertyArr = [];
        $model = Agency::find()->where(['slug' => $slug])->one();
        if (empty($model)) {
            throw new \yii\web\NotFoundHttpException('Agency does not exists');
        }
        //$agentCnt                   =   User::find()->where(['agency_id' => $model->id])->count();
        $s_la = Yii::$app->request->get('s_la');
        $order = ["CONCAT_WS('', town, state)" => SORT_ASC];
        if ($s_la == 'area') {
            $order = ["area" => SORT_ASC];
        } elseif ($s_la == 'town') {
            $order = ["town" => SORT_ASC];
        } elseif ($s_la == 'price') {
            $order = ['price' => SORT_ASC];
        }
        $agentList = \yii\helpers\ArrayHelper::getColumn(User::find()->where(['agency_id' => $model->id])->all(), 'id');
        //print_r($agentList);die();

        $query = Property::find()->where(['user_id' => $agentList])->activeSold()->orderBy($order);
        
        $listingActivitDataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        
        return $this->render('view', [
                    'model' => $model,
                    //'agentCnt'      => $agentCnt,
                    'listingActivitDataProvider' => $listingActivitDataProvider,
                    's_la' => $s_la
                ]
        );
    }

    public function actionAgents(){
        $this->layout   =   'main';
        $user = Yii::$app->user->identity;
        $agency = $user->agency;
        $searchModel = new AgentSearch();
        $searchModel->agency_id = $agency->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('agents', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }
    
    public function actionViewAgent($id){
        $this->layout   =   'main';
        $user = Yii::$app->user->identity;
        $agency = $user->agency;
        $model = Agent::find()->where(['id' => $id, 'agency_id' => $agency->id])->one();
        if(empty($model)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $this->render('view-agent', ['model' => $model]);
    }
    
    public function actionWriteReview($id){
        if(Yii::$app->user->isGuest){ 
            Yii::$app->response->format     = Response::FORMAT_JSON;
            return ['status' => false, 'is_guest' => true, 'message' => 'You are not logged in'];
        }else{
            $reviewModel                        =   new ReviewRating();
            if ($reviewModel->load(Yii::$app->request->post())) {
                $reviewModel->user_id          = Yii::$app->user->id;
                $reviewModel->model             =   "Agency";
                Yii::$app->response->format     = Response::FORMAT_JSON;
                $reviewModel->status            = 'active';
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if($reviewModel->save()){ 
                        $transaction->commit();
                        return ['success' => true,'message' => 'Thank you for your Review'];//exit;
                    }else{
                        $transaction->rollBack();
                        //\yii\helpers\VarDumper::dump($reviewModel->errors);
                        return ['success' => false,'message' => 'Following Fileds can not be blank','errors' => $reviewModel->errors];// exit;   
                    }

                } catch (Exception $ex) {
                    $transaction->rollBack();
                }
            }
            return $this->renderAjax('write-review', [
                'reviewModel' => $reviewModel,
                'id' => $id,
                
            ]);
        }
    }
    
    public function actionRecommend($id){
        if(!Yii::$app->request->isAjax){
            return $this->goHome();
        }
        Yii::$app->response->format     = Response::FORMAT_JSON;
        if(Yii::$app->user->isGuest){
            return ['status' => false, 'is_guest' => true, 'message' => 'You are not logged in'];
        }
        $insert = false;
        $userId = Yii::$app->user->id;
        $recommendModel = Recommend::find()->where(['model' => 'Agency', 'model_id' => $id])->one();
        //\yii\helpers\VarDumper::dump($userId,4,12); exit;
        if(empty($recommendModel)){
            $model = new Recommend();
            $model->model = 'Agency';
            $model->model_id = $id;
            $model->recommend_id = $userId;
            $model->save();
            $insert = true;
        }else{
            Recommend::findOne($recommendModel->id)->delete();
        }
        return ['status' => true, 'id' => $id, 'insert' => $insert];
        
    }
    
        public function actionAskQuestion($id){
        if(Yii::$app->user->isGuest){ 
            Yii::$app->response->format     = Response::FORMAT_JSON;
            return ['status' => false, 'is_guest' => true, 'message' => 'You are not logged in'];
        }else{
            $userId                     =   Yii::$app->user->id;
            $userModel                  =   User::findOne(['id' => $userId]);
            $questioModel   =   new Question();
            if ($questioModel->load(Yii::$app->request->post())) {
                $questioModel->ask_by = Yii::$app->user->id;
                Yii::$app->response->format     = Response::FORMAT_JSON;
                $questioModel->status = 'active';
//                \yii\helpers\VarDumper::dump($questioModel->user->email,12,1); exit;
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if($questioModel->save()){ 
                        $template = EmailTemplate::findOne(['code' => 'ASK_QUESTION_ADMIN']);
//                        print_r($questioModel->agency->operator->fullName);die();
                        $operator = $questioModel->agency->operator;
                        $adminEmail                             = $operator->email;
                        $arr['{{%AGENT_NAME%}}']                 = $operator->fullName;
                        $arr['{{%FULL_NAME%}}']                 = $questioModel->name;
                        $arr['{{%EMAIL%}}']                     = $questioModel->email;
                        $arr['{{%MOBILE%}}']                    = $questioModel->mobile;
                        $arr['{{%DESCRIPTION%}}']               = $questioModel->description;
                        
//                        \yii\helpers\VarDumper::dump($arr,4,12); //exit;
                        MailSend::sendMail('ASK_QUESTION_ADMIN', $adminEmail, $arr);
                        
                        $template = EmailTemplate::findOne(['code' => 'ASK_QUESTION_USER']);
                        $ar['{{%FULL_NAME%}}']                  = $questioModel->name;
                        $ar['{{%AGENT_NAME%}}']                 = $questioModel->agency->operator->fullName;
                        
//                        \yii\helpers\VarDumper::dump($ar,4,12); exit;
                        MailSend::sendMail('ASK_QUESTION_USER', $questioModel->email, $ar);
                        $transaction->commit();
                        return ['success' => true,'message' => 'You successfully messaged your selected agents. Expect a response soon!'];//exit;
                    }else{
                        $transaction->rollBack();
                        //\yii\helpers\VarDumper::dump($questioModel->errors);
                        return ['success' => false,'message' => 'Following Fileds can not be blank','errors' => $questioModel->errors];// exit;   
                    }

                } catch (Exception $ex) {
                    $transaction->rollBack();
                }
            }
            return $this->renderAjax('ask-question', [
                'questioModel'  =>  $questioModel,
                'id'            =>  $id,
                'userModel'     =>  $userModel,
            ]);
        }
    }
    
    public function actionSearchByNameJson(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $search = Yii::$app->request->get('search');
        $term = $search['term'];
        if($term){
            $offices = Agency::find()->select(['name', 'agencyID'])->where(['LIKE', 'name', '%'. $term. '%', false])->active()->all();
            if(!empty($offices)){
                $rs = [];
                foreach ($offices as $office){
                    $rs[] = ['id' => $office->name, 'text' => $office->name. ' ('. $office->agencyID. ')'];
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
            $offices = Agency::find()->select(['name', 'agencyID'])->where(['LIKE', 'agencyID', '%'. $term. '%', false])->andWhere($parentWhere)->active()->all();
            if(!empty($offices)){
                $rs = [];
                foreach ($offices as $office){
                    $rs[] = ['id' => $office->agencyID, 'text' => $office->agencyID. ' ('. $office->name. ')'];
                }
                return ['results' => $rs];
            }
        }
        return ['results' => []];
    }
    
    public function actionPopulateChildrenByNameJson(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $nameStr = Yii::$app->request->post('name');
        $id = substr($nameStr, -9, 8);
        if($id){
            $office = Agency::find()->select(['name', 'agencyID', 'state', 'town', 'area', 'zip_code'])->where(['agencyID' => $id])->active()->one();
            if(!empty($office)){
                return ['result' => ['id' => $office->agencyID, 'name' => $office->name, 'text' => $office->agencyID. ' ('. $office->name. ')', 'address' => ['state' => $office->state, 'town' => $office->town, 'area' => $office->area, 'zip_code' => $office->zip_code]]];
            }
        }
        return ['result' => []];
    }
    
    public function actionPopulateChildrenByIdJson(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        if($id){
            $office = Agency::find()->select(['name', 'agencyID', 'state', 'town', 'area', 'zip_code'])->where(['agencyID' => $id])->active()->one();
            if(!empty($office)){
                return ['result' => ['id' => $office->agencyID, 'name' => $office->name, 'text' => $office->name. ' ('. $office->agencyID. ')', 'address' => ['state' => $office->state, 'town' => $office->town, 'area' => $office->area, 'zip_code' => $office->zip_code]]];
            }
        }
        return ['result' => []];
    }

    
    protected function findModel($id)
    {
        if (($roomModel = Agency::findOne($id)) !== null) {
            return $roomModel;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
        
    protected function findBySlug($slug)
    {
        if (($model = Agency::findOne(['slug' => $slug])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
