<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション
use Cake\Auth\DefaultPasswordHasher;//

use App\myClass\Rolecheck\htmlRolecheck;

class HazaimaterialsController extends AppController {

  public function initialize()
  {
   parent::initialize();
   $this->Staffs = TableRegistry::get('staffs');
   $this->Users = TableRegistry::get('users');
   $this->StatusRoles = TableRegistry::get('statusRoles');
   $this->Products = TableRegistry::get('products');
   $this->NonKadouSeikeis = TableRegistry::get('nonKadouSeikeis');
   $this->OutsourceHandys = TableRegistry::get('outsourceHandys');//productsテーブルを使う
  }

   public function menu()
   {
     $user = $this->Users->newEntity();
     $this->set('user',$user);
   }

}
