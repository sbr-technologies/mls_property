<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

use yii\imagine\Image;
use Imagine\Image\Box;

/**
 * This is the model class for table "{{%photo_gallery}}".
 *
 * @property integer $id
 * @property string $model
 * @property integer $model_id
 * @property string $title
 * @property string $description
 * @property string $image_file_name
 * @property string $image_file_extension
 * @property string $original_file_name
 * @property string $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 */
class PhotoGallery extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    /**
     * @inheritdoc
     */
    const THUMBNAIL = '-150X150';
    const MEDIUM = '-300X300';
    const LARGE = '-640X640';
    const LANDSCAPE = '-1020X750';
    const FULL = '';
    
    public static function tableName()
    {
        return '{{%photo_gallery}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model', 'model_id'], 'required'],
            [['model_id', 'size', 'created_by', 'updated_by', 'created_at', 'updated_at','sort_order'], 'integer'],
            [['description'], 'string'],
            [['model'], 'string', 'max' => 100],
            [['title'], 'string', 'max' => 128],
            [['image_file_name', 'original_file_name'], 'string', 'max' => 255],
            [['image_file_extension'], 'string', 'max' => 5],
            [['status'], 'string', 'max' => 15],
            [['status'], 'default', 'value' => 'active'],
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
            'model' => Yii::t('app', 'Model'),
            'model_id' => Yii::t('app', 'Model ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'sort_order' => Yii::t('app','Order'),
            'image_file_name' => Yii::t('app', 'Image File Name'),
            'image_file_extension' => Yii::t('app', 'Image File Extension'),
            'original_file_name' => Yii::t('app', 'Original File Name'),
            'status' => Yii::t('app', 'Status'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public function afterDelete() {
        parent::afterDelete();
        $this->deleteImage();
        return true;
    }

    public function getImageUrl($size = self::FULL)
    {
        if(empty($this->image_file_name)){
            return;
        }
        return Yii::getAlias('@uploadsUrl/'. "{$this->model}/{$this->image_file_name}{$size}.{$this->image_file_extension}");
    }
    
    public function getImageFile($size = self::FULL) 
    {
        return $this->image_file_name ? Yii::getAlias('@uploadsPath/'. "{$this->model}/{$this->image_file_name}{$size}.{$this->image_file_extension}") : null;
    }
    
    public function resizeImage()
    {
        $file = $this->getImageFile();
        $fileLandscape =  $this->getImageFile(self::LANDSCAPE);
        $fileLarge =  $this->getImageFile(self::LARGE);
        $fileMedium = $this->getImageFile(self::MEDIUM);
        $fileThumb  = $this->getImageFile(self::THUMBNAIL);
        
        Image::getImagine()->open($file)->resize(new Box(1020, 680))->save($fileLandscape , ['quality' => 90]);
//        Image::getImagine()->open($file)->resize(new Box(960, 640))->save($fileLandscape , ['quality' => 90]);
        Image::getImagine()->open($file)->thumbnail(new Box(640, 640))->save($fileLarge , ['quality' => 90]);
        Image::getImagine()->open($file)->thumbnail(new Box(300, 300))->save($fileMedium , ['quality' => 90]);
        Image::thumbnail($file, 150, 150)->save($fileThumb);
    }
    
    public function deleteImage() {
        // if deletion successful, reset your file attributes
        if(static::unlinkFiles($this->image_file_name, $this->image_file_extension, $this->model) == false){
            return false;
        }
        return true;
    }
    
    public static function unlinkFiles($fileName, $fileExt, $modelName){
        
        $file = Yii::getAlias('@uploadsPath/'. "{$modelName}/$fileName.{$fileExt}");
        $fileLarge = Yii::getAlias('@uploadsPath/'. "{$modelName}/$fileName".self::LANDSCAPE.".{$fileExt}");
        $fileLarge = Yii::getAlias('@uploadsPath/'. "{$modelName}/$fileName".self::LARGE.".{$fileExt}");
        $fileMedium = Yii::getAlias('@uploadsPath/'. "{$modelName}/$fileName".self::MEDIUM.".{$fileExt}");
        $fileThumb = Yii::getAlias('@uploadsPath/'. "{$modelName}/$fileName".self::THUMBNAIL.".{$fileExt}");

        // check if file exists on server
        if (empty($file) || !file_exists($file)) {
            return false;
        }

        // check if uploaded file can be deleted on server
        if (!unlink($file) || !unlink($fileLarge) || !unlink($fileMedium) || !unlink($fileThumb)) {
            return false;
        }
        return true;
    }
    
    public function getFileSize() {
        $bytes = $this->size;
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' kB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
}
