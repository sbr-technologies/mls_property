<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[HolidayPackageBooking]].
 *
 * @see HolidayPackageBooking
 */
class HolidayPackageBookingQuery extends \yii\db\ActiveQuery
{
    public function active(){
        return $this->andWhere(['status' => HolidayPackageBooking::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     * @return HolidayPackageBooking[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return HolidayPackageBooking|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
