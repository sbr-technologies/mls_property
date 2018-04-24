<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%service_category}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $status
 *
 * @property PlanMaster[] $planMasters
 */
class ServiceCategory extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%service_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'status'], 'required'],
            [['description'], 'string'],
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
            'description' => Yii::t('app', 'Description'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanMasters()
    {
        return $this->hasMany(PlanMaster::className(), ['service_category_id' => 'id']);
    }
    
    /**
     * @inheritdoc
     * @return ServiceCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ServiceCategoryQuery(get_called_class());
    }
}
