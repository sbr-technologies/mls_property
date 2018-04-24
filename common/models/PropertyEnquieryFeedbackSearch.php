<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PropertyEnquieryFeedback;

/**
 * PropertyEnquieryFeedbackSearch represents the model behind the search form about `common\models\PropertyEnquieryFeedback`.
 */
class PropertyEnquieryFeedbackSearch extends PropertyEnquieryFeedback
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'proerty_enquiery_id', 'property_id'], 'integer'],
            [['replay', 'status'], 'safe'],
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
        $query = PropertyEnquieryFeedback::find();

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
            'proerty_enquiery_id' => $this->proerty_enquiery_id,
            'property_id' => $this->property_id,
        ]);

        $query->andFilterWhere(['like', 'replay', $this->replay])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
