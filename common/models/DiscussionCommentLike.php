<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%discussion_comment_like}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $post_comment_id
 * @property integer $like_count
 * @property string $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property DiscussionComment $postComment
 * @property User $user
 */
class DiscussionCommentLike extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%discussion_comment_like}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'post_comment_id', 'status', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'post_comment_id', 'like_count', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['status'], 'string', 'max' => 15],
            [['post_comment_id'], 'exist', 'skipOnError' => true, 'targetClass' => DiscussionComment::className(), 'targetAttribute' => ['post_comment_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'post_comment_id' => Yii::t('app', 'Post Comment ID'),
            'like_count' => Yii::t('app', 'Like Count'),
            'status' => Yii::t('app', 'Status'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostComment()
    {
        return $this->hasOne(DiscussionComment::className(), ['id' => 'post_comment_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return DiscussionCommentLikeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DiscussionCommentLikeQuery(get_called_class());
    }
}
