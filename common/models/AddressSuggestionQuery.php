<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[AddressSuggestion]].
 *
 * @see AddressSuggestion
 */
class AddressSuggestionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return AddressSuggestion[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AddressSuggestion|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
