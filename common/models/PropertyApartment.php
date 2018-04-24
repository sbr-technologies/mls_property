<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "{{%property_apartments}}".
 *
 * @property int $id
 * @property string $apartmentID
 * @property int $property_id
 * @property int $apt_category_id
 * @property string $title
 * @property string $description
 * @property int $interior_space
 * @property int $no_of_room
 * @property int $no_of_bathroom
 * @property int $no_of_garage
 * @property int $no_of_toilet
 * @property int $year_built
 * @property string $virtual_link
 * @property string $market_status
 * @property int $price
 * @property int $sold_price
 * @property string $sold_date
 * @property string $price_for
 * @property int $service_fee
 * @property string $service_fee_payment_term
 * @property int $other_fee
 * @property string $other_fee_payment_term
 * @property string $contact_term
 * @property int $tax
 * @property string $tax_for
 * @property int $insurance
 * @property string $insurance_for
 * @property int $hoa_fees
 * @property string $hoa_for
 * @property int $mortgage_insurance
 * @property string $construction_status_id
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_at
 * @property int $updated_at
 *
 * @property PropertyCategory $aptCategory
 * @property Property $property
 */
class PropertyApartment extends \yii\db\ActiveRecord
{
    const MARKET_ACTIVE = 'Active';
    const MARKET_SOLD = 'Sold';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%property_apartments}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['property_id', 'apt_category_id', 'interior_space', 'no_of_room', 'no_of_bathroom', 'no_of_garage', 'no_of_toilet', 'year_built', 'price', 'sold_price', 'service_fee', 'other_fee', 'tax', 'insurance', 'hoa_fees', 'mortgage_insurance', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['title', 'apt_category_id', 'market_status', 'description', 'no_of_room'], 'required'],
            [['description'], 'string'],
            [['sold_date'], 'safe'],
            [['apartmentID', 'contact_term'], 'string', 'max' => 100],
            [['title', 'construction_status_id'], 'string', 'max' => 255],
            [['virtual_link'], 'string', 'max' => 125],
            [['market_status', 'tax_for', 'insurance_for', 'hoa_for'], 'string', 'max' => 50],
            [['price_for', 'service_fee_payment_term', 'other_fee_payment_term'], 'string', 'max' => 35],
            [['apt_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => PropertyCategory::className(), 'targetAttribute' => ['apt_category_id' => 'id']],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Property::className(), 'targetAttribute' => ['property_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'apartmentID' => Yii::t('app', 'Apartment ID'),
            'property_id' => Yii::t('app', 'Property ID'),
            'apt_category_id' => Yii::t('app', 'Apt Category ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'interior_space' => Yii::t('app', 'Interior Space'),
            'no_of_room' => Yii::t('app', 'Bedrooms'),
            'no_of_bathroom' => Yii::t('app', 'Bathrooms'),
            'no_of_garage' => Yii::t('app', 'Garages'),
            'no_of_toilet' => Yii::t('app', 'Toilets'),
            'year_built' => Yii::t('app', 'Year Built'),
            'virtual_link' => Yii::t('app', 'Virtual Link'),
            'market_status' => Yii::t('app', 'Market Status'),
            'price' => Yii::t('app', 'Price'),
            'sold_price' => Yii::t('app', 'Sold Price'),
            'sold_date' => Yii::t('app', 'Sold Date'),
            'price_for' => Yii::t('app', 'Price For'),
            'service_fee' => Yii::t('app', 'Service Fee'),
            'service_fee_payment_term' => Yii::t('app', 'Service Fee Payment Term'),
            'other_fee' => Yii::t('app', 'Other Fee'),
            'other_fee_payment_term' => Yii::t('app', 'Other Fee Payment Term'),
            'contact_term' => Yii::t('app', 'Contact Term'),
            'tax' => Yii::t('app', 'Tax'),
            'tax_for' => Yii::t('app', 'Tax For'),
            'insurance' => Yii::t('app', 'Insurance'),
            'insurance_for' => Yii::t('app', 'Insurance For'),
            'hoa_fees' => Yii::t('app', 'Hoa Fees'),
            'hoa_for' => Yii::t('app', 'Hoa For'),
            'mortgage_insurance' => Yii::t('app', 'Mortgage Insurance'),
            'construction_status_id' => Yii::t('app', 'Construction Status ID'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    public function behaviors() {
        parent::behaviors();
        return [TimestampBehavior::className(), BlameableBehavior::className()];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAptCategory()
    {
        return $this->hasOne(PropertyCategory::className(), ['id' => 'apt_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(Property::className(), ['id' => 'property_id']);
    }
    
    public function setSoldDate($date) {
        if(isset($date) && $date != ''){
            $this->sold_date = date('Y-m-d', strtotime(str_replace('/', '-', $date)));
        }else{
            $this->sold_date = null;
        }
    }

    public function getSoldDate() {
        if (!empty($this->sold_date)) {
            return Yii::$app->formatter->asDate($this->sold_date);
        }
    }
    
    /**
     * @inheritdoc
     * @return PropertyApartmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PropertyApartmentQuery(get_called_class());
    }
}
