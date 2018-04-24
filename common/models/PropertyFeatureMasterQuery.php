<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[PropertyFeatureMaster]].
 *
 * @see PropertyFeatureMaster
 */
class PropertyFeatureMasterQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return PropertyFeatureMaster[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PropertyFeatureMaster|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
