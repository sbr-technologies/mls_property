<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%rental_feature}}".
 *
 * @property integer $id
 * @property integer $rental_id
 * @property integer $feature_master_id
 *
 * @property RentalFeatureMaster $featureMaster
 * @property Property $rental
 * @property RentalFeatureItem[] $rentalFeatureItems
 */
class RentalFeature extends \yii\db\ActiveRecord
{
    public $_destroy;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%rental_feature}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rental_id', 'feature_master_id'], 'required'],
            [['rental_id', 'feature_master_id'], 'integer'],
            [['feature_master_id'], 'exist', 'skipOnError' => true, 'targetClass' => RentalFeatureMaster::className(), 'targetAttribute' => ['feature_master_id' => 'id']],
            [['rental_id'], 'exist', 'skipOnError' => true, 'targetClass' => Property::className(), 'targetAttribute' => ['rental_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'rental_id' => Yii::t('app', 'Rental ID'),
            'feature_master_id' => Yii::t('app', 'Feature Master ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeatureMaster()
    {
        return $this->hasOne(RentalFeatureMaster::className(), ['id' => 'feature_master_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRental()
    {
        return $this->hasOne(Property::className(), ['id' => 'rental_id']);
    }
    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRentalFeatureItems()
    {
        return $this->hasMany(RentalFeatureItem::className(), ['rental_feature_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return RentalFeatureQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RentalFeatureQuery(get_called_class());
    }
}
