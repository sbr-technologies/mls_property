<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[UserFavorite]].
 *
 * @see UserFavorite
 */
class UserFavoriteQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return UserFavorite[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return UserFavorite|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
