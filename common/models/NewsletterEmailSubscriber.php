<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%newsletter_email_subscriber}}".
 *
 * @property integer $id
 * @property string $salutation
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $email
 * @property integer $total_mail_sent
 * @property integer $last_mail_sent_at
 * @property string $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property NewsletterEmailListSubscriber[] $newsletterEmailListSubscribers
 * @property NewsletterJob[] $newsletterJobs
 */
class NewsletterEmailSubscriber extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%newsletter_email_subscriber}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['total_mail_sent', 'last_mail_sent_at', 'created_at', 'updated_at'], 'integer'],
            [['salutation'], 'string', 'max' => 20],
            [['first_name', 'middle_name', 'last_name','auth_key'], 'string', 'max' => 128],
            [['email'], 'email'],
            [['email'], 'unique', 'message' => 'The email address "{value}" has already subscribed'],
            [['email'], 'string', 'max' => 150],
            [['status'], 'string', 'max' => 15],
            ['status', 'default', 'value' => 'active'],
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
            'salutation' => Yii::t('app', 'Salutation'),
            'first_name' => Yii::t('app', 'First Name'),
            'middle_name' => Yii::t('app', 'Middle Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'email' => Yii::t('app', 'Email'),
            'total_mail_sent' => Yii::t('app', 'Total Mail Sent'),
            'last_mail_sent_at' => Yii::t('app', 'Last Mail Sent At'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    
    public function getFullName() {
        $salutation = trim($this->salutation, '.');
        $name = (!empty($salutation) ? $salutation . '. ' : '');
        $name .= ' ' . $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name;
        return trim(str_replace('  ', ' ', $name));
    }
    
    public function getLastMailSentAt(){
        if(empty($this->last_mail_sent_at)){
            return NULL;
        }
        return Yii::$app->formatter->asDatetime($this->last_mail_sent_at);
    }
    
    public function getCreatedAt(){
        return Yii::$app->formatter->asDatetime($this->created_at);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsletterEmailListSubscribers()
    {
        return $this->hasMany(NewsletterEmailListSubscriber::className(), ['subscriber_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsletterJobs()
    {
        return $this->hasMany(NewsletterJob::className(), ['subscriber_id' => 'id']);
    }
    
    /**
    * @inheritdoc
    * @return NewsletterEmailSubscriberQuery the active query used by this AR class.
    */
    public static function find()
    {
        return new NewsletterEmailSubscriberQuery(get_called_class());
    }
}
