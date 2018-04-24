<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%email_template}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $subject
 * @property string $content
 * @property string $sms_text
 * @property string $code
 * @property string $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 */
class EmailTemplate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    const STATUS_BLOCKED    = "block";
    const STATUS_ACTIVE     = "active";
    
    public static function tableName()
    {
        return '{{%email_template}}';
    }

    public function behaviors() {
        parent::behaviors();
        return [TimestampBehavior::className(), BlameableBehavior::className()];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['content'], 'string'],
            [['created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 128],
            [['subject'], 'string', 'max' => 255],
            [['sms_text'], 'string', 'max' => 512],
            [['code'], 'string', 'max' => 50],
            [['status'], 'string', 'max' => 15],
        ];
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
            'sms_text' => Yii::t('app', 'Sms Text'),
            'code' => Yii::t('app', 'Code'),
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
    public function getCreatedBy() {
        return $this->hasOne(Users::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy() {
        return $this->hasOne(Users::className(), ['id' => 'updated_by']);
    }
}
