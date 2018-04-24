<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\data\Pagination;
use common\models\NewsletterEmailSubscriber;
use yii\helpers\Url;
use common\models\NewsletterTemplate;
use common\models\NewsletterEmailSubscriberSearch;
use common\models\NewsletterJob;
use yii\filters\AccessControl;
use common\models\ContactSearch;
use frontend\helpers\AuthHelper;
use common\models\NewsletterTemplateSearch;
use common\components\MailSend;
use common\models\EmailTemplate;
use yii\helpers\ArrayHelper;
use common\models\Agent;
use common\models\NewsletterSchedule;
use common\models\NewsletterScheduleSearch;
use common\models\NewsletterScheduleIndexSearch;
use common\models\NewsletterScheduleIndex;
use common\models\EmailSentLog;
use common\models\EmailSentLogSearch;

/**
 * Site controller
 */
class NewsletterController extends Controller
{
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
//                'only' => ['create', 'view', 'update', 'unsubscribe', 'templates', 'send', 'newsletter-subscriber', 'subscribers'],
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
    /**
     * Subscribe user.
     *
     * @return mixed
     */
    public function actionCreate(){
        $model = new NewsletterTemplate();
        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            $model->type = 'contact';
            if($model->save()){
            return $this->redirect(['/newsletter/templates']);
            }
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
          
    }
    
    public function actionView($id){
          return $this->render('view', [
                      'model' => $this->findModel($id),
          ]);
    }
    
    /**
       * Updates an existing NewsletterTemplate model.
       * If update is successful, the browser will be redirected to the 'view' page.
       * @param integer $id
       * @return mixed
       */
    public function actionUpdate($id){
        $model = new NewsletterTemplate();
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }
    
    
    public function actionTemplates() {
        $searchModel = new NewsletterTemplateSearch();
        $user = Yii::$app->user->identity;
        $agency = [];
        if(AuthHelper::is('agency')){
            $agency = $user->agency;
            $agents = ArrayHelper::getColumn(Agent::find()->where(['agency_id' => $agency->id])->active()->all(), 'id');
//            print_r($agents);die();
            if(!empty($agents)){
                $searchModel->userIdIn = $agents;
            }else{
                $searchModel->userIdIn = [0];
            }
        }else{
            $searchModel->userIdIn = $user->id;
        }
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('templates', [
                    'dataProvider' => $dataProvider,
        ]);
        //\yii\helpers\VarDumper::dump($models);exit;
    }
    
    public function actionSend($id,$subscriber_id = NULL){
        if(Yii::$app->request->isPost || $subscriber_id){
            $user = Yii::$app->user->identity;
            if($subscriber_id){
                $subscribers    =   [$subscriber_id];
            }else{
                $subscribers = Yii::$app->request->post('selection');
            }
            //\yii\helpers\VarDumper::dump($subscribers); exit;
            if(empty($subscribers)){
                Yii::$app->session->setFlash('error', Yii::t('app', 'Select Subscriber(s).'));
                return $this->redirect(['recipients', 'template_id' => $id]);
            }
            $templateModel = NewsletterTemplate::findOne($id);
            //\yii\helpers\VarDumper::dump($subscribers); exit;
            foreach ($subscribers as $subscriberId)
            {
                $logModel = new EmailSentLog();
                $logModel->sent_by = $user->id;
                $logModel->contact_id = $subscriberId;
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
                $jobModel->contact_id = $subscriberId;
                $jobModel->template_id = $id;
                if(!$jobModel->save()){
                    \yii\helpers\VarDumper::dump($jobModel->errors);die();
                }
            }
            
            Yii::$app->session->setFlash('success', Yii::t('app', 'Mail has been sent.'));
            return $this->redirect(['recipients', 'template_id' => $id]);
        }
        
        $searchModel = new NewsletterEmailSubscriberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('send', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionSchedule($id){
        if(Yii::$app->request->isPost || $subscriber_id){
            $user = Yii::$app->user->identity;

            $subscribers = Yii::$app->request->post('selection');
            $srart = date('Y-m-d');
            $end = null;
            if(empty($subscribers)){
                Yii::$app->session->setFlash('error', Yii::t('app', 'Select Subscriber(s).'));
                return $this->redirect(['schedule-recipients', 'template_id' => $id]);
            }
            
            $indexModel = new NewsletterScheduleIndex();
            $indexModel->load(Yii::$app->request->post());
            $indexModel->user_id = $user->id;
            $indexModel->name = 'Individual';
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
                $scheduleModel->contact_id = $subscriberId;
                $scheduleModel->template_id = $id;
                if(!$scheduleModel->save()){
                    \yii\helpers\VarDumper::dump($scheduleModel->errors);die();
                }
            }
            
            Yii::$app->session->setFlash('success', Yii::t('app', 'Mail has been scheduled.'));
            return $this->redirect(['schedule-recipients', 'template_id' => $id]);
        }
        
        $searchModel = new NewsletterEmailSubscriberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $indexModel = new NewsletterScheduleIndex();
        
        return $this->render('schedule-recipients', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'indexModel' => $indexModel
        ]);
    }
    
    public function actionScheduledMails(){
        $searchModel = new NewsletterScheduleIndexSearch();
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
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('scheduled-mails', [
                    'dataProvider' => $dataProvider
        ]);
    }
    
    public function actionScheduledMailsUpdate($id){
        $indexModel = NewsletterScheduleIndex::findOne($id);
        if($indexModel->load(Yii::$app->request->post())){
            $indexModel->save();
            Yii::$app->session->setFlash('success', 'Successfully Updated');
            return $this->redirect('scheduled-mails');
        }
        $searchModel = new NewsletterScheduleSearch();
        $searchModel->index_id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('scheduled-mails-update', ['indexModel' => $indexModel, 'dataProvider' => $dataProvider]);
    }
    
    public function actionScheduledMailsDelete($id){
        $indexModel = NewsletterScheduleIndex::findOne($id);
        $indexModel->delete();
        Yii::$app->session->setFlash('success', 'Successfully Deleted');
        return $this->redirect('scheduled-mails');
    }

    public function actionNewsletterSubscriber(){
        $emailSubscriber      = NewsletterEmailSubscriber::find()->all();
        return $this->render('newsletter-subscriber',['emailSubscriber' => $emailSubscriber]);
    }
    
    public function actionRecipients($template_id){
        $searchModel = new ContactSearch();
        $user = Yii::$app->user->identity;
        $agency = [];
        if(AuthHelper::is('agency')){
            $agency = $user->agency;
            $agents = ArrayHelper::getColumn(Agent::find()->where(['agency_id' => $agency->id])->active()->all(), 'id');
//            print_r($agents);die();
            if(!empty($agents)){
                $searchModel->userIdIn = $agents;
            }else{
                $searchModel->userIdIn = [0];
            }
        }else{
            $searchModel->userIdIn = $user->id;
        }
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('recipients', [
                    'dataProvider' => $dataProvider,
                    'template_id' => $template_id,
                    'searchModel' => $searchModel
        ]);
    }
    
    public function actionScheduleRecipients($template_id){
        $searchModel = new ContactSearch();
        $user = Yii::$app->user->identity;
        $agency = [];
        if(AuthHelper::is('agency')){
            $agency = $user->agency;
            $agents = ArrayHelper::getColumn(Agent::find()->where(['agency_id' => $agency->id])->active()->all(), 'id');
//            print_r($agents);die();
            if(!empty($agents)){
                $searchModel->userIdIn = $agents;
            }else{
                $searchModel->userIdIn = [0];
            }
        }else{
            $searchModel->userIdIn = $user->id;
        }
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $indexModel = new NewsletterScheduleIndex();
        
        return $this->render('schedule-recipients', [
                    'dataProvider' => $dataProvider,
                    'template_id' => $template_id,
                    'indexModel' => $indexModel,
                    'searchModel' => $searchModel
        ]);
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
        $searchModel->type = 'Drip';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('sent-mails', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel
        ]);
    }
    
    
    
    
    public function actionSubscribe(){
        if(Yii::$app->request->isPost){
            Yii::$app->response->format     = Response::FORMAT_JSON;
            $newsletterEmail                = Yii::$app->request->post('email');
            //\yii\helpers\VarDumper::dump($newsletterEmail);exit;
            $newsletterEmailArr             = explode('@', $newsletterEmail);
            $name                           = $newsletterEmailArr[0];
            $subscriberModel                =   new NewsletterEmailSubscriber();
            $subscriberModel->first_name    = $name;
            $subscriberModel->email         = $newsletterEmail;
            $subscriberModel->auth_key      = Yii::$app->security->generateRandomString();
            if($subscriberModel->save()){
                $template = EmailTemplate::findOne(['code' => 'NEWSLETTER_SUBSCRIPTION']);
                $ar['{{%SUBSCRIBER_NAME%}}']                    = $subscriberModel->first_name;
                $ar['{{%UNSUBSCRIBE_LINK%}}']                  = Url::to(['newsletter/unsubscribe', 'subscriber_id' => $subscriberModel->id, 'auth_key' => $subscriberModel->auth_key],true);
//                \yii\helpers\VarDumper::dump(Yii::$app->user->identity->email); 
//                \yii\helpers\VarDumper::dump($ar,4,12); exit;
                MailSend::sendMail('NEWSLETTER_SUBSCRIPTION', Yii::$app->user->identity->email, $ar);
                
                return ['success' => true, 'message' => Yii::t('app', 'Thank you for Subscription.')];
                
            }else{
                return ['success' => false,'errors'=>$subscriberModel->errors];
            }
            return ['success' => false,'message'=>Yii::t('app','Something went to wrong.Please Try again later...')];
        }
    }
    
    public function actionUnsubscribe($subscriber_id,$auth_key){
        $subscriberObj = NewsletterEmailSubscriber::findOne($subscriber_id);
        if($subscriberObj->auth_key != $auth_key){
            Yii::$app->session->setFlash('error', 'Something went to wrong.Please Try again later...');
            return $this->goHome();
        }
        $subscriberObj->status   = NewsletterEmailSubscriber::STATUS_INACTIVE;
        if($subscriberObj->save()){
            Yii::$app->session->setFlash('success', 'You have successfully unsubscribe from Newsletter subscription');
            return $this->goHome();
        }
    }
    
    
    /**
    * Finds the NewsletterTemplate model based on its primary key value.
    * If the model is not found, a 404 HTTP exception will be thrown.
    * @param integer $id
    * @return NewsletterTemplate the loaded model
    * @throws NotFoundHttpException if the model cannot be found
    */
   protected function findModel($id)
   {
       if (($model = NewsletterTemplate::findOne($id)) !== null) {
           return $model;
       }
       else {
           throw new NotFoundHttpException('The requested page does not exist.');
       }
   }

}
