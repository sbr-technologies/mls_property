<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use common\models\Team;
use common\models\TeamSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\AgencySearch;
use yii\web\Response;
use common\models\User;
use common\models\UserSearch;
/**
 * TeamController implements the CRUD actions for Team model.
 */
class TeamController extends Controller
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
     * Lists all Team models.
     * @return mixed
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        $agency = $user->agency;
        if(empty($agency)){
            Yii::$app->session->setFlash('error', 'Please complete your agency profile setup');
            return $this->redirect(['agency/profile']);
        }

        $searchModel = new TeamSearch();
        $searchModel->agency_id = $agency->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Team model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $user = Yii::$app->user->identity;
        $agency = $user->agency;
        $model = $this->findModel($id);
        $teamMemberSearchModel = new UserSearch();
        $teamMemberSearchModel->team_id = $id;
        $teamMemberSearchModel->profile_id = User::PROFILE_AGENT;
        $teamMemberDataProvider = $teamMemberSearchModel->search(Yii::$app->request->queryParams);
        
        $ourAgentsSearchModel = new UserSearch();
        $ourAgentsSearchModel->profile_id = User::PROFILE_AGENT;
        $ourAgentsSearchModel->agency_id = $agency->id;
        $ourAgentsSearchModel->team_id = null;
        $ourAgentsDataProvider = $ourAgentsSearchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('view', [
            'model'                 => $model,
            'teamMemberDataProvider'    => $teamMemberDataProvider,
            'ourAgentsDataProvider' => $ourAgentsDataProvider,
            'ourAgentsSearchModel' => $ourAgentsSearchModel
        ]);
    }

    /**
     * Creates a new Team model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $user = Yii::$app->user->identity;
        $agency = $user->agency;
        if(empty($agency)){
            Yii::$app->session->setFlash('error', 'Please complete your agency profile setup');
            return $this->redirect(['agency/profile']);
        }
        $model = new Team();
        if ($model->load(Yii::$app->request->post())) {
			$model->agency_id = $agency->id;
			if($model->save()){
				return $this->redirect(['view', 'id' => $model->id]);
			}
        }
        return $this->render('create', [
            'model' => $model,

        ]);
    }

    /**
     * Updates an existing Team model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $user = Yii::$app->user->identity;
        $agency = $user->agency;
        if(empty($agency)){
            Yii::$app->session->setFlash('error', 'Please complete your agency profile setup');
            return $this->redirect(['agency/profile']);
        }
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
     * Deletes an existing Team model.
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
     * Deletes an existing Team model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionAddMember($id)
    {
        $user = Yii::$app->user->identity;
        $agency = $user->agency;
        $teamId = Yii::$app->request->post('team_id');
        $member = User::find()->where(['id' => $id, 'agency_id' => $agency->id, 'profile_id' => User::PROFILE_AGENT])->one();
        if(!empty($member)){
            $member->team_id = $teamId;
            $member->save();
        }
        echo 'done';
    }
    /**
     * Deletes an existing Team model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeleteMember($id)
    {
        $user = Yii::$app->user->identity;
//        $agency = $user->agency;
        $member = User::findOne($id);
        if(!empty($member)){
            $member->team_id = null;
            $member->save();
        }
        echo 'done';
    }
    
    
    public function actionSearchByNameJson(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $search = Yii::$app->request->get('search');
        $term = $search['term'];
        if($term){
            $teams = Team::find()->select(['name', 'teamID'])->where(['LIKE', 'name', '%'. $term. '%', false])->active()->all();
            if(!empty($teams)){
                $rs = [];
                foreach ($teams as $team){
                    $rs[] = ['id' => $team->name, 'text' => $team->name. ' ('. $team->teamID. ')'];
                }
                return ['results' => $rs];
            }
        }
        return ['results' => []];
    }
    
    public function actionSearchByNameIdJson(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $search = Yii::$app->request->get('search');
        $parent = Yii::$app->request->get('parent');
        $term = $search['term'];
        $parentWhere = [];
        if($term){
            if($parent){
                $parentWhere = ['LIKE', 'name', '%'. $parent. '%', false];
            }
            $teams = Team::find()->select(['name', 'teamID'])->where(['LIKE', 'teamID', '%'. $term. '%', false])->andWhere($parentWhere)->active()->all();
            if(!empty($teams)){
                $rs = [];
                foreach ($teams as $team){
                    $rs[] = ['id' => $team->teamID, 'text' => $team->teamID. ' ('. $team->name. ')'];
                }
                return ['results' => $rs];
            }
        }
        return ['results' => []];
    }
    
    public function actionPopulateChildrenByNameJson(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $nameStr = Yii::$app->request->post('name');
        $id = substr($nameStr, -9, 8);
        if($id){
            $team = Team::find()->with('agency')->where(['teamID' => $id])->active()->one();
            if(!empty($team)){
                $office = $team->agency;
                return ['result' => ['id' => $team->teamID, 'name' => $team->name, 'text' => $team->teamID. ' ('. $team->name. ')', 'office' => ['name' => $office->name, 'id' => $office->agencyID, 'address' => ['state' => $office->state, 'town' => $office->town, 'area' => $office->area, 'zip_code' => $office->zip_code]]]];
            }
        }
        return ['result' => []];
    }
    
    public function actionPopulateChildrenByIdJson(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        if($id){
            $team = Team::find()->with('agency')->where(['teamID' => $id])->active()->one();
            if(!empty($team)){
                $office = $team->agency;
                return ['result' => ['id' => $team->teamID, 'name' => $team->name, 'text' => $team->name. ' ('. $team->teamID. ')', 'office' => ['name' => $office->name, 'id' => $office->agencyID, 'address' => ['state' => $office->state, 'town' => $office->town, 'area' => $office->area, 'zip_code' => $office->zip_code]]]];
            }
        }
        return ['result' => []];
    }
    
    
    
    /**
     * Finds the Team model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Team the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Team::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
