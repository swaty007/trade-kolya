<?php

namespace app\models;

use yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_pools".
 *
 * @property int $id
 * @property int $pool_id
 * @property int $user_id
 * @property double $invest
 * @property int $diversification
 * @property string $date
 * @property string $status
 */
class UserPools extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_pools';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pool_id', 'user_id'], 'integer'],
            [['invest','diversification'], 'number'],
            [['date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pool_id' => 'Pool ID',
            'user_id' => 'User ID',
            'diversification' => 'Diversification',
            'invest' => 'Invest',
            'date' => 'Date',
            'status' => 'Status',
        ];
    }
}
