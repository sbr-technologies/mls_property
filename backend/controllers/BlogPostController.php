<?php

namespace backend\controllers;

use Yii;
use common\models\BlogPost;
use common\models\BlogPostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


use common\models\PhotoGallery;

use yii\web\UploadedFile;
/**
 * BlogPostController implements the CRUD actions for BlogPost model.
 */
class BlogPostController extends Controller
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
     * Lists all BlogPost models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BlogPostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BlogPost model.
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
     * Creates a new BlogPost model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BlogPost();

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->user_id = Yii::$app->user->id;
                $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
                
                if($model->save()){
                    if(!empty($model->imageFiles)){
                        $model->upload();
                    }
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (Exception $ex) {
                $transaction->rollBack();
                $model->errors;
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing BlogPost model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->user_id = Yii::$app->user->id;
                $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
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
        } 
        return $this->render('update', [
            'model' => $model,
        ]);
    }
    
    
    /**
     * Deletes an existing BlogPost model.
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
        if($model->status == $model::STATUS_PUBLISHED){
            $model->status = $model::STATUS_PENDING;
            Yii::$app->session->setFlash("success", "Succesfully Pending.");
        }else {
            $model->status = $model::STATUS_PUBLISHED;
            Yii::$app->session->setFlash("success", "Succesfully Published.");
        }
        $model->save();
        return $this->redirect(['index']);
    }
    
    /**
     * Finds the BlogPost model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BlogPost the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BlogPost::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
