<?php

namespace backend\controllers;

use Yii;
use common\models\PropertyCategory;
use common\models\PropertyCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PropertyCategoryController implements the CRUD actions for PropertyCategory model.
 */
class PropertyCategoryController extends Controller
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
     * Lists all PropertyCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PropertyCategorySearch();
        $dataProvider = $searchModel->search([
                Yii::$app->request->queryParams,
                'sort' => [
                    'defaultOrder' => [
                        'sort_order' => SORT_ASC
                    ]
                ],
            ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PropertyCategory model.
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
     * Creates a new PropertyCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PropertyCategory();

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                \yii\helpers\VarDumper::dump($model->errors); exit;
            }
            
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PropertyCategory model.
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

    /**
     * Deletes an existing PropertyCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
     * Finds the PropertyCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PropertyCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PropertyCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
