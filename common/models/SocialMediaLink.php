<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%social_media_link}}".
 *
 * @property integer $id
 * @property string $model
 * @property integer $model_id
 * @property string $name
 * @property string $url
 * @property integer $created_at
 * @property integer $updated_at
 */
class SocialMediaLink extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%social_media_link}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model', 'model_id', 'name'], 'required'],
            [['model_id', 'created_at', 'updated_at'], 'integer'],
            [['model'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 100],
            [['url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'model' => Yii::t('app', 'Type'),
            'model_id' => Yii::t('app', 'Type ID'),
            'name' => Yii::t('app', 'Name'),
            'url' => Yii::t('app', 'Url'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
