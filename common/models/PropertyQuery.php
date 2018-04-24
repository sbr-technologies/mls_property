<?php

namespace common\models;
use yii\db\Expression;
/**
 * This is the ActiveQuery class for [[Property]].
 *
 * @see Property
 */
class PropertyQuery extends \yii\db\ActiveQuery
{
    public function active(){
        $today = date('Y-m-d');
        return $this->andWhere(['status' => Property::STATUS_ACTIVE, 'market_status' => Property::MARKET_ACTIVE])->andWhere(['>=', 'expired_date', $today])
                ->andWhere(['OR',
                ['is_multi_units_apt' => 0],
                ['AND', ['is_multi_units_apt'=>  1], ['is not', 'parent_id', new Expression('NULL')]]
        ]);
    }
    
    public function sold(){
        $today = date('Y-m-d');
        return $this->andWhere(['status' => Property::STATUS_ACTIVE, 'market_status' => Property::MARKET_SOLD])->andWhere(['>=', 'expired_date', $today])
                ->andWhere(['OR',
                ['is_multi_units_apt' => 0],
                ['AND', ['is_multi_units_apt'=>  1], ['is not', 'parent_id', new Expression('NULL')]]
        ]);
    }
    
    public function activeSold(){
        $today = date('Y-m-d');
        return $this->andWhere(['status' => Property::STATUS_ACTIVE])->andWhere(['OR', ['market_status' => Property::MARKET_ACTIVE], ['market_status' => Property::MARKET_SOLD], ['market_status' => Property::MARKET_PENDING]])->andWhere(['>=', 'expired_date', $today])
                ->andWhere(['OR',
                ['is_multi_units_apt' => 0],
                ['AND', ['is_multi_units_apt'=>  1], ['is not', 'parent_id', new Expression('NULL')]]
        ]);
    }
    
    public function condo(){
        $today = date('Y-m-d');
        return $this->andWhere(['is_multi_units_apt'=>  1, 'parent_id' => null])->andWhere(['>=', 'expired_date', $today]);
    }

    /**
     * @inheritdoc
     * @return Property[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Property|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
