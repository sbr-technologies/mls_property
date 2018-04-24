<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\helpers\Inflector;

use yii\helpers\StringHelper;
/**
 * This is the model class for table "{{%blog_post}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $content
 * @property string $slug
 * @property string $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property BlogComment[] $blogComments
 * @property User $user
 */
class BlogPost extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $imageFiles;
    const STATUS_PENDING = 'pending';
    const STATUS_PUBLISHED = 'published';
    const STATUS_DELETED = 'deleted';

    public static function tableName()
    {
        return '{{%blog_post}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content', 'status','category_id'], 'required'],
            [['user_id','category_id' , 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [['title', 'slug'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 15],
            ['status', 'in', 'range' => [self::STATUS_PENDING, self::STATUS_PUBLISHED, self::STATUS_DELETED]],
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
            'category_id' => Yii::t('app', 'Category'),
            'user_id' => Yii::t('app', 'User ID'),
            'title' => Yii::t('app', 'Title'),
            'content' => Yii::t('app', 'Content'),
            'slug' => Yii::t('app', 'Slug'),
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
   
    public function getPhotos(){
        return $this->hasMany(PhotoGallery::className(), ['model_id' => 'id'])->andOnCondition(['model' => StringHelper::basename($this->className())]);
    }

    public function beforeSave($insert) {
        parent::beforeSave($insert);
        $this->slug = Inflector::slug($this->title);
        return true;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogComments()
    {
        return $this->hasMany(BlogComment::className(), ['post_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function getCategory()
    {
        return $this->hasOne(BlogPostCategory::className(), ['id' => 'cotegory_id']);
    }
    
    /**
    * @inheritdoc
    * @return BlogPostQuery the active query used by this AR class.
    */
    public static function find()
    {
        return new BlogPostQuery(get_called_class());
    }
}
