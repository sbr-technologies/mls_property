<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[PropertyShowingRequestFeedback]].
 *
 * @see PropertyShowingRequestFeedback
 */
class PropertyShowingRequestFeedbackQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return PropertyShowingRequestFeedback[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PropertyShowingRequestFeedback|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
