<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%message}}".
 *
 * @property string $id
 * @property string $parent_id
 * @property integer $sender_id
 * @property string $subject
 * @property string $message
 * @property integer $is_deleted
 * @property integer $status
 * @property integer $created_at
 *
 * @property MessageAttachments[] $messageAttachments
 * @property MessageRecipients[] $messageRecipients
 * @property Users $sender
 * @property Messages $parent
 * @property Messages[] $message
 */
class Message extends \yii\db\ActiveRecord {

    const LIMIT = 4;
    const STATUS_DELETED = 2;
    const STATUS_UNREAD = 0;
    const STATUS_READ = 1;

    var $to = "";

    public function behaviors() {
        return [

            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['parent_id', 'sender_id', 'is_deleted', 'status', 'created_at'], 'integer'],
            [['to', 'subject', 'message'], 'required'],
            [['message'], 'string'],
            [['subject'], 'string', 'max' => 256],
             [['subject' ,'subject'], 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'sender_id' => Yii::t('app', 'Sender ID'),
            'subject' => Yii::t('app', 'Subject'),
            'message' => Yii::t('app', 'Message'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessageAttachments() {
        return $this->hasMany(MessageAttachment::className(), ['message_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessageRecipients() {
        return $this->hasMany(MessageRecipient::className(), ['message_id' => 'id']);
    }

    public function getRecipient($id) {
        return $this->hasOne(MessageRecipient::className(), ['message_id' => 'id'])->where(['recipient_id' => $id]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSender() {
        return $this->hasOne(User::className(), ['id' => 'sender_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent() {
        return $this->hasOne(Message::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages() {
        return $this->hasMany(Message::className(), ['parent_id' => 'id']);
    }

    public static function canView($messageId , $uid = "") {
        if(empty($uid)){
            $uid = Yii::$app->user->id;
        }
        $sender = self::find()->where(['id' => $messageId, 'sender_id' => $uid])->one();
        if (!empty($sender)) {
            return true;
        }
        $recipient = MessageRecipient::find()->where(['message_id' => $messageId, 'recipient_id' => $uid])->one();
        if (!empty($recipient)) {
            return true;
        }
        return false;
    }

    public static function next($id) {
        $message = Message::find()->where(['>', 'id', $id])->orderBy(['id' => SORT_ASC])->one();
        return empty($message) ? '#' : Yii::$app->urlManager->createUrl(['/message/view', 'id' => $message->id]);
    }

    public static function prev($id) {
        $message = Message::find()->where(['<', 'id', $id])->orderBy(['id' => SORT_ASC])->one();
        return empty($message) ? '#' : Yii::$app->urlManager->createUrl(['/message/view', 'id' => $message->id]);
    }

    public static function getRecent() {
        return static::find()
                ->joinWith('messageRecipients')
                ->joinWith('sender')
                // ->joinWith('recipient')
                ->where(['recipient_id' => Yii::$app->user->id, Yii::$app->db->tablePrefix . 'message_recipient.status' => MessageRecipients::STATUS_UNREAD])
                
                ->orderBy(['created_at' => SORT_DESC])->limit(3)->all();
        
    }
    
   
}
