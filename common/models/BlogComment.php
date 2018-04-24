<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "{{%blog_comment}}".
 *
 * @property integer $id
 * @property integer $post_id
 * @property string $title
 * @property string $content
 * @property string $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property BlogPost $post
 */
class BlogComment extends \yii\db\ActiveRecord
{
    
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_DELETED = 'deleted';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%blog_comment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'title', 'content', 'status'], 'required'],
            [['post_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 15],
            ['status', 'in', 'range' => [self::STATUS_PENDING, self::STATUS_APPROVED, self::STATUS_DELETED]],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlogPost::className(), 'targetAttribute' => ['post_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'post_id' => Yii::t('app', 'Post ID'),
            'title' => Yii::t('app', 'Title'),
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
        return $this->hasOne(BlogPost::className(), ['id' => 'post_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
    
    public function timeElapsedString($ptime){
        $etime = time() - $ptime;
        if ($etime < 1){
            return '0 seconds';
        }
        $a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
                    30 * 24 * 60 * 60       =>  'month',
                    24 * 60 * 60            =>  'day',
                    60 * 60                 =>  'hour',
                    60                      =>  'minute',
                    1                       =>  'second'
                    );

        foreach ($a as $secs => $str){
            $d = $etime / $secs;
            if ($d >= 1){
                $r = round($d);
                return $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';
            }
        }
    }
    /**
    * @inheritdoc
    * @return BlogCommentQuery the active query used by this AR class.
    */
    public static function find()
    {
        return new BlogCommentQuery(get_called_class());
    }
}
