<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use common\models\Message;
use common\models\MessageRecipient;
use common\models\MessageAttachment;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use frontend\models\Common;
use common\models\User;
use common\models\Notification;

use common\components\MailSend;
use common\components\Sms;
use common\models\EmailTemplate;
use yii\web\Response;
class MessageController extends \yii\web\Controller {
    
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['inbox', 'compose', 'sent', 'view'],
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

    public function actionInbox() {
        $this->layout   =   'main';
        $model = new Message();

        $filter = Yii::$app->request->get('filter');
        $filterUserType = null;
        switch ($filter) {
            case 'unread' :
                $status = MessageRecipient::STATUS_UNREAD;
                break;
            case 'read' :
                $status = MessageRecipient::STATUS_READ;
                break;
            default:
                $status = [MessageRecipient::STATUS_READ, MessageRecipient::STATUS_UNREAD];
                break;
        }
        $where = "1";
        $params = [];
        $keyword = Yii::$app->request->get('keyword');
        $usrTable = Yii::$app->db->tablePrefix . 'user';
        $msgTable = Yii::$app->db->tablePrefix . 'message';
        if (!empty($keyword)) {
            $where = "(REPLACE(subject , ' ', '' ) LIKE :keyword "
                    . "OR REPLACE(message , ' ', '' ) LIKE :keyword)"
                    . "OR REPLACE(CONCAT({$usrTable}.first_name , {$usrTable}.middle_name , {$usrTable}.last_name), ' ', '' ) LIKE :keyword";
            $params[':keyword'] = "%" . $keyword . "%";
        }
        $query = Message::find()
                ->joinWith('messageRecipients')
                ->joinWith('sender')
                // ->joinWith('recipient')
                ->where(['recipient_id' => Yii::$app->user->id, Yii::$app->db->tablePrefix . 'message_recipient.status' => $status])
                ->andWhere($where, $params);

        if (!empty($filterUserType) && Yii::$app->user->identity->profile_id == User::PROFILE_DOCTOR) {
            $query->andWhere("{$usrTable}.profile_id = {$filterUserType}");
        }
        $query->orderBy(['created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array('pageSize' => 20),
        ]);
        $pages = new Pagination(['totalCount' => $dataProvider->getTotalCount()]);
        $pages->setPageSize(20);
        return $this->render('inbox', [
                    'model' => $dataProvider->getModels(),
                    'messages' => $dataProvider->getModels(),
                    'pages' => $pages,
        ]);
    }

    public function actionCompose($recipientId = NULL) {
        $model = new Message();
        $recipient = NULL;
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
//            print_r($messagePost);die();
            $to = $messagePost['to'];
            if ($to == '-1') {
                /* case, when user messages admin */
                $adminMessage = true;
                $admins = User::find()->where(['profile_id' => User::PROFILE_ADMIN])->active()->select('id')->all();
                $to = [];
                foreach ($admins as $admin) {
                    $to[] = $admin->id;
                }
            } else {
                /* case, when user messages any other user */
                $adminMessage = false;
                $to = explode(',', $to);
            }
            $msgContent = @Common::cleanInput($messagePost['message']);
            $msgSubject = @Common::cleanInput($messagePost['subject']);


            if (!empty($msgContent) && !empty($to) && !empty($msgSubject)) {
                /*
                 * Okay, it's an extra query, but it ultimately helps to 
                 * filterout the invalid user ids/ hacking attempts..
                 * we can loop throgh the user collection later on. 
                 */
                $users = User::find()->where(['id' => $to])->active()->all();
                if(!empty($users)){
                    $sentMessage = [];

                    $model->message = $msgContent;
                    $model->subject = $msgSubject;
                    $model->is_deleted = 0;
                    $model->status = 1;
                    $model->sender_id = $sender->id;
                    $model->parent_id = null;
                    $model->save(false);

                    if ($model->id) {
                        $a = 0;
                        $files = $messagePost['mdud'];
                        if (!empty($files)) {
                            $files = explode("|||||", $files);
                            if (!empty($files)) {
                                foreach ($files as $file) {
                                    $file = Common::stDecrypt($file);
                                    if ($file) {
                                        @copy(Yii::getAlias('@uploads/tmp/' . $file), Yii::getAlias('@uploads/Message/' . $file));
                                        @unlink(Yii::getAlias('@uploads/tmp/' . $file));
                                        $attach = new MessageAttachment();
                                        $attach->filename = $file;
                                        $attach->message_id = $model->id;
                                        $attach->created_at = strtotime("now");
                                        $attach->save();
                                    }
                                }
                            }
                        }
                        $icon = "";
                        if (!empty($files)) {
                            $icon = "fa fa-file";
                        }
                        foreach ($users as $user) {
                            $recipient = new MessageRecipient();
                            if ($adminMessage) {
                                $recipient->for_admin = 1;
                            }
                            $recipient->recipient_id = $user->id;
                            $recipient->message_id = $model->id;
                            $recipient->status = MessageRecipient::STATUS_UNREAD;
                            $recipient->save();
                            $a = 1;
                            $data = ['sender' => $sender->commonName];
                            $targetPath = ['/message/view', "id" => $model->id];
                            Notification::add($user->id, 'message_received', json_encode($data), $targetPath, $icon);
                            /**
                             * Email to recipient
                             */
                            $ar['{{%NAME%}}'] = $user->fullName;
                            $ar['{{%SENDER_NAME%}}'] = $sender->commonName;
                            $ar['{{%SUBJECT%}}'] = $msgSubject;
                            $ar['{{%MESSAGE%}}'] = $msgContent;
                            $ar['{{%SENDER_INFO%}}'] = $senderInfo;
                            MailSend::sendMail('NEW_MESSAGE_RECEIVED', $user->email, $ar);
                        }
                        if ($a) {
                            \Yii::$app->session->setFlash('success', \Yii::t('app', 'Message sent successfully.'));
                            return $this->redirect(['/message/sent']);
                        }
                    }
                }
            }
            if (empty($users)) {
                $model->addError('to', Yii::t('app', 'Message could not be sent to this recipient.'));
            }
            
            if (empty($msgContent)) {
                $model->addError('message', Yii::t('app', 'Message is either empty, or contains prohibited words.'));
            }
            if (empty($msgSubject)) {
                $model->addError('subject', Yii::t('app', 'Message Subject is either empty, or contains prohibited words.'));
            }
            if (empty($to)) {
                $model->addError('to', Yii::t('app', 'Message Recipient is empty.'));
            }
        }

        if ($recipientId) {
            $recipient = User::findOne($recipientId);
            if (empty($recipient)) {
                throw new \yii\web\NotFoundHttpException(Yii::t('app', 'Invalid user'));
            }
            $this->getView()->title = Yii::t('app', 'Compose message for {recipientName}', ['recipientName' => $recipient->fullName]);
            $recipient = \yii\helpers\Json::encode([['id' => $recipient->id, 'name' => $recipient->fullName . '(' . $recipient->username . ')']]);
        }
        return $this->render('compose', [
                    'model' => $model, 'recipient' => $recipient
        ]);
    }

    public function actionSent() {
        $model = new Message();
        $where = "1";
        $params = [];
        $keyword = Yii::$app->request->get('keyword');
        $usrTable = Yii::$app->db->tablePrefix . 'user';
        $msgTable = Yii::$app->db->tablePrefix . 'message';
        if (!empty($keyword)) {
            $where = "(REPLACE(subject , ' ', '' ) LIKE :keyword "
                    . "OR REPLACE(message , ' ', '' ) LIKE :keyword)"
                    . "OR REPLACE(CONCAT({$usrTable}.first_name , {$usrTable}.middle_name , {$usrTable}.last_name), ' ', '' ) LIKE :keyword";
            $params[':keyword'] = "%" . $keyword . "%";
        }
        $query = MessageRecipient::find()
                ->joinWith('message')
                ->joinWith('recipient')
                ->where(['sender_id' => Yii::$app->user->id])
                ->andWhere(['for_admin' => 0])
                ->andWhere($where, $params)
                ->andWhere(['!=', Yii::$app->db->tablePrefix . 'message.status', Message::STATUS_DELETED])
                ->orderBy([$msgTable . '.created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array('pageSize' => $model::LIMIT),
        ]);
        $pages = new Pagination(['totalCount' => $dataProvider->getTotalCount()]);
        $pages->setPageSize(Message::LIMIT);
        return $this->render('sent', [
                    'model' => $dataProvider->getModels(),
                    'messages' => $dataProvider->getModels(),
                    'pages' => $pages,
        ]);
    }

    public function actionView($id) {


        if (!Message::canView($id)) {
            throw new \yii\web\HttpException(404, Yii::t('app', 'Page not found.'));
        } else {

            $modelh = Message::find()->where(['id' => $id])->one();


            $rcpt = MessageRecipient::findOne(['message_id' => $id, 'recipient_id' => Yii::$app->user->id]);
            if (!empty($rcpt)) {
                $rcpt->status = MessageRecipient::STATUS_READ;
                $rcpt->save(false);
            }

            $model = new Message();
            $modelMessage = [];
            $modelMessage['sender'] = $modelh->sender;
            $modelMessage['message'] = $modelh->message;
            $modelMessage['created_at'] = $modelh->created_at;
            $modelMessage['subject'] = $modelh->subject;
            $modelMessage['id'] = $modelh->id;
            $model->message = '<br/><br/>' . Yii::t('app', ' On ') . Yii::$app->formatter->asDatetime($modelh->created_at) . ', ' . $modelh->sender->fullName . Yii::t('app', ' wrote: <br/>') . '<blockquote style="margin:0 0 0 .8ex; font-size:14px; border-left:1px #ccc solid;padding-left:1ex; color:#555" class="sihatech_quote">' . $modelh->message . '</blockquote>';
            if (isset($_POST['Message'])) {

                $to = @$_POST['Message']['to'];

                $msgContent = @Common::cleanInput($_POST['Message']['message']);

                $mode = $_POST['Message']['mode'];
                if ($mode == "forward") {
                    $msgSubject = Yii::t('app', "FWD:") . $modelh->subject;
                } else {
                    $msgSubject = Yii::t('app', "RE:") . $modelh->subject;
                }

                if ($mode == 'reply') {
                    $rpA = [];
                    foreach ($modelh->messageRecipients as $rp) {
                        $rpA[] = $rp->recipient_id;
                    }

                    $to = $modelh->sender->id != Yii::$app->user->id ? [$modelh->sender->id] : $rpA;
                } else {
                    $to = explode(',', $to);
                }
                if (!empty($msgContent) && (!empty($to)) && !empty($msgSubject)) {
                    /* Okay, it's an extra query, but it ultimately helps to filterout the invalid user ids/ hacking attempts..
                     *  we can loop throgh the user collection later on. */
                    $users = User::find()->where(['id' => $to])->all();
                    $sentMessage = [];

                    $model->message = $msgContent;
                    $model->subject = $msgSubject;
                    $model->created_at = strtotime("now");
                    $model->is_deleted = 0;
                    $model->status = 1;
                    $model->sender_id = Yii::$app->user->id;
                    $model->parent_id = null;
                    $model->save(false);

                    $icon = "";
                    if (!empty($files)) {
                        $icon = "fa fa-file";
                    }    
                    if ($model->id) {
                        $a = 0;
                        foreach ($users as $user) {
                            $recipient = new MessageRecipient();
                            $recipient->recipient_id = $user->id;
                            $recipient->message_id = $model->id;
                            $recipient->status = MessageRecipient::STATUS_UNREAD;
                            $recipient->save();
                            $a = 1;
                            //Sent Notification to User
                            $data = ['sender' => Yii::$app->user->identity->commonName];
                            $targetPath = ['/message/view', "id" => $model->id];
                            Notification::add($user->id, 'message_received', json_encode($data), $targetPath, $icon);
                        }
                        if ($a) {
                            \Yii::$app->session->setFlash('success', \Yii::t('app', 'Message sent successfully.'));
                        }
                        $files = @$_POST['Message']['mdud'];
                        if (!empty($files)) {
                            $files = explode("|||||", $files);
                            if (!empty($files)) {
                                foreach ($files as $file) {
                                    $file = Common::stDecrypt($file);
                                    if ($file) {

                                        @copy(Yii::getAlias('@uploads/tmp/' . $file), Yii::getAlias('@uploads/message_documents/' . $file));
                                        @unlink(Yii::getAlias('@uploads/tmp/' . $file));
                                        $attach = new MessageAttachment();
                                        $attach->filename = $file;
                                        $attach->message_id = $model->id;
                                        $attach->created_at = strtotime("now");
                                        $attach->save();
                                    }
                                }
                            }
                        }
                        if ($a) {
                            return $this->redirect(['/message/view', 'id' => $model->id]);
                        }
                    }
                }
                if (empty($msgContent)) {
                    $model->addError('message', Yii::t('app', 'Message is either empty, or contains prohibited words.'));
                }
                if (empty($msgSubject)) {
                    $model->addError('message', Yii::t('app', 'Message Subject is either empty, or contains prohibited words.'));
                }
                if (empty($to)) {
                    $model->addError('message', Yii::t('app', 'Message Recipient is empty.'));
                }
            }
            return $this->render('view', [
                        'model' => $model,
                        'modelMessage' => $modelMessage,
                        'attachments' => $modelh->messageAttachments
            ]);
        }
    }

    public function actionDownloadZip() {

        $id = Yii::$app->request->post('id');
        $attachments = MessageAttachment::find()->where(['message_id' => $id])->all();
        if (empty($attachments)) {
            echo Yii::t("app", "Invalid Message specified");
            die();
        } else {
            $zipname = Yii::getAlias('@uploads/tmp/' . 'Msg_' . $id . "_" . strtotime("now") . '.zip');
            $zip = new \ZipArchive();
            $zip->open($zipname, \ZipArchive::CREATE);
            foreach ($attachments as $attachment) {
                $zip->addFile(Yii::getAlias('@uploads/message_documents/' . $attachment->filename), basename(Yii::getAlias('@uploads/message_documents/' . $attachment->filename)));
            }
            $zip->close();
            header('Content-Type: application/zip');
            header('Content-disposition: attachment; filename=' . basename($zipname));
            header('Content-Length: ' . filesize($zipname));
            readfile($zipname);
            @unlink($zipname);
        }
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

    public function actionAttachmentDownload($id) {
        
        $attachment = MessageAttachment::find()->where(['id' => $id])->one();
        if (!Message::canView($attachment->message->id)) {
            throw new \yii\web\HttpException(404, Yii::t('app', 'Page not found.'));
        } else {
            // $zip->addFile(, basename(Yii::getAlias('@uploads/message_documents/' . $attachment->filename)));
            // }
            $file = Yii::getAlias('@uploads/message_documents/' . $attachment->filename);
            if (!file_exists($file)) {
                throw new \yii\web\HttpException(404, \Yii::t('app', "File does not exist"));
            }
            $mimetype = Common::getMimeType($file);
            if (!$mimetype) {
                throw new \yii\web\HttpException(404, Yii::t('app', 'Page not found.'));
            }
            header('Content-Type: ' . $mimetype);
            header('Content-disposition: attachment; filename=' . basename($attachment->goodFilename));
            header('Content-Length: ' . filesize($file));
            readfile($file);
        }
    }

    public function actionDelete() {
        $ids = Yii::$app->request->post('msgs');
        if (!empty($ids)) {
            foreach ($ids as $id) {
                $recipient = MessageRecipient::find()->where(['message_id' => $id, 'recipient_id' => Yii::$app->user->id])->one();
                if (!empty($recipient)) {
                    $recipient->status = MessageRecipient::STATUS_DELETED;
                    $recipient->save(false);
                } else {
                    $sender = Message::find()->where(['id' => $id, 'sender_id' => Yii::$app->user->id])->one();
                    if (!empty($sender)) {
                        $sender->status = Message::STATUS_DELETED;
                        $sender->save(false);
                    }
                }
            }
        }
        echo "1";
    }
    
    public function actionSearchByEmail(){
        $q = Yii::$app->request->get('q');
        $profile_ids = [3, 4, 5, 6];
        $userModel = User::find()->where(['profile_id' => $profile_ids])->andWhere(['email' => $q])->active()->one();
        $found = [];
        if(!empty($userModel)){
            $found[] = ['id' => $userModel->id, 'name' => $userModel->email.' ('. $userModel->commonName. ')'];
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $found;
    }

}
