<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[PropertyEnquiery]].
 *
 * @see PropertyEnquiery
 */
class PropertyEnquieryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return PropertyEnquiery[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PropertyEnquiery|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
