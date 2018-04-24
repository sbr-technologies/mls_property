<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\HolidayPackage;

/**
 * HolidayPackageSearch represents the model behind the search form about `common\models\HolidayPackage`.
 */
class HolidayPackageSearch extends HolidayPackage
{
    public $keyword;
    public $desc_city;
    public $checkin;
    public $checkout;
    public $no_of_days;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'no_of_days', 'no_of_nights', 'departure_date', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['name', 'description', 'hotel_transport_info', 'inclusion', 'exclusions', 'payment_policy', 'cancellation_policy', 'status'], 'safe'],
            [['package_amount'], 'number'],
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
        $query = HolidayPackage::find();

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
            'category_id' => $this->category_id,
            'package_amount' => $this->package_amount,
            //'no_of_days' => $this->no_of_days,
            'no_of_nights' => $this->no_of_nights,
            'departure_date' => $this->departure_date,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'hotel_transport_info', $this->hotel_transport_info])
            ->andFilterWhere(['like', 'inclusion', $this->inclusion])
            ->andFilterWhere(['like', 'exclusions', $this->exclusions])
            ->andFilterWhere(['like', 'payment_policy', $this->payment_policy])
            ->andFilterWhere(['like', 'cancellation_policy', $this->cancellation_policy])
            ->andFilterWhere(['like', 'status', $this->status]);

        $query->andFilterWhere(['like', 'source_city', $this->keyword])
            ->andFilterWhere(['like', 'destination_city', $this->desc_city])
            ->andFilterWhere(['>=', 'departure_date', $this->checkin])
            ->andFilterWhere(['<=', 'departure_date', $this->checkout])
            ->andFilterWhere(['>=', 'no_of_days', $this->no_of_days]);

        return $dataProvider;
    }
}
