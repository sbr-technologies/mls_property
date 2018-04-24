<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%location_suggestion}}".
 *
 * @property integer $id
 * @property integer $zip_code
 * @property double $latitude
 * @property double $longitude
 * @property string $city
 * @property string $state
 */
class LocationSuggestion extends \yii\db\ActiveRecord
{
    public $searchType;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%location_suggestion}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city', 'state', 'zip_code'], 'required'],
            [['zip_code'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['city', 'state', 'street', 'area', 'district', 'local_government_area'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'zip_code' => Yii::t('app', 'Zip Code'),
            'latitude' => Yii::t('app', 'Latitude'),
            'longitude' => Yii::t('app', 'Longitude'),
            'city' => Yii::t('app', 'City'),
            'state' => Yii::t('app', 'State'),
        ];
    }
    
    public function getFormattedLocation(){
        //echo $this->searchType;// exit;
        return implode(', ', array_filter([$this->city, $this->state]));
//        if($this->searchType == 'area'){
//            return implode(', ', array_filter([$this->area, $this->city, $this->state]));
//        }else{
//            return implode(', ', array_filter([$this->city, $this->state]));
//        }
    }
    
    public function getLocationId(){
        if($this->searchType == 'area'){
            return implode('_', array_filter([$this->area, $this->city, $this->state]));
        }else{
            return implode('_', array_filter([$this->city, $this->state]));
        }
    }
    
    public function getCompleteLocationId(){
        return implode('_', array_filter([$this->area, $this->city]));
    }

    public function getCompleteAddress(){
        $addr =  array_filter([$this->area, $this->city, $this->district, $this->local_government_area, $this->zip_code, $this->state]);
        return implode(', ', $addr);
    }
    public function getSearchCompleteAddress(){
        $addr =  array_filter([$this->area, $this->city, $this->district, $this->local_government_area, $this->state]);
        return implode(', ', $addr);
    }
    /**
     * @inheritdoc
     * @return LocationSuggestionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LocationSuggestionQuery(get_called_class());
    }
}
