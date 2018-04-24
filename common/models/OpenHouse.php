<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%open_house}}".
 *
 * @property string $id
 * @property string $model
 * @property string $model_id
 * @property string $start_date
 * @property string $end_date
 * @property string $start_time
 * @property string $end_time
 */
class OpenHouse extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%open_house}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_id'], 'integer'],
            [['start_date', 'end_date', 'start_time', 'end_time'], 'safe'],
            [['model'], 'string', 'max' => 100],
            [['startdate','enddate','starttime','endtime'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'model' => Yii::t('app', 'Model'),
            'model_id' => Yii::t('app', 'Model ID'),
            'startdate' => Yii::t('app', 'Start Date'),
            'enddate' => Yii::t('app', 'End Date'),
            'starttime' => Yii::t('app', 'Start Time'),
            'endtime' => Yii::t('app', 'End Time'),
        ];
    }

    
    public function setStartdate($start){
        if(isset($start) && $start != ''){
            $this->start_date = date('Y-m-d', strtotime(str_replace('/', '-', $start)));
        }else{
            $this->start_date = NULL;
        }
    }
    
    public function getStartdate(){
        if(!empty($this->start_date)){
            return Yii::$app->formatter->asDate($this->start_date);
        }
    }
    
    public function setEnddate($end){
        if(isset($end) && $end != ''){
            $this->end_date = date('Y-m-d', strtotime(str_replace('/', '-', $end)));
        }else{
            $this->end_date = NULL;
        }
        
    }
    
    public function getEnddate(){
        if(!empty($this->end_date)){
            return Yii::$app->formatter->asDate($this->end_date);
        }
    }
    public function setStarttime($startTime){
        if(isset($startTime) && $startTime != ''){
            $this->start_time = date("H:i", strtotime($startTime));
        }else{
            $this->start_time = NULL;
        }
        
    }
    
    public function getStarttime(){
        if(!empty($this->start_time)){
            return date("h:i A",  strtotime($this->start_time));
        }
    }
    
    public function setEndtime($endTime){
        if(isset($endTime) && $endTime != ''){
            $this->end_time = date("H:i", strtotime($endTime));
        }else{
            $this->end_time = NULL;
        }
    }
    
    public function getEndtime(){
        if(!empty($this->end_time)){
            return date("h:i A",  strtotime($this->end_time));
        }
    }
    /**
     * @inheritdoc
     * @return OpenHouseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OpenHouseQuery(get_called_class());
    }
}
