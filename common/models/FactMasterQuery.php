<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[FactMaster]].
 *
 * @see FactMaster
 */
class FactMasterQuery extends \yii\db\ActiveQuery
{
    public function active(){
        return $this->andWhere(['status' => FactMaster::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     * @return FactMaster[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return FactMaster|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
