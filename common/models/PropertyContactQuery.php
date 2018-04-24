<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[PropertyContact]].
 *
 * @see PropertyContact
 */
class PropertyContactQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return PropertyContact[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PropertyContact|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
