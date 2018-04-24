<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[HolidayPackageFeatureItem]].
 *
 * @see HolidayPackageFeatureItem
 */
class HolidayPackageFeatureItemQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return HolidayPackageFeatureItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return HolidayPackageFeatureItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
