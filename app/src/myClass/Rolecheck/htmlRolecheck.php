<?php
namespace App\myClass\Rolecheck;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

class htmlRolecheck extends AppController
{
     public function initialize()
    {
        parent::initialize();
        $this->Staffs = TableRegistry::get('staffs');
        $this->StatusRoles = TableRegistry::get('statusRoles');
    }
/*
    public function Rolecheckold($staff_id)//アカウント画面のログイン
   {
     $StatusRoles = $this->StatusRoles->find()->where(['staff_id' => $staff_id,
     'OR' => [['role_id' => 1], ['role_id' => 2]]])->toArray();

     if(count($StatusRoles) == 0){
       $roleCheck = 1;
     }else{
       $roleCheck = 2;
     }

     return $roleCheck;
   }
*/
   public function Rolecheck($staff_id)//アカウント画面のログイン
  {
    $staffData = $this->Staffs->find()->where(['id' => $staff_id])->toArray();
    $role = $staffData[0]->role_id;

    if($role < 3){//権限がある場合
      $roleCheck = 2;
    }else{//権限がない場合
      $roleCheck = 1;
    }

    return $roleCheck;
  }

}

?>
