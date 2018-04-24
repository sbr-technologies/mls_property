<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[HolidayPackageCategory]].
 *
 * @see HolidayPackageCategory
 */
class HolidayPackageCategoryQuery extends \yii\db\ActiveQuery
{
    public function active(){
        return $this->andWhere(['status' => HolidayPackageCategory::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     * @return HolidayPackageCategory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return HolidayPackageCategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
