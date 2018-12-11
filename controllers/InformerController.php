<?php
namespace app\controllers;

use app\models\AdminSettings;
use app\models\Categories;
use app\models\InformerTag;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\Informer;
use app\models\InformerCategory;
use app\models\Tags;
use yii\web\UploadedFile;

class InformerController extends Controller
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

    public function beforeAction($action)
    {
//        $this->enableCsrfValidation = false;
        //Yii::$app->setTimeZone('UTC');
        return parent::beforeAction($action);
    }

    public function afterAction($action, $result)
    {
        //Yii::$app->setTimeZone('Europe/Kiev');
        return parent::afterAction($action, $result);
    }

    public function actionIndex()
    {
        $data = [];

        $tag                = Yii::$app->request->get('tag', null);
        $category_id        = Yii::$app->request->get('category', null);
        $n                  = Yii::$app->request->get('n', 0);
        $id_informer        = Yii::$app->request->get('id', null);
        $data['pagination'] = $n;
        $informers          = Informer::find()->joinWith(['category','tag'])->distinct();
        $data['select']     = new \stdClass();

        if ($tag !== null) {
            $tag = explode(',', $tag);
            $informers = $informers->where(['IN','tag_id',$tag]);
            $data['select']->tag = $tag;
        }

        if ($category_id !== null) {
            $category_id = explode(',', $category_id);
            $informers = $informers->orWhere(['IN','category_id',$category_id]);
            $data['select']->category = $category_id;
        }

        $countQuery                = clone $informers;
        $data['informers']         = $informers->limit(10)->offset(10*$n)->orderBy('date DESC')->all();
        $data['informers_count']   = $countQuery->count();
        $data['categories']        = Categories::find()->where(['parent_id' => null])->all();
        $data['sub_categories']    = Categories::find()->where(['not', ['parent_id' => null]])->all();
        $data['full_categories']   = Categories::find()->all();
        $data['full_tags']         = Tags::find()->all();
        $data['information_title'] = AdminSettings::find()->select('value')->where(['id' => 2])->one();
        $data['information_text']  = AdminSettings::find()->select('value')->where(['id' => 3])->one();

        $items = '';
        foreach ($data['full_tags'] as $tag) {
            $items .= $tag->tag_name . ',';
        }
        $data['tags']  = substr($items, 0, (strlen($items)-1));

        if ($id_informer !== null) {
            $data['informer'] = Informer::find()->where(['id' => $id_informer])->one();
        }

        return $this->render('index', $data);
    }

    public function actionGetInformer()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';

            if (User::canModerate()) {
                $informer_id = (int)Yii::$app->request->post('id', '');

                if (!($informer = Informer::find()
                    ->with('category')
                    ->with('tag')
                    ->where(['id'=>$informer_id])
                    ->asArray()
                    ->one())
                ) {
                    return ['msg' => 'error', 'status' => "No Informer finded"];
                }
                return ['msg' => 'ok','status'=>'Информер найден', 'informer' => $informer];

            } else {
                return ['msg' => 'error', 'status' => "Dont have asses"];
            }
        }
    }

    public function actionCreateInformer()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            if (User::canModerate()) {
                $title            = (string)Yii::$app->request->post('title', '');
                $html             = (string)Yii::$app->request->post('html', '');
                $tags             = (string)Yii::$app->request->post('tags', '');
                $category_id      = (int)Yii::$app->request->post('category_id', '');
                $sub_category_ids = (array)Yii::$app->request->post('sub_category_ids', '');
                $link             = (string)Yii::$app->request->post('link', '');
                $file             = UploadedFile::getInstanceByName('file');

                $informer        = new Informer();
                $informer->title = $title;
                $informer->html  = $html;
                $informer->link  = $link;
                $informer->date  = date("Y-m-d H:i:s");

                $tags = explode(",", $tags);

                if ($file) {
                    if (!is_null($informer->src)) {
                        unlink(Yii::getAlias('@webroot') . $informer->src);
                    }
                    $filePath = '/image/informer/' . time(). $file->baseName . '.' .$file->extension;
                    if ($file->saveAs(Yii::getAlias('@webroot') . $filePath)) {
                        $informer->src = $filePath;
                    }
                }

                if ($informer->save()) {
                    $createInfoCat = $this->createIformerCategory($category_id, $informer->id);
                    if ($createInfoCat !== true) {
                        $informer->delete();
                        return $createInfoCat;
                    }
                    if ($sub_category_ids) {
                        foreach ($sub_category_ids as $sub_category_id) {
                            $createInfoCat = $this->createIformerCategory(
                                (int)$sub_category_id,
                                $informer->id,
                                $category_id
                            );

                            if ($createInfoCat !== true) {
                                $informer->delete();
                                return $createInfoCat;
                            }
                        }
                    }

                    foreach ($tags as $tag) {
                        $createInfoTag = $this->createIformerTag($tag, $informer->id);
                        if ($createInfoTag !== true) {
                            $informer->delete();
                            return $createInfoTag;
                        }
                    }

                    return ['msg' => 'ok','status'=>'Информер создан',  'informer' => $informer];
                } else {
                    return ['msg' => 'error', 'status' => "Don't save informer"];
                }
            } else {
                return ['msg' => 'error', 'status' => "Dont have asses"];
            }
        }
    }
    public function actionUpdateInformer()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            if (User::canModerate()) {
                $informer_id      = (int)Yii::$app->request->post('informer_id', '');
                $title            = (string)Yii::$app->request->post('title', '');
                $html             = (string)Yii::$app->request->post('html', '');
                $tags             = (string)Yii::$app->request->post('tags', '');
                $category_id      = (int)Yii::$app->request->post('category_id', '');
                $sub_category_ids = (array)Yii::$app->request->post('sub_category_ids', '');
                $link             = (string)Yii::$app->request->post('link', '');
                $file             = UploadedFile::getInstanceByName('file');
                $date             = (string)Yii::$app->request->post('date', '');

                if (!($informer = Informer::findOne(['id'=>$informer_id]) )) {
                    return ['msg' => 'error', 'status' => "No Informer finded"];
                }

                $informer->title = $title;
                $informer->html  = $html;
                $informer->link  = $link;
                $informer->date  = $date;

                $tags = explode(",", $tags);

                if ($file) {
                    if (!is_null($informer->src)) {
                        unlink(Yii::getAlias('@webroot') . $informer->src);
                    }
                    $filePath = '/image/informer/' . time(). $file->baseName . '.' .$file->extension;
                    if ($file->saveAs(Yii::getAlias('@webroot') . $filePath)) {
                        $informer->src = $filePath;
                    }
                }

                if ($informer->save()) {
                    InformerCategory::deleteAll(['informer_id'=>$informer_id]);
                    InformerTag::deleteAll(['informer_id'=>$informer_id]);

                    $createInfoCat = $this->createIformerCategory($category_id, $informer->id);
                    if ($createInfoCat !== true) {
                        $informer->delete();
                        return $createInfoCat;
                    }

                    if ($sub_category_ids) {
                        foreach ($sub_category_ids as $sub_category_id) {
                            $createInfoCat = $this->createIformerCategory(
                                (int)$sub_category_id,
                                $informer->id,
                                $category_id
                            );

                            if ($createInfoCat !== true) {
                                $informer->delete();
                                return $createInfoCat;
                            }
                        }
                    }
                    foreach ($tags as $tag) {
                        $createInfoTag = $this->createIformerTag($tag, $informer->id);
                        if ($createInfoTag !== true) {
                            $informer->delete();
                            return $createInfoTag;
                        }
                    }

                    return ['msg' => 'ok', 'status' => "Informer updated"];
                } else {
                    return ['msg' => 'error', 'status' => "Informer don't updated"];
                }
            } else {
                return ['msg' => 'error', 'status' => "Dont have asses"];
            }
        }
    }

    public function actionDeleteInformer()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            if (User::canModerate()) {
                $informer_id = (int)Yii::$app->request->post('informer_id', '');

                if (!($informer = Informer::findOne(['id'=>$informer_id]))) {
                    return ['msg' => 'error', 'status' => "No Informer finded"];
                }

                if (InformerCategory::deleteAll(['informer_id'=>$informer_id])
                    && InformerTag::deleteAll(['informer_id'=>$informer_id])
                ) {
                    if (!is_null($informer->src)) {
                        unlink(Yii::getAlias('@webroot') . $informer->src);
                    }
                    if ($informer->delete()) {
                        return ['msg' => 'ok', 'status' => "Informer deleted"];
                    } else {
                        return ['msg' => 'error', 'status' => "Informer don't deleted"];
                    }
                } else {
                    return ['msg' => 'error', 'status' => "Dont relations delete"];
                }

            } else {
                return ['msg' => 'error', 'status' => "Dont have asses"];
            }
        }
    }

    public function actionCreateCategory()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';

            if (User::canModerate()) {
                $cat_name = (string)Yii::$app->request->post('cat_name', '');
                $parent_id = (int)Yii::$app->request->post('parent_id', 0);

                $informerCategory = new Categories();
                $informerCategory->cat_name  = $cat_name;
                $informerCategory->parent_id = $parent_id;

                if ($informerCategory->save()) {
                    return ['msg' => 'ok','status'=>'Категория создана',  'informerCategory' => $informerCategory];
                } else {
                    return ['msg' => 'error', 'status' => "Don't save informer Category"];
                }
            } else {
                return ['msg' => 'error', 'status' => "Dont have asses"];
            }
        }
    }

    public function actionUpdateCategory()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            if (User::canModerate()) {
                $cat_id    = (string)Yii::$app->request->post('cat_id', '');
                $cat_name  = (string)Yii::$app->request->post('cat_name', '');
                $parent_id = (int)Yii::$app->request->post('parent_id', 0);

                if (!($category = Categories::findOne(['id'=>$cat_id]) )) {
                    return ['msg' => 'error', 'status' => "No Informer Category finded"];
                }
                $category->cat_name  = $cat_name;
                $category->parent_id = $parent_id;

                if ($category->save()) {
                    return ['msg' => 'ok','status'=>'Категория обновлена',  'Category' => $category];
                } else {
                    return ['msg' => 'error', 'status' => "Don't save informer Category"];
                }
            } else {
                return ['msg' => 'error', 'status' => "Dont have asses"];
            }
        }
    }

    public function actionDeleteCategory()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';

            if (User::canModerate()) {
                $cat_id = (string)Yii::$app->request->post('cat_id', '');

                if (!($category = Categories::findOne(['id'=>$cat_id]) )) {
                    return ['msg' => 'error', 'status' => "No Informer Category finded"];
                }

                if (InformerCategory::find()->where(['category_id'=>$cat_id])->count()) {
                    return ['msg' => 'error', 'status' => "Category assigned to Informer"];
                }

                if ($category->delete()) {
                    InformerCategory::updateAll(['parent_id'=>0], 'parent_id = '.$cat_id);
                    return ['msg' => 'ok', 'status' => "Category Deleted"];
                } else {
                    return ['msg' => 'error', 'status' => "Don't save informer Category"];
                }
            } else {
                return ['msg' => 'error', 'status' => "Dont have asses"];
            }
        }
    }

    private static function createIformerCategory($category_id, $informer_id, $parent_id = null)
    {
        if (!($category = Categories::findOne(['id'=>$category_id]) )) {
            return ['msg' => 'error', 'status' => "Don't find category"];
        }

        if ($parent_id !== null && $parent_id !== $category->parent_id) {
            InformerCategory::deleteAll(['informer_id'=>$informer_id]);
            return ['msg' => 'error', 'status' => "Failed parent category"];
        }

        $info_category = new InformerCategory();
        $info_category->category_id = $category_id;
        $info_category->informer_id = $informer_id;

        if (!$info_category->save()) {
            InformerCategory::deleteAll(['informer_id'=>$informer_id]);
            InformerTag::deleteAll(['informer_id'=>$informer_id]);
            return ['msg' => 'error', 'status' => "Don't save categories"];
        }

        return true;
    }
    private static function createIformerTag($tag, $informer_id)
    {
        if ($tag !== '') {
            if (!($info_tags = Tags::findOne(['tag_name'=>$tag]) )) {
                $info_tags = new Tags();
                $info_tags->tag_name = $tag;
                if (!$info_tags->save()) {
                    return ['msg' => 'error', 'status' => "Don't save tags"];
                }
            }

            $info_tag = new InformerTag();
            $info_tag->tag_id      = $info_tags->id;
            $info_tag->informer_id = $informer_id;

            if (!$info_tag->save()) {
                InformerTag::deleteAll(['informer_id'=>$informer_id]);
                InformerCategory::deleteAll(['informer_id'=>$informer_id]);
                return ['msg' => 'error', 'status' => "Don't save tags"];
            }
        }

        return true;
    }

}