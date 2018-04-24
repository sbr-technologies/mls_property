<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%faq}}".
 *
 * @property integer $id
 * @property string $question
 * @property string $answer
 * @property string $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 */
class Faq extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%faq}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question', 'answer', 'status'], 'required'],
            [['question', 'answer'], 'string'],
            [['created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
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
            'question' => Yii::t('app', 'Question'),
            'answer' => Yii::t('app', 'Answer'),
            'status' => Yii::t('app', 'Status'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    /**
    * @inheritdoc
    * @return FaqQuery the active query used by this AR class.
    */
    public static function find()
    {
        return new FaqQuery(get_called_class());
    }
    
}
