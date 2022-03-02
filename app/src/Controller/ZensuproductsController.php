<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use App\myClass\Logins\htmlLogin;
use App\myClass\Rolecheck\htmlRolecheck;

class ZensuproductsController extends AppController {

  public function initialize()
  {
   parent::initialize();
   $this->StatusRoles = TableRegistry::get('statusRoles');
   $this->Staffs = TableRegistry::get('staffs');
   $this->Users = TableRegistry::get('users');
   $this->ZensuProducts = TableRegistry::get('zensuProducts');
  }

  public function preadd()
  {
    $zensuProducts = $this->ZensuProducts->newEntity();
    $this->set('zensuProducts',$zensuProducts);

    $Data=$this->request->query('s');
    if(isset($Data["mess"])){
      $mess = $Data["mess"];
      $this->set('mess',$mess);
    }else{
      $mess = "";
      $this->set('mess',$mess);
    }
  }

  public function login()
  {
    if ($this->request->is('post')) {
      $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける

      $userdata = $data['username'];

      if(isset($data['prelogin'])){

        $htmllogin = new htmlLogin();
        $qrcheck = $htmllogin->qrcheckprogram($userdata);

        if($qrcheck > 0){
          return $this->redirect(['action' => 'preadd',
          's' => ['mess' => "QRコードを読み込んでください。"]]);
        }

      }

      $htmllogin = new htmlLogin();
      $arraylogindate = $htmllogin->htmlloginprogram($userdata);

      $username = $arraylogindate[0];
      $delete_flag = $arraylogindate[1];
      $this->set('username',$username);
      $this->set('delete_flag',$delete_flag);

      $Users = $this->Users->find()
      ->where(['username' => $username])->toArray();
      if(isset($Users[0])){
        $StatusRolesData = $this->StatusRoles->find()->where(['staff_id' => $Users[0]["staff_id"], 'role_id <=' => 3, 'delete_flag' => 0])->toArray();

        if(!isset($StatusRolesData[0])){

          return $this->redirect(['action' => 'preadd',
          's' => ['mess' => "製品登録の権限がありません。"]]);

        }

      }

      $user = $this->Auth->identify();

      if ($user) {
        $this->Auth->setUser($user);

        $userData = $this->Users->find()->where(['username' => $username])->toArray();
        $staffData = $this->Staffs->find()->where(['id' => $userData[0]->staff_id])->toArray();
        $Staff = $staffData[0]->f_name.$staffData[0]->l_name;
        if(!isset($_SESSION)){
        session_start();
        }
        $_SESSION['login'] = array(
          'staff_id' => $userData[0]->staff_id,
          'username' => $username,
          'staffname' => $Staff
        );

        return $this->redirect(['action' => 'menu']);
      }
    }
  }

  public function menu()
  {
    $zensuProducts = $this->ZensuProducts->newEntity();
    $this->set('zensuProducts',$zensuProducts);
  }


}
