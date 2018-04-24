<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%holiday_package_feature}}".
 *
 * @property integer $id
 * @property integer $holiday_package_id
 * @property integer $holiday_package_type_id
 * @property integer $name
 *
 * @property HolidayPackageType $holidayPackageType
 * @property HolidayPackage $holidayPackage
 */
class HolidayPackageFeature extends \yii\db\ActiveRecord
{
    public $_destroy;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%holiday_package_feature}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['holiday_package_id', 'holiday_package_type_id'], 'required'],
            [['holiday_package_id', 'holiday_package_type_id'], 'integer'],
            [['holiday_package_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => HolidayPackageType::className(), 'targetAttribute' => ['holiday_package_type_id' => 'id']],
            [['holiday_package_id'], 'exist', 'skipOnError' => true, 'targetClass' => HolidayPackage::className(), 'targetAttribute' => ['holiday_package_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'holiday_package_id' => Yii::t('app', 'Holiday Package ID'),
            'holiday_package_type_id' => Yii::t('app', 'Holiday Package Type ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHolidayPackageType()
    {
        return $this->hasOne(HolidayPackageType::className(), ['id' => 'holiday_package_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHolidayPackage()
    {
        return $this->hasOne(HolidayPackage::className(), ['id' => 'holiday_package_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHolidayPackageFeatureItems()
    {
        return $this->hasMany(HolidayPackageFeatureItem::className(), ['package_feature_id' => 'id']);
    }

    
    /**
     * @inheritdoc
     * @return HolidayPackageFeatureQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new HolidayPackageFeatureQuery(get_called_class());
    }
}
