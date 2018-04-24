<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%advertisement}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $description
 * @property integer $no_of_banner
 * @property string $profile_ids
 * @property string $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 * @property AdvertisementBanner[] $advertisementBanners
 * @property AdvertisementLocation[] $advertisementLocations
 */
class Advertisement extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    
//    public $locations;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%advertisement}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['link', 'status'], 'required'],
            [['user_id', 'no_of_banner', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['profileIds', 'locations'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['link'], 'url', 'defaultScheme' => 'http'],
            [['profile_ids'], 'string', 'max' => 50],
            [['status'], 'string', 'max' => 15],
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
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'link' => Yii::t('app', 'Link'),
            'no_of_banner' => Yii::t('app', 'No Of Banner'),
            'profile_ids' => Yii::t('app', 'Profiles'),
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisementBanners()
    {
        return $this->hasMany(AdvertisementBanner::className(), ['ad_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisementLocations()
    {
        return $this->hasMany(AdvertisementLocation::className(), ['ad_id' => 'id']);
    }
    
    
    public function getLocations(){
        return \yii\helpers\ArrayHelper::getColumn($this->advertisementLocations, 'location_id');
    }
    
    public function setLocations($values){
        if($this->isNewRecord){
            return;
        }
        AdvertisementLocation::deleteAll(['ad_id' => $this->id]);
        if(empty($values)){
            return;
        }
        foreach ($values as $value){
            $adLocation = new AdvertisementLocation(); //instantiate new AdvertisementLocation model
            $adLocation->ad_id = $this->id;
            $adLocation->location_id = $value;
            $adLocation->save();
        }
    }

    public function getProfileIds()
    {
        return explode(',', $this->profile_ids);
    }
    
    public function setProfileIds($value)
    {
        $this->profile_ids = (is_array($value)?implode(',', $value):'');
    }
    
    public function getProfiles()
    {
        return Profile::find()->where(['in', 'id', $this->profileIds])->all();
    }
    
    /**
    * @inheritdoc
    * @return AdvertisementQuery the active query used by this AR class.
    */
    public static function find()
    {
        return new AdvertisementQuery(get_called_class());
    }
}
