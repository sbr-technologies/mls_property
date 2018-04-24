<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%rental_extension}}".
 *
 * @property integer $id
 * @property integer $property_id
 * @property integer $studio
 * @property integer $pet_friendly
 * @property integer $in_unit_laundry
 * @property integer $pools
 * @property integer $homes
 * @property string $rental_category
 * @property string $price_for
 * @property integer $service_fee
 * @property string $service_fee_for
 * @property integer $other_fee
 * @property string $other_fee_for
 *
 * @property Property $property
 */
class RentalExtension extends \yii\db\ActiveRecord
{
    const MARKET_STATUS_ACTIVE = 'Active';
    const MARKET_STATUS_PENDING = 'Pending';
    const MARKET_STATUS_SOLD = 'Sold';
    const MARKET_STATUS_LEASED = 'Leased';
    const MARKET_STATUS_TEMPORARY = 'Temporary';
    const MARKET_STATUS_NOT_AVALAIBLE = 'Not Avalaible';
    
    
    
    const STUDIO_YES = 1;
    const STUDIO_NO = 0;
    
    const PET_FRIENDLY_YES = 1;
    const PET_FRIENDLY_NO = 0;
    
    const UNIT_LAUNDRY_YES = 1;
    const UNIT_LAUNDRY_NO = 0;
    
    const POOLS_YES = 1;
    const POOLS_NO = 0;
    
    const HOMES_YES = 1;
    const HOMES_NO = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%rental_extension}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['property_id', 'studio', 'pet_friendly', 'in_unit_laundry', 'pools', 'homes', 'service_fee', 'other_fee'], 'integer'],
            [['price_for'], 'string', 'max' => 35],
            [['contact_term','contact_term_for','market_status','service_fee_payment_term','other_fee_payment_term','other'],'string','max' => 100],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Property::className(), 'targetAttribute' => ['property_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'property_id' => Yii::t('app', 'Property ID'),
            'studio' => Yii::t('app', 'Studio'),
            'pet_friendly' => Yii::t('app', 'Pet Friendly'),
            'in_unit_laundry' => Yii::t('app', 'In Unit Laundry'),
            'pools' => Yii::t('app', 'Pools'),
            'homes' => Yii::t('app', 'Homes'),
            'market_status' => Yii::t('app', 'Market Status'),
            'price_for' => Yii::t('app', 'Payment Term'),
            'service_fee' => Yii::t('app', 'Service Fee'),
            'contact_term' => Yii::t('app', 'Contact Term'),
            'other_fee' => Yii::t('app', 'Other Fee'),
            'contact_term_for' => Yii::t('app', 'Contact Term For'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(Property::className(), ['id' => 'property_id']);
    }

    public function getPetFriendly(){
        return $this->pet_friendly == 1 ? "Yes" : "No";
    }
    public function getInUnitLaundry(){
        return $this->in_unit_laundry == 1 ? "Yes" : "No";
    }
    public function getPool(){
        return $this->pools == 1 ? "Yes" : "No";
    }
    public function getHome(){
        return $this->homes == 1 ? "Yes" : "No";
    }
    public function getStudios(){
        return $this->studio == 1 ? "Yes" : "No";
    }
    /**
     * @inheritdoc
     * @return RentalExtensionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RentalExtensionQuery(get_called_class());
    }
}
