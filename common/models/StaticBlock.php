<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "{{%static_block}}".
 *
 * @property integer $id
 * @property integer $block_location_id
 * @property string $title
 * @property string $content
 * @property string $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property StaticBlockLocationMaster $blockLocation
 */
class StaticBlock extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_DELETED = 'deleted';
    public $imageFiles;
    public $replacePhoto;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%static_block}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['block_location_id', 'title', 'content', 'status'], 'required'],
            [['block_location_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [['title'], 'unique', 'targetAttribute' => ['title', 'block_location_id']],
            [['title', 'name'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 15],
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 2, 'on' => 'create'],
            [['block_location_id'], 'exist', 'skipOnError' => true, 'targetClass' => StaticBlockLocationMaster::className(), 'targetAttribute' => ['block_location_id' => 'id']],
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
            'block_location_id' => Yii::t('app', 'Block Location ID'),
            'name' => Yii::t('app', 'Name'),
            'title' => Yii::t('app', 'Title'),
            'content' => Yii::t('app', 'Content'),
            'status' => Yii::t('app', 'Status'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    
    public function beforeDelete() {
        parent::beforeDelete();
        $this->photo->delete();
        return true;
    }
    
    

    public function upload($replace = false){
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
            if($replace === true){
                $oldGallery = PhotoGallery::find()->where(['model' => $modelName, 'model_id' => $this->id])->one();
                if(!empty($oldGallery)){
                    $oldGallery->delete();
                }
            }
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
     * @return \yii\db\ActiveQuery
     */
    public function getBlockLocation()
    {
        return $this->hasOne(StaticBlockLocationMaster::className(), ['id' => 'block_location_id']);
    }
    
    public static function findByTitle($title){
        return static::find()->where(['title' => $title])->active()->one();
    }
    
    public static function findByName($name){
        return static::find()->where(['name' => $name])->active()->one();
    }

    /**
     * @inheritdoc
     * @return StaticBlockQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StaticBlockQuery(get_called_class());
    }
}
