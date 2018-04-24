<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[PropertyFeature]].
 *
 * @see PropertyFeature
 */
class PropertyFeatureQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return PropertyFeature[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PropertyFeature|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
