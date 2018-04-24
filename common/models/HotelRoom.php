<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%hotel_room}}".
 *
 * @property integer $id
 * @property integer $hotel_id
 * @property integer $room_type_id
 * @property string $name
 * @property string $floor_name
 * @property string $inclusion
 * @property string $amenities
 * @property integer $ac
 * @property string $status
 *
 * @property Hotel $hotel
 * @property RoomType $roomType
 */
class HotelRoom extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    
    const AVAILABLE_AC = 1;
    const AVAILABLE_NON_AC = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%hotel_room}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hotel_id', 'room_type_id', 'name', 'floor_name', 'ac', 'status'], 'required'],
            [['hotel_id', 'room_type_id', 'ac'], 'integer'],
            [['inclusion', 'amenities'], 'string'],
            [['name', 'floor_name'], 'string', 'max' => 125],
            [['status'], 'string', 'max' => 15],
            [['hotel_id'], 'exist', 'skipOnError' => true, 'targetClass' => Hotel::className(), 'targetAttribute' => ['hotel_id' => 'id']],
            [['room_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => RoomType::className(), 'targetAttribute' => ['room_type_id' => 'id']],
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
            'room_type_id' => Yii::t('app', 'Room Type ID'),
            'name' => Yii::t('app', 'Room Name'),
            'floor_name' => Yii::t('app', 'Floor Name'),
            'inclusion' => Yii::t('app', 'Inclusion'),
            'amenities' => Yii::t('app', 'Amenities'),
            'ac' => Yii::t('app', 'Ac Avalability'),
            'status' => Yii::t('app', 'Status'),
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
     * @return \yii\db\ActiveQuery
     */
    public function getRoomType()
    {
        return $this->hasOne(RoomType::className(), ['id' => 'room_type_id']);
    }

    public function getIsAc(){
        return $this->ac == 1 ? "Yes" : "No";
        
    }
    /**
     * @inheritdoc
     * @return HotelRoomQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new HotelRoomQuery(get_called_class());
    }
}
