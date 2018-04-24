<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%property_price_history}}".
 *
 * @property integer $id
 * @property integer $property_id
 * @property string $date
 * @property string $price
 * @property string $status
 *
 * @property Property $property
 */
class PropertyPriceHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%property_price_history}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['property_id', 'date', 'price', 'status'], 'required'],
            [['property_id'], 'integer'],
            [['date'], 'safe'],
            [['price'], 'number'],
            [['status'], 'string', 'max' => 15],
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
            'property_id' => Yii::t('app', 'Property Name'),
            'date' => Yii::t('app', 'Date'),
            'price' => Yii::t('app', 'Price'),
            'status' => Yii::t('app', 'Status'),
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
     * @inheritdoc
     * @return PropertyPriceHistoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PropertyPriceHistoryQuery(get_called_class());
    }
}
