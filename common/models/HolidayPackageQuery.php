<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[HolidayPackage]].
 *
 * @see HolidayPackage
 */
class HolidayPackageQuery extends \yii\db\ActiveQuery
{
    public function active(){
        return $this->andWhere(['status' => HolidayPackage::STATUS_ACTIVE]);
    }
    /**
     * @inheritdoc
     * @return HolidayPackage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return HolidayPackage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
