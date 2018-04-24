<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%hotel_booking}}".
 *
 * @property integer $id
 * @property string $booking_generated_id
 * @property integer $hotel_id
 * @property integer $user_id
 * @property string $room
 * @property integer $check_in_date
 * @property integer $check_out_date
 * @property string $amount
 * @property string $payment_mode
 * @property integer $card_last_4_digit
 * @property integer $no_of_adult
 * @property integer $no_of_children
 * @property string $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 * @property Hotel $hotel
 */
class HotelBooking extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%hotel_booking}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hotel_id', 'user_id', 'room', 'check_in_date', 'check_out_date', 'amount', 'status'], 'required'],
            [['hotel_id', 'user_id', 'check_in_date', 'check_out_date', 'card_last_4_digit', 'no_of_adult', 'no_of_children', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['amount'], 'number'],
            [['checkIn', 'checkOut'], 'safe'],
            [['room'], 'string', 'max' => 128],
            [['payment_mode'], 'string', 'max' => 20],
            [['status'], 'string', 'max' => 15],
            [['no_of_children'], 'default', 'value' => 0],
            [['no_of_adult'], 'default', 'value' => 1],
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
            'booking_generated_id' => Yii::t('app', 'Booking Generated ID'),
            'hotel_id' => Yii::t('app', 'Hotel ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'room' => Yii::t('app', 'Room'),
            'check_in_date' => Yii::t('app', 'Check In Date'),
            'check_out_date' => Yii::t('app', 'Check Out Date'),
            'amount' => Yii::t('app', 'Amount'),
            'payment_mode' => Yii::t('app', 'Payment Mode'),
            'card_last_4_digit' => Yii::t('app', 'Card Last 4 Digit'),
            'no_of_adult' => Yii::t('app', 'No Of Adult'),
            'no_of_children' => Yii::t('app', 'No Of Children'),
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
    
    /**
     * Eelation section start
     */
    
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
     * Relation section end
     * Custom Getter and Setter section start
     */
    public function getCheckIn(){
        if(!empty($this->check_in_date)){
            return Yii::$app->formatter->asDatetime($this->check_in_date);
        }
    }
    public function setCheckIn($time){
        if(!empty($time)){
            $this->check_in_date = strtotime($time);
        }
    }
    
    public function getCheckOut(){
        if(!empty($this->check_out_date)){
            return Yii::$app->formatter->asDatetime($this->check_out_date);
        }
    }
    public function setCheckOut($time){
        if(!empty($time)){
            $this->check_out_date = strtotime($time);
        }
    }
    
    public function getBookingId(){
        return $this->id;
    }
    
    public function setBookingId($value){
        $this->booking_generated_id = $value;
    }
    /**
     * Custom getter section end
     */
    
    /**
    * @inheritdoc
    * @return HotelBookingQuery the active query used by this AR class.
    */
    public static function find()
    {
        return new HotelBookingQuery(get_called_class());
    }
}
