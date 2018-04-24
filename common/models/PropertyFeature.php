<?php

namespace common\models;

use Yii;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "{{%property_feature}}".
 *
 * @property integer $id
 * @property integer $property_id
 * @property integer $feature_master_id
 *
 * @property PropertyFeatureMaster $featureMaster
 * @property Property $property
 */
class PropertyFeature extends \yii\db\ActiveRecord
{
    public $imageFiles;
    public $_destroy;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%property_feature}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['property_id', 'feature_master_id'], 'required'],
            [['property_id', 'feature_master_id'], 'integer'],
            [['feature_master_id'], 'exist', 'skipOnError' => true, 'targetClass' => PropertyFeatureMaster::className(), 'targetAttribute' => ['feature_master_id' => 'id']],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Property::className(), 'targetAttribute' => ['property_id' => 'id']],
            [['imageFiles'], 'file', 'skipOnEmpty' =>true, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 25],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'property_id' => Yii::t('app', 'Property ID'),
            'feature_master_id' => Yii::t('app', 'Feature Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeatureMaster()
    {
        return $this->hasOne(PropertyFeatureMaster::className(), ['id' => 'feature_master_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(Property::className(), ['id' => 'property_id']);
    }
    
    public function getFeatureItems()
    {
        return $this->hasMany(PropertyFeatureItem::className(), ['property_feature_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
   
    public function getPhotos(){
        return $this->hasMany(PhotoGallery::className(), ['model_id' => 'id'])->andOnCondition(['model' => StringHelper::basename($this->className())]);
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
    /**
     * @inheritdoc
     * @return PropertyFeatureQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PropertyFeatureQuery(get_called_class());
    }
}
