<?php

namespace backend\controllers;

use Yii;
use common\models\Agency;
use common\models\AgencySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use common\models\AgentSearch;
use common\models\PhotoGallery;
use common\models\SocialMediaLink;
use yii\helpers\StringHelper;
use common\models\TeamSearch;
use common\models\SubscriptionSearch;
use common\models\Subscription;

use common\models\User;

use yii\web\UploadedFile;
/**
 * AgencyController implements the CRUD actions for Agency model.
 */
class AgencyController extends Controller
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
     * Lists all Agency models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AgencySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Agency model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $teamSearchModel = new TeamSearch();
        $teamSearchModel->agency_id = $model->id;
        $teamDataProvider = $teamSearchModel->search(Yii::$app->request->queryParams);
        
        $agentSearchModel = new AgentSearch();
        $agentSearchModel->agency_id = $id;
        $agentDataProvider = $agentSearchModel->search(Yii::$app->request->queryParams);
        
        $subscriptionsSearchModel = new SubscriptionSearch();
        $subscriptionsSearchModel->agency_id = $model->id;
        $subscriptionsDataProvider = $subscriptionsSearchModel->search(null);
        
        $hasActiveSubscription = Subscription::find()->where(['agency_id' => $model->id])->active()->exists();
        $newSubscription = new Subscription();
        
        return $this->render('view', [
            'model' => $model, 'agentDataProvider' => $agentDataProvider, 'teamDataProvider' => $teamDataProvider,
            'subscriptionsDataProvider' => $subscriptionsDataProvider, 'hasActiveSubscription' => $hasActiveSubscription, 'newSubscription' => $newSubscription
        ]);
    }

    /**
     * Creates a new Agency model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Agency();
        $socialMediaModel   =   array();
        if ($model->load(Yii::$app->request->post())) {
            $agaencySocialData          = Yii::$app->request->post('SocialMediaLink'); 
            
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
                if($model->save()){
                    if(!empty($model->imageFiles)){
                        $model->upload();
                    }
//                    \yii\helpers\VarDumper::dump($agaencySocialData, 4,12); exit;
                    if(!empty($agaencySocialData)){
                        SocialMediaLink::deleteAll(['model_id' => $model->id,'model' => 'Agency']);
                        foreach($agaencySocialData as $socialKey => $socailVal){
                            if(isset($socailVal['url']) && $socailVal['url'] !=''){
                                //$loopCnt++;
                                $modelName = StringHelper::basename($model->className());
                                $agencyMedia                    = new SocialMediaLink();
                                $agencyMedia->model             = $modelName;
                                $agencyMedia->model_id          = $model->id;
                                $agencyMedia->name              = $socialKey;
                                $agencyMedia->url               = $socailVal['url'];
                                $agencyMedia->save();
                                //$saveCnt++;
                            }
                        }
                    }
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (Exception $ex) {
                $transaction->rollBack();
            }
        } else {
            //\yii\helpers\VarDumper::dump($model->errors,45,1);
            return $this->render('create', [
                'model'             => $model,
                'socialMediaModel'  => $socialMediaModel,
            ]);
        }
    }

    /**
     * Updates an existing Agency model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model                  = $this->findModel($id);
        $socialMedia            = SocialMediaLink::findAll(['model_id' => $model->id,'model' => 'Agency']);
        if(is_array($socialMedia) && count($socialMedia) > 0){
            foreach($socialMedia as $socialKey => $socialVal){
                $socialMediaModel[$socialVal->name]['url'] = $socialVal->url;
            }
        }else{
           $socialMediaModel = array(); 
        }
        $brokerModel = User::find()->where(['agency_id' => $model->id, 'profile_id' => User::PROFILE_AGENCY])->one();
       // \yii\helpers\VarDumper::dump($socialMediaModel,4,12); exit;
        //$socialMediaModel       = $model->socialMedias;
        if ($model->load(Yii::$app->request->post())) {
            $agaencySocialData          = Yii::$app->request->post('SocialMediaLink'); 
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
                if($model->save()){
                    if(!empty($model->imageFiles)){
                        $model->upload();
                    }
                    if(!empty($agaencySocialData)){
                        SocialMediaLink::deleteAll(['model_id' => $model->id,'model' => 'Agency']);
                        foreach($agaencySocialData as $socialKey => $socailVal){
                            if(isset($socailVal['url']) && $socailVal['url'] !=''){
                                //$loopCnt++;
                                $modelName = StringHelper::basename($model->className());
                                $agencyMedia                    = new SocialMediaLink();
                                $agencyMedia->model             = $modelName;
                                $agencyMedia->model_id          = $model->id;
                                $agencyMedia->name              = $socialKey;
                                $agencyMedia->url               = $socailVal['url'];
                                $agencyMedia->save();
                                //$saveCnt++;
                            }
                        }
                    }
                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (Exception $ex) {
                $transaction->rollBack();
            }
        }
        $brokerSocialMedia = array();
        $brokerSocial    = $brokerModel->agentSocialMedias;
        if(is_array($brokerSocial) && count($brokerSocial) > 0){
            foreach($brokerSocial as $socialKey => $socialVal){
                $brokerSocialMedia[$socialVal->name]['url'] = $socialVal->url;
            }
        }
        return $this->render('update', [
            'model' => $model,
            'socialMediaModel' => $socialMediaModel,
            'brokerModel' => $brokerModel,
            'brokerSocialMedia'     => $brokerSocialMedia,
        ]);
    }

    /**
     * Deletes an existing Agency model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        foreach ($model->photos as $photo){
            if($photo->delete()){
                $photo->deleteImage();
            }
        }
        $model->delete();
        Yii::$app->session->setFlash('success', 'Successfully deleted');
        return $this->redirect(['index']);
    }

    public function actionDeletePhoto($id)
    {
        $photo = PhotoGallery::findOne($id);
        if($photo->delete()){
            $photo->deleteImage();
            echo json_encode(array('status' => 'success', 'message' => 'One image delete successfully'));die();
        }else{
            echo json_encode(array('status' => 'failed', 'message' =>'Sorry, We are unable to process your data'));die();
        }
    }
    /**
     * Status Updates an existing MetricType model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionStatus($id){
        $model = $this->findModel($id);
        if($model->status == $model::STATUS_ACTIVE){
            $model->status = $model::STATUS_INACTIVE;
            Yii::$app->session->setFlash("success", "Succesfully inactive.");
        }else {
            $model->status = $model::STATUS_ACTIVE;
            Yii::$app->session->setFlash("success", "Succesfully active.");
        }
        $model->save();
        return $this->redirect(['index']);
    }
    
    
    public function actionTerminateSubscription($id){
        $subscripton = Subscription::findOne($id);
        $subscripton->status = Subscription::STATUS_INACTIVE;
        $subscripton->save();
        echo '1';
    }
    
    public function actionCreateSubscription(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $subsStart = strtotime('now');
        $subscription = new Subscription();
        if($subscription->load(Yii::$app->request->post())){
            $plan = \common\models\PlanMaster::findOne($subscription->plan_id);
            $subscription->service_category_id = $plan->service_category_id;
            $subscription->does_admin = 1;
            $subscription->subs_start = $subsStart;
            $subscription->subs_end = strtotime("+{$subscription->duration} months", $subsStart);
            $subscription->currency_code = 'NGN';
            $subscription->payment_mode = 'offline';
            $subscription->status = Subscription::STATUS_ACTIVE;
            if(!$subscription->save()){
                return ['output'=>$subscription->errors];
            }
        }
        return ['output'=>'Updated'];
    }
    
    public function actionUpdateSubscription($id){
        $subscription = Subscription::findOne($id);
        if($subscription->load(Yii::$app->request->post())){
            $subsStart = strtotime('now');
            $subscription->does_admin = 1;
            $subscription->subs_start = $subsStart;
            $subscription->subs_end = strtotime("+{$subscription->duration} months", $subsStart);
            $subscription->currency_code = 'NGN';
            $subscription->payment_mode = 'offline';
            $subscription->status = Subscription::STATUS_ACTIVE;
            $subscription->save();
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['output'=>'Updated'];
    }

    
    /**
     * Finds the Agency model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Agency the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Agency::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
