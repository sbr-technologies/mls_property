<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Contact;

/**
 * ContactSearch represents the model behind the search form about `common\models\Contact`.
 */
class ContactSearch extends Contact
{
    public $userIdIn;
    public $keyword;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'user_id', 'gender'], 'integer'],
            [['first_name', 'middle_name', 'last_name', 'email', 'mobile1', 'mobile1', 'userIdIn'], 'safe'],
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
        $query = Contact::find();

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
            'gender' => $this->gender,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        
        if(!empty($this->userIdIn)){
            $query->andFilterWhere(['IN', 'user_id', $this->userIdIn]);
        }
        
        if($this->keyword){
            $query->andFilterWhere(['or', 
                ['like', 'first_name', $this->keyword],
                ['like', 'middle_name', $this->keyword],
                ['like', 'last_name', $this->keyword],
                ['like', 'email', $this->keyword],
                ['like', 'CONCAT_WS("", first_name, last_name)', str_replace(' ', '', $this->keyword)],
                ['like', 'CONCAT_WS("", first_name, middle_name, last_name)', str_replace(' ', '', $this->keyword)],
                ['like', 'CONCAT_WS("", salutation, first_name, middle_name, last_name)', str_replace(' ', '', $this->keyword)]
            ]);
        }
        

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'email', $this->email]);
//        echo $query->createCommand()->rawSql; die();
        return $dataProvider;
    }
}
