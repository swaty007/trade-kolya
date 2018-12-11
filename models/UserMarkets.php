<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_markets".
 *
 * @property int $id
 * @property int $user_id
 * @property int $market_id
 * @property int $count_api
 * @property int $count_api_full
 * @property int $time_action
 * @property string $date_create
 * @property string $date_update
 */
class UserMarkets extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_markets';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'market_id', 'count_api', 'count_api_full', 'time_action'], 'integer'],
            [['date_create', 'date_update'], 'safe'],
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
            'market_id' => 'Market ID',
            'count_api' => 'Count Api',
            'time_action' => 'Time Action',
            'date_create' => 'Date Create',
            'date_update' => 'Date Update',
        ];
    }

    public function getMarket()
    {
        return $this->hasOne(Markets::className(), ['id' => 'market_id']);
    }
}
