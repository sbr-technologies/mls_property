<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[RentalFeatureMaster]].
 *
 * @see RentalFeatureMaster
 */
class RentalFeatureMasterQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return RentalFeatureMaster[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return RentalFeatureMaster|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
