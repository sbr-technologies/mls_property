<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[DiscussionComment]].
 *
 * @see DiscussionComment
 */
class DiscussionCommentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return DiscussionComment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return DiscussionComment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
