<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use Yii;

/**
 * This is the model class for table "{{%message_attachments}}".
 *
 * @property integer $id
 * @property string $filename
 * @property string $message_id
 * @property integer $created_at
 *
 * @property Messages $message
 */
class MessageAttachment extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%message_attachment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['filename', 'message_id', 'created_at'], 'required'],
            [['message_id', 'created_at'], 'integer'],
            [['filename'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'filename' => Yii::t('app', 'Filename'),
            'message_id' => Yii::t('app', 'Message ID'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessage() {
        return $this->hasOne(Message::className(), ['id' => 'message_id']);
    }

    public function getGoodFilename() {
        return preg_replace('/(\\_\\d+\\.)/', '.', $this->filename);
    }
    
    public function getFileUrl(){
        return Yii::getAlias("@uploadBaseUrl/message_documents/". $this->filename);
    }

}
