<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%electricity_type}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class ElectricityType extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE     = 'active';
    const STATUS_INACTIVE   = 'inactive';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%electricity_type}}';
    }
    
    public function behaviors() {
        parent::behaviors();
        return [TimestampBehavior::className()];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'status'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 100],
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
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    

    /**
     * @inheritdoc
     * @return ElectricityTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ElectricityTypeQuery(get_called_class());
    }
}
