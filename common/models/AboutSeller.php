<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%about_seller}}".
 *
 * @property string $id
 * @property string $user_id
 * @property string $property_type_id
 * @property string $price_range
 * @property string $duration
 * @property string $uses
 * @property string $occupation
 * @property string $salary_income
 * @property integer $need_agent
 * @property integer $contact_me
 */
class AboutSeller extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%about_seller}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'propertyTypeIds', 'need_agent', 'contact_me'], 'required'],
            [['user_id', 'need_agent', 'contact_me'], 'integer'],
            [['property_type_id', 'price_range', 'duration', 'uses'], 'string', 'max' => 75],
            [['occupation'], 'string', 'max' => 255],
            [['salary_income'], 'string', 'max' => 125],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'property_type_id' => Yii::t('app', 'Property Type ID'),
            'propertyTypeIds' => Yii::t('app', 'Home Type'),
            'price_range' => Yii::t('app', 'Price Range'),
            'duration' => Yii::t('app', 'Duration'),
            'uses' => Yii::t('app', 'Uses'),
            'occupation' => Yii::t('app', 'Occupation'),
            'salary_income' => Yii::t('app', 'Salary Income'),
            'need_agent' => Yii::t('app', 'Need Agent'),
            'contact_me' => Yii::t('app', 'Contact Me'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public function getPropertyTypeIds()
    {
        return explode(',', $this->property_type_id);
    }
    
    public function setPropertyTypeIds($value)
    {
        $this->property_type_id = (is_array($value)?implode(',', $value):'');
    }
    /**
     * @inheritdoc
     * @return AboutSellerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AboutSellerQuery(get_called_class());
    }
}
