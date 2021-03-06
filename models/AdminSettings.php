<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "admin_settings".
 *
 * @property int $id
 * @property string $name
 * @property string $value
 */
class AdminSettings extends \yii\db\ActiveRecord
{
//    const MinWithdraw = 13;
    const MinWithdrawBTC = 18;
    const MaxWithdrawBTC = 19;
    const MinWithdrawETH = 24;
    const MaxWithdrawETH = 25;
    const MinWithdrawUSDT = 22;
    const MaxWithdrawUSDT = 23;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'value'], 'required'],
            [['id'], 'integer'],
            [['name', 'value'], 'string'],
            [['name'], 'unique'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'value' => 'Value',
        ];
    }
}
