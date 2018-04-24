<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[PropertyEnquieryFeedback]].
 *
 * @see PropertyEnquieryFeedback
 */
class PropertyEnquieryFeedbackQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return PropertyEnquieryFeedback[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PropertyEnquieryFeedback|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
