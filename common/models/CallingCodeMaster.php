<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%calling_code_master}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $country_code
 */
class CallingCodeMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%calling_code_master}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'code'], 'required'],
            [['name'], 'string', 'max' => 128],
            [['code'], 'string', 'max' => 32],
            [['country_code'], 'string', 'max' => 10],
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
            'code' => Yii::t('app', 'Code'),
            'country_code' => Yii::t('app', 'Country Code'),
        ];
    }
}
