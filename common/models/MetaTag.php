<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%meta_tag}}".
 *
 * @property integer $id
 * @property string $model
 * @property integer $model_id
 * @property string $page_titlle
 * @property string $description
 * @property string $keywords
 */
class MetaTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%meta_tag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_title'], 'required'],
            [['model_id'], 'integer'],
            [['description', 'keywords'], 'string'],
            [['model'], 'string', 'max' => 75],
            [['page_title'], 'string', 'max' => 255],
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
            'page_title' => Yii::t('app', 'Page Title'),
            'description' => Yii::t('app', 'Description'),
            'keywords' => Yii::t('app', 'Keywords'),
        ];
    }

    /**
     * @inheritdoc
     * @return MetaTagQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MetaTagQuery(get_called_class());
    }
}
