<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%holiday_package_category}}".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $title
 * @property string $description
 * @property string $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property HolidayPackage[] $holidayPackages
 * @property HolidayPackageCategory $parent
 * @property HolidayPackageCategory[] $holidayPackageCategories
 * @property HotelEnquiry[] $hotelEnquiries
 */
class HolidayPackageCategory extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%holiday_package_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['title', 'status'], 'required'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['status'], 'string', 'max' => 15],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => HolidayPackageCategory::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
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
    public function getHolidayPackages()
    {
        return $this->hasMany(HolidayPackage::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(HolidayPackageCategory::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHolidayPackageCategories()
    {
        return $this->hasMany(HolidayPackageCategory::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHotelEnquiries()
    {
        return $this->hasMany(HotelEnquiry::className(), ['hotel_id' => 'id']);
    }
    public function behaviors() {
        parent::behaviors();
        return [TimestampBehavior::className(), BlameableBehavior::className()];
    }
    
    /**
    * @inheritdoc
    * @return HolidayPackageCategoryQuery the active query used by this AR class.
    */
    public static function find()
    {
        return new HolidayPackageCategoryQuery(get_called_class());
    }
}
