<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\User;

/**
 * This is the model class for table "{{%recommend}}".
 *
 * @property integer $id
 * @property integer $model_id
 * @property integer $recommend_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class Recommend extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%recommend}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model', 'model_id', 'recommend_id'], 'required'],
            [['model_id', 'recommend_id', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    public function behaviors() {
        parent::behaviors();
        return [TimestampBehavior::className()];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'model_id' => Yii::t('app', 'User ID'),
            'recommend_id' => Yii::t('app', 'Recommend ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        if($this->model == 'User'){
            $model = User::findOne($this->model_id);
            $model->updateCounters(['total_recommendations' => 1]);
        }elseif($this->model == 'Agency'){
            $model = Agency::findOne($this->model_id);
            $model->updateCounters(['total_recommendations' => 1]);
        }
    }
    
    public function afterDelete() {
        parent::afterDelete();
        if($this->model == 'User'){
            $model = User::findOne($this->model_id);
            $model->updateCounters(['total_recommendations' => -1]);
        }elseif($this->model == 'Agency'){
            $model = Agency::findOne($this->model_id);
            $model->updateCounters(['total_recommendations' => -1]);
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'model_id'])->andOnCondition(['model' => 'User']);
    }

    /**
     * @inheritdoc
     * @return RecommendQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RecommendQuery(get_called_class());
    }
}
