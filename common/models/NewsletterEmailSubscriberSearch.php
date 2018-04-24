<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\NewsletterEmailSubscriber;

/**
 * NewsletterEmailSubscriberSearch represents the model behind the search form about `common\models\NewsletterEmailSubscriber`.
 */
class NewsletterEmailSubscriberSearch extends NewsletterEmailSubscriber
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'total_mail_sent', 'last_mail_sent_at', 'created_at', 'updated_at'], 'integer'],
            [['salutation', 'first_name', 'middle_name', 'last_name', 'email', 'status'], 'safe'],
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
        $query = NewsletterEmailSubscriber::find();

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
            'total_mail_sent' => $this->total_mail_sent,
            'last_mail_sent_at' => $this->last_mail_sent_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'salutation', $this->salutation])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
