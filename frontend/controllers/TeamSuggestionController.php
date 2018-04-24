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

use common\models\Team;
use common\models\TeamSearch;

class TeamSuggestionController extends Controller{
    
    public function actionIndex(){
        $searchModel = new TeamSearch();
        $keyword = Yii::$app->request->get('q');
        $searchModel->keyword = $keyword;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        Yii::$app->response->format = Response::FORMAT_JSON;
        foreach ($dataProvider->getModels() as $team){
            $result[] = ['id' => $team->id, 'value' => $team->name];
        }
        
        $result = array_map('unserialize', array_unique(array_map('serialize', $result)));
        return $result;
    }
}