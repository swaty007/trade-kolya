<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\UserMarketplace;
/**
 * Signup form
 */
class UserTaskForm extends Model {

    //public $user_marketplace_id;
    //public $marketplace_id;
    //public $name;
    //public $key;
    //public $secret;
    //public $order;
    
    
    
    public $user_task_id;
    public $user_id;
    public $user_marketplace_id;
    public $task;
    public $currency_id;
    public $count;
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_task_id', 'user_id', 'user_marketplace_id', 'currency_id'],'integer'],
            [['user_task_id', 'user_id', 'user_marketplace_id', 'currency_id'], 'default', 'value' => 0],
            //[['name', 'key', 'secret'], 'trim'],
            [['name', 'key', 'secret'], 'required', 'message' => 'Поля обязательны для заполнения'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    
    public function save($user_id){
        if (!$this->validate()) {
            return null;
        }
        //print_r($this->user_marketplace_id);
        //exit;
        if ($this->user_marketplace_id){
            $user_marketplace = UserMarketplace::findOne(['user_marketplace_id' => $this->user_marketplace_id, 'user_id' => $user_id]);
            if (!$user_marketplace){
                return null;
            }
        }else{
            $user_marketplace = new UserMarketplace();
            $user_marketplace->user_id = $user_id;
        }
        
        $user_marketplace->name = $this->name;
        $user_marketplace->marketplace_id = $this->marketplace_id;
        $user_marketplace->key = $this->key;
        $user_marketplace->secret = $this->secret;
        $user_marketplace->order = (int)$this->order;
        
        return $user_marketplace->save() ? $user_marketplace : null;                
        
    }
    
    public function signup() {

        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        return $user->save() ? $user : null;
    }

}
