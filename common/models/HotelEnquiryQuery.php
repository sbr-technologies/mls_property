<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[HotelEnquiry]].
 *
 * @see HotelEnquiry
 */
class HotelEnquiryQuery extends \yii\db\ActiveQuery
{
    public function active(){
        return $this->andWhere(['status' => HotelEnquiry::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     * @return HotelEnquiry[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return HotelEnquiry|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
