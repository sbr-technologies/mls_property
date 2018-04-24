<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ReviewRating]].
 *
 * @see ReviewRating
 */
class ReviewRatingQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['status' => 'active']);
    }

    /**
     * @inheritdoc
     * @return ReviewRating[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ReviewRating|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
