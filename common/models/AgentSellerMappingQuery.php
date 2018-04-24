<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[AgentSellerMapping]].
 *
 * @see AgentSellerMapping
 */
class AgentSellerMappingQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return AgentSellerMapping[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AgentSellerMapping|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
