<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%fact_master}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property PropertyFactInfo[] $propertyFactInfos
 */
class FactMaster extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%fact_master}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'status'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
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
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyFactInfos()
    {
        return $this->hasMany(PropertyFactInfo::className(), ['fact_master_id' => 'id']);
    }
    
    /**
    * @inheritdoc
    * @return FactMasterQuery the active query used by this AR class.
    */
    public static function find()
    {
        return new FactMasterQuery(get_called_class());
    }
}
