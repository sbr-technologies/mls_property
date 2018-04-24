<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\ContactFormDb;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $full_name;
    public $email;
    public $subject;
    public $message;
    //public $verifyCode;
    public $salutation;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['salutation','full_name', 'email', 'subject', 'message'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
           // ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail($email)
    {
       // \yii\helpers\VarDumper::dump($email); exit;
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setSubject($this->subject)
            ->setTextBody($this->message)
            ->send();
    }
    
    public function sendContactMessage(){
        $modelDb                        = new ContactFormDb();
        $modelDb->salutation            = $this->salutation;
        $modelDb->full_name             = $this->full_name;
        $modelDb->email                 = $this->email;
        $modelDb->subject               = $this->subject;
        $modelDb->message               = $this->message;
        $modelDb->status                = 1;
        $modelDb->sent_at               = strtotime(date('Y-m-d'));
        if($modelDb->save()){
            Yii::$app
            ->mailer
            ->compose(
                ['html' => 'mlsContactPage-html'],
                ['contactFeedback' => $modelDb]
            )
            ->setTo(Yii::$app->params['adminEmail'])
            ->setSubject('Leave us a note for ' . Yii::$app->name)
            ->send();
            return true;
        } else {
            \yii\helpers\VarDumper::dump($modelDb->errors);exit;
        }
        
    }
    
}
