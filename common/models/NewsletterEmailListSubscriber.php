<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%newsletter_email_list_subscriber}}".
 *
 * @property integer $id
 * @property integer $subscriber_id
 * @property integer $list_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property NewsletterEmailList $list
 * @property NewsletterEmailSubscriber $subscriber
 */
class NewsletterEmailListSubscriber extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%newsletter_email_list_subscriber}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subscriber_id', 'list_id'], 'required'],
            [['subscriber_id', 'list_id', 'created_at', 'updated_at'], 'integer'],
            [['list_id'], 'exist', 'skipOnError' => true, 'targetClass' => NewsletterEmailList::className(), 'targetAttribute' => ['list_id' => 'id']],
            [['subscriber_id'], 'exist', 'skipOnError' => true, 'targetClass' => NewsletterEmailSubscriber::className(), 'targetAttribute' => ['subscriber_id' => 'id']],
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
            'subscriber_id' => Yii::t('app', 'Subscriber ID'),
            'list_id' => Yii::t('app', 'List ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
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
}
