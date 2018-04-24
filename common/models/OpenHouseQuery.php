<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[OpenHouse]].
 *
 * @see OpenHouse
 */
class OpenHouseQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return OpenHouse[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OpenHouse|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
