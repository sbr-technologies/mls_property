<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%hotel_facility_master}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $status
 */
class HotelFacilityMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%hotel_facility_master}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
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
            'name' => Yii::t('app', 'Name'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @inheritdoc
     * @return HotelFacilityMasterQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new HotelFacilityMasterQuery(get_called_class());
    }
}
