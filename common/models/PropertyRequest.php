<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%property_request}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $property_category
 * @property integer $property_type_id
 * @property string $budget
 * @property integer $no_of_bed_room
 * @property string $state
 * @property string $locality
 * @property string $comment
 * @property string $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property PropertyType $propertyType
 * @property PropertyCategory $propertyCategory
 */
class PropertyRequest extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE     = 'active';
    const STATUS_INACTIVE   = 'inactive';
    public $verifyCode;
    public $profile_id;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%property_request}}';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['property_category', 'property_type_id', 'budget_from', 'budget_to', 'no_of_bed_room', 'state', 'status'], 'required'],
            [['user_id', 'property_type_id', 'no_of_bed_room','budget_from', 'budget_to', 'created_at', 'updated_at'], 'integer'],
            [['comment'], 'string'],
            [['property_category'], 'string','max' => 35],
            [['state'], 'string', 'max' => 75],
            [['area'], 'string', 'max' => 125],
            [['locality', 'status'], 'string', 'max' => 255],
            [['property_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PropertyType::className(), 'targetAttribute' => ['property_type_id' => 'id']],
            [['scheduleDate'], 'required'],
            ['verifyCode', 'required', 'on' => 'captchaRequired'],
            ['verifyCode', 'captcha', 'skipOnEmpty' => false, 'on' => 'captchaRequired'],
            ['verifyCode', 'captcha', 'skipOnEmpty' => true, 'on' => 'update'],
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
            'referenceId' =>    Yii::t('app', 'Reff ID'),
            'property_category' => Yii::t('app', 'Property Category'),
            'property_type_id' => Yii::t('app', 'Property Type ID'),
            'budget_from' => Yii::t('app', 'Budget From'),
            'budget_to' => Yii::t('app', 'Budget To'),
            'no_of_bed_room' => Yii::t('app', 'No of Bedrooms'),
            'state' => Yii::t('app', 'State'),
            'area' => Yii::t('app', 'Area'),
            'locality' => Yii::t('app', 'Locality'),
            'comment' => Yii::t('app', 'Comment'),
            'status' => Yii::t('app', 'Status'),
            'schedule' => Yii::t('app', 'How Soon?'),
            'created_at' => Yii::t('app', 'Submit date'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public function afterSave($insert, $changedAttributes) {
        //\yii\helpers\VarDumper::dump($this->price); exit;
        parent::afterSave($insert, $changedAttributes);
        if($insert){
            $end = $this->id;
            $start = '';
            $characters = range('0','6');
            for ($i = 0; $i < 5 - strlen((string)$end); $i++) {
                    $rand = mt_rand(0, count($characters)-1);
                    $start .= $characters[$rand];
            }
            $this->referenceId = $start.$end;
            $this->scenario = 'update';
            $this->verifyCode = null;
            $this->save();
        }
        
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
    public function getPropertyType()
    {
        return $this->hasOne(PropertyType::className(), ['id' => 'property_type_id']);
    }
    
    public function getScheduleDate(){
        if(!empty($this->schedule)){
            return Yii::$app->formatter->asDate($this->schedule);
        }
    }
    public function setScheduleDate($time){
        //echo $time; exit;
        if(!empty($time)){
            $this->schedule       = date('Y-m-d', strtotime(str_replace('/', '-', $time)));
        }
    }
    

    /**
     * @inheritdoc
     * @return PropertyRequestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PropertyRequestQuery(get_called_class());
    }
}
