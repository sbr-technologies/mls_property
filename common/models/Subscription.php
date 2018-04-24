<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\CurrencyMaster;
/**
 * This is the model class for table "{{%subscription}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $plan_id
 * @property integer $transaction_id
 * @property string $paid_amount
 * @property integer $subs_start
 * @property integer $subs_end
 * @property string $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property PlanMaster $plan
 * @property User $user
 */
class Subscription extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%subscription}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['plan_id', 'subs_start', 'subs_end', 'status'], 'required'],
            [['user_id', 'agency_id', 'plan_id', 'transaction_id', 'duration', 'subs_start', 'subs_end', 'created_at', 'updated_at'], 'integer'],
            [['paid_amount'], 'number'],
            [['status'], 'string', 'max' => 255],
            [['plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => PlanMaster::className(), 'targetAttribute' => ['plan_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['transaction_id'], 'exist', 'skipOnError' => true, 'targetClass' => Transaction::className(), 'targetAttribute' => ['transaction_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User'),
            'plan_id' => Yii::t('app', 'Subscription Plan'),
            'transaction_id' => Yii::t('app', 'Transaction Id'),
            'paid_amount' => Yii::t('app', 'Paid Amount'),
            'duration' => Yii::t('app', 'Duration'),
            'subs_start' => Yii::t('app', 'Subs Start'),
            'subs_end' => Yii::t('app', 'Subs End'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public function behaviors() {
        parent::behaviors();
        return [TimestampBehavior::className()];
    }

    public function afterFind() {
        parent::afterFind();
        if($this->currency_code && $this->currency_code == 'USD'){
            $currency = new CurrencyMaster();
            $rate = $currency->convert('USD', 'NGN');
            $this->paid_amount = $this->paid_amount*$rate;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlan()
    {
        return $this->hasOne(PlanMaster::className(), ['id' => 'plan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransaction()
    {
        return $this->hasOne(Transaction::className(), ['id' => 'transaction_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgency()
    {
        return $this->hasOne(Agency::className(), ['id' => 'agency_id']);
    }

    /**
     * @inheritdoc
     * @return SubscriptionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SubscriptionQuery(get_called_class());
    }
}
