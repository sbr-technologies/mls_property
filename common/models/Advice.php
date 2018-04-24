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
 * This is the model class for table "{{%advice}}".
 *
 * @property integer $id
 * @property integer $advice_category_id
 * @property string $title
 * @property string $content
 * @property string $slug
 * @property string $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AdviceCategory $adviceCategory
 */
class Advice extends \yii\db\ActiveRecord
{
    public $imageFiles;
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%advice}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['advice_category_id', 'title', 'content', 'slug', 'status'], 'required'],
            [['advice_category_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [['title', 'slug'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 15],
            [['advice_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdviceCategory::className(), 'targetAttribute' => ['advice_category_id' => 'id']],
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
            'advice_category_id' => Yii::t('app', 'Advice Category'),
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
   
    public function getPhoto(){
        return $this->hasOne(PhotoGallery::className(), ['model_id' => 'id'])->andOnCondition(['model' => StringHelper::basename($this->className())]);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdviceCategory()
    {
        return $this->hasOne(AdviceCategory::className(), ['id' => 'advice_category_id']);
    }

    public function getReadMore($stringToCut = '',$length = 100){
        $stringToCut = strip_tags($stringToCut);	
        if (strlen($stringToCut) > $length) {
                $stringCut = substr($stringToCut, 0, $length);
                $stringToCut = substr($stringCut, 0, strrpos($stringCut, ' '))."..."; 
        }
        return $stringToCut;
    }
    /**
     * @inheritdoc
     * @return AdviceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdviceQuery(get_called_class());
    }
}
