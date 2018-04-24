<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%property_type}}".
 *
 * @property integer $id
 * @property integer $property_category_id
 * @property string $title
 * @property string $description
 * @property string $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Property[] $properties
 * @property PropertyCategory $propertyCategory
 */
class PropertyType extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%property_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['property_category_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['status'], 'string', 'max' => 15],
//            [['property_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => PropertyCategory::className(), 'targetAttribute' => ['property_category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'property_category_id' => Yii::t('app', 'Property Category'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'status' => Yii::t('app', 'Status'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    public function behaviors() {
        parent::behaviors();
        return [TimestampBehavior::className(), BlameableBehavior::className()];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperties()
    {
        return $this->hasMany(Property::className(), ['property_type_id' => 'id']);
    }
    public static function findByTitle($name){
        return static::find()->where(['title' => $name])->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyCategory()
    {
        return $this->hasOne(PropertyCategory::className(), ['id' => 'property_category_id']);
    }
    
    /**
     * @inheritdoc
     * @return PropertyTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PropertyTypeQuery(get_called_class());
    }
    
}
