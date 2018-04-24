<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[NewsletterEmailList]].
 *
 * @see NewsletterEmailList
 */
class NewsletterEmailListQuery extends \yii\db\ActiveQuery
{
    public function active(){
        return $this->andWhere(['status' => NewsletterEmailList::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     * @return NewsletterEmailList[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return NewsletterEmailList|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
