<?php

namespace backend\controllers;

use Yii;
use common\models\Agent;
use common\models\AgentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\AgentSellerMappingSearch;
use yii\helpers\StringHelper;
use common\helpers\SendMail;
use yii\web\Response;
use common\models\SellerSearch;
use common\models\AgentServiceCategoryMappingSearch;
use common\models\SubscriptionSearch;
use common\models\Subscription;
/**
 * UserController implements the CRUD actions for User model.
 */
class AgentController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AgentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionIndexJson(){
        $agencyId = Yii::$app->request->post('depdrop_parents');
        $searchModel = new AgentSearch();
        $searchModel->agency_id = $agencyId[0];
        $out = [];
        $selected = '';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        foreach ($dataProvider->getModels() as $model){
            $out[] = ['id' => $model->id, 'name' => $model->fullName];
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['output'=>$out, 'selected'=>$selected];
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $serviceCategorySearchModel = new AgentServiceCategoryMappingSearch();
        $serviceCategorySearchModel->agent_id = $id;
        $serviceCategoryDataProvider = $serviceCategorySearchModel->search(Yii::$app->request->queryParams);
        
        $sellerSearchModel = new AgentSellerMappingSearch();
        $sellerSearchModel->agent_id = $id;
        $sellerDataProvider = $sellerSearchModel->search(Yii::$app->request->queryParams);
        
        $subscriptionsSearchModel = new SubscriptionSearch();
        $subscriptionsSearchModel->user_id = $model->id;
        $subscriptionsDataProvider = $subscriptionsSearchModel->search(null);
        
        $officeSubscriptionsDataProvider = '';
        if($model->agency_id){
            $officeSubscriptionsSearchModel = new SubscriptionSearch();
            $officeSubscriptionsSearchModel->agency_id = $model->agency_id;
            $officeSubscriptionsSearchModel->status = 'active';
            $officeSubscriptionsDataProvider = $officeSubscriptionsSearchModel->search(null);
        }
//        var_dump($officeSubscriptionsDataProvider);die();
        $hasActiveSubscription = Subscription::find()->where(['user_id' => $model->id])->active()->exists();
        if($hasActiveSubscription == false && !empty($officeSubscriptionsDataProvider) && $officeSubscriptionsDataProvider->totalCount > 0){
            $hasActiveSubscription = true;
        }
        $newSubscription = new Subscription();
        
        if ($model->agency_id) {
            $subscriptionsSearchModel = new SubscriptionSearch();
            $subscriptionsSearchModel->user_id = $model->id;
            $subscriptionsDataProvider = $subscriptionsSearchModel->search(null);
        }

        return $this->render('view', [
            'model' => $model, 'serviceCategoryDataProvider' => $serviceCategoryDataProvider, 'sellerDataProvider' => $sellerDataProvider,
            'officeSubscriptionsDataProvider' => $officeSubscriptionsDataProvider,
            'subscriptionsDataProvider' => $subscriptionsDataProvider, 'hasActiveSubscription' => $hasActiveSubscription, 'newSubscription' => $newSubscription
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Agent();
        //$modelagentServiceMap = new AgentServiceCategoryMapping();

        if ($model->load(Yii::$app->request->post())) {
            $profileImage = $model->uploadImage();
            if($model->save()){
                $model->services = $_POST['Agent']['services'];
                if ($profileImage !== false) {
                    $path = $model->getImageFile();
                    $profileImage->saveAs($path);
                    $model->resizeImage();
                }
                $model->sendRegistrationMail();
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                \yii\helpers\VarDumper::dump($model->errors);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $oldFileName = $model->profile_image_file_name;
        $oldFileExt = $model->profile_image_extension;
        
        $sellerSearchModel = new AgentSellerMappingSearch();
        $sellerSearchModel->agent_id = $id;
        $sellerDataProvider = $sellerSearchModel->search(Yii::$app->request->queryParams);
        
        if ($model->load(Yii::$app->request->post())) {
            $profileImage = $model->uploadImage();
            if($model->save()){
                if ($profileImage !== false) { // delete old and overwrite
                    if($oldFileName && $oldFileExt){
                        $model::unlinkFiles($oldFileName, $oldFileExt);
                    }
                    $path = $model->getImageFile();
                    $profileImage->saveAs($path);
                    $model->resizeImage();
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,'sellerDataProvider' => $sellerDataProvider
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if($id == 1){
            Yii::$app->session->setFlash('error', 'Default user can\'t be deleted');
            return $this->redirect(['index']);
        }
        $model = $this->findModel($id);
        if($model->delete()){
            $model->deleteImage();
            Yii::$app->session->setFlash('success', 'Successfully deleted');
        }
        return $this->redirect(['index']);
    }
    
    
    public function actionStatus($id){
        $model = $this->findModel($id);
        //\yii\helpers\VarDumper::dump($model,12,1);
        if($model->status == $model::STATUS_ACTIVE){
            $model->status = $model::STATUS_INACTIVE;
            Yii::$app->session->setFlash("success", "Succesfully Inactive.");
        }else {
            $model->status = $model::STATUS_ACTIVE;
            Yii::$app->session->setFlash("success", "Succesfully Active.");
        }
        $model->save();
        return $this->redirect(['index']);
    }
    
    public function actionSellerList(){
        $sellerModel = new SellerSearch(null);
        $sellerModel->searchstring = Yii::$app->request->get('q');
        $sellerDataProvider = $sellerModel->search(Yii::$app->request->queryParams);
        Yii::$app->response->format = Response::FORMAT_JSON;
        $result = [];
        foreach ($sellerDataProvider->getModels() as $seller){
           $result[] = ['id' => $seller->id, 'value' => $seller->fullName, 'email' => $seller->email];
        }
        return $result;
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
    public function actionDetailJson(){
        $userId             = Yii::$app->request->get('user_id');
        $model          = Agent::findOne($userId);
        Yii::$app->response->format = Response::FORMAT_JSON;
        if(empty($model)){
            throw new \yii\web\NotFoundHttpException('Agent does not exist');
        }
        $result = [
            'status' => true,
            'agent_data' => [
                'agent_id' => $model->agentID,
                'salutation' => $model->salutation,
                'first_name' => $model->first_name,
                'middle_name' => $model->middle_name,
                'last_name' => $model->last_name,
                'short_name' => $model->short_name,
                'gender' => $model->gender,
                'birthday' => $model->birthday,
                'timezone' => $model->timezone,
                'email' => $model->email,
                'short_name' => $model->short_name,
                'occupation' => $model->occupation,
                'calling_code' => $model->calling_code,
                'calling_code2' => $model->calling_code2,
                'calling_code3' => $model->calling_code3,
                'calling_code4' => $model->calling_code4,
                'mobile1' => $model->mobile1,
                'mobile2' => $model->mobile2,
                'mobile3' => $model->mobile3,
                'mobile4' => $model->mobile4,
                'office1' => $model->office1,
                'office2' => $model->office2,
                'office3' => $model->office3,
                'office4' => $model->office4,
                'fax1' => $model->fax1,
                'fax2' => $model->fax2,
                'fax3' => $model->fax3,
                'fax4' => $model->fax4,
            ]
        ];
        return $result;
    }
    
    public function actionViewAddress(){
        $userId             = Yii::$app->request->get('user_id');
        $index             = Yii::$app->request->get('index');
        $model          = Agent::findOne($userId);
        return $this->renderAjax('address_fields', ['model' => $model, 'index' => $index]);
    }
    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Agent::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
