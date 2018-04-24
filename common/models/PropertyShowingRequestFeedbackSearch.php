<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PropertyShowingRequestFeedback;

/**
 * PropertyShowingRequestFeedbackSearch represents the model behind the search form about `common\models\PropertyShowingRequestFeedback`.
 */
class PropertyShowingRequestFeedbackSearch extends PropertyShowingRequestFeedback
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'showing_request_id', 'user_id', 'requested_to', 'model_id', 'created_at', 'updated_at'], 'integer'],
            [['reply', 'status'], 'safe'],
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
        $query = PropertyShowingRequestFeedback::find();

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
            'showing_request_id' => $this->showing_request_id,
            'user_id' => $this->user_id,
            'requested_to' => $this->requested_to,
            'model_id' => $this->model_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'reply', $this->reply])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
