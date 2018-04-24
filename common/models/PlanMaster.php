<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%plan_master}}".
 *
 * @property integer $id
 * @property integer $service_category_id
 * @property string $title
 * @property string $description
 * @property string $amount
 * @property string $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property ServiceCategory $serviceCategory
 * @property PlanPermission[] $planPermissions
 * @property Subscription[] $subscriptions
 */
class PlanMaster extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = "active";
    const STATUS_INACTIVE = "inactive";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%plan_master}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_category_id', 'title', 'amount', 'description'], 'required'],
            [['service_category_id', 'for_agency', 'number_of_standard_listing', 'number_of_premium_listing', 'created_at', 'updated_at', 'amount', 'amount_for_3_months', 'amount_for_6_months', 'amount_for_12_months'], 'integer'],
            [['description'], 'string'],
            ['status', 'default', 'value' => 'active'],
            ['for_agency', 'default', 'value' => 0],
            [['title', 'status'], 'string', 'max' => 255],
            [['service_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ServiceCategory::className(), 'targetAttribute' => ['service_category_id' => 'id']],
        ];
    }
    public function behaviors() {
        parent::behaviors();
        return [TimestampBehavior::className()];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'service_category_id' => Yii::t('app', 'Service Category'),
            'for_agency' => Yii::t('app', 'For Agency'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'amount' => Yii::t('app', 'Amount for 1 Month'),
            'amount_for_3_months' => Yii::t('app', 'Amount for 3 Months'),
            'amount_for_6_months' => Yii::t('app', 'Amount for 6 Months'),
            'amount_for_12_months' => Yii::t('app', 'Amount for 12 Months'),
            'status' => Yii::t('app', 'Status'),
            'number_of_standard_listing' => Yii::t('app', 'Number of Standard Listing'),
            'number_of_premium_listing' => Yii::t('app', 'Number of Premium Listing'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceCategory()
    {
        return $this->hasOne(ServiceCategory::className(), ['id' => 'service_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubscriptions()
    {
        return $this->hasMany(Subscription::className(), ['plan_id' => 'id']);
    }
    
    /**
    * @inheritdoc
    * @return PlanMasterQuery the active query used by this AR class.
    */
    public static function find()
    {
        return new PlanMasterQuery(get_called_class());
    }
    
}
