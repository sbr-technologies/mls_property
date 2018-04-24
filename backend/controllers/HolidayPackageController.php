<?php

namespace backend\controllers;

use Yii;
use common\models\HolidayPackage;
use common\models\HolidayPackageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\MetaTag;
use yii\helpers\StringHelper;
use common\models\HolidayPackageType;
use common\models\HolidayPackageFeature;
use common\models\HolidayPackageFeatureItem;
use common\models\HolidayPackageItinerary;
use common\models\HolidayPackageItinerarySearch;

use common\models\PhotoGallery;
use yii\web\UploadedFile;

/**
 * HolidayPackageController implements the CRUD actions for HolidayPackage model.
 */
class HolidayPackageController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors(){
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
     * Lists all HolidayPackage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HolidayPackageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HolidayPackage model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    
    /**
     * Creates a new HolidayPackage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate(){
        $model = new HolidayPackage();
        $metaTagModel       = new MetaTag();
        $packageFeature     =   [new HolidayPackageFeature()];
        $packageFeatureItem =   [new HolidayPackageFeatureItem()];
        
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
                if($model->save()){
                    if(!empty($model->imageFiles)){
                        $model->upload();
                    }
                    if(isset($_POST['MetaTag']) && is_array($_POST['MetaTag']) && count($_POST['MetaTag']) > 0){
                        $modelName = StringHelper::basename($model->className());
                        $metaTagModel                   = new MetaTag();
                        $metaTagModel->model            = $modelName;
                        $metaTagModel->model_id         = $model->id;
                        $metaTagModel->page_title       = $_POST['MetaTag']['page_title'];
                        $metaTagModel->description      = $_POST['MetaTag']['description'];
                        $metaTagModel->keywords         = $_POST['MetaTag']['keywords'];
                        $metaTagModel->save();
                    }
                    //\yii\helpers\VarDumper::dump($_POST['HolidayPackageFeature']); exit;
                    if(isset($_POST['HolidayPackageFeature']) && is_array($_POST['HolidayPackageFeature']) && count($_POST['HolidayPackageFeature']) > 0){
                        //echo count($_POST['HolidayPackageFeature']);die();
                        foreach ($_POST['HolidayPackageFeature'] as $i => $feature) {
                            $featureModel = new HolidayPackageFeature(); //instantiate new HolidayPackageFeature model
                            $featureModel->holiday_package_id = $model->id;
                            $featureModel->holiday_package_type_id = $feature['holiday_package_type_id'];
                            if($featureModel->save()){
                                //\yii\helpers\VarDumper::dump($_POST['HolidayPackageFeatureItem'],4,12); exit;
                                if(!empty($_POST['HolidayPackageFeatureItem'][$i])){
                                    foreach ($_POST['HolidayPackageFeatureItem'][$i] as $item) {
                                        if(!empty($item['name'])){
                                            $itemModel = new HolidayPackageFeatureItem(); //instantiate new HolidayPackageFeature model
                                            $itemModel->package_feature_id = $featureModel->id;
                                            $itemModel->name = $item['name'];
                                            if($itemModel->save()){
                                                
                                               // \yii\helpers\VarDumper::dump($itemModel->errors);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
//                    if(isset($_POST['HolidayPackageActivity']) && is_array($_POST['HolidayPackageActivity']) && count($_POST['HolidayPackageActivity']) > 0){
//                        foreach($_POST['HolidayPackageActivity'] as $activityInfo){
//                            $packageActivity                          = new HolidayPackageActivity();
//                            
//                            $packageActivity->holiday_package_id      = $model->id;
//                            $packageActivity->title                   = $activityInfo['title'];
//                            $packageActivity->description             = $activityInfo['description'];
//                            $packageActivity->imageFiles = UploadedFile::getInstances($packageActivity, "[$i]imageFiles");
//                            if($packageActivity->save()){
//                                if(!empty($packageActivity->imageFiles)){
//                                    $packageActivity->upload();
//                                }
//                            }
//                        }
//                    }
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (Exception $ex) {
                $transaction->rollBack();
                print_r($ex);
            }
        } else {
            return $this->render('create', [
                'model'             => $model,
                'metaTagModel'      =>  $metaTagModel,
                'packageFeature'    =>  $packageFeature,
                'packageFeatureItem'=>  $packageFeatureItem,
//                'packageActivity'   =>  $packageActivity,
            ]);
        }
    }

    /**
     * Updates an existing HolidayPackage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id){
        $model = $this->findModel($id);
        $metaTagModel           = MetaTag::find()->where(['model_id' => $model->id, 'model' => StringHelper::basename($model->className())])->one();
        $packageFeature         = HolidayPackageFeature::findAll(['holiday_package_id' => $id]);
        $packageFeatureItem     = $model->holidayFeatures;
//        $packageActivity        = HolidayPackageActivity::findAll(['holiday_package_id' => $model->id]);
        if ($model->load(Yii::$app->request->post()) ) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
                if($model->save()){
                    if(!empty($model->imageFiles)){
                        $model->upload();
                    }
                    if ($metaTagModel->load(Yii::$app->request->post())) {
                        if(!$metaTagModel->save()){
                            print_r($metaTagModel->errors);die();
                        }
                    }
                    
                    if(!empty($_POST['HolidayPackageFeature'])){
                        foreach ($_POST['HolidayPackageFeature'] as $i => $feature) {
                            if (!empty($feature['id']) && $feature['_destroy'] == 1) {
                                HolidayPackageFeature::findOne($feature['id'])->delete();
                                continue;
                            }
                            if (!empty($feature['id']) && !$feature['_destroy']) {
                                $featureModel = HolidayPackageFeature::findOne($feature['id']);
                            } elseif (empty($feature['id']) && !$feature['_destroy']) {
                                $featureModel = new HolidayPackageFeature();
                                $featureModel->holiday_package_id = $model->id;
                            } elseif (empty($feature['id']) && $feature['_destroy'] == 1) {
                                continue;
                            }
                            $featureModel->holiday_package_id = $model->id;
                            $featureModel->holiday_package_type_id = $feature['holiday_package_type_id'];
                           
                            if($featureModel->save()){
                                //\yii\helpers\VarDumper::dump($_POST['HolidayPackageFeatureItem'],4,12); exit;
                                if(!empty($_POST['HolidayPackageFeatureItem'][$i])){
                                    HolidayPackageFeatureItem::deleteAll(['package_feature_id' => $featureModel->id]);
                                    foreach ($_POST['HolidayPackageFeatureItem'][$i] as $item) {
                                        if(!empty($item['name'])){
                                            $itemModel = new HolidayPackageFeatureItem(); //instantiate new HolidayPackageFeature model
                                            $itemModel->package_feature_id = $featureModel->id;
                                            $itemModel->name = $item['name'];
                                            if($itemModel->save()){
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }else{
                    print_r($model->errors);
                }
            } catch (Exception $ex) {
                $transaction->rollBack();
                print_r($ex);
            }
        }
        return $this->render('update', [
            'model'             => $model,
            'metaTagModel'      =>  $metaTagModel,
            'packageFeature'    =>  $packageFeature,
            'packageFeatureItem'=>  $packageFeatureItem,
//                'packageActivity'   =>  $packageActivity,
        ]);
    }

    /**
     * Deletes an existing HolidayPackage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        foreach ($model->photos as $photo){
            $photo->delete();
        }
        $packageFeature = HolidayPackageFeature::findAll(['holiday_package_id' => $id]);
        if(!empty($packageFeature)){
            HolidayPackageFeature::deleteAll(['holiday_package_id' => $id]);
        }
        
        $model->delete();
        return $this->redirect(['index']);
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
     * Finds the HolidayPackage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HolidayPackage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    
    public function actionItineraryList($id){
        $searchModel = new HolidayPackageItinerarySearch();
        $searchModel->holiday_package_id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('itinerary-list', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
            'id'            =>  $id,
            //'hotel_id'      =>  $hotel_id,
        ]);
    }
    
    public function actionCreateItinerary($holiday_package_id){
        $itineraryModel  =   new HolidayPackageItinerary();
        if ($itineraryModel->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $itineraryModel->imageFiles = UploadedFile::getInstances($itineraryModel, 'imageFiles');
                if($itineraryModel->save()){
                    if(!empty($itineraryModel->imageFiles)){
                        $itineraryModel->upload();
                    }
                    $transaction->commit();
                    return $this->redirect(['itinerary-list', 'id' => $holiday_package_id]);
                }
            } catch (Exception $ex) {
                $transaction->rollBack();
            }
        } else {
            return $this->render('create-itinerary', [
                'itineraryModel'        => $itineraryModel, 
                'holiday_package_id'    => $holiday_package_id,
            ]);
        }
    }
    /**
     * Displays a single Hotel model.
     * @param integer $id
     * @return mixed
     */
    public function actionItineraryView($id)
    {
        $itineraryModel         =   $this->findItineraryModel($id);
        $holiday_package_id     =   $itineraryModel->holiday_package_id;
        //\yii\helpers\VarDumper::dump($hotel_id); exit;
        return $this->render('itinerary-view', [
            'itineraryModel'        =>  $itineraryModel,
            'holiday_package_id'    =>  $holiday_package_id,
            'id'                    =>  $id,
        ]);
    }
    
    public function actionItineraryUpdate($id)
    {
        $itineraryModel         = $this->findItineraryModel($id);
        $holiday_package_id     =   $itineraryModel->holiday_package_id;
        if ($itineraryModel->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $itineraryModel->imageFiles = UploadedFile::getInstances($itineraryModel, 'imageFiles');
                if($itineraryModel->save()){
                    if(!empty($itineraryModel->imageFiles)){
                        $itineraryModel->upload();
                    }
                    $transaction->commit();
                    return $this->redirect(['itinerary-view', 'id' => $itineraryModel->id]);
                }
            } catch (Exception $ex) {
                $transaction->rollBack();
            }
        } 
        return $this->render('itinerary-update', [
            'itineraryModel'        =>  $itineraryModel,
            'holiday_package_id'    =>  $holiday_package_id,
        ]);
    }
    
    /**
     * Deletes an existing Hotel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionItineraryDelete($id)
    {
        $itineraryModel                 =   $this->findItineraryModel($id);
        $searchModel                    =   new HolidayPackageItinerarySearch();
        $holiday_package_id             =   $itineraryModel->holiday_package_id;
        $itineraryModel->delete();
        $searchModel->holiday_package_id = $holiday_package_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        Yii::$app->session->setFlash('success', 'Successfully deleted');
        return $this->render('itinerary-list', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
            'id'            =>  $holiday_package_id,
        ]);
        
    }
    
    public function actionDeletePhoto($id)
    {
        $photo = PhotoGallery::findOne($id);
        if($photo->delete()){
            echo json_encode(array('status' => 'success', 'message' => 'One image delete successfully'));die();
        }else{
            echo json_encode(array('status' => 'failed', 'message' =>'Sorry, We are unable to process your data'));die();
        }
    }
    protected function findItineraryModel($id)
    {
        if (($itineraryModel = HolidayPackageItinerary::findOne($id)) !== null) {
            return $itineraryModel;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findModel($id)
    {
        if (($model = HolidayPackage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
