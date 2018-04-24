<?php

namespace backend\controllers;

use Yii;
use common\models\HolidayBookingGuest;
use common\models\HolidayBookingGuestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * HolidayBookingGuestController implements the CRUD actions for HolidayBookingGuest model.
 */
class HolidayBookingGuestController extends Controller
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
     * Lists all HolidayBookingGuest models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HolidayBookingGuestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HolidayBookingGuest model.
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
     * Creates a new HolidayBookingGuest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new HolidayBookingGuest();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing HolidayBookingGuest model.
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
     * Deletes an existing HolidayBookingGuest model.
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
     * Finds the HolidayBookingGuest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HolidayBookingGuest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HolidayBookingGuest::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
