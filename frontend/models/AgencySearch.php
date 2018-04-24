<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Agency;

/**
 * AgencySearch represents the model behind the search form about `common\models\Agency`.
 */
class AgencySearch extends Agency
{
    public $keyword;
    public $sortBy;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'total_recommendations', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['agencyID', 'name', 'tagline', 'owner_name', 'country', 'area', 'state', 'state_long', 'town', 'street_address', 'street_number', 'zip_code', 'estd', 'status', 'email', 'calling_code', 'mobile1', 'mobile2', 'mobile3', 'mobile4', 'calling_code2', 'office1', 'office2', 'office3', 'calling_code3', 'fax1', 'fax2', 'fax3', 'fax4', 'calling_code4', 'office4', 'web_address', 'keyword'], 'safe'],
            [['lat', 'lng', 'avg_rating'], 'number'],
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
        $query = Agency::find()->active();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['name'=>SORT_ASC]]
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
            'status' => $this->status,
            'estd' => $this->estd
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
            ->andFilterWhere(['like', 'area', $this->area])
            ->andFilterWhere(['like', 'zip_code', $this->zip_code])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'calling_code', $this->calling_code])
            ->andFilterWhere(['like', 'mobile1', $this->mobile1])
            ->andFilterWhere(['like', 'mobile2', $this->mobile2])
            ->andFilterWhere(['like', 'mobile3', $this->mobile3])
            ->andFilterWhere(['like', 'mobile4', $this->mobile4])
            ->andFilterWhere(['like', 'calling_code2', $this->calling_code2])
            ->andFilterWhere(['like', 'office1', $this->office1])
            ->andFilterWhere(['like', 'office2', $this->office2])
            ->andFilterWhere(['like', 'office3', $this->office3])
            ->andFilterWhere(['like', 'calling_code3', $this->calling_code3])
            ->andFilterWhere(['like', 'fax1', $this->fax1])
            ->andFilterWhere(['like', 'fax2', $this->fax2])
            ->andFilterWhere(['like', 'fax3', $this->fax3])
            ->andFilterWhere(['like', 'fax4', $this->fax4])
            ->andFilterWhere(['like', 'calling_code4', $this->calling_code4])
            ->andFilterWhere(['like', 'office4', $this->office4])
            ->andFilterWhere(['like', 'web_address', $this->web_address]);

        $query->andFilterWhere(['OR', 
            ['like', 'name', $this->keyword],
            ['like', 'agencyID', $this->keyword]
        ]);
        
        $query->andFilterWhere(['>=', 'avg_rating', $this->avg_rating])
                ->andFilterWhere(['>=', 'total_recommendations', $this->total_recommendations]);
        
        if($this->sortBy == parent::SORT_NAME){
            $query->orderBy(['name' => SORT_ASC]);
        }elseif($this->sortBy == parent::SORT_HIGHEST_RATINGS){
            $query->orderBy(['avg_rating' => SORT_DESC]);
        }elseif($this->sortBy == parent::SORT_MOST_RECOMMENDATIONS){
            $query->orderBy(['total_recommendations' => SORT_DESC]);
        }
//        echo $query->createCommand()->rawSql;die();
        return $dataProvider;
    }
}
