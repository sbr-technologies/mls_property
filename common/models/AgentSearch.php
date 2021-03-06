<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Agent;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class AgentSearch extends Agent
{
    public $keyword;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'agency_id', 'profile_id', 'gender', 'phone_verified', 'email_verified', 'email_activation_sent', 'total_reviews', 'membership_id', 'is_login_blocked', 'failed_login_cnt', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['agentID', 'salutation', 'first_name', 'middle_name', 'last_name', 'username', 'short_name', 'location', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'mobile1', 'calling_code', 'dob', 'zip_code', 'tagline', 'profile_image_file_name', 'profile_image_extension', 'email_activation_key', 'otp', 'ip_address', 'street_address', 'street_number', 'town', 'country', 'social_id', 'social_type', 'slug', 'timezone', 'login_blocked_at', 'status'], 'safe'],
            [['lat', 'lng', 'avg_rating'], 'number'],
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

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'profile_id' => $this->profile_id,
            'agency_id' => $this->agency_id,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'gender' => $this->gender,
            'dob' => $this->dob,
            'phone_verified' => $this->phone_verified,
            'email_verified' => $this->email_verified,
            'email_activation_sent' => $this->email_activation_sent,
            'avg_rating' => $this->avg_rating,
            'total_reviews' => $this->total_reviews,
            'membership_id' => $this->membership_id,
            'is_login_blocked' => $this->is_login_blocked,
            'login_blocked_at' => $this->login_blocked_at,
            'failed_login_cnt' => $this->failed_login_cnt,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'agentID', $this->agentID])
            ->andFilterWhere(['like', 'salutation', $this->salutation])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'short_name', $this->short_name])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'mobile1', $this->mobile1])
            ->andFilterWhere(['like', 'calling_code', $this->calling_code])
            ->andFilterWhere(['like', 'zip_code', $this->zip_code])
            ->andFilterWhere(['like', 'tagline', $this->tagline])
            ->andFilterWhere(['like', 'profile_image_file_name', $this->profile_image_file_name])
            ->andFilterWhere(['like', 'profile_image_extension', $this->profile_image_extension])
            ->andFilterWhere(['like', 'email_activation_key', $this->email_activation_key])
            ->andFilterWhere(['like', 'otp', $this->otp])
            ->andFilterWhere(['like', 'ip_address', $this->ip_address])
            ->andFilterWhere(['like', 'street_address', $this->street_address])
            ->andFilterWhere(['like', 'street_number', $this->street_number])
            ->andFilterWhere(['like', 'town', $this->town])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'social_id', $this->social_id])
            ->andFilterWhere(['like', 'social_type', $this->social_type])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'timezone', $this->timezone])
            ->andFilterWhere(['like', 'status', $this->status]);

        $query->andFilterWhere(['or',
            ['like', 'first_name', $this->keyword],
            ['like', 'middle_name', $this->keyword],
            ['like', 'last_name', $this->keyword],
            ['like', 'CONCAT_WS("", first_name, last_name)', str_replace(' ', '', $this->keyword)],
            ['like', 'CONCAT_WS("", middle_name, first_name, last_name)', str_replace(' ', '', $this->keyword)],
            ['like', 'CONCAT_WS("", first_name, last_name)', str_replace(',', '', $this->keyword)],
            ['like', 'CONCAT_WS("", first_name, last_name)', str_replace(', ', '', $this->keyword)],
            ['like', 'CONCAT_WS("", middle_name, first_name, last_name)', str_replace(',', '', $this->keyword)],
            ['like', 'CONCAT_WS("", middle_name, first_name, last_name)', str_replace(', ', '', $this->keyword)]
        ]);
        //var_dump($query->createCommand()->rawSql);die();
        return $dataProvider;
    }
}
