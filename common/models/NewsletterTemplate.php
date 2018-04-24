<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "{{%newsletter_template}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $subject
 * @property string $content
 * @property string $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property NewsletterJob[] $newsletterJobs
 */
class NewsletterTemplate extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    
    public $variableList;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%newsletter_template}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'title', 'content'], 'required'],
            [['type'], 'string'],
            [['content'], 'string'],
            [['created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 128],
            [['subject'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 15],
            [['status'], 'default', 'value' => 'active']
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
            'subject' => Yii::t('app', 'Subject'),
            'content' => Yii::t('app', 'Content'),
            'status' => Yii::t('app', 'Status'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public function getCreatedAt(){
        return Yii::$app->formatter->asDatetime($this->created_at);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsletterJobs()
    {
        return $this->hasMany(NewsletterJob::className(), ['template_id' => 'id']);
    }
    
    /**
    * @inheritdoc
    * @return NewsletterTemplateQuery the active query used by this AR class.
    */
    public static function find()
    {
        return new NewsletterTemplateQuery(get_called_class());
    }
    
}
