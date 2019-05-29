<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "referrals_promocode".
 *
 * @property int $id
 * @property int $user_id
 * @property string $promocode
 * @property string $created_at
 * @property string $updated_at
 */
class ReferralsPromocode extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'referrals_promocode';
    }
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => TimestampBehavior::className(),
//                'createdAtAttribute' => 'created_at',
//                'updatedAtAttribute' => 'updated_at',
                'value' => function () {
                    return date('Y-m-d h:m:s');
                },
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'promocode'], 'required'],
            [['user_id'], 'integer'],
            [['promocode'], 'string', 'max' => 155],
            [['promocode'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'promocode' => 'Promocode',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }


    static public function haveReferral($promocode_id){
        if (!($referral_user = User::findOne(['promocode_id'=>$promocode_id]) )) {
            return false;
        }
        return true;
    }
    static public function findReferralId($promocode_id){
        if (!($refferal_promocode = ReferralsPromocode::findOne(['id'=>$promocode_id]) )) {
            return false;
        }
        return $refferal_promocode->user_id;
    }
}
