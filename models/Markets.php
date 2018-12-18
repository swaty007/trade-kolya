<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "markets".
 *
 * @property int $id
 * @property string $title
 * @property string $type
 * @property string $status
 * @property string $description
 * @property number $cost
 * @property int $time_action
 * @property int $count_api
 * @property string $date_create
 * @property string $date_update
 * @property string $src
 */
class Markets extends \yii\db\ActiveRecord
{

    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'markets';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'type', 'description', 'cost', 'time_action'], 'required'],
            [['id', 'time_action', 'count_api'], 'integer'],
            [['cost'], 'number'],
            [['type', 'description', 'status', 'title', 'src'], 'string'],
            [['date_create', 'date_update'], 'safe'],
            [['file'], 'file', 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'type' => 'Type',
            'status' => 'Status',
            'description' => 'Description',
            'cost' => 'Cost',
            'time_action' => 'Time Action',
            'date_create' => 'Date Create',
            'date_update' => 'Date Update',
        ];
    }

    static public function haveInvest($market_id)
    {
        if (UserMarkets::find()->where(['market_id' => $market_id])->count()) {
            return true;
        } else {
            false;
        }
    }
}
