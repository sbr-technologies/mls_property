<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%payment_type_master}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $code
 * @property string $status
 *
 * @property User[] $users
 */
class PaymentTypeMaster extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%payment_type_master}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'status'], 'required'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['code', 'status'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'code' => Yii::t('app', 'Code'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['payment_type_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return PaymentTypeMasterQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PaymentTypeMasterQuery(get_called_class());
    }
}
