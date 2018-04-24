<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%holiday_package_feature_item}}".
 *
 * @property integer $id
 * @property integer $package_feature_id
 * @property string $name
 *
 * @property HolidayPackageFeature $packageFeature
 */
class HolidayPackageFeatureItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%holiday_package_feature_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['package_feature_id'], 'required'],
            [['package_feature_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['package_feature_id'], 'exist', 'skipOnError' => true, 'targetClass' => HolidayPackageFeature::className(), 'targetAttribute' => ['package_feature_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'package_feature_id' => Yii::t('app', 'Package Feature ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPackageFeature()
    {
        return $this->hasOne(HolidayPackageFeature::className(), ['id' => 'package_feature_id']);
    }

    /**
     * @inheritdoc
     * @return HolidayPackageFeatureItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new HolidayPackageFeatureItemQuery(get_called_class());
    }
}
