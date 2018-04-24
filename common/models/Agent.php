<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\models;
use yii\helpers\StringHelper;

class Agent extends User
{
    public $team_type;
    
    const SORT_MOST_RECENT_ACTIVITY = 'most_recent_activity';
    const SORT_HIGHEST_RATINGS = 'highest_ratings';
    const SORT_MOST_RECOMMENDATIONS = 'most_recommendations';
    const SORT_MOST_FOR_SALE_LISTINGS = 'most_for_sale_listings';
    const SORT_FIRST_NAME = 'first_name';
    const SORT_LAST_NAME = 'last_name';
    
    public function init(){
        //$this->profile_id = self::PROFILE_AGENT; 
        parent::init();
    }
    public function rules() {
        $rules = [
//                [['payment_type_id', 'team_id'], 'integer'],
//                [['payment_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PaymentTypeMaster::className(), 'targetAttribute' => ['payment_type_id' => 'id']],
                [['services'], 'safe']
            ];
        return array_merge(parent::rules(), $rules);
    }
    public function getAgency(){
        return $this->hasOne(Agency::className(), ['id' => 'agency_id']);
    }

    public function getTeam(){
        return $this->hasOne(Team::className(), ['id' => 'team_id']);
    }
    
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgentSellerMappings()
    {
        return $this->hasMany(AgentSellerMapping::className(), ['agent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgentSellerMappings0()
    {
        return $this->hasMany(AgentSellerMapping::className(), ['seller_id' => 'id']);
    }
    
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSellers()
    {
        return $this->hasMany(Seller::className(), ['id' => 'seller_id'])->viaTable('{{%agent_seller_mapping}}', ['agent_id' => 'id']);
    }
    
//        public function getSubscribers()
//    {
//        return $this->hasMany(EmailSubscribers::className(), ['id' => 'subscriber_id'])->viaTable('{{%email_list_subscriber}}', ['list_id' => 'id']);
//    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgentServiceCategoryMappings()
    {
        return $this->hasMany(AgentServiceCategoryMapping::className(), ['agent_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     *
    public function getServiceCategories()
    {
        return $this->hasMany(ServiceCategory::className(), ['id' => 'service_category_id'])->viaTable('{{%agent_service_category_mapping}}', ['agent_id' => 'id']);
    }*/

    
    public static function find()
    {
        return new UserQuery(get_called_class(), ['profileId' => self::PROFILE_AGENT, 'altProfileId' => self::PROFILE_AGENCY, 'isBrokerAgent' => 1, 'tableName' => self::tableName()]);
    }

    public function beforeSave($insert)
    {
		if($insert){
			$this->profile_id = parent::PROFILE_AGENT;
		}
        return parent::beforeSave($insert);
    }
    
    public function getServices(){
        return \yii\helpers\ArrayHelper::getColumn($this->agentServiceCategoryMappings, 'service_category_id');
    }
    
    public function setServices($values){
        if($this->isNewRecord){
            return;
        }
        AgentServiceCategoryMapping::deleteAll(['agent_id' => $this->id]);
        if(empty($values)){
            return;
        }
        foreach ($values as $value){
            $serviceCategory = new AgentServiceCategoryMapping(); //instantiate new AgentServiceCategoryMapping model
            $serviceCategory->agent_id = $this->id;
            $serviceCategory->service_category_id = $value;
            $serviceCategory->save();
        }
    }
    
    public function getPaymentType(){
        return $this->hasOne(PaymentTypeMaster::className(), ['id' => 'payment_type_id']);
    }
    public function getAgentSocialMedias(){
        return $this->hasMany(SocialMediaLink::className(), ['model_id' => 'id'])->andOnCondition(['model' => StringHelper::basename($this->className())]);
    } 
    
    public static function findByID($agentID){
        return static::find()->where(['agentID' => $agentID])->one();
    }
    
}