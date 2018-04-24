<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[BlogPost]].
 *
 * @see BlogPost
 */
class BlogPostQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['status' => 'published']);
    }

    /**
     * @inheritdoc
     * @return BlogPost[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BlogPost|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
