<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%discussion_category}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $status
 */
class DiscussionCategory extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%discussion_category}}';
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
     * @return DiscussionCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DiscussionCategoryQuery(get_called_class());
    }
}
