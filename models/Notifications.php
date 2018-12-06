<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notifications".
 *
 * @property int $id
 * @property int $show
 * @property string $status
 * @property string $message
 * @property string $info
 * @property int $user_id
 * @property string $time
 *
 * @property User $user
 */
class Notifications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notifications';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['show', 'user_id'], 'integer'],
            [['status'], 'string'],
            [['message'], 'string', 'max' => 1024],
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
            'show' => 'Show',
            'status' => 'Status',
            'message' => 'Message',
            'user_id' => 'User ID',
            'time' => 'Time',
        ];
    }

    public function createNotification($id,$status,$msg,$info = "")
    {
        $this->user_id = $id;
        $this->status = $status;//'success','error','notification','info'
        $this->message = $msg;
        $this->info = json_encode($info);

        if ($this->save()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
