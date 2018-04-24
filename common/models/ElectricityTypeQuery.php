<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ElectricityType]].
 *
 * @see ElectricityType
 */
class ElectricityTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ElectricityType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ElectricityType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
