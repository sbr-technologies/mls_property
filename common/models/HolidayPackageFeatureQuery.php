<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[HolidayPackageFeature]].
 *
 * @see HolidayPackageFeature
 */
class HolidayPackageFeatureQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return HolidayPackageFeature[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return HolidayPackageFeature|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
