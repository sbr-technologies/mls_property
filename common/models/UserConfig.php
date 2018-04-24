<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_config}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $type
 * @property string $key
 * @property string $value
 * @property string $tip
 * @property string $options
 * @property string $unit
 * @property string $default
 * @property string $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class UserConfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_config}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'title', 'type', 'key', 'value'], 'required'],
            [['user_id'], 'integer'],
            [['value', 'tip', 'default'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 10],
            [['key', 'options', 'unit'], 'string', 'max' => 128],
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
            'type' => Yii::t('app', 'Type'),
            'key' => Yii::t('app', 'Key'),
            'value' => Yii::t('app', 'Value'),
            'tip' => Yii::t('app', 'Tip'),
            'options' => Yii::t('app', 'Options'),
            'unit' => Yii::t('app', 'Unit'),
            'default' => Yii::t('app', 'Default'),
            'status' => Yii::t('app', 'Status'),
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
