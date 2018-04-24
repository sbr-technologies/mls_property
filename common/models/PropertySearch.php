<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Property;
use yii\db\Expression;

/**
 * PropertySearch represents the model behind the search form about `common\models\Property`.
 */
class PropertySearch extends Property
{
    public $keyword;
    public $categoryName;
    public $agentID;
    //var $query;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'profile_id', 'metric_type_id', 'no_of_room', 'no_of_bathroom', 'property_type_id', 'property_category_id', 'construction_status_id', 'created_by', 'updated_by', 'created_at', 'updated_at','lot_size','is_seller_information_show', 'user_id'], 'integer'],
            [['title', 'description', 'country', 'state', 'town', 'currency', 'currency_symbol','categoryName', 'market_status','listed_date','expired_date', 'agentID'], 'safe'],
            [['reference_id'], 'string'],
            [['lat', 'lng', 'price'], 'number'],
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
        $query = Property::find();
        $query->joinWith(['propertyCategory' => function($q) {
            $q->from(Yii::$app->db->tablePrefix . 'property_category c');
        }]);
        $query	->from(Yii::$app->db->tablePrefix . 'property p')
                ->join('LEFT OUTER JOIN', 'mls_user u', 'p.user_id =u.id')
                ->join('LEFT OUTER JOIN', 'mls_profile pr','u.profile_id = pr.id'); 
        
        //$query->joinWith('propertyCategory');
        // add conditions that should always apply here
//        $query = $query->createCommand();
//        $query = $query->queryAll();	
        //\yii\helpers\VarDumper::dump($data,4,12); exit;
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id' => SORT_DESC]]
            
        ]);

        
        $this->load($params);

        
        if(!\frontend\helpers\AuthHelper::is('admin')){
            $query->andWhere(['OR',
                ['is_multi_units_apt' => 0],
                ['AND', ['is_multi_units_apt'=>  1], ['is not', 'parent_id', new Expression('NULL')]]
            ]);
        }
        
        
        
//        \yii\helpers\VarDumper::dump($this->categoryName); exit;
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            //'property_category_id' => $this->categoryName,
            'is_condo' => $this->is_condo,
            'user_id' => $this->user_id,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'metric_type_id' => $this->metric_type_id,
            'lot_size' => $this->lot_size,
            'no_of_room' => $this->no_of_room,
            'no_of_toilet' => $this->no_of_toilet,
            'no_of_bathroom' => $this->no_of_bathroom,
            'price' => $this->price,
            'property_category_id' => $this->property_category_id,
            'is_seller_information_show' => $this->is_seller_information_show,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'market_status' => $this->market_status,
            'profile_id' => $this->profile_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'reference_id', $this->reference_id])   
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'town', $this->town])
            ->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'currency_symbol', $this->currency_symbol])
            ->andFilterWhere(['or', ['like', 'c.title', $this->categoryName]]);
        
        $query->andFilterWhere(['or', 
                ['like', 'p.title', $this->keyword],
                ['like', 'p.town', $this->keyword],
                ['like', 'p.description', $this->keyword],
                ['like', 'p.state', $this->keyword],
                ['like', 'p.district', $this->keyword],
                
            ]);
        
        
        /**
        * Setup your sorting attributes
        * Note: This is setup before the $this->load($params) 
        * statement below
        */
//        $dataProvider->setSort([
//            
//            'attributes' => [
//                'reference_id',
//                'agentID' => [
//                    'asc' => ['u.agentID' => SORT_ASC],
//                    'desc' => ['u.agentID' => SORT_DESC],
//                    'label' => 'Agent ID',
//                    'default' => SORT_ASC
//                ],
//                'user_id'=> [
//                    'asc' => ['u.first_name' => SORT_ASC],
//                    'desc' => ['u.first_name' => SORT_DESC],
//                    'default' => SORT_ASC
//                ],
//                'property_category_id' => [
//                    'asc' => ['c.title' => SORT_ASC],
//                    'desc' => ['c.title' => SORT_DESC],
//                    'default' => SORT_ASC
//                ],
//                'profile_id',
//                'price',
//                'town',
//                'market_status',
//                'lot_size',
//                'listed_date',
//                'expired_date',
//            ],
//            
//        ]);
        
//        echo $query->createCommand()->rawSql;die();
        return $dataProvider;
    }
}
