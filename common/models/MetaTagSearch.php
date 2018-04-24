<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MetaTag;

/**
 * MetaTagSearch represents the model behind the search form about `common\models\MetaTag`.
 */
class MetaTagSearch extends MetaTag
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'model_id'], 'integer'],
            [['model', 'page_titlle', 'description', 'keywords'], 'safe'],
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
        $query = MetaTag::find();

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
            'model_id' => $this->model_id,
        ]);

        $query->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'page_titlle', $this->page_titlle])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'keywords', $this->keywords]);

        return $dataProvider;
    }
}
