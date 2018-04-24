<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AddressSuggestion;

/**
 * AddressSuggestionSearch represents the model behind the search form of `common\models\AddressSuggestion`.
 */
class AddressSuggestionSearch extends AddressSuggestion
{
    public $streetNumberName;
    public $streetNameSuite;
    public $streetNumberNameSuite;
    public $fields;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['street_name', 'street_number', 'suite_number', 'status'], 'safe'],
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
        $query = AddressSuggestion::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
        $query->andFilterWhere([
            'id' => $this->id,
        ]);
        
        if($this->streetNumberName) {
            $query->andFilterWhere(['or',
                ['like', 'CONCAT_WS("", street_number, street_name)', str_replace(',', '', $this->streetNumberName)],
                ['like', 'CONCAT_WS("", street_number, street_name)', str_replace(', ', '', $this->streetNumberName)],
            ]);
        } elseif ($this->streetNameSuite) {
            $query->andFilterWhere(['or',
                ['like', 'CONCAT_WS("", street_name, suite_number)', str_replace(',', '', $this->streetNameSuite)],
                ['like', 'CONCAT_WS("", street_name, suite_number)', str_replace(',', '', str_replace(', ', '', $this->streetNameSuite))],
            ]);
        } else if ($this->streetNumberNameSuite) {
            $query->andFilterWhere(['or',
                ['like', 'CONCAT_WS("", street_number, street_name, suite_number)', str_replace(',', '', $this->streetNumberNameSuite)],
                ['like', 'CONCAT_WS("", street_number, street_name, suite_number)', str_replace(',', '', str_replace(', ', '', $this->streetNumberNameSuite))],
            ]);
        }

        $query->andFilterWhere(['like', 'street_name', $this->street_name])
            ->andFilterWhere(['like', 'street_number', $this->street_number])
            ->andFilterWhere(['like', 'suite_number', $this->suite_number])
            ->andFilterWhere(['like', 'status', $this->status]);
//        echo $query->createCommand()->rawSql; die();
        return $dataProvider;
    }
}
