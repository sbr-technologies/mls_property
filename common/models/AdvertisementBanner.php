<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "{{%advertisement_banner}}".
 *
 * @property integer $id
 * @property integer $ad_id
 * @property string $title
 * @property string $description
 * @property string $image_file_name
 * @property string $image_file_extension
 * @property string $text_color
 * @property integer $sort_order
 * @property string $status
 *
 * @property Advertisement $ad
 */
class AdvertisementBanner extends \yii\db\ActiveRecord
{
    public $imageFiles;
    public $_destroy;

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%advertisement_banner}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ad_id'], 'required'],
            [['ad_id', 'sort_order'], 'integer'],
            [['description'], 'string'],
            [['sort_order'], 'default', 'value' => 999],
            [['status'], 'default', 'value' => self::STATUS_ACTIVE],
            [['title'], 'string', 'max' => 100],
            [['text_color'], 'string', 'max' => 10],
            [['status'], 'string', 'max' => 15],
            [['imageFiles'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 2],
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 2, 'on' => 'create'],
            [['ad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Advertisement::className(), 'targetAttribute' => ['ad_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ad_id' => Yii::t('app', 'Ad ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'text_color' => Yii::t('app', 'Text Color'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
    
    
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        if($insert){
            $this->ad->updateCounters(['no_of_banner' => 1]);
        }
        return true;
    }
    
    public function afterDelete() {
        parent::afterDelete();
        $this->ad->updateCounters(['no_of_banner' => -1]);
        return true;
    }
    
    public function beforeDelete() {
        parent::beforeDelete();
        $this->photo->delete();
        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAd()
    {
        return $this->hasOne(Advertisement::className(), ['id' => 'ad_id']);
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
   
    public function getPhoto(){
        return $this->hasOne(PhotoGallery::className(), ['model_id' => 'id'])->andOnCondition(['model' => StringHelper::basename($this->className())]);
    }
    
    /**
    * @inheritdoc
    * @return AdvertisementBannerQuery the active query used by this AR class.
    */
    public static function find()
    {
        return new AdvertisementBannerQuery(get_called_class());
    }
}
