<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\helpers\StringHelper;

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
use common\models\Agent;
use common\components\MailSend;
use common\models\SavedSearch;


/**
 * PropertyController implements the CRUD actions for Property model.
 */
class CondominiumController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Property models.
     * @return mixed
     */
    public function actionIndex(){
        $searchModel = new PropertySearch();
        $searchModel->is_condo = 1;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Property model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id){
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
        //\yii\helpers\VarDumper::dump($metaTagModel); exit;
        return $this->render('view', [
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

    /**
     * Creates a new Property model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate(){
        $model                          = new Property(['scenario' => 'condo']);
        $localInfoModel                 = [new PropertyLocationLocalInfo()];
        $metaTagModel                   = new MetaTag();
        $taxHistoryModel                = [new PropertyTaxHistory()]; 
        $priceHistory                   = new PropertyPriceHistory();
        $openHouseModel                 = new OpenHouse(); 
        $featureModel                   = [new PropertyFeature()];
        $featureItemModel               = [new PropertyFeatureItem()];
        $genralFeature                  = new PropertyGeneralFeature();
        $contactModels        =             [];
        $contactModel = new \common\models\Contact();
        $propertyShowingContact         = new PropertyShowingContact();
        $loopCnt                        =   0;
        $saveCnt                        =   0;
        $generalArr                     =   [];
        $generals                       =   $model->generalFeatures;
        foreach($generals as $general){
            $generalArr[]               =   $general->id;
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->is_multi_units_apt = 1;
            $model->is_condo = 1;
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $loopCnt++;
                if($model->save()){
                    $saveCnt++;
                }else{
                    return ['success' => false,'errors' => $model->errors];
                }
                $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
                if(!empty($model->imageFiles)){
                    if($model->upload()){ 
                    }
                }
                $model->documentFiles = UploadedFile::getInstances($model, 'documentFiles');
                if(!empty($model->documentFiles)){
                    if($model->uploadFile()){
                    }
                }
                if(isset($_POST['PropertyLocationLocalInfo']) && is_array($_POST['PropertyLocationLocalInfo']) && count($_POST['PropertyLocationLocalInfo']) > 0){
                    foreach($_POST['PropertyLocationLocalInfo'] as $propertyLocation){
                        $loopCnt++;
                        $localInfoModel                 = new PropertyLocationLocalInfo();
                        $localInfoModel->property_id    = $model->id;
                        $localInfoModel->local_info_type_id = $propertyLocation['local_info_type_id'];
                        $localInfoModel->title          = $propertyLocation['title'];
                        $localInfoModel->location       = $propertyLocation['location'];
                        $localInfoModel->description    = $propertyLocation['description'];
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
                        foreach($generalInfo as $infoVal){
                            if(!empty($infoVal)){
                                $loopCnt++;
                                $genralFeature                  = new PropertyGeneralFeature();
                                $genralFeature->property_id     = $model->id;
                                $genralFeature->general_feature_master_id  = $infoVal;
                                if($genralFeature->save()){
                                    $saveCnt++; 
                                }
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
                        $propertyShowingContact                         = new PropertyShowingContact(); 
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
                //\yii\helpers\VarDumper::dump($loopCnt."++".$saveCnt); exit;
                if($loopCnt == $saveCnt){
                    $transaction->commit();
                    
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
                    
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (Exception $ex) {
                $transaction->rollBack();
            }
        } else {
            return $this->render('create', [
                'model'             =>  $model,
                'localInfoModel'    =>  $localInfoModel,
                'metaTagModel'      =>  $metaTagModel,
                'taxHistoryModel'   =>  $taxHistoryModel,
                'openHouseModel'    =>  $openHouseModel,
                'featureModel'      =>  $featureModel,
                'featureItemModel'  =>  $featureItemModel,
                'genralFeature'     =>  $genralFeature,
                'contactModel'   =>  $contactModel,
                'contactModels'   =>  $contactModels,
                'generalArr'        =>  $generalArr,
                'propertyShowingContact'    =>  $propertyShowingContact,
            ]);
        }
    }

    /**
     * Updates an existing Property model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id){
        $model                  = Property::findOne($id);
        $model->scenario = 'condo';
        $agentSocialMediaArr    =   [];
        $agentSocialMediaModel  =   $model->propertySocialMedias;
        $genralFeature          = new PropertyGeneralFeature();
        $contactModels        = \common\models\Contact::find()->where(['property_id' => $id])->all();
        $contactModel = new \common\models\Contact();
        $generalArr             =   [];
        $generals               =   $model->generalFeatures;
        foreach($generals as $general){
            $generalArr[]       =   $general->id;
        }
        if(empty($contactProperty)){
            $contactProperty    = new PropertyContact();
        }
        foreach($generals as $general){
            $generalArr[]         =   $general->id;
        }
        //\yii\helpers\VarDumper::dump($propertyShowingContact,4,12); exit;
        if(!empty($agentSocialMediaModel)){
            foreach ($agentSocialMediaModel as $key => $val){
                $agentSocialMediaArr[$val['name']]    =   $val;
            }
        }
        //\yii\helpers\VarDumper::dump($agentSocialMediaArr);exit;
        $localInfoModel = PropertyLocationLocalInfo::findAll(['property_id' => $model->id]);
        $factInfoModel = PropertyFactInfo::findAll(['property_id' => $model->id]);
        $metaTagModel  = MetaTag::find()->where(['model_id' => $model->id, 'model' => StringHelper::basename($model->className())])->one();
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
            $model->status = 'active'; 
            $transaction = Yii::$app->db->beginTransaction();
            try {
                //$model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
                if($model->save()){
                    $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
                    if(!empty($model->imageFiles)){
                        if($model->upload()){ 
                        }
                    }
                    $model->documentFiles = UploadedFile::getInstances($model, 'documentFiles');
                    if(!empty($model->documentFiles)){
                        if($model->uploadFile()){
                        }
                    }
                    
                    $propertyLocalInfo = Yii::$app->request->post('PropertyLocationLocalInfo');
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

                            $childModel->local_info_type_id  = $child['local_info_type_id'];
                            $childModel->location                = $child['location'];
                            $childModel->lat                = $child['lat'];
                            $childModel->lng                = $child['lng'];
                            $childModel->title           = $child['title'];
                            $childModel->description     = $child['description'];
                            if(!$childModel->save()){
    //                            print_r($childModel->errors);die();
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
                    $transaction->commit();
                    
                    return $this->redirect(['view', 'id' => $model->id]);
                }else{
                    \yii\helpers\VarDumper::dump($model->errors); die();
                }
            } catch (Exception $ex) {
                $transaction->rollBack();
                \yii\helpers\VarDumper::dump($model->errors);//echo 22; die();
            }
            
        } 
        //\yii\helpers\VarDumper::dump($localInfoModel,12,123); exit;
        return $this->render('update', [
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
            'contactModels'   =>  $contactModels,
            'contactModel'   =>  $contactModel,
            'propertyShowingContact' => $propertyShowingContact
        ]);
        
    }

    /**
     * Deletes an existing Property model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
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
        Yii::$app->session->setFlash("success", "Succesfully Deleted.");
        return $this->redirect(['index']);
    }

    public function actionDeletePhoto($id,$property_id){
        $photo = PhotoGallery::findOne($id);
        if($photo->delete()){
            Yii::$app->session->setFlash("success", "One image delete successfully");
            return $this->redirect(['update', 'id' => $property_id]);
        }else{
            Yii::$app->session->setFlash("failed", "Sorry, We are unable to process your data");
            return $this->redirect(['update', 'id' => $property_id]);
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
    /**
     * Status Updates an existing MetricType model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionStatus($id){
        $model = $this->findModel($id);
        if($model->status == $model::STATUS_ACTIVE){
            $model->status = $model::STATUS_INACTIVE;
            Yii::$app->session->setFlash("success", "Succesfully inactive.");
        }else {
            $model->status = $model::STATUS_ACTIVE;
            Yii::$app->session->setFlash("success", "Succesfully active.");
        }
        $model->save();
        return $this->redirect(['index']);
    }
    /**
     * Finds the Property model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Property the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Property::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
