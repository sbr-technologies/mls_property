<?php

namespace backend\controllers;
use Yii;
use common\models\NewsletterTemplateSearch;
use common\models\NewsletterTemplate;
use common\models\NewsletterEmailSubscriberSearch;
use common\models\NewsletterEmailListSearch;
use common\models\NewsletterJob;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use common\models\UserSearch;
use common\models\EmailSentLogSearch;
use common\models\EmailSentLog;
use common\models\NewsletterScheduleIndex;
use common\models\NewsletterScheduleIndexSearch;
use common\models\NewsletterSchedule;
use common\models\NewsletterScheduleSearch;

class NewsletterController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
    public function actionUserTemplates()
    {
        $searchModel = new NewsletterTemplateSearch();
        $searchModel->type = 'user';
          $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

          return $this->render('user-templates', [
                      'searchModel' => $searchModel,
                      'dataProvider' => $dataProvider,
          ]);
    }
    
    public function actionSubscriberTemplates()
    {
        $searchModel = new NewsletterTemplateSearch();
        $searchModel->type = 'subscriber';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

          return $this->render('subscriber-templates', [
                      'searchModel' => $searchModel,
                      'dataProvider' => $dataProvider,
          ]);
    }
    
    public function actionGroupTemplates()
    {
        $searchModel = new NewsletterTemplateSearch();
        $searchModel->type = 'subscriber';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

          return $this->render('group-templates', [
                      'searchModel' => $searchModel,
                      'dataProvider' => $dataProvider,
          ]);
    }
    
    public function actionCreate(){
        return $this->redirect(['/newsletter-template/create']);
    }
    
    public function actionView($id)
    {
        return $this->render('view', [
                    'model' => NewsletterTemplate::findOne($id),
        ]);
    }
    
    public function actionSendToUser($id)
    {
        if(Yii::$app->request->isPost){
            $user = Yii::$app->user->identity;
            $subscribers = Yii::$app->request->post('selection');
            if(empty($subscribers)){
                Yii::$app->session->setFlash('error', Yii::t('app', 'Select Subscriber(s).'));
                return $this->redirect(['send', 'id' => $id]);
            }
            $templateModel = NewsletterTemplate::findOne($id);
            foreach ($subscribers as $subscriberId)
            {
                $logModel = new EmailSentLog();
                $logModel->sent_by = $user->id;
                $logModel->user_id = $subscriberId;
                $logModel->subject = $templateModel->subject;
                $logModel->content = $templateModel->content;
                $logModel->type = 'Drip';
                $logModel->status = 'sent';
                if(!$logModel->save()){
                    print_r($logModel->errors);
                    die();
                }
                
                $jobModel = new NewsletterJob();
                $jobModel->sender_id = $user->id;
                $jobModel->name = 'Individual';
                $jobModel->subscriber_id = $subscriberId;
                $jobModel->template_id = $id;
                if(!$jobModel->save()){
                    \yii\helpers\VarDumper::dump($jobModel->errors);die();
                }
            }
            
            Yii::$app->session->setFlash('success', Yii::t('app', 'Newsletter has been sent.'));
            return $this->redirect(['send-to-user', 'id' => $id]);
        }
        
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('send-to-user', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id' => $id
        ]);
    }
    
    public function actionScheduleForUser($id){
        if(Yii::$app->request->isPost){
            $user = Yii::$app->user->identity;

            $subscribers = Yii::$app->request->post('selection');
            if(empty($subscribers)){
                Yii::$app->session->setFlash('error', Yii::t('app', 'Select Subscriber(s).'));
                return $this->redirect(['schedule-for-user', 'id' => $id]);
            }
            
            $indexModel = new NewsletterScheduleIndex();
            $indexModel->load(Yii::$app->request->post());
            $indexModel->user_id = $user->id;
            $indexModel->name = 'user';
            $indexModel->template_id = $id;
            if(!$indexModel->save()){
                \yii\helpers\VarDumper::dump($indexModel->errors);die();
            }
            //\yii\helpers\VarDumper::dump($subscribers); exit;
            foreach ($subscribers as $subscriberId)
            {
                $scheduleModel = new NewsletterSchedule();
                $scheduleModel->index_id = $indexModel->id;
                $scheduleModel->name = 'Individual';
                $scheduleModel->schedule = $indexModel->schedule;
                $scheduleModel->schedule_dates = $indexModel->schedule_dates;
                $scheduleModel->schedule_start_date = $indexModel->schedule_start_date;
                $scheduleModel->schedule_end_date = $indexModel->schedule_end_date;
                $scheduleModel->scheduled_by = $user->id;
                $scheduleModel->user_id = $subscriberId;
                $scheduleModel->template_id = $id;
                if(!$scheduleModel->save()){
                    \yii\helpers\VarDumper::dump($scheduleModel->errors);die();
                }
            }
            
            Yii::$app->session->setFlash('success', Yii::t('app', 'Mail has been scheduled.'));
            return $this->redirect(['schedule-for-user', 'id' => $id]);
        }
        
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $indexModel = new NewsletterScheduleIndex();
        
        return $this->render('schedule-for-user', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'indexModel' => $indexModel,
                    'id' => $id
        ]);
    }
    
    public function actionSendToSubscriber($id)
    {
        if(Yii::$app->request->isPost){
            $user = Yii::$app->user->identity;
            $subscribers = Yii::$app->request->post('selection');
            if(empty($subscribers)){
                Yii::$app->session->setFlash('error', Yii::t('app', 'Select Subscriber(s).'));
            return $this->redirect(['send', 'id' => $id]);
            }
            $templateModel = NewsletterTemplate::findOne($id);
            foreach ($subscribers as $subscriberId)
            {
                $logModel = new EmailSentLog();
                $logModel->sent_by = $user->id;
                $logModel->subscriber_id = $subscriberId;
                $logModel->subject = $templateModel->subject;
                $logModel->content = $templateModel->content;
                $logModel->type = 'Newsletter';
                $logModel->status = 'sent';
                if(!$logModel->save()){
                    print_r($logModel->errors);
                    die();
                }
                
                $jobModel = new NewsletterJob();
                $jobModel->sender_id = $user->id;
                $jobModel->name = 'Individual';
                $jobModel->subscriber_id = $subscriberId;
                $jobModel->template_id = $id;
                if(!$jobModel->save()){
                    \yii\helpers\VarDumper::dump($jobModel->errors);die();
                }
            }
            
            Yii::$app->session->setFlash('success', Yii::t('app', 'Newsletter has been sent.'));
            return $this->redirect(['send-to-subscriber', 'id' => $id]);
        }
        
        $searchModel = new NewsletterEmailSubscriberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

          return $this->render('send-to-subscriber', [
                      'searchModel' => $searchModel,
                      'dataProvider' => $dataProvider,
                        'id' => $id
          ]);
    }
    
    public function actionScheduleForSubscriber($id){
        if(Yii::$app->request->isPost){
            $user = Yii::$app->user->identity;

            $subscribers = Yii::$app->request->post('selection');
            if(empty($subscribers)){
                Yii::$app->session->setFlash('error', Yii::t('app', 'Select Subscriber(s).'));
                return $this->redirect(['schedule-for-user', 'id' => $id]);
            }
            
            $indexModel = new NewsletterScheduleIndex();
            $indexModel->load(Yii::$app->request->post());
            $indexModel->user_id = $user->id;
            $indexModel->name = 'subscriber';
            $indexModel->template_id = $id;
            if(!$indexModel->save()){
                \yii\helpers\VarDumper::dump($indexModel->errors);die();
            }
            //\yii\helpers\VarDumper::dump($subscribers); exit;
            foreach ($subscribers as $subscriberId)
            {
                $scheduleModel = new NewsletterSchedule();
                $scheduleModel->index_id = $indexModel->id;
                $scheduleModel->name = 'Individual';
                $scheduleModel->schedule = $indexModel->schedule;
                $scheduleModel->schedule_dates = $indexModel->schedule_dates;
                $scheduleModel->schedule_start_date = $indexModel->schedule_start_date;
                $scheduleModel->schedule_end_date = $indexModel->schedule_end_date;
                $scheduleModel->scheduled_by = $user->id;
                $scheduleModel->subscriber_id = $subscriberId;
                $scheduleModel->template_id = $id;
                if(!$scheduleModel->save()){
                    \yii\helpers\VarDumper::dump($scheduleModel->errors);die();
                }
            }
            
            Yii::$app->session->setFlash('success', Yii::t('app', 'Mail has been scheduled.'));
            return $this->redirect(['schedule-for-subscriber', 'id' => $id]);
        }
        
        $searchModel = new NewsletterEmailSubscriberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $indexModel = new NewsletterScheduleIndex();
        
        return $this->render('schedule-for-subscriber', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'indexModel' => $indexModel,
                    'id' => $id
        ]);
    }
    
    public function actionSendToList($id)
    {
        if(Yii::$app->request->isPost){
            $user = Yii::$app->user->identity;
            $subscribers = Yii::$app->request->post('selection');
            if(empty($subscribers)){
                Yii::$app->session->setFlash('error', Yii::t('app', 'Select Subscriber List.'));
            return $this->redirect(['send-list', 'id' => $id]);
            }
            $templateModel = NewsletterTemplate::findOne($id);
            foreach ($subscribers as $listId)
            {
                $logModel = new EmailSentLog();
                $logModel->sent_by = $user->id;
                $logModel->list_id = $listId;
                $logModel->subject = $templateModel->subject;
                $logModel->content = $templateModel->content;
                $logModel->type = 'Newsletter';
                $logModel->status = 'sent';
                if(!$logModel->save()){
                    print_r($logModel->errors);
                    die();
                }
                
                $jobModel = new NewsletterJob();
                $jobModel->sender_id = $user->id;
                $jobModel->name = 'Group';
                $jobModel->list_id = $listId;
                $jobModel->template_id = $id;
                $jobModel->save();
            }
            
            Yii::$app->session->setFlash('success', Yii::t('app', 'Newsletter has been sent'));
            return $this->redirect(['send-to-list', 'id' => $id]);
        }
        
        $searchModel = new NewsletterEmailListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('send-to-list', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionScheduleForList($id){
        if(Yii::$app->request->isPost){
            $user = Yii::$app->user->identity;

            $subscribers = Yii::$app->request->post('selection');
            if(empty($subscribers)){
                Yii::$app->session->setFlash('error', Yii::t('app', 'Select Subscriber(s).'));
                return $this->redirect(['schedule-for-user', 'id' => $id]);
            }
            
            $indexModel = new NewsletterScheduleIndex();
            $indexModel->load(Yii::$app->request->post());
            $indexModel->user_id = $user->id;
            $indexModel->name = 'list';
            $indexModel->template_id = $id;
            if(!$indexModel->save()){
                \yii\helpers\VarDumper::dump($indexModel->errors);die();
            }
            //\yii\helpers\VarDumper::dump($subscribers); exit;
            foreach ($subscribers as $subscriberId)
            {
                $scheduleModel = new NewsletterSchedule();
                $scheduleModel->index_id = $indexModel->id;
                $scheduleModel->name = 'list';
                $scheduleModel->schedule = $indexModel->schedule;
                $scheduleModel->schedule_dates = $indexModel->schedule_dates;
                $scheduleModel->schedule_start_date = $indexModel->schedule_start_date;
                $scheduleModel->schedule_end_date = $indexModel->schedule_end_date;
                $scheduleModel->scheduled_by = $user->id;
                $scheduleModel->list_id = $subscriberId;
                $scheduleModel->template_id = $id;
                if(!$scheduleModel->save()){
                    \yii\helpers\VarDumper::dump($scheduleModel->errors);die();
                }
            }
            
            Yii::$app->session->setFlash('success', Yii::t('app', 'Mail has been scheduled.'));
            return $this->redirect(['list-scheduled-mails', 'id' => $id]);
        }
        
        $searchModel = new NewsletterEmailListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $indexModel = new NewsletterScheduleIndex();
        
        return $this->render('schedule-for-list', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'indexModel' => $indexModel,
                    'id' => $id
        ]);
    }
    
    public function actionScheduledUpdate($id){
        $indexModel = NewsletterScheduleIndex::findOne($id);
        if($indexModel->load(Yii::$app->request->post())){
            $indexModel->save();
            Yii::$app->session->setFlash('success', 'Successfully Updated');
            if($indexModel->name == 'user'){
                return $this->redirect(['user-scheduled-mails']);
            }elseif($indexModel->name == 'list'){
                return $this->redirect(['list-scheduled-mails']);
            }elseif($indexModel->name == 'subscriber'){
                return $this->redirect(['subscriber-scheduled-mails']);
            }
        }
        $searchModel = new NewsletterScheduleSearch();
        $searchModel->index_id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('scheduled-mails-update', ['indexModel' => $indexModel, 'dataProvider' => $dataProvider]);
    }

    
    public function actionUserScheduledMails(){
        $searchModel = new NewsletterScheduleIndexSearch();
        $user = Yii::$app->user->identity;

        $searchModel->ownerIdIn = $user->id;
        $searchModel->name = 'user';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('scheduled-mails', [
                    'dataProvider' => $dataProvider
        ]);
    }
    
    public function actionSubscriberScheduledMails(){
        $searchModel = new NewsletterScheduleIndexSearch();
        $user = Yii::$app->user->identity;

        $searchModel->ownerIdIn = $user->id;
        $searchModel->name = 'subscriber';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('scheduled-mails', [
                    'dataProvider' => $dataProvider
        ]);
    }
    
    public function actionListScheduledMails(){
        $searchModel = new NewsletterScheduleIndexSearch();
        $user = Yii::$app->user->identity;

        $searchModel->ownerIdIn = $user->id;
        $searchModel->name = 'list';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('scheduled-mails', [
                    'dataProvider' => $dataProvider
        ]);
    }
    
    public function actionSentMails(){
        $searchModel = new EmailSentLogSearch();
        $user = Yii::$app->user->identity;
        $searchModel->sent_by = $user->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('sent-mails', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel
        ]);
    }
    
    public function actionScheduledDelete($id){
        $indexModel = NewsletterScheduleIndex::findOne($id);
        $name = $indexModel->name;
        $indexModel->delete();
        Yii::$app->session->setFlash('success', 'Successfully Deleted');
        return $this->redirect(["$name-scheduled-mails"]);
    }

}
