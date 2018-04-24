<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%hotel_booking_guest}}".
 *
 * @property integer $id
 * @property string $booking_id
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property integer $gender
 * @property integer $age
 */
class HotelBookingGuest extends \yii\db\ActiveRecord
{
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;
    
    const CHILD_AGE = 10;
    
    public $_destroy;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%hotel_booking_guest}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['booking_id', 'first_name', 'last_name', 'gender', 'age'], 'required'],
            [['gender', 'age','booking_id'], 'integer'],
            [['first_name', 'last_name', 'middle_name'], 'string', 'max' => 128],
            [['booking_id'], 'exist', 'skipOnError' => true, 'targetClass' => HotelBooking::className(), 'targetAttribute' => ['booking_id' => 'id']],
        ];
    }

    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'booking_id' => Yii::t('app', 'Booking ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'middle_name' => Yii::t('app', 'Middle Name'),
            'gender' => Yii::t('app', 'Gender'),
            'age' => Yii::t('app', 'Age'),
        ];
    }
    public function getBooking()
    {
        return $this->hasOne(HotelBooking::className(), ['id' => 'booking_id']);
    }
    
    public function getGenderText(){
        if(empty($this->gender)){
            return false;
        }
        return ($this->gender == 1?'Male':'Female');
    }
    
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        if($insert){
            $field = 'no_of_adult';
            if($this->age <= self::CHILD_AGE){
                $field = 'no_of_children';
            }
            $this->booking->updateCounters([$field => 1]);
        }
    }
}
