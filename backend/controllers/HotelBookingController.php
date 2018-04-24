<?php

namespace backend\controllers;

use Yii;
use common\models\HotelBooking;
use common\models\HotelBookingSearch;
use common\models\HotelBookingGuest;
use common\models\HotelBookingGuestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * HotelBookingController implements the CRUD actions for HotelBooking model.
 */
class HotelBookingController extends Controller
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
     * Lists all HotelBooking models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HotelBookingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HotelBooking model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $guestSearchModel = new HotelBookingGuestSearch();
        $guestSearchModel->booking_id = $id;
        $guestDataProvider = $guestSearchModel->search(Yii::$app->request->queryParams);
        return $this->render('view', [
            'model' => $this->findModel($id), 'guestDataProvider' => $guestDataProvider
        ]);
    }

    /**
     * Creates a new HotelBooking model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new HotelBooking();
        $guestModels = [new HotelBookingGuest()];
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
           //\yii\helpers\VarDumper::dump($_POST['HotelBookingGuest'],12,1); //exit;
            try {
                if($model->save()){
                    if(isset($_POST['HotelBookingGuest']) && is_array($_POST['HotelBookingGuest']) && count($_POST['HotelBookingGuest']) > 0){
                        foreach($_POST['HotelBookingGuest'] as $bookingGuest){
                            $guestModels                    = new HotelBookingGuest();
                            $guestModels->booking_id        = $model->id;
                            $guestModels->first_name        = $bookingGuest['first_name'];
                            $guestModels->last_name         = $bookingGuest['last_name'];
                            $guestModels->middle_name       = $bookingGuest['middle_name'];
                            $guestModels->gender            = $bookingGuest['gender'];
                            $guestModels->age               = $bookingGuest['age'];
                            if(!$guestModels->save()){
                            \yii\helpers\VarDumper::dump($guestModels->errors);exit;
                            }else{
                               $guestModels->save(); 
                            }
                        }
                    }
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }else{
                    \yii\helpers\VarDumper::dump($model->errors);
                }
            }catch (Exception $ex) {
                $transaction->rollBack();
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'guestModels' => $guestModels
            ]);
        }
    }

    /**
     * Updates an existing HotelBooking model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $guestModels = HotelBookingGuest::findAll(['booking_id' => $model->id]);
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
           //\yii\helpers\VarDumper::dump($_POST['HotelBookingGuest'],12,1); //exit;
            try {
                if($model->save()){
                    $guestModels = Yii::$app->request->post('HotelBookingGuest');
                    if(empty($guestModels)){
                        throw new NotFoundHttpException(Yii::t('app', 'Invalid data'));
                    }
                    foreach ($guestModels as $child) {
                        if (!empty($child['id']) && $child['_destroy'] == 1) {
                            HotelBookingGuest::findOne($child['id'])->delete();
                            continue;
                        }
                        if (!empty($child['id']) && !$child['_destroy']) {
                            $childModel = HotelBookingGuest::findOne($child['id']);
                        } elseif (empty($child['id']) && !$child['_destroy']) {
                            $childModel = new HotelBookingGuest();
                            $childModel->booking_id = $model->id;
                        } elseif (empty($child['id']) && $child['_destroy'] == 1) {
                            continue;
                        }
                        $childModel->first_name        = $child['first_name'];
                        $childModel->last_name         = $child['last_name'];
                        $childModel->middle_name       = $child['middle_name'];
                        $childModel->gender            = $child['gender'];
                        $childModel->age               = $child['age'];
                        
                        if(!$childModel->save()){
//                            print_r($childModel->errors);die();
                        }
                    }
                    
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }else{
                    \yii\helpers\VarDumper::dump($model->errors);
                }
            }catch (Exception $ex) {
                $transaction->rollBack();
            }
        } 
        return $this->render('update', [
            'model' => $model,
            'guestModels' => $guestModels
        ]);
    }

    /**
     * Deletes an existing HotelBooking model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the HotelBooking model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HotelBooking the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HotelBooking::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
