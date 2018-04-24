<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "{{%newsletter_job}}".
 *
 * @property integer $id
 * @property integer $template_id
 * @property integer $list_id
 * @property integer $subscriber_id
 * @property string $name
 * @property integer $attempts
 * @property integer $run_at
 * @property string $last_error
 * @property string $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property NewsletterEmailSubscriber $subscriber
 * @property NewsletterEmailList $list
 * @property NewsletterTemplate $template
 */
class NewsletterJob extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%newsletter_job}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['template_id', 'name'], 'required'],
            [['template_id', 'list_id', 'subscriber_id', 'attempts', 'run_at', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['last_error'], 'string'],
            [['attempts'], 'default', 'value' => 0],
            [['name'], 'string', 'max' => 128],
            [['status'], 'string', 'max' => 15],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['contact_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contact::className(), 'targetAttribute' => ['contact_id' => 'id']],
            [['subscriber_id'], 'exist', 'skipOnError' => true, 'targetClass' => NewsletterEmailSubscriber::className(), 'targetAttribute' => ['subscriber_id' => 'id']],
            [['list_id'], 'exist', 'skipOnError' => true, 'targetClass' => NewsletterEmailList::className(), 'targetAttribute' => ['list_id' => 'id']],
            [['template_id'], 'exist', 'skipOnError' => true, 'targetClass' => NewsletterTemplate::className(), 'targetAttribute' => ['template_id' => 'id']],
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
            'template_id' => Yii::t('app', 'Template ID'),
            'list_id' => Yii::t('app', 'List ID'),
            'subscriber_id' => Yii::t('app', 'Subscriber ID'),
            'name' => Yii::t('app', 'Name'),
            'attempts' => Yii::t('app', 'Attempts'),
            'run_at' => Yii::t('app', 'Run At'),
            'last_error' => Yii::t('app', 'Last Error'),
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
    public function getSubscriber()
    {
        return $this->hasOne(NewsletterEmailSubscriber::className(), ['id' => 'subscriber_id']);
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
    public function getTemplate()
    {
        return $this->hasOne(NewsletterTemplate::className(), ['id' => 'template_id']);
    }
}
