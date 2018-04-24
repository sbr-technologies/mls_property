<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\NewsletterEmailListSubscriber;

/**
 * NewsletterEmailListSubscriberSearch represents the model behind the search form about `common\models\NewsletterEmailListSubscriber`.
 */
class NewsletterEmailListSubscriberSearch extends NewsletterEmailListSubscriber
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'subscriber_id', 'list_id', 'created_at', 'updated_at'], 'integer'],
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
        $query = NewsletterEmailListSubscriber::find();

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
            'subscriber_id' => $this->subscriber_id,
            'list_id' => $this->list_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
