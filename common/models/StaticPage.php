<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\helpers\Inflector;

use yii\helpers\StringHelper;
/**
 * This is the model class for table "{{%static_page}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $content
 * @property string $slug
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 */
class StaticPage extends \yii\db\ActiveRecord {

    public $imageFiles;
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%static_page}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'content', 'slug', 'status'], 'required'],
            [['content', 'meta_keywords', 'meta_description'], 'string'],
            [['created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['name', 'meta_title'], 'string', 'max' => 255],
            [['slug'], 'string', 'max' => 150],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 4],
            [['status'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Title'),
            'content' => Yii::t('app', 'Content'),
            'slug' => Yii::t('app', 'Slug'),
            'meta_title' => Yii::t('app', 'Meta Title'),
            'meta_keywords' => Yii::t('app', 'Meta Kewords'),
            'meta_description' => Yii::t('app', 'Meta Description'),
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

    public function beforeValidate() {
        parent::beforeValidate();
        $this->slug = Inflector::slug($this->name);
        return true;
    }
    
    /**
     * Custom getter functions
     */
    
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
    
    public function getPageTitle(){
        $title = str_replace('[name]', $this->name, $this->meta_title);
        return str_replace(['[site_name]'], [Yii::$app->name], $title);
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
    
    public static function findByName($name){
        return static::find()->where(['name' => $name])->one();
    }
    
    public static function findBySlug($slug){
        return static::find()->where(['slug' => $slug])->one();
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
   
    public function getPhotos(){
        return $this->hasMany(PhotoGallery::className(), ['model_id' => 'id'])->andOnCondition(['model' => StringHelper::basename($this->className())]);
    }
}
