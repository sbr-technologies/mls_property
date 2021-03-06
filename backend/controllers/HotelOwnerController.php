<?php

namespace backend\controllers;

use Yii;
use common\models\HotelOwner;
use common\models\HotelOwnerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use yii\helpers\StringHelper;
use common\helpers\SendMail;
use common\models\HotelOwnerServiceCategoryMapping;
use common\models\HotelOwnerServiceCategoryMappingSearch;
/**
 * UserController implements the CRUD actions for User model.
 */
class HotelOwnerController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HotelOwnerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $serviceCategorySearchModel = new HotelOwnerServiceCategoryMappingSearch();
        $serviceCategorySearchModel->hotel_owner_id = $id;
        $serviceCategoryDataProvider = $serviceCategorySearchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('view', [
            'model' => $model,
             'serviceCategoryDataProvider' => $serviceCategoryDataProvider,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new HotelOwner();

        if ($model->load(Yii::$app->request->post())) {
            $profileImage = $model->uploadImage();
            if($model->save()){
                $model->services = $_POST['HotelOwner']['services'];
                if ($profileImage !== false) {
                    $path = $model->getImageFile();
                    $profileImage->saveAs($path);
                    $model->resizeImage();
                }
                $model->sendRegistrationMail();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $oldFileName = $model->profile_image_file_name;
        $oldFileExt = $model->profile_image_extension;
        
        
        if ($model->load(Yii::$app->request->post())) {
            $profileImage = $model->uploadImage();
            
            if($model->save()){
                if ($profileImage !== false) { // delete old and overwrite
                    if($oldFileName && $oldFileExt){
                        $model::unlinkFiles($oldFileName, $oldFileExt);
                    }
                    $path = $model->getImageFile();
                    $profileImage->saveAs($path);
                    $model->resizeImage();
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if($id == 1){
            Yii::$app->session->setFlash('error', 'Default user can\'t be deleted');
            return $this->redirect(['index']);
        }
        $model = $this->findModel($id);
        if($model->delete()){
            $model->deleteImage();
            Yii::$app->session->setFlash('success', 'Successfully deleted');
        }
        return $this->redirect(['index']);
    }
    
    
    public function actionStatus($id){
        $model = $this->findModel($id);
        //\yii\helpers\VarDumper::dump($model,12,1);
        if($model->status == $model::STATUS_ACTIVE){
            $model->status = $model::STATUS_INACTIVE;
            Yii::$app->session->setFlash("success", "Succesfully Inactive.");
        }else {
            $model->status = $model::STATUS_ACTIVE;
            Yii::$app->session->setFlash("success", "Succesfully Active.");
        }
        $model->save();
        return $this->redirect(['index']);
    }
    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HotelOwner::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
