<?php

  namespace backend\controllers;

  use Yii;
  use common\models\NewsletterTemplate;
  use common\models\NewsletterTemplateSearch;
  use yii\web\Controller;
  use yii\web\NotFoundHttpException;
  use yii\filters\VerbFilter;
use yii\filters\AccessControl;
  

  /**
   * NewsletterTemplateController implements the CRUD actions for NewsletterTemplate model.
   */
  class NewsletterTemplateController extends Controller
  {

      public function behaviors()
      {
          return [
              'verbs' => [
                  'class' => VerbFilter::className(),
                  'actions' => [
                      'delete' => ['post'],
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
       * Lists all NewsletterTemplate models.
       * @return mixed
       */
      public function actionIndex()
      {
          $searchModel = new NewsletterTemplateSearch();
          $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

          return $this->render('index', [
                      'searchModel' => $searchModel,
                      'dataProvider' => $dataProvider,
          ]);
      }

      /**
       * Displays a single NewsletterTemplate model.
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
       * Creates a new NewsletterTemplate model.
       * If creation is successful, the browser will be redirected to the 'view' page.
       * @return mixed
       */
      public function actionCreate()
      {
          $model = new NewsletterTemplate();

          if ($model->load(Yii::$app->request->post()) && $model->save()) {
              return $this->redirect(['view', 'id' => $model->id]);
          }
          else {
              return $this->render('create', [
                          'model' => $model,
              ]);
          }
      }

      /**
       * Updates an existing NewsletterTemplate model.
       * If update is successful, the browser will be redirected to the 'view' page.
       * @param integer $id
       * @return mixed
       */
      public function actionUpdate($id)
      {
          $model = $this->findModel($id);

          if ($model->load(Yii::$app->request->post()) && $model->save()) {
              return $this->redirect(['view', 'id' => $model->id]);
          }
          else {
              return $this->render('update', [
                          'model' => $model,
              ]);
          }
      }

      public function actionStatus($id)
      {
          $model = $this->findModel($id);
          if ($model->status == NewsletterTemplate::STATUS_ACTIVE) {
              $model->status = NewsletterTemplate::STATUS_BLOCKED;
              $msg = 'Successfully unblocked';
          }
          else {
              $model->status = NewsletterTemplate::STATUS_ACTIVE;
              $msg = 'Successfully blocked';
          }
          $model->update();
          if (Yii::$app->getRequest()->isAjax) {
              $dataProvider = new ActiveDataProvider([
                  'query' => User::find()
              ]);
              return $this->renderPartial('index', [
                          'dataProvider' => $dataProvider
              ]);
          }
          \Yii::$app->session->setFlash('success', \Yii::t('app', $msg));
          return $this->redirect(['index']);
      }

      /**
       * Deletes an existing NewsletterTemplate model.
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
       * Finds the NewsletterTemplate model based on its primary key value.
       * If the model is not found, a 404 HTTP exception will be thrown.
       * @param integer $id
       * @return NewsletterTemplate the loaded model
       * @throws NotFoundHttpException if the model cannot be found
       */
      protected function findModel($id)
      {
          if (($model = NewsletterTemplate::findOne($id)) !== null) {
              return $model;
          }
          else {
              throw new NotFoundHttpException('The requested page does not exist.');
          }
      }

  }
  