<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%property_tax_history}}".
 *
 * @property integer $id
 * @property integer $property_id
 * @property string $year
 * @property string $taxes
 * @property string $land
 * @property string $addition
 * @property string $total_assesment
 *
 * @property Property $property
 */
class PropertyTaxHistory extends \yii\db\ActiveRecord
{
     public $_destroy;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%property_tax_history}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['property_id'], 'required'],
            [['property_id'], 'integer'],
            [['taxes'], 'number'],
            [['year'], 'string', 'max' => 15],
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
            'year' => Yii::t('app', 'Tax Year'),
            'taxes' => Yii::t('app', 'Taxes'),
            
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
     * @return PropertyTaxHistoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PropertyTaxHistoryQuery(get_called_class());
    }
}
