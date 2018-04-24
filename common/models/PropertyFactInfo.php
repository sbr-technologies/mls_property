<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%property_fact_info}}".
 *
 * @property integer $id
 * @property integer $property_id
 * @property integer $fact_master_id
 * @property string $title
 * @property string $description
 * @property string $status
 *
 * @property FactMaster $factMaster
 * @property Property $property
 */
class PropertyFactInfo extends \yii\db\ActiveRecord
{
    public $_destroy;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%property_fact_info}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['property_id', 'fact_master_id', 'title'], 'required'],
            [['property_id', 'fact_master_id'], 'integer'],
            [['description'], 'string'],
            ['status', 'default', 'value' => 'active'],
            [['title'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 15],
            [['fact_master_id'], 'exist', 'skipOnError' => true, 'targetClass' => FactMaster::className(), 'targetAttribute' => ['fact_master_id' => 'id']],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Property::className(), 'targetAttribute' => ['property_id' => 'id']],
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
            'fact_master_id' => Yii::t('app', 'Fact Master ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFactMaster()
    {
        return $this->hasOne(FactMaster::className(), ['id' => 'fact_master_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(Property::className(), ['id' => 'property_id']);
    }
}
