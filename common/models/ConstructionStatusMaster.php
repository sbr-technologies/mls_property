<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%construction_status_master}}".
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
 */
class ConstructionStatusMaster extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%construction_status_master}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['description'], 'string'],
            [['created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 100],
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
            'status' => Yii::t('app', 'Status'),
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
        return $this->hasMany(Property::className(), ['construction_status_id' => 'id']);
    }
    
    public static function findByTitle($name){
        return static::find()->where(['title' => $name])->one();
    }
    /**
    * @inheritdoc
    * @return ConstructionStatusMasterQuery the active query used by this AR class.
    */
    public static function find()
    {
        return new ConstructionStatusMasterQuery(get_called_class());
    }
}
