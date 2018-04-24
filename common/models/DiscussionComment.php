<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\helpers\Inflector;

use yii\helpers\StringHelper;

/**
 * This is the model class for table "{{%discussion_comment}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $post_id
 * @property string $content
 * @property string $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property DiscussionPost $post
 * @property User $user
 */
class DiscussionComment extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%discussion_comment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'post_id', 'content', 'status'], 'required'],
            [['user_id', 'post_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [['tagIds'], 'safe'],
            [['status'], 'string', 'max' => 15],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => DiscussionPost::className(), 'targetAttribute' => ['post_id' => 'id']],
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
            'post_id' => Yii::t('app', 'Post ID'),
            'content' => Yii::t('app', 'Content'),
            'status' => Yii::t('app', 'Status'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function behaviors() {
        parent::behaviors();
        return [TimestampBehavior::className(), BlameableBehavior::className()];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(DiscussionPost::className(), ['id' => 'post_id']);
    }

    public function getTagIds()
    {
        return explode(',', $this->tag_ids);
    }
    
    public function setTagIds($value)
    {
        $this->tag_ids = (is_array($value)?implode(',', $value):'');
    }
    
    public function getTags()
    {
        return DiscussionTag::find()->where(['in', 'id', $this->tagIds])->all();
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
     * @return DiscussionCommentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DiscussionCommentQuery(get_called_class());
    }
}
