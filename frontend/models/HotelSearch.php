<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Hotel;
use common\models\HotelFacility;

/**
 * HotelSearch represents the model behind the search form about `common\models\Hotel`.
 */
class HotelSearch extends Hotel
{
    public $ratingPlus;
    public $facilitiesIn;
    public $sortBy;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','user_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['name', 'tagline', 'description', 'country', 'state', 'town', 'street_address', 'street_number', 'zip_code', 'estd', 'status', 'ratingPlus', 'sortBy'], 'safe'],
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
        $query = Hotel::find();

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
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'tagline', $this->tagline])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'town', $this->town])
            ->andFilterWhere(['like', 'street_address', $this->street_address])
            ->andFilterWhere(['like', 'street_number', $this->street_number])
            ->andFilterWhere(['like', 'zip_code', $this->zip_code])
            ->andFilterWhere(['like', 'estd', $this->estd])
            ->andFilterWhere(['like', 'status', $this->status]);
        
        $query->andFilterWhere(['>=', 'avg_rating', $this->ratingPlus]);
//        print_r($this->facilitiesIn);die();
        if($this->facilitiesIn){
            $subQuery = HotelFacility::find()->select('hotel_id')->where(['title' => $this->facilitiesIn]);
            $query->andFilterWhere(['IN', 'id', $subQuery]);
        }
        
        if($this->sortBy == 'sort_ratings'){
            $query->orderBy(['avg_rating' => SORT_DESC]);
        }elseif($this->sortBy == 'sort_popularity'){
            $query->orderBy(['price' => SORT_ASC]);
        }elseif($this->sortBy == 'sort_recent_viewed'){
            $query->orderBy(['price' => SORT_DESC]);
        }elseif($this->sortBy == 'sort_relevant'){
            $query->orderBy(['created_at' => SORT_DESC]);
        }
                
//    \yii\helpers\VarDumper::dump($query->createCommand()->rawSql);die();
        return $dataProvider;
    }
}
