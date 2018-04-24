<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[BlogComment]].
 *
 * @see BlogComment
 */
class BlogCommentQuery extends \yii\db\ActiveQuery
{
    public function active(){
        return $this->andWhere(['status' => BlogComment::STATUS_APPROVED]);
    }

    /**
     * @inheritdoc
     * @return BlogComment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BlogComment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
