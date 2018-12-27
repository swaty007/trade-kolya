<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_marketplace_buy".
 *
 * @property int $user_id
 * @property int $user_marketplace_id
 *
 * @property User $user
 * @property UserMarketplace $userMarketplace
 */
class UserMarketplaceBuy extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_marketplace_buy';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'user_marketplace_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['user_marketplace_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserMarketplace::className(), 'targetAttribute' => ['user_marketplace_id' => 'user_marketplace_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'user_marketplace_id' => 'User Marketplace ID',
        ];

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserMarketplace()
    {
        return $this->hasMany(UserMarketplace::className(), ['user_marketplace_id' => 'user_marketplace_id']);
    }
}
