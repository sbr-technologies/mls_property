<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[MetaTag]].
 *
 * @see MetaTag
 */
class MetaTagQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return MetaTag[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return MetaTag|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
