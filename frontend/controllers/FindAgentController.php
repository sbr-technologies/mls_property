<?php
namespace frontend\controllers;


use Yii;
use yii\web\Controller;


use common\models\LocationSuggestion;
use common\models\User;
use frontend\models\AgentSearch;
use frontend\models\AgencySearch;
use yii\web\Response;
use frontend\models\TeamSearch;


/**
 * Site controller
 */
class FindAgentController extends Controller
{
    public function init() {
        $this->layout   =   'public_main';
    }

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
    
    public function actionSearch(){
        $params = Yii::$app->request->get();
        $filters = [];
        $searchModel = new AgentSearch();
        if(isset($params['location']) && $params['location']){
            $locationIdArr      = explode('_', $params['location']);
            if(count($locationIdArr) == 1){
                $searchModel->state = $locationIdArr[0];
                $filters['state'] = $locationIdArr[0];
            }elseif(count($locationIdArr) == 2){
                $searchModel->town = $locationIdArr[0];
                $searchModel->state = $locationIdArr[1];
                $filters['town'] = $locationIdArr[0];
                $filters['state'] = $locationIdArr[1];

            }elseif(count($locationIdArr) == 3) {
                $searchModel->area = $locationIdArr[0];
                $searchModel->town = $locationIdArr[1];
                $searchModel->state = $locationIdArr[2];
                $filters['area'] = $locationIdArr[0];
                $filters['town'] = $locationIdArr[1];
                $filters['state'] = $locationIdArr[2];
            }
        }
        
        foreach ($params as $key => $value){
            if($value){
                $searchModel->$key = $value;
                $filters[$key] = $value;
            }
        }
        if(isset($filters['name']) && $filters['name'] && isset($filters['agentID']) && $filters['agentID']){
            $filters['nameText'] = $filters['name']. ' ('. $filters['agentID']. ')';
        }
        if(isset($filters['agentID']) && $filters['agentID']){
            $filters['agentIDText'] = $filters['agentID']. ' ('. $filters['name']. ')';
        }
        if(isset($filters['officeName']) && $filters['officeName'] && isset($filters['officeID']) && $filters['officeID']){
            $filters['officeNameText'] = $filters['officeName']. ' ('. $filters['officeID']. ')';
        }
        if(isset($filters['officeID']) && $filters['officeID']){
            $filters['officeIDText'] = $filters['officeID']. ' ('. $filters['officeName']. ')';
        }
//        print_r($filters);die();
        $dataProvider = $searchModel->search(null);
        return $this->render('search', ['sortBy' => 'relevant', 'filters' => $filters,
            'dataProvider' => $dataProvider]);
    }
    
    public function actionSearchAgency(){
        $params = Yii::$app->request->get();
        $filters = [];
        $searchModel = new AgencySearch();
        foreach ($params as $key => $value){
            if($value){
                $searchModel->$key = $value;
                $filters[$key] = $value;
            }
        }
        if(isset($filters['name']) && $filters['name'] && isset($filters['agencyID']) && $filters['agencyID']) {
            $filters['nameText'] = $filters['name'] . ' (' . $filters['agencyID'] . ')';
        }
        if (isset($filters['agencyID']) && $filters['agencyID']) {
            $filters['agencyIDText'] = $filters['agencyID'] . ' (' . $filters['name'] . ')';
        }
        $dataProvider = $searchModel->search(null);
        return $this->render('search-agency', ['sortBy' => 'relevant', 'filters' => $filters,
            'dataProvider' => $dataProvider]);
    }
    
    public function actionSearchTeam(){
        $params = Yii::$app->request->get();
        $searchModel = new TeamSearch();
        $filters = [];
        foreach ($params as $key => $value){
            if($value){
                $searchModel->$key = $value;
                $filters[$key] = $value;
            }
        }
        $dataProvider = $searchModel->search(null);
        return $this->render('search-team', [
            'sortBy' => 'name', 'filters' => $filters,
            'dataProvider' => $dataProvider]);
    }

    

    public function actionWhyUseMls(){
        return $this->render('why-use-mls'); 
    }
    
    public function actionReasonBuyOrSell(){
        return $this->render('reason-buy-or-sell'); 
    }
    
    public function actionHowUseMls(){
        return $this->render('how-use-mls'); 
    }
    
    public function actionDifferenceAgentBroker(){
        return $this->render('difference-agent-broker'); 
    }
    
    public function actionListingBuyerAgent(){
        return $this->render('listing-buyer-agent'); 
    }
    
    public function actionHowFindMls(){
        return $this->render('how-find-mls'); 
    }
 
    public function actionAgentAdvSearch(){
        return $this->renderAjax('agent-adv-search'); 
    }
    public function actionOfficeAdvSearch(){
        return $this->renderAjax('office-adv-search'); 
    }
    public function actionTeamsAdvSearch(){
        return $this->renderAjax('teams-adv-search'); 
    }
            
}