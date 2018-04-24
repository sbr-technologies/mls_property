<?php

namespace common\models;

use Yii;



/**
 * This is the model class for table "{{%static_block_location_master}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $code
 * @property string $description
 *
 * @property StaticBlock[] $staticBlocks
 */
class StaticBlockLocationMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%static_block_location_master}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'code'], 'required'],
            [['title'], 'string', 'max' => 128],
            [['code'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 32],
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
            'code' => Yii::t('app', 'Code'),
            'description' => Yii::t('app', 'Description'),
        ];
    }
    
    public static function findByTitle($title){
        return static::find()->where(['title' => $title])->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaticBlocks()
    {
        return $this->hasMany(StaticBlock::className(), ['block_location_id' => 'id']);
    }
    
}