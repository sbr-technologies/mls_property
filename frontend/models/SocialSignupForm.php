<?php

namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;
use yii\web\Response;

/**
 * Signup form
 */
class SocialSignupForm extends Model {

    public $profile_id;
    public $first_name;
    public $last_name;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['first_name', 'last_name', 'profile_id'], 'safe'],
//            [['profile_id'], 'required'],
//            
                //['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup() {
        if ($this->validate()) {
            $user = new User();
            $id = Yii::$app->user->identity->id;
            $socialId = substr($id, strpos($id, '-'));
            $userAttributs = Yii::$app->getSession()->get('user-' . $id);
            $socialProfile = $userAttributs['socialProfile'];
            $user->social_id = $socialProfile['id'];
            $user->social_type = $socialProfile['service'];
//            $user->profile_id = $this->profile_id;
            $user->profile_id = User::PROFILE_BUYER;
            $user->username = substr($socialProfile['id'], 0, 25);
            $password = $user->getRandomPassword();
            $user->setPassword($password);
            $name = explode(' ', $socialProfile['name']);
            
            $user->first_name = $name[0];
            $user->last_name = isset($name[1]) ? $name[1] : $name[0];
            if (isset($socialProfile['email']) && !empty($socialProfile['email'])) {
                $exists = User::find()->where(['email' => $socialProfile['email']])->exists();
                if($exists === FALSE){
                    $user->email = $socialProfile['email'];
                }
            }else{
                $user->email = $socialProfile['id']. '@mlsproperty.com';
            }
            $user->status = User::STATUS_ACTIVE;
            if ($user->save()) {
                return ['status' => true, 'user' => $user];
            } else {
                return ['status' => false, 'errors' => $user->getErrors()];
            }
        } else {
            return ['status' => false, 'errors' => $user->getErrors()];
        }

        return null;
    }

}
