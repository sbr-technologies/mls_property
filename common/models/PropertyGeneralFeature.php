<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%property_general_feature}}".
 *
 * @property integer $id
 * @property integer $property_id
 * @property string $type
 * @property string $name
 *
 * @property Property $property
 */
class PropertyGeneralFeature extends \yii\db\ActiveRecord
{
    public $_destroy;
    public $general;
    public $exterior;
    public $interior;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%property_general_feature}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['property_id', 'general_feature_master_id'], 'integer'],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Property::className(), 'targetAttribute' => ['property_id' => 'id']],
            [['general_feature_master_id'], 'exist', 'skipOnError' => true, 'targetClass' => GeneralFeatureMaster::className(), 'targetAttribute' => ['general_feature_master_id' => 'id']],
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
            'general_feature_master_id' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(Property::className(), ['id' => 'property_id']);
    }
    
    
     /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeneralFeatureMasters()
    {
        return $this->hasOne(GeneralFeatureMaster::className(), ['id' => 'general_feature_master_id']);
    }
    
    
    /**
     * @inheritdoc
     * @return PropertyGeneralFeatureQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PropertyGeneralFeatureQuery(get_called_class());
    }
}
