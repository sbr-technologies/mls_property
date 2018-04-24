<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[SellerCompany]].
 *
 * @see SellerCompany
 */
class SellerCompanyQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return SellerCompany[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SellerCompany|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
