<?php

namespace common\models;

use Yii;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "{{%holiday_package_itinerary}}".
 *
 * @property integer $id
 * @property integer $holiday_package_id
 * @property string $days_name
 * @property string $title
 * @property string $description
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $country
 *
 * @property HolidayPackage $holidayPackage
 */
class HolidayPackageItinerary extends \yii\db\ActiveRecord
{
    public $location;
    public $imageFiles;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%holiday_package_itinerary}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['holiday_package_id', 'days_name', 'title', 'description', 'address', 'city', 'state', 'country'], 'required'],
            [['holiday_package_id'], 'integer'],
            [['description'], 'string'],
            [['days_name'], 'string', 'max' => 35],
            [['title'], 'string', 'max' => 255],
            [['address'], 'string', 'max' => 125],
            [['city', 'state', 'country'], 'string', 'max' => 75],
            [['holiday_package_id'], 'exist', 'skipOnError' => true, 'targetClass' => HolidayPackage::className(), 'targetAttribute' => ['holiday_package_id' => 'id']],
            [['imageFiles'], 'file',  'extensions' => 'png, jpg, jpeg', 'maxFiles' => 2],
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 2,'on' => 'create'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'holiday_package_id' => Yii::t('app', 'Holiday Package ID'),
            'days_name' => Yii::t('app', 'Days Name'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'address' => Yii::t('app', 'Address'),
            'city' => Yii::t('app', 'City'),
            'state' => Yii::t('app', 'State'),
            'country' => Yii::t('app', 'Country'),
        ];
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
    public function getHolidayPackage()
    {
        return $this->hasOne(HolidayPackage::className(), ['id' => 'holiday_package_id']);
    }
    /**
     * @inheritdoc
     * @return HolidayPackageItineraryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new HolidayPackageItineraryQuery(get_called_class());
    }
}
