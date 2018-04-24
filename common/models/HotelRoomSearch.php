<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\HotelRoom;

/**
 * HotelRoomSearch represents the model behind the search form about `common\models\HotelRoom`.
 */
class HotelRoomSearch extends HotelRoom
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'hotel_id', 'room_type_id', 'ac'], 'integer'],
            [['name', 'floor_name', 'inclusion', 'amenities', 'status'], 'safe'],
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
        $query = HotelRoom::find();

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
            'room_type_id' => $this->room_type_id,
            'ac' => $this->ac,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'floor_name', $this->floor_name])
            ->andFilterWhere(['like', 'inclusion', $this->inclusion])
            ->andFilterWhere(['like', 'amenities', $this->amenities])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
