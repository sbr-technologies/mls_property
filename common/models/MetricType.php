<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%metric_type}}".
 *
 * @property integer $id
 * @property string $type
 * @property string $name
 * @property string $factor
 * @property string $status
 *
 * @property Property[] $properties
 */
class MetricType extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%metric_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'name', 'factor', 'status'], 'required'],
            [['factor'], 'number'],
            [['type'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 100],
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
            'type' => Yii::t('app', 'Type'),
            'name' => Yii::t('app', 'Metric Type'),
            'factor' => Yii::t('app', 'Factor'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperties()
    {
        return $this->hasMany(Property::className(), ['metric_type_id' => 'id']);
    }
    
    /**
    * @inheritdoc
    * @return MetricTypeQuery the active query used by this AR class.
    */
    public static function find()
    {
        return new MetricTypeQuery(get_called_class());
    }
}
