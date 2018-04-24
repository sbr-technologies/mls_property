<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use common\models\PropertyShowingRequest;
use common\models\PropertyShowingRequestSearch;
use common\models\PropertyShowingRequestFeedback;
use common\models\PropertyShowingRequestFeedbackSearch;
use yii\filters\AccessControl;


use common\components\MailSend;
use common\components\Sms;
use common\models\EmailTemplate;
use frontend\helpers\AuthHelper;

/**
 * PropertyShowingRequestController implements the CRUD actions for PropertyShowingRequest model.
 */
class PropertyShowingRequestController extends Controller
{
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'approve', 'decline', 'pending', 'replay-feedback', 'delete-property-request', 'create', 'update', 'delete','calender-event'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all PropertyShowingRequest models.
     * @return mixed
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        $searchModel = new PropertyShowingRequestSearch();
        if(AuthHelper::is('agency')){
            $agencyId = $user->agency_id;
            $agents = \yii\helpers\ArrayHelper::getColumn(\common\models\User::find()->where(['agency_id' => $agencyId])->all(), 'id');
            $searchModel->ownerId = $agents;
        }else{
            $searchModel->ownerId = $user->id;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PropertyShowingRequest model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id){
        $requestFeedback    =   new PropertyShowingRequestFeedback();
        $model              =   $this->findModel($id);
        $modelName          =   $model->model;
        $propertyId         =   $model->model_id;
        $requestTo          =   $model->request_to;
        //\yii\helpers\VarDumper::dump($model,4,12);exit;
        return $this->render('view', [
            'model'             => $model,
            'requestFeedback'   => $requestFeedback,
            'id'                => $id,
            'modelName'         =>  $modelName,
            'propertyId'        =>  $propertyId,
            'requestTo'         =>  $requestTo
        ]);
    }
    public function actionCancel($id){
        $model = PropertyShowingRequest::find()->where(['id' => $id])->one();
        if(empty($model)){
            throw new NotFoundHttpException('Invalid showing request');
        }
        if($model->status == PropertyShowingRequest::STATUS_APPROVE){
            Yii::$app->session->setFlash("error", "This showing has previously been Approved.");
            return $this->redirect(['index']);
        }elseif($model->status == PropertyShowingRequest::STATUS_DECLINE){
            Yii::$app->session->setFlash("error", "This showing has previously been Declined.");
            return $this->redirect(['index']);
        }elseif($model->status == PropertyShowingRequest::STATUS_CANCELLED){
            Yii::$app->session->setFlash("error", "This showing has previously been Cancelled.");
            return $this->redirect(['index']);
        }
        $model->status = $model::STATUS_CANCELLED;
        if($model->save()){
            $listingAgent = $this->renderPartial('//shared/_mail-showing-request', ['model' => $model, 'to' => 'la', 'type' => 'cancel']);
            $showingAgent = $this->renderPartial('//shared/_mail-showing-request', ['model' => $model, 'to' => 'sa', 'type' => 'cancel']);

            $ar['{{%SHOWING_REQUEST_DETAILS%}}']           =   $showingAgent;
            MailSend::sendMail('PROPERTY_SHOWING_REQUEST_CANCEL', $model->user->email, $ar);

            $ar['{{%SHOWING_REQUEST_DETAILS%}}']           =   $listingAgent;
            MailSend::sendMail('PROPERTY_SHOWING_REQUEST_CANCEL', $model->property->user->email, $ar);
        }
        Yii::$app->session->setFlash("success", "Showing request has been succesfully cancelled.");
        return $this->redirect(['index']);
    }
    public function actionQuickCancel($key, $time){
        $model = PropertyShowingRequest::find()->where(['auth_key' => $key, 'created_at' => $time])->one();
        if(empty($model)){
            throw new NotFoundHttpException('Invalid showing request');
        }

        if($model->status == PropertyShowingRequest::STATUS_APPROVE){
            Yii::$app->session->setFlash("error", "This showing has previously been Approved.");
            return $this->redirect(['/property/view', 'slug' => $model->property->slug]);
        }elseif($model->status == PropertyShowingRequest::STATUS_DECLINE){
            Yii::$app->session->setFlash("error", "This showing has previously been Declined.");
            return $this->redirect(['/property/view', 'slug' => $model->property->slug]);
        }elseif($model->status == PropertyShowingRequest::STATUS_CANCELLED){
            Yii::$app->session->setFlash("error", "This showing has previously been Cancelled.");
            return $this->redirect(['/property/view', 'slug' => $model->property->slug]);
        }
        $model->status = PropertyShowingRequest::STATUS_CANCELLED;
        if($model->save()){
            $listingAgent = $this->renderPartial('//shared/_mail-showing-request', ['model' => $model, 'to' => 'la', 'type' => 'cancel']);
            $showingAgent = $this->renderPartial('//shared/_mail-showing-request', ['model' => $model, 'to' => 'sa', 'type' => 'cancel']);

            $ar['{{%SHOWING_REQUEST_DETAILS%}}']           =   $showingAgent;
            MailSend::sendMail('PROPERTY_SHOWING_REQUEST_CANCEL', $model->user->email, $ar);
            
            $ar['{{%SHOWING_REQUEST_DETAILS%}}']           =   $listingAgent;
            MailSend::sendMail('PROPERTY_SHOWING_REQUEST_CANCEL', $model->property->user->email, $ar);
        }
        Yii::$app->session->setFlash("success", "Showing request has been succesfully cancelled.");
        return $this->redirect(['/property/view', 'slug' => $model->property->slug]);
    }
    public function actionApprove($id){
        $model = PropertyShowingRequest::find()->where(['id' => $id])->one();
        if(empty($model)){
            throw new NotFoundHttpException('Invalid showing request');
        }
        if($model->status == PropertyShowingRequest::STATUS_APPROVE){
            Yii::$app->session->setFlash("error", "This showing has previously been Approved.");
            return $this->redirect(['index']);
        }elseif($model->status == PropertyShowingRequest::STATUS_DECLINE){
            Yii::$app->session->setFlash("error", "This showing has previously been Declined.");
            return $this->redirect(['index']);
        }elseif($model->status == PropertyShowingRequest::STATUS_CANCELLED){
            Yii::$app->session->setFlash("error", "This showing has previously been Cancelled.");
            return $this->redirect(['index']);
        }        
        $model->status = PropertyShowingRequest::STATUS_APPROVE;
        if($model->save()){
            $listingAgent = $this->renderPartial('//shared/_mail-showing-request', ['model' => $model, 'to' => 'la', 'type' => 'approve']);
            $showingAgent = $this->renderPartial('//shared/_mail-showing-request', ['model' => $model, 'to' => 'sa', 'type' => 'approve']);

            $ar['{{%SHOWING_REQUEST_DETAILS%}}']           =   $showingAgent;
            MailSend::sendMail('PROPERTY_SHOWING_REQUEST_APPROVE', $model->user->email, $ar);
            
            $ar['{{%SHOWING_REQUEST_DETAILS%}}']           =   $listingAgent;
            MailSend::sendMail('PROPERTY_SHOWING_REQUEST_APPROVE', $model->property->user->email, $ar);
        }
        Yii::$app->session->setFlash("success", "Showing request has been succesfully approved.");
        return $this->redirect(['index']);
    }
    public function actionQuickApprove($key, $time){
        $model = PropertyShowingRequest::find()->where(['auth_key' => $key, 'created_at' => $time])->one();
        if(empty($model)){
            throw new NotFoundHttpException('Invalid showing request');
        }
        if($model->status == PropertyShowingRequest::STATUS_APPROVE){
            Yii::$app->session->setFlash("error", "This showing has previously been Approved.");
            return $this->redirect(['/property/view', 'slug' => $model->property->slug]);
        }elseif($model->status == PropertyShowingRequest::STATUS_DECLINE){
            Yii::$app->session->setFlash("error", "This showing has previously been Declined.");
            return $this->redirect(['/property/view', 'slug' => $model->property->slug]);
        }elseif($model->status == PropertyShowingRequest::STATUS_CANCELLED){
            Yii::$app->session->setFlash("error", "This showing has previously been Cancelled.");
            return $this->redirect(['/property/view', 'slug' => $model->property->slug]);
        }        
        $model->status = PropertyShowingRequest::STATUS_APPROVE;
        if($model->save()){
            $listingAgent = $this->renderPartial('//shared/_mail-showing-request', ['model' => $model, 'to' => 'la', 'type' => 'approve']);
            $showingAgent = $this->renderPartial('//shared/_mail-showing-request', ['model' => $model, 'to' => 'sa', 'type' => 'approve']);

            $ar['{{%SHOWING_REQUEST_DETAILS%}}']           =   $showingAgent;
            MailSend::sendMail('PROPERTY_SHOWING_REQUEST_APPROVE', $model->user->email, $ar);
            
            $ar['{{%SHOWING_REQUEST_DETAILS%}}']           =   $listingAgent;
            MailSend::sendMail('PROPERTY_SHOWING_REQUEST_APPROVE', $model->property->user->email, $ar);
        }
        Yii::$app->session->setFlash("success", "Showing request has been succesfully approved.");
        return $this->redirect(['/property/view', 'slug' => $model->property->slug]);
    }
    
    public function actionDecline($id){
        $model = PropertyShowingRequest::find()->where(['id' => $id])->one();
        if(empty($model)){
            throw new NotFoundHttpException('Invalid showing request');
        }
        if($model->status == PropertyShowingRequest::STATUS_APPROVE){
            Yii::$app->session->setFlash("error", "This showing has previously been Approved.");
            return $this->redirect(['index']);
        }elseif($model->status == PropertyShowingRequest::STATUS_DECLINE){
            Yii::$app->session->setFlash("error", "This showing has previously been Declined.");
            return $this->redirect(['index']);
        }elseif($model->status == PropertyShowingRequest::STATUS_CANCELLED){
            Yii::$app->session->setFlash("error", "This showing has previously been Cancelled.");
            return $this->redirect(['index']);
        }        
        $model->status = $model::STATUS_DECLINE;
        if($model->save()){
            $listingAgent = $this->renderPartial('//shared/_mail-showing-request', ['model' => $model, 'to' => 'la', 'type' => 'decline']);
            $showingAgent = $this->renderPartial('//shared/_mail-showing-request', ['model' => $model, 'to' => 'sa', 'type' => 'decline']);

            $ar['{{%SHOWING_REQUEST_DETAILS%}}']           =   $showingAgent;
            MailSend::sendMail('PROPERTY_SHOWING_REQUEST_DECLINE', $model->user->email, $ar);

            $ar['{{%SHOWING_REQUEST_DETAILS%}}']           =   $listingAgent;
            MailSend::sendMail('PROPERTY_SHOWING_REQUEST_DECLINE', $model->property->user->email, $ar);
        }
        Yii::$app->session->setFlash("success", "Showing request has been succesfully declined.");
        return $this->redirect(['index']);
    }
    
    public function actionQuickDecline($key, $time){
        $model = PropertyShowingRequest::find()->where(['auth_key' => $key, 'created_at' => $time])->one();
        if(empty($model)){
            throw new NotFoundHttpException('Invalid showing request');
        }
        if($model->status == PropertyShowingRequest::STATUS_APPROVE){
            Yii::$app->session->setFlash("error", "This showing has previously been Approved.");
            return $this->redirect(['/property/view', 'slug' => $model->property->slug]);
        }elseif($model->status == PropertyShowingRequest::STATUS_DECLINE){
            Yii::$app->session->setFlash("error", "This showing has previously been Declined.");
            return $this->redirect(['/property/view', 'slug' => $model->property->slug]);
        }elseif($model->status == PropertyShowingRequest::STATUS_CANCELLED){
            Yii::$app->session->setFlash("error", "This showing has previously been Cancelled.");
            return $this->redirect(['/property/view', 'slug' => $model->property->slug]);
        }
        $model->status = $model::STATUS_DECLINE;
        if($model->save()){
            $listingAgent = $this->renderPartial('//shared/_mail-showing-request', ['model' => $model, 'to' => 'la', 'type' => 'decline']);
            $showingAgent = $this->renderPartial('//shared/_mail-showing-request', ['model' => $model, 'to' => 'sa', 'type' => 'decline']);

            $ar['{{%SHOWING_REQUEST_DETAILS%}}']           =   $showingAgent;
            MailSend::sendMail('PROPERTY_SHOWING_REQUEST_DECLINE', $model->user->email, $ar);

            $ar['{{%SHOWING_REQUEST_DETAILS%}}']           =   $listingAgent;
            MailSend::sendMail('PROPERTY_SHOWING_REQUEST_DECLINE', $model->property->user->email, $ar);
        }
        Yii::$app->session->setFlash("success", "Showing request has been succesfully declined.");
        return $this->redirect(['/property/view', 'slug' => $model->property->slug]);
    }
    
    public function actionQuickReSchedule($key, $time){
        $model = PropertyShowingRequest::find()->where(['auth_key' => $key, 'created_at' => $time])->one();
        if(empty($model)){
            throw new NotFoundHttpException('Invalid showing request');
        }
        if($model->status == PropertyShowingRequest::STATUS_APPROVE){
            Yii::$app->session->setFlash("error", "This showing has previously been Approved.");
            return $this->redirect(['/property/view', 'slug' => $model->property->slug]);
        }elseif($model->status == PropertyShowingRequest::STATUS_DECLINE){
            Yii::$app->session->setFlash("error", "This showing has previously been Declined.");
            return $this->redirect(['/property/view', 'slug' => $model->property->slug]);
        }elseif($model->status == PropertyShowingRequest::STATUS_CANCELLED){
            Yii::$app->session->setFlash("error", "This showing has previously been Cancelled.");
            return $this->redirect(['/property/view', 'slug' => $model->property->slug]);
        }
        $model->status = PropertyShowingRequest::STATUS_CANCELLED;
        if($model->save()){
            $listingAgent = $this->renderPartial('//shared/_mail-showing-request', ['model' => $model, 'to' => 'la', 'type' => 'cancel']);
            $showingAgent = $this->renderPartial('//shared/_mail-showing-request', ['model' => $model, 'to' => 'sa', 'type' => 'cancel']);

            $ar['{{%SHOWING_REQUEST_DETAILS%}}']           =   $showingAgent;
            MailSend::sendMail('PROPERTY_SHOWING_REQUEST_CANCEL', $model->user->email, $ar);
            
            $ar['{{%SHOWING_REQUEST_DETAILS%}}']           =   $listingAgent;
            MailSend::sendMail('PROPERTY_SHOWING_REQUEST_CANCEL', $model->property->user->email, $ar);
        }
        return $this->redirect(['/property/view', 'slug' => $model->property->slug, 'action' => 'rs']);
    }


//    public function actionPending($id){
//        $model = $this->findModel($id);
//        $modelCnt = PropertyShowingRequest::find()->where(['id' => $id, 'status'=>$model::STATUS_PENDING])->count();
//        if($modelCnt == 0){
//            $model->status = $model::STATUS_PENDING;
//            Yii::$app->session->setFlash("success", "Succesfully Pending.");
//            $model->save();
//        }else{
//            Yii::$app->session->setFlash("error", "You already Pending.");
//        }
//        return $this->redirect(['index']);
//    }
    public function actionReplayFeedback(){
        $requestFeedback                    =   new PropertyShowingRequestFeedback();
        if ($requestFeedback->load(Yii::$app->request->post())) {
            Yii::$app->response->format     = Response::FORMAT_JSON;
            $requestFeedback->user_id       = Yii::$app->user->id;
            $requestFeedback->status        = 'active';
            
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if($requestFeedback->save()){
                    $transaction->commit();
                    return ['success' => true,'message' => 'Your reply sent successfully'];
                }else{
                    return ['success' => false,'errors' => $requestFeedback->errors];
                }
                
            } catch (Exception $ex) {
                $transaction->rollBack();
            }
        }
    }
    public function actionPropertyRequestReplayList($showing_request_id){
        $this->layout   =   'ajax';
        $searchModel = new PropertyShowingRequestFeedbackSearch();
        $searchModel->showing_request_id = $showing_request_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       // \yii\helpers\VarDumper::dump($dataProvider); exit;
        return $this->render('property-request-replay-list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        
    }
    public function actionDeletePropertyRequest(){
        if(Yii::$app->request->isAjax){
            $loopCnt        =   0;
            $saveCnt        =   0;
            Yii::$app->response->format     = Response::FORMAT_JSON;
            $id     =   Yii::$app->request->get('id');
            //\yii\helpers\VarDumper::dump($id); exit;
            $transaction = Yii::$app->db->beginTransaction();
            $deleteObj        =   PropertyShowingRequestFeedback::find()->where(['id' => $id])->one();
            if(!empty($deleteObj)){
                $loopCnt++;
                try {
                    PropertyShowingRequestFeedback::findOne($id)->delete();
                    //PropertyContact::delete(['property_id' => $propertyId]);
                    $saveCnt++;
                } catch (Exception $ex) {
                    $transaction->rollBack();
                }
            }
            //echo "<pre>"; print_r($loopCnt."++".$saveCnt); echo "<pre>"; exit;
            if($loopCnt == $saveCnt){
                $transaction->commit();
                return ['success' => true,'message' => 'One record has been Deleted successfully'];
            }else{
               $transaction->rollBack(); 
               return ['success' => true,'message' => 'Sorry, We are unable to delete'];
            }
            
        }
    }
    /**
     * Creates a new PropertyShowingRequest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PropertyShowingRequest();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PropertyShowingRequest model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PropertyShowingRequest model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionCalenderEvent(){
        $searchModel                = new PropertyShowingRequestSearch();
        $user = Yii::$app->user->identity;
        if(AuthHelper::is('agency')){
            $agencyId = $user->agency_id;
            $agents = \yii\helpers\ArrayHelper::getColumn(\common\models\User::find()->where(['agency_id' => $agencyId])->all(), 'id');
            $searchModel->ownerId = $agents;
        }else{
            $searchModel->ownerId = $user->id;
        }
        $searchModel->status = PropertyShowingRequest::STATUS_APPROVE;
        $dataProvider               = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('calender-event', [
            'searchModel'       => $searchModel,
            'dataProvider'      => $dataProvider,
            //'requests'          => $requests,
        ]);
    }
    /**
     * Finds the PropertyShowingRequest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PropertyShowingRequest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PropertyShowingRequest::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
