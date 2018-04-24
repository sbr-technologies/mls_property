<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use yii\web\Response;
use common\models\UserConfig;


use common\components\MailSend;
use common\components\Sms;
use common\models\EmailTemplate;
/**
 * Signup form
 */
class SignupForm extends Model
{
    public $profile_id;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $confirm_password;
    public $mobile1;
    public $verifyCode;
    public $calling_code;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['profile_id', 'required'],
            
            ['first_name', 'trim'],
            ['first_name', 'required'],
            
            ['last_name', 'trim'],
            ['last_name', 'required'],
            
            ['mobile1', 'required'],
            
            ['calling_code', 'trim'],
//            //['username', 'required'],
//            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
//            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            
            ['confirm_password', 'required'],
            ['confirm_password', 'string', 'min' => 6],
            ['confirm_password', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match"],
            ['verifyCode', 'required'],
            ['verifyCode', 'captcha']
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) { //echo 11;exit;
            $user = new User();
            $user->profile_id = $this->profile_id;
            $user->first_name = $this->first_name;
            $user->last_name = $this->last_name;
            $user->calling_code = $this->calling_code;
            $user->mobile1 = $this->mobile1;
            $user->status = "pending";
            $user->email = $this->email;
            $user->email_activation_sent = strtotime('now'); 
            $user->rawPassword = $this->password;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->generateEmailActivationKey();
            if($user->save()){
                $userId                         = $user->id;
                $userConfigModel                = new UserConfig();
                $userConfigModel->user_id       = $userId;
                $userConfigModel->title         = "User Registration";
                $userConfigModel->type          = "system";
                $userConfigModel->key           = "profileSetup";
                $userConfigModel->value         = "no";
                $userConfigModel->save();
                if($user->profile_id == User::PROFILE_AGENCY){
                    $userConfigModel                = new UserConfig();
                    $userConfigModel->user_id       = $userId;
                    $userConfigModel->title         = "Agency Registration";
                    $userConfigModel->type          = "system";
                    $userConfigModel->key           = "agencySetup";
                    $userConfigModel->value         = "no";
                    $userConfigModel->save();
                }
                $template       =   EmailTemplate::findOne(['code' => 'NEW_USER_EMAIL_VERIFICATION']);
                $arrr['{{%USER_FULL_NAME%}}']            = $user->fullName;
                $arrr['{{%EMAIL_VERIFICATION_LINK%}}']   = Yii::$app->urlManager->createAbsoluteUrl(['site/verify', 'key' => $user->email_activation_key]);
                $arrr['{{%USER_EMAIL%}}']                = $user->email;
                $arrr['{{%USER_PASSWORD%}}']             = $user->rawPassword;
                MailSend::sendMail('NEW_USER_EMAIL_VERIFICATION', $this->email, $arrr);
                return  $user;
            }
        }
        return null;
    }
    
    
    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateEmailAddress($emailId)
    {
        return !User::find()->where(['email' => $emailId])->exists();
    }
}
