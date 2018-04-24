<?php

namespace frontend\controllers;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\Hotel;
use frontend\models\HotelSearch;
use yii\helpers\Url;
use common\models\PhotoGallery;
use yii\web\UploadedFile;
use common\models\MetaTag;
use common\models\HotelFacility;
use common\models\RoomFacility;
use yii\helpers\StringHelper;
use yii\data\Pagination;
use common\models\HotelRoomSearch;
use common\models\HotelRoom;
use common\models\LocationSuggestion;
use frontend\helpers\AuthHelper;



class HotelController extends Controller
{
    public $context;
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['profile', 'index'],
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
        $this->layout   =   'public_main';
        $this->context = ['service_id' => 2];
    }
    
    public function actionProfile() { //echo 33;
        $userId         = Yii::$app->user->id;
        $model          = Hotel::findOne($userId);
        $buyerSocialMediaModel = array(); 
        if(empty($model)){
            return false;
        }
        $buyerSocialModel    = $model->buyerSocialMedias;
        if(is_array($buyerSocialModel) && count($buyerSocialModel) > 0){
            foreach($buyerSocialModel as $socialKey => $socialVal){
                $buyerSocialMediaModel[$socialVal->name]['url'] = $socialVal->url;
            }
        }
        return $this->render('profile', [
            'model'                     => $model,
            'buyerSocialMediaModel'     => $buyerSocialMediaModel
            ]
        );
    }
    public function actionIndex() {
        return $this->render('index');
        
    }
    
    public function actionView($slug) {
        $model          = Hotel::findOne(['slug' => $slug]);
        return $this->render('view', [
            'model' => $model,
        ]);
        
    }
    
    public function actionList(){
        $this->layout   =   'main';
        $searchModel = new HotelSearch();
        $searchModel->user_id = Yii::$app->user->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('list', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
        
    }
    
    public function actionCreate(){
//        if(!AuthHelper::Can($this->context)){
//            throw new \yii\web\UnauthorizedHttpException('You are not subscribed for this');
//        }
        $this->layout       =   'main';
        $model              = new Hotel(['scenario' =>'create']);
        $metaTagModel       = new MetaTag();
        $facilityModel      = [new HotelFacility()];
        $facilityRoomModel      = [new RoomFacility()];
        if ($model->load(Yii::$app->request->post())) {
//            \yii\helpers\VarDumper::dump($model,4,12); exit;
            Yii::$app->response->format     = Response::FORMAT_JSON;
            $model->user_id = Yii::$app->user->id;
            $model->status = 'active';
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
                if($model->save()){
                    if(!empty($model->imageFiles)){
                        $model->upload();
                    }
                    //\yii\helpers\VarDumper::dump($_POST['MetaTag'],4,12); exit;
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
                    return ['success' => true,'message' => 'Your Hotel has been Added successfully','redirectUrl' => Url::to(['hotel/list'])];
                }else{
                    return ['success' => false,'errors' => $model->errors];
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
    
    public function actionDetails($id){
        $this->layout           =   'main';
        $agentSocialMediaArr    =   [];
        $model = $this->findModel($id);
        $metaTagModel  = MetaTag::find()->where(['model_id' => $model->id, 'model' => StringHelper::basename($model->className())])->one();
        $facilityModel = HotelFacility::findAll(['hotel_id' =>  $model->id]);
        $facilityRoomModel = RoomFacility::findAll(['hotel_id' =>  $model->id]);
        
        return $this->render('details', [
            'model'             => $model,
            'metaTagModel'      =>  $metaTagModel,
            'facilityModel'     =>  $facilityModel,
            'facilityRoomModel' =>  $facilityRoomModel,
        ]);
    }
    
    /**
     * Updates an existing Hotel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id){
        $this->layout           =   'main';
        $model = $this->findModel($id);
        $metaTagModel  = MetaTag::find()->where(['model_id' => $model->id, 'model' => StringHelper::basename($model->className())])->one();
        $facilityModel = HotelFacility::findAll(['hotel_id' =>  $model->id]);
        $facilityRoomModel = RoomFacility::findAll(['hotel_id' =>  $model->id]);
        if ($model->load(Yii::$app->request->post())) {
//echo "<pre>"; print_r($model); echo "<pre>"; exit;
            Yii::$app->response->format     = Response::FORMAT_JSON;
            $model->user_id = Yii::$app->user->id;
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
                    if(!empty($facilityModel)){
                        //throw new NotFoundHttpException(Yii::t('app', 'Invalid data'));
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
                    }
                    
                    $roomFacilityModel = Yii::$app->request->post('RoomFacility');
                    if(!empty($roomFacilityModel)){
                        //throw new NotFoundHttpException(Yii::t('app', 'Invalid data'));
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
                    }
                $transaction->commit();
                return ['success' => true,'message' => 'Your Hotel has been Updated successfully','redirectUrl' => Url::to(['hotel/list'])];
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
    
    
    public function actionDelete($id){
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
        return $this->redirect(['hotel/list']);
    }
    
    
    public function actionRoomList($id){
        $this->layout   =   'main';
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
    
    public function actionCreateRoom($hotel_id){
        $this->layout   =   'main';
        $roomModel  =   new HotelRoom();
        if ($roomModel->load(Yii::$app->request->post())) {
            Yii::$app->response->format     = Response::FORMAT_JSON;
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if($roomModel->save()){ //echo 11; exit;
                    $transaction->commit();
                    return ['success' => true,'message' => 'Room has been Added successfully','redirectUrl' => Url::to(['hotel/room-list','id' => $hotel_id])];
                }else{
                    \yii\helpers\VarDumper::dump($roomModel->errors); exit;
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
    
    /**
     * Displays a single Hotel model.
     * @param integer $id
     * @return mixed
     */
    public function actionRoomView($id){
        $this->layout   =   'main';
        $roomModel = $this->findRoomModel($id);
        $hotel_id   =   $roomModel->hotel_id;
        //\yii\helpers\VarDumper::dump($hotel_id); exit;
        return $this->render('room-view', [
            'roomModel' =>  $roomModel,
            'hotel_id'  =>  $hotel_id,
            'id'        =>  $id,
        ]);
    }
    
    public function actionRoomUpdate($id){
        $this->layout   =   'main';
        $roomModel = $this->findRoomModel($id);
        $hotel_id   =   $roomModel->hotel_id;
        if ($roomModel->load(Yii::$app->request->post())) {
            Yii::$app->response->format     = Response::FORMAT_JSON;
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if($roomModel->save()){
                    $transaction->commit();
                    return ['success' => true,'message' => 'Room has been Updated successfully','redirectUrl' => Url::to(['hotel/room-list','id' => $hotel_id])];
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
    public function actionRoomDelete($id){
        $this->layout   =   'main';
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
    
    public function actionRoomStatus($id){
        $this->layout   =   'main';
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
     * Finds the Hotel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Hotel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    
    public function actionSearch(){
        $locationId             = Yii::$app->request->get('location');
        $rating                 = Yii::$app->request->get('rating');
        $facilities             = Yii::$app->request->get('facilities');
        $facilitiesArr             = explode('-', $facilities);
        $zipSearch              = false;
        $searchModel            = new HotelSearch();
        $searchModel->status    = Hotel::STATUS_ACTIVE;
        $locationIdArr          = explode('_', $locationId);
//        \yii\helpers\VarDumper::dump($facilities); exit;
        $searchModel->ratingPlus = $rating;
        $searchModel->facilitiesIn = $facilities?$facilitiesArr:[];
        $hotelName = '';
        if(count($locationIdArr) == 2){
            $searchModel->town  = $locationIdArr[0];
            $searchModel->state = $locationIdArr[1];
            $condition = ['city' => $locationIdArr[0], 'state' => $locationIdArr[1]];
        }elseif(is_numeric($locationId)){
            $searchModel->zip_code  = $locationId;
            $condition = ['zip_code' => $locationId];
            $zipSearch = true;
        }
//        $searchModel->property_category_id = 2;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $locationObj = LocationSuggestion::find()->where($condition)->one();
        $locationObj->searchType = ($zipSearch? 'zip':'city');
        $location = $locationObj->formattedLocation;
        return $this->render('search', ['hotelName' => $hotelName, 'locationId' => $locationId, 'city' => $locationObj->city, 'state' => $locationObj->state, 'location' => $location, 
            'rating' => $rating, 'facilities' => $facilitiesArr,
            'sortBy' => 'relevant', 'dataProvider' => $dataProvider]);
    }
    public function actionDeletePhoto($id,$property_id){
        $photo = PhotoGallery::findOne($id);
        if($photo->delete()){
            Yii::$app->session->setFlash("success", "One image delete successfully");
            return $this->redirect(['update', 'id' => $property_id]);
        }else{
            Yii::$app->session->setFlash("failed", "Sorry, We are unable to process your data");
            return $this->redirect(['update', 'id' => $property_id]);
        }
    }
    
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
