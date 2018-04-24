<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\NewsletterSchedule;

/**
 * NewsletterScheduleSearch represents the model behind the search form of `common\models\NewsletterSchedule`.
 */
class NewsletterScheduleSearch extends NewsletterSchedule
{
    public $ownerIdIn;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'scheduled_by', 'template_id', 'user_id', 'contact_id', 'list_id', 'subscriber_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['name', 'schedule', 'schedule_start_date', 'schedule_end_date', 'status', 'last_mail_sent'], 'safe'],
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
        $query = NewsletterSchedule::find();

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
            'index_id' => $this->index_id,
            'scheduled_by' => $this->scheduled_by,
            'template_id' => $this->template_id,
            'user_id' => $this->user_id,
            'contact_id' => $this->contact_id,
            'list_id' => $this->list_id,
            'subscriber_id' => $this->subscriber_id,
            'schedule_start_date' => $this->schedule_start_date,
            'schedule_end_date' => $this->schedule_end_date,
            'last_mail_sent' => $this->last_mail_sent,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'schedule', $this->schedule])
            ->andFilterWhere(['like', 'status', $this->status]);

        if(!empty($this->ownerIdIn)){
            $query->andFilterWhere(['IN', 'scheduled_by', $this->ownerIdIn]);
        }
        
        return $dataProvider;
    }
}
