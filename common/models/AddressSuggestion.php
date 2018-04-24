<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mls_address_suggestion".
 *
 * @property int $id
 * @property string $street_name
 * @property string $street_number
 * @property string $suite_number
 * @property string $status
 */
class AddressSuggestion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mls_address_suggestion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['street_name', 'street_number'], 'string', 'max' => 255],
            [['suite_number'], 'string', 'max' => 100],
            [['status'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'street_name' => Yii::t('app', 'Street Name'),
            'street_number' => Yii::t('app', 'Street Number'),
            'suite_number' => Yii::t('app', 'Suite Number'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @inheritdoc
     * @return AddressSuggestionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AddressSuggestionQuery(get_called_class());
    }
}
