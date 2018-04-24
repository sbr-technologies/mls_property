<?php

namespace backend\controllers;

use Yii;
use common\models\HotelBookingGuest;
use common\models\HotelBookingGuestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
/**
 * HotelBookingGuestController implements the CRUD actions for HotelBookingGuest model.
 */
class HotelBookingGuestController extends Controller
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
     * Lists all HotelBookingGuest models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HotelBookingGuestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HotelBookingGuest model.
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
     * Creates a new HotelBookingGuest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!Yii::$app->request->isAjax){
            $this->goBack();
        }
        $model = new HotelBookingGuest();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing HotelBookingGuest model.
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
     * Deletes an existing HotelBookingGuest model.
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

    /**
     * Finds the HotelBookingGuest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HotelBookingGuest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HotelBookingGuest::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
