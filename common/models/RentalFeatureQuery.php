<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[RentalFeature]].
 *
 * @see RentalFeature
 */
class RentalFeatureQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return RentalFeature[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return RentalFeature|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
