<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[StaticBlock]].
 *
 * @see StaticBlock
 */
class StaticBlockQuery extends \yii\db\ActiveQuery
{
    
    public function init()
    {
        $this->andOnCondition(['<>', 'status', StaticBlock::STATUS_DELETED]);
        parent::init();
    }

    public function active(){
//        return $this->andWhere(['status' => StaticBlock::STATUS_ACTIVE]);
        return $this->andOnCondition(['status' => StaticBlock::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     * @return StaticBlock[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return StaticBlock|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
