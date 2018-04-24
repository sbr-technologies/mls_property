<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%login_log}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $login_time
 * @property integer $logout_time
 * @property string $login_ip
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class LoginLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%login_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'login_time', 'logout_time', 'login_ip', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'login_time', 'logout_time', 'created_at', 'updated_at'], 'integer'],
            [['login_ip'], 'string', 'max' => 15],
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
            'login_time' => Yii::t('app', 'Login Time'),
            'logout_time' => Yii::t('app', 'Logout Time'),
            'login_ip' => Yii::t('app', 'Login Ip'),
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
}
