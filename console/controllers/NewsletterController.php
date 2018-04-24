<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\NewsletterJob;
use common\models\NewsletterEmailListSubscriber;
use common\models\Contact;
use common\components\MailSend;
use common\models\NewsletterSchedule;
use common\models\NewsletterTemplate;
use common\models\EmailSentLog;
use common\models\User;

class NewsletterController extends Controller {

    public function actionIndexPage() {
        echo "Done\n";
    }

    public function actionProcessQueue() {
        $models = NewsletterJob::find()->all();
        if (!empty($models)) {
            foreach ($models as $model) {
                try {
                    $recipients = [];
                    $subject = $model->template->subject;
                    $content = $model->template->content;
                    if ($model->subscriber_id) {
                        $recipients[] = ['email' => $model->subscriber->email, 'name' => $model->subscriber->first_name];
                    } elseif ($model->list_id) {
                        $listSubs = NewsletterEmailListSubscriber::find()->where(['list_id' => $model->list_id])->all();
                        foreach ($listSubs as $listSub) {
                            $recipients[] = ['email' => $listSub->subscriber->email, 'name' => $listSub->subscriber->first_name];
                        }
                    }elseif($model->contact_id){
                        $contactModel = Contact::findOne($model->contact_id);
                        $recipients[] = ['email' => $contactModel->email, 'name' => $contactModel->name];
                    }elseif($model->user_id){
                        $userModel = User::findOne($model->user_id);
                        $recipients[] = ['email' => $userModel->email, 'name' => $userModel->commonName];
                    }
                    $sender = User::findOne($model->sender_id);
                    $senderInfo = $sender->commonName;
                    if($sender->agency_id){
                        $companyModel = \common\models\Agency::findOne($sender->agency_id);
                    }
                    if(!empty($companyModel)){
                        $senderInfo .= '<br/>'.$companyModel->name;
                    }
                    if(!empty($recipients)){
                        foreach ($recipients as $recipient) {
                            $ar = [];
                            $ar['{{%NAME%}}'] = $recipient['name'];
                            $ar['{{%MESSAGE%}}'] = $content;
                            $ar['{{%SENDER_INFO%}}'] = $senderInfo;
                            MailSend::sendMail('AUTO_EMAIL', $recipient['email'], $ar, $subject);
                        }
                    }
                    $model->delete();

                } catch (Exception $exc) {
                    $model->attempts = $model->attempts + 1;
                    $model->run_at = time();
                    $model->last_error = $exc->getMessage();
                    $model->status = 'failed';
                    $model->save(false);
                }
            }
        }
    }

    public function actionProcessSchedule(){
        $today = date('Y-m-d');
        $todayDay = date('N');
        $cnt = 0;
        $scheduleModels = NewsletterSchedule::find()->where(['<=', 'schedule_start_date', $today])->active()->all();
        foreach($scheduleModels as $model){
            $start = $model->schedule_start_date;
            if($model->schedule == 'weekly'){
                $day = date('N', strtotime($start));
                if($day != $todayDay){
                    continue;
                }
            }elseif($model->schedule == 'monthly'){
                $date1 = new \DateTime($today);
                $date2 = new \DateTime($start);
                $interval = $date1->diff($date2);
                if($interval->d !== 0){
                    continue;
                }
            }elseif(!$model->schedule && $model->schedule_dates){
                $dates = explode(',', $model->schedule_dates);
                $exist = false;
                if(!empty($dates)){
                    foreach($dates as $sDate){
                        if(date('d/m') == $sDate){
                            $exist = true;
                        }
                    }
                }
                if($exist == false){
                    continue;
                }
            }elseif(!$model->schedule && !$model->schedule_dates){
                continue;
            }
            $templateModel = NewsletterTemplate::findOne($model->template_id);
            $jobModel = new NewsletterJob();
            $jobModel->sender_id = $model->scheduled_by;
            $jobModel->template_id = $model->template_id;
            $jobModel->user_id = $model->user_id;
            $jobModel->contact_id = $model->contact_id;
            $jobModel->list_id = $model->list_id;
            $jobModel->subscriber_id = $model->subscriber_id;
            $jobModel->name = 'drip';
            if(!$jobModel->save()){
                print_r($jobModel->errors);
            }
            
            $logModel = new EmailSentLog();
            $logModel->sent_by = $model->scheduled_by;
            $logModel->contact_id = $model->contact_id;
            $logModel->subject = $templateModel->subject;
            $logModel->content = $templateModel->content;
            $logModel->type = 'Drip';
            $logModel->status = 'sent';
            if(!$logModel->save()){
                print_r($logModel->errors);
            }
                
            $cnt++;
        }
    }
}
