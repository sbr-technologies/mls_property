<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\HolidayPackage;

/**
 * HolidayPackageSearch represents the model behind the search form about `common\models\HolidayPackage`.
 */
class HolidayPackageSearch extends HolidayPackage
{
    public $monthTravel;
    public $yearTravel;
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
            'no_of_nights' => $this->no_of_nights,
            'departure_date' => $this->departure_date,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'hotel_transport_info', $this->hotel_transport_info])
            ->andFilterWhere(['like', 'inclusion', $this->inclusion])
            ->andFilterWhere(['like', 'exclusions', $this->exclusions])
            ->andFilterWhere(['like', 'payment_policy', $this->payment_policy])
            ->andFilterWhere(['like', 'source_city', $this->source_city])
            ->andFilterWhere(['like', 'source_state', $this->source_state])
            ->andFilterWhere(['like', 'destination_city', $this->destination_city])
            ->andFilterWhere(['like', 'destination_state', $this->destination_state])
            ->andFilterWhere(['like', 'cancellation_policy', $this->cancellation_policy]);
        
        if($this->monthTravel && $this->yearTravel){
            $query->andFilterWhere(['MONTH(FROM_UNIXTIME(departure_date))' => $this->monthTravel,
                                'YEAR(FROM_UNIXTIME(departure_date))' => $this->yearTravel]);
        }
        
//        \yii\helpers\VarDumper::dump($query->createCommand()->rawSql);die();
        return $dataProvider;
    }
}
