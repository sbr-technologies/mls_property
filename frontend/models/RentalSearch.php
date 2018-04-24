<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Rental;

/**
 * PropertySearch represents the model behind the search form about `common\models\Property`.
 */
class RentalSearch extends Rental
{
    public $minPrice;
    public $maxPrice;
    public $bedroomPlus;
    public $bathroomPlus;
    public $typeIn;
    public $sortBy;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'metric_type_id', 'no_of_room', 'no_of_balcony', 'no_of_bathroom', 'lift', 'furnished', 'property_type_id', 'property_category_id', 'construction_status_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['title', 'description', 'country', 'state', 'city', 'street_address', 'street_number', 'zip_code', 'near_buy_location', 'water_availability', 'currency', 'currency_symbol','property_video_link', 'minPrice', 'maxPrice', 'bedroomPlus', 'bathroomPlus', 'typeIn', 'sortBy', 'status'], 'safe'],
            [['lat', 'lng', 'size', 'price'], 'number'],
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
//            'sort' => [
//                'defaultOrder' => [
//                    'created_at' => SORT_DESC,
//                ],
//                'attributes' => ['title','price','created_at']
//            ],

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
            'size' => $this->size,
            'no_of_room' => $this->no_of_room,
            'no_of_balcony' => $this->no_of_balcony,
            'no_of_bathroom' => $this->no_of_bathroom,
            'lift' => $this->lift,
            'furnished' => $this->furnished,
            'price' => $this->price,
            'property_type_id' => $this->property_type_id,
            'property_category_id' => $this->property_category_id,
            'construction_status_id' => $this->construction_status_id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);
//'street_address', 'street_number',
        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'zip_code', $this->zip_code])
            ->andFilterWhere(['like', 'street_address', $this->street_address])
            ->andFilterWhere(['like', 'street_number', $this->street_number])
            ->andFilterWhere(['like', 'near_buy_location', $this->near_buy_location])
            ->andFilterWhere(['like', 'water_availability', $this->water_availability])
            ->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'currency_symbol', $this->currency_symbol])
            ->andFilterWhere(['like', 'property_video_link', $this->property_video_link]);

        $query->andFilterWhere(['>=', 'price', $this->minPrice])
                ->andFilterWhere(['<=', 'price', $this->maxPrice])
                ->andFilterWhere(['>=', 'no_of_room', $this->bedroomPlus])
                ->andFilterWhere(['>=', 'no_of_bathroom', $this->bathroomPlus])
                ->andFilterWhere(['IN', 'property_type_id', $this->typeIn]);
        if($this->sortBy == 'newest'){
            $query->orderBy(['created_at' => SORT_DESC]);
        }elseif($this->sortBy == 'lowest_price'){
            $query->orderBy(['price' => SORT_ASC]);
        }elseif($this->sortBy == 'highest_price'){
            $query->orderBy(['price' => SORT_DESC]);
        }elseif($this->sortBy == 'largest_area'){
            $query->orderBy(['size' => SORT_DESC]);
        }
        
//        echo $query->createCommand()->rawSql; die();
        
        return $dataProvider;
    }
}
