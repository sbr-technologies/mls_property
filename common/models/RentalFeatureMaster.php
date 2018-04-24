<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%rental_feature_master}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $status
 *
 * @property RentalFeature[] $rentalFeatures
 */
class RentalFeatureMaster extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%rental_feature_master}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRentalFeatures()
    {
        return $this->hasMany(RentalFeature::className(), ['feature_master_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return RentalFeatureMasterQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RentalFeatureMasterQuery(get_called_class());
    }
}
