<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Description of Marketplace
 * @property InformerCategory[] $informerCategories
 * @property UserMarketplaceBuy[] $marketplaceUser
 * @author Дмитрий
 */
class UserMarketplace extends ActiveRecord{
    //put your code here
    public static function tableName()
    {
        return 'user_marketplace';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getMarketplace()
    {
        return $this->hasOne(Marketplace::className(), ['marketplace_id' => 'marketplace_id']);
    }



    public function getMarketplaceUser()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])
            ->viaTable('user_marketplace_buy', ['user_marketplace_id' => 'user_marketplace_id']);
    }
}
