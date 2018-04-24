<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[AdvertisementBanner]].
 *
 * @see AdvertisementBanner
 */
class AdvertisementBannerQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['status' => AdvertisementBanner::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     * @return AdvertisementBanner[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AdvertisementBanner|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
