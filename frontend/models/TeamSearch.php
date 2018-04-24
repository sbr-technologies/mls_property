<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Team;
use common\models\User;
use common\models\Agency;

/**
 * TeamSearch represents the model behind the search form about `common\models\Team`.
 */
class TeamSearch extends Team
{
    public $keyword;
    public $officeName;
    public $officeID;
    public $officeTown;
    public $officeState;
    public $officeArea;
    public $officeZipCode;
    public $officeMobile;
    public $officeEmail;
    public $sortBy;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['teamID', 'status'], 'safe'],
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
        $query = Team::find()->where([parent::tableName(). '.status' => 'active']);

        // add conditions that should always apply here

        $query->joinWith(["agency" => function($q) {
                return $q->from(Agency::tableName() . ' a');
        }]);
            
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['name' => SORT_ASC]]
        ]);

        $this->load($params);

//        if (!$this->validate()) {
//            // uncomment the following line if you do not want to return any records when validation fails
//             $query->where('0=1');
//            return $dataProvider;
//        }
        // grid filtering conditions
//        $query->andFilterWhere([
//            'id' => $this->id,
//            'created_by' => $this->created_by,
//            'updated_by' => $this->updated_by,
//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at,
//            'status' => $this->status
//        ]);
//        \yii\helpers\VarDumper::dump($this->teamName);exit;
        $query->andFilterWhere(['like', 'teamID', $this->teamID])
            ->andFilterWhere(['like', parent::tableName(). '.name', $this->name]);
        
        if($this->officeName){
//            $subQuery = Agency::find()->select('id')->where(['name' => $this->officeName])->active();
            $query->andFilterWhere(['a.name' => $this->officeName]);
        }
        if($this->officeID){
//            $subQuery = Agency::find()->select('id')->where(['agencyID' => $this->officeID])->active();
            $query->andFilterWhere(['a.agencyID' => $this->officeID]);
        }
        if($this->officeState){
//            $subQuery = Agency::find()->select('id')->where(['state' => $this->officeState])->active();
            $query->andFilterWhere(['a.state' => $this->officeState]);
        }
        if($this->officeTown){
//            $subQuery = Agency::find()->select('id')->where(['town' => $this->officeTown])->active();
            $query->andFilterWhere(['a.town' => $this->officeTown]);
        }
        if($this->officeArea){
//            $subQuery = Agency::find()->select('id')->where(['area' => $this->officeArea])->active();
            $query->andFilterWhere(['a.area' => $this->officeArea]);
        }
        if($this->officeZipCode){
//            $subQuery = Agency::find()->select('id')->where(['zip_code' => $this->officeZipCode])->active();
            $query->andFilterWhere(['a.zip_code' => $this->officeZipCode]);
        }
        if($this->officeEmail){
//            $subQuery = Agency::find()->select('id')->where(['email' => $this->officeEmail])->active();
            $query->andFilterWhere(['a.email' => $this->officeEmail]);
        }
        if($this->officeMobile){
//            $subQuery = Agency::find()->select('id')->where(['mobile1' => $this->officeMobile])->active();
            $query->andFilterWhere(['a.mobile1' => $this->officeMobile]);
        }
        
        if($this->sortBy == parent::SORT_NAME){
            $query->orderBy([parent::tableName(). '.name' => SORT_ASC]);
        }elseif($this->sortBy == parent::SORT_OFFICE_NAME){
            $query->orderBy(['a.name' => SORT_ASC, parent::tableName(). '.name' => SORT_ASC]);
        }
        
//        echo $query->createCommand()->rawSql;die();
        return $dataProvider;
    }
}
