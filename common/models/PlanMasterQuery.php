<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[PlanMaster]].
 *
 * @see PlanMaster
 */
class PlanMasterQuery extends \yii\db\ActiveQuery
{
    public function active(){
        return $this->andWhere(['status' => PlanMaster::STATUS_ACTIVE]);
    }
    
    public function agent(){
        return $this->andWhere(['for_agency' => 0]);
    }
    public function agency(){
        return $this->andWhere(['for_agency' => 1]);
    }

    /**
     * @inheritdoc
     * @return PlanMaster[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PlanMaster|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
