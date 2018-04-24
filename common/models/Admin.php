<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\models;

class Admin extends User
{
    public function init()
    {
        $this->profile_id = self::PROFILE_ADMIN;
        parent::init();
    }

    public static function find()
    {
        return new UserQuery(get_called_class(), ['profileId' => self::PROFILE_ADMIN, 'tableName' => self::tableName()]);
    }

    public function beforeSave($insert)
    {
        $this->profile_id = self::PROFILE_ADMIN;
        return parent::beforeSave($insert);
    }
}