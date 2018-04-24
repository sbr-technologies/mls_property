<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[MetricType]].
 *
 * @see MetricType
 */
class MetricTypeQuery extends \yii\db\ActiveQuery
{
    public function active(){
        return $this->andWhere(['status' => MetricType::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     * @return MetricType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return MetricType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
