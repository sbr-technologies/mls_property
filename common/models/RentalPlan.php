<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%rental_plan}}".
 *
 * @property integer $id
 * @property integer $rental_plan_id
 * @property integer $rental_id
 * @property string $name
 * @property integer $bed
 * @property integer $bath
 * @property string $size
 * @property integer $price
 * @property string $status
 *
 * @property Rental $rental
 * @property RentalPlanType $rentalPlan
 */
class RentalPlan extends \yii\db\ActiveRecord
{
    public $_destroy;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%rental_plan}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rental_plan_id', 'rental_id', 'name', 'bed', 'bath', 'size'], 'required'],
            [['rental_plan_id', 'rental_id', 'bed', 'bath', 'price'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['size'], 'string', 'max' => 150],
            [['status'], 'string', 'max' => 15],
            [['rental_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rental::className(), 'targetAttribute' => ['rental_id' => 'id']],
            [['rental_plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => RentalPlanType::className(), 'targetAttribute' => ['rental_plan_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'rental_plan_id' => Yii::t('app', 'Rental Plan ID'),
            'rental_id' => Yii::t('app', 'Rental ID'),
            'name' => Yii::t('app', 'Name'),
            'bed' => Yii::t('app', 'Bed'),
            'bath' => Yii::t('app', 'Bath'),
            'size' => Yii::t('app', 'Size'),
            'price' => Yii::t('app', 'Price'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRental()
    {
        return $this->hasOne(Rental::className(), ['id' => 'rental_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRentalPlan()
    {
        return $this->hasOne(RentalPlanType::className(), ['id' => 'rental_plan_id']);
    }

    /**
     * @inheritdoc
     * @return RentalPlanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RentalPlanQuery(get_called_class());
    }
}
