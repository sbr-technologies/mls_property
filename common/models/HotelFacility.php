<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%hotel_facility}}".
 *
 * @property integer $id
 * @property integer $hotel_id
 * @property string $title
 *
 * @property Hotel $hotel
 */
class HotelFacility extends \yii\db\ActiveRecord
{
    public $_destroy;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%hotel_facility}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hotel_id', 'title'], 'required'],
            [['hotel_id'], 'integer'],
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
     * @return HotelFacilityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new HotelFacilityQuery(get_called_class());
    }
}
