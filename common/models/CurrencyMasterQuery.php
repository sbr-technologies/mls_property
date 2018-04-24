<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[CurrencyMaster]].
 *
 * @see CurrencyMaster
 */
class CurrencyMasterQuery extends \yii\db\ActiveQuery
{
    public function active(){
        return $this->andWhere(['status' => 'active']);
    }

    /**
     * @inheritdoc
     * @return CurrencyMaster[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CurrencyMaster|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
