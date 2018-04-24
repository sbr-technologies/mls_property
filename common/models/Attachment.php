<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%attachment}}".
 *
 * @property integer $id
 * @property string $model
 * @property integer $model_id
 * @property string $title
 * @property string $description
 * @property string $file_name
 * @property string $file_extension
 * @property string $original_file_name
 * @property integer $size
 * @property string $type
 * @property string $status
 */
class Attachment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%attachment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model', 'model_id', 'title', 'file_name', 'file_extension', 'original_file_name', 'size', 'type', 'status'], 'required'],
            [['model_id', 'size','sort_order'], 'integer'],
            [['description'], 'string'],
            [['model'], 'string', 'max' => 100],
            [['title'], 'string', 'max' => 128],
            [['file_name', 'original_file_name'], 'string', 'max' => 255],
            [['file_extension'], 'string', 'max' => 5],
            [['type'], 'string', 'max' => 255],
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
            'sort_order' => Yii::t('app','Order'),
            'file_name' => Yii::t('app', 'File Name'),
            'file_extension' => Yii::t('app', 'File Extension'),
            'original_file_name' => Yii::t('app', 'Original File Name'),
            'size' => Yii::t('app', 'Size'),
            'type' => Yii::t('app', 'File Type'),
            'status' => Yii::t('app', 'Status'),
        ];
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
