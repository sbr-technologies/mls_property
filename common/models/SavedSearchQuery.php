<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[SavedSearch]].
 *
 * @see SavedSearch
 */
class SavedSearchQuery extends \yii\db\ActiveQuery
{
    public function active(){
        return $this->andWhere(['status' => SavedSearch::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     * @return SavedSearch[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SavedSearch|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
