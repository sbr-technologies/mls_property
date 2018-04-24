<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ContactFormDb]].
 *
 * @see ContactFormDb
 */
class ContactFormDbQuery extends \yii\db\ActiveQuery
{
    public function active(){
        return $this->andWhere(['status' => ContactFormDb::STATUS_READ]);
    }

    /**
     * @inheritdoc
     * @return ContactFormDb[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ContactFormDb|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
