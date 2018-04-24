<?php

namespace backend\controllers;

use Yii;
use common\models\Hotel;
use common\models\HotelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use common\models\PhotoGallery;

use yii\web\UploadedFile;
use common\models\MetaTag;
use yii\helpers\StringHelper;

use common\models\HotelFacility;
use common\models\RoomFacility;
use common\models\RoomType;
use common\models\HotelRoom;
use common\models\HotelRoomSearch;

/**
 * HotelController implements the CRUD actions for Hotel model.
 */
class HotelController extends Controller
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
     * Lists all Hotel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HotelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Hotel model.
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
     * Creates a new Hotel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model              = new Hotel(['scenario' =>'create']);
        $metaTagModel       = new MetaTag();
        $facilityModel      = [new HotelFacility()];
        $facilityRoomModel  = [new RoomFacility()];
        if ($model->load(Yii::$app->request->post())) {
            //\yii\helpers\VarDumper::dump($model,4,12);  exit;
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
                    //\yii\helpers\VarDumper::dump($_POST['HotelFacility']);exit;
                    if(isset($_POST['HotelFacility']) && is_array($_POST['HotelFacility']) && count($_POST['HotelFacility']) > 0){
                        foreach($_POST['HotelFacility'] as $facility){
                            $facilityModel                   = new HotelFacility();
                            $facilityModel->hotel_id         = $model->id;
                            $facilityModel->title            = $facility['title'];
                            $facilityModel->save();
                        }
                    }
                    if(isset($_POST['RoomFacility']) && is_array($_POST['RoomFacility']) && count($_POST['RoomFacility']) > 0){
                        foreach($_POST['RoomFacility'] as $roomFacility){
                            $facilityRoomModel                   = new RoomFacility();
                            $facilityRoomModel->hotel_id         = $model->id;
                            $facilityRoomModel->title            = $roomFacility['title'];
                            $facilityRoomModel->description      = $roomFacility['description'];
                            $facilityRoomModel->save();
                        }
                    }
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (Exception $ex) {
                $transaction->rollBack();
            }
        } else {
            return $this->render('create', [
                'model'             => $model,
                'metaTagModel'      =>  $metaTagModel,
                'facilityModel'     =>  $facilityModel,
                'facilityRoomModel'=>  $facilityRoomModel,
            ]);
        }
    }

    /**
     * Updates an existing Hotel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $metaTagModel  = MetaTag::find()->where(['model_id' => $model->id, 'model' => StringHelper::basename($model->className())])->one();
        $facilityModel = HotelFacility::findAll(['hotel_id' =>  $model->id]);
        $facilityRoomModel = RoomFacility::findAll(['hotel_id' =>  $model->id]);
        if ($model->load(Yii::$app->request->post())) {
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
                    $facilityModel = Yii::$app->request->post('HotelFacility');
                    if(empty($facilityModel)){
                        throw new NotFoundHttpException(Yii::t('app', 'Invalid data'));
                    }
                    foreach ($facilityModel as $child) {
                        if (!empty($child['id']) && $child['_destroy'] == 1) {
                            HotelFacility::findOne($child['id'])->delete();
                            continue;
                        }
                        if (!empty($child['id']) && !$child['_destroy']) {
                            $childModel = HotelFacility::findOne($child['id']);
                        } elseif (empty($child['id']) && !$child['_destroy']) {
                            $childModel = new HotelFacility();
                            $childModel->hotel_id = $model->id;
                        } elseif (empty($child['id']) && $child['_destroy'] == 1) {
                            continue;
                        }
                        //$taxHistoryModel                  = new PropertyTaxHistory();
                        $childModel->hotel_id         = $model->id;
                        $childModel->title            = $child['title'];
                        $childModel->save();
                        
                        if(!$childModel->save()){
                            print_r($childModel->errors);die();
                        }
                    }
                    $roomFacilityModel = Yii::$app->request->post('RoomFacility');
                    if(empty($roomFacilityModel)){
                        throw new NotFoundHttpException(Yii::t('app', 'Invalid data'));
                    }
                    foreach ($roomFacilityModel as $child) {
                        if (!empty($child['id']) && $child['_destroy'] == 1) {
                            RoomFacility::findOne($child['id'])->delete();
                            continue;
                        }
                        if (!empty($child['id']) && !$child['_destroy']) {
                            $childModel = RoomFacility::findOne($child['id']);
                        } elseif (empty($child['id']) && !$child['_destroy']) {
                            $childModel = new RoomFacility();
                            $childModel->hotel_id = $model->id;
                        } elseif (empty($child['id']) && $child['_destroy'] == 1) {
                            continue;
                        }
                        //$taxHistoryModel                  = new PropertyTaxHistory();
                        $childModel->hotel_id         = $model->id;
                        $childModel->title            = $child['title'];
                        $childModel->description      = $child['description'];
                        $childModel->save();
                        
                        if(!$childModel->save()){
                            print_r($childModel->errors);die();
                        }
                    }
                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (Exception $ex) {
                $transaction->rollBack();
            }
        } 
        return $this->render('update', [
            'model'             => $model,
            'metaTagModel'      =>  $metaTagModel,
            'facilityModel'     =>  $facilityModel,
            'facilityRoomModel' =>  $facilityRoomModel,
        ]);
    }

    /**
     * Deletes an existing Hotel model.
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
        
        foreach ($model->hotelFacilities as $facility){
            $facility->delete();
        }
        foreach ($model->roomFacilities as $roomFacility){
            $roomFacility->delete();
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
    public function actionCreateRoom($hotel_id){
        $roomModel  =   new HotelRoom();
        if ($roomModel->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if($roomModel->save()){
                    $transaction->commit();
                    return $this->redirect(['room-list', 'id' => $hotel_id]);
                }
            } catch (Exception $ex) {
                $transaction->rollBack();
            }
        } else {
            return $this->render('create-room', [
                'roomModel'             => $roomModel, 
                'hotel_id'              => $hotel_id,
            ]);
        }
        
    } 
    public function actionRoomList($id){
       
        $searchModel = new HotelRoomSearch();
        $searchModel->hotel_id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('room-list', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
            'id'            =>  $id,
            //'hotel_id'      =>  $hotel_id,
        ]);
    }
    public function actionRoomStatus($id){
        $roomModel  =   new HotelRoom();
        $searchModel = new HotelRoomSearch();
        $roomModel  = $this->findRoomModel($id);
        $hotel_id             =   $roomModel->hotel_id;
        if($roomModel->status == $roomModel::STATUS_ACTIVE){
            $roomModel->status = $roomModel::STATUS_INACTIVE;
            Yii::$app->session->setFlash("success", "Succesfully inactive.");
        }else {
            $roomModel->status = $roomModel::STATUS_ACTIVE;
            Yii::$app->session->setFlash("success", "Succesfully active.");
        }
        $roomModel->save();
        $searchModel->hotel_id = $hotel_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('room-list',[
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
            'id'            =>  $hotel_id,
        ]);
    }
    
    /**
     * Displays a single Hotel model.
     * @param integer $id
     * @return mixed
     */
    public function actionRoomView($id)
    {
        $roomModel = $this->findRoomModel($id);
        $hotel_id   =   $roomModel->hotel_id;
        //\yii\helpers\VarDumper::dump($hotel_id); exit;
        return $this->render('room-view', [
            'roomModel' =>  $roomModel,
            'hotel_id'  =>  $hotel_id,
            'id'        =>  $id,
        ]);
    }
    
    public function actionRoomUpdate($id)
    {
        $roomModel = $this->findRoomModel($id);
        $hotel_id   =   $roomModel->hotel_id;
        if ($roomModel->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if($roomModel->save()){
                    $transaction->commit();
                    return $this->redirect(['room-view', 'id' => $roomModel->id]);
                }
            } catch (Exception $ex) {
                $transaction->rollBack();
            }
        } 
        return $this->render('room-update', [
            'roomModel'             => $roomModel,
            'hotel_id'              => $hotel_id,
        ]);
    }
    
    /**
     * Deletes an existing Hotel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionRoomDelete($id)
    {
        $roomModel      =   $this->findRoomModel($id);
        $searchModel    =   new HotelRoomSearch();
        $hotel_id             =   $roomModel->hotel_id;
        $roomModel->delete();
        $searchModel->hotel_id = $hotel_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        Yii::$app->session->setFlash('success', 'Successfully deleted');
        return $this->render('room-list', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
            'id'            =>  $hotel_id,
        ]);
        
    }

    /**
     * Finds the Hotel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Hotel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Hotel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findRoomModel($id)
    {
        if (($roomModel = HotelRoom::findOne($id)) !== null) {
            return $roomModel;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
