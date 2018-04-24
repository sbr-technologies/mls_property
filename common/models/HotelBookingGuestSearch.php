<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\HotelBookingGuest;

/**
 * HotelBookingGuestSearch represents the model behind the search form about `common\models\HotelBookingGuest`.
 */
class HotelBookingGuestSearch extends HotelBookingGuest
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'gender', 'age'], 'integer'],
            [['booking_id', 'first_name', 'last_name', 'middle_name'], 'safe'],
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
        $query = HotelBookingGuest::find();

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
            'age' => $this->age,
        ]);

        $query->andFilterWhere(['like', 'booking_id', $this->booking_id])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name]);

        return $dataProvider;
    }
}
