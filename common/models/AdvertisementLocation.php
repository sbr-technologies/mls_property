<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%advertisement_location}}".
 *
 * @property integer $id
 * @property integer $ad_id
 * @property integer $location_id
 * @property string $status
 *
 * @property AdvertisementLocationMaster $location
 * @property Advertisement $ad
 */
class AdvertisementLocation extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%advertisement_location}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ad_id', 'location_id'], 'required'],
            [['ad_id', 'location_id'], 'integer'],
            [['status'], 'string', 'max' => 15],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            [['location_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdvertisementLocationMaster::className(), 'targetAttribute' => ['location_id' => 'id']],
            [['ad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Advertisement::className(), 'targetAttribute' => ['ad_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ad_id' => Yii::t('app', 'Ad ID'),
            'location_id' => Yii::t('app', 'Location ID'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(AdvertisementLocationMaster::className(), ['id' => 'location_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAd()
    {
        return $this->hasOne(Advertisement::className(), ['id' => 'ad_id']);
    }
    
    /**
    * @inheritdoc
    * @return AdvertisementLocationQuery the active query used by this AR class.
    */
    public static function find()
    {
        return new AdvertisementLocationQuery(get_called_class());
    }
    
}

