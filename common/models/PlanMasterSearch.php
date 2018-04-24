<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PlanMaster;

/**
 * PlanMasterSearch represents the model behind the search form about `common\models\PlanMaster`.
 */
class PlanMasterSearch extends PlanMaster
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'amount', 'service_category_id', 'for_agency', 'created_at', 'updated_at'], 'integer'],
            [['title', 'description', 'status'], 'safe'],
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
        $query = PlanMaster::find();

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
            'service_category_id' => $this->service_category_id,
            'amount' => $this->amount,
            'for_agency' => $this->for_agency,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
