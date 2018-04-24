<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PropertyRequest;

/**
 * PropertyRequestSearch represents the model behind the search form about `common\models\PropertyRequest`.
 */
class PropertyRequestSearch extends PropertyRequest
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'property_type_id', 'no_of_bed_room', 'created_at', 'updated_at'], 'integer'],
            [['user_id', 'budget_from', 'property_category','budget_to', 'state', 'locality', 'comment', 'status'], 'safe'],
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
        $query = PropertyRequest::find();

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
            'user_id' => $this->user_id,
            'property_type_id' => $this->property_type_id,
            'no_of_bed_room' => $this->no_of_bed_room,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'budget_from', $this->budget_from])
            ->andFilterWhere(['like', 'property_category', $this->property_category])    
            ->andFilterWhere(['like', 'budget_to', $this->budget_to])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'locality', $this->locality])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
