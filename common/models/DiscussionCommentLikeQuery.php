<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[DiscussionCommentLike]].
 *
 * @see DiscussionCommentLike
 */
class DiscussionCommentLikeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return DiscussionCommentLike[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return DiscussionCommentLike|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
