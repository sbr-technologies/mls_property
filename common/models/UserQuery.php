<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[User]].
 *
 * @see User
 */
class UserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    public function active(){
        return $this->andWhere(['status' => User::STATUS_ACTIVE]);
    }
    
    public $profileId;
    public $tableName;
	public $altProfileId;
	public $isBrokerAgent;

    public function prepare($builder)
    {
        if ($this->profileId !== null) {
            //$this->andWhere(["$this->tableName.profile_id" => $this->profileId]);
			$this->andFilterWhere(['or',
            ["$this->tableName.profile_id" => $this->profileId],
            ["$this->tableName.profile_id" => $this->altProfileId, "$this->tableName.broker_is_agent" => $this->isBrokerAgent]]);
        }
        return parent::prepare($builder);
    }
    
    
    
    /**
     * @inheritdoc
     * @return User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
