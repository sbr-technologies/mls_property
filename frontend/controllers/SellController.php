<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\AdviceCategory;
use common\models\Advice;
use common\models\Property;
use yii\base\Exception;
use common\models\PropertyEnquiery;
use yii\helpers\Url;
use common\models\User;
use common\models\StaticPage;
use frontend\models\PropertySearch;
use common\models\PhotoGallery;



/**
 * Site controller
 */
class SellController extends Controller
{
    public function init() {
        $this->layout   =   'public_main';
    }
    /**
     * @inheritdoc
     */
    

    /**
     * @inheritdoc
     */
    public function actions(){
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex(){
        return $this->render('index');
    }
    
    public function actionSelectAnAgent(){ 
        return $this->render('select-an-agent'); 
    }
    public function actionDiscussion(){
        return $this->render('discussion'); 
    }
    
    public function actionRecentSold(){
        return $this->render('recent-sold'); 
    }
    
    public function actionBuyingTips(){
        $adviceCategory = AdviceCategory::find()->where(['id' => 1])->one();
        $adviceDetails = Advice::find()->where(['advice_category_id' => 1])->all();
        if(empty($adviceDetails)){
//            throw new NotFoundHttpException(Yii::t('app', 'Invalid data'));
            $adviceDetails    =[];
        }
        return $this->render('buying-tips',[
            'adviceDetails'   => $adviceDetails,
            'adviceCategory'  =>  $adviceCategory,
            ]
        );
    }
    
    public function actionEstimate(){
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
        $viewType           = Yii::$app->request->get('view_type');
        $sortBy         = Yii::$app->request->get('sort');
        
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
        $toiletArr          = explode('-', $noOfToilet);
        $boysQuaterArr      = explode('-', $noOfBoysQuater);
        $yearBuiltArr       = explode('-', $yearBuilt);
//        if(empty($categories)){
//            $categories     = [2];
//        }
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
        $searchModel->garagePlus      = $garage;
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
        $searchModel->sortBy                    = $sortBy;
        
        $isLoggedIn = false;
        $isFav = false;
        if(!Yii::$app->user->isGuest){
            $isLoggedIn                         = true;
            $userId                             = Yii::$app->user->id;
        }
        
//        \yii\helpers\VarDumper::dump($searchModel,12,1);die();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = false;
        $list_url = Yii::$app->request->url;
        Yii::$app->session->set('list_url', $list_url);
        $items = [];
        if($viewType == 'map' || $viewType == 'chart'){
            foreach($dataProvider->getModels() as $listing) {
                if($isLoggedIn){
                    $isFav                          = UserFavorite::find()->where(['model' => 'Property', 'model_id' => $listing->id, 'user_id' => $userId])->exists();
                }
                $items[$listing->id] = [
                    'id' => $listing->id,
                    'propertyID' => $listing->reference_id,
                    'title' => $listing->title,
                    'lat' => $listing->lat,
                    'lng' => $listing->lng,
                    'price' => $listing->price,
                    'sold_price' => $listing->sold_price,
                    'price_as' => Yii::$app->formatter->asCurrency($listing->price),
                    'sold_price_as' => Yii::$app->formatter->asCurrency($listing->sold_price),
                    'bedroom' => $listing->no_of_room,
                    'bathroom' => $listing->no_of_bathroom,
                    'size' => round($listing->lot_size) . ' sq ft',
                    'feature_image' => $listing->getFeatureImage(PhotoGallery::THUMBNAIL),
                    'detail_url' => Url::to(['property/view', 'slug' => $listing->slug]),
                    'address' => $listing->formattedAddress, 'city' => $town,
                    'state' => $state,
                    'is_fav' => $isFav
                ];
            }
        }
        
        
        return $this->render('estimate', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel, 'items' => $items, 'town' => $town, 'state' => $state, 'area' => $area,
            'location' => $location, 'breadcrumb' => $breadcrumb, 'sortBy' => $sortBy, 'category' => 'Property', 'category_id' => 2,
            'constStatuses' => $constStatuses, 'marktStatuses' => $marktStatuses, 'categories' => $categories,
            'minPrice' => $minPrice, 'maxPrice' => $maxPrice, 'bedroom' => $bedroom, 'bathroom' => $bathroom, 'garage' => $garage, 'propTypes' => $propTypes, 
            'lotSize' => $lotSize,'buildingSize' => $buildingSize,'houseSize' => $houseSize,
            'noOfToilet' => $noOfToilet,'noOfBoysQuater' => $noOfBoysQuater,'yearBuilt' => $yearBuilt,'agencyID' => $agencyID,
            'agentID' => $agentID,'agentName' => $agentName,'generals' => $generals, 'exteriors' => $exteriors, 'interiors' => $interiors,
            'teamID' => $teamID, 'teamName' => $teamName, 'agencyName' => $agencyName, 'soleMandate' => $soleMandate, 'featuredListing' => $featuredListing,
            'propertyID' => $propertyID, 'streetAddress' => $streetAddress, 'streetNumber' => $streetNumber,'appartmentUnit' => $appartmentUnit,
            'zipCode' => $zipCode, 'localGovtArea' => $localGovtArea, 'urbanTownArea' => $urbanTownArea, 'source' => $source, 'viewType' => $viewType]);
    }
    public function actionView($slug){
        $staticPage = StaticPage::findBySlug($slug);
        // \yii\helpers\VarDumper::dump($staticPage,4,12); exit;
        return $this->render('view',['staticPage' => $staticPage]);
    }
    public function actionWhipItIntoShape(){
        return $this->render('whip-it-into-shape');
    }
}