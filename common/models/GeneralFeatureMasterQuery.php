<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[GeneralFeatureMaster]].
 *
 * @see GeneralFeatureMaster
 */
class GeneralFeatureMasterQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return GeneralFeatureMaster[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return GeneralFeatureMaster|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
