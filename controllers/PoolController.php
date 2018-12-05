<?php
namespace app\controllers;

use app\models\CommentsPools;
use app\models\InvestPools;
use app\models\Transactions;
use app\models\User;
use app\models\UserPools;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\helpers\VarDumper;
use yii\widgets\Menu;
use app\models\UserMenu;

class PoolController extends Controller
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionCron()
    {

        foreach (InvestPools::find()->where(['status' => 'new'])->orWhere(['status' => 'active'])->all() as $pool) {
            $today = date('Y-m-d');

            switch ($pool->status) {
                case 'new':
                    if ($today >= $pool->date_start && $today <= $pool->date_end) {
                        $pool->status = "active";
                        $in_pool = InvestPools::haveInvest($pool->id);

                        if ($in_pool < $pool->min_size_invest && $in_pool > $pool->max_size_invest) {
                            foreach (UserPools::find()->where(['pool_id' => $pool->id])->all() as $u_pool) {
                                $user          = User::find()->where(['id' => $u_pool->user_id])->one();
                                $invest_method = $pool->invest_method;

                                if (User::allowedCurrency($invest_method)) {
                                    $user->{$invest_method.'_money'} += $u_pool->invest;
                                } else {
                                    return ['msg' => 'error', 'status' => "Failed currency"];
                                }

                                if ($user->save()) {
                                    $transaction              = new Transactions();
                                    $transaction->type        = 'pool';
                                    $transaction->user_id     = $user->id;
                                    $transaction->status      = -1;
                                    $transaction->amount1     = $u_pool->invest;
                                    //$transaction->amount2     = $amount2;
                                    $transaction->currency1   = $invest_method;
                                    //$transaction->currency2   = $curr2;
                                    $transaction->buyer_name  = Yii::$app->user->identity->username;
                                    $transaction->buyer_email = Yii::$app->user->identity->email;

                                    $transaction->save();

                                    if (!$u_pool->delete()) {
                                        return ['msg' => 'error', 'status' => "User Pool don't deleted"];
                                    }
                                } else {
                                    return ['msg' => 'error', 'status' => "Don't user balance save"];
                                }
                            }
                            $pool->status = "archive";
                        }
                    }
                    break;
                case 'active':
                    $all_period      = (int)((strtotime($pool->date_end) - strtotime($pool->date_start))/(60*60*24));
                    $days_from_start = (int)((strtotime($today) - strtotime($pool->date_start))/(60*60*24));
                    $user_pools      = UserPools::find()
                                                    ->where(['pool_id' => $pool->id])
                                                    ->andWhere(['status'=>'deposit'])
                                                    ->all();

                    foreach ($user_pools as $u_pool) {
                        if (((int)($all_period/$pool->diversification)*$u_pool->diversification <= $days_from_start)) {
                            $user = User::find()->where(['id' => $u_pool->user_id])->one();

                            if (User::allowedCurrency($pool->invest_method)) {
                                $transaction_pay_val = (($u_pool->invest*$pool->profit)/100)/$pool->diversification;
                                $user->{$pool->invest_method.'_money'} +=  $transaction_pay_val;
                            } else {
                                Yii::error("Failed invest method");
                            }

                            if (User::allowedCurrency($pool->invest_method)
                                && $u_pool->diversification == $pool->diversification
                            ) {
                                $u_pool->status = 'withdraw';
                                $user->{$pool->invest_method.'_money'} +=  $u_pool->invest;
                                $transaction_pay_val += $u_pool->invest;
                            } else {
                                Yii::error("Failed invest method");
                            }

                            $u_pool->diversification += 1;

                            if ($u_pool->save()) {
                                $transaction              = new Transactions();
                                $transaction->type        = 'pool';
                                $transaction->user_id     = $user->id;
                                $transaction->status      = 2;
                                $transaction->amount1     = $transaction_pay_val;
                                $transaction->currency1   = $pool->invest_method;
                                $transaction->buyer_name  = Yii::$app->user->identity->username;
                                $transaction->buyer_email = Yii::$app->user->identity->email;

                                $transaction->save();

                                if (!$user->save()) {
                                    Yii::error("Don't save user balance");
                                    return;
                                }
                            } else {
                                Yii::error("Don't save user pool status");
                                return;
                            }
                        }
                    }
                    if ($today > $pool->date_end
                        && !UserPools::find()->where(['pool_id' => $pool->id])->andWhere(['status'=>'deposit'])->count()
                    ) {
                        $pool->status = "archive";
                    }
                    break;
            }
            if ($pool->save()) {
                Yii::trace("Status changed");
            } else {
                Yii::error("Status changed ERROR");
            }
        }
    }

    public function actionIndex()
    {
        $data = [];
        $id = Yii::$app->user->getId();

        $data['pools_new']     = InvestPools::find()
            ->with('comments.user')
            ->where(['status' => 'new'])
            ->orderBy('date_start ASC')
            ->asArray()
            ->all();
        $data['pools_active']  = InvestPools::find()
            ->with('comments.user')
            ->where(['status' => 'active'])
            ->orderBy('date_start ASC')
            ->asArray()
            ->all();
        $data['pools_archive'] = InvestPools::find()
            ->with('comments.user')
            ->where(['status' => 'archive'])
            ->orderBy('date_start ASC')
            ->asArray()
            ->all();

        $u_pools = UserPools::find()->where(['user_id' => $id])->asArray()->all();

        foreach ($u_pools as $item) {
            $data['user_pools'][] = $item;
        }
        foreach ($data['pools_new'] as $item_new) {
            $data['info_pools'][$item_new['id']] = $item_new;
        }
        foreach ($data['pools_active'] as $item_active) {
            $data['info_pools'][$item_active['id']] = $item_active;
        }
        foreach ($data['pools_archive'] as $item_archive) {
            $data['info_pools'][$item_archive['id']] = $item_archive;
        }
        foreach (UserPools::find()
                     ->select('SUM(invest) AS invest, pool_id')
                     ->groupBy('pool_id')
                     ->asArray()
                     ->all() as $item_sum) {
            $data['info_pools'][$item_sum['pool_id']]['sum_invest'] = $item_sum['invest'];
        }

        if (Yii::$app->user->identity->user_role == "admin") {
            foreach (UserPools::find()->asArray()->all() as $admin_pool) {
                $admin_pool['username'] = User::find()->where(['id'=>$admin_pool['user_id']])->one()->username;
                $data['admin_pools'][$admin_pool['pool_id']][] = $admin_pool;
            }
        }

        return $this->render('index', $data);
    }

    public function actionCreatePool()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $id              = Yii::$app->user->getId();
            $profit          = (int)Yii::$app->request->post('profit', '');
            $min_invest      = (double)Yii::$app->request->post('min_invest', '');
            $pool_method     = (string)Yii::$app->request->post('pool_method', '');
            $diversification = (int)Yii::$app->request->post('diversification', 1);
            $name            = (string)Yii::$app->request->post('name', '');
            $desc            = (string)Yii::$app->request->post('description', '');
            $date_start      = Yii::$app->request->post('date_start', '');
            $date_end        = Yii::$app->request->post('date_start', '');
            $min_size        = (double)Yii::$app->request->post('min_size', '');
            $max_size        = (double)Yii::$app->request->post('max_size', '');

            $pool                  = new InvestPools();
            $pool->min_invest      = $min_invest;
            $pool->invest_method   = $pool_method;
            $pool->diversification = $diversification;
            $pool->profit          = $profit;
            $pool->name            = $name;
            $pool->description     = $desc;
            $pool->date_start      = $date_start;
            $pool->date_end        = $date_end;
            $pool->min_size_invest = $min_size;
            $pool->max_size_invest = $max_size;

            if ($pool->save()) {
                return ['msg' => 'ok', 'pool' => $pool];
            } else {
                return ['msg' => 'error', 'pool' => $pool];
            }
        }
    }

    public function actionDeletePool()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->user->getId();
            if (User::canAdmin()) {
                Yii::$app->response->format = 'json';

                $pool_id = (int)Yii::$app->request->post('pool_id', '');

                if (!($pool = InvestPools::findOne(['id'=>$pool_id]) )) {
                    return ['msg' => 'error', 'status' => "No Invest Pool finded"];
                }

                if (InvestPools::haveInvest($pool->id)) {
                    return ['msg' => 'error', 'status' => 'Have money in invest'];
                }

                CommentsPools::deleteAll(['pool_id'=>$pool_id]);

                if ($pool->delete()) {
                    return ['msg' => 'ok', 'status' => "Pool deleted"];
                } else {
                    return ['msg' => 'error', 'status' => "Pool don't deleted"];
                }
            } else {
                return ['msg' => 'error', 'status' => "Dont have asses"];
            }
        }
    }

    public function actionCreateUserPool()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $id      = Yii::$app->user->getId();
            $pool_id = (int)Yii::$app->request->post('pool_id', '');
            $value   = (double)Yii::$app->request->post('value', 0);

            if (!($pool = InvestPools::findOne(['id'=>$pool_id]) )) {
                return ['msg' => 'error', 'status' => "No Invest Pool finded"];
            }

            $user = User::find()->where(['id' => $id])->one();

            if ($pool->status === 'archive' || $pool->status === 'active') {
                return ['msg' => 'error', 'status' => "Archive/Active Pool"];
            }

            $u_pool                  = new UserPools();
            $u_pool->user_id         = $id;
            $u_pool->pool_id         = $pool_id;
            $u_pool->invest          = $value;
            $u_pool->diversification = 1;

            $invest_method           = $pool->invest_method;

            if (User::allowedCurrency($invest_method)) {
                if ($user->{$invest_method.'_money'} < $value) {
                    return ['msg' => 'error', 'status' => "Don't have balance"];
                } elseif ($pool->min_invest > $value) {
                    return ['msg' => 'error', 'status' => "Value lower than minimal invest"];
                }

                $in_pool = InvestPools::haveInvest($pool_id);
                if ((($in_pool+$u_pool->invest) > $pool->max_size_invest)) {
                    return ['msg' => 'error', 'status' => "Bigger than max_pool_size"];
                }

                $user->{$invest_method.'_money'} -= $u_pool->invest;
            } else {
                return ['msg' => 'error', 'status' => "Failed currency"];
            }

            if ($u_pool->save()) {
                if (!$user->save()) {
                    $u_pool->delete();
                    return ['msg' => 'error', 'status' => "User don't save"];
                }

                $transaction              = new Transactions();
                $transaction->type        = 'pool';
                $transaction->user_id     = $id;
                $transaction->status      = 1;
                $transaction->amount1     = $u_pool->invest;
//                $transaction->amount2 = $amount2;
                $transaction->currency1   = $invest_method;
//                $transaction->currency2 = $curr2;
                $transaction->buyer_name  = Yii::$app->user->identity->username;
                $transaction->buyer_email = Yii::$app->user->identity->email;

                $transaction->save();

                return ['msg' => 'ok', 'status' => $u_pool];
            } else {
                return ['msg' => 'error', 'status' => "Don't save pool"];
            }
        }
    }

    public function actionReturnUserMoney()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->user->getId();
            if (User::canAdmin()) {
                Yii::$app->response->format = 'json';

                $user_pool_id = (int)Yii::$app->request->post('user_pool_id', '');

                if (!($u_pool = UserPools::findOne(['id'=>$user_pool_id]) )) {
                    return ['msg' => 'error', 'status' => "No User Pool finded"];
                }
                if (!($pool = InvestPools::findOne(['id'=>$u_pool->pool_id]) )) {
                    return ['msg' => 'error', 'status' => "No Invest Pool finded"];
                }
                if ($pool->status === 'archive' || $pool->status === 'active') {
                    return ['msg' => 'error', 'status' => "Archive/Active Pool"];
                }
                $user          = User::find()->where(['id' => $u_pool->user_id])->one();
                $invest_method = $pool->invest_method;
                $invest        = $u_pool->invest;

                if (User::allowedCurrency($invest_method)) {
                    $user->{$invest_method.'_money'} += $invest;
                } else {
                    return ['msg' => 'error', 'status' => "Failed currency"];
                }

                if ($user->save()) {
                    if ($u_pool->delete()) {
                        $transaction              = new Transactions();
                        $transaction->type        = 'pool';
                        $transaction->user_id     = $user->id;
                        $transaction->status      = -1;
                        $transaction->amount1     = $invest;
//                $transaction->amount2 = $amount2;
                        $transaction->currency1   = $invest_method;
//                $transaction->currency2 = $curr2;
                        $transaction->buyer_name  = Yii::$app->user->identity->username;
                        $transaction->buyer_email = Yii::$app->user->identity->email;

                        $transaction->save();

                        return ['msg' => 'ok', 'status' => "User Pool deleted and returned money"];
                    } else {
                        return ['msg' => 'error', 'status' => "User Pool don't deleted"];
                    }
                } else {
                    return ['msg' => 'error', 'status' => "User balance don't saved"];
                }
            } else {
                return ['msg' => 'error', 'status' => "Dont have asses"];
            }
        }
    }

    public function actionUpdatePool()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->user->getId();
            if (User::canAdmin()) {
                Yii::$app->response->format = 'json';

                $pool_id         = (int)Yii::$app->request->post('pool_id', '');
                $profit          = (int)Yii::$app->request->post('profit', '');
                $min_invest      = (double)Yii::$app->request->post('min_invest', '');
                $pool_method     = (string)Yii::$app->request->post('pool_method', '');
                $diversification = (string)Yii::$app->request->post('diversification', '');
                $name            = (string)Yii::$app->request->post('name', '');
                $desc            = (string)Yii::$app->request->post('description', '');
                $date_start      = Yii::$app->request->post('date_start', '');
                $date_end        = Yii::$app->request->post('date_start', '');
                $min_size        = (double)Yii::$app->request->post('min_size', '');
                $max_size        = (double)Yii::$app->request->post('max_size', '');

                if (!($pool = InvestPools::findOne(['id'=>$pool_id]) )) {
                    return ['msg' => 'error', 'status' => "No Invest Pool finded"];
                }

                if (InvestPools::haveInvest($pool->id)) {
                    return ['msg' => 'error', 'status' => 'Have money in invest'];
                }

                $pool->min_invest      = $min_invest;
                $pool->invest_method   = $pool_method;
                $pool->profit          = $profit;
                $pool->name            = $name;
                $pool->description     = $desc;
                $pool->diversification = $diversification;
                $pool->date_start      = $date_start;
                $pool->date_end        = $date_end;
                $pool->min_size_invest = $min_size;
                $pool->max_size_invest = $max_size;

                if ($pool->save()) {
                    return ['msg' => 'ok', 'status' => "Pool updated"];
                } else {
                    return ['msg' => 'error', 'status' => "Pool don't updated"];
                }
            } else {
                return ['msg' => 'error', 'status' => "Dont have asses"];
            }
        }
    }

    public function actionCreateComment()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->user->getId();
            if (User::canAdmin()) {
                Yii::$app->response->format = 'json';

                $pool_id = (int)Yii::$app->request->post('pool_id', '');
                $comment = (string)Yii::$app->request->post('comment', '');

                if ($comment == "") {
                    return ['msg' => 'error', 'status' => "Comment can't be empty"];
                }

                if (!($pool = InvestPools::findOne(['id'=>$pool_id]))) {
                    return ['msg' => 'error', 'status' => "No Invest Pool finded"];
                }

                $u_comment          = new CommentsPools();
                $u_comment->user_id = $id;
                $u_comment->pool_id = $pool->id;
                $u_comment->comment = $comment;

                if ($u_comment->save()) {
                    return ['msg' => 'ok', 'status' => "Comment saved"];
                } else {
                    return ['msg' => 'error', 'status' => "Comment don't saved"];
                }
            } else {
                return ['msg' => 'error', 'status' => "Dont have asses"];
            }
        }
    }

    public function actionDeleteComment()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->user->getId();
            if (User::canAdmin()) {
                Yii::$app->response->format = 'json';

                $comment_id = (int)Yii::$app->request->post('comment_id', '');
                if (!($u_comment = CommentsPools::findOne(['id'=>$comment_id]))) {
                    return ['msg' => 'error', 'status' => "No Comment finded"];
                }

                if ($u_comment->delete()) {
                    return ['msg' => 'ok', 'status' => "Comment deleted"];
                } else {
                    return ['msg' => 'error', 'status' => "Comment don't deleted"];
                }
            } else {
                return ['msg' => 'error', 'status' => "Dont have asses"];
            }
        }
    }
}
