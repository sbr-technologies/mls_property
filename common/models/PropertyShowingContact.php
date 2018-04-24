<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%property_showing_contact}}".
 *
 * @property integer $id
 * @property integer $property_id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $email
 * @property string $phone1
 * @property string $phone2
 * @property string $phone3
 * @property string $key_location
 * @property string $showing_instruction
 *
 * @property Property $property
 */
class PropertyShowingContact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%property_showing_contact}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['property_id'], 'integer'],
            [['key_location', 'showing_instruction'], 'string'],
            [['first_name', 'middle_name', 'last_name'], 'string', 'max' => 75],
            [['email'], 'string', 'max' => 125],
            [['phone1', 'phone2', 'phone3'], 'string', 'max' => 35],
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
            'first_name' => Yii::t('app', 'First Name'),
            'middle_name' => Yii::t('app', 'Middle Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'email' => Yii::t('app', 'Email'),
            'phone1' => Yii::t('app', 'Phone1'),
            'phone2' => Yii::t('app', 'Phone2'),
            'phone3' => Yii::t('app', 'Phone3'),
            'key_location' => Yii::t('app', 'Key Location & Key Address'),
            'showing_instruction' => Yii::t('app', 'Showing Instruction'),
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
     * @return PropertyShowingContactQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PropertyShowingContactQuery(get_called_class());
    }
}
