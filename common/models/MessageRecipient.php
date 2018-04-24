<?php

namespace common\models;
use yii\behaviors\TimestampBehavior;
use Yii;

/**
 * This is the model class for table "{{%message_recipient}}".
 *
 * @property string $id
 * @property string $message_id
 * @property integer $recipient_id
 * @property integer $status
 *
 * @property Users $recipient
 * @property Messages $message
 */
class MessageRecipient extends \yii\db\ActiveRecord {

   const STATUS_UNREAD = 0;
   const STATUS_READ = 1;
   const STATUS_DELETED = 2;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%message_recipient}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['message_id', 'recipient_id', 'status'], 'required'],
            [['message_id', 'recipient_id', 'status'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'message_id' => Yii::t('app', 'Message ID'),
            'recipient_id' => Yii::t('app', 'Recipient ID'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipient() {
        return $this->hasOne(User::className(), ['id' => 'recipient_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessage() {
        return $this->hasOne(Message::className(), ['id' => 'message_id']);
    }

}
