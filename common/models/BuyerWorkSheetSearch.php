<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\BuyerWorkSheet;

/**
 * BuyerWorkSheetSearch represents the model behind the search form of `common\models\BuyerWorkSheet`.
 */
class BuyerWorkSheetSearch extends BuyerWorkSheet
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'year_built'], 'integer'],
            [['state', 'lga', 'city', 'area', 'comment_location', 'price_range_from', 'price_range_to', 'how_soon_need', 'usage', 'investment', 'cash_flow', 'appricition', 'need_agent', 'contact_me', 'bed', 'bath', 'living', 'dining', 'stories', 'square_footage', 'celling', 'feature_comment', 'amenities_comment', 'additional_criteria', 'condition', 'commercial', 'demolition', 'property_types', 'property_amenities', 'other_features'], 'safe'],
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
        $query = BuyerWorkSheet::find();

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
            'year_built' => $this->year_built,
        ]);

        $query->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'lga', $this->lga])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'area', $this->area])
            ->andFilterWhere(['like', 'comment_location', $this->comment_location])
            ->andFilterWhere(['like', 'price_range_from', $this->price_range_from])
            ->andFilterWhere(['like', 'price_range_to', $this->price_range_to])
            ->andFilterWhere(['like', 'how_soon_need', $this->how_soon_need])
            ->andFilterWhere(['like', 'usage', $this->usage])
            ->andFilterWhere(['like', 'investment', $this->investment])
            ->andFilterWhere(['like', 'cash_flow', $this->cash_flow])
            ->andFilterWhere(['like', 'appricition', $this->appricition])
            ->andFilterWhere(['like', 'need_agent', $this->need_agent])
            ->andFilterWhere(['like', 'contact_me', $this->contact_me])
            ->andFilterWhere(['like', 'bed', $this->bed])
            ->andFilterWhere(['like', 'bath', $this->bath])
            ->andFilterWhere(['like', 'living', $this->living])
            ->andFilterWhere(['like', 'dining', $this->dining])
            ->andFilterWhere(['like', 'stories', $this->stories])
            ->andFilterWhere(['like', 'square_footage', $this->square_footage])
            ->andFilterWhere(['like', 'celling', $this->celling])
            ->andFilterWhere(['like', 'feature_comment', $this->feature_comment])
            ->andFilterWhere(['like', 'amenities_comment', $this->amenities_comment])
            ->andFilterWhere(['like', 'additional_criteria', $this->additional_criteria])
            ->andFilterWhere(['like', 'condition', $this->condition])
            ->andFilterWhere(['like', 'commercial', $this->commercial])
            ->andFilterWhere(['like', 'demolition', $this->demolition])
            ->andFilterWhere(['like', 'property_types', $this->property_types])
            ->andFilterWhere(['like', 'property_amenities', $this->property_amenities])
            ->andFilterWhere(['like', 'other_features', $this->other_features]);

        return $dataProvider;
    }
}
