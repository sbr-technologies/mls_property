<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%notification}}".
 *
 * @property integer $id
 * @property integer $shown_to
 * @property integer $sent_by
 * @property integer $read
 * @property string $type
 * @property string $data
 * @property string $target_path
 * @property string $icon_class
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $sentBy
 * @property User $shownTo
 */
class Notification extends \yii\db\ActiveRecord
{
    const STATUS_UNREAD = 0;
    const STATUS_READ = 1;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%notification}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shown_to', 'sent_by', 'type'], 'required'],
            [['shown_to', 'sent_by', 'read', 'created_at', 'updated_at'], 'integer'],
            [['type'], 'string', 'max' => 34],
            [['data'], 'string', 'max' => 512],
            ['read', 'default', 'value' => 0],
            [['target_path'], 'string', 'max' => 255],
            [['icon_class'], 'string', 'max' => 128],
            [['sent_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['sent_by' => 'id']],
            [['shown_to'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['shown_to' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'shown_to' => Yii::t('app', 'Shown To'),
            'sent_by' => Yii::t('app', 'Sent By'),
            'read' => Yii::t('app', 'Read'),
            'type' => Yii::t('app', 'Type'),
            'data' => Yii::t('app', 'Data'),
            'target_path' => Yii::t('app', 'Target Path'),
            'icon_class' => Yii::t('app', 'Icon Class'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    public function behaviors() {
        parent::behaviors();
        return [TimestampBehavior::className()];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSentBy()
    {
        return $this->hasOne(User::className(), ['id' => 'sent_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShownTo()
    {
        return $this->hasOne(User::className(), ['id' => 'shown_to']);
    }
    
    
    
    public static function add($to, $type, $data = "", $targetPath = "", $icon = "" , $sentBy = null) {
        $notification = new self();
        $notification->shown_to = $to;
        $notification->sent_by = !empty($sentBy) ? $sentBy: Yii::$app->user->id;
        $notification->type = $type;
        $notification->data = $data;
        $notification->target_path = json_encode($targetPath);
        $notification->icon_class = $icon;
        $notification->save();
    }

    public function searchAll() {
        $notifications = static::find()->where(['shown_to' => Yii::$app->user->id, 'read' => static::STATUS_UNREAD])->andWhere(['is not', 'sent_by', null])->orderBy(["id" => SORT_DESC])->all();
        // let's load the config only once. 
        // if we put this into the prepareNotification(), then 
        // it will get loaded multiple times. Not gonna do that.
        $config = $this->loadLanguageFile();
        $allNotifications = [];
        foreach ($notifications as $notification) {
            if (!isset($config[$notification->type])) {
                throw new \yii\web\HttpException(400, $notification->type . ' not defined');
            }
            $params = @json_decode($notification->data, true);
            $targetPath = @json_decode($notification->target_path, true);

            $subject = $this->prepareNotification($config[$notification->type][0], $params);
            $message = $this->prepareNotification($config[$notification->type][1], $params);
            $allNotifications[] = [
                'id' => $notification->id,
                'message' => $message,
                'subject' => $subject,
                'target_path' => $targetPath,
                'sent_at' => $notification->created_at,
                'icon_class' => $notification->icon_class,
                'sent_by' => $notification->sentBy
            ];
        }
        return $allNotifications;
    }

    private function prepareNotification($message, $params) {
        foreach ($params as $key => $value) {
            $message = str_replace('{{' . $key . '}}', $value, $message);
        }
        return $message;
    }
    
    private function loadLanguageFile() {

        return require realpath(dirname(__FILE__) . "/../config/notifications.php");
    }
}
