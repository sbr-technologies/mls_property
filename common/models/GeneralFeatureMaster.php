<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%general_feature_master}}".
 *
 * @property integer $id
 * @property string $type
 * @property string $name
 * @property string $status
 *
 * @property PropertyGeneralFeature[] $propertyGeneralFeatures
 */
class GeneralFeatureMaster extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE     = 'active';
    const STATUS_INACTIVE   = 'inactive';
    
    const TYPE_GENERAL      =   'general';
    const TYPE_EXTERIOR     =   'exterior';
    const TYPE_INTERIOR     =   'interior';


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%general_feature_master}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'name'], 'required'],
            [['type', 'name', 'status'], 'string', 'max' => 75],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'name' => Yii::t('app', 'Name'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyGeneralFeatures()
    {
        return $this->hasMany(PropertyGeneralFeature::className(), ['general_feature_master_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return GeneralFeatureMasterQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GeneralFeatureMasterQuery(get_called_class());
    }
}
