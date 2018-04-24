<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PropertyLocationLocalInfo;

/**
 * PropertyLocationLocalInfoSearch represents the model behind the search form about `common\models\PropertyLocationLocalInfo`.
 */
class PropertyLocationLocalInfoSearch extends PropertyLocationLocalInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'property_id', 'local_info_type_id'], 'integer'],
            [['title', 'description', 'status'], 'safe'],
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
        $query = PropertyLocationLocalInfo::find();

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
            'property_id' => $this->property_id,
            'local_info_type_id' => $this->local_info_type_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
