<?php

namespace backend\controllers;

use Yii;
use common\models\NewsletterEmailList;
use common\models\NewsletterEmailListSearch;
use common\models\NewsletterEmailListSubscriber;
use common\models\NewsletterEmailSubscriber;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * NewsletterEmailListController implements the CRUD actions for NewsletterEmailList model.
 */
class NewsletterEmailListController extends Controller
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
     * Lists all NewsletterEmailList models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsletterEmailListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single NewsletterEmailList model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $assigned = NewsletterEmailListSubscriber::find()->where(['list_id' => $id])->all();
        $available = NewsletterEmailSubscriber::find()->where(['not in', 'id', NewsletterEmailListSubscriber::find()->select('subscriber_id')])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'available' => $available,
            'assigned' => $assigned
        ]);
    }

    /**
     * Creates a new NewsletterEmailList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new NewsletterEmailList();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing NewsletterEmailList model.
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
     * Deletes an existing NewsletterEmailList model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionAssign($id)
    {
        $ids = Yii::$app->request->post('email_ids');
        if(!empty($ids)){
            $model = NewsletterEmailList::findOne($id);
            foreach ($ids as $subsId){
                $listSubs = new NewsletterEmailListSubscriber();
                $listSubs->list_id = $model->id;
                $listSubs->subscriber_id = $subsId;
                $listSubs->save();
            }
        }
        $assigned = NewsletterEmailListSubscriber::find()->where(['list_id' => $id])->all();
        $available = NewsletterEmailSubscriber::find()->where(['not in', 'id', NewsletterEmailListSubscriber::find()->select('subscriber_id')])->all();
        return $this->renderAjax('assign', ['assigned' => $assigned, 'available' => $available]);
    }
    
    public function actionUnassign($id)
    {
        $ids = Yii::$app->request->post('email_ids');
        if(!empty($ids)){
            $model = NewsletterEmailList::findOne($id);
            foreach ($ids as $subsId){
                NewsletterEmailListSubscriber::deleteAll(['subscriber_id' => $subsId, 'list_id' => $model->id]);
            }
        }
        $assigned = NewsletterEmailListSubscriber::find()->where(['list_id' => $id])->all();
        $available = NewsletterEmailSubscriber::find()->where(['not in', 'id', NewsletterEmailListSubscriber::find()->select('subscriber_id')])->all();
        return $this->renderAjax('assign', ['assigned' => $assigned, 'available' => $available]);
    }

    /**
     * Finds the NewsletterEmailList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NewsletterEmailList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = NewsletterEmailList::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
