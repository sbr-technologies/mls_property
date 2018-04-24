<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ConstructionStatusMaster]].
 *
 * @see ConstructionStatusMaster
 */
class ConstructionStatusMasterQuery extends \yii\db\ActiveQuery
{
    public function active(){
        return $this->andWhere(['status' => ConstructionStatusMaster::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     * @return ConstructionStatusMaster[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ConstructionStatusMaster|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
