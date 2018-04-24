<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[SellerServiceCategoryMapping]].
 *
 * @see SellerServiceCategoryMapping
 */
class SellerServiceCategoryMappingQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return SellerServiceCategoryMapping[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SellerServiceCategoryMapping|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
