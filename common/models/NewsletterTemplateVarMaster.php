<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%newsletter_template_var_master}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $variable
 * @property string $status
 */
class NewsletterTemplateVarMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%newsletter_template_var_master}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'variable', 'status'], 'required'],
            [['title', 'variable'], 'string', 'max' => 50],
            [['status'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'variable' => Yii::t('app', 'Variable'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @inheritdoc
     * @return NewsletterTemplateVarMasterQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NewsletterTemplateVarMasterQuery(get_called_class());
    }
}
