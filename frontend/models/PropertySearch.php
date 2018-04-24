<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Property;
use common\models\Agency;
use common\models\Team;
use common\models\User;
use yii\db\Expression;
use common\models\PropertyGeneralFeature;

/**
 * PropertySearch represents the model behind the search form about `common\models\Property`.
 */
class PropertySearch extends Property
{
    public $categories;
    public $minPrice;
    public $maxPrice;
    public $bedroomPlus;
    public $bathroomPlus;
    public $garagePlus;
    public $toiletPlus;
    public $boysQuaterPlus;
    public $typesIn;
    public $constStatuses;
    public $marktStatuses;
    public $sortBy;
    
    public $minLotSize;
    public $maxLotSize;
    public $minBuildingSize;
    public $maxBuildingSize;
    public $minHouseSize;
    public $maxHouseSize;
    
    public $minToilet;
    public $maxToilet;
    public $minBoysQuater;
    public $maxBoysQuater;
    public $minYearBuilt;
    public $maxYearBuilt;
    
    public $agencyID;
    public $agencyName;
    public $teamID;
    public $teamName;
    public $agentID;
    public $agentName;
    
    public $soleMandate;
    public $featured;
    public $propertyID;
//    public $streetAddress;
//    public $streetNumber;
//    public $appartmentUnit;
//    public $zipCode;
//    public $localGovtArea;
//    public $urbanTownArea;

    public $listingFromDate;
    public $listingToDate;
    public $closingFromDate;
    public $closingToDate;


    public $searchType;
    public $generalFeatures;
    public $exteriorFeatures;
    public $interiorFeatures;
    
    public $condominium;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'metric_type_id', 'no_of_room', 'no_of_bathroom', 'no_of_garage', 'property_type_id', 'property_category_id', 'construction_status_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'lot_size'], 'integer'],
            [['title', 'description', 'country', 'state', 'town', 'area', 'zip_code', 'appartment_unit', 'currency','virtual_link', 'minPrice', 'maxPrice', 'bedroomPlus', 'bathroomPlus', 'garagePlus', 'typesIn', 'sortBy', 'status', 'sole_mandate', 'featured', 'categories','propertyID'], 'safe'],
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
        $today = date('Y-m-d');
        $query = Property::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'preimum_lisitng' => SORT_DESC, 'created_at' => SORT_DESC
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
             $query->where('0=1');
            return $dataProvider;
        }
        
        $query->andWhere(['OR',
                ['is_multi_units_apt' => 0],
                ['AND', ['is_multi_units_apt'=>  1], ['is not', 'parent_id', new Expression('NULL')]]
        ]);    
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'metric_type_id' => $this->metric_type_id,
            'no_of_room' => $this->no_of_room,
            'no_of_toilet' => $this->no_of_toilet,
            'no_of_bathroom' => $this->no_of_bathroom,
//            'status_of_electricity' => $this->status_of_electricity,
            'price' => $this->price,
            'property_type_id' => $this->property_type_id,
            'property_category_id' => $this->property_category_id,
            'construction_status_id' => $this->construction_status_id,
            'sole_mandate' => $this->sole_mandate,
            'featured' => $this->featured,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'reference_id' => $this->propertyID,
            'state' => $this->state,
            'town' => $this->town,
            'area' => $this->area,
            'zip_code' => $this->zip_code,
            'state' => $this->state,
            'street_address' => $this->street_address,
            'street_number' => $this->street_number,
            'area' => $this->area,
            'appartment_unit' => $this->appartment_unit,
            'local_govt_area' => $this->local_govt_area,
            'district' => $this->district,
            'urban_town_area' => $this->urban_town_area,
            
        ]);

        $query->andFilterWhere(['>=', 'expired_date', $today]);
        
        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'currency', $this->currency]);

        $query->andFilterWhere(['>=', 'price', $this->minPrice])
                ->andFilterWhere(['<=', 'price', $this->maxPrice])
                ->andFilterWhere(['>=', 'no_of_room', $this->bedroomPlus])
                ->andFilterWhere(['>=', 'no_of_bathroom', $this->bathroomPlus])
                ->andFilterWhere(['>=', 'no_of_garage', $this->garagePlus])
                ->andFilterWhere(['>=', 'no_of_toilet', $this->toiletPlus])
                ->andFilterWhere(['>=', 'no_of_boys_quater', $this->boysQuaterPlus]);
        
        if(!empty($this->categories)){
            $query->andFilterWhere(['IN', 'property_category_id', $this->categories]);
        }
        
        
        if(!empty($this->typesIn)){
            $typeQ = '';
            foreach ($this->typesIn as $typeId){
                $typeQ .= "FIND_IN_SET('$typeId', property_type_id)>0 OR ";
            }
            $typeQ = substr($typeQ, 0, -4);
            $query->andWhere(new Expression($typeQ));
        }
        
        if(!empty($this->constStatuses)){
            $constQ = '';
            foreach ($this->constStatuses as $statusId){
                $constQ .= "FIND_IN_SET('$statusId',  construction_status_id)>0 OR ";
            }
            $constQ = substr($constQ, 0, -4);
            $query->andWhere(new Expression($constQ));
        }
        
        if(!empty($this->marktStatuses)){
//            $mktQ = '';
//            foreach ($this->marktStatuses as $statusId){
//                $mktQ .= "FIND_IN_SET('$statusId', market_status)>0 OR ";
//            }
//            $mktQ = substr($mktQ, 0, -4);
//            $query->andWhere(new Expression($mktQ));
            $query->andFilterWhere(['IN', 'market_status', $this->marktStatuses]);
        }else{
            $query->andFilterWhere(['IN', 'market_status', 'Active', 'Sold', 'Pending']);
        }
        
        $query->andFilterWhere(['>=', 'lot_size', $this->minLotSize])
                ->andFilterWhere(['<=', 'lot_size', $this->maxLotSize])
                ->andFilterWhere(['>=', 'building_size', $this->minBuildingSize])
                ->andFilterWhere(['<=', 'building_size', $this->maxBuildingSize])
                ->andFilterWhere(['>=', 'house_size', $this->minHouseSize])
                ->andFilterWhere(['<=', 'house_size', $this->maxHouseSize]);
        
        $query->andFilterWhere(['>=', 'year_built', $this->minYearBuilt])
                ->andFilterWhere(['<=', 'year_built', $this->maxYearBuilt]);
       
        if($this->agencyID){
            $subQuery = Agency::find()->select('id')->where(['agencyID' => $this->agencyID])->active();
            $userSubQuery = User::find()->select('id')->where(['IN', 'agency_id', $subQuery])->active();
            $query->andFilterWhere(['IN', Yii::$app->db->tablePrefix. 'property.user_id', $userSubQuery]);
        }
        
        if($this->agencyName){
            $subQuery = Agency::find()->select('id')->where(['name' => $this->agencyName])->active();
            $userSubQuery = User::find()->select('id')->where(['IN', 'agency_id', $subQuery])->active();
            $query->andFilterWhere(['IN', Yii::$app->db->tablePrefix. 'property.user_id', $userSubQuery]);
        }
        
//        if($this->teamID){
//            $subQuery = Team::find()->select('id')->where(['team_ID' => $this->teamID])->active();
//            $subSubQuery = User::find()->select('id')->where(['IN', 'team_id', $subQuery])->active();
//            $query->andFilterWhere(['IN', Yii::$app->db->tablePrefix. 'property.user_id', $subSubQuery]);
//        }
//        
//        if($this->teamName){
//            $subQuery = Team::find()->select('id')->where(['name' => $this->teamName])->active();
//            $subSubQuery = User::find()->select('id')->where(['IN', 'team_id', $subQuery])->active();
//            $query->andFilterWhere(['IN', Yii::$app->db->tablePrefix. 'property.user_id', $subSubQuery]);
//        }
        
        if($this->agentID){
            $subQuery = User::find()->select('id')->where(['agentID' =>$this->agentID])->active();
            $query->andFilterWhere(['IN', Yii::$app->db->tablePrefix. 'property.user_id', $subQuery]);
        }
        
        if($this->listingFromDate){
            $query->andFilterWhere(['>=', 'listed_date', date('Y-m-d', strtotime(str_replace('/', '-', $this->listingFromDate)))]);
        }
        if($this->listingToDate){
                $query->andFilterWhere(['<=', 'listed_date', date('Y-m-d', strtotime(str_replace('/', '-', $this->listingToDate)))]);
        }
        if($this->closingFromDate){
                $query->andFilterWhere(['>=', 'sold_date', date('Y-m-d', strtotime(str_replace('/', '-', $this->closingFromDate)))]);
        }
        if($this->closingToDate){
                $query->andFilterWhere(['<=', 'sold_date', date('Y-m-d', strtotime(str_replace('/', '-', $this->closingToDate)))]);
        }
        
        if($this->generalFeatures){
            $subQuery = PropertyGeneralFeature::find()->select('property_id')->distinct()->where(['general_feature_master_id' => $this->generalFeatures]);
            $query->andFilterWhere(['IN', Yii::$app->db->tablePrefix. 'property.id', $subQuery]);
        }
        if($this->exteriorFeatures){
            $subQuery = PropertyGeneralFeature::find()->select('property_id')->distinct()->where(['general_feature_master_id' => $this->exteriorFeatures]);
            $query->andFilterWhere(['IN', Yii::$app->db->tablePrefix. 'property.id', $subQuery]);
        }
        if($this->interiorFeatures){
            $subQuery = PropertyGeneralFeature::find()->select('property_id')->distinct()->where(['general_feature_master_id' => $this->interiorFeatures]);
            $query->andFilterWhere(['IN', Yii::$app->db->tablePrefix. 'property.id', $subQuery]);
        }
        
        if($this->agentName){
            $subQuery = User::find()->select('id')
                    ->andFilterWhere(['or',
                        ['like', 'first_name', $this->agentName],
                        ['like', 'middle_name', $this->agentName],
                        ['like', 'last_name', $this->agentName],
                        ['like', "CONCAT_WS('', first_name, last_name)", str_replace(' ', '', $this->agentName)],
                        ['like', "CONCAT_WS('', first_name, middle_name, last_name)", str_replace(' ', '', $this->agentName)],
                    ])->active();
            $query->andFilterWhere(['IN', Yii::$app->db->tablePrefix. 'property.user_id', $subQuery]);
        }
        
        if($this->condominium){
            $subQuery = parent::find()->select('id')->where(['like', 'building_name', $this->condominium]);
            $query->andFilterWhere([Yii::$app->db->tablePrefix. 'property.parent_id' => $subQuery]);
        }
        
        
        
        if($this->sortBy == 'newest'){
            $query->orderBy(['created_at' => SORT_DESC]);
        }elseif($this->sortBy == 'lowest_price'){
            $query->orderBy(['price' => SORT_ASC]);
        }elseif($this->sortBy == 'highest_price'){
            $query->orderBy(['price' => SORT_DESC]);
        }
//        elseif($this->sortBy == 'largest_area'){
//            $query->orderBy(['size' => SORT_DESC]);
//        }
//        echo $query->createCommand()->rawSql;die();
        return $dataProvider;
    }
}
