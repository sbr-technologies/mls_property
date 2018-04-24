<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

use yii\helpers\StringHelper;

/**
 * This is the model class for table "{{%banner}}".
 *
 * @property integer $id
 * @property integer $type_id
 * @property string $title
 * @property string $description
 * @property string $image_file_name
 * @property string $image_file_extension
 * @property string $text_color
 * @property integer $sort_order
 * @property string $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 */
class Banner extends \yii\db\ActiveRecord
{
    public $imageFiles;
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%banner}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id',], 'required'],
            [['sort_order', 'type_id', 'property_id','created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
            ['sort_order', 'default', 'value' => 999],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 2],
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 2, 'on' => 'create'],
            [['text_color'], 'string', 'max' => 10],
            [['status'], 'string', 'max' => 15],
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
            'type_id' => Yii::t('app', 'Banner Type'),
            'property_id' => Yii::t('app', 'Property'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'text_color' => Yii::t('app', 'Text Color'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'status' => Yii::t('app', 'Status'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
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
   
    public function getPhoto(){
        return $this->hasOne(PhotoGallery::className(), ['model_id' => 'id'])->andOnCondition(['model' => StringHelper::basename($this->className())]);
    }
    
    public function getType(){
        return $this->hasOne(BannerType::className(), ['id' => 'type_id']);
    }
    public function getProperty(){
        return $this->hasOne(Property::className(), ['id' => 'property_id']);
    }

    
        /**
    * @inheritdoc
    * @return BannerQuery the active query used by this AR class.
    */
    public static function find()
    {
        return new BannerQuery(get_called_class());
    }
    
}
