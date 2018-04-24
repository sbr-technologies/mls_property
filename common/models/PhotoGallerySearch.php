<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PhotoGallery;

/**
 * PhotoGallerySearch represents the model behind the search form about `common\models\PhotoGallery`.
 */
class PhotoGallerySearch extends PhotoGallery
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'model_id', 'size', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['model', 'title', 'description', 'image_file_name', 'image_file_extension', 'original_file_name', 'status'], 'safe'],
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
        $query = PhotoGallery::find();

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
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'image_file_name', $this->image_file_name])
            ->andFilterWhere(['like', 'image_file_extension', $this->image_file_extension])
            ->andFilterWhere(['like', 'original_file_name', $this->original_file_name])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
