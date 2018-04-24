<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use common\models\Message;
use frontend\models\Common;
use common\models\Contact;
use common\components\MailSend;
use common\models\EmailSentLog;
use common\models\EmailSentLogSearch;
use frontend\helpers\AuthHelper;
use yii\helpers\ArrayHelper;
use common\models\Agent;

class EmailController extends \yii\web\Controller {
    
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
//                'only' => ['inbox', 'compose', 'sent', 'view'],
                'rules' => [
                    [
//                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action) {
        if ($this->action->id == 'download-zip' || $this->action->id == 'upload') {
            Yii::$app->controller->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionCompose($recipientId = NULL) {
        $model = new Message();
        $sender = Yii::$app->user->identity;
        $senderInfo = $sender->commonName;
        if($sender->agency_id){
            $companyModel = \common\models\Agency::findOne($sender->agency_id);
        }
        if(!empty($companyModel)){
            $senderInfo .= '<br/>'.$companyModel->name;
        }
        $messagePost = Yii::$app->request->post('Message');
        if ($messagePost) {
            $user = Yii::$app->user->identity;
            $to = $messagePost['to'];
            $adminMessage = false;
            $to = explode(',', $to);
            $msgContent = @Common::cleanInput($messagePost['message']);
            $msgSubject = @Common::cleanInput($messagePost['subject']);
            if (!empty($msgContent) && !empty($to) && !empty($msgSubject)) {
                $contacts = Contact::find()->where(['id' => $to])->all();
                if (!empty($contacts)) {
                    foreach ($contacts as $contact) {
                        $logModel = new EmailSentLog();
                        $logModel->sent_by = $user->id;
                        $logModel->contact_id = $contact->id;
                        $logModel->subject = $msgSubject;
                        $logModel->content = $msgContent;
                        $logModel->type = 'Manual';
                        $logModel->status = 'sent';
                        if(!$logModel->save()){
                            print_r($logModel->errors);
                            die();
                        }
                        
                        $ar = [];
                        $ar['{{%NAME%}}'] = $contact->fullName;
                        $ar['{{%SENDER_NAME%}}'] = $sender->commonName;
                        $ar['{{%SUBJECT%}}'] = $msgSubject;
                        $ar['{{%MESSAGE%}}'] = $msgContent;
                        $ar['{{%SENDER_INFO%}}'] = $senderInfo;
                        MailSend::sendMail('NEW_EMAIL_MESSAGE_RECEIVED', $contact->email, $ar);
                    }
                }
                Yii::$app->session->setFlash('success', 'Your message has been sent');
                return $this->refresh();
            }
        }
        
        return $this->render('compose', [
                    'model' => $model, 'recipient' => ''
        ]);
    }

    public function actionUpload() {
        if (isset($_FILES['message_upload_file'])) {
            $whitelist = \common\models\SiteConfig::multiSetting("allowed_ext_doc");
            $file = $_FILES['message_upload_file'];
            $name = $oname = basename($file['name']);
            $tmpName = $file['tmp_name'];
            $error = $file['error'];

            if ($error === UPLOAD_ERR_OK) {
                $extension = pathinfo($name, PATHINFO_EXTENSION);
                if (!in_array($extension, $whitelist)) {
                    $error = Yii::t('app', 'Invalid file type uploaded. Only ' . implode(', ', $whitelist) . ' are allowed');
                } else {
                    $fname = pathinfo($name, PATHINFO_FILENAME) . "_" . strtotime("now");
                    $name = $fname . "." . $extension;
                    @move_uploaded_file($tmpName, Yii::getAlias('@uploads/tmp/' . $name));
                }
            }
            echo json_encode(['hash' => Common::stEncrypt($name), 'oname' => $oname,
                'error' => $error]);
        }
    }
    
    public function actionSentMails(){
        $searchModel = new EmailSentLogSearch();
        $user = Yii::$app->user->identity;
        $agency = [];
        if(AuthHelper::is('agency')){
            $agency = $user->agency;
            $agents = ArrayHelper::getColumn(Agent::find()->where(['agency_id' => $agency->id])->active()->all(), 'id');
//            print_r($agents);die();
            if(!empty($agents)){
                $searchModel->ownerIdIn = $agents;
            }else{
                $searchModel->ownerIdIn = [0];
            }
        }else{
            $searchModel->ownerIdIn = $user->id;
        }
        $searchModel->type = 'Manual';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('sent-mails', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel
        ]);
    }
}
