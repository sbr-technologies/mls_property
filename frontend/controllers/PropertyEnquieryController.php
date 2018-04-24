<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\PropertyEnquiery;
use common\models\PropertyEnquierySearch;
use common\models\PropertyEnquieryFeedback;
use common\models\PropertyEnquieryFeedbackSearch;
use yii\filters\AccessControl;
use frontend\helpers\AuthHelper;


/**
 * PropertyEnquieryController implements the CRUD actions for PropertyEnquiery model.
 */
class PropertyEnquieryController extends Controller
{
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'replay-feedback', 'delete-property-enquiery'],
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
     * Lists all PropertyEnquiery models.
     * @return mixed
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        $searchModel                = new PropertyEnquierySearch();
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
     * Displays a single PropertyEnquiery model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $enquieryFeedback    =   new PropertyEnquieryFeedback();
        $model              =   $this->findModel($id);
        $propertyId         =   $model->model_id;
        return $this->render('view', [
            'model'             => $model,
            'enquieryFeedback'  => $enquieryFeedback,
            'id'                => $id,
            'propertyId'        =>  $propertyId,
        ]);
    }
    
    public function actionReplayFeedback(){
        $requestFeedback                    =   new PropertyEnquieryFeedback();
        if ($requestFeedback->load(Yii::$app->request->post())) {
            Yii::$app->response->format     = Response::FORMAT_JSON;
            $requestFeedback->user_id       = Yii::$app->user->id;
            $requestFeedback->status        = 'active';
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if($requestFeedback->save()){
                    $transaction->commit();
                    return ['success' => true,'message' => 'Your replay on property enquiery send successfully'];
                }else{
                    return ['success' => false,'errors' => $requestFeedback->errors];
                }
                
            } catch (Exception $ex) {
                $transaction->rollBack();
            }
        }
    }
    public function actionPropertyEnquieryReplayList($proerty_enquiery_id){
        $this->layout   =   'ajax';
        $searchModel = new PropertyEnquieryFeedbackSearch();
        $searchModel->proerty_enquiery_id = $proerty_enquiery_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       // \yii\helpers\VarDumper::dump($dataProvider); exit;
        return $this->render('property-enquiery-replay-list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        
    }
    public function actionDeletePropertyEnquiery(){
        if(Yii::$app->request->isAjax){
            $loopCnt        =   0;
            $saveCnt        =   0;
            Yii::$app->response->format     = Response::FORMAT_JSON;
            $id     =   Yii::$app->request->get('id');
            //\yii\helpers\VarDumper::dump($id); exit;
            $transaction = Yii::$app->db->beginTransaction();
            $deleteObj        =   PropertyEnquieryFeedback::find()->where(['id' => $id])->one();
            if(!empty($deleteObj)){
                $loopCnt++;
                try {
                    PropertyEnquieryFeedback::findOne($id)->delete();
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
     * Creates a new PropertyEnquiery model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PropertyEnquiery();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PropertyEnquiery model.
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
     * Deletes an existing PropertyEnquiery model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Successfully deleted');
        return $this->redirect(['index']);
    }

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
    
    /**
     * Finds the PropertyEnquiery model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PropertyEnquiery the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PropertyEnquiery::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
