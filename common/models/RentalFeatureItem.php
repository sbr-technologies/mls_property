<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%rental_feature_item}}".
 *
 * @property integer $id
 * @property integer $rental_feature_id
 * @property string $name
 *
 * @property RentalFeature $rentalFeature
 */
class RentalFeatureItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%rental_feature_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rental_feature_id'], 'required'],
            [['rental_feature_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['rental_feature_id'], 'exist', 'skipOnError' => true, 'targetClass' => RentalFeature::className(), 'targetAttribute' => ['rental_feature_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'rental_feature_id' => Yii::t('app', 'Rental Feature ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRentalFeature()
    {
        return $this->hasOne(RentalFeature::className(), ['id' => 'rental_feature_id']);
    }

    /**
     * @inheritdoc
     * @return RentalFeatureItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RentalFeatureItemQuery(get_called_class());
    }
}
