<?php

namespace backend\controllers;

use Yii;
use yii\web\Response;
use common\models\LocationSuggestion;
use common\models\LocationSuggestionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * LocationSuggestionController implements the CRUD actions for LocationSuggestion model.
 */
class LocationSuggestionController extends Controller
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
     * Lists all LocationSuggestion models.
     * @return mixed
     */
//    public function actionIndex()
//    {
//        $searchModel = new LocationSuggestionSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
//    }

    /**
     * Displays a single LocationSuggestion model.
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
     * Creates a new LocationSuggestion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LocationSuggestion();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing LocationSuggestion model.
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
     * Deletes an existing LocationSuggestion model.
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
     * Finds the LocationSuggestion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LocationSuggestion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LocationSuggestion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionIndex(){
        $searchModel = new LocationSuggestionSearch();
        $searchType = 'city';
        $keyword = Yii::$app->request->get('q');
        $searchModel->keyword = $keyword;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        if(is_numeric($keyword) || is_numeric(substr($keyword, 0, 4))){
            $searchType = 'zip';
        }
        if(strpos(trim($keyword), ' ') !== false){
            $searchType = 'area';
        }
        
        $result = [];
        foreach ($dataProvider->getModels() as $location){
            $location->searchType = $searchType;
            $result[] = ['id' => $location->locationId, 'value' => $location->formattedLocation];
        }
        $result = array_map('unserialize', array_unique(array_map('serialize', $result)));
        return $result;
    }
    
    
    public function actionComplete(){
        $searchModel = new LocationSuggestionSearch();
        $keyword = Yii::$app->request->get('q');
        $searchModel->keyword = $keyword;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        Yii::$app->response->format = Response::FORMAT_JSON;
        $result = [];
        foreach ($dataProvider->getModels() as $location){
            $result[] = ['id' => $location->completeLocationId, 'value' => $location->CompleteAddress];
        }
        $result = array_map('unserialize', array_unique(array_map('serialize', $result)));
        return $result;
    }
    
    public function actionGetStates(){
        $keyword = Yii::$app->request->get('q');
        $records = LocationSuggestion::find()->where(['LIKE', 'state', $keyword])->select('state')->distinct()->orderBy(['state' => SORT_ASC])->all();
        Yii::$app->response->format = Response::FORMAT_JSON;
        $result = [];
        foreach ($records as $rec){
            $result[] = ['value' => $rec->state];
        }
        return $result;
    }
    
    public function actionGetTowns(){
        $params = Yii::$app->request->post('depdrop_parents');
        $state = $params[0];
//        $records = LocationSuggestion::find()->where(['state' => $state])->andWhere(['LIKE', 'city', $keyword])->select('city')->distinct()->all();
        Yii::$app->response->format = Response::FORMAT_JSON;
        $result = [];
        if($state){
            $records = LocationSuggestion::find()->where(['state' => $state])->select('city')->distinct()->orderBy(['city' => SORT_ASC])->all();
            foreach ($records as $rec){
                if(trim($rec->city)){
                    $result[] = ['id' => $rec->city, 'name' => $rec->city];
                }
            }
        }
        return ['output'=>$result, 'selected'=>''];
    }
    
    public function actionGetAreas(){
//        $keyword = Yii::$app->request->get('q');
//        $city = Yii::$app->request->get('town');
        $params = Yii::$app->request->post('depdrop_parents');
        $city = $params[0];
        Yii::$app->response->format = Response::FORMAT_JSON;
        $result = [];
        if($city){
            $records = LocationSuggestion::find()->where(['city' => $city])->select('area')->distinct()->orderBy(['area' => SORT_ASC])->all();
            foreach ($records as $rec){
                if(trim($rec->area)){
                    $result[] = ['id' => $rec->area, 'name' => $rec->area];
                }
            }
        }
        return ['output'=>$result, 'selected'=>''];
    }
    
    public function actionGetZipCodes(){
        $params = Yii::$app->request->post('depdrop_parents');
        $city = $params[0];
        Yii::$app->response->format = Response::FORMAT_JSON;
        $result = [];
        if($city){
            $records = LocationSuggestion::find()->where(['city' => $city])->select('zip_code')->distinct()->orderBy(['zip_code' => SORT_ASC])->all();
            foreach ($records as $rec){
                if(trim($rec->zip_code)) {
                    $result[] = ['id' => $rec->zip_code, 'name' => $rec->zip_code];
                }
            }
        }
        return ['output'=>$result, 'selected'=>''];
    }
    
    public function actionGetLocalGovtArea(){
        $params = Yii::$app->request->post('depdrop_parents');
        $state = $params[0];
        Yii::$app->response->format = Response::FORMAT_JSON;
        $result = [];
        if($state){
            $records = LocationSuggestion::find()->where(['state' => $state])->select('local_government_area')->distinct()->all();
            foreach ($records as $rec){
                if(trim($rec->local_government_area)){
                    $result[] = ['id' => $rec->local_government_area, 'name' => $rec->local_government_area];
                }
            }
        }
        return ['output'=>$result, 'selected'=>''];
    }
    
    public function actionGetDistricts(){
        $params = Yii::$app->request->post('depdrop_parents');
        $local_govt_area = $params[0];
        Yii::$app->response->format = Response::FORMAT_JSON;
        $result = [];
        if($local_govt_area){
            $records = LocationSuggestion::find()->where(['local_government_area' => $local_govt_area])->select('district')->distinct()->all();
            foreach ($records as $rec){
                if(trim($rec->district)){
                    $result[] = ['id' => $rec->district, 'name' => $rec->district];
                }
            }
        }
        return ['output'=>$result, 'selected'=>''];
    }
}
