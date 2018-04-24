<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[HolidayPackageEnquiry]].
 *
 * @see HolidayPackageEnquiry
 */
class HolidayPackageEnquiryQuery extends \yii\db\ActiveQuery
{
    public function active(){
        return $this->andWhere(['status' => HolidayPackageEnquiry::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     * @return HolidayPackageEnquiry[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return HolidayPackageEnquiry|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
