<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Response;
use yii\web\Controller;
use common\models\Property;
use frontend\models\PropertySearch;
use common\models\Rental;
use frontend\models\RentalSearch;
use common\models\PhotoGallery;
use common\models\LocationSuggestion;
use common\models\UserFavorite;

class SearchResultController extends Controller{
    
    public function init() {
        parent::init();
        $this->layout   =   'public_main';
    }
    
    public function actionIndex(){
        $postData                               = json_decode(file_get_contents('php://input'), true);
        $condition                              = [];
        $propertyFor                            = null;
        $viewType                               = $postData['view_type'];
        $requireJson                            = $postData['require_json'];
        $searchModel                            = new PropertySearch();
        $filters                                = $postData['filters'];
        $sortBy                                 = (isset($postData['sort'])?$postData['sort']:null);
        $searchModel->status                    = Property::STATUS_ACTIVE;
        $searchModel->categories                = $filters['categories'];
        if($postData['type'] == 'Property'){
            $propertyFor                        = 'Sale';
        }elseif($postData['type'] == 'Rental'){
            $propertyFor                        = 'Rent';
        }elseif($postData['type'] == 'ShortLet'){
            
            $propertyFor                        = 'Short Let';
        }
        $list_url = $postData['list_url'];
        Yii::$app->session->set('list_url', $list_url);
        
        $state = $town = $area = $lga = $zip = $district = '';
        $location = '';
        $breadcrumb = [];
        if(isset($filters['state']) && $filters['state']){
            $state = $searchModel->state = $filters['state'];
            $location = $state;
            array_push($breadcrumb, $state);
        }
        if(isset($filters['town']) && $filters['town']){
            $town = $searchModel->town = $filters['town'];
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
        if(isset($filters['area']) && $filters['area']){
            $area = $searchModel->area = $filters['area'];
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
        
        $searchModel->zip_code = $filters['zip_code'];
        $searchModel->local_govt_area = $filters['local_govt_area'];
        $searchModel->district = $filters['district'];
        
        $searchModel->street_address = $filters['street_address'];
        $searchModel->street_number = $filters['street_number'];
        $searchModel->appartment_unit = $filters['appartment_unit'];
        
        $searchModel->condominium = $filters['condominium'];

        $searchModel->minPrice                  = ($filters['min_price']?$filters['min_price']:null);
        $searchModel->maxPrice                  = ($filters['max_price']?$filters['max_price']:null);
        $searchModel->bedroomPlus               = $filters['bedroom'];
        $searchModel->bathroomPlus              = $filters['bathroom'];
        $searchModel->garagePlus                = $filters['garage'];
        $searchModel->toiletPlus                = $filters['no_of_toilet'];
        $searchModel->boysQuaterPlus            = $filters['no_of_boys_quater'];
        $searchModel->typesIn                   = $filters['prop_types'];
        $searchModel->constStatuses             = $filters['const_status'];
        $searchModel->marktStatuses             = $filters['market_statuses'];
        $searchModel->sortBy                    = $sortBy;
        $searchModel->propertyID                = $filters['property_id'];
        /**
         * For More filter options
         */
        $searchModel->sole_mandate              = (isset($filters['sole_mandate'])?$filters['sole_mandate']: null);
        $searchModel->featured                  = (isset($filters['featured_listing'])?$filters['featured_listing']:null);
        
        $lotSizeArr                             = explode('-', $filters['lot_size']);
        $buildingSizeArr                        = explode('-', $filters['building_size']);
        $houseSizeArr                           = explode('-', $filters['house_size']);
        
        $searchModel->minLotSize                = isset($lotSizeArr[0])?trim($lotSizeArr[0]):null;
        $searchModel->maxLotSize                = isset($lotSizeArr[1])?trim($lotSizeArr[1]):null;
        $searchModel->minBuildingSize           = isset($buildingSizeArr[0])?trim($buildingSizeArr[0]):null;
        $searchModel->maxBuildingSize           = isset($buildingSizeArr[1])?trim($buildingSizeArr[1]):null;
        $searchModel->minHouseSize              = isset($houseSizeArr[0])?trim($houseSizeArr[0]):null;
        $searchModel->maxHouseSize              = isset($houseSizeArr[1])?trim($houseSizeArr[1]):null;
        
        
        $yearBuiltArr                           = explode('-', $filters['year_built']);
        
        $searchModel->minYearBuilt              = isset($yearBuiltArr[0])?trim($yearBuiltArr[0]):null;
        $searchModel->maxYearBuilt              = isset($yearBuiltArr[1])?trim($yearBuiltArr[1]):null;
        $searchModel->agencyID                  = $filters['agency_id'];
        $searchModel->agencyName                = $filters['agency_name'];
//        $searchModel->teamID                    = $filters['team_id'];
//        $searchModel->teamName                  = $filters['team_name'];
        $searchModel->agentID                   = $filters['agent_id'];
        $searchModel->agentName                 = $filters['agent_name'];
        $generalFeatures                        = $filters['general_features'];
        $exteriorFeatures                       = $filters['exterior_features'];
        $interiorFeatures                       = $filters['interior_features'];
        
        $searchModel->listingFromDate = $filters['listing_from_date'];
        $searchModel->listingToDate = $filters['listing_to_date'];
        $searchModel->closingFromDate = $filters['closing_from_date'];
        $searchModel->closingToDate = $filters['closing_to_date'];
        
        $searchModel->generalFeatures           = $generalFeatures;
        $searchModel->exteriorFeatures          = $exteriorFeatures;
        $searchModel->interiorFeatures          = $interiorFeatures;
        /**
         * Pagination
         */
        
        $page = 0;
        if (isset($postData['page']) && !empty($postData['page']) && $postData['page'] > 0) {
            $page = (int) $postData['page'];
        }
        $dataProvider                           = $searchModel->search(null);
        $properties = $dataProvider->getModels();
        \frontend\helpers\PropertyHelper::filterListing($properties);
        $dataProvider->setTotalCount(count($properties));
        $dataProvider->pagination->page         = $page;
        $isLoggedIn                             = false;
        $pagination                             = $dataProvider->getPagination();
        if($postData['type'] == 'Property' && $viewType == 'list' || $requireJson == 'y'){
            return $this->renderAjax('realestate', ['totalCount' => $dataProvider->totalCount, 'properties' => $properties,'pagination' => $pagination, 'breadcrumb' => $breadcrumb, 'location' => $location, 'propertyFor' => $propertyFor, 'sortBy' => $sortBy, 'viewType' => $viewType,
                'city' => $town, 'state' => $state]);
        }elseif($postData['type'] == 'Rental' && $viewType == 'list' || $requireJson == 'y'){
            return $this->renderAjax('rental-appt', ['properties' => $properties,'pagination' => $pagination, 'breadcrumb' => $breadcrumb, 'location' => $location, 'propertyFor' => $propertyFor, 'sortBy' => $sortBy, 'viewType' => $viewType,
                'city' => $town, 'state' => $state]);
        }elseif($postData['type'] == 'Rental' && $viewType == 'list' || $requireJson == 'y'){
            return $this->renderAjax('short-let', ['properties' => $properties,'pagination' => $pagination, 'breadcrumb' => $breadcrumb, 'location' => $location, 'propertyFor' => $propertyFor, 'sortBy' => $sortBy, 'viewType' => $viewType,
                'city' => $town, 'state' => $state]);
        }
        $isFav                                  = false;
        $items                                  = [];
        if(!Yii::$app->user->isGuest){
            $isLoggedIn                         = true;
            $userId                             = Yii::$app->user->id;
        }
        $propListHtml = $this->renderAjax('realestate', ['totalCount' => $dataProvider->totalCount, 'properties' => $dataProvider->getModels(),'pagination' => $pagination, 'breadcrumb' => $breadcrumb, 'location' => $location, 'propertyFor' => $propertyFor, 'sortBy' => $sortBy, 'viewType' => $viewType,
                'city' => $town, 'state' => $state]);
        foreach($dataProvider->getModels() as $listing){
            if($isLoggedIn){
                $isFav                          = UserFavorite::find()->where(['model' => 'Property', 'model_id' => $listing->id, 'user_id' => $userId])->exists();
            }
            $items[$listing->id]                = [
                                                    'id'                        => $listing->id, 
                                                    'title'                     => $listing->title, 
                                                    'lat'                       => $listing->lat,
                                                    'lng'                       => $listing->lng, 
                                                    'price'                     => $listing->price, 
                                                    'price_as'                  => Yii::$app->formatter->asCurrency($listing->price),
                                                    'bedroom'                   => $listing->no_of_room, 
                                                    'bathroom'                  => $listing->no_of_bathroom, 
                                                    'size'                      => round($listing->lot_size). ' sq ft',
                                                    'feature_image'             => $listing->getFeatureImage(PhotoGallery::THUMBNAIL), 
                                                    'detail_url'                => Url::to(['property/view', 'slug' => $listing->slug]),
                                                    'address'                   => $listing->formattedAddress, 'city' => $town, 
                                                    'state'                     => $state, 
                                                    'is_fav'                    => $isFav
                                                ];
        }
        Yii::$app->response->format             = \yii\web\Response::FORMAT_JSON;
        return ['status' => true, 'propertyFor' => $propertyFor, 'propListHtml' => $propListHtml, 'results' => ['items' => $items]];
    }
}