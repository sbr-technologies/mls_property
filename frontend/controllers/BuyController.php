<?php
namespace frontend\controllers;

use Yii;
use common\models\Property;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\AdviceCategory;
use common\models\Advice;
use yii\web\Response;




/**
 * Site controller
 */
class BuyController extends Controller
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
    public function actionAllHome(){
        return $this->render('all-home');
    }
    
    public function actionNewHome(){ 
        return $this->render('new-home'); 
    }
    public function actionForeclosure(){
        return $this->render('foreclosure'); 
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
    
    public function actionDiscussion(){
        return $this->render('discussion'); 
    }
    
    public function actionPropertyRecords(){
        $state = Yii::$app->request->get('state');
        $city = Yii::$app->request->get('city');
        $zip = Yii::$app->request->get('zip');
        $stateName = '';
        $cityName = '';
        $stateCode = '';
        if(!empty($state)){
            $type = 'state';
            $list = Property::find()->select(['city', 'state_long', 'COUNT(*) AS cnt'])->where(['state' => $state])->groupBy(['city'])->orderBy(['state_long' => SORT_ASC])->active()->all();
            if(!empty($list)){
                $stateName = $list[0]->state_long;
                $stateCode = $list[0]->state;
            }
        }elseif(!empty ($city)){
            $type = 'city';
            $list = Property::find()->select(['zip_code', 'city', 'state_long', 'COUNT(*) AS cnt'])->where(['city' => $city])->groupBy(['zip_code'])->active()->all();
            if(!empty($list)){
                $stateName = $list[0]->state_long;
                $stateCode = $list[0]->state;
                $cityName = $city;
            }
        }elseif(!empty($zip)){
            $type = 'zip';
            $list = Property::find()->where(['zip_code' => $zip])->active()->all();
            if(!empty($list)){
                $stateName = $list[0]->state_long;
                $stateCode = $list[0]->state;
                $cityName = $list[0]->city;
            }
        }else{
            $type = 'all';
            $list = Property::find()->select(['state', 'state_long', 'COUNT(*) AS cnt'])->groupBy(['state'])->active()->all(); 
        }
        return $this->render('property-records', ['list' => $list, 'type' => $type, 'stateCode' => $stateCode, 'stateName' => $stateName, 'cityName' => $cityName, 'zip' => $zip]);
    }
}