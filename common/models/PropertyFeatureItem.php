<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%property_feature_item}}".
 *
 * @property integer $id
 * @property integer $property_feature_id
 * @property integer $name
 *
 * @property PropertyFeature $propertyFeature
 */
class PropertyFeatureItem extends \yii\db\ActiveRecord
{
    public $_destroy;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%property_feature_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['property_feature_id'], 'required'],
            [['property_feature_id'], 'integer'],
            [['name','description'], 'string', 'max' => 255],
            [['size'], 'string', 'max' => 50],
            [['property_feature_id'], 'exist', 'skipOnError' => true, 'targetClass' => PropertyFeature::className(), 'targetAttribute' => ['property_feature_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'property_feature_id' => Yii::t('app', 'Property Feature ID'),
            'name' => Yii::t('app', 'Name'),
            'size' => Yii::t('app', 'Size(m)'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyFeature()
    {
        return $this->hasOne(PropertyFeature::className(), ['id' => 'property_feature_id']);
    }

    /**
     * @inheritdoc
     * @return PropertyFeatureItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PropertyFeatureItemQuery(get_called_class());
    }
}
