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


class RentalController extends Controller{
    
    public $context;
    public function init() {
        parent::init();
        $this->layout   =   'public_main';
        $this->context = ['service_id' => 1, 'user' => Yii::$app->user->identity];
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
        $rentType           = Yii::$app->request->get('rent_type');
        $state             = Yii::$app->request->get('state');
        $town             = Yii::$app->request->get('town');
        $area             = Yii::$app->request->get('area');
        $source             = Yii::$app->request->get('source');
        $condominium             = Yii::$app->request->get('condominium');
        
        if(empty($marktStatuses)){
            $marktStatuses  =   'Active';
        }
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
//        print_r($marktStatuses); exit;
        if(isset($rentType) && $rentType == 'short_let'){
            $propCategories     = [3];
        }elseif(!empty ($categories)){
            $propCategories = $categories;
        }else{
            $propCategories     = [1];
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

        
//        \yii\helpers\VarDumper::dump($searchModel,12,1); exit;
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
        $searchModel->minYearBuilt      = isset($yearBuiltArr[0])?trim($yearBuiltArr[0]):null;
        $searchModel->maxYearBuilt      = isset($yearBuiltArr[1])?trim($yearBuiltArr[1]):null;
        $searchModel->agentID           = $agentID;
        $searchModel->agencyID          = $agencyID;
        $searchModel->agentName         = $agentName;
        $searchModel->categories        = $propCategories;
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
        
        $searchModel->condominium = $condominium;
//        \yii\helpers\VarDumper::dump($searchModel,12,1);die();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        if($type == 'map'){
           return $this->render('search-map'); 
        }
        
        return $this->render('search', ['town' => $town, 'state' => $state, 'area' => $area,
            'location' => $location, 'breadcrumb' => $breadcrumb, 'sortBy' => 'relevant', 'category' => 'Property', 'category_id' => 1,
            'constStatuses' => $constStatuses, 'marktStatuses' => $marktStatuses, 'categories' => $propCategories,
            'minPrice' => $minPrice, 'maxPrice' => $maxPrice, 'bedroom' => $bedroom, 'bathroom' => $bathroom, 'garage' => $garage, 'propTypes' => $propTypes, 
            'dataProvider' => $dataProvider,'lotSize' => $lotSize,'buildingSize' => $buildingSize,'houseSize' => $houseSize,
            'noOfToilet' => $noOfToilet,'noOfBoysQuater' => $noOfBoysQuater,'yearBuilt' => $yearBuilt,'agencyID' => $agencyID,
            'agentID' => $agentID,'agentName' => $agentName,'generals' => $generals, 'exteriors' => $exteriors, 'interiors' => $interiors,
            'teamID' => $teamID, 'teamName' => $teamName, 'agencyName' => $agencyName, 'soleMandate' => $soleMandate, 'featuredListing' => $featuredListing,
            'propertyID' => $propertyID, 'streetAddress' => $streetAddress, 'streetNumber' => $streetNumber,'appartmentUnit' => $appartmentUnit,
            'zipCode' => $zipCode, 'localGovtArea' => $localGovtArea, 'urbanTownArea' => $urbanTownArea, 'condominium' => $condominium, 'source' => $source]);
    }
    
    public function actionIndex(){
        return $this->render('index');
    }
    
    public function actionDiscussion(){
        return $this->render('discussion'); 
    }
    public function actionMonthToMonth(){
        return $this->render('month-to-month'); 
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
        Yii::$app->response->format         = Response::FORMAT_JSON;
        if(Yii::$app->user->isGuest){
            return ['status' => false, 'is_guest' => true, 'message' => 'You are not logged in'];
        }
        $propertyEnquiry                    = new PropertyEnquiery();
        $propertyEnquieryData               =   Yii::$app->request->post('PropertyEnquiery');
        
        if ($propertyEnquiry->load(Yii::$app->request->post())) {
            Yii::$app->response->format     = Response::FORMAT_JSON;
            $property_url                   =   $propertyEnquieryData['property_url'];
            
            $property                       =   Property::findOne($propertyEnquiry->model_id);
            $userMail                       =   $property->user->email;
            $propertyEnquiry->assign_to     = $property->user->id;
            $propertyEnquiry->status        = 'pending';
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if($propertyEnquiry->save()){
                    Yii::$app
                    ->mailer
                    ->compose(
                        ['html' => 'rentalEnquieryRequest-html'],
                        ['propertyEnquiry' => $propertyEnquiry,'property_url' => $property_url]
                    )
                    ->setTo($userMail)
                    ->setSubject('NaijaHouses.com Contact Message about Property ID# '.$propertyEnquiry->rental->referenceId)
                    ->send();
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
    public function actionRequestShowing($id = Null){
        $this->layout           =   'public_main';
        $propertyData           =   Property::find()->where(['id' => $id])->one();
        $openHouseData          =   $propertyData->openHouses;
        //\yii\helpers\VarDumper::dump($openHouseData,4,12); exit;
        if(isset(Yii::$app->user->id)){
            $userId                     =   Yii::$app->user->id;
            $userModel                  =   User::findOne(['id' => $userId]);
        }else{
            $userModel                  =   new User();
        }
        $model                  =   new PropertyShowingRequest();
        
        return $this->renderAjax('request-showing', [
            'model'             => $model,
            'propertyData'      =>  $propertyData,
            'userModel'         =>  $userModel,
            'openHouseData'     =>  $openHouseData,
        ]);
        
    }
    public function actionSendRequestShowing(){
        $this->layout                   =   'public_main';
        $model                          =   new PropertyShowingRequest();
        $model->status                  =   'pending';
        $time   =   Yii::$app->request->post('PropertyShowingRequest');
        if(!empty($time['time'])){
            $model->time        =   $time['time'];

        }else{
            $model->time        =   '';
        }
        if ($model->load(Yii::$app->request->post())) {
            if(isset($model->time) && $model->time != ''){
                $model->scheduleDate        =   $model->schedule." ".$model->time;
                $dateTime                   =   $model->schedule;
                $date                       =   '';
            }else{ 
                $model->scheduleDate        =   $model->schedule;
                $date                       =   $model->schedule;
                $dateTime                   =   '';
            }
            Yii::$app->response->format     = Response::FORMAT_JSON;
            if(!empty(Yii::$app->user->id)){
                $model->user_id = Yii::$app->user->id;
            }
            $model->status              = 'pending';
            $model->model               = 'Property';
            //\yii\helpers\VarDumper::dump($model, 4,12); exit;
            $transaction = Yii::$app->db->beginTransaction(); 
            //try {
                if($model->save()){ 
                    //\yii\helpers\VarDumper::dump($model->property->user->emailAddress); exit;
                    Yii::$app
                    ->mailer
                    ->compose(
                        ['html' => 'rentalShowingRequest-html'],
                        ['propertyRequest' => $model,'date' => $date,'dateTime' => $dateTime]
                    )
                    ->setTo($model->rental->user->emailAddress)
                    ->setSubject('Property Showing Request Form for ' . Yii::$app->name)
                    ->send();

                    Yii::$app
                    ->mailer
                    ->compose(
                        ['html' => 'rentalShowingRequest-html'],
                        ['propertyRequest' => $model,'date' => $date,'dateTime' => $dateTime]
                    )
                    ->setTo(Yii::$app->params['adminEmail'])
                    ->setSubject('Property Showing Request Form for ' . Yii::$app->name)
                    ->send();
                    
                    $transaction->commit();
                    return ['success' => true,'message' => 'Thank you for Sending Request for proerty.We will respond to you as soon as possible'];exit;
                }else{
                    $transaction->rollBack();
                    //\yii\helpers\VarDumper::dump($model->errors);
                    return ['success' => false,'message' => 'Following Fileds can not be blank','errors' => $model->errors]; exit;   
                }
                
//            } catch (Exception $ex) {
//                $transaction->rollBack();
//            }
        }
//        return $this->render('request',[
//            'model'             =>  $model,
//        ]);
    }
    
    public function actionDeletePhoto($id){
        $photo = PhotoGallery::findOne($id);
        if($photo->delete()){
            echo json_encode(array('status' => 'success', 'message' => 'One image delete successfully'));die();
        }else{
            echo json_encode(array('status' => 'failed', 'message' =>'Sorry, We are unable to process your data'));die();
        }
    }
    
    public function actionDelete($id){
        $model = $this->findModel($id);
        foreach ($model->photos as $photo){
            $photo->delete();
        }
        $openHouse = OpenHouse::findOne(['model_id' => $id,'model' => 'Property']);
        if(!empty($openHouse)){
            $openHouse->delete();
        }
        PropertyLocationLocalInfo::deleteAll(['rental_id' => $id]);
//        PropertyPlan::deleteAll(['rental_id' => $id]);
        $model->delete();
        Yii::$app->session->setFlash('success', 'Successfully deleted');
        //return $this->redirect(['rental-list']);
    }
    /**
     * Displays homepage.
     *
     * @return mixed
     */
//    public function actionRentalList(){
//        $this->layout   =   'main';
//        $searchModel = new PropertySearch();
//        $searchModel->user_id = Yii::$app->user->id;
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        return $this->render('rental-list', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
//    }
    
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