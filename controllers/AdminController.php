<?php

namespace app\controllers;

use app\models\AdminSettings;
use app\models\Categories;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\Tags;
use app\models\UserMarketplace;

class AdminController extends Controller
{
    public $layout = 'dashboard-layout';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['login', 'logout', 'signup'],
                'rules' => [
                    [
                        'allow' => false,
                        //'actions' => ['login', 'signup'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        //'actions' => ['logout'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        if (User::canAdmin()) {
            $data = [];
            $id = Yii::$app->user->getId();

            $data['categories']     = Categories::find()->where(['parent_id' => null])->all();
            $data['sub_categories'] = Categories::find()->where(['not', ['parent_id' => null]])->all();
            $data['full_tags']      = Tags::find()->all();
            $items = '';
            foreach ($data['full_tags'] as $tag) {
                $items .= $tag->tag_name . ',';
            }
            $data['tags']  = substr($items, 0, (strlen($items)-1));


            $data['types'] = ['api','telegram'];
            $data['user_marketplace'] = UserMarketplace::find()
                ->select(['user_marketplace_id', 'name', 'marketplace_name'])
                ->innerJoin('marketplace', 'marketplace.marketplace_id = user_marketplace.marketplace_id')
                ->where(['user_id' => $id])
                ->andWhere(['user_market_id' => 0])
                ->orderBy('order')
                ->asArray()
                ->all();

            $data['users'] = User::find()->all();

            $data['admin_settings'] = AdminSettings::find()->all();

            return $this->render('index', $data);
        } else {
            return ['msg' => 'error', 'status' => "Dont have asses"];
        }
    }

    public function actionChangeSetting()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->user->getId();
            if (User::canAdmin()) {
                Yii::$app->response->format = 'json';

                $setting_id = (int)Yii::$app->request->post('id', '');
                $value = (string)Yii::$app->request->post('value', '');

                if (!($setting = AdminSettings::findOne(['id'=>$setting_id]) )) {
                    return ['msg' => 'error', 'status' => "No setting finded"];
                }
                $setting->value = $value;

                if ($setting->save()) {
                    return ['msg' => 'ok','status'=>'Настройка сохранена', 'setting' => $setting];
                } else {
                    return ['msg' => 'error','status'=>'При сохранении произошла ошибка', 'setting' => $setting];
                }

            } else {
                return ['msg' => 'error', 'status' => "Dont have asses"];
            }
        }
    }
}
