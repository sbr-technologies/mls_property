<?php

namespace backend\controllers;

use Yii;
use common\models\PlanMaster;
use common\models\PlanMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * PlanMasterController implements the CRUD actions for PlanMaster model.
 */
class PlanMasterController extends Controller
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
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
     * Lists all PlanMaster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PlanMasterSearch();
        $searchModel->for_agency = 0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Lists all PlanMaster models.
     * @return mixed
     */
    public function actionAgency()
    {
        $searchModel = new PlanMasterSearch();
        $searchModel->for_agency = 1;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('agency', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PlanMaster model.
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
     * Creates a new PlanMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PlanMaster();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        
        return $this->render('create', [
            'model' => $model,
        ]);
    }
    
    /**
     * Creates a new PlanMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAgencyCreate()
    {
        $model = new PlanMaster();
        if ($model->load(Yii::$app->request->post())) {
            $model->for_agency = 1;
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }
        
        return $this->render('agency-create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PlanMaster model.
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
     * Deletes an existing PlanMaster model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $redirect = ['index'];
        $model = $this->findModel($id);
        if($model->for_agency){
            $redirect = ['agency'];
        }
        $model->delete();
        return $this->redirect($redirect);
    }
    
    public function actionPlanOptions(){
        $params = Yii::$app->request->post('depdrop_parents');
        $planId = $params[0];
        $plan = PlanMaster::findOne($planId);
        $rs = [['id' => 1, 'name' => $plan->amount. ' For 1 Month']];
        if($plan->amount_for_6_months){
            $rs[] = ['id' => 6, 'name' => $plan->amount_for_6_months. ' For 6 Months'];
        }
        if($plan->amount_for_12_months){
            $rs[] = ['id' => 12, 'name' => $plan->amount_for_12_months. ' For 12 Months'];
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['output' => $rs, 'selected' => ''];
    }

    /**
     * Finds the PlanMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PlanMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PlanMaster::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
