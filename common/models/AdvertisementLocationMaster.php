<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%advertisement_location_master}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $page
 * @property string $section
 * @property string $status
 *
 * @property AdvertisementLocation[] $advertisementLocations
 */
class AdvertisementLocationMaster extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%advertisement_location_master}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['page', 'status'], 'required'],
            [['title'], 'string', 'max' => 100],
            [['page', 'section'], 'string', 'max' => 128],
            [['status'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'page' => Yii::t('app', 'Page'),
            'section' => Yii::t('app', 'Section'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisementLocations()
    {
        return $this->hasMany(AdvertisementLocation::className(), ['location_id' => 'id']);
    }
    
    public function getAdvertisements()
    {
        return $this->hasMany(Advertisement::className(), ['id' => 'ad_id'])->viaTable('{{%advertisement_location}}', ['location_id' => 'id']);
    }
    
    /**
    * @inheritdoc
    * @return AdvertisementLocationMasterQuery the active query used by this AR class.
    */
    public static function find()
    {
        return new AdvertisementLocationMasterQuery(get_called_class());
    }
    
}
