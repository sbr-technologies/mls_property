<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "{{%hotel}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $tagline
 * @property string $description
 * @property string $country
 * @property string $state
 * @property string $town
 * @property string $street_address
 * @property string $street_number
 * @property string $zip
 * @property double $lat
 * @property double $lng
 * @property string $estd
 * @property string $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property HotelBooking[] $hotelBookings
 */
class Hotel extends ActiveRecord
{
    public $imageFiles;
    public $location;
    public $profile_id;
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    
    const SORT_RELEVANT = 'sort_relevant';
    const SORT_RATINGS = 'sort_ratings';
    const SORT_POPULARITY = 'sort_popularity';
    const SORT_RECENT_VIEWED = 'sort_recent_viewed';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%hotel}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id','name', 'country', 'state', 'town', 'street_address','price','days_no','night_no'], 'required'],
            [['description'], 'string'],
            [['lat', 'lng'], 'number'],
            [['price'], 'number', 'max' => 99999999],
            [['days_no','night_no','avg_rating'], 'number'],
            [['user_id','created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['name', 'tagline', 'street_address','sub_area', 'local_govt_area', 'urban_town_area'], 'string', 'max' => 255],
            [['country', 'state', 'town', 'area', 'street_number', 'appartment_unit', 'district'], 'string', 'max' => 75],
            [['imageFiles'], 'file',  'extensions' => 'png, jpg, jpeg', 'maxFiles' => 25],
            [['imageFiles'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 25,'on' => 'create'],
            [['zip_code', 'status'], 'string', 'max' => 15],
            [['estd'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }
    
    public function behaviors() {
        parent::behaviors();
        return [TimestampBehavior::className(), BlameableBehavior::className()];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Hotel Name'),
            'tagline' => Yii::t('app', 'Tagline'),
            'description' => Yii::t('app', 'Description'),
            'price' => Yii::t('app', 'Price'),
            'days_no' => Yii::t('app', 'No. of Days'),
            'night_no' => Yii::t('app', 'No. of Nights'),
            'country' => Yii::t('app','Country'),
            'state' => Yii::t('app','State'),
            'town' => Yii::t('app','Town'),
            'area' => Yii::t('app','Area'),
            'street_address'=> Yii::t('app','Street Address'),
            'sub_area'=> Yii::t('app','Sub Area'),
            'local_govt_area'=> Yii::t('app','Local Government Area'),
            'urban_town_area' => Yii::t('app','Urban Town Area'),
            'street_number' => Yii::t('app','Street #'),
            'appartment_unit' => Yii::t('app','Apartment/Unit #'),
            'district' => Yii::t('app','District'),
            'lat' => Yii::t('app', 'Lat'),
            'lng' => Yii::t('app', 'Lng'),
            'estd' => Yii::t('app', 'Estd'),
            'status' => Yii::t('app', 'Status'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public function beforeSave($insert) {
        parent::beforeSave($insert);
//        if($insert){
//            $i = 1;
//            $slug = Inflector::slug($this->name);
//            while (self::find()->where(['slug' => $slug])->exists()){
//                $slug = $slug.$i;
//                $i++;
//            }
//            $this->slug = $slug;
//        }
        $this->slug     = Inflector::slug($this->formattedAddress); //"1600 Amphitheatre Parkway, Mountain View, CA 94043, USA"
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
    
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
//        if($this->town && $this->state){
//            $cond = [];
//            if($this->zip_code){
//                $cond = ['zip_code' => $this->zip_code];
//            }
//            $suggestion = LocationSuggestion::find()->where(['city' => $this->town, 'state' => $this->state])->andWhere($cond)->exists();
//            
//            if($suggestion == false){
//                $suggestionObj = new LocationSuggestion();
//                $suggestionObj->city = $this->town;
//                $suggestionObj->state = $this->state;
//                $suggestionObj->zip_code = $this->zip_code?$this->zip_code:null;
//                $suggestionObj->latitude = $this->lat?$this->lat:null;
//                $suggestionObj->longitude = $this->lng?$this->lng:null;
//                //\yii\helpers\VarDumper::dump($suggestionObj); exit;
//                $suggestionObj->save();
//            }
//        }
    }

    public function upload(){
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
            if($galleryModel->save()){
                $file->saveAs(Yii::getAlias("@uploadsPath/$modelName/$baseName.$file->extension"));
                $galleryModel->resizeImage();
            }
        }
    }
    /**
     * @return \yii\db\ActiveQuery
     */
   
    public function getPhotos(){
        return $this->hasMany(PhotoGallery::className(), ['model_id' => 'id'])->andOnCondition(['model' => StringHelper::basename($this->className())]);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHotelBookings()
    {
        return $this->hasMany(HotelBooking::className(), ['hotel_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHotelFacilities()
    {
        return $this->hasMany(HotelFacility::className(), ['hotel_id' => 'id']);
    }
    
    public function getRoomFacilities()
    {
        return $this->hasMany(RoomFacility::className(), ['hotel_id' => 'id']);
    }
    
    
    public function getFormattedLineAddress(){
        return $this->street_address.$this->street_number.",".$this->town.",".$this->state.",".$this->country." - ".$this->zip_code;
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
    public function getMetaTag()
    {
        return $this->hasOne(MetaTag::className(), ['model_id' => 'id'])->andOnCondition(['model' => StringHelper::basename($this->className())]);
    }
    
    public function getBuyerSocialMedias(){
        return $this->hasMany(SocialMediaLink::className(), ['model_id' => 'id'])->andOnCondition(['model' => StringHelper::basename($this->className())]);
    } 
    /**
     * Custom getter functions
     */
    public function getFormattedAddress(){
        return implode(', ', array_filter([$this->street_number, $this->street_address, $this->appartment_unit, $this->area, $this->town, $this->state, $this->country]));
    }
    public function afterDelete() {
        parent::afterDelete();
        $metaTagModel  = MetaTag::find()->where(['model_id' => $this->id, 'model' => StringHelper::basename($this->className())])->one();
        return $metaTagModel->delete();
    }
    /**
    * @inheritdoc
    * @return HotelQuery the active query used by this AR class.
    */
    public static function find()
    {
        return new HotelQuery(get_called_class());
    }
}
