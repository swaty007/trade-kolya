<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comments_pools".
 *
 * @property int $id
 * @property int $user_id
 * @property int $pool_id
 * @property string $comment
 * @property string $date
 *
 * @property InvestPools $pool
 * @property User $user
 */
class CommentsPools extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments_pools';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'pool_id'], 'integer'],
            [['date'], 'safe'],
            [['comment'], 'string', 'max' => 480],
            [['pool_id'], 'exist', 'skipOnError' => true, 'targetClass' => InvestPools::className(), 'targetAttribute' => ['pool_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'pool_id' => 'Pool ID',
            'comment' => 'Comment',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPool()
    {
        return $this->hasOne(InvestPools::className(), ['id' => 'pool_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
