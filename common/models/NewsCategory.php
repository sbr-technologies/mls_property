<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

use yii\helpers\StringHelper;

/**
 * This is the model class for table "{{%news_category}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property News[] $news
 */
class NewsCategory extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug', 'status'], 'required'],
            [['created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 15],
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
            'name' => Yii::t('app', 'Name'),
            'slug' => Yii::t('app', 'Slug'),
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
    public function getNews()
    {
        return $this->hasMany(News::className(), ['news_category_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return NewsCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NewsCategoryQuery(get_called_class());
    }
    
    public static function findByName($name){
        return static::find()->where(['name' => $name])->active()->one();
    }
}
