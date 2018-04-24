<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\JobApplication;

/**
 * JobApplicationSearch represents the model behind the search form about `common\models\JobApplication`.
 */
class JobApplicationSearch extends JobApplication
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'gender', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['first_name', 'middle_name', 'last_name', 'email', 'calling_code', 'phone_number', 'dob', 'zip_code', 'ip_address', 'status'], 'safe'],
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
        $query = JobApplication::find();

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
            'gender' => $this->gender,
            'dob' => $this->dob,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'calling_code', $this->calling_code])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'zip_code', $this->zip_code])
            ->andFilterWhere(['like', 'ip_address', $this->ip_address])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
