<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%holiday_package_booking}}".
 *
 * @property integer $id
 * @property string $booking_generated_id
 * @property integer $holiday_package_id
 * @property integer $user_id
 * @property integer $departure_date
 * @property string $departure_location
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
 * @property HolidayPackage $holidayPackage
 */
class HolidayPackageBooking extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    /**
     * @inheritdoc
     */
    public $vat;
    public $total_amount;
    public static function tableName()
    {
        return '{{%holiday_package_booking}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['holiday_package_id', 'user_id', 'departure_date', 'amount', 'status'], 'required'],
            [['holiday_package_id', 'user_id', 'departure_date', 'card_last_4_digit', 'no_of_adult', 'no_of_children', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['amount'], 'number'],
            [['departureDate'], 'safe'],
            [['booking_generated_id'], 'string', 'max' => 50],
            [['departure_location'], 'string', 'max' => 100],
            [['payment_mode'], 'string', 'max' => 20],
            [['status'], 'string', 'max' => 15],
            [['no_of_children'], 'default', 'value' => 0],
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
            'booking_generated_id' => Yii::t('app', 'Booking Generated ID'),
            'holiday_package_id' => Yii::t('app', 'Holiday Package ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'departure_date' => Yii::t('app', 'Departure Date'),
            'departure_location' => Yii::t('app', 'Departure Location'),
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
    public function behaviors() {
        parent::behaviors();
        return [TimestampBehavior::className(), BlameableBehavior::className()];
    }
    
    public function getGuests(){
        return $this->hasMany(HolidayBookingGuest::className(), ['booking_id' => 'id']);
    }
    
    public function getDepartureDate(){
        if(!empty($this->departure_date)){
            return Yii::$app->formatter->asDatetime($this->departure_date);
        }
    }
    public function setDepartureDate($time){
        if(!empty($time)){
            $this->departure_date = strtotime($time);
        }
    }
    
    public function getBookingId(){
        return $this->id;
    }
    
    public function setBookingId($value){
        $this->booking_generated_id = $value;
    }
    
    /**
    * @inheritdoc
    * @return HolidayPackageBookingQuery the active query used by this AR class.
    */
    public static function find()
    {
        return new HolidayPackageBookingQuery(get_called_class());
    }
}
