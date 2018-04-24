<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\helpers\Inflector;

use yii\helpers\StringHelper;
/**
 * This is the model class for table "{{%agency}}".
 *
 * @property integer $id
 * @property integer $agencyID
 * @property string $name
 * @property string $tagline
 * @property string $owner_name
 * @property string $country
 * @property string $state
 * @property string $town
 * @property string $address1
 * @property string $address2
 * @property string $zip_code
 * @property double $lat
 * @property double $lng
 * @property string $estd
 * @property string $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 */
class Agency extends \yii\db\ActiveRecord
{
    public $imageFiles;
    public $location;
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    
    const SORT_HIGHEST_RATINGS = 'highest_ratings';
    const SORT_MOST_RECOMMENDATIONS = 'most_recommendations';
    const SORT_MOST_FOR_SALE_LISTINGS = 'most_for_sale_listings';
    const SORT_NAME = 'name';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%agency}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'owner_name', 'country', 'state', 'town', 'street_address'], 'required'],
            [['lat', 'lng'], 'number'],
            [['created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['name', 'owner_name','agencyID','calling_code'], 'string', 'max' => 100],
            [['tagline', 'street_address', 'street_number', 'appartment_unit', 'area', 'sub_area', 'local_govt_area', 'urban_town_area', 'district'], 'string', 'max' => 255],
            [['country', 'state', 'town','email','web_address'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['about'], 'string'],
            [['mobile1', 'mobile2','mobile3','calling_code2','calling_code3', 'calling_code4','office1','office2','office3','office4','fax1','fax2','fax3','fax4'], 'string', 'max' => 35],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 5],
            [['zip_code', 'status'], 'string', 'max' => 15],
            [['estd'], 'string', 'max' => 50],
            [['status'], 'default', 'value' => 'active'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'agencyID' => Yii::t('app', 'Agency ID'),
            'name' => Yii::t('app', 'Name'),
            'slug' => Yii::t('app', 'Slug'),
            'tagline' => Yii::t('app', 'Tagline'),
            'owner_name' => Yii::t('app', 'Owner Name'),
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
            'lat' => Yii::t('app', 'Lat'),
            'lng' => Yii::t('app', 'Lng'),
            'estd' => Yii::t('app', 'Estd'),
            'status' => Yii::t('app', 'Status'),
            'email' => Yii::t('app', 'Email'),
            'calling_code' => Yii::t('app','Calling Code'),
            'mobile1' => Yii::t('app', 'Mobile1'),
            'mobile2' => Yii::t('app', 'Mobile2'),
            'mobile3' => Yii::t('app', 'Mobile3'),
            'mobile4' => Yii::t('app', 'Other Mobile'),
            'calling_code2' => Yii::t('app','Calling Code'),
            'office1' => Yii::t('app', 'Office1'),
            'office2' => Yii::t('app', 'Office2'),
            'office3' => Yii::t('app', 'Office3'),
            'office4' => Yii::t('app', 'Other Office'),
            'calling_code3' => Yii::t('app','Calling Code'),
            'fax1' => Yii::t('app', 'Fax1'),
            'fax2' => Yii::t('app', 'Fax2'),
            'fax3' => Yii::t('app', 'Fax3'),
            'fax4' => Yii::t('app', 'Other Fax'),
            'calling_code4' => Yii::t('app','Calling Code'),
            'about' => Yii::t('app','About Agency'),
            'web_address' => Yii::t('app', 'Web Address'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    
    public function beforeSave($insert) {
        parent::beforeSave($insert);
        
        if($this->street_address && $this->town && $this->state){
            $locationLat    =   null;//9.0765° N, 7.3986° E
            $locationLng    =   null;
            $addressData = implode(' ', array_filter([$this->street_number, $this->street_address, $this->area, $this->town,$this->state]));
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
        
        if($insert){
            $i = 1;
            $slug = Inflector::slug($this->name, '');
            while (self::find()->where(['slug' => $slug])->exists()){
                $slug = $slug.$i;
                $i++;
            }
            $this->slug = $slug;
        }
        return true;
    }
    
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
//        if($this->town && $this->state){
//            $cond = [];
//            if($this->zip_code){
//                $cond = ['zip_code' => $this->zip_code];
//            }
//            //\yii\helpers\VarDumper::dump($this->town."++".$this->state); exit;
//            $suggestion = LocationSuggestion::find()->where(['city' => $this->town, 'state' => $this->state])->andWhere($cond)->exists();
//            //\yii\helpers\VarDumper::dump($suggestion,4,12); exit;
//            if($suggestion == false){
//                $suggestionObj = new LocationSuggestion();
//                $suggestionObj->city = $this->town;
//                $suggestionObj->state = $this->state;
//                $suggestionObj->zip_code = $this->zip_code?$this->zip_code:null;
//                $suggestionObj->latitude = $this->lat?$this->lat:null;
//                $suggestionObj->longitude = $this->lng?$this->lng:null;
//                $suggestionObj->save();
//            }
//        }
        if(empty($this->agencyID)){
            $end = $this->id;
            $start = 'AG';
            $characters = range('0','9');
            for ($i = 0; $i < 6 - strlen((string)$end); $i++) {
                    $rand = mt_rand(0, count($characters)-1);
                    $start .= $characters[$rand];
            }
            $this->agencyID = $start.$end;
            $this->save();
        }
    }
    
    public function upload($replace = false){
        foreach ($this->imageFiles as $file) {
            $modelName = StringHelper::basename($this->className());
            $baseName = Yii::$app->security->generateRandomString() . '-' . time();
            $galleryModel = new PhotoGallery();
            $galleryModel->model = $modelName;
            $galleryModel->model_id = $this->id;
            $galleryModel->title = $modelName;
            $galleryModel->image_file_name = $baseName;
            $galleryModel->image_file_extension = $file->extension;
            $galleryModel->original_file_name = $file->name;
            $galleryModel->size = $file->size;
            if($replace === true){
                $oldGallery = PhotoGallery::find()->where(['model' => $modelName, 'model_id' => $this->id])->one();
                if(!empty($oldGallery)){
                    $oldGallery->delete();
                }
            }
            if($galleryModel->save()){
                $file->saveAs(Yii::getAlias("@uploadsPath/$modelName/$baseName.$file->extension"));
                $galleryModel->resizeImage();
            }
        }
    }
    /**
     * @return \yii\db\ActiveQuery
     */
   
    public function getPhoto(){
        return $this->hasOne(PhotoGallery::className(), ['model_id' => 'id'])->andOnCondition(['model' => StringHelper::basename($this->className())])->orderBy(['id' => SORT_DESC])->limit(1);
    }


    public function getPhotos(){
        return $this->hasMany(PhotoGallery::className(), ['model_id' => 'id'])->andOnCondition(['model' => StringHelper::basename($this->className())]);
    } 
    public function behaviors() {
        parent::behaviors();
        return [TimestampBehavior::className(), BlameableBehavior::className()];
    }
    
	public function getFormattedAddress(){
		$addr = implode(' ', array_filter([$this->street_number, $this->street_address]));
		if($this->appartment_unit){
			$addr = $addr. ', #'. $this->appartment_unit;
		}
        return implode(', ', array_filter([$addr, $this->area, $this->town, $this->state]));
    }
    public function getShortAddress(){
        return $this->street_address.",".$this->country;
    }
    /**
     * @return \yii\db\ActiveQuery
    */
    public function getAgents()
    {
        return $this->hasMany(Agent::className(), ['user_id' => 'id']);
    }
    
    public function getNameLink($scheme = false){
        return \yii\helpers\Html::a($this->name, \yii\helpers\Url::to(['agency/view', 'slug' => $this->slug], $scheme), ['target' => '_blank']);
    }

        /**
     * @return \yii\db\ActiveQuery
    */
    public function getOperator()
    {
        return $this->hasOne(User::className(), ['agency_id' => 'id'])->andOnCondition(['profile_id' => User::PROFILE_AGENCY]);
    }

    public function getTotalListings(){
        $agents = Agent::find()->select('id')->where(['agency_id' => $this->id])->active();
        $listings = Property::find()->where(['IN', 'user_id', $agents])->activeSold()->count();
        return $listings;
    }

    /**
     * @return \yii\db\ActiveQuery
    */
    public function getBrokerAgent()
    {
        return $this->hasOne(User::className(), ['agency_id' => 'id'])->andOnCondition(['profile_id' => User::PROFILE_AGENCY, 'broker_is_agent' => 1]);
    }
    
    public function getSocialMedias(){
        return $this->hasMany(SocialMediaLink::className(), ['model_id' => 'id'])->andOnCondition(['model' => StringHelper::basename($this->className())]);
    } 
    public function getTeams(){
        return $this->hasMany(Team::className(), ['agency_id' => 'id']);
    }
    
    public function getTotalAgents(){
        return $this->total_agents + (empty($this->brokerAgent)?0:1);
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
    /**
    * @inheritdoc
    * @return AgencyQuery the active query used by this AR class.
    */
    public static function find()
    {
        return new AgencyQuery(get_called_class());
    }
}
