<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Agency;

/**
 * AgencySearch represents the model behind the search form about `common\models\Agency`.
 */
class AgencySearch extends Agency
{
    public $searchstring;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['agencyID', 'name', 'tagline', 'owner_name', 'country', 'state', 'town', 'street_address', 'street_number','zip_code', 'estd', 'status'], 'safe'],
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
        $query = Agency::find();

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
            'lat' => $this->lat,
            'lng' => $this->lng,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status
        ]);

        $query->andFilterWhere(['like', 'agencyID', $this->agencyID])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'tagline', $this->tagline])
            ->andFilterWhere(['like', 'owner_name', $this->owner_name])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'town', $this->town])
            ->andFilterWhere(['like', 'street_address', $this->street_address])
            ->andFilterWhere(['like', 'street_number', $this->street_number])
            ->andFilterWhere(['like', 'zip_code', $this->zip_code])
            ->andFilterWhere(['like', 'estd', $this->estd]);
        
        $query->orFilterWhere(['like', 'name', $this->searchstring])
            ->orFilterWhere(['like', 'owner_name', $this->searchstring]);
        return $dataProvider;
    }
}
