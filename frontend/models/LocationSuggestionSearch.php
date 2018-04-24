<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LocationSuggestion;

/**
 * LocationSuggestionSearch represents the model behind the search form about `common\models\LocationSuggestion`.
 */
class LocationSuggestionSearch extends LocationSuggestion
{
    public $cityState;
    public $areaCityState;
    public $areaCity;
    public $fields;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['area', 'city', 'state', 'cityState', 'areaCityState', 'areaCity', 'fields'], 'safe'],
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
//            'sort'=> ['defaultOrder' => ['topic_order'=>SORT_ASC]]
//            'pagination' => false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }
        
        if($this->fields){
            $query->select($this->fields)->distinct()->orderBy([$this->fields[0] => SORT_ASC]);
        }

        // grid filtering conditions
//        $query->andFilterWhere([
//            'id' => $this->id,
//            'zip_code' => $this->zip_code,
//            'latitude' => $this->latitude,
//            'longitude' => $this->longitude,
//        ]);

        if($this->cityState){
            $query->andFilterWhere(['or',
                ['like', 'CONCAT_WS("", city, state)', str_replace(',', '', $this->cityState)],
                ['like', 'CONCAT_WS("", city, state)', str_replace(', ', '', $this->cityState)],
            ]);
        }elseif($this->areaCity){
            $query->andFilterWhere(['or',
                ['like', 'CONCAT_WS("", area, city)', str_replace(',', '', $this->areaCity)],
                ['like', 'CONCAT_WS("", area, city)', str_replace(', ', '', $this->areaCity)],
            ]);
        }else if($this->areaCityState){
            $query->andFilterWhere(['or',
                ['like', 'CONCAT_WS("", area, city, state)', str_replace(',', '', $this->areaCityState)],
                ['like', 'CONCAT_WS("", area, city, state)', str_replace(', ', '', $this->areaCityState)],
            ]);
        }

        $query->andFilterWhere(['or',
            ['like', 'city', $this->city],
            ['like', 'state', $this->state],
            ['like', 'area', $this->area],
        ]);
        
//        echo $query->createCommand()->rawSql;die();
        return $dataProvider;
    }
}
