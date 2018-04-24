<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[HotelFacilityMaster]].
 *
 * @see HotelFacilityMaster
 */
class HotelFacilityMasterQuery extends \yii\db\ActiveQuery
{
    public function active(){
        return $this->andWhere(['status' => 'active']);
    }

    /**
     * @inheritdoc
     * @return HotelFacilityMaster[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return HotelFacilityMaster|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
