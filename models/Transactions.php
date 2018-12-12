<?php

namespace app\models;

use yii;
use app\models\api\CoinPayments;
use yii\db\ActiveRecord;
use app\models\User;
use yii\helpers\Url;

/**
 * This is the model class for table "transactions".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $status
 * @property double $amount1
 * @property double $amount2
 * @property string $currency1
 * @property string $currency2
 * @property string $type
 * @property string $sub_type
 * @property string $buyer_name
 * @property string $buyer_email
 * @property string $user_purse
 * @property integer $txn_id
 * @property integer $confirms_needed
 * @property string $date_start
 * @property string $comment
 * @property string $date_last
 */
class Transactions extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transactions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id','status','amount1','currency1' ], 'required'],
            [['status', 'user_id',  'confirms_needed'], 'integer'],
            [['amount1', 'amount2'], 'number'],
            [['date_start', 'date_last'], 'safe'],
            [['currency1', 'currency2'], 'string', 'max' => 20],
            [['buyer_name', 'buyer_email'], 'string', 'max' => 100],
            [['txn_id'], 'string', 'max' => 255],
            [['user_purse'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'amount1' => 'Amount1',
            'amount2' => 'Amount2',
            'type' => 'Type',
            'sub_type' => 'Sub Type',
            'currency1' => 'Currency1',
            'currency2' => 'Currency2',
            'buyer_name' => 'Buyer Name',
            'buyer_email' => 'Buyer Email',
            'txn_id' => 'Txn ID',
            'user_purse' => 'User Address',
            'confirms_needed' => 'Confirms Needed',
            'date_start' => 'Date Start',
            'date_last' => 'Date Last',
        ];
    }

    public function checkRate()
    {
        $cps = new CoinPayments();
        $result = $cps->getRates();
        if ($result['error'] == 'ok') {
            return $result['result'];
        } else {
            return 'Error: '.$result['error']."\n";
        }
    }

    public function createTransaction()
    {
        $cps = new CoinPayments();

        $rates_btc = $cps->GetRates();

        //($this->amount1 - $rates_btc['result'][$this->currency1]['tx_fee']) * $rates_btc['result'][$this->currency1]['rate_btc'])
        $commission_persent = (double)AdminSettings::findOne(['id'=>4])->value;
        $commission = ($this->amount1/100)*$commission_persent;
        $amount_in_btc = number_format(
        ($this->amount1 - $commission), 15,'.','');

        $req = array(
            'amount' => $this->amount1,
            'currency1' => $this->currency1,
            'currency2' => $this->currency1,
            'address' => '', // leave blank send to follow your settings on the Coin Settings page
            'buyer_email' => $this->buyer_email, // leave blank send to follow your settings on the Coin Settings page
            'buyer_name' => $this->buyer_name, // leave blank send to follow your settings on the Coin Settings page
            'item_number' => '', // leave blank send to follow your settings on the Coin Settings page
            'custom' => $amount_in_btc, // СЂР°РЅРґРѕРјРЅРѕРµ РїРѕР»Рµ
            'invoice' => $this->user_id, //СЂР°РЅРґРѕРјРЅРѕРµ РїРѕР»Рµ 2
            'item_name' => 'Test Item/Order Description',
            'ipn_url' => Url::to(['coins/api-answer'],'https'),
        );

        $result = $cps->createTransaction($req);

        $result['result']['txn_id'];
        $result['result']['address'];
        $result['result']['amount'];
        $result['result']['txn_id'];
        $result['result']['confirms_needed'];
        $result['result']['timeout'];
        $result['result']['status_url'];
        $result['result']['qrcode_url'];

        if ($result['error'] == 'ok') {
            $this->status = 0;
            $this->amount2 = $commission;
//            $this->currency2 =  "BTC";
            $this->txn_id = $result['result']['txn_id'];
            $this->confirms_needed = floatval($result['result']['confirms_needed']);
            return [
                'result' => 'ok',
                'status_url' => $result['result']['status_url'],
                'qrcode_url' => $result['result']['qrcode_url'],
                'address' => $result['result']['address']
            ];
        } else {
            return $result['error'];
        }
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
