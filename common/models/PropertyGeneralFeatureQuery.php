<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[PropertyGeneralFeature]].
 *
 * @see PropertyGeneralFeature
 */
class PropertyGeneralFeatureQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return PropertyGeneralFeature[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PropertyGeneralFeature|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
