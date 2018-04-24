<?php

namespace backend\controllers;

use Yii;
use common\models\AgentSellerMapping;
use common\models\AgentSellerMappingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * AgentSellerMappingController implements the CRUD actions for AgentSellerMapping model.
 */
class AgentSellerMappingController extends Controller
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
     * Lists all AgentSellerMapping models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AgentSellerMappingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AgentSellerMapping model.
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
     * Creates a new AgentSellerMapping model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AgentSellerMapping();
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $agentId = Yii::$app->request->post('agent_id');
            $sellerId = Yii::$app->request->post('seller_id');
            $model->agent_id = $agentId;
            $model->seller_id = $sellerId;
            if($model->save()){
                $model->sendAssignSellerMail();
                return ['status' => 'success'];
//                return $this->renderAjax('create', [
//                    'model' => $model,
//                ]);
            }else{
                return ['status' => 'failed','errors' => $model->errors];
                //echo json_encode($model->errors);
            }
        }
    }

    /**
     * Updates an existing AgentSellerMapping model.
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
     * Deletes an existing AgentSellerMapping model.
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
     * Finds the AgentSellerMapping model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AgentSellerMapping the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AgentSellerMapping::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
