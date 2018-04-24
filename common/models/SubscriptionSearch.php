<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Subscription;

/**
 * SubscriptionSearch represents the model behind the search form of `common\models\Subscription`.
 */
class SubscriptionSearch extends Subscription
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'agency_id', 'plan_id', 'service_category_id', 'transaction_id', 'subs_start', 'subs_end', 'duration', 'created_at', 'updated_at'], 'integer'],
            [['paid_amount'], 'number'],
            [['currency_code', 'status'], 'safe'],
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
        $query = Subscription::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
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
            'agency_id' => $this->agency_id,
            'plan_id' => $this->plan_id,
            'service_category_id' => $this->service_category_id,
            'transaction_id' => $this->transaction_id,
            'paid_amount' => $this->paid_amount,
            'subs_start' => $this->subs_start,
            'subs_end' => $this->subs_end,
            'duration' => $this->duration,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'currency_code', $this->currency_code]);

        return $dataProvider;
    }
}
