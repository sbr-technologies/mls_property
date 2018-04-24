<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[NewsletterSchedule]].
 *
 * @see NewsletterSchedule
 */
class NewsletterScheduleQuery extends \yii\db\ActiveQuery
{
    public function active(){
        $today = date('Y-m-d');
        return $this->andWhere(['status' => 'active'])->andWhere(['>=', 'schedule_end_date', $today]);
    }

    /**
     * @inheritdoc
     * @return NewsletterSchedule[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return NewsletterSchedule|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
