<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%property_category}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Property[] $properties
 * @property PropertyType[] $propertyTypes
 */
class PropertyCategory extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    
    const CATEGORY_SELL = 2;
    const CATEGORY_RENT = 1;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%property_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['description'], 'string'],
            [['created_by', 'updated_by', 'created_at', 'updated_at','sort_order'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['status'], 'string', 'max' => 15],
        ];
    }
    
    /**
     * @inheritdoc
    */
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
            'title' => Yii::t('app', 'Property Category'),
            'description' => Yii::t('app', 'Description'),
            'status' => Yii::t('app', 'Status'),
            'sort_order' => Yii::t('app', 'Order'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperties()
    {
        return $this->hasMany(Property::className(), ['property_category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyTypes()
    {
        return $this->hasMany(PropertyType::className(), ['property_category_id' => 'id']);
    }
    
    /**
     * @inheritdoc
     * @return PropertyCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PropertyCategoryQuery(get_called_class());
    }
    
}

