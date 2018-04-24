<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%discussion_tag}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $status
 */
class DiscussionTag extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%discussion_tag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'status'], 'required'],
            [['title'], 'string', 'max' => 255],
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
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @inheritdoc
     * @return DiscussionTagQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DiscussionTagQuery(get_called_class());
    }
}
