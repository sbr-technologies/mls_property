<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Agent;
use common\models\Property;
use yii\db\Expression;
use common\models\Team;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class AgentSearch extends Agent
{
    public $type;
    public $keyword;
    public $phone;
    public $searchstring;
    public $name;
    
    public $officeName;
    public $officeID;
    public $officeState;
    public $officeTown;
    public $officeArea;
    public $officeZipCode;
    public $propTypeIn;
    public $officePhone1;
    public $officeEmail;
    public $sortBy;
    
    
    public $teamName;
    public $teamID;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','agency_id', 'profile_id', 'gender', 'phone_verified', 'total_reviews', 'membership_id', 'is_login_blocked', 'failed_login_cnt', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['salutation', 'first_name', 'middle_name', 'last_name', 'username', 'short_name', 'location', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'mobile1', 'calling_code', 'dob', 'zip_code', 'tagline', 'profile_image_file_name', 'profile_image_extension', 'email_activation_key', 'otp', 'ip_address', 'street_number', 'area' ,'street_address', 'town', 'country', 'social_id', 'social_type', 'slug', 'name', 'agentID', 'officeName', 'officeID', 'status', 'ratingPlus', 'recommendationPlus', 'sortBy'], 'safe'],
            [['lat', 'lng', 'avg_rating', 'max_price', 'min_price'], 'number'],
            [['slug', 'worked_with'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Agent::find();
        $query->joinWith(['agency' => function($q) {
            $q->from(Yii::$app->db->tablePrefix . 'agency a');
        }]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['first_name'=>SORT_ASC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
             $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'profile_id' => $this->profile_id,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'gender' => $this->gender,
            'dob' => $this->dob,
        ]);

        $query->andFilterWhere(['like', 'salutation', $this->salutation])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'agentID', $this->agentID])
            ->andFilterWhere(['like', 'short_name', $this->short_name])
            ->andFilterWhere(['like', Yii::$app->db->tablePrefix. 'user.email', $this->email])
            ->andFilterWhere(['like', 'mobile1', $this->mobile1])
            ->andFilterWhere(['like', Yii::$app->db->tablePrefix. 'user.state', $this->state])
            ->andFilterWhere(['like', Yii::$app->db->tablePrefix. 'user.town', $this->town])
            ->andFilterWhere(['like', Yii::$app->db->tablePrefix. 'user.area', $this->area])
            ->andFilterWhere(['like', Yii::$app->db->tablePrefix. 'user.zip_code', $this->zip_code])
            ->andFilterWhere(['like', 'tagline', $this->tagline])
            ->andFilterWhere(['like', 'street_number', $this->street_number])
            ->andFilterWhere(['like', 'street_address', $this->street_address])
            ->andFilterWhere(['like', 'a.name', $this->officeName])
            ->andFilterWhere(['like', 'a.agencyID', $this->officeID])
            ->andFilterWhere(['like', 'a.state', $this->officeState])
            ->andFilterWhere(['like', 'a.town', $this->officeTown])
            ->andFilterWhere(['like', 'a.area', $this->officeArea])
            ->andFilterWhere(['like', 'a.office1', $this->officePhone1])
            ->andFilterWhere(['like', 'a.email', $this->officeEmail])
            ->andFilterWhere(['like', 'a.zip_code', $this->officeZipCode])
                
            ->andFilterWhere(['like', 'social_id', $this->social_id])
            ->andFilterWhere(['like', 'social_type', $this->social_type])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'timezone', $this->timezone])
            ->andFilterWhere(['like', Yii::$app->db->tablePrefix. 'user.status', $this->status]);

        $query->andFilterWhere(['or',
            ['like', "CONCAT_WS('', first_name, last_name)", str_replace(' ', '', $this->name)],
            ['like', "CONCAT_WS('', first_name, middle_name, last_name)", str_replace(' ', '', $this->name)],
            ['like', "CONCAT_WS('', first_name, last_name)", str_replace(' ', '', $this->name)],
        ]);
        
//        $query->andFilterWhere(['or',
//            ['like', 'salutation', $this->salutation],
//            ['like', 'first_name', $this->first_name],
//            ['like', 'middle_name', $this->middle_name],
//            ['like', 'last_name', $this->last_name],
//            ['like', 'mobile1', $this->mobile1],            
//            ['like', 'a.agencyID', $this->officeID],
//            ['like', 'a.name', $this->officeName],
////            ['like', 'a.owner_name', $this->searchstring],
//            ['like', 'a.zip_code', $this->officeZipCode],
//            ['like', 'a.state', $this->officeState],
//            ['like', 'a.town', $this->officeCity],
//            ['like', 'a.street_address', $this->searchstring],
//            ['like', 'a.street_number', $this->searchstring],
//            
//        ]);
        
        $query->andFilterWhere(['or',
            ['like', Yii::$app->db->tablePrefix. 'user.state', $this->state],
           // ['like', Yii::$app->db->tablePrefix. 'user.state_long', $this->state]
        ]);
        
        
//        $query->andWhere('min_price < :maxPrice and max_price > :minPrice', [':maxPrice' => $this->max_price, ':minPrice' => $this->min_price]);
        if($this->worked_with == 1){
            $query->andWhere(new Expression('FIND_IN_SET(:workedWith, worked_with)'))->addParams([':workedWith' => 'buyer']);
            $query->andWhere(new Expression('FIND_IN_SET(:workedWith, worked_with)'))->addParams([':workedWith' => 'seller']);
        }elseif($this->worked_with == 2){
            $query->andWhere(new Expression('FIND_IN_SET(:workedWith, worked_with)'))->addParams([':workedWith' => 'buyer']);
        }elseif($this->worked_with == 3){
            $query->andWhere(new Expression('FIND_IN_SET(:workedWith, worked_with)'))->addParams([':workedWith' => 'seller']);
        }
        
        $query->andFilterWhere(['<=', 'min_price', $this->max_price])
                ->andFilterWhere(['>=', 'max_price', $this->min_price]);
        
        $query->andFilterWhere(['>=', parent::tableName(). '.avg_rating', $this->avg_rating])
                ->andFilterWhere(['>=', parent::tableName(). '.total_recommendations', $this->total_recommendations]);
        
        if($this->propTypeIn){
            $subQuery = Property::find()->select('user_id')->where(['property_type_id' => $this->propTypeIn])->active();
            $query->andFilterWhere(['IN', Yii::$app->db->tablePrefix. 'user.id', $subQuery]);
        }
        
        if($this->teamName || $this->teamID){
            $cond = [];
            if($this->teamName){
                $cond = ['name' => $this->teamName];
            }
            if($this->teamID){
                $cond = array_merge($cond, ['teamID' => $this->teamID]);
            }
            $subQuery = Team::find()->select('id')->where($cond)->active();
            $query->andFilterWhere(['IN', Yii::$app->db->tablePrefix. 'user.team_id', $subQuery]);
        }
        
        if($this->sortBy == parent::SORT_MOST_RECENT_ACTIVITY){
            $query->orderBy(['last_activity_at' => SORT_DESC]);
        }elseif($this->sortBy == parent::SORT_HIGHEST_RATINGS){
            $query->orderBy(['avg_rating' => SORT_DESC]);
        }elseif($this->sortBy == parent::SORT_MOST_RECOMMENDATIONS){
            $query->orderBy(['total_recommendations' => SORT_DESC]);
        }elseif($this->sortBy == parent::SORT_MOST_FOR_SALE_LISTINGS){
            $query->orderBy(['total_listings' => SORT_DESC]);
        }elseif($this->sortBy == parent::SORT_FIRST_NAME){
            $query->orderBy(['first_name' => SORT_ASC]);
        }elseif($this->sortBy == parent::SORT_LAST_NAME){
            $query->orderBy(['last_name' => SORT_ASC]);
        }
        
//     echo $query->createCommand()->rawSql; die();
        return $dataProvider;
    }
}
