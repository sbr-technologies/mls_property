<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\StringHelper;
use yii\helpers\Inflector;
/**
 * This is the model class for table "{{%holiday_package}}".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property string $description
 * @property string $package_amount
 * @property integer $no_of_days
 * @property integer $no_of_nights
 * @property string $hotel_transport_info
 * @property integer $departure_date
 * @property string $inclusion
 * @property string $exclusions
 * @property string $payment_policy
 * @property string $cancellation policy
 * @property string $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property HolidayPackageCategory $category
 * @property HolidayPackageBooking[] $holidayPackageBookings
 * @property HolidayPackageEnquiry[] $holidayPackageEnquiries
 */
class HolidayPackage extends \yii\db\ActiveRecord
{
    public $imageFiles;
    public $profile_id;
    public $source_location;
    public $destination_location;
    public $vat;
    public $total_amount;
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%holiday_package}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'name', 'package_amount', 'status','source_address','destination_address','source_city','source_state', 'source_state_long', 'source_country','destination_city','destination_state', 'destination_state_long', 'destination_country','currency_id'], 'required'],
            [['user_id','category_id', 'no_of_days', 'no_of_nights', 'created_by', 'updated_by', 'created_at', 'updated_at','currency_id'], 'integer'],
            [['description', 'hotel_transport_info', 'inclusion', 'exclusions', 'payment_policy', 'cancellation_policy'], 'string'],
            [['package_amount', 'source_lat', 'source_lng', 'destination_lat', 'destination_lng'], 'number'],
            [['departureDate'], 'safe'],
            [['source_address','destination_address'], 'string', 'max' => 125],
            [['source_city','source_state','source_country','destination_city','destination_state','destination_country'], 'string', 'max' => 75],
            [['name'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 15],
            [['imageFiles'], 'file',  'extensions' => 'png, jpg, jpeg', 'maxFiles' => 25],
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 25,'on' => 'create'],
            [['no_of_days','no_of_nights'], 'default', 'value' => 0],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => HolidayPackageCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_id' => Yii::t('app', 'Category'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'package_amount' => Yii::t('app', 'Package Amount'),
            'no_of_days' => Yii::t('app', 'No Of Days'),
            'no_of_nights' => Yii::t('app', 'No Of Nights'),
            'hotel_transport_info' => Yii::t('app', 'Hotel Transport Info'),
            'departure_date' => Yii::t('app', 'Departure Date'),
            'inclusion' => Yii::t('app', 'Inclusion'),
            'exclusions' => Yii::t('app', 'Exclusions'),
            'payment_policy' => Yii::t('app', 'Payment Policy'),
            'cancellation policy' => Yii::t('app', 'Cancellation Policy'),
            'source_state_long' => Yii::t('app', 'Source State'),
            'destination_state_long' => Yii::t('app', 'Destination State'),
            'currency_id'           =>  Yii::t('app', 'Currency'),
            
            
            
            'status' => Yii::t('app', 'Status'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    public function behaviors() {
        parent::behaviors();
        return [TimestampBehavior::className(), BlameableBehavior::className()];
    }
    
    
    public function beforeSave($insert) {
        parent::beforeSave($insert);
        $this->slug = Inflector::slug($this->name);
        return true;
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
                $this->package_amount = $this->package_amount*$rate;
                Yii::$app->formatter->currencyCode = $selectedCurrency;
            }
        }
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(HolidayPackageCategory::className(), ['id' => 'category_id']);
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHolidayPackageBookings()
    {
        return $this->hasMany(HolidayPackageBooking::className(), ['holiday_package_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHolidayFeatures()
    {
        return $this->hasMany(HolidayPackageFeature::className(), ['holiday_package_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHolidayPackageItineraries()
    {
        return $this->hasMany(HolidayPackageItinerary::className(), ['holiday_package_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHolidayPackageEnquiries()
    {
        return $this->hasMany(HolidayPackageEnquiry::className(), ['holiday_package_id' => 'id']);
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
    * @inheritdoc
    * @return HolidayPackageQuery the active query used by this AR class.
    */
    public static function find()
    {
        return new HolidayPackageQuery(get_called_class());
    }
    
    /**
     * Relation section end
     * Custom Getter and Setter section start
     */
    public function getDepartureDate(){
        if(!empty($this->departure_date)){
            return Yii::$app->formatter->asDatetime($this->departure_date);
        }
    }
    public function setDepartureDate($time){ 
        //echo $time; exit;
        if(!empty($time)){
            $dateTimeArr    = explode(" ", $time);
            $dateTime = date('Y-m-d', strtotime(str_replace('/', '-', $dateTimeArr[0])));
            //echo $dateTime." ".$dateTimeArr[1]; exit;
            $this->departure_date = strtotime($dateTime." ".$dateTimeArr[1]);
        }
    }
}
