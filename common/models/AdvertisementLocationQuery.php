<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[AdvertisementLocation]].
 *
 * @see AdvertisementLocation
 */
class AdvertisementLocationQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['status' => AdvertisementLocation::STATUS_ACTIVE]);
    }


    /**
     * @inheritdoc
     * @return AdvertisementLocation[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AdvertisementLocation|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
