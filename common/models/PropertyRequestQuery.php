<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[PropertyRequest]].
 *
 * @see PropertyRequest
 */
class PropertyRequestQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return PropertyRequest[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PropertyRequest|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
