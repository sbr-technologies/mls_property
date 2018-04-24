<?php 
 
namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\Property;
use common\models\SavedSearch;


use common\components\MailSend;
use common\components\Sms;
use common\models\EmailTemplate;
 
/**
 * Booking CronJob controller
 */
class PropertyController extends Controller {
 
   
    public function actionIndexPage(){
//        $properties = Property::find()->where(['auth_key' => null])->all();
//        foreach ($properties as $p){
//            $p->auth_key = Yii::$app->security->generateRandomString();
//            $p->save(false);
//        }
    }

    public function actionStatusUpdateRem()
    {
        $now      = time();
        $oneMonth = strtotime("-30 days", $now);
        $properties = Property::find()->andWhere(['<', 'rem_sent_at', $oneMonth])->active()->all();
//        echo $properties;die();
        $queue = [];
        foreach ($properties as $property){
            $queue[$property->user_id][] = $property;
            $property->rem_sent_at = strtotime('now');
            $property->save();
        }
        
        foreach($queue as $userId => $models){
            $thumbs = $this->renderPartial('thumbs_update', ['models' => $models]);
            $userModel = \common\models\User::findOne($userId);
            $opt = [];
            $opt['{{%FULL_NAME%}}']                  = $userModel->fullName;
            $opt['{{%PROPERTY_THUMBS%}}']           = $thumbs;
            MailSend::sendMail('PROPERTY_STATUS_UPDATE_REMINDER', $userModel->email, $opt); // $userModel->email abadewas@yahoo.com shantinath.roy@sbr-technologies.com
        }
//        foreach ($properties as $property){
//            $lastTime = $property->rem_sent_at;
//            if(empty($lastTime)){
//                $lastTime = $property->created_at;
//            }
//            
//            $now = new \DateTime();
//            $now->modify("-30 days");
//            $time = $now->getTimestamp();
//            
//            if($time > $lastTime){
//                /**
//                 * Email to recipient
//                 */
//                $ar['{{%FULL_NAME%}}']                  = $property->user->fullName;
//                $ar['{{%PROPERTY_ADDRESS%}}']           = $property->formattedAddress;
//                $ar['{{%PROPERTY_PRICE%}}']             = Yii::$app->formatter->asCurrency($property->price);
//                $ar['{{%PROPERTY_LISTED_DATE%}}']       = Yii::$app->formatter->asDate($property->listed_date);
//
//                MailSend::sendMail('PROPERTY_STATUS_UPDATE_REMINDER', $property->user->email, $ar);
//                $property->rem_sent_at = strtotime('now');
//                $property->save();
//            }
//
//        }
    }
    public function actionExpiryReminder(){
        $today      = date("Y-m-d");
        $oneMonth = date('Y-m-d', strtotime("+35 days", strtotime($today)));
        $properties = Property::find()->where(['<', 'expired_date', $oneMonth])->active()->all();
        $queue = [];
        foreach ($properties as $property){
            $daysExpiring = $property->getDaysExpiring();
//            echo $daysExpiring. "\n";
            if(in_array($daysExpiring, [0, 1, 3, 7, 14, 30])){
                $queue[$property->user_id][] = $property;
            }
        }
//        print_r($queue);die();
        foreach($queue as $userId => $models){
            $thumbs = $this->renderPartial('thumb', ['models' => $models]);
            $userModel = \common\models\User::findOne($userId);
            $opt = [];
            $opt['{{%FULL_NAME%}}']                  = $userModel->fullName;
            $opt['{{%PROPERTY_THUMBS%}}']           = $thumbs;

            MailSend::sendMail('PROPERTY_EXPIRY_REMINDER', $userModel->email, $opt); //'abadewas@yahoo.com' shantinath.roy@sbr-technologies.com
//                    
//            $expiredDate    = $property->expired_date;
//            if(!empty($expiredDate)){
//                $days30ago = date('Y-m-d', strtotime('-14 days', strtotime($expiredDate)));
//                $days14ago = date('Y-m-d', strtotime('-14 days', strtotime($expiredDate)));
//                $days7ago = date('Y-m-d', strtotime('-7 days', strtotime($expiredDate)));
//                $days3ago = date('Y-m-d', strtotime('-7 days', strtotime($expiredDate)));
//                $days1ago = date('Y-m-d', strtotime('-1 days', strtotime($expiredDate)));
//                $days0ago = date('Y-m-d', strtotime('-1 days', strtotime($expiredDate)));
//                if(strtotime($today) == strtotime($days14ago)){
//                    $remainDays     = "14 days"; 
//                }else if(strtotime($today) == strtotime($days7ago)){
//                    $remainDays     = "7 days";  
//                }else if(strtotime($today) == strtotime($days1ago)){
//                    $remainDays     = "1 day"; 
//                }
//                if(!empty($remainDays)){
//                    $template = EmailTemplate::findOne(['code' => 'PROPERTY_EXPIRY_REMINDER']);
//                    
//                }
//                
//            }
        }
    }
    
    public function actionNotifySavedList() {
        $savedSearchItems = SavedSearch::find()->where(['schedule' => ['daily', 'weekly', 'monthly']])->active()->all();
        if(!empty($savedSearchItems)){
            foreach ($savedSearchItems as $savedItem){
                $curTime = strtotime('now');
                $today = date('Y-m-d', $curTime);
                $lastAlert = date('Y-m-d', $savedItem->last_alert_sent_at);
                if($savedItem->schedule == 'weekly'){
                    $lastUpdate = date('Y-m-d', strtotime("$lastAlert +1 week"));
                    if($today != $lastUpdate){
                        continue;
                    }
                }
                if($savedItem->schedule == 'monthly'){
                    $lastUpdate = date('Y-m-d', strtotime("$lastAlert +1 month"));
                    if($today != $lastUpdate){
                        continue;
                    }
                }
                $catWhere = '';
                $typeWhere = '';
                $constWhere = '';
                $stateWhere = '';
                $townWhere = '';
                $areaWhere = '';
                $propIDWhere = '';
                if($savedItem->categories){
                    $catWhere = " AND property_category_id IN ({$savedItem->categories})";
                }
                if($savedItem->prop_types){
                    $typeIds = explode(',', $savedItem->prop_types);
                    $typeWhere .= " AND(";
                    foreach ($typeIds as $item){
                        $typeWhere .= " FIND_IN_SET('".$item."', property_type_id)>0 OR";
                    }
                    $typeWhere = substr($typeWhere, 0, -3);
                    $typeWhere .= ')';
                }
                if($savedItem->const_statuses){
                    $constIds = explode(',', $savedItem->const_statuses);
                    $constWhere .= " AND(";
                    foreach ($constIds as $item){
                        $constWhere .= " FIND_IN_SET('".$item."', construction_status_id)>0 OR";
                    }
                    $constWhere = substr($constWhere, 0, -3);
                    $constWhere .= ')';
                }
                if($savedItem->state){
                    $stateWhere = " AND state='".$savedItem->state."'";
                }
                if($savedItem->town){
                    $towns = "'" . implode("','", explode(',', $savedItem->town)). "'";
                    $townWhere = " AND town IN($towns)";
                }
                
                if($savedItem->area){
                    $areas = "'" . implode("','", explode(',', $savedItem->area)). "'";
                    $areaWhere = " AND area IN ($areas)";
                }
                if($savedItem->property_id){
                    $propIDWhere = " AND reference_id='".$savedItem->property_id."'";
                }
                
                $propSql = "SELECT id FROM ". Property::tableName(). "WHERE status='active' AND market_status in ('".Property::MARKET_PENDING."', '".Property::MARKET_ACTIVE."', '".Property::MARKET_SOLD."')"
                        . " AND updated_at>{$savedItem->last_alert_sent_at}{$catWhere}{$typeWhere}{$constWhere}{$stateWhere}{$townWhere}{$areaWhere}{$propIDWhere}";
                
                $properties = Property::findBySql($propSql)->all();
                
                if(!empty($properties)){
                    $user = $savedItem->user;
                    $recipients = $savedItem->recipient;
                    if ($savedItem->cc_self) {
                        array_push($recipients, $user->email);
                    }
                    $itemHtml = '<ul>';
                    $searchArray = json_decode($savedItem->search_string);
                    foreach ($searchArray->filters as $key => $filter) {
                        if (!empty($filter)) {
                            $itemHtml .= '<li><strong>' . SavedSearch::formattedFilter($key) . ':</strong> ' . SavedSearch::RelatedValue($key, $filter) . '</li>';
                        }
                    }

                    $itemHtml .= '</ul>';

                    if (!empty($recipients)) {
                        $vars = [];
                        $vars['{{%USER_NAME%}}'] = $user->commonName;
                        $vars['{{%CRITERIA%}}'] = $itemHtml;
                        $vars['{{%SEARCH_NAME%}}'] = $savedItem->name;
                        $vars['{{%MESSAGE%}}'] = $savedItem->message;
                        $vars['{{%SEARCH_LINK%}}'] = $savedItem->searchUrl;
                        
                        $thumb = $this->renderPartial('//shared/thumbs', ['models' => $properties]);
                        $vars['{{%PROPERTY_THUMBS%}}'] = $thumb;
                        
                        $savedSearchModel = SavedSearch::findOne($savedItem->id);
                        $savedSearchModel->last_alert_sent_at = $curTime;
                        $savedSearchModel->save();
                        foreach($recipients as $recipient){
                            MailSend::sendMail('SAVED_PROPERTY_ALERT', $recipient, $vars);
                        }
                    }
                }
            }
        }
    }
    
    public function actionUpdateMarketStatus(){
        $today = date('Y-m-d');
//        $properties = Property::find()->where(['market_status' => 'active'])->andWhere(['<', 'expired_date', $today])->all();
//        foreach ($properties as $property){
//            $property->market_status = Property::MARKET_EXPIRED;
//            $property->save();
//        }
        \Yii::$app->db->createCommand("UPDATE ".Property::tableName()." SET market_status=:marketExpired WHERE market_status=:marketActive AND expired_date<:today")
        ->bindValue(':marketExpired', Property::MARKET_EXPIRED)
                ->bindValue(':marketActive', Property::MARKET_ACTIVE)
                ->bindValue(':today', $today)
                ->execute();
    }
}