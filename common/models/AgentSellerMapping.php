<?php

namespace common\models;

use Yii;

use common\components\MailSend;
use common\components\Sms;
use common\models\EmailTemplate;

/**
 * This is the model class for table "{{%agent_seller_mapping}}".
 *
 * @property integer $id
 * @property integer $agent_id
 * @property integer $seller_id
 *
 * @property User $agent
 * @property User $seller
 */
class AgentSellerMapping extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%agent_seller_mapping}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['agent_id', 'seller_id'], 'required'],
            [['agent_id', 'seller_id'], 'integer'],
            ['agent_id', 'unique', 'targetAttribute' => ['agent_id', 'seller_id']],
            [['agent_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['agent_id' => 'id']],
            [['seller_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['seller_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'agent_id' => Yii::t('app', 'Agent ID'),
            'seller_id' => Yii::t('app', 'Seller ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgent()
    {
        return $this->hasOne(User::className(), ['id' => 'agent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeller()
    {
        return $this->hasOne(User::className(), ['id' => 'seller_id']);
    }

    /**Used for Change Passwords Send Mail Start**/
    
    public function sendAssignSellerMail(){
        $template = EmailTemplate::findOne(['code' => 'ASSIGN_SELLER']);
        $ar['{{%FULL_NAME%}}']          = $this->seller->fullName;
        $ar['{{%AGENT_FULL_NAME%}}']    = $this->agent->fullName;
        
        MailSend::sendMail('ASSIGN_SELLER', $this->seller->email, $ar);
//         return Yii::$app
//            ->mailer
//            ->compose(
//                ['html' => 'assignSeller-html'],
//                ['sellerMap' => $this]
//            )
//            //->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
//            ->setTo($this->seller->email)
//            ->setSubject('Assign Seller Form for ' . Yii::$app->name)
//            ->send();
    }
    /**
     * @inheritdoc
     * @return AgentSellerMappingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AgentSellerMappingQuery(get_called_class());
    }
}
