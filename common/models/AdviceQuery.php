<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Advice]].
 *
 * @see Advice
 */
class AdviceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Advice[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Advice|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
