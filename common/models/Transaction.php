<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%transaction}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $gateway
 * @property string $transactionid
 * @property string $amt
 * @property string $currencycode
 * @property string $receiveremail
 * @property string $receiverid
 * @property string $payerid
 * @property string $payerstatus
 * @property string $timestamp
 * @property string $correlationid
 * @property string $receiptid
 * @property string $paymenttype
 * @property string $paymentstatus
 * @property string $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class Transaction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%transaction}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'gateway', 'status'], 'required'],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['amt'], 'number'],
            [['currencycode'], 'string'],
            [['gateway', 'transactionid'], 'string', 'max' => 50],
            [['receiveremail', 'receiverid', 'payerid', 'payerstatus', 'timestamp', 'correlationid', 'receiptid', 'paymenttype', 'paymentstatus'], 'string', 'max' => 125],
            [['status'], 'string', 'max' => 255],
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
            'gateway' => Yii::t('app', 'Gateway'),
            'transactionid' => Yii::t('app', 'Transaction ID'),
            'amt' => Yii::t('app', 'Paid Amount'),
            'currencycode' => Yii::t('app', 'Currency Code'),
            'receiveremail' => Yii::t('app', 'Receiveremail'),
            'receiverid' => Yii::t('app', 'Receiverid'),
            'payerid' => Yii::t('app', 'Payerid'),
            'payerstatus' => Yii::t('app', 'Payerstatus'),
            'timestamp' => Yii::t('app', 'Timestamp'),
            'correlationid' => Yii::t('app', 'Correlationid'),
            'receiptid' => Yii::t('app', 'Receiptid'),
            'paymenttype' => Yii::t('app', 'Paymenttype'),
            'paymentstatus' => Yii::t('app', 'Paymentstatus'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public function behaviors() {
        parent::behaviors();
        return [TimestampBehavior::className()];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return TransactionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TransactionQuery(get_called_class());
    }
}
