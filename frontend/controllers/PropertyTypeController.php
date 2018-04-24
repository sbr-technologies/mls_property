<?php

namespace frontend\controllers;

use Yii;
use common\models\PropertyType;
use common\models\PropertyTypeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * PropertyTypeController implements the CRUD actions for PropertyType model.
 */
class PropertyTypeController extends Controller
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
        ];
    }

    /**
     * Lists all PropertyType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PropertyTypeSearch();
        
        if(Yii::$app->request->isAjax){
            $finalArray = array();
            if(Yii::$app->request->isPost){
                $params = Yii::$app->request->post('depdrop_all_params');
                if(isset($params['property_category_id']) && $params['property_category_id']){
                    $searchModel->property_category_id = $params['property_category_id'];
                }
            }
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            foreach ($dataProvider->models as $model) {
                array_push($finalArray, ['id' => $model->id, 'name' => $model->title]);
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['output' => $finalArray, 'selected'=>''];
        }else{
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    
    public function actionMultiSelect(){
        if (Yii::$app->request->isAjax) {
            $categoryId = Yii::$app->request->get('selected_id');
            return $this->renderAjax('multi-select', [
                        'categoryId' => $categoryId,
            ]);
        }
    }

    /**
     * Displays a single PropertyType model.
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
     * Creates a new PropertyType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PropertyType();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PropertyType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
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
     * Deletes an existing PropertyType model.
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
     * Finds the PropertyType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PropertyType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PropertyType::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
