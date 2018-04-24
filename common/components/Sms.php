<?php

namespace common\components;

use Yii;

class Sms {

    private $smsClient;
    private $sms;

    function __construct() {
        require_once Yii::getAlias("@vendor/twilio/sdk/Services/Twilio.php");
        $this->smsClient = new \Services_Twilio(
                Yii::$app->params['smsAccountSID'], Yii::$app->params['smsAuthToken']
        );
    }

    private function prepareSms($sendTo, $template, $options) {

        if (isset($template->sms_text)) {
            $this->sms = ['message' => strtr($template->sms_text, $options)];
        } else {
            $this->sms = ['message' => @strtr($template, $options)];
        }


        if (is_object($sendTo)) {
            $phone = isset($sendTo->phone) ? $sendTo->phone : $sendTo->mobile1;
        } else {
            $this->sms['phoneNumber'] = $sendTo;
            return;
        }

        $this->sms['phoneNumber'] = "";
        if (!empty($phone) && !empty($sendTo->calling_code)) {
            $this->sms['phoneNumber'] = $sendTo->calling_code . $phone;
        }
    }

    public function sendSms($sendTo, $template, $options) {

        $this->prepareSms($sendTo, $template, $options);
        $text = $this->sms['message'];
        $phone = $this->sms['phoneNumber'];
        
        if (empty($phone) || empty($text)) {
            return false;
        }
        try {
            return $this->smsClient->account->messages->create(array(
                        "From" => Yii::$app->params['smsAccountSentFrom'],
                        "To" => $phone,
                        "Body" => $text,
            ));
        } catch (\Exception $e) {
            // do nothing
          //echo  $e->getMessage();
            return false;
        }
    }

}
