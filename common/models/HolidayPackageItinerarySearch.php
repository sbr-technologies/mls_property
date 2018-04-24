<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\HolidayPackageItinerary;

/**
 * HolidayPackageItinerarySearch represents the model behind the search form about `common\models\HolidayPackageItinerary`.
 */
class HolidayPackageItinerarySearch extends HolidayPackageItinerary
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'holiday_package_id'], 'integer'],
            [['days_name', 'title', 'description', 'address', 'city', 'state', 'country'], 'safe'],
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
        $query = HolidayPackageItinerary::find();

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
            'holiday_package_id' => $this->holiday_package_id,
        ]);

        $query->andFilterWhere(['like', 'days_name', $this->days_name])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'country', $this->country]);

        return $dataProvider;
    }
}
