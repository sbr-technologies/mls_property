<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[BlogPostCategory]].
 *
 * @see BlogPostCategory
 */
class BlogPostCategoryQuery extends \yii\db\ActiveQuery
{
    public function active(){
        return $this->andWhere(['status' => BlogPostCategory::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     * @return BlogPostCategory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BlogPostCategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
