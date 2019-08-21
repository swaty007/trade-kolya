<?php
namespace app\controllers;

use app\models\AdminSettings;
use app\models\CommentsPools;
use app\models\InvestPools;
use app\models\ReferralsPromocode;
use app\models\Transactions;
use app\models\Notifications;
use app\models\User;
use app\models\UserPools;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;
use yii\widgets\Menu;
use app\models\UserMenu;

class PoolController extends UserAccessController
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
        foreach ( UserPools::find()->with('pool')->where(['status'=> UserPools::STATUS_DEPOSIT ])->orWhere(['status'=> UserPools::STATUS_API ])->all() as $u_pool) {

            $today = date('Y-m-d');
            $pool = $u_pool->pool;
            $day_end = date('Y-m-d', strtotime("+".$pool->period." months", strtotime($today)));

            $all_period      = (int)((strtotime($day_end) - strtotime($u_pool->date))/(60*60*24));
//                    $today = date('Y-m-d', strtotime("+1 months", strtotime($today)));
            $days_from_start = (int)((strtotime($today) - strtotime($u_pool->date))/(60*60*24));
            switch ($u_pool->pool->type) {
                case "direct":
                    if (((int)($all_period/$pool->diversification)*$u_pool->diversification <= $days_from_start)) {
                        $user = User::find()->where(['id' => $u_pool->user_id])->one();

                            if (User::allowedCurrency($pool->invest_method)) {
                                if ($pool->type_percent == "float" && $u_pool->diversification != 1) {
                                    $transaction_pay_val = (($u_pool->invest*$pool->float_profit)/100)/$pool->diversification;
                                } else {
                                    $transaction_pay_val = (($u_pool->invest*$pool->profit)/100)/$pool->diversification;
                                }
//                                $user->{$pool->invest_method.'_money'} +=  $transaction_pay_val;
                                $user_update = $user->updateCounters([$pool->invest_method.'_money' => $transaction_pay_val]);
                            } else {
                                Yii::error("Failed invest method");
//                                return ['msg' => 'error', 'status' => "Failed invest method"];
                            }

                            if ($u_pool->diversification == $pool->diversification) {
                                $u_pool->status = UserPools::STATUS_WITHDRAW;
//                                $user->{$pool->invest_method.'_money'} +=  $u_pool->invest;
                                $user_update2 = $user->updateCounters([$pool->invest_method.'_money' => $u_pool->invest]);
                                $transaction_pay_val += $u_pool->invest;
                            }

                            $u_pool->diversification += 1;

                            if ($u_pool->save()) {
                                $transaction              = new Transactions();
                                $transaction->type        = 'pool';
                                $transaction->sub_type    = 'withdraw';
                                $transaction->comment     = 'Начисление % за пул';
                                $transaction->user_id     = $user->id;
                                $transaction->status      = Transactions::STATUS_DONE;
                                $transaction->amount1     = $transaction_pay_val;
                                $transaction->currency1   = $pool->invest_method;
                                $transaction->buyer_name  = $user->username;
                                $transaction->buyer_email = $user->email;

                                $global_admin = User::find()->where(['id' => Yii::$app->params['globalAdminId']])->one();
//                                $global_admin->{$pool->invest_method.'_money'} -= $transaction_pay_val;
                                $admin_update = $global_admin->updateCounters([$pool->invest_method.'_money' => -$transaction_pay_val]);
                                $transaction_admin = new Transactions();
                                $transaction_admin->amount1     = -1*$transaction_pay_val;
                                $transaction_admin->currency1   = $pool->invest_method;
                                $transaction_admin->type        = 'pool';
                                $transaction_admin->sub_type    = 'withdraw';
                                $transaction_admin->comment     = 'Начисление % за пул';
                                $transaction_admin->status      = Transactions::STATUS_DONE;
                                $transaction_admin->user_id     = $global_admin->id;
                                $transaction_admin->buyer_name  = $user->username;
                                $transaction_admin->buyer_email = $user->email;

                                $notification = new Notifications();
                                $notification->createNotification($user->id,
                                    'success',
                                    'Вы успещно получили выплату % за пул',
                                    $transaction->attributes);

//                                if (!$user->save() || !$global_admin->save()) {
                                if (!$user_update || !$user_update2 || !$admin_update) {
                                    Yii::error("Don't save user balance");
//                                    return ['msg' => 'error', 'status' => "Don't save user balance"];
                                }
                                if (!$transaction->save() || !$transaction_admin->save()) {
                                    Yii::error("Транзакция не сохранилась");
//                                    return ['msg' => 'error', 'status' => "Транзакция не сохранилась"];
                                }
                            } else {
                                Yii::error("Don't save user pool status");
//                                return ['msg' => 'error', 'status' => "Don't save user pool status"];
                            }
                        }

//                    if ($today > $pool->date_end
//                        && !UserPools::find()->where(['pool_id' => $pool->id])->andWhere(['status'=>UserPools::STATUS_DEPOSIT])->count()
//                    ) {
//                        $pool->status = "archive";
//                    }
                    break;
                case "API":

                    if (((int)($all_period/$pool->diversification)*$u_pool->diversification <= $days_from_start)) {
                        $user = User::find()->where(['id' => $u_pool->user_id])->one();

                        if (User::allowedCurrency($pool->invest_method)) {
                            if ($pool->type_percent == "float" && $u_pool->diversification != 1) {
                                $transaction_pay_val = (($u_pool->invest*$pool->float_profit)/100)/$pool->diversification;
                            } else {
                                $transaction_pay_val = (($u_pool->invest*$pool->profit)/100)/$pool->diversification;
                            }

                        } else {
                            Yii::error("Failed invest method");
                        }


                        // Начисления по рефералам тут
                        if (!!($parent_referral_id = ReferralsPromocode::findReferralId($user->promocode_id))) {
                            if (!!($user_referral = User::findOne(['id'=>$parent_referral_id]) )) {

//                                        $referral_bonus_percent = (($u_pool->invest*(int)AdminSettings::findOne(['id' => 14])->value)/100);
                                $referral_bonus_percent = $pool->referral_percent;
//                                        $user_referral->{$pool->invest_method.'_money'} += $referral_bonus_percent;
                                $referral_value = ($transaction_pay_val*$referral_bonus_percent)/100;
                                $referral_update = $user_referral->updateCounters([$pool->invest_method.'_money' => $referral_value]);

                                $transaction_referral              = new Transactions();
                                $transaction_referral->type        = 'pool';
                                $transaction_referral->sub_type    = 'referral';
//                                        $transaction_referral->comment     = 'Начисление '.AdminSettings::findOne(['id' => 14])->value.'% за пул (реферальный)';
                                $transaction_referral->comment     = 'Начисление '.$referral_bonus_percent.'% за пул (реферальный)';
                                $transaction_referral->user_id     = $user_referral->id;
                                $transaction_referral->status      = Transactions::STATUS_DONE;
                                $transaction_referral->amount1     = $referral_value;
                                $transaction_referral->amount2     = $transaction_pay_val;
                                $transaction_referral->currency1   = $pool->invest_method;
                                $transaction_referral->buyer_name  = $user->username;
                                $transaction_referral->buyer_email = $user->email;

                                $notification_referral = new Notifications();
                                $notification_referral->createNotification($user_referral->id,
                                    'success',
                                    'Вы успещно получили выплату % за пул (реферальный)',
                                    $transaction_referral->attributes);

//                                        if (!$user_referral->save()) {
                                if (!$referral_update) {
                                    Yii::error("Don't save user balance");
//                                            return ['msg' => 'error', 'status' => "Don't save user balance"];
                                }
                                if (!$transaction_referral->save()) {
                                    Yii::error("Транзакция реферала не сохранилась");
                                    return ['msg' => 'error', 'status' => "Транзакция реферала не сохранилась"];
                                }
                            }
                        }
//                             конец реферальных начислений


                        if ($u_pool->diversification == $pool->diversification) {
                            $u_pool->status = UserPools::STATUS_WITHDRAW;
                            $transaction_pay_val += $u_pool->invest;
                        }

                        $u_pool->diversification += 1;

                        if ($u_pool->save()) {
                            $transaction              = new Transactions();
                            $transaction->type        = 'pool';
                            $transaction->sub_type    = 'withdraw';
                            $transaction->comment     = 'Начисление % за пул API';
                            $transaction->user_id     = $user->id;
                            $transaction->status      = Transactions::STATUS_API;
                            $transaction->amount1     = $transaction_pay_val;
                            $transaction->currency1   = $pool->invest_method;
                            $transaction->buyer_name  = $user->username;
                            $transaction->buyer_email = $user->email;

                            $global_admin = User::find()->where(['id' => Yii::$app->params['globalAdminId']])->one();
                            $transaction_admin = new Transactions();
                            $transaction_admin->amount1     = -1*$transaction_pay_val;
                            $transaction_admin->currency1   = $pool->invest_method;
                            $transaction_admin->type        = 'pool';
                            $transaction_admin->sub_type    = 'withdraw';
                            $transaction_admin->comment     = 'Начисление % за пул API';
                            $transaction_admin->status      = Transactions::STATUS_API;
                            $transaction_admin->user_id     = $global_admin->id;
                            $transaction_admin->buyer_name  = $user->username;
                            $transaction_admin->buyer_email = $user->email;

                            $notification = new Notifications();
                            $notification->createNotification($user->id,
                                'success',
                                'Вы успещно получили выплату % за API пул',
                                $transaction->attributes);


                            if (!$transaction->save() || !$transaction_admin->save()) {
                                Yii::error("Транзакция не сохранилась");
                            }
                        } else {
                            Yii::error("Don't save user pool status");
                        }
                    }

                    break;
            }
        };







//        foreach (InvestPools::find()->where(['status' => 'new'])->orWhere(['status' => 'active'])->all() as $pool) {
//            $today = date('Y-m-d');
//
//            switch ($pool->status) {
//                case 'new':
//                    if ($today >= $pool->date_start && $today <= $pool->date_end) {
//                        $pool->status = "active";
//                        $in_pool = InvestPools::haveInvest($pool->id);
//
//                        if ($in_pool < $pool->min_size_invest && $in_pool > $pool->max_size_invest) {
//                            foreach (UserPools::find()->where(['pool_id' => $pool->id])->all() as $u_pool) {
//                                $user          = User::find()->where(['id' => $u_pool->user_id])->one();
//                                $invest_method = $pool->invest_method;
//
//                                if (User::allowedCurrency($invest_method)) {
////                                    $user->{$invest_method.'_money'} += $u_pool->invest;
//                                    $user_update = $user->updateCounters([$invest_method.'_money' => $u_pool->invest]);
//                                } else {
//                                     Yii::error("Failed currency");
//                                    return ['msg' => 'error', 'status' => "Failed currency"];
//                                }
//
//                                $global_admin = User::find()->where(['id' => Yii::$app->params['globalAdminId']])->one();
////                                $global_admin->{$invest_method.'_money'} -= $u_pool->invest;
//                                $admin_update = $global_admin->updateCounters([$invest_method.'_money' => -$u_pool->invest]);
//                                $transaction_admin = new Transactions();
//                                $transaction_admin->amount1     = -1*$u_pool->invest;
//                                $transaction_admin->currency1   = $invest_method;
//                                $transaction_admin->type        = 'pool';
//                                $transaction_admin->sub_type    = 'refund';
//                                $transaction_admin->comment     = 'Возврат с пула (не собралась нужная сума для старта)';
//                                $transaction_admin->status      = Transactions::STATUS_DONE;
//                                $transaction_admin->user_id     = $global_admin->id;
//                                $transaction_admin->buyer_name  = $user->username;
//                                $transaction_admin->buyer_email = $user->email;
//
////                                if ($user->save() && $global_admin->save()) {
//                                if ($user_update && $admin_update) {
//                                    $transaction              = new Transactions();
//                                    $transaction->type        = 'pool';
//                                    $transaction->sub_type    = 'refund';
//                                    $transaction->comment     = 'Возврат с пула (не собралась нужная сума для старта)';
//                                    $transaction->user_id     = $user->id;
//                                    $transaction->status      = Transactions::STATUS_REFUND;
//                                    $transaction->amount1     = $u_pool->invest;
//                                    //$transaction->amount2     = $amount2;
//                                    $transaction->currency1   = $invest_method;
//                                    //$transaction->currency2   = $curr2;
//                                    $transaction->buyer_name  = Yii::$app->user->identity->username;
//                                    $transaction->buyer_email = Yii::$app->user->identity->email;
//
//                                    $notification = new Notifications();
//                                    $notification->createNotification($user->id,
//                                        'notification',
//                                        'Вы получили возврат по пулу потому-что он не запустился',
//                                        $transaction->attributes);
//
//                                    if (!$transaction->save() || !$transaction_admin->save()) {
//                                         Yii::error("Транзакция не сохранилась");
//                                        return ['msg' => 'error', 'status' => "Транзакция не сохранилась"];
//                                    }
//
//                                    if (!$u_pool->delete()) {
//                                         Yii::error("User Pool don't deleted");
//                                        return ['msg' => 'error', 'status' => "User Pool don't deleted"];
//                                    }
//                                } else {
//                                     Yii::error("Don't user balance save");
//                                    return ['msg' => 'error', 'status' => "Don't user balance save"];
//                                }
//                            }
//                            $pool->status = "archive";
//                        }
//                    }
//                    break;
//                case 'active':
//
//            }
//            if ($pool->save()) {
//                Yii::trace("Status changed");
//            } else {
//                Yii::error("Status changed ERROR");
//            }
//        }
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

        if (User::canAdmin()) {
            foreach (UserPools::find()->asArray()->all() as $admin_pool) {
                $admin_pool['username'] = User::find()->where(['id'=>$admin_pool['user_id']])->one()->username;
                $data['admin_pools'][$admin_pool['pool_id']][] = $admin_pool;
            }
        }

        return $this->render('index', $data);
    }
    public function actionShow($pool_id)
    {
        $data = [];
        $id = Yii::$app->user->getId();

        $data['pool'] = InvestPools::find()
            ->with('comments.user')
            ->where(['id' => $pool_id])
            ->asArray()
            ->one();

        if (User::canAdmin()) {
            foreach (UserPools::find()->asArray()->all() as $admin_pool) {
                $admin_pool['username'] = User::find()->where(['id'=>$admin_pool['user_id']])->one()->username;
                $data['admin_pools'][$admin_pool['pool_id']][] = $admin_pool;
            }
        }

        return $this->render('show', $data);
    }

    public function actionCreatePool()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $id              = Yii::$app->user->getId();
            $type          = (string)Yii::$app->request->post('type', '');
            $form          = (string)Yii::$app->request->post('form', '');
            $profit          = (int)Yii::$app->request->post('profit', '');
            $float_profit          = (int)Yii::$app->request->post('float_profit', '');
            $min_invest      = (double)Yii::$app->request->post('min_invest', '');
            $pool_method     = (string)Yii::$app->request->post('pool_method', '');
            $diversification = (int)Yii::$app->request->post('diversification', '');
            $name            = (string)Yii::$app->request->post('name', '');
            $desc            = (string)Yii::$app->request->post('description', '');
            $full_desc            = (string)Yii::$app->request->post('full_description', '');
            $period            = (int)Yii::$app->request->post('month', '');
            $type_percent            = (string)Yii::$app->request->post('type_percent', '');
            $referral_percent            = (string)Yii::$app->request->post('referral_percent', '');
//            $date_start      = Yii::$app->request->post('date_start', '');
//            $date_end        = Yii::$app->request->post('date_end', '');
//            $min_size        = (double)Yii::$app->request->post('min_size', '');
//            $max_size        = (double)Yii::$app->request->post('max_size', '');
            $file            = UploadedFile::getInstanceByName('file');


            $today = date('Y-m-d');
            $date_start = $today;
//            $date_end = date("Y-m-d", strtotime("+".$period." month", $today));

            $pool                   = new InvestPools();
            $pool->type             = $type;
            $pool->form             = $form;
            $pool->type_percent     = $type_percent;
            $pool->min_invest       = $min_invest;
            $pool->invest_method    = $pool_method;
            $pool->diversification  = $diversification;
            $pool->profit           = $profit;
            $pool->float_profit     = $float_profit;
            $pool->period           = $period;
            $pool->name             = $name;
            $pool->description      = $desc;
            $pool->referral_percent = $referral_percent;
            $pool->full_description = $full_desc;
            $pool->date_start       = $date_start;
            //$pool->status           = 'new';
//            $pool->date_end        = $date_end;
//            $pool->min_size_invest = $min_size;
//            $pool->max_size_invest = $max_size;

            if ($file) {
                if (!is_null($pool->src)) {
                    unlink(Yii::getAlias('@webroot') . $pool->src);
                }
                $filePath = '/image/pool/' . time(). $file->baseName . '.' .$file->extension;
                if ($file->saveAs(Yii::getAlias('@webroot') . $filePath)) {
                    $pool->src = $filePath;
                }
            }

            if ($pool->save()) {
                return ['msg' => 'ok', 'pool' => $pool, 'status' => 'Pull created'];
            } else {
                return ['msg' => 'error', 'pool' => $pool, 'status' => 'Pull dont created'];
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
                $diversification = (string)Yii::$app->request->post('diversification_edit', '');
                $name            = (string)Yii::$app->request->post('name', '');
                $desc            = (string)Yii::$app->request->post('description', '');

                $type          = (string)Yii::$app->request->post('type', '');
                $form          = (string)Yii::$app->request->post('form', '');
                $float_profit          = (int)Yii::$app->request->post('float_profit', '');
                $full_desc            = (string)Yii::$app->request->post('full_description', '');
                $period            = (int)Yii::$app->request->post('month', '');
                $type_percent            = (string)Yii::$app->request->post('type_percent', '');
                $referral_percent            = (string)Yii::$app->request->post('referral_percent', '');

//                $date_start      = Yii::$app->request->post('date_start', '');
//                $date_end        = Yii::$app->request->post('date_end', '');
//                $min_size        = (double)Yii::$app->request->post('min_size', '');
//                $max_size        = (double)Yii::$app->request->post('max_size', '');
                $file             = UploadedFile::getInstanceByName('file');
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
//                $pool->date_start      = $date_start;
//                $pool->date_end        = $date_end;
//                $pool->min_size_invest = $min_size;
//                $pool->max_size_invest = $max_size;

                $pool->type             = $type;
                $pool->form             = $form;
                $pool->type_percent     = $type_percent;
                $pool->float_profit     = $float_profit;
                $pool->period           = $period;
                $pool->referral_percent = $referral_percent;
                $pool->full_description = $full_desc;
//                $pool->date_start       = $date_start;

                if ($file) {
                    if (!is_null($pool->src)) {
                        unlink(Yii::getAlias('@webroot') . $pool->src);
                    }
                    $filePath = '/image/pool/' . time(). $file->baseName . '.' .$file->extension;
                    if ($file->saveAs(Yii::getAlias('@webroot') . $filePath)) {
                        $pool->src = $filePath;
                    }
                }

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
                if (!is_null($pool->src)) {
                    unlink(Yii::getAlias('@webroot') . $pool->src);
                }

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

            $global_admin = User::find()->where(['id' => Yii::$app->params['globalAdminId']])->one();
            $transaction_admin              = new Transactions();
            $transaction_admin->comment     = 'Покупка пула API';
            $transaction                    = new Transactions();
            $transaction->comment           = 'Покупка пула API';

            if ($pool->min_invest > $value) {
                return ['msg' => 'error', 'status' => "Value lower than minimal invest"];
            }

            switch ($pool->type) {
                case "API":
                    $transaction_admin->status      = Transactions::STATUS_API;
                    $transaction->status            = Transactions::STATUS_API;

                    $u_pool->status = UserPools::STATUS_WAIT_ACTIVATION;
                    break;
                case "direct":
                    if (User::allowedCurrency($invest_method)) {
                        if ($user->{$invest_method.'_money'} < $value) {
                            return ['msg' => 'error', 'status' => "Don't have balance"];
                        }

                        $in_pool = InvestPools::haveInvest($pool_id);
//                if ((($in_pool+$u_pool->invest) > $pool->max_size_invest)) {
//                    return ['msg' => 'error', 'status' => "Bigger than max_pool_size"];
//                }

//                $user->{$invest_method.'_money'} -= $u_pool->invest;
                        $user_update = $user->updateCounters([$invest_method.'_money' => -$u_pool->invest]);
                    } else {
                        return ['msg' => 'error', 'status' => "Failed currency"];
                    }
                    //                $global_admin->{$invest_method.'_money'} += $u_pool->invest;
                    $admin_update = $global_admin->updateCounters([$invest_method.'_money' => $u_pool->invest]);

                    //                if (!$user->save() || !$global_admin->save()) {
                    if (!$user_update || !$admin_update) {
                        $u_pool->delete();
                        return ['msg' => 'error', 'status' => "User don't save"];
                    }
                    $transaction_admin->status      = Transactions::STATUS_DONE;
                    $transaction_admin->comment     = 'Покупка пула';
                    $transaction->status            = Transactions::STATUS_DONE;
                    $transaction->comment     = 'Покупка пула';

                    $u_pool->status = UserPools::STATUS_DEPOSIT;
                    // Начисления по рефералам тут
                    if (!!($parent_referral_id = ReferralsPromocode::findReferralId($user->promocode_id))) {
                        if (!!($user_referral = User::findOne(['id'=>$parent_referral_id]) )) {

//                                        $referral_bonus_percent = (($u_pool->invest*(int)AdminSettings::findOne(['id' => 14])->value)/100);
                            $referral_bonus_percent = $pool->referral_percent;
//                                        $user_referral->{$pool->invest_method.'_money'} += $referral_bonus_percent;
                            $referral_value = ($u_pool->invest*$referral_bonus_percent)/100;
                            $referral_update = $user_referral->updateCounters([$pool->invest_method.'_money' => $referral_value]);

                            $transaction_referral              = new Transactions();
                            $transaction_referral->type        = 'pool';
                            $transaction_referral->sub_type    = 'referral';
//                                        $transaction_referral->comment     = 'Начисление '.AdminSettings::findOne(['id' => 14])->value.'% за пул (реферальный)';
                            $transaction_referral->comment     = 'Начисление '.$referral_bonus_percent.'% за пул (реферальный)';
                            $transaction_referral->user_id     = $user_referral->id;
                            $transaction_referral->status      = Transactions::STATUS_DONE;
                            $transaction_referral->amount1     = $referral_value;
                            $transaction_referral->amount2     = $u_pool->invest;
                            $transaction_referral->currency1   = $pool->invest_method;
                            $transaction_referral->buyer_name  = $user->username;
                            $transaction_referral->buyer_email = $user->email;

                            $notification_referral = new Notifications();
                            $notification_referral->createNotification($user_referral->id,
                                'success',
                                'Вы успещно получили выплату % за пул (реферальный)',
                                $transaction_referral->attributes);

//                                        if (!$user_referral->save()) {
                            if (!$referral_update) {
                                Yii::error("Don't save user balance");
//                                            return ['msg' => 'error', 'status' => "Don't save user balance"];
                            }
                            if (!$transaction_referral->save()) {
                                Yii::error("Транзакция реферала не сохранилась");
                                return ['msg' => 'error', 'status' => "Транзакция реферала не сохранилась"];
                            }
                        }
                    }
//                             конец реферальных начислений
                    break;
                default:
                    return ['msg' => 'error', 'status' => "Not allowed type"];
                    break;
            }

            if ($u_pool->save()) {

                $transaction_admin->amount1     = $u_pool->invest;
                $transaction_admin->currency1   = $invest_method;
                $transaction_admin->type        = 'pool';
                $transaction_admin->sub_type    = 'deposit';
                $transaction_admin->user_id     = $global_admin->id;
                $transaction_admin->buyer_name  = $user->username;
                $transaction_admin->buyer_email = $user->email;


                $transaction->type        = 'pool';
                $transaction->sub_type    = 'deposit';
                $transaction->user_id     = $id;
                $transaction->amount1     = -1*$u_pool->invest;
//                $transaction->amount2 = $amount2;
                $transaction->currency1   = $invest_method;
//                $transaction->currency2 = $curr2;
                $transaction->buyer_name  = Yii::$app->user->identity->username;
                $transaction->buyer_email = Yii::$app->user->identity->email;

                if (!$transaction->save() || !$transaction_admin->save()) {
                    return ['msg' => 'error', 'status' => "Транзакция не сохранилась"];
                }

                return ['msg' => 'ok', 'status' => 'Вы успещно вложили деньги', 'pool' => $u_pool];
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

                if (!($u_pool = UserPools::findOne(['id'=>$user_pool_id, 'status' => UserPools::STATUS_DEPOSIT]) )) {
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
//                    $user->{$invest_method.'_money'} += $invest;
                    $user_update = $user->updateCounters([$invest_method.'_money' => $invest]);
                } else {
                    return ['msg' => 'error', 'status' => "Failed currency"];
                }

                $global_admin = User::find()->where(['id' => Yii::$app->params['globalAdminId']])->one();
//                $global_admin->{$invest_method.'_money'} -= $invest;
                $admin_update = $global_admin->updateCounters([$invest_method.'_money' => -$invest]);
                $transaction_admin = new Transactions();
                $transaction_admin->amount1     = -1*$invest;
                $transaction_admin->currency1   = $invest_method;
                $transaction_admin->type        = 'pool';
                $transaction_admin->sub_type    = 'refund';
                $transaction_admin->comment     = 'Возврат с пула';
                $transaction_admin->status      = Transactions::STATUS_DONE;
                $transaction_admin->user_id     = $global_admin->id;
                $transaction_admin->buyer_name  = $user->username;
                $transaction_admin->buyer_email = $user->email;

//                if ($user->save() && $global_admin->save()) {
                if ($user_update->save() && $admin_update->save()) {
                    if ($u_pool->delete()) {
                        $transaction              = new Transactions();
                        $transaction->type        = 'pool';
                        $transaction->sub_type    = 'refund';
                        $transaction->comment     = 'Возврат с пула';
                        $transaction->user_id     = $user->id;
                        $transaction->status      = Transactions::STATUS_DONE;
                        $transaction->amount1     = $invest;
//                $transaction->amount2 = $amount2;
                        $transaction->currency1   = $invest_method;
//                $transaction->currency2 = $curr2;
                        $transaction->buyer_name  = Yii::$app->user->identity->username;
                        $transaction->buyer_email = Yii::$app->user->identity->email;

                        if (!$transaction->save() || !$transaction_admin->save()) {
                            return ['msg' => 'error', 'status' => "Транзакция не сохранилась"];
                        }

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

    public function actionConfirmPoolApi()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->user->getId();
            if (User::canAdmin()) {
                Yii::$app->response->format = 'json';

                $user_pool_id = (int)Yii::$app->request->post('user_pool_id', '');

                if (!($u_pool = UserPools::findOne(['id'=>$user_pool_id, 'status' => UserPools::STATUS_WAIT_ACTIVATION]) )) {
                    return ['msg' => 'error', 'status' => "No User Pool finded"];
                }
                if (!($pool = InvestPools::findOne(['id'=>$u_pool->pool_id]) )) {
                    return ['msg' => 'error', 'status' => "No Invest Pool finded"];
                }
                if ($pool->status === 'archive' || $pool->status === 'active') {
                    return ['msg' => 'error', 'status' => "Archive/Active Pool"];
                }
                $timestamp = date('Y-m-d G:i:s');
                $u_pool->status = UserPools::STATUS_API;
                $u_pool->date = $timestamp;
                $user          = User::find()->where(['id' => $u_pool->user_id])->one();
                $invest_method = $pool->invest_method;
                $invest        = $u_pool->invest;

                $notification = new Notifications();
                $notification->createNotification($u_pool->user_id,
                    'success',
                    'Вам успещно подвердили оплату АПИ пула');


                // Начисления по рефералам тут
                if (!!($parent_referral_id = ReferralsPromocode::findReferralId($user->promocode_id))) {
                    if (!!($user_referral = User::findOne(['id'=>$parent_referral_id]) )) {

//                                        $referral_bonus_percent = (($u_pool->invest*(int)AdminSettings::findOne(['id' => 14])->value)/100);
                        $referral_bonus_percent = $pool->referral_percent;
//                                        $user_referral->{$pool->invest_method.'_money'} += $referral_bonus_percent;
                        $referral_value = ($u_pool->invest*$referral_bonus_percent)/100;
                        $referral_update = $user_referral->updateCounters([$pool->invest_method.'_money' => $referral_value]);

                        $transaction_referral              = new Transactions();
                        $transaction_referral->type        = 'pool';
                        $transaction_referral->sub_type    = 'referral';
//                                        $transaction_referral->comment     = 'Начисление '.AdminSettings::findOne(['id' => 14])->value.'% за пул (реферальный)';
                        $transaction_referral->comment     = 'Начисление '.$referral_bonus_percent.'% за пул (реферальный)';
                        $transaction_referral->user_id     = $user_referral->id;
                        $transaction_referral->status      = Transactions::STATUS_DONE;
                        $transaction_referral->amount1     = $referral_value;
                        $transaction_referral->amount2     = $u_pool->invest;
                        $transaction_referral->currency1   = $pool->invest_method;
                        $transaction_referral->buyer_name  = $user->username;
                        $transaction_referral->buyer_email = $user->email;

                        $notification_referral = new Notifications();
                        $notification_referral->createNotification($user_referral->id,
                            'success',
                            'Вы успещно получили выплату % за пул (реферальный)',
                            $transaction_referral->attributes);

//                                        if (!$user_referral->save()) {
                        if (!$referral_update) {
                            Yii::error("Don't save user balance");
//                                            return ['msg' => 'error', 'status' => "Don't save user balance"];
                        }
                        if (!$transaction_referral->save()) {
                            Yii::error("Транзакция реферала не сохранилась");
                            return ['msg' => 'error', 'status' => "Транзакция реферала не сохранилась"];
                        }
                    }
                }
//                             конец реферальных начислений

                if ($u_pool->save()) {
                    return ['msg' => 'ok', 'status' => "User Pool API activated"];
                } else {
                    return ['msg' => 'error', 'status' => "User Pool don't save"];
                }
            } else {
                return ['msg' => 'error', 'status' => "Dont have asses"];
            }
        }
    }

    public function actionCreateComment()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $id = Yii::$app->user->getId();
            if (User::canAdmin()) {

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
