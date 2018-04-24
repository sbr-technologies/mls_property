<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Rental;

/**
 * RentalSearch represents the model behind the search form about `common\models\Rental`.
 */
class RentalSearch extends Rental
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'metric_type_id', 'lift', 'studio', 'pet_friendly', 'in_unit_laundry', 'pools', 'homes', 'furnished', 'price', 'property_type_id', 'property_category_id', 'construction_status_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['title', 'description', 'country', 'state', 'city', 'address1', 'address2', 'zip_code', 'land_mark', 'near_buy_location', 'size', 'electricity_type_ids','lot_area', 'no_of_room', 'no_of_balcony', 'no_of_bathroom', 'water_availability', 'currency', 'currency_symbol', 'property_video_link', 'watermark_image', 'status'], 'safe'],
            [['reference_id'], 'string'],
            [['lat', 'lng'], 'number'],
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
        $query = Rental::find();

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
            'lat' => $this->lat,
            'lng' => $this->lng,
            'metric_type_id' => $this->metric_type_id,
            'lift' => $this->lift,
            'studio' => $this->studio,
            'pet_friendly' => $this->pet_friendly,
            'in_unit_laundry' => $this->in_unit_laundry,
            'pools' => $this->pools,
            'homes' => $this->homes,
            'furnished' => $this->furnished,
//            'electricity_type_ids' => $this->electricity_type_ids,
            'price' => $this->price,
            'property_type_id' => $this->property_type_id,
            'property_category_id' => $this->property_category_id,
            'construction_status_id' => $this->construction_status_id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'reference_id', $this->reference_id])  
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'address1', $this->address1])
            ->andFilterWhere(['like', 'address2', $this->address2])
            ->andFilterWhere(['like', 'zip_code', $this->zip_code])
            ->andFilterWhere(['like', 'land_mark', $this->land_mark])
            ->andFilterWhere(['like', 'near_buy_location', $this->near_buy_location])
            ->andFilterWhere(['like', 'size', $this->size])
            ->andFilterWhere(['like', 'lot_area', $this->lot_area])
            ->andFilterWhere(['like', 'no_of_room', $this->no_of_room])
            ->andFilterWhere(['like', 'no_of_balcony', $this->no_of_balcony])
            ->andFilterWhere(['like', 'no_of_bathroom', $this->no_of_bathroom])
            ->andFilterWhere(['like', 'water_availability', $this->water_availability])
            ->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'currency_symbol', $this->currency_symbol])
            ->andFilterWhere(['like', 'property_video_link', $this->property_video_link])
            ->andFilterWhere(['like', 'watermark_image', $this->watermark_image])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
