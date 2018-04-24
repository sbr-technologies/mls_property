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
use common\models\Agent;
use frontend\models\TeamSearch;
use frontend\models\AgencySearch;
use common\models\Team;

class TeamSearchResultController extends Controller{
    
    public function init() {
        parent::init();
        $this->layout   =   'public_main';
    }
    
    public function actionIndex(){
        $postData = json_decode(file_get_contents('php://input'), true);
       // \yii\helpers\VarDumper::dump($postData,12,1); exit;
        $filters = $postData['filters'];
        $searchModel = new TeamSearch();
        foreach ($filters as $key => $value){
            if($value){
                $searchModel->$key = $value;
            }
        }
        $searchModel->sortBy = $postData['sortBy'];
        $page = 0;
        if (isset($postData['page']) && !empty($postData['page']) && $postData['page'] > 0) {
            $page = (int) $postData['page'];
        }
        $dataProvider = $searchModel->search(null);
        $dataProvider->pagination->page         = $page;
        return $this->renderAjax('index', ['filters' => $filters, 'sortBy' => $postData['sortBy'], 'dataProvider' => $dataProvider]);
    }
       
}