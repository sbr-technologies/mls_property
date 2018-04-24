<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EmailSentLog;

/**
 * EmailSentLogSearch represents the model behind the search form of `common\models\EmailSentLog`.
 */
class EmailSentLogSearch extends EmailSentLog
{
    public $ownerIdIn;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sent_by', 'template_id', 'user_id', 'contact_id', 'list_id', 'subscriber_id', 'created_at', 'updated_at'], 'integer'],
            [['subject', 'content', 'type', 'status'], 'safe'],
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
        $query = EmailSentLog::find();

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
            'sent_by' => $this->sent_by,
            'template_id' => $this->template_id,
            'user_id' => $this->user_id,
            'contact_id' => $this->contact_id,
            'list_id' => $this->list_id,
            'subscriber_id' => $this->subscriber_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'status', $this->status]);

        if(!empty($this->ownerIdIn)){
            $query->andFilterWhere(['IN', 'sent_by', $this->ownerIdIn]);
        }
        
        return $dataProvider;
    }
}
