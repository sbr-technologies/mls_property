<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%video_gallery}}".
 *
 * @property integer $id
 * @property string $model
 * @property integer $model_id
 * @property string $title
 * @property string $description
 * @property string $video_file_name
 * @property string $video_file_extension
 * @property string $original_file_name
 * @property string $youtube_video_code
 * @property string $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 */
class VideoGallery extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%video_gallery}}';
    }
    public function behaviors() {
        parent::behaviors();
        return [TimestampBehavior::className(), BlameableBehavior::className()];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'youtube_video_code', 'status'], 'required'],
            [['model_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['model'], 'string', 'max' => 100],
            [['title'], 'string', 'max' => 128],
            [['video_file_name', 'original_file_name'], 'string', 'max' => 255],
            [['video_file_extension'], 'string', 'max' => 5],
            [['video_file_extension'], 'url'],
            [['youtube_video_code'], 'string', 'max' => 120],
            [['status'], 'string', 'max' => 15],
        ];
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
            'video_file_name' => Yii::t('app', 'Video File Name'),
            'video_file_extension' => Yii::t('app', 'Video File Extension'),
            'original_file_name' => Yii::t('app', 'Original File Name'),
            'youtube_video_code' => Yii::t('app', 'Youtube Video Code'),
            'status' => Yii::t('app', 'Status'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    public static function findByTitle($title){
        return static::find()->where(['title' => $title])->one();
    }
}
