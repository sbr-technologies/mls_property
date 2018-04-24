<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[PropertyType]].
 *
 * @see PropertyType
 */
class PropertyTypeQuery extends \yii\db\ActiveQuery
{
    public function active(){
        return $this->andWhere(['status' => PropertyType::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     * @return PropertyType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PropertyType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
