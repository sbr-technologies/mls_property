<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%contact_form_db}}".
 *
 * @property integer $id
 * @property string $salutation
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property string $subject
 * @property string $message
 * @property integer $sent_at
 * @property integer $created_at
 * @property integer $updated_at
 */
class ContactFormDb extends \yii\db\ActiveRecord
{
    const STATUS_READ = 1;
    const STATUS_UNREAD = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%contact_form_db}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['full_name', 'email', 'subject', 'message'], 'required'],
            [['message'], 'string'],
            ['email', 'email'],
            [['status','sent_at', 'created_at', 'updated_at'], 'integer'],
            [['salutation'], 'string', 'max' => 20],
            [['full_name'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 120],
            [['subject'], 'string', 'max' => 255],
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
            'full_name' => Yii::t('app', 'Full Name'),
            'email' => Yii::t('app', 'Email'),
            'subject' => Yii::t('app', 'Subject'),
            'message' => Yii::t('app', 'Message'),
            'status' => Yii::t('app', 'Status'),
            'sent_at' => Yii::t('app', 'Sent At'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    public function getStatusText(){
        return ($this->status == self::STATUS_READ? 'Read':'Unread');
    }
    
    /**
    * @inheritdoc
    * @return ContactFormDbQuery the active query used by this AR class.
    */
    public static function find()
    {
        return new ContactFormDbQuery(get_called_class());
    }
}
