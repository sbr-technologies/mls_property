<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%hotel_enquiry}}".
 *
 * @property integer $id
 * @property integer $hotel_id
 * @property integer $user_id
 * @property string $title
 * @property string $description
 * @property integer $enquiry_at
 * @property string $status
 *
 * @property User $user
 * @property HolidayPackageCategory $hotel
 */
class HotelEnquiry extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%hotel_enquiry}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hotel_id', 'user_id', 'title', 'description', 'enquiry_at', 'status'], 'required'],
            [['hotel_id', 'user_id', 'enquiry_at'], 'integer'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['status'], 'string', 'max' => 15],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['hotel_id'], 'exist', 'skipOnError' => true, 'targetClass' => Hotel::className(), 'targetAttribute' => ['hotel_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'hotel_id' => Yii::t('app', 'Hotel ID'),
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
    public function getHotel()
    {
        return $this->hasOne(Hotel::className(), ['id' => 'hotel_id']);
    }
    
    /**
    * @inheritdoc
    * @return HotelEnquiryQuery the active query used by this AR class.
    */
    public static function find()
    {
        return new HotelEnquiryQuery(get_called_class());
    }
}
