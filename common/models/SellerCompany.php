<?php

namespace common\models;
use Yii;
use yii\helpers\StringHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%seller_company}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $country
 * @property string $state
 * @property string $city
 * @property string $address1
 * @property string $address2
 * @property string $zip_code
 * @property string $estd
 * @property string $email
 * @property string $
 * @property string $fax
 * @property string $telephone
 * @property string $web_address
 * @property string $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class SellerCompany extends \yii\db\ActiveRecord
{
    public $location;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%seller_company}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'country', 'state', 'city', 'address1', 'zip_code'], 'required'],
            [['lat', 'lng'], 'number'],
            [['user_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['name', 'address1', 'address2'], 'string', 'max' => 255],
            [['country', 'state', 'state_long', 'city', 'email', 'web_address'], 'string', 'max' => 75],
            [['zip_code', 'status'], 'string', 'max' => 15],
            [['estd'], 'string', 'max' => 50],
            [['calling_code'], 'string', 'max' => 100],
            [['mobile1', 'mobile2', 'mobile3','calling_code2','calling_code3', 'calling_code4','office1','office2','office3','office4','fax1','fax2','fax3','fax4'], 'string', 'max' => 35],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function behaviors() {
        parent::behaviors();
        return [TimestampBehavior::className(), BlameableBehavior::className()];
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
            'country' => Yii::t('app', 'Country'),
            'state' => Yii::t('app', 'State'),
            'state_long' => Yii::t('app', 'State'),
            'city' => Yii::t('app', 'City'),
            'address1' => Yii::t('app', 'Address1'),
            'address2' => Yii::t('app', 'Address2'),
            'zip_code' => Yii::t('app', 'Zip Code'),
            'estd' => Yii::t('app', 'Estd'),
            'email' => Yii::t('app', 'Email'),
            'calling_code' => Yii::t('app', 'Calling Code'),
            '' => Yii::t('app', 'Mobile1'),
            'mobile2' => Yii::t('app', 'Mobile2'),
            'mobile3' => Yii::t('app', 'Mobile3'),
            'mobile4' => Yii::t('app', 'Other Mobile'),
            'calling_code2' => Yii::t('app', 'Calling Code'),
            'office1' => Yii::t('app', 'Office1'),
            'office2' => Yii::t('app', 'Office2'),
            'office3' => Yii::t('app', 'Office3'),
            'office4' => Yii::t('app', 'Other Office'),
            'calling_code3' => Yii::t('app', 'Calling Code'),
            'fax1' => Yii::t('app', 'Fax1'),
            'fax2' => Yii::t('app', 'Fax2'),
            'fax3' => Yii::t('app', 'Fax3'),
            'fax4' => Yii::t('app', 'Other Fax'),
            'web_address' => Yii::t('app', 'Web Address'),
            'status' => Yii::t('app', 'Status'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
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
    
    public function getSocialMedias(){
        return $this->hasMany(SocialMediaLink::className(), ['model_id' => 'id'])->andOnCondition(['model' => StringHelper::basename($this->className())]);
    } 
    /**
     * @inheritdoc
     * @return SellerCompanyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SellerCompanyQuery(get_called_class());
    }
}
