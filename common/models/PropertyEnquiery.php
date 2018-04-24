<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%property_enquiery}}".
 *
 * @property integer $id
 * @property integer $property_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $subject
 * @property string $message
 * @property integer $assign_to
 * @property string $status
 *
 * @property Property $property
 * @property User $assignTo
 */
class PropertyEnquiery extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_PENDING = 'pending';
    public $property_url;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%property_enquiery}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_id', 'model', 'name', 'email','phone', 'status'], 'required'],
            [['model_id', 'assign_to', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['message'], 'string'],
            ['email', 'email'],
            [['name'], 'string', 'max' => 150],
            [['email', 'model'], 'string', 'max' => 75],
            [['phone', 'status'], 'string', 'max' => 15],
            [['subject'], 'string', 'max' => 255],
            [['assign_to'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['assign_to' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'model_id' => Yii::t('app', 'Property ID'),
            'user_id' => Yii::t('app', 'Requested By'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'subject' => Yii::t('app', 'Subject'),
            'message' => Yii::t('app', 'Message'),
            'assign_to' => Yii::t('app', 'Assign To'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    public function behaviors() {
        parent::behaviors();
        return [TimestampBehavior::className()];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(Property::className(), ['id' => 'model_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignTo()
    {
        return $this->hasOne(User::className(), ['id' => 'assign_to']);
    }

    /**
     * @inheritdoc
     * @return PropertyEnquieryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PropertyEnquieryQuery(get_called_class());
    }
}
