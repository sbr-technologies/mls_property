<?php

namespace common\helpers;

class SendMail {
    public static function send($temCode, $to, $subject, $var = array()) {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => $temCode.'-html'],
                [$var]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($to)
            ->setSubject($subject)
            ->send();
    }
}
