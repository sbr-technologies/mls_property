<?php

namespace common\models;

use Yii;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "{{%newsletter_email_list}}".
 *
 * @property integer $id
 * @property string $list_name
 * @property string $description
 * @property integer $last_mail_sent_at
 * @property integer $total_mail_sent
 * @property string $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property NewsletterEmailListSubscriber[] $newsletterEmailListSubscribers
 * @property NewsletterJob[] $newsletterJobs
 */
class NewsletterEmailList extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%newsletter_email_list}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'status'], 'required'],
            [['description'], 'string'],
            [['last_mail_sent_at', 'total_mail_sent', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 15],
        ];
    }
    
    public function behaviors() {
        parent::behaviors();
        return [TimestampBehavior::className(), BlameableBehavior::className()];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'last_mail_sent_at' => Yii::t('app', 'Last Mail Sent At'),
            'total_mail_sent' => Yii::t('app', 'Total Mail Sent'),
            'status' => Yii::t('app', 'Status'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsletterEmailListSubscribers()
    {
        return $this->hasMany(NewsletterEmailListSubscriber::className(), ['list_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsletterJobs()
    {
        return $this->hasMany(NewsletterJob::className(), ['list_id' => 'id']);
    }
    
    public function getSubscriberCount()
    {
        // Customer has_many Order via Order.customer_id -> id
        return $this->hasMany(NewsletterEmailListSubscriber::className(), ['list_id' => 'id'])->count();
    }
    
    /**
    * @inheritdoc
    * @return NewsletterEmailListQuery the active query used by this AR class.
    */
    public static function find()
    {
        return new NewsletterEmailListQuery(get_called_class());
    }
    
}
