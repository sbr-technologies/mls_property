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

use common\models\Agent;
use common\models\AgentSearch;

class AgentSuggestionController extends Controller{
    
    public function actionIndex(){
        $searchModel = new AgentSearch();
        $keyword = Yii::$app->request->get('q');
        $searchModel->keyword = $keyword;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $result = [];
        foreach ($dataProvider->getModels() as $agent){
            $result[] = ['id' => $agent->commonName, 'value' => $agent->fullName];
            // $result[] = ['id' => $agent->id, 'value' => $agent->fullName];
        }
        
        $result = array_map('unserialize', array_unique(array_map('serialize', $result)));
        return $result;
    }
}