<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "{{%newsletter_schedule}}".
 *
 * @property int $id
 * @property int $template_id
 * @property int $user_id
 * @property int $contact_id
 * @property int $list_id
 * @property int $subscriber_id
 * @property string $name
 * @property int $schedule
 * @property string $status
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Contact $contact
 * @property NewsletterEmailList $list
 * @property NewsletterEmailSubscriber $subscriber
 * @property NewsletterTemplate $template
 */
class NewsletterSchedule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%newsletter_schedule}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['template_id', 'name'], 'required'],
            [['template_id', 'user_id', 'contact_id', 'list_id', 'subscriber_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 128],
            [['schedule'], 'string'],
            [['status'], 'string', 'max' => 15],
            [['contact_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contact::className(), 'targetAttribute' => ['contact_id' => 'id']],
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
            'template_id' => Yii::t('app', 'Template ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'contact_id' => Yii::t('app', 'Contact ID'),
            'list_id' => Yii::t('app', 'List ID'),
            'subscriber_id' => Yii::t('app', 'Subscriber ID'),
            'name' => Yii::t('app', 'Name'),
            'schedule' => Yii::t('app', 'Schedule'),
            'status' => Yii::t('app', 'Status'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    public function behaviors() {
        parent::behaviors();
        return [TimestampBehavior::className(), BlameableBehavior::className()];
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
    public function getList()
    {
        return $this->hasOne(NewsletterEmailList::className(), ['id' => 'list_id']);
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
    public function getSubscriber()
    {
        return $this->hasOne(NewsletterEmailSubscriber::className(), ['id' => 'subscriber_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndex()
    {
        return $this->hasOne(NewsletterScheduleIndex::className(), ['id' => 'index_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(NewsletterTemplate::className(), ['id' => 'template_id']);
    }

    public function getRecipientName(){
        if($this->contact_id){
            return $this->contact->fullName;
        }elseif($this->user_id){
            return $this->user->commonName;
        }elseif($this->subscriber_id){
            return $this->subscriber->fullName;
        }elseif($this->list_id){
            return $this->list->title;
        }
    }

    public function getRecipientEmail(){
        if($this->contact_id){
            return $this->contact->email;
        }elseif($this->user_id){
            return $this->user->email;
        }elseif($this->subscriber_id){
            return $this->subscriber->email;
        }elseif($this->list_id){
            return null;
        }
    }

    /**
     * @inheritdoc
     * @return NewsletterScheduleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NewsletterScheduleQuery(get_called_class());
    }
}
