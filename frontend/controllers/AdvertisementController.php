<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\controllers;
use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\UploadedFile;
use common\models\Advertisement;
use common\models\AdvertisementSearch;
use common\models\AdvertisementBanner;
use common\models\AdvertisementBannerSearch;
use common\models\AdvertisementLocation;
use frontend\helpers\AuthHelper;

class AdvertisementController extends Controller {
    
    public $context;
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'update', 'view', 'delete'],
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
    public function init() {
        parent::init();
        $this->context = ['service_id' => 4];
    }
    
    public function actionIndex(){
        $this->layout   =   'main';
        $searchModel = new AdvertisementSearch();
        $searchModel->user_id = Yii::$app->user->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
    }
    
    public function actionCreate(){
//        if(!AuthHelper::Can($this->context)){
//            throw new \yii\web\UnauthorizedHttpException('You are not subscribed for this');
//        }
        $model = new Advertisement();
        $bannerModels = [new AdvertisementBanner(['scenario' =>'create'])];
        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            $model->status = "pending";
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->save();
                $model->locations = $_POST['Advertisement']['locations'];
                if(!empty($_POST['AdvertisementBanner'])){
                   // echo count($_POST['AdvertisementBanner']);die();
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
                return $this->redirect(['index', 'id' => $model->id]);
            } catch (Exception $ex) {
                $transaction->rollBack();
            }
        }
        return $this->render('create', [
            'model' => $model, 'bannerModels' => $bannerModels
        ]);

    }
    
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
                return $this->redirect(['index', 'id' => $model->id]);
            } catch (Exception $ex) {
                $transaction->rollBack();
            }
        } else {
            return $this->render('update', [
                'model' => $model, 'bannerModels' => $bannerModels
            ]);
        }
    }
    
    public function actionView($id){
        $this->layout           =   'main';
        $model = $this->findModel($id);
        $advBanner  = AdvertisementBanner::find()->where(['ad_id' => $model->id])->one();
        $advBannerLocation  = AdvertisementLocation::find()->where(['ad_id' => $model->id])->one();
        //\yii\helpers\VarDumper::dump($advBanner); exit;
        
        
        return $this->render('view', [
            'model'             =>  $model,
            'advBanner'         =>  $advBanner,
            'advBannerLocation' =>  $advBannerLocation
            
        ]);
        
    }
    
    public function actionDelete($id){
        $model = $this->findModel($id);
        $advBanner  =   AdvertisementBanner::findAll(['ad_id' => $id]);
        if(isset( $advBanner->photo)){
            $advBanner->photo->delete();
        }
        AdvertisementBanner::deleteAll(['ad_id' => $id]);  
        
        
        $model->delete();
        
        Yii::$app->session->setFlash('success', 'Successfully deleted');
        //return $this->redirect(['index']);
    }
    
    public function actionRedirect($id){
        if(!is_numeric($id))
        {
            $id = decode($id);
        }
        $ad_details = Advertisement::findOne($id);
        $ad_details->updateCounters(['total_viewed' => 1]);
        echo 'Redirecting to '. urlencode($ad_details->link);
        echo "<script>setTimeout(\"location.replace('".$ad_details->link."');\",1500);</script>";
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