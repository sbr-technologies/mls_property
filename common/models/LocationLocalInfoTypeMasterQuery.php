<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[LocationLocalInfoTypeMaster]].
 *
 * @see LocationLocalInfoTypeMaster
 */
class LocationLocalInfoTypeMasterQuery extends \yii\db\ActiveQuery
{
    public function active(){
        return $this->andWhere(['status' => LocationLocalInfoTypeMaster::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     * @return LocationLocalInfoTypeMaster[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return LocationLocalInfoTypeMaster|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
