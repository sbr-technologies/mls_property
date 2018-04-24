<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "{{%room_type}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property HotelRoom[] $hotelRooms
 */
class RoomType extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%room_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'name' => Yii::t('app', 'Room Type Name'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHotelRooms()
    {
        return $this->hasMany(HotelRoom::className(), ['room_type_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return RoomTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RoomTypeQuery(get_called_class());
    }
}
