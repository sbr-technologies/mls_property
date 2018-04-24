<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Box;
use common\models\UserConfig;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

use common\components\MailSend;
use common\components\Sms;
use common\models\EmailTemplate;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property integer $profile_id
 * @property string $salutation
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $username
 * @property string $short_name
 * @property double $lat
 * @property double $lng
 * @property string $location
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $mobile1
 * @property string $calling_code
 * @property integer $gender
 * @property string $dob
 * @property string $zip_code
 * @property string $tagline
 * @property string $email_activation_key
 * @property string $otp
 * @property integer $phone_verified
 * @property integer $email_verified
 * @property integer $email_activation_sent
 * @property string $avg_rating
 * @property integer $total_reviews
 * @property string $ip_address
 * @property integer $membership_id
 * @property string $street_address
 * @property string $street_number
 * @property string $town
 * @property string $country
 * @property string $social_id
 * @property string $social_type
 * @property string $slug
 * @property string $timezone
 * @property integer $is_login_blocked
 * @property string $login_blocked_at
 * @property integer $failed_login_cnt
 * @property string $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Advertisement[] $advertisements
 * @property BlogPost[] $blogPosts
 * @property HolidayPackageBooking[] $holidayPackageBookings
 * @property HolidayPackageEnquiry[] $holidayPackageEnquiries
 * @property HotelBooking[] $hotelBookings
 * @property HotelEnquiry[] $hotelEnquiries
 * @property LoginLog[] $loginLogs
 * @property Notification[] $notifications
 * @property Notification[] $notifications0
 * @property Property[] $properties
 * @property Profile $profile
 * @property UserConfig[] $userConfigs
 */
class User extends ActiveRecord implements IdentityInterface {

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_PENDING = 'pending';
    const STATUS_DELETED = 'deleted';
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    public $rawPassword;
    public $passwordRepeat;
    public $location;
    public $profileImage;
    public $socialProfile;
    public $authKey;

    const THUMBNAIL = '-150X150';
    const MEDIUM = '-300X300';
    const LARGE = '-640X640';
    const FULL = '';
    const SCENARIO_LOGIN = 'login';
    const SCENARIO_REGISTER = 'register';
    const SCENARIO_UPDATE_PASSWORD = 'update_password';
    const PROFILE_SUPERADMIN = 1;
    const PROFILE_ADMIN = 2;
    const PROFILE_BUYER = 3;
    const PROFILE_SELLER = 4;
    const PROFILE_AGENT = 5;
    const PROFILE_HOTEL = 6;
    const PROFILE_AGENCY = 7;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            TimestampBehavior::className(),
//            [
//                'class' => SluggableBehavior::className(),
////                'attribute' => 'title',
//                // 'slugAttribute' => 'slug',
//                'ensureUnique' => true,
//                'value' => function($event){
//                    if(!empty($event->sender->slug)){
//                        return $event->sender->slug;
//                    }
//                    return Inflector::slug($event->sender->first_name.$event->sender->last_name, '');
//                },
//            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['profile_id', 'agency_id', 'gender', 'phone_verified', 'email_verified', 'email_activation_sent', 'total_reviews', 'membership_id', 'is_login_blocked', 'failed_login_cnt', 'created_by', 'updated_by', 'created_at', 'updated_at', 'total_recommendations'], 'integer'],
            [['first_name', 'email', 'status'], 'required'],
            ['email', 'email'],
            ['email', 'unique'],
            ['slug', 'unique'],
            [['lat', 'lng', 'avg_rating', 'broker_is_agent'], 'number'],
            [['birthday', 'login_blocked_at', 'rawPassword'], 'safe'],
            [['salutation', 'slug', 'exp_year'], 'string', 'max' => 20],
            [['first_name', 'middle_name', 'last_name', 'street_address', 'street_number'], 'string', 'max' => 128],
            [['urban_town_area', 'appartment_unit', 'local_govt_area', 'sub_area', 'username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'specialization', 'area_served', 'brokerage', 'about'], 'string', 'max' => 255],
            [['short_name', 'social_type'], 'string', 'max' => 50],
            [['mobile1'], 'string', 'max' => 20],
            [['occupation_other','occupation'], 'string', 'max' => 125],
            [['calling_code', 'zip_code', 'status'], 'string', 'max' => 15],
            [['tagline', 'social_id', 'agentID'], 'string', 'max' => 100],
            [['profileImage'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 1],
            [['profile_image_extension'], 'string', 'max' => 5],
            [['email_activation_key', 'mobile2', 'mobile3', 'mobile4', 'calling_code2', 'calling_code3', 'calling_code4', 'office1', 'office2', 'office3', 'office4', 'fax1', 'fax2', 'fax3', 'fax4','price_range'], 'string', 'max' => 35],
            ['ip_address', 'default', 'value' => Yii::$app->request->getUserIP()],
            [['otp'], 'string', 'max' => 6],
            [['workedWiths'], 'safe'],
            [['worked_with'], 'string', 'max' => 50],
            [['town', 'country', 'state', 'area', 'intrest_in','district'], 'string', 'max' => 75],
            [['timezone'], 'string', 'max' => 60],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profile_id' => 'id']],
            [['phone_verified', 'email_verified', 'total_reviews'], 'default', 'value' => 0],
            [['rawPassword', 'passwordRepeat'], 'required', 'on' => self::SCENARIO_UPDATE_PASSWORD],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'rawPassword', 'message' => "Passwords don't match", 'skipOnEmpty' => true],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_PENDING, self::STATUS_DELETED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'profile_id' => Yii::t('app', 'Profile'),
            'agentID' => Yii::t('app', 'Agent ID'),
            'sellerID' => Yii::t('app', 'Seller ID'),
            'hotelOwnerID' => Yii::t('app', 'Hotel Owner ID'),
            'buyerID' => Yii::t('app', 'Buyer ID'),
            'agency_id' => Yii::t('app', 'Agency Name'),
            'salutation' => Yii::t('app', 'Salutation'),
            'first_name' => Yii::t('app', 'First Name'),
            'middle_name' => Yii::t('app', 'Middle Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'username' => Yii::t('app', 'Username'),
            'short_name' => Yii::t('app', 'Short Name'),
            'lat' => Yii::t('app', 'Lat'),
            'lng' => Yii::t('app', 'Lng'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email' => Yii::t('app', 'Email'),
            'mobile1' => Yii::t('app', 'Mobile1'),
            'calling_code' => Yii::t('app', 'Calling Code'),
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
            'calling_code4' => Yii::t('app', 'Calling Code'),
            'gender' => Yii::t('app', 'Gender'),
            'dob' => Yii::t('app', 'Birthday'),
            'zip_code' => Yii::t('app', 'Zip Code'),
            'tagline' => Yii::t('app', 'Tagline'),
            'profile_image_file_name' => Yii::t('app', 'Profile Image File Name'),
            'profile_image_extension' => Yii::t('app', 'Profile Image Extension'),
            'email_activation_key' => Yii::t('app', 'Email Activation Key'),
            'otp' => Yii::t('app', 'Otp'),
            'phone_verified' => Yii::t('app', 'Phone Verified'),
            'email_verified' => Yii::t('app', 'Email Verified'),
            'email_activation_sent' => Yii::t('app', 'Email Activation Sent'),
            'avg_rating' => Yii::t('app', 'Avg Rating'),
            'total_reviews' => Yii::t('app', 'Total Reviews'),
            'ip_address' => Yii::t('app', 'Ip Address'),
            'membership_id' => Yii::t('app', 'Membership ID'),
            'street_address' => Yii::t('app', 'Street Name'),
            'street_number' => Yii::t('app', 'House Number'),
            'town' => Yii::t('app', 'Town'),
            'appartment_unit' => Yii::t('app', 'Apt/Unit/Suite #'),
            'area' => Yii::t('app', 'Area'),
            'state' => Yii::t('app', 'State'),
            'state_long' => Yii::t('app', 'State'),
            'country' => Yii::t('app', 'Country'),
            'social_id' => Yii::t('app', 'Social ID'),
            'social_type' => Yii::t('app', 'Social Type'),
            'slug' => Yii::t('app', 'Slug'),
            'timezone' => Yii::t('app', 'Timezone'),
            'is_login_blocked' => Yii::t('app', 'Is Login Blocked'),
            'login_blocked_at' => Yii::t('app', 'Login Blocked At'),
            'failed_login_cnt' => Yii::t('app', 'Failed Login Cnt'),
            'workedWiths' => Yii::t('app', 'Worked With'),
            'team_id' => Yii::t('app', 'Team'),
            'intrest_in' => Yii::t('app', 'interest in'),
            'status' => Yii::t('app', 'Status'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'occupation' => Yii::t('app', 'Occupation'),
            'occupation_other' => Yii::t('app', 'Other'),
            'price_range' =>  Yii::t('app', 'Activity Range'),
            'genderText' => 'Gender',
            'payment_type_id' => 'Payment Type'
            
        ];
    }

    public function beforeSave($insert) {
        parent::beforeSave($insert);

        if($this->street_address && $this->town && $this->state){
            $locationLat    =   null;//9.0765° N, 7.3986° E
            $locationLng    =   null;
            $addressData = implode(', ', array_filter([$this->street_number, $this->street_address, $this->area, $this->town,$this->state, $this->country]));
            $location =  file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=". urlencode($addressData) ."&key=".Yii::$app->params['googleMapKey']."");
            $locationObj = json_decode($location);
            //\yii\helpers\VarDumper::dump($locationObj,12,125); exit;
            if(!empty($locationObj->results[0]->geometry->location)){
                $locationLat    =   $locationObj->results[0]->geometry->location->lat;
                $locationLng    =   $locationObj->results[0]->geometry->location->lng;
            }
            //\yii\helpers\VarDumper::dump($locationLat."++".$locationLng); exit;
            $this->lat = $locationLat;
            $this->lng = $locationLng;
        }
        
        if ($insert) {
            $i = 1;
            $slug = Inflector::slug($this->first_name . $this->last_name, '');
            while (self::find()->where(['slug' => $slug])->exists()) {
                $slug = $slug . $i;
                $i++;
            }
            $this->slug = $slug;

            if (Yii::$app->session->has('tz')) {
                $this->timezone = Yii::$app->session->get('tz');
            }
        }

        if ($insert && empty($this->rawPassword)) {
            $this->rawPassword = Yii::$app->security->generateRandomString(6);
            $this->password = $this->rawPassword;
        }
        if ($this->scenario == self::SCENARIO_UPDATE_PASSWORD) {
            $this->password = $this->rawPassword;
        }
        return true;
    }

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            $end = $this->id;
            $start = '';
            $characters = range('0', '9');
            for ($i = 0; $i < 16 - strlen((string) $end); $i++) {
                $rand = mt_rand(0, count($characters) - 1);
                $start .= $characters[$rand];
            }
            $this->mls_id = $start . $end;
            $this->save();

            /* if ($this->profile_id == self::PROFILE_AGENT) {
                $end = $this->id;
                $start = 'A';
                $characters = range('0', '9');
                for ($i = 0; $i < 8 - strlen((string) $end); $i++) {
                    $rand = mt_rand(0, count($characters) - 1);
                    $start .= $characters[$rand];
                }
                $this->agentID = $start . $end;
                $this->save();
            } */
        }
        if ($this->profile_id == self::PROFILE_AGENT || ($this->profile_id == self::PROFILE_AGENCY && $this->broker_is_agent)) {
            if ($this->agentID == NULL) {
                $end = $this->id;
                $start = 'A';
                $characters = range('0', '9');
                for ($i = 0; $i < 8 - strlen((string) $end); $i++) {
                    $rand = mt_rand(0, count($characters) - 1);
                    $start .= $characters[$rand];
                }
                $this->agentID = $start . $end;
                $this->save();
            }
            if(isset($changedAttributes['agency_id']) && $changedAttributes['agency_id']){
                    $oldAgency = Agency::findOne($changedAttributes['agency_id']);
                    $oldAgency->updateCounters(['total_agents' => -1]);
            }
            if($this->agency_id && isset($changedAttributes['agency_id'])){
                $agencyModel = Agency::findOne($this->agency_id);
                $agencyModel->updateCounters(['total_agents' => 1]);
            }
        }elseif ($this->profile_id == self::PROFILE_SELLER) {
            if ($this->sellerID == NULL) {
                $end = $this->id;
                $start = 'S';
                $characters = range('0', '9');
                for ($i = 0; $i < 8 - strlen((string) $end); $i++) {
                    $rand = mt_rand(0, count($characters) - 1);
                    $start .= $characters[$rand];
                }
                $this->sellerID = $start . $end;
                $this->save();
            }
        }elseif ($this->profile_id == self::PROFILE_HOTEL) {
            if ($this->hotelOwnerID == NULL) {
                $end = $this->id;
                $start = 'H';
                $characters = range('0', '9');
                for ($i = 0; $i < 8 - strlen((string) $end); $i++) {
                    $rand = mt_rand(0, count($characters) - 1);
                    $start .= $characters[$rand];
                }
                $this->hotelOwnerID = $start . $end;
                $this->save();
            }
        }elseif ($this->profile_id == self::PROFILE_BUYER) {
            if ($this->buyerID == NULL) {
                $end = $this->id;
                $start = 'B';
                $characters = range('0', '9');
                for ($i = 0; $i < 8 - strlen((string) $end); $i++) {
                    $rand = mt_rand(0, count($characters) - 1);
                    $start .= $characters[$rand];
                }
                $this->buyerID = $start . $end;
                $this->save();
            }
        }
    }

    public function getAgentSocialMedias(){
        return $this->hasMany(SocialMediaLink::className(), ['model_id' => 'id'])->andOnCondition(['model' => StringHelper::basename($this->className())]);
    }
    
    public function getWorkedWiths() {
        return explode(',', $this->worked_with);
    }

    public function setWorkedWiths($value) {
        $this->worked_with = (is_array($value) ? implode(',', $value) : '');
    }

    public function getRandomPassword() {
        return Yii::$app->security->generateRandomString(8);
    }

    public function getAgentID(){
        return $this->agentID;
    }

    public function getEmailAddress() {
        $email = trim($this->email, '.');

        return $email;
    }

    public function getStatusText() {
        if ($this->status == self::STATUS_ACTIVE) {
            return 'Active';
        } elseif ($this->status == self::STATUS_INACTIVE) {
            return 'Inactive';
        } elseif ($this->status == self::STATUS_PENDING) {
            return 'Pending';
        }
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        if (Yii::$app->getSession()->has('user-' . $id)) {
            return new self(Yii::$app->getSession()->get('user-' . $id));
        } else {
            return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
        }
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByEmail($email) {
        //print_r($email);exit;
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findBySlug($slug) {
        return static::findOne(['slug' => $slug, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisements() {
        return $this->hasMany(Advertisement::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogPosts() {
        return $this->hasMany(BlogPost::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHolidayPackageBookings() {
        return $this->hasMany(HolidayPackageBooking::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHolidayPackageEnquiries() {
        return $this->hasMany(HolidayPackageEnquiry::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHotelBookings() {
        return $this->hasMany(HotelBooking::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHotelEnquiries() {
        return $this->hasMany(HotelEnquiry::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoginLogs() {
        return $this->hasMany(LoginLog::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotifications() {
        return $this->hasMany(Notification::className(), ['sent_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotifications0() {
        return $this->hasMany(Notification::className(), ['shown_to' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperties() {
        return $this->hasMany(Property::className(), ['user_id' => 'id']);
    }

//    public function getPropertyMaxPrice(){	
//        return Yii::$app->db->createCommand('select max(price) as max_price from mls_property WHERE user_id='.$this->id)->queryOne();
//    }
//    public function getPropertyMinPrice(){	
//        return Yii::$app->db->createCommand('select min(price) as min_price from mls_property WHERE user_id='.$this->id)->queryOne();
//    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile() {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }

    public function getAgency() {
        return $this->hasOne(Agency::className(), ['id' => 'agency_id']);
    }

    public function getSellerCompany() {
        return $this->hasOne(SellerCompany::className(), ['user_id' => 'id']);
    }

    public function getTeamName() {
        return $this->hasOne(Team::className(), ['id' => 'team_id']);
    }
    public function getWorkSheet() {
        return $this->hasOne(BuyerWorkSheet::className(), ['user_id' => 'id']);
    }
    public function getWorkSheetFeatures() {
        return $this->hasMany(BuyerWorkSheetFeature::className(), ['user_id' => 'id']);
    }
    public function getWorkSheetPropertyAmenities() {
        return $this->hasMany(BuyerWorkSheetPropertyAmenities::className(), ['user_id' => 'id']);
    }
    public function getWorkSheetPropertyTypes() {
        return $this->hasMany(BuyerWorkSheetPropertyType::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserConfigs() {
        return $this->hasMany(UserConfig::className(), ['user_id' => 'id']);
    }

    /**
     * Relations section end
     */
    public function getImageUrl($size = self::FULL) {
        if (empty($this->profile_image_file_name)) {
            return Yii::getAlias('@uploadsUrl/banner_image/add-photo-img.jpg');
        }
        return Yii::getAlias('@uploadsUrl/' . "User/{$this->profile_image_file_name}{$size}.{$this->profile_image_extension}");
    }

    public function getImageFile($size = self::FULL) {
        return $this->profile_image_file_name ? Yii::getAlias('@uploadsPath/' . "User/{$this->profile_image_file_name}{$size}.{$this->profile_image_extension}") : null;
    }

    public function getCoverPhotoUrl() {
        //\yii\helpers\VarDumper::dump($this->cover_photo);
        if (empty($this->cover_photo)) {
            return Yii::getAlias('@web/' . "images/profile-cover-img.jpg");
        }
        return Yii::getAlias('@uploadsUrl/' . "User/{$this->cover_photo}");
    }

    public function uploadImage() {
        // get the uploaded file instance. for multiple file uploads
        // the following data will return an array (you may need to use
        // getInstances method)
        $profileImage = UploadedFile::getInstance($this, 'profileImage');

        // if no image was uploaded abort the upload
        if (empty($profileImage)) {
            return false;
        }

        // generate a unique file name
        $this->profile_image_file_name = Yii::$app->security->generateRandomString() . '-' . time();
        $this->profile_image_extension = $profileImage->extension;
        // the uploaded image instance
        return $profileImage;
    }

    public function resizeImage() {
        $file = $this->getImageFile();
        $fileLarge = $this->getImageFile(self::LARGE);
        $fileMedium = $this->getImageFile(self::MEDIUM);
        $fileThumb = $this->getImageFile(self::THUMBNAIL);
        Image::getImagine()->open($file)->thumbnail(new Box(640, 640))->save($fileLarge, ['quality' => 90]);
        Image::getImagine()->open($file)->thumbnail(new Box(300, 300))->save($fileMedium, ['quality' => 90]);
        Image::thumbnail($file, 150, 150)->save($fileThumb);
        Image::watermark($fileThumb, Yii::getAlias('@uploadsPath/watermark/watermark.png'), [6, 130])->save($fileThumb);
    }

    public function deleteImage() {
        // if deletion successful, reset your file attributes
        if (static::unlinkFiles($this->profile_image_file_name, $this->profile_image_extension) == false) {
            return false;
        }
        $this->profile_image_file_name = null;
        $this->profile_image_extension = null;
        return true;
    }

    public static function unlinkFiles($fileName, $fileExt) {

        $file = Yii::getAlias('@uploadsPath/' . "User/$fileName.{$fileExt}");
        $fileLarge = Yii::getAlias('@uploadsPath/' . "User/$fileName" . self::LARGE . ".{$fileExt}");
        $fileMedium = Yii::getAlias('@uploadsPath/' . "User/$fileName" . self::MEDIUM . ".{$fileExt}");
        $fileThumb = Yii::getAlias('@uploadsPath/' . "User/$fileName" . self::THUMBNAIL . ".{$fileExt}");

        // check if file exists on server
        if (empty($fileName) || !is_file($file) || !file_exists($file)) {
            return false;
        }
        // check if uploaded file can be deleted on server
        if (!unlink($file) || !unlink($fileLarge) || !unlink($fileMedium) || !unlink($fileThumb)) {
            return false;
        }
        return true;
    }

    public static function instantiate($row) {
        switch ($row['profile_id']) {
            case self::PROFILE_BUYER:
                return new Buyer();
            case self::PROFILE_SELLER:
                return new Seller();
            case self::PROFILE_AGENT:
			case self::PROFILE_AGENCY:
                return new Agent();
            case self::PROFILE_HOTEL:
                return new HotelOwner();
            case self::PROFILE_ADMIN:
                return new Admin();
            default:
                return new self;
        }
    }

    public function getFullName() {
        return ucwords(implode(' ', array_filter([$this->salutation, $this->first_name, $this->middle_name, $this->last_name])));
    }

    
    public function getCommonName() {
        return ucwords(implode(' ', array_filter([$this->first_name, $this->middle_name, $this->last_name])));
    }
    
    public function getNameLink($scheme = false) {
        return \yii\helpers\Html::a($this->fullName, \yii\helpers\Url::to(['user/view-profile', 'slug' => $this->slug], $scheme), ['target' => '_blank']);
    }
    public function getGenderText() {
        if (empty($this->gender)) {
            return null;
        }
        return ($this->gender == 1 ? 'Male' : 'Female');
    }
    
    public function setBirthday($dob) {
        if(empty($dob)){
            $this->dob = null;
        }else{
            $this->dob = date('Y-m-d', strtotime(str_replace('/', '-', $dob)));
        }
    }

    public function getBirthday() {
        if (!empty($this->dob)) {
            return Yii::$app->formatter->asDate($this->dob);
        }
        return null;
    }

    public function getPhoneNumber() {
        if (empty($this->mobile1)) {
            return null;
        }
        return "{$this->calling_code} {$this->mobile1}";
    }

    /*     * Used for New Registration Send Mail Start* */

    public function sendRegistrationMail() {
        $template = EmailTemplate::findOne(['code' => 'NEW_USER_REGISTRATION']);
        $ar['{{%FULL_NAME%}}']        = $this->fullName;
        $ar['{{%USER_EMAIL%}}']       = $this->email;
        $ar['{{%USER_PASSWORD%}}']    = $this->rawPassword;

        MailSend::sendMail('NEW_USER_REGISTRATION', $this->email, $ar);
//        return Yii::$app
//            ->mailer
//            ->compose(
//                    ['html' => 'newUserRegistration-html'], ['user' => $this]
//            )
//            //->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
//            ->setTo($this->email)
//            ->setSubject('New Registration Form for ' . Yii::$app->name)
//            ->send();
    }

    /*     * Used for Change Passwords Send Mail Start* */

    public function sendChangePasswordMail() {
        $template = EmailTemplate::findOne(['code' => 'CHANGE_PASSWORD']);
        $ar['{{%FULL_NAME%}}']        = $this->fullName;
        $ar['{{%USER_EMAIL%}}']       = $this->email;
        $ar['{{%USER_PASSWORD%}}']    = $this->rawPassword;

        MailSend::sendMail('CHANGE_PASSWORD', $this->email, $ar);
//        return Yii::$app
//            ->mailer
//            ->compose(
//                    ['html' => 'changePassword-html'], ['user' => $this]
//            )
//            //->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
//            ->setTo($this->email)
//            ->setSubject('Change Password Form for ' . Yii::$app->name)
//            ->send();
    }

    public function generateEmailActivationKey() {
        $this->email_activation_key = Yii::$app->security->generateRandomString();
    }

    public function getConfigItem($key, $default = NULL) {
        $userConfigs = $this->userConfigs;
        foreach ($userConfigs as $userConfig) {
            if (isset($userConfig->key) && $userConfig->key == $key) {
                return $userConfig->value;
            }
        }
        return $default;
    }

    public function getTimeZone() {
        return $this->timezone ? $this->timezone : 'Asia/Kolkata';
    }

    public static function findByMlsId($mlsId) {
        return static::find()->where(['mls_id' => $mlsId])->active()->one();
    }

    public function getFormattedAddress(){
		$addr = implode(' ', array_filter([$this->street_number, $this->street_address]));
		if($this->appartment_unit){
			$addr = $addr. ', #'. $this->appartment_unit;
		}
        return implode(', ', array_filter([$addr, $this->area, $this->town, $this->state]));
    }

    public function getShortAddress() {
        return $this->town . " " . $this->state . "," . $this->country . " - " . $this->zip_code;
    }

    public function getDashboardUrl() {
        $profileSetup = $this->getConfigItem('profileSetup', 'yes');
        $redirectUrl = NULL;
        switch ($this->profile_id) {
            case self::PROFILE_BUYER:
                $params = 'buyer/dashboard';
                if ($profileSetup == 'no') {
                    $params = 'buyer/profile';
                }
                $redirectUrl = Yii::$app->urlManager->createUrl($params);
                break;
            case self::PROFILE_SELLER:
                $params = 'seller/dashboard';
                if ($profileSetup == 'no') {
                    $params = 'seller/profile';
                }
                $redirectUrl = Yii::$app->urlManager->createUrl($params);
                break;
            case self::PROFILE_AGENT:
                $params = 'agent/dashboard';
                if ($profileSetup == 'no') {
                    $params = 'agent/profile';
                }
                $redirectUrl = Yii::$app->urlManager->createUrl($params);
                break;
            case self::PROFILE_HOTEL:
                $params = 'hotel-owner/dashboard';
                if ($profileSetup == 'no') {
                    $params = 'hotel-owner/profile';
                }
                $redirectUrl = Yii::$app->urlManager->createUrl($params);
                break;
            case self::PROFILE_AGENCY:
                $agencySetup = $this->getConfigItem('agencySetup', 'yes');
                $params = 'agency/dashboard';
                if ($profileSetup == 'no' || $agencySetup == 'no') {
                    $params = 'agency/profile';
                }
                $redirectUrl = Yii::$app->urlManager->createUrl($params);
                break;
                
        }
        if ($redirectUrl)
            return $redirectUrl;
        return FALSE;
    }

    /**
     * @param \nodge\eauth\ServiceBase $service
     * @return User
     * @throws ErrorException
     */
    public static function findByEAuth($service) {
        if (!$service->getIsAuthenticated()) {
            throw new ErrorException('EAuth user should be authenticated before creating identity.');
        }

        $id = $service->getServiceName() . '-' . $service->getId();
        $attributes = array(
            'id' => $id,
            'username' => $service->getAttribute('name'),
            'authKey' => md5($id),
            'socialProfile' => $service->getAttributes(),
        );
        $attributes['socialProfile']['service'] = $service->getServiceName();
        Yii::$app->getSession()->set('user-' . $id, $attributes);
        return new self($attributes);
    }

    public static function findUserByEAuth($service) {
        if (!$service->getIsAuthenticated()) {
            throw new ErrorException('EAuth user should be authenticated before creating identity.');
        }
        return static::find()->where(['social_id' => $service->getId(), 'social_type' => $service->getServiceName()])->one();
    }

    public static function findByEAuthEmail($service) {
        if (!$service->getIsAuthenticated()) {
            throw new ErrorException('EAuth user should be authenticated before creating identity.');
        }
        $attributes = $service->getAttributes();
        if (isset($attributes['email']) && $attributes['email']) {
            $user = static::find()->where(['email' => $attributes['email']])->one();
            if (!empty($user)) {
                $user->social_id = $service->getId();
                $user->social_type = $service->getServiceName();
                $user->status = User::STATUS_ACTIVE;
                $user->save();
            }
            return $user;
        }
        return false;
    }
    
    public function getMobile1(){
        if(empty($this->mobile1)){
            return null;
        }
        return $this->calling_code. ' '. $this->mobile1;
    }
    
    public function getOffice1(){
        if(empty($this->office1)){
            return null;
        }
        return $this->calling_code. ' '. $this->office1;
    }
    
    public function getFax1(){
        if(empty($this->fax1)){
            return null;
        }
        return $this->calling_code. ' '. $this->fax1;
    }
    
    public function getMobile2(){
        if(empty($this->mobile2)){
            return null;
        }
        return $this->calling_code2. ' '. $this->mobile2;
    }
    
    public function getOffice2(){
        if(empty($this->office2)){
            return null;
        }
        return $this->calling_code2. ' '. $this->office2;
    }
    
    public function getFax2(){
        if(empty($this->fax2)){
            return null;
        }
        return $this->calling_code2. ' '. $this->fax2;
    }
    
    public function getMobile3(){
        if(empty($this->mobile3)){
            return null;
        }
        return $this->calling_code3. ' '. $this->mobile3;
    }
    
    public function getOffice3(){
        if(empty($this->office3)){
            return null;
        }
        return $this->calling_code3. ' '. $this->office3;
    }
    
    public function getFax3(){
        if(empty($this->fax3)){
            return null;
        }
        return $this->calling_code3. ' '. $this->fax3;
    }
    
    public function getMobile4(){
        if(empty($this->mobile4)){
            return null;
        }
        return $this->calling_code4. ' '. $this->mobile4;
    }
    
    public function getOffice4(){
        if(empty($this->office4)){
            return null;
        }
        return $this->calling_code4. ' '. $this->office4;
    }
    
    public function getFax4(){
        if(empty($this->fax4)){
            return null;
        }
        return $this->calling_code4. ' '. $this->fax4;
    }
    /**
     * @inheritdoc
     * @return TestimonialQuery the active query used by this AR class.
     */
    public static function find() {
        return new UserQuery(get_called_class());
    }

}
