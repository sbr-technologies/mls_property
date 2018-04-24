<?php

namespace common\models;

use Yii;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\helpers\Inflector;

use yii\helpers\StringHelper;


/**
 * This is the model class for table "{{%rental}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $description
 * @property string $country
 * @property string $state
 * * @property string $state_long
 * @property string $city
 * @property string $address1
 * @property string $address2
 * @property double $lat
 * @property double $lng
 * @property string $zip_code
 * @property string $land_mark
 * @property string $near_buy_location
 * @property integer $metric_type_id
 * @property string $size
 * @property string $lot_area
 * @property string $no_of_room
 * @property string $no_of_balcony 
 * @property string $no_of_bathroom
 * @property integer $lift
 * @property integer $studio
 * @property integer $pet_friendly
 * @property integer $in_unit_laundry
 * @property integer $pools
 * @property integer $homes
 * @property integer $furnished
 * @property string $water_availability
 * @property integer $status_of_electricity
 * @property string $currency_id
 * @property integer $price
 * @property string $property_video_link
 * @property integer $property_type_id
 * @property integer $property_category_id
 * @property integer $construction_status_id
 * @property string $watermark_image
 * @property string $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property ConstructionStatusMaster $constructionStatus
 * @property MetricType $metricType
 * @property PropertyCategory $propertyCategory
 * @property PropertyType $propertyType
 * @property User $user
 * @property RentalPlan[] $rentalPlans
 */
class Rental extends \yii\db\ActiveRecord
{
    public $imageFiles;
    public $location;
    public $waterMarkImage;
    public $profile_id;

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    
    const LIFT_YES = 1;
    const LIFT_NO = 0;
    
    const FURNISHED_YES = 1;
    const FURNISHED_NO = 0;
    
    const WATER_AVAILABILITY_YES = 1;
    const WATER_AVAILABILITY_NO = 0;
    
    
    
    const STUDIO_YES = 1;
    const STUDIO_NO = 0;
    
    const PET_FRIENDLY_YES = 1;
    const PET_FRIENDLY_NO = 0;
    
    const UNIT_LAUNDRY_YES = 1;
    const UNIT_LAUNDRY_NO = 0;
    
    const POOLS_YES = 1;
    const POOLS_NO = 0;
    
    const HOMES_YES = 1;
    const HOMES_NO = 0;
    
    const SORT_RELEVANT = 'relevant';
    const SORT_NEWEST = 'newest';
    const SORT_LOWEST_PRICE = 'lowest_price';
    const SORT_HIGHEST_PRICE = 'highest_price';
    const SORT_LARGEST_AREA = 'largest_area';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%rental}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'description', 'country', 'state', 'state_long' , 'city', 'address1', 'lat', 'lng', 
                'zip_code', 'metric_type_id', 'size',
                'lot_area', 'no_of_room', 'lift', 'studio', 'furnished', 'currency_id', 'property_type_id', 
                'construction_status_id', 'status', 'no_of_bathroom', 'no_of_bathroom_max', 'no_of_balcony','no_of_balcony_max','no_of_room_max',
                'lot_area_max','size_max', 'pet_friendly', 'in_unit_laundry', 'pools', 'homes', 'furnished','price','rental_category'], 'required'],
            [['user_id', 'metric_type_id', 'lift', 'studio', 'pet_friendly', 'in_unit_laundry', 'pools', 'homes', 'furnished', 'price', 'property_type_id', 'property_category_id', 'construction_status_id', 'currency_id', 'created_by', 'updated_by', 'created_at', 'updated_at','no_of_bathroom_max','no_of_balcony_max','no_of_room_max','lot_area_max','size_max', 'service_fee', 'other_fee'], 'integer'],
            [['description'], 'string'],
            [['lat', 'lng'], 'number'],
            [['title', 'country', 'state', 'city', 'address1', 'address2', 'land_mark', 'near_buy_location', 'water_availability', 'property_video_link'], 'string', 'max' => 255],
            [['zip_code', 'status'], 'string', 'max' => 15],
            [['size', 'lot_area', 'no_of_room', 'no_of_balcony', 'no_of_bathroom'], 'number'],
            [['watermark_image','state_long'], 'string', 'max' => 50],
            [['electricity_type_ids'], 'string', 'max' => 50],
            [['rental_category'], 'string', 'max' => 75],
            [['price_for','service_fee_for','other_fee_for'], 'string', 'max' => 35],
            [['electricityTypeIds'], 'safe'],
            ['property_category_id', 'default', 'value' => 1],
            [['imageFiles'], 'file',  'extensions' => 'png, jpg, jpeg', 'maxFiles' => 25],
            [['imageFiles'], 'file',  'extensions' => 'png, jpg, jpeg', 'maxFiles' => 25,'on' => 'create'],
            [['construction_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => ConstructionStatusMaster::className(), 'targetAttribute' => ['construction_status_id' => 'id']],
            [['metric_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => MetricType::className(), 'targetAttribute' => ['metric_type_id' => 'id']],
            [['property_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => PropertyCategory::className(), 'targetAttribute' => ['property_category_id' => 'id']],
            [['property_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PropertyType::className(), 'targetAttribute' => ['property_type_id' => 'id']],
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
            'profile_id' => Yii::t('app', 'Profile'),
            'user_id' => Yii::t('app', 'User'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'country' => Yii::t('app', 'Country'),
            'state' => Yii::t('app', 'State'),
            'state_long' => Yii::t('app', 'State'),
            'city' => Yii::t('app', 'City'),
            'address1' => Yii::t('app', 'Address1'),
            'address2' => Yii::t('app', 'Address2'),
            'lat' => Yii::t('app', 'Lat'),
            'lng' => Yii::t('app', 'Lng'),
            'zip_code' => Yii::t('app', 'Zip Code'),
            'land_mark' => Yii::t('app', 'Land Mark'),
            'near_buy_location' => Yii::t('app', 'Near Buy Location'),
            'metric_type_id' => Yii::t('app', 'Metric Type'),
            'size' => Yii::t('app', 'Size'),
            'lot_area' => Yii::t('app', 'Lot Area'),
            'no_of_room' => Yii::t('app', 'Bed Room'),
            'no_of_balcony' => Yii::t('app', 'Balcony'),
            'no_of_bathroom' => Yii::t('app', 'Bathroom'),
            'lift' => Yii::t('app', 'Lift'),
            'studio' => Yii::t('app', 'Studio'),
            'pet_friendly' => Yii::t('app', 'Pet Friendly'),
            'in_unit_laundry' => Yii::t('app', 'In Unit Laundry'),
            'pools' => Yii::t('app', 'Pools'),
            'homes' => Yii::t('app', 'Homes'),
            'furnished' => Yii::t('app', 'Furnished'),
            'water_availability' => Yii::t('app', 'Water Availability'),
            'status_of_electricity' => Yii::t('app', 'Status Of Electricity'),
            'currency_id' => Yii::t('app', 'Currency'),
            'price' => Yii::t('app', 'Price'),
            'property_video_link' => Yii::t('app', 'Property Video Link'),
            'property_type_id' => Yii::t('app', 'Property Type'),
            'property_category_id' => Yii::t('app', 'Property Category'),
            'construction_status_id' => Yii::t('app', 'Construction Status'),
            'watermark_image' => Yii::t('app', 'Watermark Image'),
            'status' => Yii::t('app', 'Status'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'formattedAddress' => Yii::t('app','Property Address'),
        ];
    }
    
    public function beforeSave($insert) {
        parent::beforeSave($insert);
        $this->slug = Inflector::slug($this->formattedAddress);
        return true;
    }
    
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
//        if($this->city && $this->state){
//            $cond = [];
//            if($this->zip_code){
//                $cond = ['zip_code' => $this->zip_code];
//            }
//            $suggestion = LocationSuggestion::find()->where(['city' => $this->city, 'state' => $this->state])->andWhere($cond)->exists();
//            if($suggestion == false){
//                $suggestionObj = new LocationSuggestion();
//                $suggestionObj->city = $this->city;
//                $suggestionObj->state = $this->state;
//                $suggestionObj->zip_code = $this->zip_code?$this->zip_code:null;
//                $suggestionObj->latitude = $this->lat?$this->lat:null;
//                $suggestionObj->longitude = $this->lng?$this->lng:null;
//                $suggestionObj->save();
//            }
//        }
        if($insert){
            $end = $this->id;
            $start = '';
            $characters = range('0','9');
            for ($i = 0; $i < 8 - strlen((string)$end); $i++) {
                    $rand = mt_rand(0, count($characters)-1);
                    $start .= $characters[$rand];
            }
            $this->reference_id = $start.$end;
            $this->save();
        }
    }
    
    public function afterFind() {
        parent::afterFind();
        if(is_a(Yii::$app,'yii\web\Application')){
            $cookies = Yii::$app->request->cookies;
            if($cookies->has('selected_currency')){
                $selectedCurrency = $cookies->getValue('selected_currency');
                $curCookies = "{$this->currency->code}_{$selectedCurrency}";
                if($cookies->has($curCookies)){
                    $rate = $cookies->getValue($curCookies);
                }else{
                    $converter = new \imanilchaudhari\CurrencyConverter\CurrencyConverter();
                    $rate = $converter->convert($this->currency->code, $selectedCurrency);
                    $setCookies = Yii::$app->response->cookies;
                    $setCookies->add(new \yii\web\Cookie([
                        'name' => $curCookies,
                        'value' => $rate,
                    ]));
                }
                $this->price = $this->price*$rate;
                Yii::$app->formatter->currencyCode = $selectedCurrency;
            }
        }
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
    public function uploadImage() {
        // get the uploaded file instance. for multiple file uploads
        // the following data will return an array (you may need to use
        // getInstances method)
        $waterMarkImage = UploadedFile::getInstance($this, 'waterMarkImage');
        // if no image was uploaded abort the upload
        if (empty($waterMarkImage)) {
            return false;
        }
        
        // generate a unique file name
        $this->profile_image_file_name = Yii::$app->security->generateRandomString(). '-'. time();
        $this->profile_image_extension = $waterMarkImage->extension;
        // the uploaded image instance
        return $waterMarkImage;
    }
     
    public function getPhotos(){
        return $this->hasMany(PhotoGallery::className(), ['model_id' => 'id'])->andOnCondition(['model' => StringHelper::basename($this->className())]);
    }
    
    public function getReferenceId(){
        return $this->reference_id;
    }
    
    public function getIsLift(){
        return $this->lift == 1 ? "Yes" : "No";
        
    }
    public function getIsFurnished(){
        return $this->furnished == 1 ? "Yes" : "No";
        
    }
    public function getIsWaterAvailability(){
        return $this->water_availability == 1 ? "Yes" : "No";
    }
    public function getIsFeatured(){
        return $this->featured == 1 ? "Yes" : "No";
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpenHouses()
    {
        return $this->hasMany(OpenHouse::className(), ['model_id' => 'id'])->andOnCondition(['model' => StringHelper::basename($this->className())]);
    }
   
    public function getElectricityTypeIds()
    {
        return explode(',', $this->electricity_type_ids);
    }
    
    public function setElectricityTypeIds($value)
    {
        $this->electricity_type_ids = (is_array($value)?implode(',', $value):'');
    }
    
    public function getElectricityTypes()
    {
        return ElectricityType::find()->where(['in', 'id', $this->electricityTypeIds])->all();
    }
    
    public function getPetFriendly(){
        return $this->pet_friendly == 1 ? "Yes" : "No";
    }
    public function getInUnitLaundry(){
        return $this->in_unit_laundry == 1 ? "Yes" : "No";
    }
    public function getPool(){
        return $this->pools == 1 ? "Yes" : "No";
    }
    public function getHome(){
        return $this->homes == 1 ? "Yes" : "No";
    }
    public function getStudios(){
        return $this->studio == 1 ? "Yes" : "No";
    }
    
    public function getFeatureImage($size = PhotoGallery::FULL){
        $photos = $this->photos;
        if(empty($photos)){
            return false;
        }
        return $photos[0]->getImageUrl($size);
    }
    
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRentalFeatures()
    {
        return $this->hasMany(RentalFeature::className(), ['rental_id' => 'id']);
    }
    public function getIsNew(){
        return $this->created_at + 1296000 > time();
    }

    public function getPageTitle(){
        $metaTag = $this->metaTag;
        $title = str_replace('[title]', $this->title, $metaTag->page_title);
        return str_replace(['[site_name]'], [Yii::$app->name], $title);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMetaTag()
    {
        return $this->hasOne(MetaTag::className(), ['model_id' => 'id'])->andOnCondition(['model' => StringHelper::basename($this->className())]);
    }
    
    /**
     * Custom getter functions
     */
    
    public function afterDelete() {
        parent::afterDelete();
        $metaTagModel  = MetaTag::find()->where(['model_id' => $this->id, 'model' => StringHelper::basename($this->className())])->one();
        return $metaTagModel->delete();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConstructionStatus()
    {
        return $this->hasOne(ConstructionStatusMaster::className(), ['id' => 'construction_status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMetricType()
    {
        return $this->hasOne(MetricType::className(), ['id' => 'metric_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(CurrencyMaster::className(), ['id' => 'currency_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyCategory()
    {
        return $this->hasOne(PropertyCategory::className(), ['id' => 'property_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyType()
    {
        return $this->hasOne(PropertyType::className(), ['id' => 'property_type_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRentalLocationLocalInfo()
    {
        return $this->hasMany(RentalLocationLocalInfo::className(), ['rental_id' => 'id']);
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
    public function getRentalPlans()
    {
        return $this->hasMany(RentalPlan::className(), ['rental_id' => 'id']);
    }
    
    public function getFormattedAddress(){
        return implode(', ', array_filter([$this->street_number, $this->street_address, $this->appartment_unit, $this->area, $this->town, $this->state, $this->country]));
    }


    /**
     * @inheritdoc
     * @return RentalQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RentalQuery(get_called_class());
    }
}
