<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\HotelBooking;

/**
 * HotelBookingSearch represents the model behind the search form about `common\models\HotelBooking`.
 */
class HotelBookingSearch extends HotelBooking
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'hotel_id', 'user_id', 'check_in_date', 'check_out_date', 'card_last_4_digit', 'no_of_adult', 'no_of_children', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['booking_generated_id', 'room', 'payment_mode', 'status'], 'safe'],
            [['amount'], 'number'],
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
        $query = HotelBooking::find();

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
            'hotel_id' => $this->hotel_id,
            'user_id' => $this->user_id,
            'check_in_date' => $this->check_in_date,
            'check_out_date' => $this->check_out_date,
            'amount' => $this->amount,
            'card_last_4_digit' => $this->card_last_4_digit,
            'no_of_adult' => $this->no_of_adult,
            'no_of_children' => $this->no_of_children,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'booking_generated_id', $this->booking_generated_id])
            ->andFilterWhere(['like', 'room', $this->room])
            ->andFilterWhere(['like', 'payment_mode', $this->payment_mode])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
