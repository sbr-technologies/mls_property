<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%contact}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $mobile1
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class Contact extends \yii\db\ActiveRecord
{
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;
    public $location;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%contact}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email'], 'required', 'on' => 'userContact'],
            [['user_id'], 'required', 'on' => 'userContact'],
            [['property_id'], 'required', 'on' => 'propertyContact'],
            [['user_id', 'created_at', 'updated_at', 'gender'], 'integer'],
            ['birthday', 'date'],
            [['salutation', 'first_name', 'middle_name', 'last_name', 'short_name', 'occupation'], 'string', 'max' => 150],
            [['occupation_other', 'timezone'], 'string'],
            [['email', 'street_address', 'street_number', 'appartment_unit', 'area', 'sub_area', 'local_govt_area', 'urban_town_area', 'district', 'town', 'state', 'country', 'zip_code'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['calling_code', 'mobile1', 'mobile2', 'mobile3', 'mobile4', 'calling_code2', 'calling_code3', 'calling_code4', 'office1', 'office2', 'office3', 'office4', 'fax1', 'fax2', 'fax3', 'fax4'], 'string', 'max' => 35],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => Yii::t('app', 'User'),
            'property_id' => Yii::t('app', 'Property'),
            'agentID' => Yii::t('app', 'Agent ID'),
            'salutation' => Yii::t('app', 'Salutation'),
            'first_name' => Yii::t('app', 'First Name'),
            'middle_name' => Yii::t('app', 'Middle Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'gender' => Yii::t('app', 'Gender'),
            'email' => Yii::t('app', 'Email'),
            'short_name' => Yii::t('app', 'Short Name'),
            'dob' => Yii::t('app', 'Birthday'),
            'mobile1' => Yii::t('app', 'Mobile1'),
            'calling_code' => Yii::t('app', 'Calling Code'),
            'mobile2' => Yii::t('app', 'Mobile2'),
            'mobile3' => Yii::t('app', 'Mobile3'),
            'mobile4' => Yii::t('app', 'Other Mobile'),
            'calling_code2' => Yii::t('app', 'Calling Code'),
            'office1' => Yii::t('app', 'Office1'),
            'office2' => Yii::t('app', 'Office2'),
            'office3' => Yii::t('app', 'Office3'),
            'office4' => Yii::t('app', 'Other Office'),
            'calling_code3' => Yii::t('app', 'Calling Code'),
            'fax1' => Yii::t('app', 'Fax1'),
            'fax2' => Yii::t('app', 'Fax2'),
            'fax3' => Yii::t('app', 'Fax3'),
            'fax4' => Yii::t('app', 'Other Fax'),
            'calling_code4' => Yii::t('app', 'Calling Code'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'status' => Yii::t('app', 'Status'),
            'country' => Yii::t('app', 'Country'),
            'state' => Yii::t('app', 'State'),
            'town' => Yii::t('app', 'Town'),
            'appartment_unit' => Yii::t('app', 'Apt/Unit/Suite #'),
            'area' => Yii::t('app', 'Area'),
            'sub_area' => Yii::t('app', 'Sub Area'),
            'area' => Yii::t('app', 'Area'),
            'local_govt_area' => Yii::t('app', 'Local Government Area'),
            'urban_town_area' => Yii::t('app', 'Urban Town Area'),
            'district' => Yii::t('app', 'District'),
            'street_address' => Yii::t('app', 'Street Name'),
            'street_number' => Yii::t('app', 'House Number'),
            'zip_code' => Yii::t('app', 'Zip'),
            'occupation_other' => Yii::t('app', 'Other'),
            'FullName' => Yii::t('app', 'Name'),
            'genderText' => Yii::t('app', 'Gender'),
        ];
    }
    
    public function beforeSave($insert) {
        parent::beforeSave($insert);
        if($this->street_address && $this->town && $this->state){
            $locationLat    =   null;//9.0765° N, 7.3986° E
            $locationLng    =   null;
            $addressData = implode(', ', array_filter([$this->street_number, $this->street_address, $this->area, $this->town,$this->state, $this->zip_code, $this->country]));
            $location =  file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=". urlencode($addressData) ."&key=".Yii::$app->params['googleMapKey']."");
            $locationObj = json_decode($location);
            //\yii\helpers\VarDumper::dump($locationObj,12,125); exit;
            if(!empty($locationObj->results[0]->geometry->location)){
                $locationLat    =   $locationObj->results[0]->geometry->location->lat;
                $locationLng    =   $locationObj->results[0]->geometry->location->lng;
            }
            //\yii\helpers\VarDumper::dump($locationLat."++".$locationLng); exit;
            $this->lat = $locationLat;
            $this->lng = $locationLng;
        }
        return true;
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
        return $this->hasOne(Property::className(), ['id' => 'property_id']);
    }
	
    public function getFormattedAddress(){
        $addr = implode(' ', array_filter([$this->street_number, $this->street_address]));
        if($this->appartment_unit){
                $addr = $addr. ', #'. $this->appartment_unit;
        }
        return implode(', ', array_filter([$addr, $this->area, $this->town, $this->state]));
    }
    
    public function getName() {
        return ucwords(implode(' ', array_filter([$this->first_name, $this->middle_name, $this->last_name])));
    }
    
    public function getFullName() {
        return ucwords(implode(' ', array_filter([$this->salutation, $this->first_name, $this->middle_name, $this->last_name])));
    }

    public function getGenderText() {
        if (empty($this->gender)) {
            return null;
        }
        return ($this->gender == 1 ? 'Male' : 'Female');
    }
    
    public function setBirthday($dob) {
        if(empty($dob)){
            $this->dob = null;
        }else{
            $this->dob = date('Y-m-d', strtotime(str_replace('/', '-', $dob)));
        }
    }

    public function getBirthday() {
        if (!empty($this->dob)) {
            return Yii::$app->formatter->asDate($this->dob);
        }
        return null;
    }
    
    
    public function getMobile1(){
        if(empty($this->mobile1)){
            return null;
        }
        return $this->calling_code. ' '. $this->mobile1;
    }
    
    public function getOffice1(){
        if(empty($this->office1)){
            return null;
        }
        return $this->calling_code. ' '. $this->office1;
    }
    
    public function getFax1(){
        if(empty($this->fax1)){
            return null;
        }
        return $this->calling_code. ' '. $this->fax1;
    }
    
    public function getMobile2(){
        if(empty($this->mobile2)){
            return null;
        }
        return $this->calling_code2. ' '. $this->mobile2;
    }
    
    public function getOffice2(){
        if(empty($this->office2)){
            return null;
        }
        return $this->calling_code2. ' '. $this->office2;
    }
    
    public function getFax2(){
        if(empty($this->fax2)){
            return null;
        }
        return $this->calling_code2. ' '. $this->fax2;
    }
    
    public function getMobile3(){
        if(empty($this->mobile3)){
            return null;
        }
        return $this->calling_code3. ' '. $this->mobile3;
    }
    
    public function getOffice3(){
        if(empty($this->office3)){
            return null;
        }
        return $this->calling_code3. ' '. $this->office3;
    }
    
    public function getFax3(){
        if(empty($this->fax3)){
            return null;
        }
        return $this->calling_code3. ' '. $this->fax3;
    }
    
    public function getMobile4(){
        if(empty($this->mobile4)){
            return null;
        }
        return $this->calling_code4. ' '. $this->mobile4;
    }
    
    public function getOffice4(){
        if(empty($this->office4)){
            return null;
        }
        return $this->calling_code4. ' '. $this->office4;
    }
    
    public function getFax4(){
        if(empty($this->fax4)){
            return null;
        }
        return $this->calling_code4. ' '. $this->fax4;
    }
    
    public function assignAttributes($values){
        $this->salutation = $values['salutation'];
        $this->first_name = $values['first_name'];
        $this->middle_name = $values['middle_name'];
        $this->last_name = $values['last_name'];
        $this->gender = $values['gender'];
        $this->email = $values['email'];
        $this->short_name = $values['short_name'];
        $this->birthday = isset($values['birthday'])?$values['birthday']:$values['dob'];
        $this->timezone = $values['timezone'];
        $this->occupation = $values['occupation'];
        $this->country = $values['country'];
        $this->state = $values['state'];
        $this->town = $values['town'];
        $this->area = $values['area'];
        $this->zip_code = $values['zip_code'];
        $this->street_address = $values['street_address'];
        $this->street_number = $values['street_number'];
        $this->appartment_unit = $values['appartment_unit'];
        $this->sub_area = $values['sub_area'];
        $this->local_govt_area = $values['local_govt_area'];
        $this->urban_town_area = $values['urban_town_area'];
        $this->district = $values['district'];
        
        $this->calling_code = $values['calling_code'];
        $this->calling_code2 = $values['calling_code2'];
        $this->calling_code3 = $values['calling_code3'];
        $this->calling_code4 = $values['calling_code4'];
        
        $this->mobile1 = $values['mobile1'];
        $this->mobile2 = $values['mobile2'];
        $this->mobile3 = $values['mobile3'];
        $this->mobile4 = $values['mobile4'];
        
        $this->office1 = $values['office1'];
        $this->office2 = $values['office2'];
        $this->office3 = $values['office3'];
        $this->office4 = $values['office4'];
        
        $this->fax1 = $values['fax1'];
        $this->fax2 = $values['fax2'];
        $this->fax3 = $values['fax3'];
        $this->fax4 = $values['fax4'];
    }

    /**
     * @inheritdoc
     * @return ContactQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ContactQuery(get_called_class());
    }
}
