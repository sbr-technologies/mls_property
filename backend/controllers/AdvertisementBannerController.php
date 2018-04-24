<?php

namespace backend\controllers;

use Yii;
use common\models\AdvertisementBanner;
use common\models\AdvertisementBannerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\PhotoGallery;
use yii\web\Response;

use yii\web\UploadedFile;

/**
 * AdvertisementBannerController implements the CRUD actions for AdvertisementBanner model.
 */
class AdvertisementBannerController extends Controller
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
     * Lists all AdvertisementBanner models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdvertisementBannerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AdvertisementBanner model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(!Yii::$app->request->isAjax){
            $this->goBack();
        }
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
        
    }

    /**
     * Creates a new AdvertisementBanner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($ad_id = Null)
    {
        $model = new AdvertisementBanner(['scenario' =>'create']);

        if ($model->load(Yii::$app->request->post())) {

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
//                print_r($model->imageFiles);die();
                if($model->save()){
                    if(!empty($model->imageFiles)){
                        $model->upload();
                    }
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }else{
                    print_r($model->errors);die();
                }
            } catch (Exception $ex) {
                $transaction->rollBack();
            }
        }
        if(!empty($ad_id)){
            $model->ad_id = $ad_id;
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AdvertisementBanner model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(!Yii::$app->request->isAjax){
            $this->goBack();
        }
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($model->save()){
                return ['status' => 'success'];
            }else{
                return ['status' => 'failed'];
            }
        } 
        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }
    
    /**
     * Deletes an existing AdvertisementBanner model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(!Yii::$app->request->isAjax){
            $this->goBack();
        }
        $this->findModel($id)->delete(); 
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
        }else {
            $model->status = $model::STATUS_ACTIVE;
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($model->save()){
            return ['status' => 'success'];
        }
        return ['status' => 'failed'];
    }
    
    /**
     * Finds the AdvertisementBanner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdvertisementBanner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdvertisementBanner::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
