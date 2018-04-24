<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\HolidayPackageBooking;

/**
 * HolidayPackageBookingSearch represents the model behind the search form about `common\models\HolidayPackageBooking`.
 */
class HolidayPackageBookingSearch extends HolidayPackageBooking
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'holiday_package_id', 'user_id', 'departure_date', 'card_last_4_digit', 'no_of_adult', 'no_of_children', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['booking_generated_id', 'departure_location', 'payment_mode', 'status'], 'safe'],
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
        $query = HolidayPackageBooking::find();

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
            'holiday_package_id' => $this->holiday_package_id,
            'user_id' => $this->user_id,
            'departure_date' => $this->departure_date,
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
            ->andFilterWhere(['like', 'departure_location', $this->departure_location])
            ->andFilterWhere(['like', 'payment_mode', $this->payment_mode])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
