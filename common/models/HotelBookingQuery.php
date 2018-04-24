<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[HotelBooking]].
 *
 * @see HotelBooking
 */
class HotelBookingQuery extends \yii\db\ActiveQuery
{
    public function active(){
        return $this->andWhere(['status' => HotelBooking::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     * @return HotelBooking[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return HotelBooking|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
