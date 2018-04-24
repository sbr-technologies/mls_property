<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[RentalExtension]].
 *
 * @see RentalExtension
 */
class RentalExtensionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return RentalExtension[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return RentalExtension|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
