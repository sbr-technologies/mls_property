<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\models;

class HotelOwner extends User
{
    public function init()
    {
        $this->profile_id = self::PROFILE_HOTEL;
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
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHotelOwnerServiceCategoryMappings()
    {
        return $this->hasMany(HotelOwnerServiceCategoryMapping::className(), ['hotel_owner_id' => 'id']);
    }
    public function getServices(){
        return \yii\helpers\ArrayHelper::getColumn($this->hotelOwnerServiceCategoryMappings, 'service_category_id');
    }
    
    public function setServices($values){
        if($this->isNewRecord){
            return;
        }
        HotelOwnerServiceCategoryMapping::deleteAll(['hotel_owner_id' => $this->id]);
        if(empty($values)){
            return;
        }
        foreach ($values as $value){
            $serviceCategory = new HotelOwnerServiceCategoryMapping(); //instantiate new SellerServiceCategoryMapping model
            $serviceCategory->hotel_owner_id = $this->id;
            $serviceCategory->service_category_id = $value;
            $serviceCategory->save();
        }
    }
    public function getPaymentType(){
        return $this->hasOne(PaymentTypeMaster::className(), ['id' => 'payment_type_id']);
    }
    public static function find()
    {
        return new UserQuery(get_called_class(), ['profileId' => self::PROFILE_HOTEL, 'tableName' => self::tableName()]);
    }

    public function beforeSave($insert)
    {
        $this->profile_id = self::PROFILE_HOTEL;
        return parent::beforeSave($insert);
    }
}