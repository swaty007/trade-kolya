<?php

namespace app\models;

use yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "invest_pools".
 *
 * @property int $id
 * @property string $status
 * @property string $min_invest
 * @property string $min_size_invest
 * @property string $max_size_invest
 * @property string $invest_method
 * @property int $profit
 * @property string $name
 * @property string $description
 * @property int $diversification
 * @property string $date_start
 * @property string $date_end
 * @property string $src
 */
class InvestPools extends ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invest_pools';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'string'],
            [['min_invest','diversification'], 'number'],
            [['profit'], 'integer'],
            [['date_start', 'date_end'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['invest_method'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 255],
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
            'status' => 'Status',
            'min_invest' => 'Min Invest',
            'min_size_invest' => 'Min size Invest',
            'max_size_invest' => 'max size Invest',
            'invest_method' => 'Invest Method',
            'profit' => 'Profit',
            'name' => 'Name',
            'description' => 'Description',
            'diversification' => 'Diversification',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
        ];
    }
    static public function haveInvest($pool_id){
        $u_sums = UserPools::find()
            ->select('SUM(invest) AS invest, pool_id')
            ->where(['pool_id' => $pool_id])
            ->asArray()
            ->one();

        if((float)$u_sums['invest'] > 0) {
            return (float)$u_sums['invest'];
        } else {
            false;
        }
    }
    public function getComments()
    {
        return $this->hasMany(CommentsPools::className(), ['pool_id' => 'id']);
    }

//    public function getUsers()
//    {
//            return $this->hasMany(User::className(), ['id' => 'user_id'])
//                ->viaTable('comments_pools',['pool_id' => 'id'])->asArray();
//    }

}
