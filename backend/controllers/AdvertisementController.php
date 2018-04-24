<?php

namespace backend\controllers;

use Yii;
use common\models\Advertisement;
use common\models\AdvertisementSearch;
use common\models\AdvertisementBannerSearch;
use common\models\AdvertisementBanner;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * AdvertisementController implements the CRUD actions for Advertisement model.
 */
class AdvertisementController extends Controller
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
     * Lists all Advertisement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdvertisementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Advertisement model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $bannerSearchModel = new AdvertisementBannerSearch();
        $bannerSearchModel->ad_id = $id;
        $bannerDataProvider = $bannerSearchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('view', [
            'model' => $this->findModel($id), 'bannerDataProvider' => $bannerDataProvider
        ]);
    }

    /**
     * Creates a new Advertisement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Advertisement();
        $bannerModels = [new AdvertisementBanner(['scenario' =>'create'])];
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->save();
                $model->locations = $_POST['Advertisement']['locations'];
                if(!empty($_POST['AdvertisementBanner'])){
//                    echo count($_POST['AdvertisementBanner']);die();
                    foreach ($_POST['AdvertisementBanner'] as $i => $banner) {
                        $bannerModel = new AdvertisementBanner(['scenario' =>'create']); //instantiate new AdvertisementLocation model
                        $bannerModel->ad_id = $model->id;
                        $bannerModel->title = $banner['title'];
                        $bannerModel->description = $banner['description'];
                        $bannerModel->text_color = $banner['text_color'];
                        $bannerModel->imageFiles = UploadedFile::getInstances($bannerModel, "[$i]imageFiles");
                        if($bannerModel->save()){
                            if (!empty($bannerModel->imageFiles)) {
                                $bannerModel->upload();
                            }
                        }
                    }
                }
                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->id]);
            } catch (Exception $ex) {
                $transaction->rollBack();
            }
        }
        return $this->render('create', [
            'model' => $model, 'bannerModels' => $bannerModels
        ]);

    }

    /**
     * Updates an existing Advertisement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $bannerModels = AdvertisementBanner::findAll(['ad_id' => $id]);
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->save();
                
                if(!empty($_POST['AdvertisementBanner'])){
                    foreach ($_POST['AdvertisementBanner'] as $i => $banner) {
                        if (!empty($banner['id']) && $banner['_destroy'] == 1) {
                            AdvertisementBanner::findOne($banner['id'])->delete();
                            continue;
                        }
                        if (!empty($banner['id']) && !$banner['_destroy']) {
                            $bannerModel = AdvertisementBanner::findOne($banner['id']);
                        } elseif (empty($banner['id']) && !$banner['_destroy']) {
                            $bannerModel = new AdvertisementBanner();
                            $bannerModel->ad_id = $model->id;
                        } elseif (empty($banner['id']) && $banner['_destroy'] == 1) {
                            continue;
                        }
                        
                        $bannerModel->title = $banner['title'];
                        $bannerModel->description = $banner['description'];
                        $bannerModel->text_color = $banner['text_color'];
                        $bannerModel->imageFiles = UploadedFile::getInstances($bannerModel, "[$i]imageFiles");
//                        print_r($bannerModel->imageFiles);die();
                        if($bannerModel->save()){
                            if (!empty($bannerModel->imageFiles)) {
                                $bannerModel->upload();
                            }
                        }else{
                            print_r($bannerModel->errors);die();
                        }
                    }
                }
                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->id]);
            } catch (Exception $ex) {
                $transaction->rollBack();
            }
        } else {
            return $this->render('update', [
                'model' => $model, 'bannerModels' => $bannerModels
            ]);
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
    
    
    
    /**
     * Deletes an existing Advertisement model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        foreach ($model->advertisementBanners as $banner){
            $banner->photo->delete();
        }
        $model->delete();
        Yii::$app->session->setFlash('success', 'Successfully deleted');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Advertisement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Advertisement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Advertisement::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
