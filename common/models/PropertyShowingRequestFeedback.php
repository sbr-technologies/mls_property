<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%property_showing_request_feedback}}".
 *
 * @property integer $id
 * @property integer $showing_request_id
 * @property integer $user_id
 * @property integer $requested_to
 * @property integer $property_id
 * @property string $reply
 * @property string $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Property $property
 * @property PropertyShowingRequest $showingRequest
 * @property User $user
 */
class PropertyShowingRequestFeedback extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%property_showing_request_feedback}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['showing_request_id', 'user_id', 'reply', 'status'], 'required'],
            [['showing_request_id', 'user_id', 'requested_to', 'model_id', 'created_at', 'updated_at'], 'integer'],
            [['reply'], 'string'],
            [['status'], 'string', 'max' => 255],
            [['model'], 'string', 'max' => 100],
            [['showing_request_id'], 'exist', 'skipOnError' => true, 'targetClass' => PropertyShowingRequest::className(), 'targetAttribute' => ['showing_request_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'showing_request_id' => Yii::t('app', 'Showing Request ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'requested_to' => Yii::t('app', 'Requested To'),
            'model' => Yii::t('app', 'Request Type'),
            'reply' => Yii::t('app', 'Message'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
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
    public function getShowingRequest()
    {
        return $this->hasOne(PropertyShowingRequest::className(), ['id' => 'showing_request_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return PropertyShowingRequestFeedbackQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PropertyShowingRequestFeedbackQuery(get_called_class());
    }
}
