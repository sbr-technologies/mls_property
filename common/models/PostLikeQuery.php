<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[PostLike]].
 *
 * @see PostLike
 */
class PostLikeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return PostLike[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PostLike|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
