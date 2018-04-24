<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
/**
 * This is the model class for table "{{%saved_search}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $search_string
 * @property string $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class SavedSearch extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%saved_search}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'search_string', 'name'], 'required'],
            [['user_id', 'created_at', 'updated_at', 'cc_self'], 'integer'],
            [['search_string', 'recipients',  'type', 'schedule'], 'string'],
            [['status'], 'string', 'max' => 255],
            [['recipient'], 'safe']
        ];
    }

    public function behaviors() {
        parent::behaviors();
        return [TimestampBehavior::className()];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'name' => Yii::t('app', 'Name'),
            'search_string' => Yii::t('app', 'Search String'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function beforeSave($insert) {
        parent::beforeSave($insert);
        if($this->listing_from_date){
            $this->listing_from_date = date('Y-m-d', strtotime(str_replace('/', '-', $this->listing_from_date)));
        }
        if($this->listing_to_date){
            $this->listing_to_date = date('Y-m-d', strtotime(str_replace('/', '-', $this->listing_to_date)));
        }
        if($this->closing_from_date){
            $this->closing_from_date = date('Y-m-d', strtotime(str_replace('/', '-', $this->closing_from_date)));
        }
        if($this->closing_to_date){
            $this->closing_to_date = date('Y-m-d', strtotime(str_replace('/', '-', $this->closing_to_date)));
        }
        return true;
    }

        public function getSearchUrl(){
        $searchArray = json_decode($this->search_string);
//        \yii\helpers\VarDumper::dump($searchArray->filters, 11,1);die();
        if($this->type == 'Property'){
            $searchUrl = Yii::$app->params['homeUrl'].'/realestate/search?';
        }
        $item = [];

        foreach ($searchArray->filters as $key => $filter){
            if(is_array($filter) && !empty($filter)){
                $item[$key] = implode(',', $filter);
            }elseif($filter){
                $item[$key] = $filter;
            }
        }

        return $searchUrl. http_build_query($item);
    }
    
    
    public function getRecipient() {
        return json_decode($this->recipients);
    }

    public function setRecipient($value) {
        $this->recipients = json_encode(array_filter(array_values($value)));
    }

    public static function formattedFilter($key){
        switch ($key){
            case 'agent_id':
                return 'AgentID';
            case 'agency_name':
                return 'Office name';
            case 'agency_id':
                return 'OfficeID';
            case 'prop_types':
                return 'Property type';
            case 'const_statuses':
                return 'Construction status';
            case 'market_statuses':
                return 'Market status';
            case 'no_of_toilet':
                return 'Toilet';
            default :
                return Inflector::humanize($key);
        }
    }

    public static function RelatedValue($key, $value){
        switch ($key){
            case 'categories':
                $cats = PropertyCategory::find()->where(['id' => $value])->all();
                return implode(', ', ArrayHelper::getColumn($cats, 'title'));
            case 'prop_types':
                $cats = PropertyType::find()->where(['id' => $value])->all();
                return implode(', ', ArrayHelper::getColumn($cats, 'title'));
            case 'const_statuses':
                $cats = ConstructionStatusMaster::find()->where(['id' => $value])->all();
                return implode(', ', ArrayHelper::getColumn($cats, 'title'));
            case 'general_features':
            case 'exterior_features':
            case 'interior_features':
                $cats = GeneralFeatureMaster::find()->where(['id' => $value])->all();
                return implode(', ', ArrayHelper::getColumn($cats, 'name'));
            case 'bedroom':
            case 'bathroom':
            case 'garage':
            case 'no_of_toilet':
                return $value. '+';
            default :
                if(is_array($value) && !empty($value)){
                    return implode(', ', $value);
                }elseif ($value) {
                    return $value;
                }
        }
    }

    /**
     * @inheritdoc
     * @return SavedSearchQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SavedSearchQuery(get_called_class());
    }
}
