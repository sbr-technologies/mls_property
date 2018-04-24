<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[AgentContact]].
 *
 * @see AgentContact
 */
class ContactQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return AgentContact[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AgentContact|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
