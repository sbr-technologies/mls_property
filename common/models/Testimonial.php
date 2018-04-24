<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

use yii\helpers\StringHelper;
/**
 * This is the model class for table "{{%testimonial}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $model
 * @property integer $model_id
 * @property string $title
 * @property string $description
 * @property integer $rating
 * @property string $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class Testimonial extends \yii\db\ActiveRecord
{
    const STATUS_APPROVED = 'approved';
    const STATUS_BLOCKED = 'blocked';
    const STATUS_PENDING = 'pending';
    const STATUS_DELETED = 'deleted';
    
    const RATING_1 = 1;
    const RATING_2 = 2;
    const RATING_3 = 3;
    const RATING_4 = 4;
    const RATING_5 = 5;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%testimonial}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'rating', 'status'], 'required'],
            [['user_id', 'model_id', 'rating', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['model'], 'string', 'max' => 100],
            [['title'], 'string', 'max' => 128],
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
            'model' => Yii::t('app', 'Model'),
            'model_id' => Yii::t('app', 'Model ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'rating' => Yii::t('app', 'Rating'),
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    /**
     * @inheritdoc
     * @return TestimonialQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TestimonialQuery(get_called_class());
    }
    
}
