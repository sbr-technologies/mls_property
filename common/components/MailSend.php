<?php

namespace common\components;

use yii\base\Component;
use common\models\EmailTemplate;
use common\models\SiteConfig;

class MailSend extends Component {

    public static function sendMail($temCode, $email, $var = array(), $subject = null) {
        $model = EmailTemplate::findOne(['code' => $temCode]);
        $adminEmail = SiteConfig::item('adminEmail');
        $emailSender = SiteConfig::item('emailSender');
        $search_by = array_keys($var);
        $replace_with = array_values($var);
        $content = str_replace($search_by, $replace_with, $model->content);
        $title = $model->title;
        if($subject == null){
            $subject = $model->subject;
        }
        ob_start();
        require(dirname(__FILE__) . '/../mail/layouts/html.php');
        $formatted = ob_get_clean();
        return \Yii::$app->mailer->compose()
                        ->setFrom([$adminEmail => $emailSender])
                        ->setTo($email)
                        ->setSubject($subject)
                        ->setHtmlBody($formatted)
                        ->send();
    }
    public static function sendSubjectMail($temCode, $email, $var = array(),$subject) {
        $model = EmailTemplate::findOne(['code' => $temCode]);
        $adminEmail = SiteConfig::item('adminEmail');
        $emailSender = SiteConfig::item('emailSender');
        $search_by = array_keys($var);
        $replace_with = array_values($var);
        $content = str_replace($search_by, $replace_with, $model->content);
        $title = $model->title;
        
        ob_start();
        require(dirname(__FILE__) . '/../mail/layouts/html.php');
        $formatted = ob_get_clean();
        return \Yii::$app->mailer->compose()
                        ->setFrom([$adminEmail => $emailSender])
                        ->setTo($email)
                        ->setSubject($model->title." ".$subject)
                        ->setHtmlBody($formatted)
                        ->send();
    }

}
