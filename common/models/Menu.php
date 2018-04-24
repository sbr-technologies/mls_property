<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%menu}}".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property string $slug
 * @property string $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Menu extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'created_at', 'updated_at'], 'integer'],
            [['name', 'slug','status'], 'required'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 15],
            [['link'], 'string', 'max' => 150],
        ];
    }
    
    public function behaviors() {
        parent::behaviors();
        return [TimestampBehavior::className()];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'name' => Yii::t('app', 'Name'),
            'slug' => Yii::t('app', 'Slug'),
            'link' => Yii::t('app', 'Link'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function getMenu(){
        return static::findOne(['parent_id' => NULL, 'status' => self::STATUS_ACTIVE]);
    }
    /**
     * @inheritdoc
     * @return MenuQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MenuQuery(get_called_class());
    }
}
