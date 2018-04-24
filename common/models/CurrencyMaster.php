<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%currency_master}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $symbol
 * @property string $ex_ngn
 * @property string $status
 */
class CurrencyMaster extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%currency_master}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'code', 'ex_ngn', 'ex_usd', 'ex_cny', 'ex_eur', 'ex_gbp', 'ex_zar', 'status'], 'required'],
            [['ex_ngn', 'ex_cny', 'ex_usd', 'ex_eur', 'ex_gbp', 'ex_zar'], 'number'],
            [['name'], 'string', 'max' => 100],
            [['code'], 'string', 'max' => 3],
            [['symbol'], 'string', 'max' => 2],
            [['status'], 'string', 'max' => 15],
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
            'symbol' => Yii::t('app', 'Symbol'),
            'ex_ngn' => Yii::t('app', 'Ex Rate NGN'),
            'ex_usd' => Yii::t('app', 'Ex Rate USD'),
            'ex_cny' => Yii::t('app', 'Ex Rate CNY'),
            'ex_eur' => Yii::t('app', 'Ex Rate EUR'),
            'ex_gbp' => Yii::t('app', 'Ex Rate GBP'),
            'ex_zar' => Yii::t('app', 'Ex Rate ZAR'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
    
    public function convert($from, $to,  $amount = 1){
        $currency = static::find()->where(['code' => $from])->asArray()->one();
        $column = 'ex_'. strtolower($to);
        return $currency[$column]*$amount;
    }

    /**
     * @inheritdoc
     * @return CurrencyMasterQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CurrencyMasterQuery(get_called_class());
    }
}
