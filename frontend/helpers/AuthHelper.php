<?php
namespace frontend\helpers;
use Yii;
use common\models\Subscription;
use common\models\User;
class AuthHelper {
    public static function is($type, $strict = false){
        $user = Yii::$app->user->identity;
        if(empty($user)){
            return false;
        }
        if($strict == false && $type == 'agent' && $user->profile_id == User::PROFILE_AGENCY){
            return $user->broker_is_agent == 1;
        }
        $userType = $user->profile->type; //print_r($userType."++".$type);
        return $userType == $type;
    }
    
    public static function Can($context){
        $user = Yii::$app->user->identity;
        if(empty($user)){
            return false;
        }
        $subscribedServices = [];
        $subscriptions = Subscription::find()->where(['user_id' => $user->id])->active()->all();
//        \yii\helpers\VarDumper::dump($subscriptions, 11,1);die();
        foreach ($subscriptions as $subscription){
            $plan = $subscription->plan;
            array_push($subscribedServices, $plan->service_category_id);
        }
        return in_array($context['service_id'], $subscribedServices);
    }
    
    public static function canModify($model, $type = 'Property'){
        $user = Yii::$app->user->identity;
        if(empty($user)){
            return false;
        }
        if(static::is('agent', true) || static::is('seller')){
            return $model->user_id == $user->id;
        }elseif (static::is('agency')) {
            $agents = \yii\helpers\ArrayHelper::getColumn(User::find()->where(['agency_id' => $user->agency_id])->all(), 'id');
            return in_array($model->user_id, $agents);
        }
        return false;
    }
}