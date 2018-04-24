<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%seller_service_category_mapping}}".
 *
 * @property integer $id
 * @property integer $seller_id
 * @property integer $service_category_id
 *
 * @property User $seller
 * @property ServiceCategory $serviceCategory
 */
class SellerServiceCategoryMapping extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%seller_service_category_mapping}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['seller_id', 'service_category_id'], 'required'],
            [['seller_id', 'service_category_id'], 'integer'],
            [['seller_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['seller_id' => 'id']],
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
            'seller_id' => Yii::t('app', 'Seller ID'),
            'service_category_id' => Yii::t('app', 'Service Category ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeller()
    {
        return $this->hasOne(User::className(), ['id' => 'seller_id']);
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
     * @return SellerServiceCategoryMappingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SellerServiceCategoryMappingQuery(get_called_class());
    }
}
