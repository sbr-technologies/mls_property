<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\helpers\Inflector;

use yii\helpers\StringHelper;
use common\components\MailSend;


/**
 * This is the model class for table "{{%property}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $country
 * @property string $state
 * @property string $state_long
 * @property string $town
 * @property double $lat
 * @property double $lng
 * @property string $near_buy_location
 * @property integer $metric_type_id
 * @property string $size
 * @property integer $no_of_room
 * @property integer $no_of_balcony
 * @property integer $no_of_bathroom
 * @property integer $lift
 * @property integer $furnished
 * @property string $water_availability
 * @property integer $electritown_type_id
 * @property string $currency_id
 * @property string $price
 * @property string $featured
 * @property string $image_file_name
 * @property string $image_file_extension
 * @property string $watermark_image
 * @property string $property_video_link
 * @property integer $property_type_id
 * @property integer $property_category_id
 * @property integer $construction_status_id
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
 * @property PropertyLocationLocalInformation[] $propertyLocationLocalInformations
 * @property PropertyTaxHistory[] $propertyTaxHistories
 */
class Property extends \yii\db\ActiveRecord
{
    public $imageFiles;
    public $documentFiles;
    public $location;
    public $waterMarkImage;
    public $profile_id;
    public $distance;
    public $save_incomplete;
    public $property_url;
    
    public $share_with;
    public $share_email;
    public $share_name;
    public $share_note;
    public $share_property_url;
    
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_SOLD = 'sold';
    const STATUS_DRAFT = 'draft';
    
    const LIFT_YES = 1;
    const LIFT_NO = 0;
    
    const FURNISHED_YES = 1;
    const FURNISHED_NO = 0;
    
    const WATER_AVAILABILITY_YES = 1;
    const WATER_AVAILABILITY_NO = 0;
    
    const ELECTRIC_STATUS_YES = 1;
    const ELECTRIC_STATUS_NO = 0;
    
    const SOLE_MANDATE_YES = 'yes';
    const SOLE_MANDATE_NO = 'no';
    
    const MARKET_ACTIVE = 'Active';
    const MARKET_NOTACTIVE = 'Not Active';
    const MARKET_PENDING = 'Pending';
    const MARKET_SOLD = 'Sold';
    const MARKET_COMPS_SOLD = 'Comps Sold';
    const MARKET_CANCELLED = 'Cancelled';
    const MARKET_EXPIRED = 'Expired';
    const MARKET_NOT_AVAILABLE = 'Not Available for Sale(NASF)';
    const MARKET_INCOMPLETE = 'Incomplete';
    const MARKET_LEASED = 'Leased';
    const MARKET_NOT_AVAILABLE_FOR_LEASE = 'Not available for Lease';
    


    const SORT_RELEVANT = 'relevant';
    const SORT_NEWEST = 'newest';
    const SORT_LOWEST_PRICE = 'lowest_price';
    const SORT_HIGHEST_PRICE = 'highest_price';
    const SORT_LARGEST_AREA = 'largest_area';
    const MORTGAGE_INSURANCE = 1;
    
    public $cnt;
//    const LIFT_YES = 1;
//    const LIFT_NO = 0;
    
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%property}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'description', 'property_type_id', 'construction_status_id','country', 'state', 'town', 'street_address', 'property_category_id','market_status','expiredDate', 'metric_type_id'], 'required'],
            [['user_id', 'metric_type_id', 'no_of_room', 'no_of_bathroom', 'property_category_id', 'tax', 'insurance', 'hoa_fees', 'featured', 'currency_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'zip_code','lot_size','building_size', 'house_size', 'no_of_toilet', 'no_of_boys_quater', 'year_built','no_of_garage','service_fee','other_fee','is_seller_information_show', 'is_multi_units_apt', 'parent_id', 'floors'], 'integer'],
            [['description','status', 'building_name', 'bedroom_range', 'bathroom_range', 'toilet_range', 'parking_range', 'price_range', 'rental_price_range'], 'string'],
            [['lat', 'lng'], 'number'],
//            ['slug', 'unique'],
            [['price', 'title'], 'required', 'on' => 'prop'],
            [['building_name'], 'required', 'on' => 'condo'],
            [['price','sold_price'], 'number', 'max' => 999999999],
            [['tax'], 'number', 'max' => 9999999],
            [['insurance'], 'number', 'max' => 9999999],
            [['hoa_fees'], 'number', 'max' => 9999999],
            [['virtual_link'], 'string', 'max' => 125],
            [['property_type_id'], 'string', 'max' => 255],
            [['propertyTypeId'], 'safe'],
            [['year_built'], 'number', 'min' => 1900, 'max' => date('Y')],
            [['expiredDate','soldDate'], 'safe'],
            [['construction_status_id'], 'string', 'max' => 255],
            [['constructionStatusId'], 'safe'],
            [['title', 'street_address', 'sub_area', 'local_govt_area', 'urban_town_area'], 'string', 'max' => 255],
            [['price_for','service_fee_payment_term','other_fee_payment_term'], 'string', 'max' => 35],
            [['contact_term'], 'string', 'max' => 100],
            [['country', 'state', 'town', 'area', 'street_number', 'appartment_unit', 'district'],'string', 'max' => 75],
            [['market_status','tax_for','insurance_for','hoa_for'],'string', 'max' => 50],
            [['featured','sole_mandate', 'preimum_lisitng'], 'default', 'value' => 0],
            [['imageFiles'], 'file',  'extensions' => 'png, jpg, jpeg', 'maxFiles' => 20],
            [['imageFiles'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 20,'on' => 'create'],
            [['documentFiles'], 'file',  'extensions' => 'doc, docx, pdf', 'maxFiles' => 5],
            [['documentFiles'], 'file', 'extensions' => 'doc, docx, pdf', 'maxFiles' => 5,'on' => 'create'],
            [['metric_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => MetricType::className(), 'targetAttribute' => ['metric_type_id' => 'id']],
            [['property_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => PropertyCategory::className(), 'targetAttribute' => ['property_category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'profile_id' => Yii::t('app', 'Profile'),
            'reference_id' => Yii::t('app', 'Property ID'),
            'referenceId' => Yii::t('app', 'Property ID'),
            'parent_id' => Yii::t('app', 'If Property part of Complex/Dvlpmt/Sub Division/Flat/Apmt/Condo etc.'),
            'is_multi_units_apt' => Yii::t('app', 'Multi Units Apartment'),
            'user_id' => Yii::t('app', 'User'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'lat' => Yii::t('app', 'Latitude'),
            'lng' => Yii::t('app', 'Longitude'),
            'metric_type_id' => Yii::t('app', 'Metric Type'),
            'no_of_room' => Yii::t('app', 'Bedrooms'),
            'no_of_bathroom' => Yii::t('app', 'Bathrooms'),
            'no_of_garage' => Yii::t('app', 'Parking Spaces'),
            'furnished' => Yii::t('app', 'Furnished'),
            'currency_id' => Yii::t('app', 'Currency'),
            'price' => Yii::t('app', 'Listed Price'),
            'featured' => Yii::t('app', 'Featured'),
            'propertyTypeId' => Yii::t('app', 'Property Type'),
            'PropertyTypeIds' => Yii::t('app', 'Property Type'),
            'property_type_id' => Yii::t('app', 'Property Type'),
            'property_category_id' => Yii::t('app', 'Property Category'),
            'constructionStatusId' => Yii::t('app', 'Construction Status'),
            'construction_status_id' => Yii::t('app', 'Construction Status'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'formattedAddress' => Yii::t('app','Address'),
            'tax' => Yii::t('app','Taxes '),
            'insurance' => Yii::t('app','Insurance'),
            'hoa_fees' => Yii::t('app','Home Owner Association Fee (HOA)'),
            'country' => Yii::t('app','Country'),
            'state' => Yii::t('app','State'),
            'town' => Yii::t('app','Town'),
            'area' => Yii::t('app','Area'),
            'street_address'=> Yii::t('app','Street Name'),
            'sub_area'=> Yii::t('app','Sub Area'),
            'local_govt_area'=> Yii::t('app','Local Government Area'),
            'urban_town_area' => Yii::t('app','Urban Town Area'),
            'street_number' => Yii::t('app','House Number'),
            'appartment_unit' => Yii::t('app','Apt/Unit/Suite #'),
            'district' => Yii::t('app','District'),
            'sole_mandate' => Yii::t('app','Sole Mandate'),
            'preimum_lisitng' => Yii::t('app','Premium Listing'),
            'market_status' => Yii::t('app','Market Status'),
            'zip_code' => Yii::t('app','Zip Code'),
            'lot_size' => Yii::t('app','Lot size'),
            'building_size' => Yii::t('app','Building Size'),
            'house_size' => Yii::t('app','Property Size'),
            'no_of_toilet' => Yii::t('app','Toilets'),
            'no_of_boys_quater' => Yii::t('app','Boys Quarter'),
            'year_built'  => Yii::t('app','Year Built'),
            'price_for' => Yii::t('app', 'Payment Term'),
            'service_fee' => Yii::t('app', 'Service Fee'),
            `service_fee_payment_term` => Yii::t('app','Service Fee Payment Term'), 
            `other_fee` => Yii::t('app','Other Fee'),
            `other_fee_payment_term` => Yii::t('app','Other Fee Payment Term'),
            'contact_term' => Yii::t('app', 'Contact Term'),
            'virtual_link' => Yii::t('app','Virtual Tour'),
            'tax_for' => Yii::t('app','Tax Per Annum'),
            'insurance_for' => Yii::t('app','Insurance Per Annum'),
            'hoa_for' => Yii::t('app','HOA Per Annum'),
            'is_seller_information_show' => Yii::t('app', 'Assign The MLS Properties as the Broker?'),
            'categoryName' => Yii::t('app', 'Property Category'),
            'listedDate' => Yii::t('app', 'Date Listed'),
            'expiredDate' => Yii::t('app', 'Date Expiring'),
            'soldDate' => Yii::t('app', 'Sold Date'),
            'sold_price' => Yii::t('app', 'Sold Price'),
            'expired_date' => Yii::t('app', 'Date Expiring'),
            'AgentID' => Yii::t('app', 'Agent ID'),
            'pricePerUnit' => Yii::t('app', 'Price Per Sqm'),
            
            
        ];
    }
    
    public function assignAttributes($property){
        $this->country = $property['country'];
        $this->state = $property['state'];
        $this->town = $property['town'];
        $this->area = $property['area'];
        $this->district = $property['district'];
        $this->street_number = $property['street_number'];
        $this->street_address = $property['street_address'];
        $this->local_govt_area = $property['local_govt_area'];
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
    public function uploadFile(){
        foreach ($this->documentFiles as $file) {
            //\yii\helpers\VarDumper::dump($file->type,4,12); exit;
            $modelName = StringHelper::basename($this->className());
            $baseName = Yii::$app->security->generateRandomString() . '-' . time();
            $attachModel = new Attachment();
            $attachModel->model = $modelName;
            $attachModel->model_id = $this->id;
            $attachModel->title = $modelName;
            $attachModel->description = "";
            $attachModel->file_name = $baseName;
            $attachModel->file_extension = $file->extension;
            $attachModel->original_file_name = $file->name;
            $attachModel->size = $file->size;
            $attachModel->type = $file->type;
            $attachModel->status = "active";
            if($attachModel->save()){ //echo 22; exit;
                $file->saveAs(Yii::getAlias("@uploadsPath/$modelName/$baseName.$file->extension"));
                
            }else{ //echo 11;
                \yii\helpers\VarDumper::dump($attachModel->errors,4,12); exit;
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
//    'country' => Yii::t('app','Country'),
//            'state' => Yii::t('app','State'),
//            'town' => Yii::t('app','Town'),
//            'area' => Yii::t('app','Area'),
//            'street_address'=> Yii::t('app','Street Address'),
//            'sub_area'=> Yii::t('app','Sub Area'),
//            'local_govt_area'=> Yii::t('app','Local Government Area'),
//            'urban_town_area' => Yii::t('app','Urban Town Area'),
//            'street_number' => Yii::t('app','Street #'),
//            'appartment_unit' => Yii::t('app','Apartment/Unit #'),
//            'appartment_units' => Yii::t('app','House/Apartment/Unit #'),
//            'district' => Yii::t('app','District'),
    
    public function beforeSave($insert) {
        parent::beforeSave($insert);
        
//        $this->slug = Inflector::slug($this->formattedAddress); //"1600 Amphitheatre Parkway, Mountain View, CA 94043, USA"
        if($insert){
            $this->auth_key = Yii::$app->security->generateRandomString();
            $this->rem_sent_at = strtotime('now');
            $i = 1;
            $slug = Inflector::slug($this->formattedAddress);
            while (static::find()->where(['slug' => $slug])->exists()) {
                $slug = $slug .'-'. $i;
                $i++;
            }
            $this->slug = $slug;
            $this->setlistedDate();
        }
        if((empty($this->lat) || empty($this->lng)) && $this->street_address && $this->town && $this->state){
            $locationLat    =   null;//9.0765° N, 7.3986° E
            $locationLng    =   null;
            $addressData = implode(' ', array_filter([$this->street_number, $this->street_address, $this->area, $this->town, $this->state]));
            $location =  file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=". urlencode($addressData) ."&key=".Yii::$app->params['googleMapKey']."");
            $locationObj = json_decode($location);
//            var_dump($locationObj->results[0]->geometry->location);die();
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
        //\yii\helpers\VarDumper::dump($this->price); exit;
        parent::afterSave($insert, $changedAttributes);
        
        if($insert){
            $end = $this->id;
            $start = 'P';
            $characters = range('0','9');
            for ($i = 0; $i < 10 - strlen((string)$end); $i++) {
                    $rand = mt_rand(0, count($characters)-1);
                    $start .= $characters[$rand];
            }
            $this->reference_id = $start.$end;
                        
            $profileId     =   $this->user->profile->id;
//            \yii\helpers\VarDumper::dump($profileId."++".$this->user_id);
//            \yii\helpers\VarDumper::dump($agencyId);exit;
            if($profileId == 5 || $profileId == 7){
                $agencyId   =   $this->user->agency->id; 
            }else{
                $agencyId   = null;
            }
            
            $this->agency_id = $agencyId;
            $this->save();
            
            $priceHistory                   = new PropertyPriceHistory();
            $priceHistory->property_id      = $this->id;
            $priceHistory->date             = date("Y-m-d");
            $priceHistory->price            = $this->price;
            $priceHistory->status           = "Listed";
            $priceHistory->save();
            $this->setUserMaxMinPrice($insert);
			
            if($this->status != self::STATUS_DRAFT && $this->agency_id){
                    $agencyModel = Agency::findOne($this->agency_id);
                    $agencyModel->updateCounters(['total_listings' => 1]);
            }
        }else{
            $oldPropPrice = PropertyPriceHistory::find()->where(['property_id' => $this->id])->orderBy(['id' => SORT_DESC])->limit(1)->one();
            if(!empty($oldPropPrice) && $oldPropPrice->price != $this->price){
                $priceHistory                   = new PropertyPriceHistory();
                $priceHistory->property_id      = $this->id;
                $priceHistory->date             = date("Y-m-d");
                $priceHistory->price            = $this->price;
                $priceHistory->status           = "Updated";
                $priceHistory->save();
                $this->setUserMaxMinPrice($insert);
            }
        }  
        if(!$this->reference_id){
            $end = $this->id;
            $start = 'P';
            $characters = range('0','9');
            for ($i = 0; $i < 10 - strlen((string)$end); $i++) {
                    $rand = mt_rand(0, count($characters)-1);
                    $start .= $characters[$rand];
            }
            $this->reference_id = $start.$end;
            $this->save();
        }
        
         if($this->street_address ||  $this->street_number || $this->appartment_unit){
            $cond = [];
            if($this->street_address){
                $cond = ['street_name' => $this->street_address];
            }
            if($this->street_number){
                $cond = array_merge($cond, ['street_number' => $this->street_number]);
            }
            if($this->appartment_unit){
                $cond = array_merge($cond, ['suite_number' => $this->appartment_unit]);
            }
            $suggestion = AddressSuggestion::find()->where($cond)->exists();
            if($suggestion == false){
                $suggestionObj = new AddressSuggestion();
                $suggestionObj->street_name = $this->street_address;
                $suggestionObj->street_number = $this->street_number;
                $suggestionObj->suite_number = $this->appartment_unit;
                $suggestionObj->save();
            }
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
//                $this->price = $this->price*$rate;
//                Yii::$app->formatter->currencyCode = $selectedCurrency;
            }
        }
    }

    


    public function setUserMaxMinPrice($insert) {
        $user = User::find(['id' => $this->user_id])->one();
        if($insert){
            $user->updateCounters(['total_listings' => 1]);
            $user->last_activity = 'listing';
            $user->last_activity_at = strtotime('now');
        }
        if ($this->price > $user->max_price) {
            $user->max_price = $this->price;
        }
        if ($this->price < $user->min_price) {
            $user->min_price = $this->price;
        }
        $user->save();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
   
   public function setlistedDate($date = null) {
        $this->listed_date = date('Y-m-d', time());
    }

    public function getlistedDate() {
        if (!empty($this->listed_date)) {
            return Yii::$app->formatter->asDate($this->listed_date);
        }
    }
    
    public function getListedBy(){
        if($this->user->profile_id == User::PROFILE_AGENT){
            return $this->user;
        }elseif($this->user->profile_id == User::PROFILE_SELLER){
            if($this->isSellerInformationShow == 'No'){
                return $this->user;
            }else{
                $agentId = SiteConfig::item('agentId');
                $adminUserData      = User::findOne($agentId);
                return $adminUserData;
            }
        }
    }

    public function setExpiredDate($date) {
        $this->expired_date = date('Y-m-d', strtotime(str_replace('/', '-', $date)));
    }

    public function getExpiredDate() {
        if (!empty($this->expired_date)) {
            return Yii::$app->formatter->asDate($this->expired_date);
        }
    }
    public function setSoldDate($date) {
        if(isset($date) && $date != ''){
            $this->sold_date = date('Y-m-d', strtotime(str_replace('/', '-', $date)));
        }else{
            $this->sold_date = null;
        }
    }

    public function getSoldDate() {
        if (!empty($this->sold_date)) {
            return Yii::$app->formatter->asDate($this->sold_date);
        }
    }
    
    public function getAge(){
        if($this->year_built){
            return date('Y') - $this->year_built;
        }
    }

    public function behaviors() {
        parent::behaviors();
        return [TimestampBehavior::className(), BlameableBehavior::className()];
    }
    public function getPhotos(){
        return $this->hasMany(PhotoGallery::className(), ['model_id' => 'id'])->andOnCondition(['model' => StringHelper::basename($this->className())])->orderBy(['sort_order' => SORT_ASC]);
    }
    public function getDocuments(){
        return $this->hasMany(Attachment::className(), ['model_id' => 'id'])->andOnCondition(['model' => StringHelper::basename($this->className())])->orderBy(['sort_order' => SORT_ASC]);
    }
    public function getPropertyShowingContacts(){
        return $this->hasMany(PropertyShowingContact::className(), ['property_id' => 'id']);
    }
    
    public function getFeatureImage($size = PhotoGallery::FULL){
        $photos = $this->photos;
        return empty($photos)? Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png'):$photos[0]->getImageUrl($size);
    }

    public function getFeatureThumbImage($size = PhotoGallery::THUMBNAIL){
        $photos = $this->photos;
        return empty($photos)? Yii::getAlias('@uploadsUrl/banner_image/no_image_avaliable.png'):$photos[0]->getImageUrl($size);
    }

    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
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
    public function getCategoryName() {
        return $this->propertyCategory->title;
    }
    
    
    public function getAgentID() {
        return $this->user->agentID;
    }
    
    public function getCurrentPrice(){
        if($this->market_status == self::MARKET_SOLD){
            return $this->sold_price;
        }
        return $this->price;
    }

    public function getDaysListed(){
        return round((time() - strtotime($this->listed_date)) / (60 * 60 * 24));
    }
    
    public function getDaysExpiring($strict = false){
        if(strtotime($this->expired_date)< time() && $strict == false){
            return 0;
        }
        return round((strtotime($this->expired_date) - time()) / (60 * 60 * 24));
    }
    
    public function renew($days = 30){
        $renewOn = $this->expired_date;
        $today = date('Y-m-d');
        if($renewOn < $today){
            $renewOn = $today;
        }
        $this->expired_date = date('Y-m-d', strtotime("+$days days", strtotime($renewOn)));
        if($this->market_status == self::MARKET_EXPIRED){
            $this->market_status = self::MARKET_ACTIVE;
        }
        return $this->save();
    }
    
    public function getPricePerUnit(){
        if(!$this->house_size){
            return null;
        }
        $price = $this->price;
        if($this->market_status == self::MARKET_SOLD){
            $price = $this->sold_price;
        }
        return round($price / $this->house_size);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMetaTag()
    {
        return $this->hasOne(MetaTag::className(), ['model_id' => 'id'])->andOnCondition(['model' => StringHelper::basename($this->className())]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public function getPropertyTypeId()
    {
        return explode(',', $this->property_type_id);
    }
    
    public function getFirstPropertyType(){
        if(!empty($ids = $this->propertyTypeId)){
            $type = PropertyType::findOne($ids[0]);
            return (empty($type)?null:$type->title);
        }
        return null;
    }
    
    public function getPropertyTypes(){
        if(!empty($ids = $this->propertyTypeId)){
            $types = PropertyType::find()->where(['id' => $ids])->all();
            return (empty($types)?null: implode(',', \yii\helpers\ArrayHelper::getColumn($types, 'title')));
        }
        return null;
    }

    public function setPropertyTypeId($value)
    {
        $this->property_type_id = (is_array($value)?implode(',', $value):'');
    }
    
    public function getPropertyTypeIds()
    {
        return PropertyType::find()->where(['in', 'id', $this->propertyTypeId])->all();
    }
    
    public function getConstructionStatusId()
    {
        return explode(',', $this->construction_status_id);
    }
    
    public function setConstructionStatusId($value)
    {
        $this->construction_status_id = (is_array($value)?implode(',', $value):'');
    }
    
    public function getConstructionStatus()
    {
        return ConstructionStatusMaster::find()->where(['in', 'id', $this->constructionStatusId])->all();
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContacts()
    {
        return $this->hasMany(Contact::className(), ['property_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyLocationLocalInfo()
    {
        return $this->hasMany(PropertyLocationLocalInfo::className(), ['property_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyGeneralFeature()
    {
        return $this->hasMany(PropertyGeneralFeature::className(), ['property_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeneralFeatures()
    {
        return $this->hasMany(GeneralFeatureMaster::className(), ['id' => 'general_feature_master_id'])->viaTable('{{%property_general_feature}}', ['property_id' => 'id']);
    }
    
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyFactInfo()
    {
        return $this->hasMany(PropertyFactInfo::className(), ['property_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyFeatures()
    {
        return $this->hasMany(PropertyFeature::className(), ['property_id' => 'id']);
    }
    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyTaxHistories()
    {
        return $this->hasMany(PropertyTaxHistory::className(), ['property_id' => 'id'])->andOnCondition(['<>', 'year', '']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpenHouses()
    {
        return $this->hasMany(OpenHouse::className(), ['model_id' => 'id'])->andOnCondition(['model' => StringHelper::basename($this->className())]);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpenHouse()
    {
        return $this->hasOne(OpenHouse::className(), ['model_id' => 'id'])->andOnCondition(['model' => StringHelper::basename($this->className())]);
    }
    
     /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyPriceHistories()
    {
        return $this->hasMany(PropertyPriceHistory::className(), ['property_id' => 'id'])->orderBy(['id' => SORT_DESC]);
    }
 
    public function getReferenceId(){
        return $this->reference_id ? $this->reference_id : '';
    }
    public function getFormattedAddress(){
        $addr = implode(' ', array_filter([$this->street_number, $this->street_address]));
        if($this->appartment_unit){
                $addr = $addr. ', #'. $this->appartment_unit;
        }
        return implode(', ', array_filter([$addr, $this->area, $this->town, $this->state]));
    }
    public function getFormattedGmapAddress(){
        $addr = implode(' ', array_filter([$this->street_number, $this->street_address]));
        return urlencode(implode(', ', array_filter([$addr, $this->area, $this->town, $this->state])));
    }
    
    public function getFormattedPdfAddress(){
        return implode('<br> ', array_filter([$this->street_number, $this->street_address, $this->appartment_unit, $this->area, $this->town, $this->state, $this->country]));
    }
    
    public function getShortAddress(){
        $addr = implode(' ', array_filter([$this->street_number, $this->street_address]));
        if($this->appartment_unit){
                $addr = $addr. ', #'. $this->appartment_unit;
        }
        return $addr;
    }
    public function getReqAddress(){
        return implode(', ', array_filter([$this->street_number, $this->street_address]));
    }
    
    public function getSlug(){
        return $this->slug;
    }
    public function getIsFeatured(){
        return $this->featured == 1 ? "Yes" : "No";
    }
    public function getSoleMandate(){
        return $this->sole_mandate == 1 ? "Yes" : "No";
    }
    public function getPreimumLisitng(){
        return $this->preimum_lisitng == 1 ? "Yes" : "No";
    }
    
    public function getIsSellerInformationShow(){
        return $this->is_seller_information_show == 1 ? "Yes" : "No";
    }
    
    
    public function getIsNew(){
        return $this->created_at + 604800 > time();
    }

    public function getPageTitle(){
        $metaTag = $this->metaTag;
        $title = str_replace('[title]', $this->title, $metaTag->page_title);
        return str_replace(['[site_name]'], [Yii::$app->name], $title);
    }
    
    /**
     * Custom getter functions
     */
    
    public function afterDelete() {
        parent::afterDelete();
		if($this->status != self::STATUS_DRAFT && $this->agency_id){
			$agencyModel = Agency::findOne($this->agency_id);
			$agencyModel->updateCounters(['total_listings' => -1]);
		}
        $metaTagModel  = MetaTag::find()->where(['model_id' => $this->id, 'model' => StringHelper::basename($this->className())])->one();
        return $metaTagModel->delete();
    }
    

    public function getPropertySocialMedias(){
        return $this->hasMany(SocialMediaLink::className(), ['model_id' => 'id'])->andOnCondition(['model' => StringHelper::basename($this->className())]);
    }
    
    
    public function getDuplicate(){
       return static::find()->select(['slug'])->where(['property_category_id' => $this->property_category_id, 'is_multi_units_apt' => $this->is_multi_units_apt, 'street_number' => $this->street_number, 'street_address' => $this->street_address, 'appartment_unit' => $this->appartment_unit, 'area' => $this->area, 'town' => $this->town, 'state' => $this->state])->andWhere(['<>', 'id', $this->id])->active()->all();
    }
    
    public function getUnitsForSellCount(){
        if($this->isCondo){
            return static::find()->where(['property_category_id' => 2, 'parent_id' => $this->id])->active()->count();
        }
    }
    
    public function getUnitsForRentCount(){
        if($this->isCondo){
            return static::find()->where(['property_category_id' => 1, 'parent_id' => $this->id])->active()->count();
        }else{
            return null;
        }
    }

    public function getIsCondo(){
        return $this->is_multi_units_apt = 1 && empty($this->parent_id);
    }

//    public function notifySavedList() {
//        if ($this->market_status == self::MARKET_ACTIVE || $this->market_status == self::MARKET_PENDING || $this->market_status == self::MARKET_SOLD) {
//            $sql = "SELECT * FROM " . SavedSearch::tableName() . "WHERE `schedule` <> 'never' AND status = 'active'"
//            . " AND JSON_EXTRACT(`search_string`, '$.filters.state')  like '%" . $this->state . "%'"
//            . " AND JSON_EXTRACT(`search_string`, '$.filters.town')  like '%" . $this->town . "%'"
//            . " AND JSON_EXTRACT(`search_string`, '$.filters.area')  like '%" . $this->area . "%'";
//            $savedList = SavedSearch::findBySql($sql)->all();
//            if (!empty($savedList)) {
//                foreach ($savedList as $item) {
//                    $curTime = strtotime('now');
//                    $dailyTime = strtotime($item->last_alert_sent_at . ' +1 day');
//                    $weeklyTime = strtotime($item->last_alert_sent_at . ' +7 days');
//                    if($item->schedule == 'daily' && $dailyTime>$curTime){
//                        continue;
//                    }elseif($item->schedule == 'weekly' && $weeklyTime>$curTime){
//                        continue;
//                    }
//                    
//                    $user = $item->user;
//                    $recipients = $item->recipient;
//                    if ($item->cc_self) {
//                        array_push($recipients, $user->email);
//                    }
//                    $itemHtml = '<ul>';
//                    $searchArray = json_decode($item->search_string);
//                    foreach ($searchArray->filters as $key => $filter) {
//                        if (!empty($filter)) {
//                            $itemHtml .= '<li>' . SavedSearch::formattedFilter($key) . ': ' . SavedSearch::RelatedValue($key, $filter) . '</li>';
//                        }
//                    }
//
//                    $itemHtml .= '</ul>';
//
//                    if (!empty($recipients)) {
//                        $vars = [];
//                        $vars['{{%USER_NAME%}}'] = $user->commonName;
//                        $vars['{{%CRITERIA%}}'] = $itemHtml;
//                        $vars['{{%SEARCH_NAME%}}'] = $item->name;
//                        $vars['{{%SEARCH_LINK%}}'] = $item->searchUrl;
//                        MailSend::sendMail('SAVED_PROPERTY_ALERT', $recipients, $vars);
//                        $savedSearchModel = SavedSearch::findOne($item->id);
//                        $savedSearchModel->last_alert_sent_at = $curTime;
//                        $savedSearchModel->save();
//                    }
//                }
//            }
//        }
//    }

    /**
     * @inheritdoc
     * @return PropertyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PropertyQuery(get_called_class());
    }
    
}
