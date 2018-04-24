<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Hotel;
use frontend\models\HotelSearch;
use common\models\LocationSuggestion;

class HotelSearchResultController extends Controller{
    
    public function actionIndex(){
        $postData = json_decode(file_get_contents('php://input'), true);
        $filters = $postData['filters'];
        $locationId = $postData['location'];
        $zipSearch              = false;
        $searchModel            = new HotelSearch();
        $searchModel->status    = Hotel::STATUS_ACTIVE;
        $locationIdArr          = explode('_', $locationId);
        //\yii\helpers\VarDumper::dump($locationIdArr); exit;
        
        $searchModel->ratingPlus = $filters['rating'];
        $searchModel->facilitiesIn = $filters['facilities'];
        $searchModel->name = $filters['name'];
        $hotelName = '';
        if(count($locationIdArr) == 2){
            $searchModel->city  = $locationIdArr[0];
            $searchModel->state = $locationIdArr[1];
            $condition = ['city' => $locationIdArr[0], 'state' => $locationIdArr[1]];
        }elseif(is_numeric($locationId)){
            $searchModel->zip_code  = $locationId;
            $condition = ['zip_code' => $locationId];
            $zipSearch = true;
        }
        $sortBy = $postData['sort'];
        $searchModel->sortBy = $sortBy;
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $locationObj = LocationSuggestion::find()->where($condition)->one();
        $locationObj->searchType = ($zipSearch? 'zip':'city');
        $location = $locationObj->formattedLocation;
        
        return $this->renderAjax('index', ['hotelName' => $hotelName, 'locationId' => $locationId, 'city' => $locationObj->city, 'state' => $locationObj->state, 'location' => $location, 'sortBy' => $sortBy, 'dataProvider' => $dataProvider]);
    }
}