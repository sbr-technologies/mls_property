<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

use yii\helpers\Inflector;

use yii\helpers\StringHelper;

/**
 * This is the model class for table "{{%location_local_info_type_master}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property PropertyLocationLocalInfo[] $propertyLocationLocalInfos
 */
class LocationLocalInfoTypeMaster extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%location_local_info_type_master}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'status'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 15],
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
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyLocationLocalInfos()
    {
        return $this->hasMany(PropertyLocationLocalInfo::className(), ['local_info_type_id' => 'id']);
    }
    
    /**
    * @inheritdoc
    * @return LocationLocalInfoTypeMasterQuery the active query used by this AR class.
    */
    public static function find()
    {
        return new LocationLocalInfoTypeMasterQuery(get_called_class());
    }
}
