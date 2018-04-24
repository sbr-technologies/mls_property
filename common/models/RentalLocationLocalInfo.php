<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%rental_location_local_info}}".
 *
 * @property integer $id
 * @property integer $rental_id
 * @property integer $local_info_type_id
 * @property string $title
 * @property string $location
 * @property string $description
 * @property string $distance
 * @property double $lat
 * @property double $lng
 * @property string $status
 *
 * @property LocationLocalInfoTypeMaster $localInfoType
 * @property Rental $rental
 */
class RentalLocationLocalInfo extends \yii\db\ActiveRecord
{
    public $_destroy;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%rental_location_local_info}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rental_id', 'local_info_type_id', 'title', 'status'], 'required'],
            [['rental_id', 'local_info_type_id'], 'integer'],
            [['description'], 'string'],
            [['distance', 'lat', 'lng'], 'number'],
            [['title', 'location'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 15],
            [['local_info_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => LocationLocalInfoTypeMaster::className(), 'targetAttribute' => ['local_info_type_id' => 'id']],
            [['rental_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rental::className(), 'targetAttribute' => ['rental_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'rental_id' => Yii::t('app', 'Rental ID'),
            'local_info_type_id' => Yii::t('app', 'Local Info Type ID'),
            'title' => Yii::t('app', 'Title'),
            'location' => Yii::t('app', 'Location'),
            'description' => Yii::t('app', 'Description'),
            'distance' => Yii::t('app', 'Distance'),
            'lat' => Yii::t('app', 'Lat'),
            'lng' => Yii::t('app', 'Lng'),
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
    public function getRental()
    {
        return $this->hasOne(Rental::className(), ['id' => 'rental_id']);
    }

    /**
     * @inheritdoc
     * @return RentalLocationLocalInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RentalLocationLocalInfoQuery(get_called_class());
    }
}
