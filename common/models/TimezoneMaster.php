<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%timezone_master}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $label
 */
class TimezoneMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%timezone_master}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'label'], 'required'],
            [['label', 'name'], 'string', 'max' => 125],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'label' => Yii::t('app', 'Value'),
        ];
    }
}
