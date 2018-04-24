<?php

namespace backend\controllers;

use Yii;
use common\models\Rental;
use common\models\RentalSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use common\models\RentalLocationLocalInfo;
use common\models\PhotoGallery;
use common\models\MetaTag;
use yii\web\UploadedFile;
use yii\helpers\StringHelper;
use common\models\RentalPlan;

use common\models\RentalFeature;
use common\models\RentalFeatureItem;
use common\models\RentalFeatureMaster;
use common\models\RentalFeatureMasterSearch;
use common\models\OpenHouse;


/**
 * RentalController implements the CRUD actions for Rental model.
 */
class RentalController extends Controller
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
     * Lists all Rental models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RentalSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Rental model.
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
     * Creates a new Rental model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model              = new Rental(['scenario' =>'create']);
        $localInfoModel     = [new RentalLocationLocalInfo()];
        $metaTagModel       = new MetaTag();
        $rentalTypeModel    = [new RentalPlan()];
        $featureModel       = [new RentalFeature()];
        $featureItemModel   = [new RentalFeatureItem()];
        $openHouseModel     = new OpenHouse(); 
       // \yii\helpers\VarDumper::dump($model); exit;
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
                if($model->save()){
                    if(!empty($model->imageFiles)){
                        $model->upload();
                    }
                    // \yii\helpers\VarDumper::dump($_POST['RentalLocationLocalInfo']); exit;
                    if(isset($_POST['RentalLocationLocalInfo']) && is_array($_POST['RentalLocationLocalInfo']) && count($_POST['RentalLocationLocalInfo']) > 0){
                        foreach($_POST['RentalLocationLocalInfo'] as $rentalLocation){
                            $localInfoModel                 = new RentalLocationLocalInfo();
                            $localInfoModel->rental_id      = $model->id;
                            $localInfoModel->local_info_type_id = $rentalLocation['local_info_type_id'];
                            $localInfoModel->title          = $rentalLocation['title'];
                            $localInfoModel->description    = $rentalLocation['description'];
                            $localInfoModel->status    = "active";
                            $localInfoModel->save();
                        }
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
                    if(isset($_POST['RentalPlan']) && is_array($_POST['RentalPlan']) && count($_POST['RentalPlan']) > 0){
                        foreach($_POST['RentalPlan'] as $rental){
                            $rentalTypeModel                    = new RentalPlan();
                            $rentalTypeModel->rental_id         = $model->id;
                            $rentalTypeModel->rental_plan_id    = $rental['rental_plan_id'];
                            $rentalTypeModel->name              = $rental['name'];
                            $rentalTypeModel->bed               = $rental['bed'];
                            $rentalTypeModel->bath              = $rental['bath'];
                            $rentalTypeModel->size              = $rental['size'];
                            $rentalTypeModel->price             = $rental['price'];
                            $rentalTypeModel->status            = 'active';
                            $rentalTypeModel->save();
                        }
                    }
                    
                    ///\yii\helpers\VarDumper::dump($_POST['RentalFeature']); exit;
                    if(isset($_POST['RentalFeature']) && is_array($_POST['RentalFeature']) && count($_POST['RentalFeature']) > 0){
                        foreach ($_POST['RentalFeature'] as $i => $feature) {
                            $featureModel = new RentalFeature(); //instantiate new RentalFeature model
                            $featureModel->rental_id = $model->id;
                            $featureModel->feature_master_id = $feature['feature_master_id'];
                            if($featureModel->save()){
                                if(!empty($_POST['RentalFeatureItem'][$i])){
                                    foreach ($_POST['RentalFeatureItem'][$i] as $item) {
                                        if(!empty($item['name'])){
                                            $itemModel = new RentalFeatureItem(); //instantiate new RentalFeature model
                                            $itemModel->rental_feature_id = $featureModel->id;
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
                    if(isset($_POST['OpenHouse']) && is_array($_POST['OpenHouse']) && count($_POST['OpenHouse']) > 0){
                        $modelName                          = StringHelper::basename($model->className());
                        $openHouseModel                     = new OpenHouse();
                        $openHouseModel->model              = $modelName;
                        $openHouseModel->model_id           = $model->id;
                        $openHouseModel->startdate          = $_POST['OpenHouse']['startdate'];
                        $openHouseModel->enddate            = $_POST['OpenHouse']['enddate'];
                        $openHouseModel->starttime          = $_POST['OpenHouse']['starttime'];
                        $openHouseModel->endtime            = $_POST['OpenHouse']['endtime'];
                        $openHouseModel->save();
                        
                    }
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }else{
                    print_r($model->errors); die();
                }
            } catch (Exception $ex) {
                $transaction->rollBack();
                print_r($ex);
            }
        }
        return $this->render('create', [
            'model'             =>  $model,
            'localInfoModel'    =>  $localInfoModel,
            'metaTagModel'      =>  $metaTagModel,
            'rentalTypeModel'   =>  $rentalTypeModel,
            'featureModel'      =>  $featureModel,
            'featureItemModel'  =>  $featureItemModel,
            'openHouseModel'    =>  $openHouseModel,
        ]);
    }

    /**
     * Updates an existing Rental model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->profile_id  =   $model->user->profile_id;
        $localInfoModel = RentalLocationLocalInfo::findAll(['rental_id' => $model->id]);
        $metaTagModel       = MetaTag::find()->where(['model_id' => $model->id, 'model' => StringHelper::basename($model->className())])->one();
        $rentalTypeModel     = RentalPlan::findAll(['rental_id' => $model->id]);
        $featureModel       = RentalFeature::findAll(['rental_id' => $id]);
        $openHouseModel     = OpenHouse::find()->where(['model_id' => $model->id, 'model' => StringHelper::basename($model->className())])->one();
        if(empty($openHouseModel)){
            $openHouseModel     = new OpenHouse();
        }
        $propertyfeature   = $model->rentalFeatures;
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
                if($model->save()){
                    if(!empty($model->imageFiles)){
                        $model->upload();
                    }
                    $rentalLocalInfo = Yii::$app->request->post('RentalLocationLocalInfo');
                    if(!empty($rentalLocalInfo)){
                        foreach ($rentalLocalInfo as $child) {
                            if (!empty($child['id']) && $child['_destroy'] == 1) {
                                RentalLocationLocalInfo::findOne($child['id'])->delete();
                                continue;
                            }
                            if (!empty($child['id']) && !$child['_destroy']) {
                                $childModel = RentalLocationLocalInfo::findOne($child['id']);
                            } elseif (empty($child['id']) && !$child['_destroy']) {
                                $childModel = new RentalLocationLocalInfo();
                                $childModel->property_id = $model->id;
                            } elseif (empty($child['id']) && $child['_destroy'] == 1) {
                                continue;
                            }

                            $childModel->local_info_type_id  = $child['local_info_type_id'];
                            $childModel->lat                = $child['lat'];
                            $childModel->lng                = $child['lng'];
                            $childModel->title              = $child['title'];
                            $childModel->description        = $child['description'];
                            if(!$childModel->save()){
    //                            print_r($childModel->errors);die();
                            }
                        }
                    }
                    $rentalTypeModel = Yii::$app->request->post('RentalPlan');
                    if(!empty($rentalTypeModel)){
                        foreach ($rentalTypeModel as $child) {
                            if (!empty($child['id']) && $child['_destroy'] == 1) {
                                RentalPlan::findOne($child['id'])->delete();
                                continue;
                            }
                            if (!empty($child['id']) && !$child['_destroy']) {
                                $childModel = RentalPlan::findOne($child['id']);
                            } elseif (empty($child['id']) && !$child['_destroy']) {
                                $childModel = new RentalPlan();
                                $childModel->rental_id = $model->id;
                            } elseif (empty($child['id']) && $child['_destroy'] == 1) {
                                continue;
                            }
                            //$taxHistoryModel                  = new PropertyTaxHistory();
                            
                            $childModel->rental_plan_id    = $child['rental_plan_id'];
                            $childModel->name              = $child['name'];
                            $childModel->bed               = $child['bed'];
                            $childModel->bath              = $child['bath'];
                            $childModel->size              = $child['size'];
                            $childModel->price             = $child['price'];
                            $childModel->status            = 'active';
                            
                            if(!$childModel->save()){
                                print_r($childModel->errors);die();
                            }
                        }
                    }
                    if(!empty($_POST['RentalFeature'])){
                        foreach ($_POST['RentalFeature'] as $i => $feature) {
                            if (!empty($feature['id']) && $feature['_destroy'] == 1) {
                                RentalFeature::findOne($feature['id'])->delete();
                                continue;
                            }
                            if (!empty($feature['id']) && !$feature['_destroy']) {
                                $featureModel = RentalFeature::findOne($feature['id']);
                            } elseif (empty($feature['id']) && !$feature['_destroy']) {
                                $featureModel = new RentalFeature();
                                $featureModel->rental_id = $model->id;
                            } elseif (empty($feature['id']) && $feature['_destroy'] == 1) {
                                continue;
                            }
                            $featureModel->rental_id = $model->id;
                            $featureModel->feature_master_id = $feature['feature_master_id'];
                            if($featureModel->save()){
                                if(!empty($_POST['RentalFeatureItem'][$i])){
                                    RentalFeatureItem::deleteAll(['rental_feature_id' => $featureModel->id]);
                                    foreach ($_POST['RentalFeatureItem'][$i] as $item) {
                                        if(!empty($item['name'])){
                                            $itemModel = new RentalFeatureItem(); //instantiate new RentalFeature model
                                            $itemModel->rental_feature_id = $featureModel->id;
                                            $itemModel->name = $item['name'];
                                            if($itemModel->save()){
                                               // \yii\helpers\VarDumper::dump($itemModel->errors);
                                            }
                                        }
                                        //echo "<pre>"; print_r($i); echo "<pre>"; 
                                        //echo "<pre>"; print_r($i."++".$item['name']); echo "<pre>"; 
                                    }//exit;
                                }
                            }
                        }//exit;
                    }
                    $openHouse = Yii::$app->request->post('OpenHouse');
                   // \yii\helpers\VarDumper::dump($openHouse,4,12); exit;
                    if(isset($openHouse) && is_array($openHouse) && count($openHouse) > 0){
                        OpenHouse::deleteAll(['model_id' => $model->id, 'model' => 'Rental']);
                        $modelName                          = StringHelper::basename($model->className());
                        $openHouseModel                     = new OpenHouse();
                        $openHouseModel->model              = $modelName;
                        $openHouseModel->model_id           = $model->id;
                        $openHouseModel->startdate          = $_POST['OpenHouse']['startdate'];
                        $openHouseModel->enddate            = $_POST['OpenHouse']['enddate'];
                        $openHouseModel->starttime          = $_POST['OpenHouse']['starttime'];
                        $openHouseModel->endtime            = $_POST['OpenHouse']['endtime'];
                        $openHouseModel->save();
                        
                    }
                    if ($metaTagModel->load(Yii::$app->request->post())) {
                        if(!$metaTagModel->save()){
                            print_r($metaTagModel->errors);die();
                        }
                    }
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }else{
                    \yii\helpers\VarDumper::dump($model->errors); die();
                }
            } catch (Exception $ex) {
                $transaction->rollBack();
                \yii\helpers\VarDumper::dump($model->errors); die();
            }
        }
        return $this->render('update', [
            'model'             =>  $model,
            'localInfoModel'    =>  $localInfoModel,
            'rentalTypeModel'   =>  $rentalTypeModel,
            'metaTagModel'      =>  $metaTagModel,
            'featureModel'     =>  $featureModel,
            'openHouseModel'    =>  $openHouseModel,
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
    /**
     * Deletes an existing Rental model.
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
        $openHouse = OpenHouse::findOne(['model_id' => $id,'model' => 'Rental']);
        if(!empty($openHouse)){
            $openHouse->delete();
        }
        RentalLocationLocalInfo::deleteAll(['rental_id' => $id]);
        RentalPlan::deleteAll(['rental_id' => $id]);
        $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Rental model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Rental the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Rental::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
