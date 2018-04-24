<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%banner_type}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $text_color
 * @property string $status
 *
 * @property Banner[] $banners
 */
class BannerType extends \yii\db\ActiveRecord
{
    
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%banner_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['text_color'], 'string', 'max' => 10],
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
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'text_color' => Yii::t('app', 'Text Color'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBanners()
    {
        return $this->hasMany(Banner::className(), ['type_id' => 'id']);
    }
    public static function findByName($title){
        return static::find()->where(['title' => $title])->active()->one();
    }
    /**
     * @inheritdoc
     * @return BannerTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BannerTypeQuery(get_called_class());
    }
}
