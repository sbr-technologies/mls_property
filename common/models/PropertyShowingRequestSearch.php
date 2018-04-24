<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PropertyShowingRequest;

/**
 * PropertyShowingRequestSearch represents the model behind the search form about `common\models\PropertyShowingRequest`.
 */
class PropertyShowingRequestSearch extends PropertyShowingRequest
{
    public $ownerId;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'model_id', 'schedule', 'is_lender', 'created_at', 'updated_at'], 'integer'],
            [['model', 'note', 'name', 'email', 'phone', 'status'], 'safe'],
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
        $query = PropertyShowingRequest::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' =>['id' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'model_id' => $this->model_id,
            'schedule' => $this->schedule,
            'is_lender' => $this->is_lender,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone]);
        
        if($this->ownerId){
            $subQuery = Property::find()->select('id')->where(['user_id' => $this->ownerId, 'status' => 'active']);
//            $query->andWhere(['model_id' => $subQuery]);
            $query->andWhere(['or',
                ['model_id' => $subQuery, 'status' => [parent::STATUS_PENDING, parent::STATUS_APPROVE]],
                ['user_id'=>  $this->ownerId]
            ]);
        }


//        echo $query->createCommand()->rawSql;die();
        return $dataProvider;
    }
}
