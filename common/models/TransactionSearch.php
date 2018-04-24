<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Transaction;

/**
 * TransactionSearch represents the model behind the search form about `common\models\Transaction`.
 */
class TransactionSearch extends Transaction
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['gateway', 'transactionid', 'currencycode', 'receiveremail', 'receiverid', 'payerid', 'payerstatus', 'timestamp', 'correlationid', 'receiptid', 'paymenttype', 'paymentstatus', 'status'], 'safe'],
            [['amt'], 'number'],
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
        $query = Transaction::find();

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
            'amt' => $this->amt,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'gateway', $this->gateway])
            ->andFilterWhere(['like', 'transactionid', $this->transactionid])
            ->andFilterWhere(['like', 'currencycode', $this->currencycode])
            ->andFilterWhere(['like', 'receiveremail', $this->receiveremail])
            ->andFilterWhere(['like', 'receiverid', $this->receiverid])
            ->andFilterWhere(['like', 'payerid', $this->payerid])
            ->andFilterWhere(['like', 'payerstatus', $this->payerstatus])
            ->andFilterWhere(['like', 'timestamp', $this->timestamp])
            ->andFilterWhere(['like', 'correlationid', $this->correlationid])
            ->andFilterWhere(['like', 'receiptid', $this->receiptid])
            ->andFilterWhere(['like', 'paymenttype', $this->paymenttype])
            ->andFilterWhere(['like', 'paymentstatus', $this->paymentstatus])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
