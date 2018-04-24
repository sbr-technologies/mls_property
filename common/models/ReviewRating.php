<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%review_rating}}".
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
class ReviewRating extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%review_rating}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'model', 'model_id','title', 'description', 'rating', 'status'], 'required'],
            [['user_id', 'model_id', 'rating', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['model'], 'string', 'max' => 100],
            [['title'], 'string', 'max' => 128],
            [['status'], 'string', 'max' => 15],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }
    public function behaviors() {
        parent::behaviors();
        return [TimestampBehavior::className(), BlameableBehavior::className()];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'Review and Rating is given by this user'),
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

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        if($this->model == 'User'){
            $avg = static::find()->where(['model' => 'User', 'model_id' => $this->model_id])->active()->average('rating');
            $model = User::findOne($this->model_id);
            $model->total_reviews = $model->total_reviews + 1;
            $model->avg_rating = $avg;
            $model->save();
        }elseif($this->model == 'Agency'){
            $avg = static::find()->where(['model' => 'Agency', 'model_id' => $this->model_id])->active()->average('rating');
            $model = Agency::findOne($this->model_id);
            $model->total_reviews = $model->total_reviews + 1;
            $model->avg_rating = $avg;
            $model->save();
        }
    }
    
    public function afterDelete() {
        parent::afterDelete();
            if($this->model == 'User'){
            $avg = static::find()->where(['model' => 'User', 'model_id' => $this->model_id])->active()->average('rating');
            $model = User::findOne($this->model_id);
            $model->total_reviews = $model->total_reviews - 1;
            $model->avg_rating = $avg;
            $model->save();
        }elseif($this->model == 'Agency'){
            $avg = static::find()->where(['model' => 'Agency', 'model_id' => $this->model_id])->active()->average('rating');
            $model = Agency::findOne($this->model_id);
            $model->total_reviews = $model->total_reviews - 1;
            $model->avg_rating = $avg;
            $model->save();
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function getModelUser()
    {
        return $this->hasOne(User::className(), ['id' => 'model_id']);
    }
    
    public function getModelAgency()
    {
        return $this->hasOne(Agency::className(), ['id' => 'model_id']);
    }
    /**
     * @inheritdoc
     * @return ReviewRatingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReviewRatingQuery(get_called_class());
    }
}
