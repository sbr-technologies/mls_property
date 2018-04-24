<?php

namespace common\models;

use Yii;
use common\components\MailSend;
use common\models\SiteConfig;
use frontend\helpers\AuthHelper;
/**
 * This is the model class for table "{{%buyer_work_sheet}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $state
 * @property string $lga
 * @property string $city
 * @property string $area
 * @property string $comment_location
 * @property string $price_range_from
 * @property string $price_range_to
 * @property string $how_soon_need
 * @property string $usage
 * @property string $investment
 * @property string $cash_flow
 * @property string $appricition
 * @property string $need_agent
 * @property string $contact_me
 * @property integer $year_built
 * @property string $bed
 * @property string $bath
 * @property string $living
 * @property string $stories
 * @property string $square_footage
 * @property string $celling
 * @property string $feature_comment
 * @property string $amenities_comment
 * @property string $additional_criteria
 * @property string $condition
 * @property string $commercial
 * @property string $demolition
 *
 * @property User $user
 * @property User $user0
 */
class BuyerWorkSheet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%buyer_work_sheet}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'year_built'], 'integer'],
            [['comment_location', 'feature_comment', 'amenities_comment', 'additional_criteria'], 'string'],
            [['state', 'lga', 'city', 'how_soon_need', 'usage', 'investment', 'cash_flow', 'appricition', 'stories', 'condition'], 'string', 'max' => 75],
            [['area'], 'string', 'max' => 125],
            [['price_range_from', 'price_range_to'], 'string', 'max' => 35],
            [['need_agent', 'contact_me', 'bed', 'bath', 'living','dining'], 'string', 'max' => 15],
            [['square_footage', 'celling'], 'string', 'max' => 25],
            [['propertyTypes', 'propertyAmenities', 'otherFeatures'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'state' => Yii::t('app', 'State'),
            'lga' => Yii::t('app', 'LGA'),
            'city' => Yii::t('app', 'Town'),
            'area' => Yii::t('app', 'Area'),
            'comment_location' => Yii::t('app', 'Comment Location'),
            'price_range_from' => Yii::t('app', 'Price Range From'),
            'price_range_to' => Yii::t('app', 'Price Range To'),
            'how_soon_need' => Yii::t('app', 'How Soon Need'),
            'usage' => Yii::t('app', 'Usage'),
            'investment' => Yii::t('app', 'Investment'),
            'cash_flow' => Yii::t('app', 'Cash Flow'),
            'appricition' => Yii::t('app', 'Appricition'),
            'need_agent' => Yii::t('app', 'Need Agent'),
            'contact_me' => Yii::t('app', 'Contact Me'),
            'year_built' => Yii::t('app', 'Year Built'),
            'bed' => Yii::t('app', 'Bed'),
            'bath' => Yii::t('app', 'Bath'),
            'living' => Yii::t('app', 'Living'),
            'dining' => Yii::t('app', 'Dining'),
            'stories' => Yii::t('app', 'Stories'),
            'square_footage' => Yii::t('app', 'Square Footage'),
            'celling' => Yii::t('app', 'Celling'),
            'feature_comment' => Yii::t('app', 'Feature Comment'),
            'amenities_comment' => Yii::t('app', 'Amenities Comment'),
            'additional_criteria' => Yii::t('app', 'Additional Criteria'),
            'condition' => Yii::t('app', 'Condition'),
            'commercial' => Yii::t('app', 'Commercial'),
            'demolition' => Yii::t('app', 'Demolition'),
            'property_types' => Yii::t('app', 'Property Types'),
            'property_amenities' => Yii::t('app', 'Property Amenities'),
            'other_features' => Yii::t('app', 'Other Features'),
        ];
    }
    
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        if(!AuthHelper::is('admin')){
            $opts = [];
            $adminEmail = SiteConfig::item('adminEmail');
            if($this->user_id){
                $user = $this->user;
                $opts['{{%BUYER_NAME%}}']        = $user->commonName;
                $opts['{{%BUYER_ID%}}']              = $user->buyerID;
                $opts['{{%EMAIL%}}']           = $user->email;
            }
            MailSend::sendMail('CRITERIA_WORKSHEET_NOTIFICATION', $adminEmail, $opts);
        }
    }

    public function getPropertyTypes(){
        if(empty($this->property_types)){
            return null;
        }
        return explode(',', $this->property_types);
    }
    
    public function setPropertyTypes($value){
        if(!empty($value) && is_array($value)){
            $this->property_types = implode(',', $value);
        }
    }

    public function getPropertyAmenities(){
        if(empty($this->property_amenities)){
            return null;
        }
        return explode(',', $this->property_amenities);
    }
    
    public function setPropertyAmenities($value){
        if(!empty($value) && is_array($value)){
            $this->property_amenities = implode(',', $value);
        }
    }

    public function getOtherFeatures(){
        if(empty($this->other_features)){
            return null;
        }
        return explode(',', $this->other_features);
    }
    
    public function setOtherFeatures($value){
        if(!empty($value) && is_array($value)){
            $this->other_features = implode(',', $value);
        }
    }
    
    public function getPropertyTypesNames(){
        return PropertyType::find()->select('title')->where(['id' => $this->propertyTypes])->active()->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return BuyerWorkSheetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BuyerWorkSheetQuery(get_called_class());
    }
}
