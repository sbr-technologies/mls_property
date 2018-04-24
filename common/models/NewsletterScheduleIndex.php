<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%newsletter_schedule_index}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $template_id
 * @property string $name
 * @property string $schedule
 * @property string $schedule_start_date
 * @property string $schedule_end_date
 * @property string $status
 * @property string $total_recipients
 * @property int $created_at
 * @property int $updated_at
 *
 * @property NewsletterTemplate $template
 */
class NewsletterScheduleIndex extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%newsletter_schedule_index}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'template_id', 'created_at', 'updated_at'], 'integer'],
            [['template_id', 'name'], 'required'],
            [['schedule_start_date', 'schedule_end_date', 'total_recipients', 'scheduleStartDate', 'scheduleEndDate'], 'safe'],
            [['name'], 'string', 'max' => 128],
            [['schedule_dates'], 'string'],
            [['schedule'], 'string', 'max' => 20],
            [['status'], 'string', 'max' => 15],
            [['template_id'], 'exist', 'skipOnError' => true, 'targetClass' => NewsletterTemplate::className(), 'targetAttribute' => ['template_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'template_id' => Yii::t('app', 'Template ID'),
            'name' => Yii::t('app', 'Name'),
            'schedule' => Yii::t('app', 'Schedule'),
            'schedule_start_date' => Yii::t('app', 'Schedule Start Date'),
            'schedule_end_date' => Yii::t('app', 'Schedule End Date'),
            'status' => Yii::t('app', 'Status'),
            'total_recipients' => Yii::t('app', 'Total Recipients'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    public function behaviors() {
        parent::behaviors();
        return [TimestampBehavior::className()];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(NewsletterTemplate::className(), ['id' => 'template_id']);
    }
    
    public function getScheduleStartDate(){
        if($this->schedule_start_date){
            return Yii::$app->formatter->asDate($this->schedule_start_date);
        }
    }
    public function getScheduleEndDate(){
        if($this->schedule_end_date){
            return Yii::$app->formatter->asDate($this->schedule_end_date);
        }
    }
    
    public function setScheduleStartDate($value) {
        if(empty($value)){
            $this->schedule_start_date = null;
        }else{
            $this->schedule_start_date = date('Y-m-d', strtotime(str_replace('/', '-', $value)));
        }
    }
    
    public function setScheduleEndDate($value) {
        if(empty($value)){
            $this->schedule_end_date = null;
        }else{
            $this->schedule_end_date = date('Y-m-d', strtotime(str_replace('/', '-', $value)));
        }
    }

    /**
     * @inheritdoc
     * @return NewsletterScheduleIndexQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NewsletterScheduleIndexQuery(get_called_class());
    }
}
