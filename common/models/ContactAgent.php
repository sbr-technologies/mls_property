<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%contact_agent}}".
 *
 * @property string $id
 * @property string $user_id
 * @property string $property_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $message
 * @property string $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class ContactAgent extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%contact_agent}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'property_id', 'created_at', 'updated_at','login_user','privacy_policy','newsletter_send'], 'integer'],
            [['name', 'email', 'phone', 'status'], 'required'],
            [['message'], 'string'],
            [['name'], 'string', 'max' => 125],
            [['email'], 'string', 'max' => 75],
            [['phone'], 'string', 'max' => 35],
            [['status'], 'string', 'max' => 255],
        ];
    }

    public function behaviors() {
        parent::behaviors();
        return [TimestampBehavior::className()];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'Agent Name'),
            'property_id' => Yii::t('app', 'Property Name'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'message' => Yii::t('app', 'Message'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
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
     * @inheritdoc
     * @return ContactAgentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ContactAgentQuery(get_called_class());
    }
}
