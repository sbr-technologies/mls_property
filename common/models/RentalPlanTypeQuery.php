<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[RentalPlanType]].
 *
 * @see RentalPlanType
 */
class RentalPlanTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return RentalPlanType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return RentalPlanType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
