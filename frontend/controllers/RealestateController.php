<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\LocationSuggestion;
use common\models\Property;
use frontend\models\PropertySearch;
use yii\web\Response;
use common\models\SavedSearch;
use yii\filters\AccessControl;
use common\components\MailSend;
use yii\helpers\Inflector;

class RealestateController extends Controller{
    
    public function init() {
        parent::init();
        $this->layout   =   'public_main';
    }
    
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['save-search', 'my-saved-searches'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
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
        $condominium             = Yii::$app->request->get('condominium');
        $sortBy               = Yii::$app->request->get('sort');
        
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
        
        $searchModel->condominium = $condominium;
        
        $searchModel->sortBy                    = $sortBy;
        
//        \yii\helpers\VarDumper::dump($searchModel,12,1);die();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        if($type == 'map'){
           return $this->render('search-map'); 
        }
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
            'zipCode' => $zipCode, 'localGovtArea' => $localGovtArea, 'urbanTownArea' => $urbanTownArea, 'condominium' => $condominium, 'source' => $source]);
    }
    
    public function actionIndex(){
        return $this->render('index');
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
}