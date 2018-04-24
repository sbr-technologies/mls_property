<?php

namespace backend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use \common\models\SiteConfig;
use yii\filters\AccessControl;

class SiteConfigController extends Controller {

        /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
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
    
    public function actionManage() {
        $settingsPost = Yii::$app->request->post("settings");
        if (!empty($settingsPost)) {
            $settings = array_values($settingsPost);
            foreach ($settings as $setting) {
                $mdl = SiteConfig::find()->where(["key" => $setting["key"]])->one();
                if (is_array($setting["value"])) {
                    $setting["value"] = implode("|", $setting["value"]);
                }
                $mdl->value = $setting["value"];
                $mdl->save(false);
            }
            Yii::$app->session->setFlash('success', \Yii::t('app', 'Settings updated successfully.'));
            return $this->refresh();
        }
        $settings = SiteConfig::find()->all();
        return $this->render('manage', ['model' => new SiteConfig(), 'settings' => $settings]);
    }

}
