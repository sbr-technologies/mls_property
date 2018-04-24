<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%holiday_package_enquiry}}".
 *
 * @property integer $id
 * @property integer $holiday_package_id
 * @property integer $user_id
 * @property string $title
 * @property string $description
 * @property integer $enquiry_at
 * @property string $status
 *
 * @property User $user
 * @property HolidayPackage $holidayPackage
 */
class HolidayPackageEnquiry extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%holiday_package_enquiry}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['holiday_package_id', 'user_id', 'title', 'description', 'enquiry_at', 'status'], 'required'],
            [['holiday_package_id', 'user_id', 'enquiry_at'], 'integer'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['status'], 'string', 'max' => 15],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['holiday_package_id'], 'exist', 'skipOnError' => true, 'targetClass' => HolidayPackage::className(), 'targetAttribute' => ['holiday_package_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'holiday_package_id' => Yii::t('app', 'Holiday Package ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'enquiry_at' => Yii::t('app', 'Enquiry At'),
            'status' => Yii::t('app', 'Status'),
        ];
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
    public function getHolidayPackage()
    {
        return $this->hasOne(HolidayPackage::className(), ['id' => 'holiday_package_id']);
    }
    
    /**
    * @inheritdoc
    * @return HolidayPackageEnquiryQuery the active query used by this AR class.
    */
    public static function find()
    {
        return new HolidayPackageEnquiryQuery(get_called_class());
    }
}
