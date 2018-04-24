<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%agent_service_category_mapping}}".
 *
 * @property integer $id
 * @property integer $agent_id
 * @property integer $service_category_id
 *
 * @property User $agent
 * @property ServiceCategory $serviceCategory
 */
class AgentServiceCategoryMapping extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%agent_service_category_mapping}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['agent_id', 'service_category_id'], 'required'],
            [['agent_id', 'service_category_id'], 'integer'],
            [['agent_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['agent_id' => 'id']],
            [['service_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ServiceCategory::className(), 'targetAttribute' => ['service_category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'agent_id' => Yii::t('app', 'Agent ID'),
            'service_category_id' => Yii::t('app', 'Service Category ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgent()
    {
        return $this->hasOne(User::className(), ['id' => 'agent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceCategory()
    {
        return $this->hasOne(ServiceCategory::className(), ['id' => 'service_category_id']);
    }

    /**
     * @inheritdoc
     * @return AgentServiceCategoryMappingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AgentServiceCategoryMappingQuery(get_called_class());
    }
}
