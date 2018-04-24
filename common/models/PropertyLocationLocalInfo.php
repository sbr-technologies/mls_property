<?php

namespace common\models;

use Yii;
use common\helpers\LocationHelper;
/**
 * This is the model class for table "{{%property_location_local_info}}".
 *
 * @property integer $id
 * @property integer $property_id
 * @property integer $local_info_type_id
 * @property string $title
 * @property string $description
 * @property string $status
 *
 * @property LocationLocalInfoTypeMaster $localInfoType
 * @property Property $property
 */
class PropertyLocationLocalInfo extends \yii\db\ActiveRecord
{
    public $_destroy;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%property_location_local_info}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['property_id', 'local_info_type_id', 'title'], 'required'],
            [['property_id', 'local_info_type_id'], 'integer'],
            [['description', 'location'], 'string'],
            [['lat', 'lng','distance'], 'number'],
            ['status', 'default', 'value' => 'active'],
            [['title','location'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 15],
            [['local_info_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => LocationLocalInfoTypeMaster::className(), 'targetAttribute' => ['local_info_type_id' => 'id']],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Property::className(), 'targetAttribute' => ['property_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'property_id' => Yii::t('app', 'Property ID'),
            'local_info_type_id' => Yii::t('app', 'Local Info Type'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocalInfoType()
    {
        return $this->hasOne(LocationLocalInfoTypeMaster::className(), ['id' => 'local_info_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(Property::className(), ['id' => 'property_id']);
    }
    
    public function beforeSave($insert) {
        parent::beforeSave($insert);
        $propObj = $this->property;
        $this->distance = round(LocationHelper::distance($this->lat, $this->lng, $propObj->lat, $propObj->lng), 1);
        return true;
    }
}
