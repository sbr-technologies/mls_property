<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%hotel_owner_service_category_mapping}}".
 *
 * @property integer $id
 * @property integer $hotel_owner_id
 * @property integer $service_category_id
 *
 * @property User $hotelOwner
 * @property ServiceCategory $serviceCategory
 */
class HotelOwnerServiceCategoryMapping extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%hotel_owner_service_category_mapping}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hotel_owner_id', 'service_category_id'], 'required'],
            [['hotel_owner_id', 'service_category_id'], 'integer'],
            [['hotel_owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['hotel_owner_id' => 'id']],
            [['service_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ServiceCategory::className(), 'targetAttribute' => ['service_category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'hotel_owner_id' => Yii::t('app', 'Hotel Owner ID'),
            'service_category_id' => Yii::t('app', 'Service Category ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHotelOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'hotel_owner_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceCategory()
    {
        return $this->hasOne(ServiceCategory::className(), ['id' => 'service_category_id']);
    }

    /**
     * @inheritdoc
     * @return HotelOwnerServiceCategoryMappingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new HotelOwnerServiceCategoryMappingQuery(get_called_class());
    }
}
