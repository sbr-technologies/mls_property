<?php

namespace backend\controllers;

use Yii;
use common\models\PropertyShowingRequest;
use common\models\PropertyShowingRequestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\PropertyShowingRequestFeedback;
use common\models\PropertyShowingRequestFeedbackSearch;
use yii\web\Response;

use common\components\MailSend;
use common\components\Sms;
use common\models\EmailTemplate;

/**
 * PropertyShowingRequestController implements the CRUD actions for PropertyShowingRequest model.
 */
class PropertyShowingRequestController extends Controller
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

    /**
     * Lists all PropertyShowingRequest models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PropertyShowingRequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PropertyShowingRequest model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
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

    public function actionApprove($id){
        $model = $this->findModel($id);
        $modelCnt = PropertyShowingRequest::find()->where(['id' => $id, 'status'=>$model::STATUS_APPROVE])->count();
        //echo $modelCnt; exit;
        if($modelCnt == 0){
            $model->status = $model::STATUS_APPROVE;
            if($model->save()){
                $approveShowingRequest       =    '<div style="color:#666; font:14px/22px arial, sans-serif; margin:0 auto; padding:20px; outline:none; box-sizing:border-box; text-decoration:none; border:none; background:#fff; width:650px;">';
                $approveShowingRequest       .=    '<div>';
                $approveShowingRequest       .=    '<h2 style="color:#01a04e; font-size:22px; margin:0 0 25px; font-weight:600; text-align:center;"><img src="'.Yii::$app->params['homeUrl']. '/images/icon-check.png" alt="" style="display:inline-block; margin:0 0 0 0;"> <span style="display:inline-block; margin:0;">Showing Request Approved</span></h2>';
                $approveShowingRequest       .=    '<div style="clear:both;"></div>';
                $approveShowingRequest       .=    '<img src="'.$model->property->featureThumbImage.'" alt="" style="width:200px; height:125px; float:left; border-radius:10px; border:1px #ddd solid; padding:4px; margin:0 15px 10px 0;">';
                $approveShowingRequest       .=    '<h4 style="font-size:16px; color:#333; margin:0 0 5px;">'.$model->property->reqAddress.'</h4>';
                $approveShowingRequest       .=    '<h5 style="font-size:14px; color:#999; margin:0 0 5px;">'.$model->property->shortAddress.'</h5>';
                $approveShowingRequest       .=    '<p style="color:#666; margin:0 0 5px; font-size:12px;">'.Yii::$app->formatter->asCurrency($model->property->price).' | '.$model->property->market_status.' | MLS '.$model->property->referenceId.'</p>';
                $approveShowingRequest       .=    '<p style="color:#666; margin:0 0 5px; font-size:12px;"><strong>Pressnted by:</strong> '.$model->user->FullName.'</p>';
                $approveShowingRequest       .=    '<p style="color:#1093f5; margin:0 0 10px; font-size:12px;">Additional Listing Details</p>';
                $approveShowingRequest       .=    '<div style="clear:both;"></div>';
                $approveShowingRequest       .=    '<p style="color:#333; margin:0 0 10px; font-size:12px; float:left; font-weight:bold;">You have not ahours this listing before</p>';
                $approveShowingRequest       .=    '<p style="color:#333; margin:0 0 10px 50px; font-size:12px; float:left; font-weight:bold;">Buying info not Provided</p>';
                $approveShowingRequest       .=    '<a style="background:#ddd; border-radius:3px; font-size:13px; color:#1093f5; text-decoration:none; margin-left:15px;" href="javascript:void(0)"></a>';
                $approveShowingRequest       .=    '<h3 style="color:#b21117; font-size:18px; margin:20px 0; font-weight:600; border-bottom:1px #ddd solid; padding-bottom:10px;">Appointment Details</h3>';
                $approveShowingRequest       .=    '<p style="width:100%; float:left; margin:0;"><img src="'.Yii::$app->params['homeUrl']. '/images/icon-road.png" alt="" style="margin-top:2px; float:left;"> <span style="border-left:1px #333 solid; padding:5px 0 5px 25px; float:left; margin-left:15px;">Showing</span></p>';
                $approveShowingRequest       .=    '<p style="width:100%; float:left; margin:0;"><img src="'.Yii::$app->params['homeUrl']. '/images/icon-date.png" alt="" style="margin-top:2px; float:left;"> <span style="border-left:1px #333 solid; padding:5px 0 5px 25px; float:left; margin-left:15px;">'.date('d-m-Y',$model->schedule).'</span></p>';
                $approveShowingRequest       .=    '<p style="width:100%; float:left; margin:15px 0;"><img src="'.Yii::$app->params['homeUrl']. '/images/icon-message.png" alt="" style="margin-top:2px; float:left;"> <span style="border-left:1px #333 solid; padding:0 0 0 25px; float:left; margin:-17px 0 0 31px;"> '.$model->note.'</span></p>';
                $approveShowingRequest       .=    '<div style="clear:both;"></div>';
                $approveShowingRequest       .=    '<h3 style="color:#b21117; font-size:18px; margin:20px 0; font-weight:600; border-bottom:1px #ddd solid; padding-bottom:10px;">Information You’ve Provided</h3>';
                $approveShowingRequest       .=    '<h4 style="font-size:16px; color:#333; margin:0 0 5px;">'.$model->name.'</h4>';
                $approveShowingRequest       .=    '<h5 style="font-size:14px; color:#999; margin:0 0 5px;">'.$model->email.'</h5>';
                $approveShowingRequest       .=    '<p style="color:#666; margin:0 0 5px; font-size:12px;">'.$model->phone.'</p>';
                $approveShowingRequest       .=    '<h3 style="color:#b21117; font-size:18px; margin:50px 0 20px 0; font-weight:600; border-bottom:1px #ddd solid; padding-bottom:10px;">Listing Presented By</h3>';
                $approveShowingRequest       .=    '<img src="'.$model->user->imageUrl.'" alt="" style="width:150px; height:100px; float:left; border:1px #ddd solid; padding:4px; margin:0 15px 10px 0;">';
                $approveShowingRequest       .=    '<h4 style="font-size:16px; color:#333; margin:0 0 5px;">'.$model->user->FullName.'</h4>';
                $approveShowingRequest       .=    '<h5 style="font-size:14px; color:#999; margin:0 0 5px;">'.$model->user->agency->name.'</h5>';
                $approveShowingRequest       .=    '<p style="color:#666; margin:0 0 5px; font-size:12px;">'.$model->user->mobile1.'</p>';
                $approveShowingRequest       .=    '<p style="color:#666; margin:0 0 5px; font-size:12px;">'.$model->user->agency->mobile.'</p>';
                $approveShowingRequest       .=    '<p style="color:#666; margin:30px 0 0 0; padding:10px 0; font-size:13px; border-top:1px #ddd solid; text-align:center;">For questions regarding this appointment, Please contact the listing office directly at '.$model->user->agency->mobile.'</p>';
                $approveShowingRequest       .=    '</div>';
                $approveShowingRequest       .=    '</div>';
                $template = EmailTemplate::findOne(['code' => 'APPROVE_PROPERTY_SHOWING_REQUEST']);
                $ar['{{%SHOWING_REQUEST_PROPERTY_APPROVE%}}']    = $approveShowingRequest;
                MailSend::sendMail('APPROVE_PROPERTY_SHOWING_REQUEST', $model->user->emailAddress, $ar);
                Yii::$app->session->setFlash("success", "Succesfully Approved.");
            }  else {
                \yii\helpers\VarDumper::dump($model->errors); exit;
            }
        }else{
            Yii::$app->session->setFlash("error", "You already Approveed.");
        }
        return $this->redirect(['index']);
    }
    public function actionDiscard($id){
        $model = $this->findModel($id);
        $modelCnt = PropertyShowingRequest::find()->where(['id' => $id, 'status'=>$model::STATUS_DISCARD])->count();
        if($modelCnt == 0){
            $model->status = $model::STATUS_DISCARD;
            if($model->save()){
                $discardShowingRequest       =    '<div style="color:#666; font:14px/22px arial, sans-serif; margin:0 auto; padding:20px; outline:none; box-sizing:border-box; text-decoration:none; border:none; background:#fff; width:650px;">';
                $discardShowingRequest       .=    '<div>';
                $discardShowingRequest       .=    '<h2 style="color:#b21117; font-size:22px; margin:0 0 25px; font-weight:600; text-align:center;"><img src="'.Yii::$app->params['homeUrl']. '/images/icon-close.png" alt="" style="display:inline-block; margin:0 0 0 0;"> <span style="display:inline-block; margin:0;">Showing Request Cancel</span></h2>';
                $discardShowingRequest       .=    '<div style="clear:both;"></div>';
                $discardShowingRequest       .=    '<img src="'.$model->property->featureThumbImage.'" alt="" style="width:200px; height:125px; float:left; border-radius:10px; border:1px #ddd solid; padding:4px; margin:0 15px 10px 0;">';
                $discardShowingRequest       .=    '<h4 style="font-size:16px; color:#333; margin:0 0 5px;">'.$model->property->reqAddress.'</h4>';
                $discardShowingRequest       .=    '<h5 style="font-size:14px; color:#999; margin:0 0 5px;">'.$model->property->shortAddress.'</h5>';
                $discardShowingRequest       .=    '<p style="color:#666; margin:0 0 5px; font-size:12px;">'.Yii::$app->formatter->asCurrency($model->property->price).' | '.$model->property->market_status.' | MLS '.$model->property->referenceId.'</p>';
                $discardShowingRequest       .=    '<p style="color:#666; margin:0 0 5px; font-size:12px;"><strong>Pressnted by:</strong> '.$model->user->FullName.'</p>';
                $discardShowingRequest       .=    '<p style="color:#1093f5; margin:0 0 10px; font-size:12px;">Additional Listing Details</p>';
                $discardShowingRequest       .=    '<div style="clear:both;"></div>';
                $discardShowingRequest       .=    '<p style="color:#333; margin:0 0 10px; font-size:12px; float:left; font-weight:bold;">You have not ahours this listing before</p>';
                $discardShowingRequest       .=    '<p style="color:#333; margin:0 0 10px 50px; font-size:12px; float:left; font-weight:bold;">Buying info not Provided</p>';
                $discardShowingRequest       .=    '<a style="background:#ddd; border-radius:3px; font-size:13px; color:#1093f5; text-decoration:none; margin-left:15px;" href="javascript:void(0)"></a>';
                $discardShowingRequest       .=    '<h3 style="color:#b21117; font-size:18px; margin:20px 0; font-weight:600; border-bottom:1px #ddd solid; padding-bottom:10px;">Appointment Details</h3>';
                $discardShowingRequest       .=    '<p style="width:100%; float:left; margin:0;"><img src="'.Yii::$app->params['homeUrl']. '/images/icon-road.png" alt="" style="margin-top:2px; float:left;"> <span style="border-left:1px #333 solid; padding:5px 0 5px 25px; float:left; margin-left:15px;">Showing</span></p>';
                $discardShowingRequest       .=    '<p style="width:100%; float:left; margin:0;"><img src="'.Yii::$app->params['homeUrl']. '/images/icon-date.png" alt="" style="margin-top:2px; float:left;"> <span style="border-left:1px #333 solid; padding:5px 0 5px 25px; float:left; margin-left:15px;">'.date('d-m-Y',$model->schedule).'</span></p>';
                $discardShowingRequest       .=    '<p style="width:100%; float:left; margin:15px 0;"><img src="'.Yii::$app->params['homeUrl']. '/images/icon-message.png" alt="" style="margin-top:2px; float:left;"> <span style="border-left:1px #333 solid; padding:0 0 0 25px; float:left; margin:-17px 0 0 31px;"> '.$model->note.'</span></p>';
                $discardShowingRequest       .=    '<div style="clear:both;"></div>';
                $discardShowingRequest       .=    '<h3 style="color:#b21117; font-size:18px; margin:20px 0; font-weight:600; border-bottom:1px #ddd solid; padding-bottom:10px;">Information You’ve Provided</h3>';
                $discardShowingRequest       .=    '<h4 style="font-size:16px; color:#333; margin:0 0 5px;">'.$model->name.'</h4>';
                $discardShowingRequest       .=    '<h5 style="font-size:14px; color:#999; margin:0 0 5px;">'.$model->email.'</h5>';
                $discardShowingRequest       .=    '<p style="color:#666; margin:0 0 5px; font-size:12px;">'.$model->phone.'</p>';
                $discardShowingRequest       .=    '<h3 style="color:#b21117; font-size:18px; margin:50px 0 20px 0; font-weight:600; border-bottom:1px #ddd solid; padding-bottom:10px;">Listing Presented By</h3>';
                $discardShowingRequest       .=    '<img src="'.$model->user->imageUrl.'" alt="" style="width:150px; height:100px; float:left; border:1px #ddd solid; padding:4px; margin:0 15px 10px 0;">';
                $discardShowingRequest       .=    '<h4 style="font-size:16px; color:#333; margin:0 0 5px;">'.$model->user->FullName.'</h4>';
                $discardShowingRequest       .=    '<h5 style="font-size:14px; color:#999; margin:0 0 5px;">'.$model->user->agency->name.'</h5>';
                $discardShowingRequest       .=    '<p style="color:#666; margin:0 0 5px; font-size:12px;">'.$model->user->mobile1.'</p>';
                $discardShowingRequest       .=    '<p style="color:#666; margin:0 0 5px; font-size:12px;">'.$model->user->agency->mobile.'</p>';
                $discardShowingRequest       .=    '<p style="color:#666; margin:30px 0 0 0; padding:10px 0; font-size:13px; border-top:1px #ddd solid; text-align:center;">For questions regarding this appointment, Please contact the listing office directly at '.$model->user->agency->mobile.'</p>';
                $discardShowingRequest       .=    '</div>';
                $discardShowingRequest       .=    '</div>';
                $template = EmailTemplate::findOne(['code' => 'DISCARD_PROPERTY_SHOWING_REQUEST']);
                $ar['{{%SHOWING_REQUEST_PROPERTY_DISCARD%}}']    = $discardShowingRequest;
 
                MailSend::sendMail('DISCARD_PROPERTY_SHOWING_REQUEST', $model->user->emailAddress, $ar);
            }
            Yii::$app->session->setFlash("success", "Succesfully Discard.");
        }else{
            Yii::$app->session->setFlash("error", "You already Discard.");
        }
        return $this->redirect(['index']);
    }
    public function actionPending($id){
        $model = $this->findModel($id);
        $modelCnt = PropertyShowingRequest::find()->where(['id' => $id, 'status'=>$model::STATUS_PENDING])->count();
        if($modelCnt == 0){
            $model->status = $model::STATUS_PENDING;
            Yii::$app->session->setFlash("success", "Succesfully Pending.");
            $model->save();
        }else{
            Yii::$app->session->setFlash("error", "You already Pending.");
        }
        return $this->redirect(['index']);
    }
    public function actionReplayFeedback(){
        $requestFeedback                    =   new PropertyShowingRequestFeedback();
        if ($requestFeedback->load(Yii::$app->request->post())) {
            Yii::$app->response->format     = Response::FORMAT_JSON;
            $requestFeedback->user_id       = Yii::$app->user->id;
            $requestFeedback->status        = 'active';
            $requestFeedback->model        = 'Property';
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if($requestFeedback->save()){
                    $transaction->commit();
                    return ['success' => true,'message' => 'Your replay on property request send successfully'];
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
     * @param string $id
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
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
		Yii::$app->session->setFlash('success', 'Successfully deleted'); 
        return $this->redirect(['index']);
    }

    /**
     * Finds the PropertyShowingRequest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
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
