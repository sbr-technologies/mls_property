<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

use common\models\LocationSuggestion;
use frontend\models\LocationSuggestionSearch;

use common\models\AddressSuggestion;
use common\models\AddressSuggestionSearch;

class LocationSuggestionController extends Controller{
    
    public function init() {
        parent::init();
        Yii::$app->response->format = Response::FORMAT_JSON;
    }

    public function actionIndex(){
        $keyword = Yii::$app->request->get('q');
        $result = [];
        
        $searchModel = new LocationSuggestionSearch();
        $searchModel->state = $keyword;
        $searchModel->fields = ['state'];
        $dataProvider = $searchModel->search(null);
        foreach ($dataProvider->getModels() as $key => $location){
            if($key == 0){
                $result[] = ['id' => $location->state, 'value' => $location->state, 'location_type' => 'State'];
            }else{
                $result[] = ['id' => $location->state, 'value' => $location->state];
            }
        }
        $searchModel = new LocationSuggestionSearch();
        if(strpos($keyword, ',') ===false){
            $searchModel->city = $keyword;
            $searchModel->fields = ['city', 'state'];
        }elseif(count(explode(',', $keyword)) == 2){
            $searchModel->cityState = $keyword;
            $searchModel->fields = ['city', 'state'];
        }
        $dataProvider = $searchModel->search(null);
        foreach ($dataProvider->getModels() as $key => $location){
            if($key == 0){
                $result[] = ['id' => $location->city. '_'. $location->state, 'value' => $location->city. ', '. $location->state, 'location_type' => 'Town'];
            }else{
                $result[] = ['id' => $location->city. '_'. $location->state, 'value' => $location->city. ', '. $location->state];
            }
        }
        $searchModel = new LocationSuggestionSearch();
        if(strpos($keyword, ',') ===false){
            $searchModel->area = $keyword;
            $searchModel->fields = ['area', 'city', 'state'];
        }elseif(count(explode(',', $keyword)) == 2){
            $searchModel->areaCity = $keyword;
            $searchModel->fields = ['area', 'city', 'state'];
        }elseif(count(explode(',', $keyword)) == 3){
            $searchModel->areaCityState = $keyword;
            $searchModel->fields = ['area', 'city', 'state'];
        }
        $dataProvider = $searchModel->search(null);
        foreach ($dataProvider->getModels() as $key => $location){
            if($key == 0){
                $result[] = ['id' => $location->area. '_'. $location->city. '_'. $location->state, 'value' => $location->area. ', '. $location->city. ', '. $location->state, 'location_type' => 'Area'];
            }else{
                $result[] = ['id' => $location->area. '_'. $location->city. '_'. $location->state, 'value' => $location->area. ', '. $location->city. ', '. $location->state];
            }
        }
        
        $rs = array_map('unserialize', array_unique(array_map('serialize', $result)));
        return $rs;
    }
    
    public function actionAddress(){
        $keyword = Yii::$app->request->get('q');
        $result = [];
        
        $searchModel = new AddressSuggestionSearch();
        $searchModel->street_name = $keyword;
        $searchModel->fields = ['street_name'];
        $dataProvider = $searchModel->search(null);
        foreach ($dataProvider->getModels() as $key => $location){
            if($key == 0){
                $result[] = ['id' => $location->street_name, 'value' => $location->street_name, 'location_type' => 'Street'];
            }else{
                $result[] = ['id' => $location->street_name, 'value' => $location->street_name];
            }
        }
        
        $searchModel = new AddressSuggestionSearch();
        if(strpos($keyword, ',') ===false){
            $searchModel->street_number = $keyword;
            $searchModel->fields = ['street_number', 'street_name'];
            $dataProvider = $searchModel->search(null);
            foreach ($dataProvider->getModels() as $key => $location){
                if($key == 0){
                    $result[] = ['id' => $location->street_number. '_'. $location->street_name, 'value' => $location->street_number. ', '. $location->street_name, 'location_type' => 'Street #'];
                }else{
                    $result[] = ['id' => $location->street_number. '_'. $location->street_name, 'value' => $location->street_number. ', '. $location->street_name];
                }
            }
        }elseif(count(explode(',', $keyword)) == 2){
            $searchModel->streetNumberName = $keyword;
            $searchModel->fields = ['street_number', 'street_name'];
            $dataProvider = $searchModel->search(null);
            foreach ($dataProvider->getModels() as $key => $location){
                if($key == 0){
                    $result[] = ['id' => $location->street_number. '_'. $location->street_name, 'value' => $location->street_number. ', '. $location->street_name, 'location_type' => 'Street #'];
                }else{
                    $result[] = ['id' => $location->street_number. '_'. $location->street_name, 'value' => $location->street_number. ', '. $location->street_name];
                }
            }
        }
        
        $searchModel = new AddressSuggestionSearch();
        if(strpos($keyword, ',') ===false){
            $searchModel->suite_number = $keyword;
            $searchModel->fields = ['street_number', 'street_name', 'suite_number'];
        }elseif(count(explode(',', $keyword)) == 2){
            $searchModel->streetNameSuite = $keyword;
            $searchModel->fields = ['street_number', 'street_name', 'suite_number'];
        }elseif(count(explode(',', $keyword)) >= 3){
            $searchModel->streetNumberNameSuite = $keyword;
            $searchModel->fields = ['street_number', 'street_name', 'suite_number'];
        }
        $dataProvider = $searchModel->search(null);
        $i=0;
        foreach ($dataProvider->getModels() as $key => $location){
            if(empty($location->suite_number)){
                continue;
            }
            if($location->suite_number && $i == 0){
                $result[] = ['id' => $location->street_number. '_'. $location->street_name. '_'. $location->suite_number, 'value' => $location->street_number. ', '. $location->street_name. ', '. $location->suite_number, 'location_type' => 'Apartment/Unit/Suite #'];
            }elseif($location->suite_number){
                $result[] = ['id' => $location->street_number. '_'. $location->street_name. '_'. $location->suite_number, 'value' => $location->street_number. ', '. $location->street_name. ', '. $location->suite_number];
            }
            $i++;
        }
        
        $rs = array_map('unserialize', array_unique(array_map('serialize', $result)));
        return $rs;
    }
    
    public function actionComplete(){
        $keyword = Yii::$app->request->get('q');
        $result = [];
        $searchModel = new LocationSuggestionSearch();
        if(strpos($keyword, ',') ===false){
            $searchModel->area = $keyword;
        }elseif(count(explode(',', $keyword)) == 2){
            $searchModel->areaCity = $keyword;
        }elseif(count(explode(',', $keyword)) == 3){
            $searchModel->areaCityState = $keyword;
        }
        $dataProvider = $searchModel->search(null);
        foreach ($dataProvider->getModels() as $location){
            $result[] = ['id' => $location->area. '_'. $location->city. '_'. $location->state, 'value' => $location->area. ', '. $location->city. ', '. $location->state];
        }
        $rs = array_map('unserialize', array_unique(array_map('serialize', $result)));
        return $rs;
    }
    
    public function actionGetStates(){
        $keyword = Yii::$app->request->get('q');
        $records = LocationSuggestion::find()->where(['LIKE', 'state', $keyword])->select('state')->distinct()->orderBy(['state' => SORT_ASC])->all();

        $result = [];
        foreach ($records as $rec){
            $result[] = ['value' => $rec->state];
        }
        return $result;
    }
    
    public function actionGetTowns(){
        $params = Yii::$app->request->post('depdrop_parents');
        $state = $params[0];
//        $records = LocationSuggestion::find()->where(['state' => $state])->andWhere(['LIKE', 'city', $keyword])->select('city')->distinct()->all();
        $result = [];
        if($state){
            $records = LocationSuggestion::find()->where(['state' => $state])->select('city')->distinct()->orderBy(['city' => SORT_ASC])->all();
            foreach ($records as $rec){
                if(trim($rec->city)){
                    $result[] = ['id' => $rec->city, 'name' => $rec->city];
                }
            }
        }
        return ['output'=>$result, 'selected'=>''];
    }
    
    public function actionGetAreas(){
//        $keyword = Yii::$app->request->get('q');
//        $city = Yii::$app->request->get('town');
        $params = Yii::$app->request->post('depdrop_parents');
        $city = $params[0];
        $result = [];
        if($city){
            $records = LocationSuggestion::find()->where(['city' => $city])->select('area')->distinct()->orderBy(['area' => SORT_ASC])->all();
            foreach ($records as $rec){
                if(trim($rec->area)){
                    $result[] = ['id' => $rec->area, 'name' => $rec->area];
                }
            }
        }
        return ['output'=>$result, 'selected'=>''];
    }
    
    public function actionGetZipCodes(){
        $params = Yii::$app->request->post('depdrop_parents');
        $city = $params[0];
        $result = [];
        if($city){
            $records = LocationSuggestion::find()->where(['city' => $city])->select('zip_code')->distinct()->orderBy(['zip_code' => SORT_ASC])->all();
            foreach ($records as $rec){
                if(trim($rec->zip_code)) {
                    $result[] = ['id' => $rec->zip_code, 'name' => $rec->zip_code];
                }
            }
        }
        return ['output'=>$result, 'selected'=>''];
    }
    
    public function actionGetLocalGovtArea(){
        $params = Yii::$app->request->post('depdrop_parents');
        $state = $params[0];
        $result = [];
        if($state){
            $records = LocationSuggestion::find()->where(['state' => $state])->select('local_government_area')->distinct()->all();
            foreach ($records as $rec){
                if(trim($rec->local_government_area)){
                    $result[] = ['id' => $rec->local_government_area, 'name' => $rec->local_government_area];
                }
            }
        }
        return ['output'=>$result, 'selected'=>''];
    }
    
    public function actionGetDistricts(){
        $params = Yii::$app->request->post('depdrop_parents');
        $local_govt_area = $params[0];
        $result = [];
        if($local_govt_area){
            $records = LocationSuggestion::find()->where(['local_government_area' => $local_govt_area])->select('district')->distinct()->all();
            foreach ($records as $rec){
                if(trim($rec->district)){
                    $result[] = ['id' => $rec->district, 'name' => $rec->district];
                }
            }
        }
        return ['output'=>$result, 'selected'=>''];
    }
    
    public function actionGetTownAndLga(){
        $state = Yii::$app->request->post('selected_state');
        $towns = [];
        $lgas = [];
        if($state){
            $records = LocationSuggestion::find()->where(['state' => $state])->select('city')->distinct()->orderBy(['city' => SORT_ASC])->all();
            foreach ($records as $rec){
                if(trim($rec->city)){
                    $towns[] = ['label' => $rec->city, 'value' => $rec->city];
                }
            }
            $records = LocationSuggestion::find()->where(['state' => $state])->select('local_government_area')->distinct()->all();
            foreach ($records as $rec){
                if(trim($rec->local_government_area)){
                    $lgas[] = ['label' => $rec->local_government_area, 'value' => $rec->local_government_area];
                }
            }
        }
        return ['output'=>['towns' => $towns, 'lgas' => $lgas], 'selected'=>''];
    }
    
    public function actionGetAreaAndZip(){
        $city = Yii::$app->request->post('selected_cities');
        $areas = [];
        $zips = [];
        if($city){
            $records = LocationSuggestion::find()->where(['city' => $city])->select(['city'])->addSelect(["GROUP_CONCAT(DISTINCT area ORDER BY area ASC SEPARATOR ',') AS area"])->groupBy(['city'])->orderBy(['city' => SORT_ASC])->all();
            foreach ($records as $rec){
                $rs = [];
                if(trim(str_replace(',', '', $rec->area))){
                    $exp = explode(',', $rec->area);
                    foreach ($exp as $ex){
                        array_push($rs, ['label' => $ex, 'value' => $ex]);
                    }
                    $areas[] = ['label' => $rec->city, 'children' => $rs];
                }
            }
            $records = LocationSuggestion::find()->where(['city' => $city])->select(['city'])->addSelect(["GROUP_CONCAT(DISTINCT zip_code ORDER BY zip_code ASC SEPARATOR ',') AS zip_code"])->groupBy(['city'])->orderBy(['city' => SORT_ASC])->all();
            foreach ($records as $rec){
//                if(trim($rec->zip_code)){
//                    $zips[] = [$rec->city => ['label' => $rec->zip_code, 'value' => $rec->zip_code]];
//                }
                $rs = [];
                if (trim($rec->zip_code)) {
                    $exp = array_unique(explode(',', $rec->zip_code));
                    foreach ($exp as $ex) {
                        if($ex)
                            array_push($rs, ['label' => $ex, 'value' => $ex]);
                    }
                    $zips[] = ['label' => $rec->city, 'children' => $rs];
                }
            }
        }
        return ['output'=>['areas' => $areas, 'zips' => $zips], 'selected'=>''];
    }
    
    public function actionGetDistrictMultiLga(){
        $lga = Yii::$app->request->post('selected_lgaes');
        $districts = [];
        if($lga){
            $records = LocationSuggestion::find()->where(['local_government_area' => $lga])->select(['local_government_area'])->addSelect(["GROUP_CONCAT(DISTINCT district ORDER BY district ASC SEPARATOR ',') AS district"])->groupBy(['local_government_area'])->orderBy(['local_government_area' => SORT_ASC])->all();
            foreach ($records as $rec){
                $rs = [];
                if(trim($rec->district)){
                    $exp = explode(',', $rec->district);
                    foreach ($exp as $ex){
                        if($ex)
                            array_push($rs, ['label' => $ex, 'value' => $ex]);
                    }
                    $districts[] = ['label' => $rec->local_government_area, 'children' => $rs];
                }
            }
        }
        return ['output'=>['districts' => $districts], 'selected'=>''];
    }
}