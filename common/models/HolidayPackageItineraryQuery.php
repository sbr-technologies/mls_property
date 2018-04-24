<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[HolidayPackageItinerary]].
 *
 * @see HolidayPackageItinerary
 */
class HolidayPackageItineraryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return HolidayPackageItinerary[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return HolidayPackageItinerary|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
