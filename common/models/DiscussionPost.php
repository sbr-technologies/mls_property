<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\helpers\Inflector;

use yii\helpers\StringHelper;

/**
 * This is the model class for table "{{%discussion_post}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $content
 * @property string $slug
 * @property string $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property DiscussionComment[] $discussionComments
 * @property DiscussionLike[] $discussionLikes
 * @property User $user
 */
class DiscussionPost extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%discussion_post}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id','category_id', 'title', 'content', 'slug', 'status'], 'required'],
            [['user_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [['tagIds'], 'safe'],
            [['title', 'slug'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 15],
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
            'title' => Yii::t('app', 'Title'),
            'content' => Yii::t('app', 'Content'),
            'slug' => Yii::t('app', 'Slug'),
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
    public function getDiscussionComments()
    {
        return $this->hasMany(DiscussionComment::className(), ['post_id' => 'id']);
    }

    public function getReadMore($stringToCut = '',$length = 100){
        $stringToCut = strip_tags($stringToCut);	
        if (strlen($stringToCut) > $length) {
                $stringCut = substr($stringToCut, 0, $length);
                $stringToCut = substr($stringCut, 0, strrpos($stringCut, ' '))."..."; 
        }
        return $stringToCut;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostLikes()
    {
        return $this->hasMany(PostLike::className(), ['model_id' => 'id'])->andOnCondition(['model' => StringHelper::basename($this->className())]);
    }

    public function getCategory()
    {
        return $this->hasOne(DiscussionCategory::className(), ['id' => 'category_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
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
     * @inheritdoc
     * @return DiscussionPostQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DiscussionPostQuery(get_called_class());
    }
}
