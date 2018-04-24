<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LocationSuggestion;

/**
 * LocationSuggestionSearch represents the model behind the search form about `common\models\LocationSuggestion`.
 */
class LocationSuggestionSearch extends LocationSuggestion
{
    public $keyword;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'zip_code'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['city', 'state', 'street', 'area', 'district', 'local_government_area', 'keyword'], 'safe'],
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
        $query = LocationSuggestion::find();
        $query->orderBy(['id' => SORT_DESC]);
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
            'zip_code' => $this->zip_code,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ]);

//        $query->andFilterWhere(['like', 'city', $this->city])
//            ->andFilterWhere(['like', 'state', $this->state]);
        $keyWord        =   $this->keyword;
        if (strpos($keyWord, ',') !== false){
            $keyWord     =   explode(", ", $keyWord);
            if(count($keyWord) == 2){
                $query->andFilterWhere(['or',
                    ['like', 'CONCAT_WS("", city, state)', str_replace(' ', '', $this->keyword)],
                    ['like', 'CONCAT_WS("", city, state)', str_replace(',', '', $this->keyword)],
                    ['like', 'CONCAT_WS("", city, state)', str_replace(', ', '', $this->keyword)],
                ]);
            }else if(count($keyWord) == 3){
                $query->andFilterWhere(['or',
                    ['like', 'CONCAT_WS("", area, city, state)', str_replace(' ', '', $this->keyword)],
                    ['like', 'CONCAT_WS("", area, city, state)', str_replace(',', '', $this->keyword)],
                    ['like', 'CONCAT_WS("", area, city, state)', str_replace(', ', '', $this->keyword)],
                ]);
            }
        }else{
            $query->andFilterWhere(['or',
                ['like', 'city', $this->keyword],
                ['like', 'state', $this->keyword],
                //['like', 'street', $this->keyword],
                ['like', 'area', $this->keyword],
               // ['like', 'district', $this->keyword],
               // ['like', 'local_government_area', $this->keyword],
            ]);
        }
        
        
            
            //['like', 'CONCAT_WS("", city, state)', str_replace(' ', '', $this->keyword)],
            //['like', 'CONCAT_WS("", zip_code, city, state)', str_replace(' ', '', $this->keyword)],
//            ['like', 'CONCAT_WS("", city, state)', str_replace(',', '', $this->keyword)],
//            ['like', 'CONCAT_WS("", city, state)', str_replace(', ', '', $this->keyword)],
//            ['like', 'CONCAT_WS("", zip_code, city, state)', str_replace(',', '', $this->keyword)],
//            ['like', 'CONCAT_WS("", zip_code, city, state)', str_replace(', ', '', $this->keyword)]
        
       // echo $query->createCommand()->rawSql;die();
        return $dataProvider;
    }
}
