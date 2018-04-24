<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%profile}}".
 *
 * @property integer $id
 * @property string $type
 * @property string $title
 * @property integer $no_of_member
 *
 * @property User[] $users
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%profile}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'title'], 'required'],
            [['no_of_member'], 'integer'],
            [['type', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'title' => Yii::t('app', 'User Type'),
            'no_of_member' => Yii::t('app', 'No Of Member'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['profile_id' => 'id']);
    }
}
