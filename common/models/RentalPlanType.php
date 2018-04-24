<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%rental_plan_type}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $status
 *
 * @property RentalPlan[] $rentalPlans
 */
class RentalPlanType extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = "active";
    const STATUS_INACTIVE = "inactive";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%rental_plan_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
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
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRentalPlans()
    {
        return $this->hasMany(RentalPlan::className(), ['rental_plan_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return RentalPlanTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RentalPlanTypeQuery(get_called_class());
    }
}
