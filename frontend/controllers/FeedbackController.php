<?php
namespace frontend\controllers;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\helpers\StringHelper;
use common\models\Testimonial;
use common\models\TestimonialSearch;


class FeedbackController extends \yii\web\Controller
{ 
    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'property', 'details', 'hotel', 'holiday', 'update', 'delete'],
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
    }
    
    public function actionIndex() {
        
        return $this->render('index', [
           // 'model' => $model,
        ]);
        
    }
    
    public function actionProperty() {
        $this->layout           =   'main';
        $searchModel            = new TestimonialSearch();
        $searchModel->user_id   = Yii::$app->user->id;
        $searchModel->model     = 'Property';
        $dataProvider           = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('property', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
    }
    
    public function actionDetails($id){
        $this->layout           =   'main';
        $model                  = $this->findModel($id);
        
        return $this->render('details', [
            'model'             => $model,
        ]);
    }
    
    public function actionHotel() {
        $this->layout           =   'main';
        $searchModel            = new TestimonialSearch();
        $searchModel->user_id   = Yii::$app->user->id;
        $searchModel->model     = 'Hotel';
        $dataProvider           = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('hotel', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
    }
    public function actionHoliday() {
        $this->layout           =   'main';
        $searchModel            = new TestimonialSearch();
        $searchModel->user_id   = Yii::$app->user->id;
        $searchModel->model     = 'HolidayPackage';
        $dataProvider           = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('holiday', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
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
        
        
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format     = Response::FORMAT_JSON;
            $model->user_id = Yii::$app->user->id;
            $transaction = Yii::$app->db->beginTransaction();
            try {
                //$model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
                if($model->save()){
                    $transaction->commit();
                    if($model->model == 'Property'){
                        $redirectUrl = Url::to(['feedback/property']);
                    }else if($model->model == 'Hotel'){
                        $redirectUrl = Url::to(['feedback/hotel']);
                    }else if($model->model == 'Holiday'){
                        $redirectUrl = Url::to(['feedback/holiday']);
                    }
                    return ['success' => true,'message' => 'Feedback has been Updated successfully','redirectUrl' => $redirectUrl];
                }
            } catch (Exception $ex) {
                $transaction->rollBack();
            }
        } 
        return $this->render('update', [
            'model'             => $model,
        ]);
    }
    
    
    public function actionDelete($id){
        $model = $this->findModel($id);
        $model->delete();
        Yii::$app->session->setFlash('success', 'Successfully deleted');
        return $this->redirect(['hotel/list']);
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
        if (($model = Testimonial::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
