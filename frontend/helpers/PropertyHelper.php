<?php
namespace frontend\helpers;
use Yii;
use common\models\UserFavorite;
use common\models\Subscription;
use common\models\User;
class PropertyHelper {
    public static function isFavorite($propertyId){
        $model = UserFavorite::find()->where(['model' => 'Property', 'model_id' => $propertyId, 'user_id' => Yii::$app->user->id])->one();
        return !empty($model);
    }
    
    public static function intVal($val){
        if(strpos($val, '.') !== false){
            $val = substr($val, 0, strpos($val, '.')+1);
        }
        $cleanVal = (int)preg_replace('/[^\d]/', '', $val);
        return $cleanVal;
    }
    public static function getNumberFormatShort( $n, $precision = 1 ) {
        if ($n < 900) {
                // 0 - 900
                $n_format = number_format($n, $precision);
                $suffix = '';
        } else if ($n > 999) {
                // 0.9k-850k
                $n_format = number_format($n / 1000, $precision);
                $suffix = 'K';
        } 
  // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
  // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ( $precision > 0 ) {
                $dotzero = '.' . str_repeat( '0', $precision );
                $n_format = str_replace( $dotzero, '', $n_format );
        }
        return $n_format . $suffix;
    }
    
    
    public static function filterListing(& $properties){
        return true;
        foreach ($properties as $key => $property){
            if($property->created_at > strtotime('-30 days') ){
                continue;
            }
            $user = \common\models\User::findOne($property->user_id);
            $subs = null;
            if(AuthHelper::is('agent')){
                $subs = Subscription::find()->where(['agency_id' => $user->agency_id, 'service_category_id' => 1])->active()->one();
            }            
            if(empty($subs)){
                $subs = Subscription::find()->where(['user_id' => $property->user_id, 'service_category_id' => 1])->active()->one();
            }
            if(empty($subs)){
                unset($properties[$key]);
                continue;
            }
            if($subs){
                $plan = $subs->plan;
                if($subs->subs_end < strtotime('now')){
                    unset($properties[$key]);
                }elseif($plan->number_of_premium_listing === 0 && $property->preimum_lisitng){
                    unset($properties[$key]);
                }
            }
        }
        
    }
    
    public static function canList($context){
        $user = $context['user'];
        if($user->total_listings <= 5){
            return true;
        }
        $subs = null;
        if(AuthHelper::is('agent')){
            $subs = Subscription::find()->where(['agency_id' => $user->agency_id, 'service_category_id' => $context['service_id']])->active()->one();
        }
        if(empty($subs)){
            $subs = Subscription::find()->where(['user_id' => $user->id, 'service_category_id' => $context['service_id']])->active()->one();
        }
        if(empty($subs)){
            return false;
        }
        $plan = $subs->plan;
        if($user->total_listings >= $plan->number_of_standard_listing){
            return false;
        }
        
        return true;
    }
    
    public static function createVerified($model, $context){
        $user = $context['user'];
        $subs = null;
        if(AuthHelper::is('agent')){
            $subs = Subscription::find()->where(['agency_id' => $user->agency_id, 'service_category_id' => $context['service_id']])->active()->one();
        }
        if(empty($subs)){
            $subs = Subscription::find()->where(['user_id' => $user->id, 'service_category_id' => $context['service_id']])->active()->one();
        }
        if(empty($subs)){
            return false;
        }
//        if($subs->subs_end < strtotime('now')){
//            return false;
//        }
        $plan = $subs->plan;
        if($plan->number_of_standard_listing !== null && $user->total_listings >= $plan->number_of_standard_listing){
            return false;
        }
        if($model->preimum_lisitng){
            $totalPremiumListings = \common\models\Property::find()->where(['user_id' => $user->id, 'preimum_lisitng' => 1])->active()->count();
            if($plan->number_of_premium_listing !== null && $totalPremiumListings >= $plan->number_of_premium_listing){
                return false;
            }
        }
        return true;
    }
    
    public static function updateVerified($model, $context){
        $user = $context['user'];
        $subs = null;
        if(AuthHelper::is('agent')){
            $subs = Subscription::find()->where(['agency_id' => $user->agency_id, 'service_category_id' => $context['service_id']])->active()->one();
        }
        if(empty($subs)){
            $subs = Subscription::find()->where(['user_id' => $user->id, 'service_category_id' => $context['service_id']])->active()->one();
        }
        if(empty($subs)){
            return false;
        }
//        if($subs->subs_end < strtotime('now')){
//            return false;
//        }
        $plan = $subs->plan;
        if($plan->number_of_standard_listing !== null && $user->total_listings > $plan->number_of_standard_listing){
            return false;
        }
        if($model->preimum_lisitng){
            $totalPremiumListings = \common\models\Property::find()->where(['user_id' => $user->id, 'preimum_lisitng' => 1])->active()->count();
            if($plan->number_of_premium_listing !== null && $totalPremiumListings > $plan->number_of_premium_listing){
                return false;
            }
        }
        return true;
    }
}