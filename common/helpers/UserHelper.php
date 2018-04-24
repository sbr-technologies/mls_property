<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\helpers;

use common\models\User;


class UserHelper{
    
    public static function admins(){
        return User::find()->where(['profile_id' => [1, 2]])->active()->all();
    }
}