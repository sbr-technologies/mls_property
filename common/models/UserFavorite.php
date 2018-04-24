<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_favorite}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $model
 * @property integer $model_id
 *
 * @property User $user
 */
class UserFavorite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_favorite}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'model_id'], 'integer'],
            [['model'], 'string', 'max' => 100],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getProperty()
    {
        return $this->hasOne(Property::className(), ['id' => 'model_id']);
    }
    /**
     * @inheritdoc
     * @return UserFavoriteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserFavoriteQuery(get_called_class());
    }
}
