<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\HolidayPackageEnquiry;

/**
 * HolidayPackageEnquirySearch represents the model behind the search form about `common\models\HolidayPackageEnquiry`.
 */
class HolidayPackageEnquirySearch extends HolidayPackageEnquiry
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'holiday_package_id', 'user_id', 'enquiry_at'], 'integer'],
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
        $query = HolidayPackageEnquiry::find();

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
            'holiday_package_id' => $this->holiday_package_id,
            'user_id' => $this->user_id,
            'enquiry_at' => $this->enquiry_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
