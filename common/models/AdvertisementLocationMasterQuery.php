<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[AdvertisementLocationMaster]].
 *
 * @see AdvertisementLocationMaster
 */
class AdvertisementLocationMasterQuery extends \yii\db\ActiveQuery
{
    public function active(){
        return $this->andWhere(['status' => AdvertisementLocationMaster::STATUS_ACTIVE]);
    }
    /**
     * @inheritdoc
     * @return AdvertisementLocationMaster[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AdvertisementLocationMaster|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
