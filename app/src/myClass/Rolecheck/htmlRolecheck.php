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
        $this->StatusRoles = TableRegistry::get('statusRoles');
    }

    public function Rolecheck($staff_id)
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

}

?>
