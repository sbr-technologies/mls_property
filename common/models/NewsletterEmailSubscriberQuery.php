<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[NewsletterEmailSubscriber]].
 *
 * @see NewsletterEmailSubscriber
 */
class NewsletterEmailSubscriberQuery extends \yii\db\ActiveQuery
{
    public function active(){
        return $this->andWhere(['status' => NewsletterEmailSubscriber::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     * @return NewsletterEmailSubscriber[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return NewsletterEmailSubscriber|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
