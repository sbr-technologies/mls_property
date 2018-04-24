<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Property;
use frontend\models\PropertySearch;
use yii\web\Response;
use common\models\SavedSearch;
use yii\filters\AccessControl;
use common\components\MailSend;
use yii\data\ActiveDataProvider;
use common\models\User;
use common\models\MetaTag;
use common\models\PropertyLocationLocalInfo;
use common\models\SocialMediaLink;
use common\models\PropertyTaxHistory;
use common\models\PropertyPriceHistory;
use common\models\PropertyFeature;
use common\models\PropertyFeatureItem;
use common\models\PropertyGeneralFeature;
use common\models\PropertyContact;
use common\models\PropertyShowingContact;
use common\models\Agent;
use common\models\OpenHouse;
use common\models\EmailTemplate;
use frontend\helpers\AuthHelper;
use yii\web\UploadedFile;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\db\Expression;

class CondominiumController extends Controller{
    
    public function init() {
        parent::init();
        $this->layout   =   'public_main';
    }
    
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'my-saved-searches'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
    public function actionCreate(){
        $this->layout                   =   'main';
        $model                          = new Property(['scenario' => 'condo']);
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
            $user = Yii::$app->user->identity;
            if (!AuthHelper::is('agency')) {
                $model->user_id = $user->id;
            }
            $model->is_multi_units_apt = 1;
            $model->is_condo = 1;
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
                            //MailSend::sendMail('SELLER_PROPERTY_BROKERAGE', $adminEmail, $arr);
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
                            //MailSend::sendMail('SELLER_PROPERTY_CREATE', $adminEmail, $arrr);
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

                        //MailSend::sendMail('NEW_PROPERTY_CREATE', $adminEmail, $ar);
                    }
                    
                    $transaction->commit();
                    return ['success' => true,'message' => 'Your Property has been Added successfully','redirectUrl' => $redirectUrl];
                }
            } catch (Exception $ex) {
                $transaction->rollBack();
                return ['success' => false,'message' => 'Error in saving Property'. $ex->getMessage()];
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
    
    public function actionSearch($type = null){
        $categories       = Yii::$app->request->get('categories');
        $minPrice       = Yii::$app->request->get('min_price');
        $maxPrice       = Yii::$app->request->get('max_price');
        $bedroom        = Yii::$app->request->get('bedroom');
        $bathroom       = Yii::$app->request->get('bathroom');
        $garage       = Yii::$app->request->get('garage');
        $propTypes      = Yii::$app->request->get('prop_types');
        $constStatuses  = Yii::$app->request->get('const_status');
        $marktStatuses  = Yii::$app->request->get('market_statuses');
        $generalFeatures = Yii::$app->request->get('general_features');
        $exteriorFeatures = Yii::$app->request->get('exterior_features');
        $interiorFeatures = Yii::$app->request->get('interior_features');
        $teamID             = Yii::$app->request->get('team_id');
        $teamName           = Yii::$app->request->get('team_name');
        $agencyName         = Yii::$app->request->get('agency_name');
        $soleMandate        = Yii::$app->request->get('sole_mandate');
        $featuredListing    = Yii::$app->request->get('featured_listing');
        $propertyID         = Yii::$app->request->get('property_id');
        $streetAddress      = Yii::$app->request->get('street_address');
        $streetNumber       = Yii::$app->request->get('street_number');
        $appartmentUnit     = Yii::$app->request->get('appartment_unit');
        $zipCode            = Yii::$app->request->get('zip_code');
        $localGovtArea      = Yii::$app->request->get('local_govt_area');
        $urbanTownArea      = Yii::$app->request->get('urban_town_area');
        $agencyID           = Yii::$app->request->get('agency_id');
        $agentID            = Yii::$app->request->get('agent_id');
        $agentName          = Yii::$app->request->get('agent_name');
        $lotSize            = Yii::$app->request->get('lot_size');
        $buildingSize       = Yii::$app->request->get('building_size');
        $houseSize          = Yii::$app->request->get('house_size');
        $noOfToilet         = Yii::$app->request->get('no_of_toilet');
        $noOfBoysQuater     = Yii::$app->request->get('no_of_boys_quater');
        $yearBuilt          = Yii::$app->request->get('year_built');
        $source             = Yii::$app->request->get('source');
        $state             = Yii::$app->request->get('state');
        $town             = Yii::$app->request->get('town');
        $area             = Yii::$app->request->get('area');
        $sortBy             = Yii::$app->request->get('sort');
        
        if(!is_array($propTypes)){
            $propTypes          = ($propTypes?explode(',', $propTypes):[]);
        }
        if(!is_array($constStatuses)){
            $constStatuses      = ($constStatuses?explode(',', $constStatuses):[]);
        }
        if(!is_array($marktStatuses)){
            $marktStatuses      = explode(',', $marktStatuses);
        }
        $generals           = ($generalFeatures?explode(',', $generalFeatures):[]);
        $exteriors          = ($exteriorFeatures?explode(',', $exteriorFeatures):[]);
        $interiors          = ($interiorFeatures?explode(',', $interiorFeatures):[]);
        $lotSizeArr         = explode('-', $lotSize);
        $buildingSizeArr    = explode('-', $buildingSize);
        $houseSizeArr       = explode('-', $houseSize);
        $yearBuiltArr       = explode('-', $yearBuilt);
        if(empty($categories)){
            $categories     = [2];
        }
        if(!is_array($categories)){
            $categories = explode(',', $categories);
        }
        $searchModel        = new PropertySearch();
        $searchModel->status = Property::STATUS_ACTIVE;
        $location = '';
        $breadcrumb = [];
        if($state){
            $searchModel->state = $state;
            $location = $state;
            array_push($breadcrumb, $state);
        }
        if($town){
            $searchModel->town = $town;
            if(is_array($town) && count($town)>1){
                $location = '';
            }else{
                if(is_array($town)){
                    $town = $town[0];
                }
                $location = $town. ', '. $state;
            }
            array_push($breadcrumb, $town);
        }
        if($area){
            $searchModel->area = $area;
            if(is_array($area) && count($area)>1){
                $location = '';
            }else if($location){
                if(is_array($area)){
                    $area = $area[0];
                }
                $location = $area. ', '. $town. ', '. $state;
            }else{
                $location = '';
            }
            array_push($breadcrumb, $area);
        }
        
//        print_r($propTypes);die();
        $searchModel->minLotSize = isset($lotSizeArr[0])?trim($lotSizeArr[0]):null;
        $searchModel->maxLotSize = isset($lotSizeArr[1])?trim($lotSizeArr[1]):null;
        $searchModel->minBuildingSize = isset($buildingSizeArr[0])?trim($buildingSizeArr[0]):null;
        $searchModel->maxBuildingSize = isset($buildingSizeArr[1])?trim($buildingSizeArr[1]):null;
        $searchModel->minHouseSize = isset($houseSizeArr[0])?trim($houseSizeArr[0]):null;
        $searchModel->maxHouseSize = isset($houseSizeArr[1])?trim($houseSizeArr[1]):null;
        $searchModel->minPrice          = $minPrice;
        $searchModel->maxPrice          = $maxPrice;
        $searchModel->bedroomPlus       = $bedroom;
        $searchModel->bathroomPlus      = $bathroom;
        $searchModel->garagePlus        = $garage;
        $searchModel->toiletPlus        = $noOfToilet;
        $searchModel->boysQuaterPlus    = $noOfBoysQuater;
        $searchModel->typesIn           = $propTypes;
        $searchModel->constStatuses     = $constStatuses;
        $searchModel->marktStatuses     = $marktStatuses;
        $searchModel->minToilet         = isset($toiletArr[0])?trim($toiletArr[0]):null;
        $searchModel->maxToilet         = isset($toiletArr[1])?trim($toiletArr[1]):null;
        $searchModel->minBoysQuater     = isset($boysQuaterArr[0])?trim($boysQuaterArr[0]):null;
        $searchModel->maxBoysQuater     = isset($boysQuaterArr[1])?trim($boysQuaterArr[1]):null;
        $searchModel->minYearBuilt      = isset($yearBuiltArr[0])?trim($yearBuiltArr[0]):null;
        $searchModel->maxYearBuilt      = isset($yearBuiltArr[1])?trim($yearBuiltArr[1]):null;
        $searchModel->agentID           = $agentID;
        $searchModel->agencyID          = $agencyID;
        $searchModel->agentName         = $agentName;
        $searchModel->categories        = $categories;
        $searchModel->teamID            = $teamID;
        $searchModel->teamName          = $teamName;
        $searchModel->agencyName        = $agencyName;
        $searchModel->sole_mandate      = $soleMandate;
        $searchModel->featured          = $featuredListing;
        $searchModel->propertyID        = $propertyID;
        $searchModel->street_address     = $streetAddress;
        $searchModel->street_number      = $streetNumber;
        $searchModel->appartment_unit    = $appartmentUnit;
        $searchModel->zip_code          = $zipCode;
        $searchModel->local_govt_area     = $localGovtArea;
        $searchModel->urban_town_area     = $urbanTownArea;
        
        $searchModel->generalFeatures   = $generalFeatures;
        $searchModel->exteriorFeatures  = $exteriorFeatures;
        $searchModel->interiorFeatures  = $interiorFeatures;
        
//        \yii\helpers\VarDumper::dump($searchModel,12,1);die();
        $query = Property::find()->condo();
        if($state){
            $query->andWhere(['state' => $state]);
        }if($town){
            $query->andWhere(['town' => $town]);
        }if($area){
            $query->andWhere(['area' => $area]);
        }
        
        if(!empty($propTypes)){
            $typeQ = '';
            foreach ($propTypes as $typeId){
                $typeQ .= "FIND_IN_SET('$typeId', property_type_id)>0 OR ";
            }
            $typeQ = substr($typeQ, 0, -4);
            $query->andWhere(new Expression($typeQ));
        }
        
        if($sortBy == 'newest'){
            $query->orderBy(['created_at' => SORT_DESC]);
        }elseif($sortBy == 'name'){
            $query->orderBy(['building_name' => SORT_ASC]);
        }elseif($sortBy == 'town'){
            $query->orderBy(['town' => SORT_ASC]);
        }elseif($sortBy == 'area'){
            $query->orderBy(['area' => SORT_ASC]);
        }else{
            $query->orderBy(['created_at' => SORT_DESC]);
        }
        
//        echo $query->createCommand()->rawSql;die();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        
//        $dataProvider->pagination->pageSize=1;
        
        $list_url = Yii::$app->request->url;
        Yii::$app->session->set('list_url', $list_url);
//        echo $state;die();
        return $this->render('search', ['town' => $town, 'state' => $state, 'area' => $area,
            'location' => $location, 'breadcrumb' => $breadcrumb, 'sortBy' => $sortBy, 'category' => 'Property', 'category_id' => 2,
            'constStatuses' => $constStatuses, 'marktStatuses' => $marktStatuses, 'categories' => $categories,
            'minPrice' => $minPrice, 'maxPrice' => $maxPrice, 'bedroom' => $bedroom, 'bathroom' => $bathroom, 'garage' => $garage, 'propTypes' => $propTypes, 
            'dataProvider' => $dataProvider,'lotSize' => $lotSize,'buildingSize' => $buildingSize,'houseSize' => $houseSize,
            'noOfToilet' => $noOfToilet,'noOfBoysQuater' => $noOfBoysQuater,'yearBuilt' => $yearBuilt,'agencyID' => $agencyID,
            'agentID' => $agentID,'agentName' => $agentName,'generals' => $generals, 'exteriors' => $exteriors, 'interiors' => $interiors,
            'teamID' => $teamID, 'teamName' => $teamName, 'agencyName' => $agencyName, 'soleMandate' => $soleMandate, 'featuredListing' => $featuredListing,
            'propertyID' => $propertyID, 'streetAddress' => $streetAddress, 'streetNumber' => $streetNumber,'appartmentUnit' => $appartmentUnit,
            'zipCode' => $zipCode, 'localGovtArea' => $localGovtArea, 'urbanTownArea' => $urbanTownArea, 'source' => $source]);
    }
    
    public function actionSaveSearch(){
        $user = Yii::$app->user->identity;
        $postData = file_get_contents('php://input');
       // \yii\helpers\VarDumper::dump($postData,12,1); exit;
        $postDataArray = json_decode($postData, true);
        $name = $postDataArray['name'];
        $recipients = $postDataArray['recipients'];
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new SavedSearch();
        $model->user_id = Yii::$app->user->id;
        $model->name = $name;
        $model->type = 'Property';
        if(!empty($recipients)){
            $model->recipient = $recipients;
        }
        if(isset($postDataArray['cc_self']) && $postDataArray['cc_self']){
            $model->cc_self = $postDataArray['cc_self'];
            array_push($recipients, $user->email);
        }
        $model->schedule = $postDataArray['schedule'];
        $model->message = $postDataArray['message'];
        $model->search_string = json_encode($postDataArray['search_string']);
        $model->last_alert_sent_at = strtotime('now');
        
        $searchArray = $postDataArray['search_string'];
        $itemHtml = '<ul>';
        foreach ($searchArray['filters'] as $key => $filter) {
            if (!empty($filter)) {
                $model->$key = is_array($filter)?implode(',', $filter):$filter;
                $itemHtml .= '<li>'. SavedSearch::formattedFilter($key). ': '. SavedSearch::RelatedValue($key, $filter). '</li>';
            }
        }
        $itemHtml .= '</ul>';
        
        if($model->save()){
            $vars = [];
            $vars['{{%USER_NAME%}}'] = $user->commonName;
            $vars['{{%SEARCH_NAME%}}'] = $model->name;
            $vars['{{%MESSAGE%}}'] = $model->message;
            $vars['{{%SEARCH_LINK%}}'] = $model->searchUrl;
            $vars['{{%CRITERIA%}}'] = $itemHtml;
            foreach ($recipients as $recipient){
                MailSend::sendMail('SAVE_SEARCH', $recipient, $vars);
            }
            return ['status' => true, 'message' => 'Successfully Saved'];
        }
        return ['status' => false, 'errors' => $model->errors];
    }
    
    public function actionUpdateSaveSearch($id){
        $user = Yii::$app->user->identity;
        $postData = file_get_contents('php://input');
       // \yii\helpers\VarDumper::dump($postData,12,1); exit;
        $postDataArray = json_decode($postData, true);
        $name = $postDataArray['name'];
        $recipients = $postDataArray['recipients'];
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = SavedSearch::findOne($id);
        $model->name = $name;
        $model->recipient = $recipients;
        if(isset($postDataArray['cc_self']) && $postDataArray['cc_self']){
            $model->cc_self = $postDataArray['cc_self'];
            array_push($recipients, $user->email);
        }
        $model->schedule = $postDataArray['schedule'];
        $model->message = $postDataArray['message'];
        $model->search_string = json_encode($postDataArray['search_string']);
        $model->last_alert_sent_at = strtotime('now');
        
        $searchArray = $postDataArray['search_string'];
        $itemHtml = '<ul>';
        foreach ($searchArray['filters'] as $key => $filter) {
            if (!empty($filter)) {
                $model->$key = is_array($filter)?implode(',', $filter):$filter;
                $itemHtml .= '<li>'. SavedSearch::formattedFilter($key). ': '. SavedSearch::RelatedValue($key, $filter). '</li>';
            }
        }

        $itemHtml .= '</ul>';
            
        if($model->save()){
            $vars = [];
            $vars['{{%USER_NAME%}}'] = $user->commonName;
            $vars['{{%SEARCH_NAME%}}'] = $model->name;
            $vars['{{%MESSAGE%}}'] = $model->message;
            $vars['{{%SEARCH_LINK%}}'] = $model->searchUrl;
            $vars['{{%CRITERIA%}}'] = $itemHtml;
            foreach ($recipients as $recipient){
                MailSend::sendMail('SAVE_SEARCH', $recipient, $vars);
            }
            return ['status' => true, 'message' => 'Successfully Saved'];
        }
        return ['status' => false, 'errors' => $model->errors];
    }
    
    public function actionConfigSavedSearch($id){
        $this->layout = 'main';
        $model = SavedSearch::findOne($id);
        if($model->load(Yii::$app->request->post())){
            if($model->save()){
                return $this->redirect(['my-saved-searches']);
            }else{
                print_r($model->errors);
            }
        }
        return $this->render('config-saved-search', ['model' => $model]);
    }
    
    public function actionDeleteSavedSearch($id){
        $model = SavedSearch::findOne($id);
        $model->delete();
        return $this->redirect(['my-saved-searches']);
    }

    public function actionMySavedSearches(){
        $this->layout = 'main';
        $userId = Yii::$app->user->id;
        $searches = SavedSearch::find()->where(['user_id' => $userId])->orderBy(['id' => SORT_DESC])->active()->all();
        return $this->render('my-saved-searches', ['searches' => $searches]);
    }
    
    
    
    public function actionView($slug){
        $this->layout           =   'public_main';
        $property               =   Property::findOne(['slug' => $slug]);
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
            'userModel'         => $userModel,
        ]);
    }
}