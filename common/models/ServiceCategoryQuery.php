<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ServiceCategory]].
 *
 * @see ServiceCategory
 */
class ServiceCategoryQuery extends \yii\db\ActiveQuery
{
    public function active(){
        return $this->andWhere(['status' => ServiceCategory::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     * @return ServiceCategory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ServiceCategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
