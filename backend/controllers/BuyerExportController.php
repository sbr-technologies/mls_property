<?php

namespace backend\controllers;

use Yii;
use common\models\Buyer;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use yii\helpers\ArrayHelper;
use common\models\BuyerWorkSheet;
use common\models\BuyerWorkSheetSearch;
/**
 * BuyerExportController implements the CRUD actions for Buyer model.
 */
class BuyerExportController extends Controller
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
     * Lists all Buyer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Buyer::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Buyer model.
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
     * Creates a new Buyer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Buyer();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Buyer model.
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
     * Deletes an existing Buyer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionCriteriaWorksheet(){
//        $allModels = BuyerWorkSheet::find()->all();
//        $attributes =['User Name', 'User Email', 'State', 'LGA', 'Town', 'Area', 'Comment Location', 'Price Range From',
//                'Price Range To', 'How Soon Need', 'Usage', 'Investment', 'Cash Flow', 'Appricition', 'Need Agent', 'Contact Me', 
//                'Year Built', 'Bed', 'Bath', 'Living', 'Dining', 'Stories', 'Square Footage', 'Celling', 'Feature Comment', 'Amenities Comment', 
//                'Additional Criteria', 'Condition', 'Commercial', 'Demolition', 'Property Amenities', 'Other Features', 'Property Types'];
//        if(Yii::$app->request->isPost){
//            $tempDir = './tmp/';
//            $time = strtotime('now');
//            if(!file_exists($tempDir)){
//                mkdir($tempDir);
//            }
//            $fileName = "{$time}_buyer-criteria-worksheet.xlsx";
//            $filePath = $tempDir.$fileName;
//            $spreadsheet = new Spreadsheet();
//            $sheet = $spreadsheet->getActiveSheet();
//            if(!empty($allModels)){
//                $row = 1;
//                $col = 'A';
//                foreach ($allModels as $model){
//                    if($row == 1){
//                        foreach ($attributes as $label){
//                            $sheet->setCellValue("{$col}$row", $label);
//                            $col++;
//                        }
//                        $row++;
//                    }
//                    $col = 'A';
//                    $sheet->setCellValue("$col$row", $model->user->fullName);
//                    $col++;
//                    $sheet->setCellValue("$col$row", $model->user->email);
//                    $col++;
//                    foreach($model->getAttributes(null, ['id', 'user_id', 'property_types']) as $attribute){
//                        $sheet->setCellValue("$col$row", $attribute);
//                        $col++;
//                    }
//                    $propTypeNames = implode(', ', ArrayHelper::getColumn($model->propertyTypesNames, 'title'));
//                    $sheet->setCellValue("$col$row", $propTypeNames);
//                    $row++;
//                }
//            }
//            $writer = new Xlsx($spreadsheet);
//            $writer->save($filePath);
//            Yii::$app->response->sendFile($filePath, 'Buyer Criteria Worksheet-'. date('j-F-Y'));
//        }
        $searchModel = new BuyerWorkSheetSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('criteria-worksheet', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
    }

    /**
     * Finds the Buyer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Buyer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Buyer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
