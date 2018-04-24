<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Agency]].
 *
 * @see Agency
 */
class AgencyQuery extends \yii\db\ActiveQuery
{
    public function active(){
        return $this->andWhere(['status' => Agency::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     * @return Agency[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Agency|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
