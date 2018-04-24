<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[PropertyShowingContact]].
 *
 * @see PropertyShowingContact
 */
class PropertyShowingContactQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return PropertyShowingContact[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PropertyShowingContact|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
