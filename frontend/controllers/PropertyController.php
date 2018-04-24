<?php

namespace frontend\controllers;

use Yii;
use yii\base\Exception;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\helpers\StringHelper;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

use frontend\helpers\PropertyHelper;
use frontend\helpers\AuthHelper;
use common\models\MetaTag;
use common\models\PropertyLocationLocalInfo;
use common\models\PropertyFactInfo;
use common\models\SocialMediaLink;
use common\models\Property;
use common\models\PropertySearch;
use common\models\PropertyShowingRequest;
use common\models\PropertyTaxHistory;
use common\models\PropertyPriceHistory;
use common\models\PropertyEnquiery;
use common\models\OpenHouse;
use common\models\PropertyFeature;
use common\models\PropertyFeatureItem;
use common\models\PhotoGallery;
use common\models\UserFavorite;
use common\models\PropertyRequest;
use common\models\User;
use common\models\UserConfig;
use common\models\PropertyShowingRequestSearch;
use common\models\PropertyShowingRequestFeedback;
use common\models\PropertyShowingRequestFeedbackSearch;
use common\models\ContactAgent;
use common\models\ContactAgentSearch;
use common\models\RentalExtension;
use common\models\PropertyGeneralFeature;
use common\models\NewsletterEmailSubscriber;
use common\models\PropertyContact;
use common\models\GeneralFeatureMaster;
use common\models\PropertyType;
use common\models\Attachment;
use common\models\UserSearch;
use common\models\Agency;
use common\models\PropertyShowingContact;
use common\models\PropertyRequestSearch;
use kartik\mpdf\Pdf;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\Agent;
use common\models\SavedSearch;

use common\components\MailSend;
use common\components\Sms;
use common\models\EmailTemplate;
use common\models\PropertyApartment;


class PropertyController extends Controller{
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public $context;
    
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'index', 'update', 'details', 'delete','sell','rent','short-let','duplicate','copy','request-showing','favourite-property', 'requested-property', 'request', 'send-request-showing', 'renew'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
    public function beforeAction($action) {
        if($this->action->id == 'request'){
            Yii::$app->session->set('_redirect_url', Url::to(['property/request']));
        }
        return parent::beforeAction($action);
    }

        public function init() {
        parent::init();
        $this->context = ['service_id' => 1, 'user' => Yii::$app->user->identity];
    }
    public function actionIndex(){
        $this->layout   =   'main';
        $searchModel = new PropertySearch();
        $user = Yii::$app->user->identity;
        if(AuthHelper::is('agency')){
            $agency = $user->agency;
            $agents = ArrayHelper::getColumn(Agent::find()->where(['agency_id' => $agency->id])->all(), 'id');
            if(!empty($agents)){
                $searchModel->user_id = $agents;
            }else{
                $searchModel->user_id = [0];
            }
        }else{
            $searchModel->user_id = $user->id;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
        
    }
    public function actionSell(){
        $this->layout   =   'main';
        $searchModel = new PropertySearch();
        $searchModel->categoryName = 'Sale';
        $user = Yii::$app->user->identity;
        if(AuthHelper::is('agency')){
            $agency = $user->agency;
            $agents = ArrayHelper::getColumn(Agent::find()->where(['agency_id' => $agency->id])->all(), 'id');
            if(!empty($agents)){
                $searchModel->user_id = $agents;
            }else{
                $searchModel->user_id = [0];
            }
        }else{
            $searchModel->user_id = $user->id;
        }
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('sell', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
    }
    public function actionRent(){
        $this->layout   =   'main';
        $searchModel = new PropertySearch();
        $searchModel->categoryName = 'Rent';
        $user = Yii::$app->user->identity;
        if(AuthHelper::is('agency')){
            $agency = $user->agency;
            $agents = ArrayHelper::getColumn(Agent::find()->where(['agency_id' => $agency->id])->all(), 'id');
            if(!empty($agents)){
                $searchModel->user_id = $agents;
            }else{
                $searchModel->user_id = [0];
            }
        }else{
            $searchModel->user_id = $user->id;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('rent', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
    }
    public function actionShortLet(){
        $this->layout   =   'main';
        $searchModel = new PropertySearch();
//        $searchModel->property_category_id = 3;
        $searchModel->categoryName = 'Short Let';
        $user = Yii::$app->user->identity;
        if(AuthHelper::is('agency')){
            $agency = $user->agency;
            $agents = ArrayHelper::getColumn(Agent::find()->where(['agency_id' => $agency->id])->all(), 'id');
            if(!empty($agents)){
                $searchModel->user_id = $agents;
            }else{
                $searchModel->user_id = [0];
            }
        }else{
            $searchModel->user_id = $user->id;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('short-let', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
    }
    public function actionPropertyTypeList(){
        $this->layout       =   'ajax';
        $model              =   new Property();
        if(Yii::$app->request->isAjax){
            $finalArray = [];
            $categoryId = Yii::$app->request->get('selected_id');
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->render('property-type-list', [
                'categoryId'        => $categoryId,
                'model'            => $model
            ]);
        }
    }
    public function actionPriceForList(){
        $this->layout       =   'ajax';
        $model              =   new Property();
        if(Yii::$app->request->isAjax){
            $finalArray = [];
            $categoryId = Yii::$app->request->get('selected_id');
            //\yii\helpers\VarDumper::dump($categoryId); exit;
            if($categoryId == 1){
                $finalArray = ['Per Annum' => 'Per Annum','Per Square Meter/Per Annum' => 'Per Square Meter/Per Annum','Per Square Foot/Per Annum' => 'Per Square Foot/Per Annum'];
            }elseif($categoryId == 3){
                $finalArray =  ['Per Month' => 'Per Month','Per Week' => 'Per Week','Per Day' => 'Per Day'];
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->render('price-for-list', [
                'output'            => $finalArray,
                'model'            => $model
            ]);
            //return [];
        }
    }
    public function actionServiceForList(){
        $this->layout       =   'ajax';
        $model              =   new Property();
        if(Yii::$app->request->isAjax){
            $finalArray = [];
            $categoryId = Yii::$app->request->get('selected_id');
            //\yii\helpers\VarDumper::dump($categoryId); exit;
            if($categoryId == 1){
                $finalArray = ['Per Annum' => 'Per Annum','Per Square Meter/Per Annum' => 'Per Square Meter/Per Annum','Per Square Foot/Per Annum' => 'Per Square Foot/Per Annum'];
            }elseif($categoryId == 3){
                $finalArray =  ['Per Month' => 'Per Month','Per Week' => 'Per Week','Per Day' => 'Per Day'];
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->render('service-for-list', [
                'output'            => $finalArray,
                'model'            => $model
            ]);
            //return [];
        }
    }
    public function actionOtherForList(){
        $this->layout       =   'ajax';
        $model              =   new Property();
        if(Yii::$app->request->isAjax){
            $finalArray = [];
            $categoryId = Yii::$app->request->get('selected_id');
            //\yii\helpers\VarDumper::dump($categoryId); exit;
            if($categoryId == 1){
                $finalArray = ['Per Annum' => 'Per Annum','Per Square Meter/Per Annum' => 'Per Square Meter/Per Annum','Per Square Foot/Per Annum' => 'Per Square Foot/Per Annum'];
            }elseif($categoryId == 3){
                $finalArray =  ['Per Month' => 'Per Month','Per Week' => 'Per Week','Per Day' => 'Per Day'];
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->render('other-for-list', [
                'output'            => $finalArray,
                'model'            => $model
            ]);
            //return [];
        }
    }
    public function actionContactTermList(){
        $this->layout       =   'ajax';
        $model              =   new Property();
        if(Yii::$app->request->isAjax){
            $finalArray     =   [];
            $contractArr    =   [];
            $categoryId     =   Yii::$app->request->get('selected_id');
            //\yii\helpers\VarDumper::dump($categoryId); exit;
            if($categoryId == 1){ 
                $finalArray = ['None' => 'None','1 Year' => '1 Year','2 Years' => '2 Years','3 Years' => '3 Years','4 Years' => '4 Years','5 Years' => '5 Years+'];
            }else if($categoryId == 3){
                $finalArray = ['None' => 'None','1 Month+' => '1 Month+','1 Month' => '1 Month','1 Week' => '1 Week','1 Day' => '1 Day'];
            }
            
            
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->render('contact-term-list', [
                'output'            => $finalArray,
                'model'            => $model,
            ]);
        }
    }
    public function actionOrderedImageList(){
        $this->layout       =   'ajax';
        $loopCnt            =   0;
        $saveCnt            =   0;
        $postData           =   json_decode(file_get_contents('php://input'), true);
        //\yii\helpers\VarDumper::dump($postData);  exit;
        if(!empty($postData['formData'])){
            foreach($postData['formData'] as $picCapKey => $picCapVal){
//                \yii\helpers\VarDumper::dump($picCapVal); echo 11;exit;
                $propertyId     =   $picCapVal['property_id'];
                $loopCnt++;
                if($picCapVal['sort'] != ''){
                    $picCapVal['sort'] = $picCapVal['sort'];
                }else{
                    $picCapVal['sort'] = 999;
                }
                $photoGallery                  =    PhotoGallery::find()->where(['id' => $picCapVal['id']])->one();
                $photoGallery->sort_order      =   $picCapVal['sort'];
                $photoGallery->description     =   $picCapVal['title'];
                $photoGallery->save();
                $saveCnt++;
            }
            //\yii\helpers\VarDumper::dump($loopCnt."++".$saveCnt); exit;
            if($loopCnt == $saveCnt){
                return $this->renderAjax('ordered-image-list', [
                    'propertyId'        =>  $propertyId,
                    'update'            =>  true,
                ]);
            }
        }
        
    }
    public function actionSaveCaption(){
        $attachment                     =   new Attachment();
        $formData                       =   Yii::$app->request->post('formData');
        //\yii\helpers\VarDumper::dump($formData); exit;
        $description                    =   Yii::$app->request->post('description');
        $attachment                     =   Attachment::findOne($id);
        $transaction                    = Yii::$app->db->beginTransaction();
        Yii::$app->response->format     = Response::FORMAT_JSON;
        
        $attachment->description        =  $description;

        try {
            if($attachment->save()){
                $transaction->commit();
                return ['success' => true,'message' => 'Your caption saved successfully'];
            }else{
                return ['success' => false,'errors' => $attachment->errors];
            }

        } catch (Exception $ex) {
            $transaction->rollBack();
        }
    }
    public function actionAgent(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        //return ['success' => 'abcd']; 
        $userModel = new UserSearch();
        $userModel->profile_id = 5;
        $userModel->keyword = Yii::$app->request->get('q');
        $userDataProvider = $userModel->search(Yii::$app->request->queryParams);
        
        $result = [];
        foreach ($userDataProvider->getModels() as $user){
           $result[] = ['id' => $user->id, 'value' => $user->first_name." ".$user->middle_name." ".$user->last_name];
        }
        return $result;
    }
    public function actionAgentDetails(){
        $result                 =   '';
        $userAgencyId           =   '';
        $userFullName           =   '';
        $userAgentId            =   '';
        $agencyId               =   '';
        $userEmail              =   '';
        $userMobile             =   ''; 
        $userOffice             =   ''; 
        $userFax                =   '';
        $userAddress            =   '';
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $userId             = Yii::$app->request->get('user_id');
            $userModel          =   User::findOne($userId);
            //\yii\helpers\VarDumper::dump($userModel,4,12);exit;
            if(!empty($userModel)){
                $userAgencyId   =   $userModel->agency_id;
                $userFullName   =   $userModel->first_name." ".$userModel->middle_name." ".$userModel->last_name;
                $userAgentId    =   $userModel->agentID;
                $userAddress    =   $userModel->formattedAddress;
                $userEmail      =   $userModel->email;
                $userMobile     =   $userModel->mobile1; 
                $userOffice     =   $userModel->office1; 
                $userFax        =   $userModel->fax1; 
            }
            $agencyModel        = Agency::findOne($userAgencyId);
            if(!empty($agencyModel)){
                $agencyId       =   $agencyModel->agencyID;
            }
        }
        
        $result             =   ['agency_data' => [
                                                //'id'                        => $agencyModel->id, 
                                                'agencyID'                  => $agencyId, 
                                                'fullname'                  => $userFullName, 
                                                'agentId'                   => $userAgentId,
                                                'userEmail'                 => $userEmail,             
                                                'userMobile'                => $userMobile,
                                                'userOffice'                => $userOffice,
                                                'userFax'                   => $userFax,
                                                'userAddress'               => $userAddress,
                                                'test'                      => 'test Data',
                                                ]
                                        ];
        return $result;
    }
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionCreate(){
        if(!PropertyHelper::canList($this->context)){
            throw new \yii\web\UnauthorizedHttpException('You are not subscribed for this');
        }
        $parentId = Yii::$app->request->get('parent_id');
        $this->layout                   =   'main';
        $model                          = new Property(['scenario' => 'prop']);
        $localInfoModel                 = [new PropertyLocationLocalInfo()];
        $metaTagModel                   = new MetaTag();
        $taxHistoryModel                = [new PropertyTaxHistory()]; 
        $priceHistory                   = new PropertyPriceHistory();
        $openHouseModel                 = new OpenHouse(); 
        $featureModel                   = [new PropertyFeature()];
        $featureItemModel               = [new PropertyFeatureItem()];
        $genralFeatureModel             = new PropertyGeneralFeature();
        $contactProperty                = new PropertyContact();
        $propertyShowingContact         = new PropertyShowingContact();
        $loopCnt                        =   0;
        $saveCnt                        =   0;
        $incomplete     =   Yii::$app->request->post('Property');
        $genralFeatures = [];
        
        $contactModel = new \common\models\Contact();
        
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format     = Response::FORMAT_JSON;
            if(!PropertyHelper::createVerified($model, $this->context)){
                return ['success' => false, 'message' => 'You are not subscribed for this'];
            }
            $user = Yii::$app->user->identity;
            if (!AuthHelper::is('agency')) {
                $model->user_id = $user->id;
            }

            if(isset($incomplete['save_incomplete']) && $incomplete['save_incomplete'] == 1){
                $model->status = 'draft';
            }else{
               $model->status = 'active'; 
            }
            if($model->is_seller_information_show){
                $model->market_status = Property::MARKET_NOTACTIVE;
            }
            $transaction = Yii::$app->db->beginTransaction();
            //\yii\helpers\VarDumper::dump($model); exit;
            if($parentId){
                $parentData = Property::find()->where(['id' => $parentId])->asArray()->one();
                $model->assignAttributes($parentData);
                $model->is_multi_units_apt = 1;
                $model->parent_id = $parentData['id'];
            }
            try {
                $loopCnt++;
                if($model->save()){
                    $saveCnt++;
                }else{
                    return ['success' => false,'errors' => $model->errors];
                }
                $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
                if(!empty($model->imageFiles)){
                    //$loopCnt++;
                    if($model->upload()){ //echo 55;
                       //$saveCnt++; 
                    }
                }
                //echo "<pre>"; print_r($loopCnt."++".$saveCnt); echo "<pre>"; exit;
                $model->documentFiles = UploadedFile::getInstances($model, 'documentFiles');
                //\yii\helpers\VarDumper::dump($model->documentFiles); exit;
                if(!empty($model->documentFiles)){
                    //$loopCnt++;
                    if($model->uploadFile()){
                        //$saveCnt++; 
                    }
                }
                
                if(isset($_POST['PropertyLocationLocalInfo']) && is_array($_POST['PropertyLocationLocalInfo']) && count($_POST['PropertyLocationLocalInfo']) > 0){
                    foreach($_POST['PropertyLocationLocalInfo'] as $propertyLocation){
                        $loopCnt++;
                        $localInfoModel                 = new PropertyLocationLocalInfo();
                        $localInfoModel->property_id    = $model->id;
                        $localInfoModel->local_info_type_id = $propertyLocation['local_info_type_id'];
                        $localInfoModel->title          = $propertyLocation['title'];
                        $localInfoModel->description    = $propertyLocation['description'];
                        $localInfoModel->location            = $propertyLocation['location'];
                        $localInfoModel->lat            = $propertyLocation['lat'];
                        $localInfoModel->lng            = $propertyLocation['lng'];
                        if($localInfoModel->save()){
                            $saveCnt++; 
                        }
                        
                    }
                }
                if(isset($_POST['PropertyGeneralFeature']) && is_array($_POST['PropertyGeneralFeature']) && count($_POST['PropertyGeneralFeature']) > 0){
                    foreach($_POST['PropertyGeneralFeature'] as $key => $generalInfo){

                        if(!empty($generalInfo)){
                            foreach($generalInfo as $val){
                                $loopCnt++;
                                $genralFeature                  = new PropertyGeneralFeature();
                                $genralFeature->property_id     = $model->id;
                                $genralFeature->general_feature_master_id  = $val;
                                if($genralFeature->save()){
                                    $saveCnt++; 
                                }
                            }  
                        }
                    }
                }
                
                if(isset($_POST['MetaTag']) && is_array($_POST['MetaTag']) && count($_POST['MetaTag']) > 0){
                    $loopCnt++;
                    $modelName = StringHelper::basename($model->className());
                    $metaTagModel                   = new MetaTag();
                    $metaTagModel->model            = $modelName;
                    $metaTagModel->model_id         = $model->id;
                    $metaTagModel->page_title       = $_POST['MetaTag']['page_title'];
                    $metaTagModel->description      = $_POST['MetaTag']['description'];
                    $metaTagModel->keywords         = $_POST['MetaTag']['keywords'];
                    if($metaTagModel->save()){
                        $saveCnt++; 
                    }
                }
                if(isset($_POST['SocialMediaLink']) && is_array($_POST['SocialMediaLink']) && count($_POST['SocialMediaLink']) > 0){
                    foreach($_POST['SocialMediaLink'] as $socialKey => $socailVal){
                        if(isset($socailVal['url']) && $socailVal['url'] !=''){
                            $loopCnt++;
                            $modelName = StringHelper::basename(Property::className());
                            $agencyMedia                    = new SocialMediaLink();
                            $agencyMedia->model             = $modelName;
                            $agencyMedia->model_id          = $model->id;
                            $agencyMedia->name              = $socialKey;
                            $agencyMedia->url               = $socailVal['url'];
                            if($agencyMedia->save()){
                                $saveCnt++; 
                            }
                        }
                    }
                }
                if(isset($_POST['PropertyTaxHistory']) && is_array($_POST['PropertyTaxHistory']) && count($_POST['PropertyTaxHistory']) > 0){
                    foreach($_POST['PropertyTaxHistory'] as $taxHistory){
                        $loopCnt++;
                        $taxHistoryModel                  = new PropertyTaxHistory();
                        $taxHistoryModel->property_id     = $model->id;
                        $taxHistoryModel->year            = $taxHistory['year'];
                        $taxHistoryModel->taxes           = $taxHistory['taxes'];
                        if($taxHistoryModel->save()){
                            $saveCnt++; 
                        }
                    }
                }
                //\yii\helpers\VarDumper::dump($_POST['OpenHouse']); exit;
                if(isset($_POST['OpenHouse']) && is_array($_POST['OpenHouse']) && count($_POST['OpenHouse']) > 0){
                    $loopCnt++;
                    $modelName                          = StringHelper::basename($model->className());
                    $openHouseModel                     = new OpenHouse();
                    $openHouseModel->model              = $modelName;
                    $openHouseModel->model_id           = $model->id;
                    $openHouseModel->startdate          = $_POST['OpenHouse']['startdate'];
                    $openHouseModel->enddate            = $_POST['OpenHouse']['enddate'];
                    $openHouseModel->starttime          = $_POST['OpenHouse']['starttime'];
                    $openHouseModel->endtime            = $_POST['OpenHouse']['endtime'];
                    if($openHouseModel->save()){
                        $saveCnt++; 
                    }

                }

                if(isset($_POST['PropertyFeature']) && is_array($_POST['PropertyFeature']) && count($_POST['PropertyFeature']) > 0){
                    foreach ($_POST['PropertyFeature'] as $i => $feature) {

                        if(!empty($feature['feature_master_id'])){
			   $loopCnt++;
                            $featureModel = new PropertyFeature();
                            $featureModel->property_id = $model->id;
                            $featureModel->feature_master_id = $feature['feature_master_id'];
                            $featureModel->imageFiles = UploadedFile::getInstances($featureModel, "[$i]imageFiles");
                            if($featureModel->save()){
                                $saveCnt++; 
                                if (!empty($featureModel->imageFiles)) {
                                    $featureModel->upload();
                                }

                                if(!empty($_POST['PropertyFeatureItem'][$i])){
                                    foreach ($_POST['PropertyFeatureItem'][$i] as $item) {
                                        if(!empty($item['name'])){
                                            $loopCnt++;
                                            $itemModel = new PropertyFeatureItem(); //instantiate new PropertyFeature model
                                            $itemModel->property_feature_id = $featureModel->id;
                                            $itemModel->name = $item['name'];
                                            $itemModel->size = $item['size'];
                                            $itemModel->description = $item['description'];
                                            if($itemModel->save()){
                                                $saveCnt++; 
                                               // \yii\helpers\VarDumper::dump($itemModel->errors);
                                            }
                                        }
                                    }
                                }
                            }else{
                               \yii\helpers\VarDumper::dump($featureModel->errors); 
                            }
                        }
                    }
                }
                //echo "<pre>"; print_r($loopCnt."++".$saveCnt); echo "<pre>"; exit;
                //\yii\helpers\VarDumper::dump($_POST['PropertyContact'],14,1); exit;
                if(isset($_POST['PropertyContact']) && is_array($_POST['PropertyContact']) && count($_POST['PropertyContact']) > 0){
                    foreach ($_POST['PropertyContact'] as $contactKey => $contactInfo) {
                        foreach($contactInfo as $i => $contact){
                            if($i == 0){
                                $property_contact_for   =   $contact['property_contact_for'];
                            }elseif($i > 0){
                                if($property_contact_for != ''){
                                    if(isset($contact['value']) && $contact['value'] != ''){
                                        $loopCnt++;
                                        $contactProperty                  = new PropertyContact(); //instantiate new PropertyFeature model
                                        $contactProperty->property_id     = $model->id;
                                        $contactProperty->property_contact_for = $property_contact_for;
                                        $contactProperty->type            = $contact['type'];
                                        $contactProperty->value           = $contact['value'];
                                        $contactProperty->flag            = $contactKey;
                                        if($contactProperty->save()){
                                            $saveCnt++; 
                                        }else{
                                            \yii\helpers\VarDumper::dump($contactProperty->errors); exit;
                                        }
                                    }
                                }
                            }
                        }
                        
                    }//exit;
                }
                
                
                
                    $propertyContact = Yii::$app->request->post('Contact');
                    $property_contact = Yii::$app->request->post('property_contact');
//                    print_r($propertyContact);die();
                    if(!empty($propertyContact)){
                        foreach ($propertyContact as $contactKey => $contactData) {
                            if((isset($property_contact[$contactKey]['agent_id']) && $property_contact[$contactKey]['agent_id']) || ($contactData['first_name'] && $contactData['last_name'])){
                                $contactModel = \common\models\Contact::findOne($contactData['id']);
                                if(empty($contactModel)){
                                    $contactModel = new \common\models\Contact();
                                    $contactModel->property_id = $model->id;
                                    if(isset($contactData['type']) && $contactData['type']){
                                        $contactModel->type = $contactData['type'];
                                    }
                                }
                                if(isset($property_contact[$contactKey]['agent_id']) && $property_contact[$contactKey]['agent_id']){
                                    $agentArray = Agent::find()->where(['agentID' => $property_contact[$contactKey]['agent_id']])->asArray()->one();
                                    if(!empty($agentArray)){
                                        $contactModel->agentID = $agentArray['agentID'];
                                        $contactModel->type = 'Buyer Agent';
                                        $contactModel->assignAttributes($agentArray);
                                    }
                                }else{
                                    $contactModel->assignAttributes($contactData);
                                }
                                if(!$contactModel->save()){
                                    print_r($contactModel->errors);die();
                                }
                            }
                        }
                    }
                
               //echo "<pre>"; print_r($loopCnt."++".$saveCnt); echo "<pre>"; 
                if(isset($_POST['PropertyShowingContact']) && is_array($_POST['PropertyShowingContact']) && count($_POST['PropertyShowingContact'])){
                    foreach($_POST['PropertyShowingContact'] as $showingContact){
                        $loopCnt++;
                            //\yii\helpers\VarDumper::dump($contact,4,12); exit;
                        $propertyShowingContact                         = new PropertyShowingContact(); //instantiate new PropertyFeature model
                        $propertyShowingContact->property_id            = $model->id;
                        $propertyShowingContact->first_name             = $showingContact['first_name'];
                        $propertyShowingContact->middle_name            = $showingContact['middle_name'];
                        $propertyShowingContact->last_name              = $showingContact['last_name'];
                        $propertyShowingContact->email                  = $showingContact['email'];
                        $propertyShowingContact->phone1                 = $showingContact['phone1'];
                        $propertyShowingContact->phone2                 = $showingContact['phone2'];
                        $propertyShowingContact->phone3                 = $showingContact['phone3'];
                        $propertyShowingContact->key_location           = $showingContact['key_location'];
                        $propertyShowingContact->showing_instruction    = $showingContact['showing_instruction'];
                        if($propertyShowingContact->save()){
                            $saveCnt++; 
                        }else{
                            \yii\helpers\VarDumper::dump($propertyShowingContact->errors); exit;
                        }
                    }
                }
                if($model->property_category_id == 1){
                    $redirectUrl    =   Url::to(['property/rent']);
                }elseif($model->property_category_id == 2){
                    $redirectUrl    =   Url::to(['property/sell']);
                }elseif($model->property_category_id == 3){
                    $redirectUrl    =   Url::to(['property/short-let']);
                }
                //echo "<pre>"; print_r($loopCnt."++".$saveCnt); echo "<pre>"; 
                if($loopCnt == $saveCnt){
                    
                    if($model->user->profile->id == 4){
                        if($model->is_seller_information_show == 1){
                            $template = EmailTemplate::findOne(['code' => 'SELLER_PROPERTY_BROKERAGE']);
                            $adminEmail                             = Yii::$app->params['adminEmail'];
                            //\yii\helpers\VarDumper::dump($adminEmail,4,12); exit;
                            $arr['{{%FULL_NAME%}}']                  = $model->user->fullName;
                            $arr['{{%PROFILE_NAME%}}']               = $model->user->profile->title;
                            $arr['{{%SELLER_NAME%}}']                = $model->user->sellerCompany->name;
                            $arr['{{%PROPERTY_REFFERENCE_ID%}}']     = $model->referenceId;
                            $arr['{{%PROPERTY_ADDRESS%}}']           = $model->formattedAddress;
                            $arr['{{%PROPERTY_CATEGORY%}}']          = $model->propertyCategory->title;
                            $arr['{{%PROPERTY_URL%}}']               = Yii::$app->urlManager->createAbsoluteUrl(['property/view', 'slug' => $model->slug]);
                            //\yii\helpers\VarDumper::dump($arr,4,12); exit;
                            MailSend::sendMail('SELLER_PROPERTY_BROKERAGE', $adminEmail, $arr);
                        }else{
                            $template = EmailTemplate::findOne(['code' => 'SELLER_PROPERTY_CREATE']);
                            $adminEmail                             = Yii::$app->params['adminEmail'];
                            $arrr['{{%FULL_NAME%}}']                  = $model->user->fullName;
                            $arrr['{{%PROFILE_NAME%}}']               = $model->user->profile->title;
                            $arrr['{{%SELLER_NAME%}}']                = $model->user->sellerCompany->name;
                            $arrr['{{%PROPERTY_REFFERENCE_ID%}}']     = $model->referenceId;
                            $arrr['{{%PROPERTY_ADDRESS%}}']           = $model->formattedAddress;
                            $arrr['{{%PROPERTY_CATEGORY%}}']          = $model->propertyCategory->title;
                            $arrr['{{%PROPERTY_URL%}}']               = Yii::$app->urlManager->createAbsoluteUrl(['property/view', 'slug' => $model->slug]);
                           // \yii\helpers\VarDumper::dump($arrr,4,12); exit;
                            MailSend::sendMail('SELLER_PROPERTY_CREATE', $adminEmail, $arrr);
                        }
                    }else{
                        $template = EmailTemplate::findOne(['code' => 'NEW_PROPERTY_CREATE']);
                        $adminEmail                             = Yii::$app->params['adminEmail'];
                        $ar['{{%FULL_NAME%}}']                  = $model->user->fullName;
                        $ar['{{%PROFILE_NAME%}}']               = $model->user->profile->title;
                        $ar['{{%AGENCY_NAME%}}']                = $model->user->agency->name;
                        $ar['{{%PROPERTY_REFFERENCE_ID%}}']     = $model->referenceId;
                        $ar['{{%PROPERTY_ADDRESS%}}']           = $model->formattedAddress;
                        $ar['{{%PROPERTY_CATEGORY%}}']          = $model->propertyCategory->title;
                        $ar['{{%PROPERTY_URL%}}']               = Yii::$app->urlManager->createAbsoluteUrl(['property/view', 'slug' => $model->slug]);
                        //\yii\helpers\VarDumper::dump($adminEmail); exit;

                        MailSend::sendMail('NEW_PROPERTY_CREATE', $adminEmail, $ar);
                    }
                    
                    /**
                     * Notify Saved List
                     */
                    
                    if (!$model->isCondo && ($model->market_status == Property::MARKET_ACTIVE || $model->market_status == Property::MARKET_PENDING || $model->market_status == Property::MARKET_SOLD)) {
                        $typeWhere = '';
                        $constWhere = '';
                        $areaWhere = '';
                        $agencyWhere = '';
                        if ($model->property_type_id) {
                            $typeIds = $model->propertyTypeId;
                            $typeWhere .= " AND(prop_types IS NULL OR";
                            foreach ($typeIds as $item) {
                                $typeWhere .= " FIND_IN_SET('" . $item . "', prop_types)>0 OR";
                            }
                            $typeWhere = substr($typeWhere, 0, -3);
                            $typeWhere .= ')';
                        }
                        if ($model->construction_status_id) {
                            $constIds = $model->constructionStatusId;
                            $constWhere .= " AND( const_statuses IS NULL OR";
                            foreach ($constIds as $item) {
                                $constWhere .= " FIND_IN_SET('" . $item . "', const_statuses)>0 OR";
                            }
                            $constWhere = substr($constWhere, 0, -3);
                            $constWhere .= ')';
                        }
                        if ($model->area) {
                            $areaWhere = " AND (area IS NULL OR FIND_IN_SET('" . $model->area . "', area)>0)";
                        }
                        $user = $model->user;
                        if ($user->agency_id) {
                            $agency = $user->agency;
                            $agencyWhere = " AND (agency_id IS NULL OR agency_id='" . $agency->agencyID . "') AND (agency_name IS NULL OR agency_name='" . $agency->name . "')";
                        }

                        $agentWhere = " AND (agent_id IS NULL OR agent_id='" . $user->agentID . "') AND (agent_name IS NULL OR agent_name='" . $user->commonName . "')";



                        $sql = "SELECT * FROM " . SavedSearch::tableName() . "WHERE `schedule` = 'asap' AND status = 'active'"
                                . " AND state like '%" . $model->state . "%' AND (town IS NULL OR FIND_IN_SET('" . $model->town . "', town)>0) $areaWhere"
                                . " AND (categories IS NULL OR FIND_IN_SET('" . $model->property_category_id . "', categories)>0) $typeWhere $constWhere AND (market_statuses IS NULL OR FIND_IN_SET('" . $model->market_status . "', market_statuses)>0)"
                                . " $agencyWhere $agentWhere";

                        $savedList = SavedSearch::findBySql($sql)->all();

                        if (!empty($savedList)) {
                            foreach ($savedList as $item) {
                                $curTime = strtotime('now');
                                $dailyTime = strtotime($item->last_alert_sent_at . ' +1 day');
                                $weeklyTime = strtotime($item->last_alert_sent_at . ' +7 days');
                                if ($item->schedule == 'daily' && $dailyTime > $curTime) {
                                    continue;
                                } elseif ($item->schedule == 'weekly' && $weeklyTime > $curTime) {
                                    continue;
                                }

                                $user = $item->user;
                                $recipients = $item->recipient;
                                if ($item->cc_self) {
                                    array_push($recipients, $user->email);
                                }
                                $itemHtml = '<ul>';
                                $searchArray = json_decode($item->search_string);
                                foreach ($searchArray->filters as $key => $filter) {
                                    if (!empty($filter)) {
                                        $itemHtml .= '<li><strong>' . SavedSearch::formattedFilter($key) . ':</strong> ' . SavedSearch::RelatedValue($key, $filter) . '</li>';
                                    }
                                }

                                $itemHtml .= '</ul>';

                                if (!empty($recipients)) {
                                    $vars = [];
                                    $vars['{{%USER_NAME%}}'] = $user->commonName;
                                    $vars['{{%CRITERIA%}}'] = $itemHtml;
                                    $vars['{{%SEARCH_NAME%}}'] = $item->name;
                                    $vars['{{%MESSAGE%}}'] = $item->message;
                                    $vars['{{%SEARCH_LINK%}}'] = $item->searchUrl;

                                    $thumb = $this->renderPartial('//shared/thumb', ['model' => $model]);
                                    $vars['{{%PROPERTY_THUMBS%}}'] = $thumb;
                                    
                                    $savedSearchModel = SavedSearch::findOne($item->id);
                                    $savedSearchModel->last_alert_sent_at = $curTime;
                                    $savedSearchModel->save();
                                    foreach ($recipients as $recipient) {
                                        MailSend::sendMail('SAVED_PROPERTY_ALERT', $recipient, $vars);
                                    }
                                }
                            }
                        }
                    }

                    /**
                     * Saved End
                     */
                    
                    $transaction->commit();
                    return ['success' => true,'message' => 'Your Property has been Added successfully','redirectUrl' => $redirectUrl];
                }
            } catch (Exception $ex) {
                $transaction->rollBack();
                return ['success' => false,'message' => 'Error in saving Property'. $ex->getMessage()];
            }
        }
        
        if($parentId){
            $parentModel = $this->findModel($parentId);
            $model->setAttributes($parentModel->attributes);
            $model->parent_id = $parentId;
            $model->expiredDate = $parentModel->expiredDate;
            $model->appartment_unit = '';
            $model->house_size = '';
            $model->no_of_room = '';
            $model->no_of_bathroom = '';
            $model->no_of_garage = '';
            $model->no_of_toilet = '';
            $model->no_of_boys_quater = '';
            $model->price = '';
            $model->sold_price = '';
            $model->tax = '';
            $model->insurance = '';
            $model->hoa_fees = '';
            $model->virtual_link = '';
            $genralFeatures = ArrayHelper::getColumn($parentModel->generalFeatures, 'id');
            $parentMetaTagModel  = MetaTag::find()->where(['model_id' => $model->id, 'model' => 'Property'])->one();
            if(!empty($parentMetaTagModel)){
                $metaTagModel = $parentMetaTagModel;
            }
        }

        return $this->render('create', [
            'model'             =>  $model,
            'localInfoModel'    =>  $localInfoModel,
//            'factInfoModel'     =>  $factInfoModel,
            'metaTagModel'      =>  $metaTagModel,
            'taxHistoryModel'   =>  $taxHistoryModel,
            'openHouseModel'    =>  $openHouseModel,
            'featureModel'      =>  $featureModel,
            'featureItemModel'  =>  $featureItemModel,
            'genralFeatureModel'     =>  $genralFeatureModel,
            'genralFeatures'     =>  $genralFeatures,
            
            'contactProperty'   =>  $contactProperty,
            'contactModel' => $contactModel,
            'propertyShowingContact'    =>  $propertyShowingContact,
        ]);
        
    }
    public function actionDetails($id){
        $this->layout           =   'main';
        $agentSocialMediaArr    =   [];
        $model                  =   Property::findOne(['id' => $id]);
        $metaTagModel           =   $model->metaTag;
        $localInfoModel         =   $model->propertyLocationLocalInfo;
        $factInfoModel          =   $model->propertyFactInfo;
        $agentSocialMediaModel  =   $model->propertySocialMedias;
        $taxHistoryModel        =   $model->propertyTaxHistories;
        $openHouseModel         =   $model->openHouses;
        $featureModel           =   $model->propertyFeatures;
        $propertyShowingContact =   $model->propertyShowingContacts;
        if(empty($propertyShowingContact)){// echo 11;
            $propertyShowingContact     =   [];
        }
        $rentalExtension    = RentalExtension::find()->where(['property_id' => $id])->one();
        if(empty($rentalExtension)){
            $rentalExtension    =   new RentalExtension();
        }
        if(!empty($agentSocialMediaModel)){
            foreach ($agentSocialMediaModel as $key => $val){
                $agentSocialMediaArr[$val['name']]    =   $val;
            }
        }
        //\yii\helpers\VarDumper::dump($propertyShowingContact,4,12);exit;
        
        return $this->render('details', [
            'model'             => $model, 
            'localInfoModel'    =>  $localInfoModel,
            'factInfoModel'     =>  $factInfoModel,
            'metaTagModel'      =>  $metaTagModel,
            'agentSocialMediaArr' =>  $agentSocialMediaArr,
            'taxHistoryModel'   =>  $taxHistoryModel,
            'openHouseModel'    =>  $openHouseModel,
            'featureModel'      =>  $featureModel,
            'rentalExtension'   =>  $rentalExtension,
            'propertyShowingContact' => $propertyShowingContact
        ]);
    }
    public function actionUpdate($id){
        $model                  = Property::findOne($id);
        if(!AuthHelper::canModify($model)){
            throw new \yii\web\UnauthorizedHttpException('You are not authorized');
        }
        $agentSocialMediaArr    =   [];
        $generalArr             =   [];
        $agentSocialMediaModel  =   $model->propertySocialMedias;
        $genralFeature          = new PropertyGeneralFeature();
        $generals               =   $model->generalFeatures;
        $contactModels        = \common\models\Contact::find()->where(['property_id' => $id])->all();
        foreach($generals as $general){
            $generalArr[]         =   $general->id;
        }
       // \yii\helpers\VarDumper::dump($contactProperty,4,12); exit;
        if(!empty($agentSocialMediaModel)){
            foreach ($agentSocialMediaModel as $key => $val){
                $agentSocialMediaArr[$val['name']]    =   $val;
            }
        }
        $contactModel = new \common\models\Contact();
        $contactModel->scenario = 'propertyContact';
        //\yii\helpers\VarDumper::dump($agentSocialMediaArr);exit;
        $oldMarketStatus = $model->market_status;
        $localInfoModel = PropertyLocationLocalInfo::findAll(['property_id' => $model->id]);
        $factInfoModel = PropertyFactInfo::findAll(['property_id' => $model->id]);
        $metaTagModel  = MetaTag::find()->where(['model_id' => $model->id, 'model' => StringHelper::basename($model->className())])->one();
        if(empty($metaTagModel)){
            $metaTagModel = new MetaTag();
        }
        $taxHistoryModel    = PropertyTaxHistory::findAll(['property_id' => $model->id]);
        $openHouseModel     = OpenHouse::find()->where(['model_id' => $model->id, 'model' => StringHelper::basename($model->className())])->one();
        $featureModel       = PropertyFeature::findAll(['property_id' => $id]);
        $propertyfeature    = $model->propertyFeatures;
        if(empty($openHouseModel)){
            $openHouseModel             = new OpenHouse();
        }
        $propertyShowingContact         =   $model->propertyShowingContacts;
        if(empty($propertyShowingContact)){// echo 11;
            $propertyShowingContact     =   new PropertyShowingContact();
        }
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format     = Response::FORMAT_JSON;
            if(!PropertyHelper::updateVerified($model, $this->context)) {
                return ['success' => false, 'message' => 'You are not subscribed for this'];
            }
            if($oldMarketStatus != Property::MARKET_ACTIVE && $model->market_status == Property::MARKET_ACTIVE && $model->is_seller_information_show){
                $model->market_status = Property::MARKET_NOTACTIVE;
            }
            $model->status = 'active'; 
            $model->rem_sent_at = strtotime('now');
            $transaction = Yii::$app->db->beginTransaction();
           //try {
                $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
                if($model->save()){
                    if(!empty($model->imageFiles)){
                        $model->upload();
                    }
                    if(!empty(Yii::$app->request->post('property_document'))){
                        foreach(Yii::$app->request->post('property_document') as $docCapKey => $docCapVal){
                            if($docCapVal['sort_order'] != ''){
                                $docCapVal['sort_order'] = $docCapVal['sort_order'];
                            }else{
                                $docCapVal['sort_order'] = 999;
                            }
                            $attachDoc                  = Attachment::find()->where(['id' => $docCapKey])->one();
                            $attachDoc->sort_order     =   $docCapVal['sort_order'];
                            $attachDoc->description     =   $docCapVal['description'];
                            $attachDoc->save();
                        }
                    }
                    $propertyLocalInfo = Yii::$app->request->post('PropertyLocationLocalInfo');
                    //\yii\helpers\VarDumper::dump($propertyLocalInfo); exit;
                    if(!empty($propertyLocalInfo)){
                        foreach ($propertyLocalInfo as $child) {
                            if (!empty($child['id']) && $child['_destroy'] == 1) {
                                PropertyLocationLocalInfo::findOne($child['id'])->delete();
                                continue;
                            }
                            if (!empty($child['id']) && !$child['_destroy']) {
                                $childModel = PropertyLocationLocalInfo::findOne($child['id']);
                            } elseif (empty($child['id']) && !$child['_destroy']) {
                                $childModel = new PropertyLocationLocalInfo();
                                $childModel->property_id = $model->id;
                            } elseif (empty($child['id']) && $child['_destroy'] == 1) {
                                continue;
                            }
			    $childModel->property_id	=	$model->id;
                            $childModel->local_info_type_id  = $child['local_info_type_id'];
                            $childModel->title           = $child['title'];
                            $childModel->description     = $child['description'];
                            $childModel->location            = $child['location'];
                            $childModel->lat            = $child['lat'];
                            $childModel->lng            = $child['lng'];
                            if(!$childModel->save()){
				\yii\helpers\VarDumper::dump($childModel); exit;
                            }
                        }                    
                    }
                    if(isset($_POST['PropertyGeneralFeature']) && is_array($_POST['PropertyGeneralFeature']) && count($_POST['PropertyGeneralFeature']) > 0){
                        PropertyGeneralFeature::deleteAll(['property_id' => $model->id]);
                        foreach($_POST['PropertyGeneralFeature'] as $key => $generalInfo){
                            if(!empty($generalInfo)){
                                foreach($generalInfo as $infoVal){
                                    $genralFeature                  = new PropertyGeneralFeature();
                                    $genralFeature->property_id     = $model->id;
                                    $genralFeature->general_feature_master_id  = $infoVal;
                                    $genralFeature->save();
                                }
                            }
                        }
                    }
                    if ($metaTagModel->load(Yii::$app->request->post())) {
                        if($metaTagModel->isNewRecord){
                            $metaTagModel->model = 'Property';
                            $metaTagModel->model_id = $model->id;
                        }
                        if(!$metaTagModel->save()){
                            print_r($metaTagModel->errors);die();
                        }
                    }
                    $socialMediaLinkInfo = Yii::$app->request->post('SocialMediaLink');
                    if(!empty($socialMediaLinkInfo)){
                        if(isset($socialMediaLinkInfo) && is_array($socialMediaLinkInfo) && count($socialMediaLinkInfo) > 0){
                            SocialMediaLink::deleteAll(['model_id' => $id,'model' => 'Property']);
                            foreach($socialMediaLinkInfo as $socialKey => $socailVal){
                                if(isset($socailVal['url']) && $socailVal['url'] !=''){
                                    $modelName = StringHelper::basename(Property::className());
                                    $agencyMedia                    = new SocialMediaLink();
                                    $agencyMedia->model             = $modelName;
                                    $agencyMedia->model_id          = $model->id;
                                    $agencyMedia->name              = $socialKey;
                                    $agencyMedia->url               = $socailVal['url'];
                                    if(!$agencyMedia->save()){
                                        print_r($agencyMedia->errors);die();
                                    }
                                }
                            }
                        }
                    }
                    
                    $propertyTaxHistory = Yii::$app->request->post('PropertyTaxHistory');
                    if(!empty($propertyTaxHistory)){
                        foreach ($propertyTaxHistory as $child) {
                            if (!empty($child['id']) && $child['_destroy'] == 1) {
                                PropertyTaxHistory::findOne($child['id'])->delete();
                                continue;
                            }
                            if (!empty($child['id']) && !$child['_destroy']) {
                                $childModel = PropertyTaxHistory::findOne($child['id']);
                            } elseif (empty($child['id']) && !$child['_destroy']) {
                                $childModel = new PropertyTaxHistory();
                                $childModel->property_id = $model->id;
                            } elseif (empty($child['id']) && $child['_destroy'] == 1) {
                                continue;
                            }
                            
                            $childModel->year            = $child['year'];
                            $childModel->taxes           = $child['taxes'];

                            if(!$childModel->save()){
                                print_r($childModel->errors);die();
                            }
                        }
                    }
                    
                    $openHouse = Yii::$app->request->post('OpenHouse');
                   // \yii\helpers\VarDumper::dump($openHouse,4,12); exit;
                    if(isset($openHouse) && is_array($openHouse) && count($openHouse) > 0){
                        OpenHouse::deleteAll(['model_id' => $model->id, 'model' => 'Property']);
                        $modelName                          = StringHelper::basename($model->className());
                        $openHouseModel                     = new OpenHouse();
                        $openHouseModel->model              = $modelName;
                        $openHouseModel->model_id           = $model->id;
                        $openHouseModel->startdate          = $_POST['OpenHouse']['startdate'];
                        $openHouseModel->enddate            = $_POST['OpenHouse']['enddate'];
                        $openHouseModel->starttime          = $_POST['OpenHouse']['starttime'];
                        $openHouseModel->endtime            = $_POST['OpenHouse']['endtime'];
                        $openHouseModel->save();
                        
                    }
                    $propertyFeatureModel = Yii::$app->request->post('PropertyFeature');
                    if(!empty($propertyFeatureModel)){
                        foreach ($propertyFeatureModel as $i => $feature) {
                            if (!empty($feature['id']) && isset($feature['_destroy']) && $feature['_destroy'] == 1) {
                                PropertyFeature::findOne($feature['id'])->delete();
                                PropertyFeatureItem::deleteAll(['property_feature_id' => $feature['id']]);
                                continue;
                            }
                            if (!empty($feature['id']) && isset($feature['_destroy'])) {
                                $featureModel = PropertyFeature::findOne($feature['id']);
                                //\yii\helpers\VarDumper::dump($featureModel, 4,12);
                                PropertyFeatureItem::deleteAll(['property_feature_id' => $feature['id']]);
                            } elseif (empty($feature['id']) && !$feature['_destroy']) {
                                $featureModel = new PropertyFeature();
                                $featureModel->property_id = $model->id;
                            } elseif (empty($feature['id']) && $feature['_destroy'] == 1) {
                                continue;
                            }
//                            \yii\helpers\VarDumper::dump($featureModel, 4,12);
//                            exit;
                            $featureModel->property_id = $id;
                            $featureModel->feature_master_id = $feature['feature_master_id'];
                            $featureModel->imageFiles = UploadedFile::getInstances($featureModel, "[$i]imageFiles");
                            if($featureModel->save()){
                                if (!empty($featureModel->imageFiles)) {
                                    $featureModel->upload();
                                }
                                $FeatureItemModel = Yii::$app->request->post('PropertyFeatureItem');
                                //\yii\helpers\VarDumper::dump($FeatureItemModel); exit;
                                if(!empty($_POST['PropertyFeatureItem'][$i])){
                                    PropertyFeatureItem::deleteAll(['property_feature_id' => $featureModel->id]);
                                    foreach ($_POST['PropertyFeatureItem'][$i] as $item) {
                                        if(!empty($item['name'])){
                                            $itemModel = new PropertyFeatureItem(); //instantiate new PropertyFeature model
                                            $itemModel->property_feature_id = $featureModel->id;
                                            $itemModel->name = $item['name'];
                                            $itemModel->size = $item['size'];
                                            $itemModel->description = $item['description'];
                                            if(!$itemModel->save()){
                                                \yii\helpers\VarDumper::dump($itemModel->errors);
                                            }
                                        } 
                                    }
                                }
                            }
                        }
                    }
                    
                   // \yii\helpers\VarDumper::dump($_POST['PropertyContact'],12,1); exit;
                    $propertyContact = Yii::$app->request->post('Contact');
                    $property_contact = Yii::$app->request->post('property_contact');
//                    print_r($propertyContact);die();
                    if(!empty($propertyContact)){
                        foreach ($propertyContact as $contactKey => $contactData) {
                            if((isset($property_contact[$contactKey]['agent_id']) && $property_contact[$contactKey]['agent_id']) || ($contactData['first_name'] && $contactData['last_name'])){
                                $contactModel = \common\models\Contact::findOne($contactData['id']);
                                if(empty($contactModel)){
                                    $contactModel = new \common\models\Contact();
                                    $contactModel->property_id = $model->id;
                                    if(isset($contactData['type']) && $contactData['type']){
                                        $contactModel->type = $contactData['type'];
                                    }
                                }
                                if(isset($property_contact[$contactKey]['agent_id']) && $property_contact[$contactKey]['agent_id']){
                                    $agentArray = Agent::find()->where(['agentID' => $property_contact[$contactKey]['agent_id']])->asArray()->one();
                                    if(!empty($agentArray)){
                                        $contactModel->agentID = $agentArray['agentID'];
                                        $contactModel->type = 'Buyer Agent';
                                        $contactModel->assignAttributes($agentArray);
                                    }
                                }else{
                                    $contactModel->assignAttributes($contactData);
                                }
                                if(!$contactModel->save()){
                                    print_r($contactModel->errors);die();
                                }
                            }
                        }
                    }
                    if(isset($_POST['PropertyShowingContact']) && is_array($_POST['PropertyShowingContact']) && count($_POST['PropertyShowingContact'])){
                        $propertyCnt        = PropertyShowingContact::find()->where(['property_id' => $model->id])->count();
                        if($propertyCnt != 0){
                            PropertyShowingContact::deleteAll(['property_id' => $model->id]);
                        }
                        foreach($_POST['PropertyShowingContact'] as $showingContact){
                            //$loopCnt++;
                                //\yii\helpers\VarDumper::dump($contact,4,12); exit;
                            $propertyShowingContact                         = new PropertyShowingContact(); //instantiate new PropertyFeature model
                            $propertyShowingContact->property_id            = $model->id;
                            $propertyShowingContact->first_name             = $showingContact['first_name'];
                            $propertyShowingContact->middle_name            = $showingContact['middle_name'];
                            $propertyShowingContact->last_name              = $showingContact['last_name'];
                            $propertyShowingContact->email                  = $showingContact['email'];
                            $propertyShowingContact->phone1                 = $showingContact['phone1'];
                            $propertyShowingContact->phone2                 = $showingContact['phone2'];
                            $propertyShowingContact->phone3                 = $showingContact['phone3'];
                            $propertyShowingContact->key_location           = $showingContact['key_location'];
                            $propertyShowingContact->showing_instruction    = $showingContact['showing_instruction'];
                            if($propertyShowingContact->save()){
                               // $saveCnt++; 
                            }else{
                                \yii\helpers\VarDumper::dump($propertyShowingContact->errors); exit;
                            }
                        }
                    }
                    $redirectUrl = Url::to(['property/update', 'id' => $model->id]);
                    $transaction->commit();
                    
                    /**
                     * Notify Saved Fav list
                     */
                    
                    $favList = UserFavorite::find()->where(['model' => 'Property', 'model_id' => $model->id])->all();
                    foreach ($favList as $item) {
                        $user = $item->user;
                        if ($user->email) {
                            $vars = [];
                            $thumb = $this->renderPartial('//shared/thumb', ['model' => $model]);
                            $vars['{{%USER_NAME%}}'] = $user->commonName;
                            $vars['{{%PROPERTY_THUMB%}}'] = $thumb;
                            MailSend::sendMail('FAV_PROPERTY_ALERT', $user->email, $vars);
                        }
                    }
                    /**
                     * Fav End
                     */
                    
                    /**
                     * Notify Saved List
                     */
                    
                    if ($model->market_status == Property::MARKET_ACTIVE || $model->market_status == Property::MARKET_PENDING || $model->market_status == Property::MARKET_SOLD) {
                        $typeWhere = '';
                        $constWhere = '';
                        $areaWhere = '';
                        $agencyWhere = '';
                        if ($model->property_type_id) {
                            $typeIds = $model->propertyTypeId;
                            $typeWhere .= " AND(prop_types IS NULL OR";
                            foreach ($typeIds as $item) {
                                $typeWhere .= " FIND_IN_SET('" . $item . "', prop_types)>0 OR";
                            }
                            $typeWhere = substr($typeWhere, 0, -3);
                            $typeWhere .= ')';
                        }
                        if ($model->construction_status_id) {
                            $constIds = $model->constructionStatusId;
                            $constWhere .= " AND( const_statuses IS NULL OR";
                            foreach ($constIds as $item) {
                                $constWhere .= " FIND_IN_SET('" . $item . "', const_statuses)>0 OR";
                            }
                            $constWhere = substr($constWhere, 0, -3);
                            $constWhere .= ')';
                        }
                        if ($model->area) {
                            $areaWhere = " AND (area IS NULL OR FIND_IN_SET('" . $model->area . "', area)>0)";
                        }
                        $user = $model->user;
                        if ($user->agency_id) {
                            $agency = $user->agency;
                            $agencyWhere = " AND (agency_id IS NULL OR agency_id='" . $agency->agencyID . "') AND (agency_name IS NULL OR agency_name='" . $agency->name . "')";
                        }

                        $agentWhere = " AND (agent_id IS NULL OR agent_id='" . $user->agentID . "') AND (agent_name IS NULL OR agent_name='" . $user->commonName . "')";



                        $sql = "SELECT * FROM " . SavedSearch::tableName() . "WHERE `schedule` = 'asap' AND status = 'active'"
                                . " AND state like '%" . $model->state . "%' AND (town IS NULL OR FIND_IN_SET('" . $model->town . "', town)>0) $areaWhere"
                                . " AND (categories IS NULL OR FIND_IN_SET('" . $model->property_category_id . "', categories)>0) $typeWhere $constWhere AND (market_statuses IS NULL OR FIND_IN_SET('" . $model->market_status . "', market_statuses)>0)"
                                . " $agencyWhere $agentWhere";

                        $savedList = SavedSearch::findBySql($sql)->all();

                        if (!empty($savedList)) {
                            foreach ($savedList as $item) {
                                $curTime = strtotime('now');
                                $dailyTime = strtotime($item->last_alert_sent_at . ' +1 day');
                                $weeklyTime = strtotime($item->last_alert_sent_at . ' +7 days');
                                if ($item->schedule == 'daily' && $dailyTime > $curTime) {
                                    continue;
                                } elseif ($item->schedule == 'weekly' && $weeklyTime > $curTime) {
                                    continue;
                                }

                                $user = $item->user;
                                $recipients = $item->recipient;
                                if ($item->cc_self) {
                                    array_push($recipients, $user->email);
                                }
                                $itemHtml = '<ul>';
                                $searchArray = json_decode($item->search_string);
                                foreach ($searchArray->filters as $key => $filter) {
                                    if (!empty($filter)) {
                                        $itemHtml .= '<li><strong>' . SavedSearch::formattedFilter($key) . ':</strong> ' . SavedSearch::RelatedValue($key, $filter) . '</li>';
                                    }
                                }

                                $itemHtml .= '</ul>';

                                if (!empty($recipients)) {
                                    $vars = [];
                                    $vars['{{%USER_NAME%}}'] = $user->commonName;
                                    $vars['{{%CRITERIA%}}'] = $itemHtml;
                                    $vars['{{%SEARCH_NAME%}}'] = $item->name;
                                    $vars['{{%MESSAGE%}}'] = $item->message;
                                    $vars['{{%SEARCH_LINK%}}'] = $item->searchUrl;

                                    $thumb = $this->renderPartial('//shared/thumb', ['model' => $model]);
                                    $vars['{{%PROPERTY_THUMBS%}}'] = $thumb;
                                    
                                    $savedSearchModel = SavedSearch::findOne($item->id);
                                    $savedSearchModel->last_alert_sent_at = $curTime;
                                    $savedSearchModel->save();
                                    foreach ($recipients as $recipient) {
                                        MailSend::sendMail('SAVED_PROPERTY_ALERT', $recipient, $vars);
                                    }
                                }
                            }
                        }
                    }

                    /**
                     * Saved End
                     */
                    
                    return ['success' => true,'message' => 'Your Property has been Updated successfully','redirectUrl' => $redirectUrl];
                }else{
                    return ['success' => false, 'errors' => $model->errors];
                }
                $transaction->rollBack();
        }
        
        $apartmentDataProvider = new ActiveDataProvider([
            'query' => PropertyApartment::find(),
            'sort' => [
                    'defaultOrder' => [
                        'id' => SORT_DESC
                    ]
                ],
        ]);
        
        return $this->render('update', [
            'model'             => $model, 
            'localInfoModel'    =>  $localInfoModel,
            'metaTagModel'      =>  $metaTagModel,
            'agentSocialMediaArr' =>  $agentSocialMediaArr,
            'taxHistoryModel'   =>  $taxHistoryModel,
            'openHouseModel'    =>  $openHouseModel,
            'featureModel'      =>  $featureModel,
            'genralFeature'     =>  $genralFeature,
            'generalArr'        =>  $generalArr,
            'contactModels'   =>  $contactModels,
            'propertyShowingContact' => $propertyShowingContact,
            'featureModel'      =>  $featureModel,
            'contactModel' => $contactModel,
            'apartmentDataProvider' => $apartmentDataProvider
        ]);
    }
    
    public function actionRenew($id, $cat = null){
        $model = $this->findModel($id);
        if($model->daysExpiring>30){
            Yii::$app->session->setFlash('error', 'Unable to Renew this listing');
            if($cat){
                return $this->redirect(['/property/'. $cat]);
            }else{
                return $this->redirect(['/property/update', 'id' => $id]);
            }
        }
        if($model->renew()){
            Yii::$app->session->setFlash('success', 'Successfully Renewed for 30 Days');
        }
        if($cat){
            return $this->redirect(['/property/'. $cat]);
        }else{
            return $this->redirect(['/property/update', 'id' => $id]);
        }
    }
    
    public function actionQuickRenew($key, $time){
        $now = time();
        $timePlus3days = strtotime("+3 days", $time);
        if($now > $timePlus3days){
            throw new NotFoundHttpException('Your link has been expired');
        }
        $model = Property::find()->where(['auth_key' => $key])->one();
        if(empty($model)){
            throw new NotFoundHttpException('Invalid listing');
        }
        if($model->daysExpiring>30){
            Yii::$app->session->setFlash('error', 'Unable to Renew this listing');
        }
        if($model->renew()){
            Yii::$app->session->setFlash('success', 'Successfully Renewed for 30 Days');
        }
        return $this->redirect(['/property/view', 'slug' => $model->slug]);
    }
    
    public function actionDeleteContact(){
        $contactId = Yii::$app->request->post('contact_id');
        $model = \common\models\Contact::findOne($contactId);
        $model->delete();
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['return' => true];
    }

//    public function actionContactInfoDiv(){
//        $model                =   new \common\models\Contact();
//        if(Yii::$app->request->isAjax){
//            $propertyId     =   Yii::$app->request->get('property_id');
//            $allModels    = \common\models\Contact::find()->where(['property_id' => $propertyId])->all();
//            return $this->renderAjax('contact-info-div', [
//                'allModels'   => $allModels,
//                'model'   => $model
//            ]);
//        }
//    }
    public function actionDeleteContactInfo(){
        if(Yii::$app->request->isAjax){
            $loopCnt        =   0;
            $saveCnt        =   0;
            Yii::$app->response->format     = Response::FORMAT_JSON;
            $propertyId     =   Yii::$app->request->get('property_id');
            $flag           =   Yii::$app->request->get('flag');
//            \yii\helpers\VarDumper::dump($propertyId."++".$contactFor); exit;
            $transaction = Yii::$app->db->beginTransaction();
            $contactPropertyObj        =   PropertyContact::find()->where(['property_id' => $propertyId,'flag' => $flag])->one();
            if(!empty($contactPropertyObj)){
                $loopCnt++;
                try {
                    PropertyContact::deleteAll(['property_id' => $propertyId,'flag' => $flag]);
                    $saveCnt++;
                } catch (Exception $ex) {
                    $transaction->rollBack();
                }
            }
            //echo "<pre>"; print_r($loopCnt."++".$saveCnt); echo "<pre>"; exit;
            if($loopCnt == $saveCnt){
                $transaction->commit();
                return ['success' => true,'message' => 'Your Contact info has been Deleted successfully','selectedVal' =>$propertyId];
            }else{
               $transaction->rollBack(); 
               return ['success' => true,'message' => 'Sorry, We are unable to delete','selectedVal' =>$propertyId];
            }
            
        }
    }
    public function actionDuplicate($id){
        $model                  = Property::findOne($id);
        $agentSocialMediaArr    =   [];
        $generalArr             =   [];
        $agentSocialMediaModel  =   $model->propertySocialMedias;
        $genralFeature          = new PropertyGeneralFeature();
        $generals                =   $model->generalFeatures;
        $propertyShowingContact         =   $model->propertyShowingContacts;
        if(empty($propertyShowingContact)){// echo 11;
            $propertyShowingContact     =   new PropertyShowingContact();
        }
        foreach($generals as $general){
            $generalArr[]         =   $general->id;
        }
        $contactModel = new \common\models\Contact();
//        \yii\helpers\VarDumper::dump($generalArr,4,12); exit;
        if(!empty($agentSocialMediaModel)){
            foreach ($agentSocialMediaModel as $key => $val){
                $agentSocialMediaArr[$val['name']]    =   $val;
            }
        }
        //\yii\helpers\VarDumper::dump($agentSocialMediaArr);exit;
        $model = $this->findModel($id);
        $localInfoModel = PropertyLocationLocalInfo::findAll(['property_id' => $model->id]);
        $factInfoModel = PropertyFactInfo::findAll(['property_id' => $model->id]);
        $metaTagModel  = MetaTag::find()->where(['model_id' => $model->id, 'model' => StringHelper::basename($model->className())])->one();
        $taxHistoryModel    = PropertyTaxHistory::findAll(['property_id' => $model->id]);
        $openHouseModel     = OpenHouse::find()->where(['model_id' => $model->id, 'model' => StringHelper::basename($model->className())])->one();
        $featureModel       = PropertyFeature::findAll(['property_id' => $id]);
        $propertyfeature   = $model->propertyFeatures;
        if(empty($openHouseModel)){
            $openHouseModel     = new OpenHouse();
        }
        
        return $this->render('duplicate', [
            'model'             => $model, 
            'localInfoModel'    =>  $localInfoModel,
            'factInfoModel'     =>  $factInfoModel,
            'metaTagModel'      =>  $metaTagModel,
            'agentSocialMediaArr' =>  $agentSocialMediaArr,
            'taxHistoryModel'   =>  $taxHistoryModel,
            'openHouseModel'    =>  $openHouseModel,
            'featureModel'      =>  $featureModel,
            'genralFeature'     =>  $genralFeature,
            'generalArr'        =>  $generalArr,
            'contactModel'   =>  $contactModel,
            'propertyShowingContact' => $propertyShowingContact,
        ]);
    }
    public function actionCopy(){
        $this->layout                   =   'main';
        $model                          = new Property();
        $localInfoModel                 = [new PropertyLocationLocalInfo()];
        $factInfoModel                  = [new PropertyFactInfo()];
        $metaTagModel                   = new MetaTag();
        $taxHistoryModel                = [new PropertyTaxHistory()]; 
        $priceHistory                   = new PropertyPriceHistory();
        $openHouseModel                 = new OpenHouse(); 
        $featureModel                   = [new PropertyFeature()];
        $featureItemModel               = [new PropertyFeatureItem()];
        $rentalExtension                = new RentalExtension();
        $genralFeature                  = [new PropertyGeneralFeature()];
        $loopCnt                        =   0;
        $saveCnt                        =   0;
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format     = Response::FORMAT_JSON;
            $user = Yii::$app->user->identity;
            if (!AuthHelper::is('agency')) {
                $model->user_id = $user->id;
            }
            $model->status = 'active'; 
           
            $transaction = Yii::$app->db->beginTransaction();
            //\yii\helpers\VarDumper::dump($model); exit;
            try {
                $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
                if(!$model->save()){
                    return ['success' => false,'errors' => $model->errors];
                }
                if(!empty($model->imageFiles)){
                    $model->upload();
                }
                $model->documentFiles = UploadedFile::getInstances($model, 'documentFiles');
                //\yii\helpers\VarDumper::dump($model->documentFiles); exit;
                if(!empty($model->documentFiles)){
                    $model->uploadFile();
                }
                
                if(isset($_POST['PropertyLocationLocalInfo']) && is_array($_POST['PropertyLocationLocalInfo']) && count($_POST['PropertyLocationLocalInfo']) > 0){
                    foreach($_POST['PropertyLocationLocalInfo'] as $propertyLocation){
                        $localInfoModel                 = new PropertyLocationLocalInfo();
                        $localInfoModel->property_id    = $model->id;
                        $localInfoModel->local_info_type_id = $propertyLocation['local_info_type_id'];
                        $localInfoModel->title          = $propertyLocation['title'];
                        $localInfoModel->description    = $propertyLocation['description'];
                        $localInfoModel->lat            = $propertyLocation['lat'];
                        $localInfoModel->lng            = $propertyLocation['lng'];
                        $localInfoModel->save();
                    }
                }
                
                if(isset($_POST['PropertyGeneralFeature']) && is_array($_POST['PropertyGeneralFeature']) && count($_POST['PropertyGeneralFeature']) > 0){
//                    PropertyGeneralFeature::deleteAll(['property_id' => $model->id]);
                    foreach($_POST['PropertyGeneralFeature'] as $key => $generalInfo){
                        if(!empty($generalInfo)){
                            foreach($generalInfo as $infoVal){
                                $genralFeature                  = new PropertyGeneralFeature();
                                $genralFeature->property_id     = $model->id;
                                $genralFeature->general_feature_master_id  = $infoVal;
                                $genralFeature->save();
                            }
                        }
                    }
                }
                
                if(isset($_POST['MetaTag']) && is_array($_POST['MetaTag']) && count($_POST['MetaTag']) > 0){
                    $modelName = StringHelper::basename($model->className());
                    $metaTagModel                   = new MetaTag();
                    $metaTagModel->model            = $modelName;
                    $metaTagModel->model_id         = $model->id;
                    $metaTagModel->page_title       = $_POST['MetaTag']['page_title'];
                    $metaTagModel->description      = $_POST['MetaTag']['description'];
                    $metaTagModel->keywords         = $_POST['MetaTag']['keywords'];
                    $metaTagModel->save();
                }
                if(isset($_POST['SocialMediaLink']) && is_array($_POST['SocialMediaLink']) && count($_POST['SocialMediaLink']) > 0){
                    foreach($_POST['SocialMediaLink'] as $socialKey => $socailVal){
                        if(isset($socailVal['url']) && $socailVal['url'] !=''){
                            $loopCnt++;
                            $modelName = StringHelper::basename(Property::className());
                            $agencyMedia                    = new SocialMediaLink();
                            $agencyMedia->model             = $modelName;
                            $agencyMedia->model_id          = $model->id;
                            $agencyMedia->name              = $socialKey;
                            $agencyMedia->url               = $socailVal['url'];
                            $agencyMedia->save();
                        }
                    }
                }
                if(isset($_POST['PropertyTaxHistory']) && is_array($_POST['PropertyTaxHistory']) && count($_POST['PropertyTaxHistory']) > 0){
                    foreach($_POST['PropertyTaxHistory'] as $taxHistory){
                        $taxHistoryModel                  = new PropertyTaxHistory();
                        $taxHistoryModel->property_id     = $model->id;
                        $taxHistoryModel->year            = $taxHistory['year'];
                        $taxHistoryModel->taxes           = $taxHistory['taxes'];
                        $taxHistoryModel->save();
                    }
                }
                //\yii\helpers\VarDumper::dump($_POST['OpenHouse']); exit;
                if(isset($_POST['OpenHouse']) && is_array($_POST['OpenHouse']) && count($_POST['OpenHouse']) > 0){
                    $modelName                          = StringHelper::basename($model->className());
                    $openHouseModel                     = new OpenHouse();
                    $openHouseModel->model              = $modelName;
                    $openHouseModel->model_id           = $model->id;
                    $openHouseModel->startdate          = $_POST['OpenHouse']['startdate'];
                    $openHouseModel->enddate            = $_POST['OpenHouse']['enddate'];
                    $openHouseModel->starttime          = $_POST['OpenHouse']['starttime'];
                    $openHouseModel->endtime            = $_POST['OpenHouse']['endtime'];
                    $openHouseModel->save();

                }
                
                if(isset($_POST['PropertyFeature']) && is_array($_POST['PropertyFeature']) && count($_POST['PropertyFeature']) > 0){
                    foreach ($_POST['PropertyFeature'] as $i => $feature) {
                        $featureModel = new PropertyFeature();
                        $featureModel->property_id = $model->id;
                        $featureModel->feature_master_id = $feature['feature_master_id'];
                        $featureModel->imageFiles = UploadedFile::getInstances($featureModel, "[$i]imageFiles");
                        if($featureModel->save()){
                            if (!empty($featureModel->imageFiles)) {
                                $featureModel->upload();
                            }
                        
                            if(!empty($_POST['PropertyFeatureItem'][$i])){
                                foreach ($_POST['PropertyFeatureItem'][$i] as $item) {
                                    if(!empty($item['name'])){
                                        $itemModel = new PropertyFeatureItem(); //instantiate new PropertyFeature model
                                        $itemModel->property_feature_id = $featureModel->id;
                                        $itemModel->name = $item['name'];
                                        $itemModel->size = $item['size'];
                                        $itemModel->description = $item['description'];
                                        if($itemModel->save()){
                                           // \yii\helpers\VarDumper::dump($itemModel->errors);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                    $propertyContact = Yii::$app->request->post('Contact');
                    $property_contact = Yii::$app->request->post('property_contact');
//                    print_r($propertyContact);die();
                    if(!empty($propertyContact)){
                        foreach ($propertyContact as $contactKey => $contactData) {
                            if((isset($property_contact[$contactKey]['agent_id']) && $property_contact[$contactKey]['agent_id']) || ($contactData['first_name'] && $contactData['last_name'])){
                                $contactModel = \common\models\Contact::findOne($contactData['id']);
                                if(empty($contactModel)){
                                    $contactModel = new \common\models\Contact();
                                    $contactModel->property_id = $model->id;
                                    if(isset($contactData['type']) && $contactData['type']){
                                        $contactModel->type = $contactData['type'];
                                    }
                                }
                                if(isset($property_contact[$contactKey]['agent_id']) && $property_contact[$contactKey]['agent_id']){
                                    $agentArray = Agent::find()->where(['agentID' => $property_contact[$contactKey]['agent_id']])->asArray()->one();
                                    if(!empty($agentArray)){
                                        $contactModel->agentID = $agentArray['agentID'];
                                        $contactModel->type = 'Buyer Agent';
                                        $contactModel->assignAttributes($agentArray);
                                    }
                                }else{
                                    $contactModel->assignAttributes($contactData);
                                }
                                if(!$contactModel->save()){
                                    print_r($contactModel->errors);die();
                                }
                            }
                        }
                    }                
                if(isset($_POST['PropertyShowingContact']) && is_array($_POST['PropertyShowingContact']) && count($_POST['PropertyShowingContact'])){
                    foreach($_POST['PropertyShowingContact'] as $showingContact){
                        $loopCnt++;
                            //\yii\helpers\VarDumper::dump($contact,4,12); exit;
                        $propertyShowingContact                         = new PropertyShowingContact(); //instantiate new PropertyFeature model
                        $propertyShowingContact->property_id            = $model->id;
                        $propertyShowingContact->first_name             = $showingContact['first_name'];
                        $propertyShowingContact->middle_name            = $showingContact['middle_name'];
                        $propertyShowingContact->last_name              = $showingContact['last_name'];
                        $propertyShowingContact->email                  = $showingContact['email'];
                        $propertyShowingContact->phone1                 = $showingContact['phone1'];
                        $propertyShowingContact->phone2                 = $showingContact['phone2'];
                        $propertyShowingContact->phone3                 = $showingContact['phone3'];
                        $propertyShowingContact->key_location           = $showingContact['key_location'];
                        $propertyShowingContact->showing_instruction    = $showingContact['showing_instruction'];
                        if($propertyShowingContact->save()){
                            $saveCnt++; 
                        }else{
                            \yii\helpers\VarDumper::dump($propertyShowingContact->errors); exit;
                        }
                    }
                }
                if($model->property_category_id == 1){
                    $redirectUrl    =   Url::to(['property/rent']);
                }elseif($model->property_category_id == 2){
                    $redirectUrl    =   Url::to(['property/sell']);
                }elseif($model->property_category_id == 3){
                    $redirectUrl    =   Url::to(['property/short-let']);
                }
                $transaction->commit();
                return ['success' => true,'message' => 'Your Property has been Added successfully','redirectUrl' => $redirectUrl];
                //return ['success' => true,'message' => 'Your Property has been Added successfully','redirectUrl' => Url::to(['property/index'])];
            } catch (Exception $ex) {
                $transaction->rollBack();
            }
        }
        return $this->render('copy', [
            'model'             =>  $model,
            'localInfoModel'    =>  $localInfoModel,
            'factInfoModel'     =>  $factInfoModel,
            'metaTagModel'      =>  $metaTagModel,
            'taxHistoryModel'   =>  $taxHistoryModel,
            'openHouseModel'    =>  $openHouseModel,
            'featureModel'      =>  $featureModel,
            'featureItemModel'  =>  $featureItemModel,
            'rentalExtension'   =>  $rentalExtension,
            'genralFeature'     =>  $genralFeature,
            'propertyShowingContact' => $propertyShowingContact,
        ]);
        
    }
    public function actionDelete($id){
        $model = $this->findModel($id);
        foreach ($model->photos as $photo){
            $photo->delete();
        }
        SocialMediaLink::deleteAll(['model_id' => $id,'model' => 'Property']);
        $openHouse = OpenHouse::findOne(['model_id' => $id,'model' => 'Property']);
        if(!empty($openHouse)){
            $openHouse->delete();
        }
        PropertyLocationLocalInfo::deleteAll(['property_id' => $id]);
        $propertyFact = PropertyFactInfo::findOne(['property_id' => $id]);
        if(!empty($propertyFact)){
            $propertyFact->delete();
        }
        $model->delete();
        PropertyFeature::deleteAll(['property_id' => $id]);
        Yii::$app->session->setFlash('success', 'Successfully deleted');
        //return $this->redirect(['index']);
    }
    public function actionDeletePhoto($id,$property_id){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $photo = PhotoGallery::findOne($id);
        if($photo->delete()){
            $message = "One image delete successfully";
            return ['status' => true, 'message' => $message];
        }else{
            $message = "Sorry, We are unable to process your data";
            return ['status' => false, 'message' => $message];
        } 
    }
    public function actionDeleteDocument($id,$property_id){
        $photo = Attachment::findOne($id);
        if($photo->delete()){
            Yii::$app->session->setFlash("success", "One document delete successfully");
            return $this->redirect(['update', 'id' => $property_id]);
        }else{
            Yii::$app->session->setFlash("failed", "Sorry, We are unable to process your data");
            return $this->redirect(['update', 'id' => $property_id]);
        } 
    }
    public function actionView($slug){
        $this->layout           =   'public_main';
        $propertyEnquiry        =   new PropertyEnquiery();
        $property               =   Property::findOne(['slug' => $slug]);
        $propertyUrl            =   Url::to('','http');
        if(isset(Yii::$app->user->id)){
            $userId                     =   Yii::$app->user->id;
            $userModel                  =   User::findOne(['id' => $userId]);
        }else{
            $userModel                  =   new User();
        }
        //\yii\helpers\VarDumper::dump($propertyUrl); exit;
        if(empty($property)){
            throw new NotFoundHttpException('The property does not exists');
        }
        return $this->render('view', [
            'property'          => $property, 
            'propertyEnquiry'   => $propertyEnquiry,
            'propertyUrl'       => $propertyUrl,
            'userModel'         => $userModel,
        ]);
    }
    public function actionEnquiery(){
        Yii::$app->response->format     = Response::FORMAT_JSON;
        if(Yii::$app->user->isGuest){
            return ['status' => false, 'is_guest' => true, 'message' => 'You are not logged in'];
        }
        $propertyEnquiry               = new PropertyEnquiery();
        $propertyEnquieryData   =   Yii::$app->request->post('PropertyEnquiery');
        
        if ($propertyEnquiry->load(Yii::$app->request->post())) {
            Yii::$app->response->format     = Response::FORMAT_JSON;
            $property_url               =   $propertyEnquieryData['property_url'];
            
            $property       =   Property::findOne($propertyEnquiry->model_id);
            $userMail       =   $property->user->email;
            $propertyEnquiry->assign_to = $property->user->id;
            $propertyEnquiry->status = 'pending';
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if($propertyEnquiry->save()){
                    $template = EmailTemplate::findOne(['code' => 'PROPERTY_ENQUIERY_REQUEST']);
                   // \yii\helpers\VarDumper::dump($property_url,4,12); //exit;
                    $ar['{{%FULL_NAME%}}']                  = $propertyEnquiry->property->user->fullName;
                    $ar['{{%ENQUIRY_NAME%}}']               = $propertyEnquiry->name;
                    $ar['{{%ENQUIRY_PROPERTY_REF_ID%}}']    = $propertyEnquiry->property->referenceId;
                    $ar['{{%ENQUIRY_PROPERTY_ADDRESS%}}']   = $propertyEnquiry->property->formattedAddress;
                    //$ar['{{%ENQUIRY_PROPERTY_URL%}}']       = $model->formattedAddress;
                    $ar['{{%ENQUIRY_EMAIL%}}']              = $propertyEnquiry->email;
                    $ar['{{%ENQUIRY_PHONE%}}']              = $propertyEnquiry->phone;
                    $ar['{{%ENQUIRY_MESSAGE%}}']            = $propertyEnquiry->message;
                    $ar['{{%ENQUIRY_PROPERTY_URL%}}']       = $property_url;
                   // \yii\helpers\VarDumper::dump($ar,4,12); //exit;
                    MailSend::sendSubjectMail('PROPERTY_ENQUIERY_REQUEST', $userMail, $ar,$propertyEnquiry->property->referenceId);
//                    Yii::$app
//                    ->mailer
//                    ->compose(
//                        ['html' => 'propertyEnquieryRequest-html'],
//                        ['propertyEnquiry' => $propertyEnquiry,'property_url' => $property_url]
//                    )
//                    ->setTo($userMail)
//                    ->setSubject('NaijaHouses.com Contact Message about Property ID# '.$propertyEnquiry->property->referenceId)
//                    ->send();
                    $transaction->commit();
                    return ['success' => true,'message' => 'Your Request Sent successfully'];
                }else{
                    return ['success' => false, "message" => "Enquiery form contains error(s)", "errors" => $propertyEnquiry->errors];
                }
            } catch (Exception $ex) {
                $transaction->rollBack();
            }
        }
    }
    public function actionRequest(){
        $this->layout                   =   'public_main';
        //$userId                         =   '';
        $model                          =   new PropertyRequest(['scenario' =>'captchaRequired']);
        $userModel                      =   new User();
        $propertyCategory               =   [
                                                'Rent'      =>  'Rent',
                                                'Sale'      =>  'Sale',
                                                'Short Let' =>  'Short Let',
                                                'Buy'       =>  'Buy',
                                            ];
        $model->status                  =   'pending';
        if(isset(Yii::$app->user->id)){
            $userId                     =   Yii::$app->user->id;
            $userModel                  =   User::findOne(['id' => $userId]);
        }
//        \yii\helpers\VarDumper::dump($propertyCategory,4,12); exit;
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            if(isset(Yii::$app->user->id)){
                if(!empty($_POST['Agent'])){ 
                    $userEmailData      =   $_POST['Agent']['email'];
                }else if(!empty($_POST['Buyer'])){ 
                    $userEmailData      =   $_POST['Buyer']['email'];
                }else if(!empty($_POST['Seller'])){ 
                    $userEmailData      =   $_POST['Seller']['email'];
                }else if(!empty($_POST['User'])){ 
                    $userEmailData      =   $_POST['User']['email'];
                }
                if($model->save()){
                    $template       =   EmailTemplate::findOne(['code' => 'PROPERTY_REQUEST']);
                    $adminEmail     =   Yii::$app->params['adminEmail'];
                    $ar['{{%PROPERTY_REQ_FULL_NAME%}}']         = $model->user->FullName;
                    $ar['{{%PROPERTY_REQ_EMAIL%}}']             = $model->user->emailAddress;
                    $ar['{{%PROPERTY_REQ_PHONE%}}']             = $model->user->phoneNumber;
                    $ar['{{%PROPERTY_REQ_SCHEDULE%}}']          = Yii::$app->formatter->asDate($model->schedule);
                    $ar['{{%PROPERTY_REQ_CATEGORY%}}']          = $model->property_category;
                    $ar['{{%PROPERTY_REQ_TYPE%}}']              = $model->propertyType->title;
                    $ar['{{%PROPERTY_REQ_BEDROOM_NO%}}']        = $model->no_of_bed_room;
                    $ar['{{%PROPERTY_REQ_STATE%}}']             = $model->state;
                    $ar['{{%PROPERTY_REQ_LOCALITY%}}']          = $model->locality ? $model->locality : "";
                    $ar['{{%PROPERTY_REQ_COMMENT%}}']           = $model->comment ? $model->comment : "";
                   // \yii\helpers\VarDumper::dump($ar,4,12); 
                    MailSend::sendMail('PROPERTY_REQUEST', $adminEmail, $ar);
                    $template       =   EmailTemplate::findOne(['code' => 'PROPERTY_REQUEST_USER']);
                    $arr['{{%PROPERTY_REQ_FULL_NAME%}}']         = $model->user->FullName;
                    MailSend::sendMail('PROPERTY_REQUEST_USER', $userEmailData, $arr);
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Thank you for your request. We will respond to you as soon as possible.');
                    return $this->refresh();
                }else{
                    \yii\helpers\VarDumper::dump($model->errors); exit; 
                }
            }else{
                $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
                $pass = array(); //remember to declare $pass as an array
                $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
                for ($i = 0; $i < 8; $i++) {
                    $n = rand(0, $alphaLength);
                    $pass[] = $alphabet[$n];
                }
                $randomPswd =  implode($pass); 
                if(!empty($_POST['User'])){ 
                    //\yii\helpers\VarDumper::dump($randomPswd); exit;
                    $user = new User();
                    $user->profile_id = $_POST['User']['profile_id'];
                    $user->first_name = $_POST['User']['first_name'];
                    $user->last_name = "";
                    $user->mobile1 = $_POST['User']['mobile1'];
                    $user->status = "pending";
                    $user->email = $_POST['User']['email'];
                    $user->email_activation_sent = strtotime('now'); 
                    $user->rawPassword = $randomPswd;
                    $user->setPassword($randomPswd);
                    $user->generateAuthKey();
                    $user->generateEmailActivationKey();
                    if($user->save()){
                        $userId                         = $user->id;
                        $userConfigModel                = new UserConfig();
                        $userConfigModel->user_id       = $userId;
                        $userConfigModel->title         = "User Registration";
                        $userConfigModel->type          = "system";
                        $userConfigModel->key           = "profileSetup";
                        $userConfigModel->value         = "no";
                        if($userConfigModel->save()){
                            $template       =   EmailTemplate::findOne(['code' => 'NEW_USER_EMAIL_VERIFICATION']);
                            $arrr['{{%USER_FULL_NAME%}}']            = $user->fullName;
                            $arrr['{{%EMAIL_VERIFICATION_LINK%}}']   = Yii::$app->urlManager->createAbsoluteUrl(['site/verify', 'key' => $user->email_activation_key]);
                            $arrr['{{%USER_EMAIL%}}']                = $user->email;
                            $arrr['{{%USER_PASSWORD%}}']             = $user->rawPassword;
                            MailSend::sendMail('NEW_USER_EMAIL_VERIFICATION', $_POST['User']['email'], $arrr);
                            $model->user_id                     =    $user->id;
                            if($model->save()){
                                $template       =   EmailTemplate::findOne(['code' => 'PROPERTY_REQUEST']);
                                $adminEmail     =   Yii::$app->params['adminEmail'];
                                $ar['{{%PROPERTY_REQ_FULL_NAME%}}']         = $model->user->FullName;
                                $ar['{{%PROPERTY_REQ_EMAIL%}}']             = $model->user->emailAddress;
                                $ar['{{%PROPERTY_REQ_PHONE%}}']             = $model->user->phoneNumber;
                                $ar['{{%PROPERTY_REQ_SCHEDULE%}}']          = Yii::$app->formatter->asDate($model->schedule);
                                $ar['{{%PROPERTY_REQ_CATEGORY%}}']          = $model->property_category;
                                $ar['{{%PROPERTY_REQ_TYPE%}}']              = $model->propertyType->title;
                                $ar['{{%PROPERTY_REQ_BEDROOM_NO%}}']        = $model->no_of_bed_room;
                                $ar['{{%PROPERTY_REQ_STATE%}}']             = $model->state;
                                $ar['{{%PROPERTY_REQ_LOCALITY%}}']          = $model->locality ? $model->locality : "";
                                $ar['{{%PROPERTY_REQ_COMMENT%}}']           = $model->comment ? $model->comment : "";
                                MailSend::sendMail('PROPERTY_REQUEST', $adminEmail, $ar);
                                $template       =   EmailTemplate::findOne(['code' => 'PROPERTY_REQUEST_USER']);
                                $arr['{{%PROPERTY_REQ_FULL_NAME%}}']         = $model->user->FullName;
                                MailSend::sendMail('PROPERTY_REQUEST_USER', $userEmailData, $arr);
                                $transaction->commit();
                                Yii::$app->session->setFlash('success', 'Thank you for your request. We will respond to you as soon as possible');
                                return $this->refresh();
                            }else{
                                \yii\helpers\VarDumper::dump($model->errors); exit; 
                            }
                        }else{
                            \yii\helpers\VarDumper::dump($userConfigModel->errors);exit;
                        }
                    }else{
                        \yii\helpers\VarDumper::dump($user->errors);exit;
                    }
                }
                
                
            }
            //\yii\helpers\VarDumper::dump($model->errors);exit;
        }
        return $this->render('request',[
            'model'             =>  $model,
            'userModel'         =>  $userModel,
            'propertyCategory' =>  $propertyCategory,
        ]);
    }
    public function actionRequestList(){
        $this->layout                   =   'public_main';
        $model                          =   new PropertyRequest();
        return $this->render('request-list',[
            'model'                     =>  $model,
        ]);
    }
    public function actionRequestView($request_id){
        $this->layout                   =   'public_main';
        $propertyRequest            = PropertyRequest::find()->where(['id' => $request_id])->one();
        if(empty($propertyRequest)){
            throw new NotFoundHttpException(Yii::t('app', 'Invalid data'));
        }
        return $this->render('request-view',['propertyRequest' => $propertyRequest]);
    }
    public function actionRequestShowing($id = Null,$propertyUrl = Null){
        $propertyData           =   Property::find()->where(['id' => $id])->one();
        $openHouseData          =   $propertyData->openHouses;
        $propertyIpUrl          =   Url::to($propertyUrl,'http');
        if(isset(Yii::$app->user->id)){
            $userId             =   Yii::$app->user->id;
            $userModel          =   User::findOne(['id' => $userId]);
        }else{
            $userModel          =   new User();
        }
        $model                  =   new PropertyShowingRequest();
        
        return $this->renderAjax('request-showing', [
            'model'             => $model,
            'propertyData'      =>  $propertyData,
            'userModel'         =>  $userModel,
            'openHouseData'     =>  $openHouseData,
            'propertyIpUrl'     =>  $propertyIpUrl,
        ]);
        
    }
    public function actionSendRequestShowing(){
        $model                          =   new PropertyShowingRequest();
        $model->status                  =   'pending';
        $time   =   Yii::$app->request->post('PropertyShowingRequest');
        if(!empty($time['start_time'])){
            $model->start_time        =   $time['start_time'];
        }else{
            $model->start_time        =   '';
        }
        if(!empty($time['end_time'])){
            $model->end_time        =   $time['end_time'];

        }else{
            $model->end_time        =   '';
        }
        if ($model->load(Yii::$app->request->post())) {
            if($model->start_time && !$model->end_time){
                $model->scheduleDate        = str_replace('/', '-', $model->schedule)." ".$model->start_time;
                $model->scheduleEndDate     =   null;
            }else if($model->start_time && $model->end_time){
                $model->scheduleEndDate     =   str_replace('/', '-', $model->schedule)." ".$model->end_time;
                $model->scheduleDate        =   str_replace('/', '-', $model->schedule)." ".$model->start_time;
            }else if(!$model->start_time && $model->end_time){
                $model->scheduleDate        =   null;
                $model->scheduleEndDate     =   str_replace('/', '-', $model->schedule)." ".$model->end_time;
            }else{
                $model->scheduleDate        =   null;
                $model->scheduleEndDate     =   null;
            }
            Yii::$app->response->format     = Response::FORMAT_JSON;

            $model->user_id = Yii::$app->user->id;
            $model->status              = 'pending';
            $model->model               = 'Property';
            $propertyUrl                =  $time['property_url'];
//            \yii\helpers\VarDumper::dump($propertyUrl,4,12); exit;
            
                if($model->save()){
                    
                    $listingAgent = $this->renderPartial('//shared/_mail-showing-request', ['model' => $model, 'to' => 'la', 'type' => 'request']);
                    
                    $showingAgent = $this->renderPartial('//shared/_mail-showing-request', ['model' => $model, 'to' => 'sa', 'type' => 'request']);
                    
                    $ar['{{%SHOWING_REQUEST_DETAILS%}}']           =   $showingAgent;
                    MailSend::sendMail('PROPERTY_SHOWING_REQUEST', $model->user->email, $ar);  // $model->user->email shantinath.roy@sbr-technologies.com
                    
                    $arr['{{%SHOWING_REQUEST_DETAILS%}}']           =   $listingAgent;
                    MailSend::sendMail('PROPERTY_SHOWING_REQUEST', $model->property->user->email, $arr);
                    return ['success' => true,'message' => 'Thank you for your request. We will respond to you as soon as possible'];
                }else{
                    //\yii\helpers\VarDumper::dump($model->errors);
                    return ['success' => false,'message' => 'Following Fileds can not be blank','errors' => $model->errors];
                }
        }
    }
    public function actionContactAgent($id = Null,$propertyUrl = Null){
        $this->layout           =   'public_main';
        $propertyData           =   Property::find()->where(['id' => $id])->one();
        $model                  =   new PropertyEnquiery();
        $propertyIpUrl          =   Url::to($propertyUrl,'http');
        //\yii\helpers\VarDumper::dump($propertyIpUrl); exit;
        if(isset(Yii::$app->user->id)){
            $userId                     =   Yii::$app->user->id;
            $userModel                  =   User::findOne(['id' => $userId]);
        }
        return $this->renderAjax('contact-agent', [
            'model'             =>  $model,
            'propertyData'      =>  $propertyData,
            'userId'            =>  $userId,
            'userModel'         =>  $userModel,
            'propertyUrl'       => $propertyIpUrl,
        ]);
    }
    public function actionSendContactAgent(){
        $this->layout                   =   'public_main';
        $model                          =   new PropertyEnquiery();
        $propertyEnquieryData           =   Yii::$app->request->post('PropertyEnquiery');
        
        if ($model->load(Yii::$app->request->post())) {
            $user = Yii::$app->user->identity;
            Yii::$app->response->format     = Response::FORMAT_JSON;
            $property_url                   = $propertyEnquieryData['property_url'];
            
            $property                   = Property::findOne($model->model_id);
            $userMail                   = $property->user->email;
            $model->user_id             = $user->id;
            $model->assign_to           = $property->user->id;
            $model->status              = 'pending';
            //$userMail = $model->property->user->fullName;
            //\yii\helpers\VarDumper::dump($userMail,4,12); exit;
            $transaction                = Yii::$app->db->beginTransaction();
            try {
                if($model->save()){ //echo 12; exit;
                    $template = EmailTemplate::findOne(['code' => 'PROPERTY_ENQUIERY_REQUEST']);
                    $ar['{{%FULL_NAME%}}']                  = $model->property->user->fullName;
                    $ar['{{%ENQUIRY_NAME%}}']               = $model->name;
                    $ar['{{%ENQUIRY_PROPERTY_REF_ID%}}']    = $model->property->referenceId;
                    $ar['{{%ENQUIRY_PROPERTY_ADDRESS%}}']   = $model->property->formattedAddress;
                    $ar['{{%ENQUIRY_EMAIL%}}']              = $model->email;
                    $ar['{{%ENQUIRY_PHONE%}}']              = $model->phone;
                    $ar['{{%ENQUIRY_MESSAGE%}}']            = $model->message;
                    $ar['{{%ENQUIRY_PROPERTY_URL%}}']       = $property_url;

                    MailSend::sendSubjectMail('PROPERTY_ENQUIERY_REQUEST', $userMail, $ar,$model->property->referenceId);
                    $transaction->commit();
                    return ['success' => true,'message' => 'Your Request Sent successfully'];
                }else{
                    return ['success' => false, "message" => "Enquiery form contains error(s)", "errors" => $model->errors];
                }
            } catch (Exception $ex) {
                $transaction->rollBack();
            }
        }else{
            return ['success' => false, "message" => "Enquiery form contains error(s)", "errors" => $model->errors];
        }
    }
    public function actionFavouriteProperty(){
        $userId = Yii::$app->user->id; 
        $modelArr     =   UserFavorite::find()->where(['model' => 'Property','user_id' => $userId])->all();
        //\yii\helpers\VarDumper::dump($userId); exit;
        return $this->render('favourite-property',[
            'modelArr'             =>  $modelArr,
        ]);
    }
    public function actionRequestedProperty(){
        $this->layout           =   'main';
        $searchModel            = new PropertyRequestSearch();
        
        $user = Yii::$app->user->identity;
        if(AuthHelper::is('agency')){
            $agency = $user->agency;
            $agents = ArrayHelper::getColumn(Agent::find()->where(['agency_id' => $agency->id])->all(), 'id');
            if(!empty($agents)){
                $searchModel->user_id = $agents;
            }else{
                $searchModel->user_id = [0];
            }
        }else{
            $searchModel->user_id = $user->id;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      
        return $this->render('requested-property',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }
    public function actionRequestFeedbackView($id){
        //echo 18;exit;
        $this->layout           =   'main';
        $requestFeedback    =   new PropertyShowingRequestFeedback();
        $model              = PropertyRequest::findOne($id);
        //$userId             =   $model->user_id;
//        $propertyId         =   $model->model_id;
//        $requestTo          =   $model->request_to;
//        \yii\helpers\VarDumper::dump($model,4,12);exit;
        return $this->render('request-feedback-view', [
            'model'             => $model,
            'requestFeedback'   => $requestFeedback,
            'id'                => $id,
            //'userId'            =>  $userId,
//            'propertyId'        =>  $propertyId,
//            'requestTo'         =>  $requestTo
        ]);
    }
    public function actionReplayFeedback(){
        $requestFeedback                    =   new PropertyShowingRequestFeedback();
        if ($requestFeedback->load(Yii::$app->request->post())) {
            Yii::$app->response->format     = Response::FORMAT_JSON;
            $requestFeedback->user_id       = Yii::$app->user->id;
            $requestFeedback->status        = 'active';
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if($requestFeedback->save()){
                    $transaction->commit();
                    return ['success' => true,'message' => 'Your reply sent successfully'];
                }else{
                    return ['success' => false,'errors' => $requestFeedback->errors];
                }
                
            } catch (Exception $ex) {
                $transaction->rollBack();
            }
        }
    }
    public function actionPropertyRequestReplayList($showing_request_id){
        $this->layout   =   'ajax';
        $searchModel = new PropertyShowingRequestFeedbackSearch();
        $searchModel->showing_request_id = $showing_request_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       // \yii\helpers\VarDumper::dump($dataProvider); exit;
        return $this->render('property-request-replay-list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        
    }
    public function actionSellAdvice(){
        $this->layout           =   'public_main';
        return $this->render('sell-advice');
    }
    public function actionRealstateforsale(){
        $this->layout           =   'public_main';
        $properties               =   Property::find()->where(['property_category_id' => 2])->orderBy(['id' => SORT_ASC])->all();
        //\yii\helpers\VarDumper::dump($property,4,12); exit;
        return $this->render('realstateforsale', [
            'properties'          => $properties, 
        ]);
    }
    public function actionSaveFavorite($id){
        if(!Yii::$app->request->isAjax){
            return $this->goHome();
        }
        Yii::$app->response->format     = Response::FORMAT_JSON;
        if(Yii::$app->user->isGuest){
            return ['status' => false, 'is_guest' => true, 'message' => 'You are not logged in'];
        }
        $insert = false;
        $userId = Yii::$app->user->id;
        $favoriteModel = UserFavorite::find()->where(['model' => 'Property', 'model_id' => $id, 'user_id' => $userId])->one();
        if(empty($favoriteModel)){
            $model = new UserFavorite();
            $model->user_id = $userId;
            $model->model = 'Property';
            $model->model_id = $id;
            $model->save();
            $insert = true;
        }else{
            UserFavorite::findOne($favoriteModel->id)->delete();
        }
        return ['status' => true, 'id' => $id, 'insert' => $insert];
    }
    public function actionDeleteFavorite($id){
        $userId                 = Yii::$app->user->id;
        
        $favoriteModel          = UserFavorite::find()->where(['model' => 'Property', 'model_id' => $id, 'user_id' => $userId])->one();
        $deleteFavoriteModel    = UserFavorite::findOne($id)->delete();
        $modelArr     =   UserFavorite::find()->where(['model' => 'Property','user_id' => $userId])->all();
        if(isset($deleteFavoriteModel)){
            return $this->render('favourite-property',[
                'modelArr'             =>  $modelArr,
            ]);
        }
        return $this->render('favourite-property',[
            'modelArr'             =>  $modelArr,
        ]);

        
        
    }
    
    public function actionCalculatePayment(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $calcData = Yii::$app->request->post('Calc');
        $calcViewData = Yii::$app->request->post('CalcV');
        $property_price = $calcData['property_price'];

        $property_price_num = PropertyHelper::intVal($property_price);
        
        $down_payment_percent = $calcData['down_payment_percent'];
        $down_payment_amount = $calcData['down_payment_amount'];
        
        $mortgage_insurance = PropertyHelper::intVal($calcViewData['mortgage_insurance']);
        
        if($calcData['field_name'] == 'down_payment_percent'){
            $down_payment_amount_num = ($property_price_num * PropertyHelper::intVal($down_payment_percent)/100);
            $down_payment_percent_num = PropertyHelper::intVal($down_payment_percent);
        }elseif($calcData['field_name'] == 'down_payment_amount'){
            $down_payment_amount_num = PropertyHelper::intVal($down_payment_amount);
            $down_payment_percent_num = round(PropertyHelper::intVal($down_payment_amount)*100/$property_price_num);
        }elseif($calcData['field_name'] == 'property_price'){
            $down_payment_percent_num = PropertyHelper::intVal($down_payment_percent);
            $down_payment_amount_num = ($property_price_num * $down_payment_percent_num / 100);
            $mortgage_insurance = ($property_price_num * Property::MORTGAGE_INSURANCE / 100);
        }else{
            $down_payment_percent_num = PropertyHelper::intVal($down_payment_percent);
            $down_payment_amount_num = PropertyHelper::intVal($down_payment_amount);
        }
        
        
        
        
        $mortgage_loan_type = $calcData['mortgage_loan_type'];
        $mortgage_loan_type_percentage = $calcData['mortgage_loan_type_percentage'];
        $mortgage_loan_type_percentage_num = str_replace('%', '', $mortgage_loan_type_percentage);
        

        
        $princ = $property_price_num - $down_payment_amount_num;
        $term  = $mortgage_loan_type * 12;
        $intr   = $mortgage_loan_type_percentage_num / 1200;
        $calc_pay_value = round($princ * $intr / (1 - (pow(1/(1 + $intr), $term))));
        
        
        $total_monthly_installment = $calc_pay_value + PropertyHelper::intVal($calcViewData['tax']) + PropertyHelper::intVal($calcViewData['insurance']) + PropertyHelper::intVal($calcViewData['hoa_fees']) + PropertyHelper::intVal($mortgage_insurance);
        
        $pay_value_percent = round($calc_pay_value*100/$total_monthly_installment);
        $tax_percent = round(PropertyHelper::intVal($calcViewData['tax'])*100/$total_monthly_installment);
        $insurance_percent = round(PropertyHelper::intVal($calcViewData['insurance'])*100/$total_monthly_installment);
        $hoa_fees_percent = round(PropertyHelper::intVal($calcViewData['hoa_fees'])*100/$total_monthly_installment);
        $mortgage_insurance_percent = round(PropertyHelper::intVal($calcViewData['mortgage_insurance'])*100/$total_monthly_installment);
        
        return ['status' => true, 'property_price' => Yii::$app->formatter->asCurrency($property_price_num), 
            'down_payment_percent' => $down_payment_percent_num. '%', 
            'down_payment_amount' => Yii::$app->formatter->asCurrency($down_payment_amount_num), 
            'mortgage_loan_type_percentage' => $mortgage_loan_type_percentage_num. '%',
            'calc_pay_value' => Yii::$app->formatter->asCurrency($calc_pay_value),
            'total_monthly_installment' => Yii::$app->formatter->asCurrency($total_monthly_installment),
            'mortgage_insurance' => Yii::$app->formatter->asCurrency($mortgage_insurance),
            'tax_percent' => $tax_percent,
            'pay_value_percent' => $pay_value_percent,
            'insurance_percent' => $insurance_percent,
            'hoa_fees_percent' => $hoa_fees_percent,
            'mortgage_insurance_percent' => $mortgage_insurance_percent];
    }

    public function actionPrint($slug){
        $mpdf = new \Mpdf\Mpdf();

        $stylesheet = file_get_contents(Url::home(true). '/public_main/css/pdf.css'); // external css
        // Define the Header/Footer before writing anything so they appear on the first page
        $property               =   Property::findOne(['slug' => $slug]);
        $content                =   $this->renderPartial('print',['property' => $property]);
        $mpdf->SetHTMLHeader('<div class="header"><img src="'.Url::home(true).'/public_main/images/logo.png'. '" height="70"></div>');
        $mpdf->SetHTMLFooter('<div class="footer-section" style="background: #405e6f url('. Url::home(true).'/public_main/images/logo-icon.png)no-repeat 95% center;">This report has been prepared based on information furnished by sources deemed reliable , however no representation or warranty , either expressed or implied , is made to its accuracy.</div>');

        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($content, 2);

        $mpdf->Output("$slug.pdf", 'I');


//        $this->layout           =   'public_pdf';
//        $property               =   Property::findOne(['slug' => $slug]);
//        $content                =   $this->renderPartial('print',['property' => $property]);
//        $pdf                    =   new Pdf([
//                                        'mode' => Pdf::MODE_UTF8, 
//                                        'format' => Pdf::FORMAT_A4, 
//                                        'orientation' => Pdf::ORIENT_PORTRAIT, 
//                                        'destination' => Pdf::DEST_BROWSER, 
//                                        'content' => $content,  
//                                        'cssFile' => '', //'@webroot/public_main/css/pdf.css',
//                                        'options' => ['title' => $property->formattedAddress],
//                                        'methods' => [ 
//                                                    'SetHeader'=>[Yii::$app->name], 
//                                                    'SetFooter'=>['{PAGENO}'],
//                                        ]
//                                    ]);
//        return $pdf->render(); 
//        //return $this->render('print-property',['property' => $property]);
    }
    public function actionShareProperty($slug,$propertyUrl = Null){
        $model                  =   Property::findOne(['slug' => $slug]);
        $propertyIpUrl          =   Url::to($propertyUrl,'http');
        return $this->renderAjax('share-property', [
            'model'             => $model,
            'propertyIpUrl'     => $propertyIpUrl
        ]);
    }
    public function actionSendShareProperty(){
        $loopCnt = 0;
        $saveCnt = 0;
        $propertyShare = Yii::$app->request->post('Property');
        $property                  =   Property::findOne(['id' => $propertyShare['id']]);
        Yii::$app->response->format     = Response::FORMAT_JSON;
       // echo "<pre>"; print_r($property); echo "<pre>"; exit;
        if(!empty($propertyShare)){
            $sharePropertyUrl       =   $propertyShare['share_property_url'];
            $shareWith              =   $propertyShare['share_with'];
            $shareEmail             =   $propertyShare['share_email'];
            $shareName              =   $propertyShare['share_name'];
            $shareNote              =   $propertyShare['share_note'];
            $sharePropertyDetail    =   "<div style='width:100%; display:inline-block; font-family: 'Open Sans';' data-id='". $property->id."'>";
            $sharePropertyDetail    .=  "<div style='width:100%; display:inline-block;'>";
            $sharePropertyDetail    .=  "<div style='width:42%; margin:0 2% 0 0; float:left;'>";
            $sharePropertyDetail    .=  "<img src = '". $property->featureThumbImage ."' style='width:94%; background:#fff; border:1px #ddd solid; padding:4px; box-shadow: 0 0 5px #ccc;'/>";                                                               
            $sharePropertyDetail    .=   "</div>";
            $sharePropertyDetail    .=   "<div style='width:56%; margin:0; float:left;'>";
            $sharePropertyDetail    .=   "<h2 style='font-size:24px; margin:0 0 10px; color:#131313;'>". Yii::$app->formatter->asCurrency($property->price)."</h2>";
            $sharePropertyDetail    .=   "<h4 style='font-size:15px; margin:0 0 5px; color:#b21117; font-weight:normal;'>";
            $sharePropertyDetail    .=   $property->formattedAddress ;
            $sharePropertyDetail    .=   "</h4>";
            $sharePropertyDetail    .=   "<p style='font-size:15px; color:#121212; margin:0 0 12px;'>Single Family Home</p>";
            $sharePropertyDetail    .=   "<ul style='margin:0 0 10px; padding:0; width:100%; display:inline-block;'>";
            $sharePropertyDetail    .=   "<li style='background:#e5e5e5; padding:6px 10px; display:inline-block; margin:0 5px 0 0; text-align:center; line-height:18px; color:#121212; min-height:40px; min-width:42px; float:left;'><span style='display:block;'>". $property->no_of_room ."</span> <img src='".Yii::$app->params['homeUrl']. "/images/icon-bed.png' alt=''></li>";
            $sharePropertyDetail    .=   "<li style='background:#e5e5e5; padding:6px 10px; display:inline-block; margin:0 5px 0 0; text-align:center; line-height:18px; color:#121212; min-height:40px; min-width:42px; float:left;'><span style='display:block;'>". $property->no_of_bathroom."</span> <img src='".Yii::$app->params['homeUrl']. "/images/icon-bath.png' alt=''> </li>";
            $sharePropertyDetail    .=   "<li style='background:#e5e5e5; padding:6px 10px; display:inline-block; margin:0 5px 0 0; text-align:center; line-height:18px; color:#121212; min-height:40px; min-width:42px; float:left;'><span style='display:block;'>". $property->lot_size ."</span> <img src='".Yii::$app->params['homeUrl']. "/images/icon-sqft.png' alt=''></li>";
            $sharePropertyDetail    .=    "</ul>";
            $sharePropertyDetail    .=   "<a href='javascript:void(0)' style='font-weight:bold; font-size:14px; color:#b21117; margin:0 0 15px; display:block;'>Property Id # ". $property->ReferenceId ."</a>";
            $sharePropertyDetail    .=   "<a href='". $sharePropertyUrl."' style='padding:8px 10px; color:#fff; background:#b21117; text-decoration:none;'>View Details</a>";
            $sharePropertyDetail    .=    "</div>";
            $sharePropertyDetail    .=    "</div>";
            $sharePropertyDetail    .=    "</div>";
            //echo "<pre>"; print_r($sharePropertyDetail); echo "<pre>"; exit;
            if( strpos($shareWith, ',') !== false ){
                $shareWithArr   = explode(",", $shareWith);
            }else{
                $shareWithArr   = [
                                    0 => $shareWith,
                                    ];
            }
            if(is_array($shareWithArr) && count($shareWithArr) > 0){
                foreach($shareWithArr as $share){
                    if($share != ''){
                        $loopCnt++;
                        $template = EmailTemplate::findOne(['code' => 'SHARE_PROPERTY_WITH_FRIEND']);
                        $ar['{{%SHARE_NAME%}}']                 = $shareName;
                        $ar['{{%SHARE_EMAIL%}}']                = $shareEmail;
                        $ar['{{%SHARE_NOTE%}}']                 = $shareNote;
                        $ar['{{%SHARE_PROPERTY_DETAILS%}}']     = $sharePropertyDetail;
                        MailSend::sendMail('SHARE_PROPERTY_WITH_FRIEND', $share, $ar);
                        $saveCnt++;
                    }
                }
            }
        }
        if($loopCnt == $saveCnt){
            return ['success' => true,'message' => 'Your message is on the way. Thank you.'];
        }else{
            return ['success' => false, "message" => "We are uanble to send Mail"];
        }
    }
    /**
     * Finds the Property model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Property the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id){
        if (($model = Property::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionPropertyExpireRem(){
        $properties = Property::find()->with('user')->active()->all();
        foreach ($properties as $property){
            $remainDays             =   '';
            $expiredDate    = $property->expired_date;
            $todatDate      = date("Y-m-d");
            if(!empty($expiredDate)){
                $days14ago = date('Y-m-d', strtotime('-14 days', strtotime($expiredDate)));
                $days7ago = date('Y-m-d', strtotime('-7 days', strtotime($expiredDate)));
                $days1ago = date('Y-m-d', strtotime('-1 days', strtotime($expiredDate)));
                if(strtotime($todatDate) == strtotime($days14ago)){
                    $remainDays     = "14 days"; 
                }else if(strtotime($todatDate) == strtotime($days7ago)){
                    $remainDays     = "7 days";  
                }else if(strtotime($todatDate) == strtotime($days1ago)){
                    $remainDays     = "1 day"; 
                }
                $template = EmailTemplate::findOne(['code' => 'PROPERTY_EXPIRY_REMINDER']);
                $ar['{{%FULL_NAME%}}']                  = $property->user->fullName;
                $ar['{{%REMAIN_DAYS%}}']                = $remainDays;
                $ar['{{%PROPERTY_ADDRESS%}}']           = $property->property->formattedAddress;
                $ar['{{%PROPERTY_PRICE%}}']             = Yii::$app->formatter->asCurrency($property->price, $property->currency->code);
                $ar['{{%PROPERTY_LISTED_DATE%}}']       = date("d-m-Y",  strtotime($property->listed_date));
                $ar['{{%PROPERTY_EXPIRY_DATE%}}']       = date("d-m-Y",  strtotime($property->expired_date));

                MailSend::sendMail('PROPERTY_EXPIRY_REMINDER', $userMail, $ar);
            }
        }
    }
    public function actionAddToCompare(){
        Yii::$app->response->format     =   Response::FORMAT_JSON;
        $session                        =   Yii::$app->session;
        $propertyId                     =   Yii::$app->request->get('id');
        if($propertyId){
            $compProps = $session->get('comp_props');
            if(empty($compProps)){
                $compProps = [];
            }
            if(!in_array($propertyId, $compProps)){
                if(count($compProps) < 3){
                    array_push($compProps, $propertyId);
                    $session->set('comp_props', $compProps);
                    return ['success' => true,'message' => 'added successfully'];
                }else{
                    return ['success' => false,'message' => 'You can not add more than 3 properties.'];
                }
            }else{
                if(($key = array_search($propertyId, $compProps)) !== false) {
                    unset($compProps[$key]);
                    $session->set('comp_props', $compProps);
                    return ['success' => true,'message' => 'removed successfully'];
                }
            }
        }
        return ['success' => false,'message' => 'Invalid params'];
    }
    public function actionCompareProperty(){
        $this->layout   =   'public_main';
        $session = Yii::$app->session;
        $compProps = $session->get('comp_props');
        if(empty($compProps)){
            return $this->goHome();
        }
        $propertiesArr      = Property::find()->where(['id' => $compProps])->all(); 
        if(empty($propertiesArr) || count($propertiesArr) < 2){
            Yii::$app->session->setFlash('error', 'Please add Property to compare');
            return $this->goHome();
        }else{
            return $this->render('compare-property', [
                'propertiesArr'             => $propertiesArr,
            ]);
        }
    }
    public function actionRemoveProperty(){
//        $this->layout                   =   'public_main';
        $propertyId                     =   Yii::$app->request->get('id');
        $session                        =   Yii::$app->session;
        $propertiesArr                  =   [];
        $compProps                      =   $session->get('comp_props');
        if(($key                        =   array_search($propertyId, $compProps)) !== false) {
            unset($compProps[$key]);
            //unset($session)
        }
        $session->set('comp_props', $compProps);
        return $this->redirect(['property/compare-property']);
//        $compProps                      =   $session->get('comp_props');
//        //\yii\helpers\VarDumper::dump($compProps); exit;
//        foreach($compProps as $propertyId){
//            $propertiesArr[]      = Property::find()->where(['id' => $propertyId])->one(); 
//        }
//        if(empty($propertiesArr)){
//            return $this->goHome();
//        }else{
//            return $this->render('compare-property', [
//                'propertiesArr'             => $propertiesArr,
//            ]);
//        }
    }
    
    public function actionCreateApartment($property_id){
        $model = new PropertyApartment();
        
        if(Yii::$app->request->isPost){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->load(Yii::$app->request->post())){
                if($model->save()){
                    return ['status' => true, 'message' => 'Successfully Added'];
                }
            }
            return ['status' => false, 'errors' => $model->firstErrors];
        }
        
        return $this->renderAjax('create-apartment', ['model' => $model, 'propertyId' => $property_id]);
    }
}
