<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[PropertyCategory]].
 *
 * @see PropertyCategory
 */
class PropertyCategoryQuery extends \yii\db\ActiveQuery
{
    public function active(){
        return $this->andWhere(['status' => PropertyCategory::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     * @return PropertyCategory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PropertyCategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
