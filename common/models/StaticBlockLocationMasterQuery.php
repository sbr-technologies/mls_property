<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[StaticBlockLocationMaster]].
 *
 * @see StaticBlockLocationMaster
 */
class StaticBlockLocationMasterQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return StaticBlockLocationMaster[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return StaticBlockLocationMaster|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
