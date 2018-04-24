<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\Subscription;


use common\components\MailSend;
use common\components\Sms;


class SubscriptionController extends Controller{
    
    public function actionIndexPage(){
//        echo "Done\n";
        Yii::$app->mailer->compose()
                        //->setFrom([$adminEmail => $emailSender])
//                        ->setTo('shantinath.roy@sbr-technologies.com')
                        ->setTo(['shantinath.roy@sbr-technologies.com', 'abadewa@themlsproperties.com'])
                        ->setSubject('Test email')
                        ->setHtmlBody('Test description')
                        ->send();
    }
    
    public function actionExpiryReminder(){
        $subscriptions = Subscription::find()->with('user')->active()->all();
        foreach ($subscriptions as $subscription){
            $remainDays             =   null;
            $expiredDate    = date('Y-m-d', $subscription->subs_end);
            $todayDate      = date("Y-m-d", strtotime('now'));
            $days14ago = date('Y-m-d', strtotime('-14 days', strtotime($expiredDate)));
            $days7ago = date('Y-m-d', strtotime('-7 days', strtotime($expiredDate)));
            $days3ago = date('Y-m-d', strtotime('-3 days', strtotime($expiredDate)));
            $days1ago = date('Y-m-d', strtotime('-1 days', strtotime($expiredDate)));
            if($todayDate == $days14ago){
                $remainDays     = "14 days"; 
            }else if($todayDate == $days7ago){
                $remainDays     = "7 days";  
            }else if($todayDate == $days3ago){
                $remainDays     = "3 days"; 
            }else if($todayDate == $days1ago){
                $remainDays     = "1 day"; 
            }elseif($expiredDate == $todayDate){
                $remainDays = 'today';
            }
            
            if($remainDays){
                $opts = [];
                if($subscription->user_id){
                    $to = $subscription->user->email;
                    $opts['{{%SUBSCRIBER_NAME%}}']        = $subscription->user->commonName;
                    $opts['{{%REMAIN_DAY%}}']              = $remainDays;
                    $opts['{{%SUBSCRIBE_LINK%}}']           = Yii::$app->urlManager->createAbsoluteUrl(['subscription/plans', 'service_id' => 1]);
                }elseif ($subscription->agency_id) {
                    $to = $subscription->agency->operator->email;
                    $opts['{{%SUBSCRIBER_NAME%}}']        = $subscription->agency->name;
                    $opts['{{%REMAIN_DAY%}}']              = $remainDays;
                    $opts['{{%SUBSCRIBE_LINK%}}']           = Yii::$app->urlManager->createAbsoluteUrl(['agency-subscription/plans', 'service_id' => 1]);
                }
                MailSend::sendMail('SUBSCRIPTION_EXPIRY_REMINDER', $to, $opts);
            }
        }
    }
    
    public function actionUpdateStatus(){
        $now = time();
        $subscriptions = Subscription::find()->where(['<', 'subs_end', $now])->active()->all();
        foreach ($subscriptions as $subscription){
            $subscription->status = Subscription::STATUS_INACTIVE;
            $subscription->save();
        }
    }
}