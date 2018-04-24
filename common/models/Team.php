<?php

namespace common\models;

use Yii;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%team}}".
 *
 * @property integer $id
 * @property integer $name
 * @property string $teamID
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $status
 *
 * @property User[] $users
 */
class Team extends \yii\db\ActiveRecord
{
    
    public $team_type;
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_PENDING = 'pending';

    const SORT_NAME = 'name';
    const SORT_OFFICE_NAME = 'office_name';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%team}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'agency_id'], 'required'],
            ['name', 'unique', 'targetAttribute' => ['name', 'agency_id'], 'message' => 'Team name already exists'],
            ['teamID', 'unique'],
            ['status', 'default', 'value' => 'active'],
            [['created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['name', 'teamID', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'agency_id' => Yii::t('app', 'Agency'),
            'name' => Yii::t('app', 'Team Name'),
            'teamID' => Yii::t('app', 'Team ID'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
    
    public function behaviors() {
        parent::behaviors();
        return [TimestampBehavior::className(), BlameableBehavior::className()];
    }
    
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        if($insert){
            $end = $this->id;
            $start = 'T';
            $characters = range('0','9');
            for ($i = 0; $i < 7 - strlen((string)$end); $i++) {
                    $rand = mt_rand(0, count($characters)-1);
                    $start .= $characters[$rand];
            }
            $this->teamID = $start.$end;
            $this->save();
			$agencyModel = Agency::findOne($this->agency_id);
			$agencyModel->updateCounters(['total_teams' => 1]);
        }
    }
	
	public function afterDelete() {
        parent::afterDelete();
        $agencyModel = Agency::findOne($this->agency_id);
		$agencyModel->updateCounters(['total_teams' => -1]);
        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['team_id' => 'id']);
    }
    
    public function getCreatedBy(){
        return $this->hasOne(User::className(), ['id' => 'created_by'])->one()->fullName;
    }
    
    public function getAgency(){
        return $this->hasOne(Agency::className(), ['id' => 'agency_id']);
    }

    /**
     * @inheritdoc
     * @return TeamQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TeamQuery(get_called_class());
    }
}
