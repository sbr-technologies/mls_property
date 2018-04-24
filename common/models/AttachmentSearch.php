<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Attachment;

/**
 * AttachmentSearch represents the model behind the search form about `common\models\Attachment`.
 */
class AttachmentSearch extends Attachment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'model_id', 'size'], 'integer'],
            [['model', 'title', 'description', 'file_name', 'file_extension', 'original_file_name', 'type', 'status'], 'safe'],
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
        $query = Attachment::find();

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
            'size' => $this->size,
        ]);

        $query->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'file_name', $this->file_name])
            ->andFilterWhere(['like', 'file_extension', $this->file_extension])
            ->andFilterWhere(['like', 'original_file_name', $this->original_file_name])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
