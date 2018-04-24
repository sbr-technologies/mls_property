<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\models;
use yii\helpers\StringHelper;

class Buyer extends User
{
    public function init()
    {
        $this->profile_id = self::PROFILE_BUYER;
        parent::init();
    }

    public static function find()
    {
        return new UserQuery(get_called_class(), ['profileId' => self::PROFILE_BUYER, 'tableName' => self::tableName()]);
    }
    public function getBuyerSocialMedias(){
        return $this->hasMany(SocialMediaLink::className(), ['model_id' => 'id'])->andOnCondition(['model' => StringHelper::basename($this->className())]);
    } 
    public function beforeSave($insert)
    {
        $this->profile_id = self::PROFILE_BUYER;
        return parent::beforeSave($insert);
    }
}