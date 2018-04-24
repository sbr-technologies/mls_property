<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%blog_post_category}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $status
 *
 * @property BlogPost[] $blogPosts
 */
class BlogPostCategory extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = "active";
    const STATUS_INACTIVE = "inactive";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%blog_post_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'status'], 'required'],
            [['title'], 'string', 'max' => 75],
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
     * @return \yii\db\ActiveQuery
     */
    public function getBlogPosts()
    {
        return $this->hasMany(BlogPost::className(), ['category_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return BlogPostCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BlogPostCategoryQuery(get_called_class());
    }
}
