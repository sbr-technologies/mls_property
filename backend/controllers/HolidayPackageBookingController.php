<?php

namespace backend\controllers;

use Yii;
use common\models\HolidayPackageBooking;
use common\models\HolidayPackageBookingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\HolidayBookingGuest;
use common\models\HolidayBookingGuestSearch;

/**
 * HolidayPackageBookingController implements the CRUD actions for HolidayPackageBooking model.
 */
class HolidayPackageBookingController extends Controller
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
     * Lists all HolidayPackageBooking models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HolidayPackageBookingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HolidayPackageBooking model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $holidayGuestSearchModel = new HolidayBookingGuestSearch();
        $holidayGuestSearchModel->booking_id = $id;
        $holidayGuestDataProvider = $holidayGuestSearchModel->search(Yii::$app->request->queryParams);
        return $this->render('view', [
            'model' => $this->findModel($id),'holidayGuestDataProvider' => $holidayGuestDataProvider
        ]);
    }

    /**
     * Creates a new HolidayPackageBooking model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new HolidayPackageBooking();
        $holidayGuestModels = [new HolidayBookingGuest()];
        if ($model->load(Yii::$app->request->post())) {
           // \yii\helpers\VarDumper::dump($model,12,1); exit;
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if($model->save()){
                    if(isset($_POST['HolidayBookingGuest']) && is_array($_POST['HolidayBookingGuest']) && count($_POST['HolidayBookingGuest']) > 0){
                        foreach($_POST['HolidayBookingGuest'] as $holidayBookGuest){
                            $holidayGuestModels                    = new HolidayBookingGuest();
                            $holidayGuestModels->booking_id        = $model->id;
                            $holidayGuestModels->first_name        = $holidayBookGuest['first_name'];
                            $holidayGuestModels->last_name         = $holidayBookGuest['last_name'];
                            $holidayGuestModels->middle_name       = $holidayBookGuest['middle_name'];
                            $holidayGuestModels->gender            = $holidayBookGuest['gender'];
                            $holidayGuestModels->age               = $holidayBookGuest['age'];
                            if(!$holidayGuestModels->save()){
                                \yii\helpers\VarDumper::dump($holidayGuestModels->errors);exit;
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
                'holidayGuestModels'   => $holidayGuestModels
            ]);
        }
        
    }

    /**
     * Updates an existing HolidayPackageBooking model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $holidayGuestModels = HolidayBookingGuest::findAll(['booking_id' => $model->id]);
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
           //\yii\helpers\VarDumper::dump($_POST['HolidayBookingGuest'],12,1); //exit;
            try {
                if($model->save()){
                    $guestModels = Yii::$app->request->post('HolidayBookingGuest');
                    if(empty($guestModels)){
                        throw new NotFoundHttpException(Yii::t('app', 'Invalid data'));
                    }
                    foreach ($guestModels as $child) {
                        if (!empty($child['id']) && $child['_destroy'] == 1) {
                            HolidayBookingGuest::findOne($child['id'])->delete();
                            continue;
                        }
                        if (!empty($child['id']) && !$child['_destroy']) {
                            $childModel = HolidayBookingGuest::findOne($child['id']);
                        } elseif (empty($child['id']) && !$child['_destroy']) {
                            $childModel = new HolidayBookingGuest();
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
            'holidayGuestModels' => $holidayGuestModels
        ]);
        
    }

    /**
     * Deletes an existing HolidayPackageBooking model.
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
     * Finds the HolidayPackageBooking model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HolidayPackageBooking the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HolidayPackageBooking::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
}
