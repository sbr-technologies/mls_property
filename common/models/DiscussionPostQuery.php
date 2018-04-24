<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[DiscussionPost]].
 *
 * @see DiscussionPost
 */
class DiscussionPostQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['status' => DiscussionPost::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     * @return DiscussionPost[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return DiscussionPost|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
