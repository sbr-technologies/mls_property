<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%email_sent_log}}".
 *
 * @property int $id
 * @property int $sent_by
 * @property string $subject
 * @property string $content
 * @property int $template_id
 * @property int $user_id
 * @property int $contact_id
 * @property int $list_id
 * @property int $subscriber_id
 * @property string $type
 * @property string $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property NewsletterEmailList $list
 * @property NewsletterEmailSubscriber $subscriber
 * @property NewsletterTemplate $template
 */
class EmailSentLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%email_sent_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sent_by'], 'required'],
            [['sent_by', 'template_id', 'user_id', 'contact_id', 'list_id', 'subscriber_id', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [['subject'], 'string', 'max' => 255],
            [['type', 'status'], 'string', 'max' => 15],
            [['list_id'], 'exist', 'skipOnError' => true, 'targetClass' => NewsletterEmailList::className(), 'targetAttribute' => ['list_id' => 'id']],
            [['subscriber_id'], 'exist', 'skipOnError' => true, 'targetClass' => NewsletterEmailSubscriber::className(), 'targetAttribute' => ['subscriber_id' => 'id']],
            [['template_id'], 'exist', 'skipOnError' => true, 'targetClass' => NewsletterTemplate::className(), 'targetAttribute' => ['template_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'sent_by' => Yii::t('app', 'Sent By'),
            'subject' => Yii::t('app', 'Subject'),
            'content' => Yii::t('app', 'Content'),
            'template_id' => Yii::t('app', 'Template ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'contact_id' => Yii::t('app', 'Contact ID'),
            'list_id' => Yii::t('app', 'List ID'),
            'subscriber_id' => Yii::t('app', 'Subscriber ID'),
            'type' => Yii::t('app', 'Type'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    public function behaviors() {
        parent::behaviors();
        return [TimestampBehavior::className()];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getList()
    {
        return $this->hasOne(NewsletterEmailList::className(), ['id' => 'list_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubscriber()
    {
        return $this->hasOne(NewsletterEmailSubscriber::className(), ['id' => 'subscriber_id']);
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
    public function getContact()
    {
        return $this->hasOne(Contact::className(), ['id' => 'contact_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSentBy()
    {
        return $this->hasOne(User::className(), ['id' => 'sent_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(NewsletterTemplate::className(), ['id' => 'template_id']);
    }

    public function getRecipient(){
        if($this->contact_id){
            return $this->contact->fullName;
        }elseif($this->subscriber_id){
            return $this->subscriber->fullName;
        }elseif($this->user_id){
            return $this->user->commonName;
        }
    }

    /**
     * @inheritdoc
     * @return EmailSentLogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EmailSentLogQuery(get_called_class());
    }
}
