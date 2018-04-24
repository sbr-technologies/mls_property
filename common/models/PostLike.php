<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%post_like}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $model_id
 * @property string $model
 * @property integer $like_count
 * @property string $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class PostLike extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post_like}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'model_id', 'model', 'status', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'model_id', 'like_count', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['model'], 'string', 'max' => 75],
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
            'model_id' => Yii::t('app', 'Model ID'),
            'model' => Yii::t('app', 'Model'),
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return PostLikeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PostLikeQuery(get_called_class());
    }
}
