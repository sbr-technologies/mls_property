<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%site_config}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $type
 * @property string $key
 * @property string $value
 * @property string $tip
 * @property string $options
 * @property string $unit
 * @property string $default
 * @property string $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class SiteConfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%site_config}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'type', 'key', 'value', 'options', 'created_at', 'updated_at'], 'required'],
            [['value', 'tip', 'default'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 10],
            [['key', 'options', 'unit'], 'string', 'max' => 128],
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
            'type' => Yii::t('app', 'Type'),
            'key' => Yii::t('app', 'Key'),
            'value' => Yii::t('app', 'Value'),
            'tip' => Yii::t('app', 'Tip'),
            'options' => Yii::t('app', 'Options'),
            'unit' => Yii::t('app', 'Unit'),
            'default' => Yii::t('app', 'Default'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public static function item($name){
        $setting = SiteConfig::find()->where(["key" => $name])->one();
        return empty($setting) ? false : $setting->value;
    }
    public static function items($name){
        $settings = static::item($name);
        return empty($settings) ? false : explode("|" , $settings);
    }
}
