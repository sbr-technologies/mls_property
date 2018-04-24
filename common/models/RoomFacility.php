<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%room_facility}}".
 *
 * @property integer $id
 * @property integer $hotel_id
 * @property string $title
 * @property string $description
 *
 * @property Hotel $hotel
 */
class RoomFacility extends \yii\db\ActiveRecord
{
    public $_destroy;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%room_facility}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hotel_id', 'title', 'description'], 'required'],
            [['hotel_id'], 'integer'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 75],
            [['hotel_id'], 'exist', 'skipOnError' => true, 'targetClass' => Hotel::className(), 'targetAttribute' => ['hotel_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'hotel_id' => Yii::t('app', 'Hotel ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHotel()
    {
        return $this->hasOne(Hotel::className(), ['id' => 'hotel_id']);
    }

    /**
     * @inheritdoc
     * @return RoomFacilityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RoomFacilityQuery(get_called_class());
    }
}
