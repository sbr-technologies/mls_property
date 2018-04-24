<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[AdviceCategory]].
 *
 * @see AdviceCategory
 */
class AdviceCategoryQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['status' => AdviceCategory::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     * @return AdviceCategory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AdviceCategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
