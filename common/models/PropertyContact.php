<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%property_contact}}".
 *
 * @property integer $id
 * @property integer $property_id
 * @property string $type
 * @property string $value
 *
 * @property Property $property
 */
class PropertyContact extends \yii\db\ActiveRecord
{
    public $_destroy;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%property_contact}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['property_id', 'type'], 'required'],
            [['property_id'], 'integer'],
            [['type','property_contact_for'], 'string', 'max' => 75],
            [['value'], 'string', 'max' => 175],
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
            'property_contact_for'  => Yii::t('app','Contact'),
            'type' => Yii::t('app', 'Type'),
            'value' => Yii::t('app', 'Value'),
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
     * @return PropertyContactQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PropertyContactQuery(get_called_class());
    }
}
