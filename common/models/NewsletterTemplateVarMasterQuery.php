<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[NewsletterTemplateVarMaster]].
 *
 * @see NewsletterTemplateVarMaster
 */
class NewsletterTemplateVarMasterQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return NewsletterTemplateVarMaster[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return NewsletterTemplateVarMaster|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
