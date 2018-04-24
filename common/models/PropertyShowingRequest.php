<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%property_showing_request}}".
 *
 * @property string $id
 * @property string $user_id
 * @property string $model_id
 * @property string $model
 * @property integer $schedule
 * @property string $note
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property integer $is_lender
 * @property string $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class PropertyShowingRequest extends \yii\db\ActiveRecord
{
//    const STATUS_ACTIVE = 'active';
    const STATUS_PENDING = 'pending';
    const STATUS_DECLINE = 'declined';
    const STATUS_APPROVE = 'approved';
    const STATUS_CANCELLED = 'cancelled';
    
    public $start_time;
    public $end_time;
    public $property_url;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%property_showing_request}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'model_id', 'schedule', 'schedule_end', 'is_lender', 'created_at', 'updated_at'], 'integer'],
            [['schedule', 'name', 'email', 'phone', 'status'], 'required'],
            [['note'], 'string'],
            [['model'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 125],
            [['email'], 'string', 'max' => 75],
            [['phone'], 'string', 'max' => 35],
            [['status'], 'string', 'max' => 255],
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
            'user_id' => Yii::t('app', 'User ID'),
            'model_id' => Yii::t('app', 'Model ID'),
            'model' => Yii::t('app', 'Request Type'),
            'schedule' => Yii::t('app', 'Schedule'),
            'note' => Yii::t('app', 'Note'),
            'start_time' => Yii::t('app', 'From Time'),
            'end_time' => Yii::t('app', 'End Time'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'is_lender' => Yii::t('app', 'Is Lender'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Requested Date'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public function beforeSave($insert) {
        parent::beforeSave($insert);
        if($insert){
            $this->auth_key = Yii::$app->security->generateRandomString();
        }
        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequestTo()
    {
        return $this->hasOne(User::className(), ['id' => 'request_to']);
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
    public function getProperty()
    {
        return $this->hasOne(Property::className(), ['id' => 'model_id']);
        
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRental()
    {
        return $this->hasOne(Rental::className(), ['id' => 'model_id']);
        
    }
    
    public function getNeedLender(){
        return ($this->is_lender == 1?'Yes':'No');
    }

        /**
     * Relation section end
     * Custom Getter and Setter section start
     */
    public function getScheduleDate(){
        if(!empty($this->schedule)){
            return Yii::$app->formatter->asDatetime($this->schedule);
        }
    }
    public function setScheduleDate($datetime){ 
        if(!empty($datetime)){
            $this->schedule =   strtotime($datetime);
        }else{
            $this->schedule =   null;
        }
    }
    public function setScheduleEndDate($datetime){ //echo $datetime; exit;
        if(!empty($datetime)){
            $this->schedule_end =   strtotime($datetime);
        }else{
            $this->schedule_end =   null;
        }
        // echo $this->schedule_end; exit;
    }
    
    /**
     * @inheritdoc
     * @return PropertyShowingRequestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PropertyShowingRequestQuery(get_called_class());
    }
}
