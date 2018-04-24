<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[HolidayPackageType]].
 *
 * @see HolidayPackageType
 */
class HolidayPackageTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return HolidayPackageType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return HolidayPackageType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
