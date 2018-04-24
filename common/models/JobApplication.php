<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\helpers\Inflector;

use yii\helpers\StringHelper;

/**
 * This is the model class for table "{{%job_application}}".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $email
 * @property string $calling_code
 * @property string $phone_number
 * @property integer $gender
 * @property string $dob
 * @property string $zip_code
 * @property string $ip_address
 * @property string $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 */
class JobApplication extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%job_application}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'ip_address'], 'required'],
            [['gender', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['dob'], 'safe'],
            [['first_name', 'middle_name', 'last_name'], 'string', 'max' => 128],
            [['email'], 'string', 'max' => 255],
            [['calling_code', 'zip_code', 'status'], 'string', 'max' => 15],
            [['phone_number'], 'string', 'max' => 20],
            [['ip_address'], 'string', 'max' => 35],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'middle_name' => Yii::t('app', 'Middle Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'email' => Yii::t('app', 'Email'),
            'calling_code' => Yii::t('app', 'Calling Code'),
            'phone_number' => Yii::t('app', 'Phone Number'),
            'gender' => Yii::t('app', 'Gender'),
            'dob' => Yii::t('app', 'Dob'),
            'zip_code' => Yii::t('app', 'Zip Code'),
            'ip_address' => Yii::t('app', 'Ip Address'),
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
}
