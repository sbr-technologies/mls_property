<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\models;
use yii\helpers\StringHelper;

class Seller extends User
{
    public function init()
    {
        $this->profile_id = self::PROFILE_SELLER;
        parent::init();
    }
    public function rules() {
        $rules = [
                [['payment_type_id'], 'integer'],
                [['payment_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PaymentTypeMaster::className(), 'targetAttribute' => ['payment_type_id' => 'id']],
                [['services'], 'safe']
            ];
        return array_merge(parent::rules(), $rules);
    }
    public static function find()
    {
        return new UserQuery(get_called_class(), ['profileId' => self::PROFILE_SELLER, 'tableName' => self::tableName()]);
    }

    public function beforeSave($insert)
    {
        $this->profile_id = self::PROFILE_SELLER;
        return parent::beforeSave($insert);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSellerServiceCategoryMappings()
    {
        return $this->hasMany(SellerServiceCategoryMapping::className(), ['seller_id' => 'id']);
    }
    public function getServices(){
        return \yii\helpers\ArrayHelper::getColumn($this->sellerServiceCategoryMappings, 'service_category_id');
    }
    
    public function setServices($values){
        if($this->isNewRecord){
            return;
        }
        SellerServiceCategoryMapping::deleteAll(['seller_id' => $this->id]);
        if(empty($values)){
            return;
        }
        foreach ($values as $value){
            $serviceCategory = new SellerServiceCategoryMapping(); //instantiate new SellerServiceCategoryMapping model
            $serviceCategory->seller_id = $this->id;
            $serviceCategory->service_category_id = $value;
            $serviceCategory->save();
        }
    }
    public function getPaymentType(){
        return $this->hasOne(PaymentTypeMaster::className(), ['id' => 'payment_type_id']);
    }
    public function getSellerSocialMedias(){
        return $this->hasMany(SocialMediaLink::className(), ['model_id' => 'id'])->andOnCondition(['model' => StringHelper::basename($this->className())]);
    }
}