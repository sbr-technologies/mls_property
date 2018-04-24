<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PropertyEnquiery;

/**
 * PropertyEnquierySearch represents the model behind the search form about `common\models\PropertyEnquiery`.
 */
class PropertyEnquierySearch extends PropertyEnquiery
{
    public $ownerId;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'assign_to'], 'integer'],
            [['name', 'email', 'phone', 'subject', 'message', 'status'], 'safe'],
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
        $query = PropertyEnquiery::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
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
           // 'property_id' => $this->property_id,
            'assign_to' => $this->assign_to,
        ]);
        
        if($this->ownerId){
            $query->andWhere(['or',
                ['assign_to' => $this->ownerId],
                ['user_id'=>  $this->ownerId]
            ]);
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
