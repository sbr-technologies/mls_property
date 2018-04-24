<?php

namespace backend\controllers;

use Yii;
use common\models\News;
use common\models\NewsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use common\models\PhotoGallery;
use yii\web\UploadedFile;
use yii\helpers\StringHelper;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends Controller
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
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single News model.
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
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new News();
        if ($model->load(Yii::$app->request->post()) ) {
            $transaction = Yii::$app->db->beginTransaction();
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            try {
                if($model->save()){
                    if(!empty($model->imageFiles)){
                        $model->upload();
                    }
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (Exception $ex) {
                $transaction->rollBack();
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                
            ]);
        }
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            $photo = PhotoGallery::find()->where(['model' => 'News', 'model_id' => $id])->one();
            try {
                if($model->save()){
                    if(isset($photo)){
                        $photo->delete();
                    } 
                    if(!empty($model->imageFiles)){
                        $model->upload();
                    }
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }else{
                    \yii\helpers\VarDumper::dump($model->errors); exit;
                }
            } catch (Exception $ex) {
                $transaction->rollBack();
            }
            
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

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
     * Deletes an existing News model.
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
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
