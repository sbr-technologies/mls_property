<?php

namespace frontend\controllers;

use Yii;
use common\models\Contact;
use common\models\ContactSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\helpers\AuthHelper;
use yii\helpers\ArrayHelper;
use common\models\Agent;
/**
 * ContactsController implements the CRUD actions for Contact model.
 */
class ContactsController extends Controller
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
                'only' => ['create', 'index', 'update', 'view', 'delete'],
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
     * Lists all Contact models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ContactSearch();
        $user = Yii::$app->user->identity;
        $agency = [];
        if(AuthHelper::is('agency')){
            $agency = $user->agency;
            $agents = ArrayHelper::getColumn(Agent::find()->where(['agency_id' => $agency->id])->active()->all(), 'id');
//            print_r($agents);die();
            if(!empty($agents)){
                $searchModel->userIdIn = $agents;
            }else{
                $searchModel->userIdIn = [0];
            }
        }else{
            $searchModel->userIdIn = $user->id;
        }
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'agency' => $agency
        ]);
    }

    /**
     * Displays a single Contact model.
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
     * Creates a new Contact model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Contact();

        if ($model->load(Yii::$app->request->post())) {
            if(!$model->user_id){
                $model->user_id = Yii::$app->user->identity->id;
            }
            
            if($model->save()){
            return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Contact model.
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
    
    public function actionSearchMyContacts(){
        $q = Yii::$app->request->get('q');
        $searchModel = new ContactSearch();
        $user = Yii::$app->user->identity;
        $agency = [];
        $searchModel->keyword = $q;
        if(AuthHelper::is('agency')){
            $agency = $user->agency;
            $agents = ArrayHelper::getColumn(Agent::find()->where(['agency_id' => $agency->id])->active()->all(), 'id');
//            print_r($agents);die();
            if(!empty($agents)){
                $searchModel->userIdIn = $agents;
            }else{
                $searchModel->userIdIn = [0];
            }
        }else{
            $searchModel->userIdIn = $user->id;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $rs = [];
        foreach ($dataProvider->getModels() as $model){
            array_push($rs, ['id' => $model->id, 'name' => $model->fullName.' ('. $model->email. ')']); 
        }
        return $rs;
    }

    /**
     * Deletes an existing Contact model.
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
     * Finds the Contact model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Contact the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Contact::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
