<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[AgentServiceCategoryMapping]].
 *
 * @see AgentServiceCategoryMapping
 */
class AgentServiceCategoryMappingQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return AgentServiceCategoryMapping[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AgentServiceCategoryMapping|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
