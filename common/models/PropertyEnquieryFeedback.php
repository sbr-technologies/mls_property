<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%property_enquiery_feedback}}".
 *
 * @property integer $id
 * @property integer $proerty_enquiery_id
 * @property integer $property_id
 * @property string $replay
 * @property string $status
 *
 * @property Property $property
 * @property PropertyEnquiery $proertyEnquiery
 */
class PropertyEnquieryFeedback extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%property_enquiery_feedback}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['proerty_enquiery_id', 'property_id', 'replay', 'status'], 'required'],
            [['proerty_enquiery_id', 'property_id', 'user_id'], 'integer'],
            [['replay'], 'string'],
            [['status'], 'string', 'max' => 15],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Property::className(), 'targetAttribute' => ['property_id' => 'id']],
            [['proerty_enquiery_id'], 'exist', 'skipOnError' => true, 'targetClass' => PropertyEnquiery::className(), 'targetAttribute' => ['proerty_enquiery_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'proerty_enquiery_id' => Yii::t('app', 'Proerty Enquiery ID'),
            'property_id' => Yii::t('app', 'Property ID'),
            'replay' => Yii::t('app', 'Message'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
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
    public function getProertyEnquiery()
    {
        return $this->hasOne(PropertyEnquiery::className(), ['id' => 'proerty_enquiery_id']);
    }

    /**
     * @inheritdoc
     * @return PropertyEnquieryFeedbackQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PropertyEnquieryFeedbackQuery(get_called_class());
    }
}
