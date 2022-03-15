<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use App\myClass\Logins\htmlLogin;
use App\myClass\Rolecheck\htmlRolecheck;
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

class ZensuproductsController extends AppController {

  public function initialize()
  {
   parent::initialize();
   $this->StatusRoles = TableRegistry::get('statusRoles');
   $this->Staffs = TableRegistry::get('staffs');
   $this->Users = TableRegistry::get('users');
   $this->ZensuProducts = TableRegistry::get('zensuProducts');
   $this->Products = TableRegistry::get('products');//productsテーブルを使う
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

  public function form()
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

     $session = $this->request->getSession();
     $sessiondata = $session->read();

     if(!isset($sessiondata['login']['staff_id'])){//セッションが切れていた場合
       return $this->redirect(['action' => 'preadd',
 			's' => ['mess' => "ログインしてください。"]]);
     }

     $staff_id = $sessiondata['login']['staff_id'];
     $this->set('staff_id',$staff_id);
  }

  public function formdetail()
  {
    $zensuProducts = $this->ZensuProducts->newEntity();
    $this->set('zensuProducts',$zensuProducts);

    $data = $this->request->getData();
    $Products = $this->Products->find()->where(['product_code' => $data["product_code"], 'delete_flag' => 0])->toArray();
    if(!isset($Products[0])){
      return $this->redirect(['action' => 'form',
      's' => ['mess' => "入力された品番はProductsテーブルに存在しません。"]]);
    }
    $product_code = $data["product_code"];
    $this->set('product_code',$product_code);

    $ZensuProducts = $this->ZensuProducts->find()->where(['product_code' => $data["product_code"], 'delete_flag' => 0])->toArray();
    if(!isset($ZensuProducts[0])){
      $tourokucheck = 0;
      $mess = "※詳細を入力してください。";
    }else{
      $tourokucheck = 1;
      $mess = "※下記の製品は既に全数検査製品に登録されています。";
    }
    $this->set('tourokucheck',$tourokucheck);
    $this->set('mess',$mess);

    $staff_id = $data['staff_id'];
    $this->set('staff_id',$staff_id);

    if(!isset($_SESSION)){
    session_start();
    }
    header('Expires:-1');//フォーム再送信の確認の予防
    header('Cache-Control:');
    header('Pragma:');

  }

  public function confirm()
  {
    $zensuProducts = $this->ZensuProducts->newEntity();
    $this->set('zensuProducts',$zensuProducts);

    $mess = "※下記の製品を全数検査製品に登録します。よろしければ追加ボタンを押してください。";
    $this->set('mess',$mess);

    $data = $this->request->getData();
    $product_code = $data["product_code"];
    $this->set('product_code',$product_code);
    $shot_cycle = $data["shot_cycle"];
    $this->set('shot_cycle',$shot_cycle);
    $kijyun = $data["kijyun"];
    $this->set('kijyun',$kijyun);
    $staff_id = $data['staff_id'];
    $this->set('staff_id',$staff_id);
  }

  public function do()
  {
    $zensuProducts = $this->ZensuProducts->newEntity();
    $this->set('zensuProducts',$zensuProducts);

    $data = $this->request->getData();
    $product_code = $data["product_code"];
    $this->set('product_code',$product_code);
    $shot_cycle = $data["shot_cycle"];
    $this->set('shot_cycle',$shot_cycle);
    $kijyun = $data["kijyun"];
    $this->set('kijyun',$kijyun);
    $staff_id = $data['staff_id'];

    $Staffs = $this->Staffs->find()
    ->where(['id' => $staff_id, 'delete_flag' => 0])->toArray();

    $newZensuProduct = [
      "product_code" => $product_code,
      "shot_cycle" => $shot_cycle,
      "kijyun" => $kijyun,
      "kariunyou" => 1,
      "status" => 1,
      "staff_code" => $Staffs[0]['staff_code'],
      "datetime_touroku" => date('Y-m-d H:i:s'),
      "delete_flag" => 0,
      "created_at" => date('Y-m-d H:i:s'),
      "created_staff" => $staff_id,
    ];

    $ZensuProducts = $this->ZensuProducts->patchEntity($zensuProducts, $newZensuProduct);
    $connection = ConnectionManager::get('default');
    $connection->begin();
     try {

       if ($this->ZensuProducts->save($ZensuProducts)) {

         //旧DBに登録
         $connection = ConnectionManager::get('sakaeMotoDB');
         $table = TableRegistry::get('zensu_product');
         $table->setConnection($connection);

         if(strlen($newZensuProduct["shot_cycle"]) > 0){//旧DBには空文字はnullとして登録しないといけない
           $shot_cycle = $newZensuProduct["shot_cycle"];
         }else{
           $shot_cycle = null;
         }

         if(strlen($newZensuProduct["kijyun"]) > 0){//旧DBには空文字はnullとして登録しないといけない
           $kijyun = $newZensuProduct["kijyun"];
         }else{
           $kijyun = null;
         }

         $connection->insert('zensu_product', [
           'product_id' => $newZensuProduct["product_code"],
           'shot_cycle' => $shot_cycle,
           'kijyun' => $kijyun,
           'status' => $newZensuProduct["status"],
           'emp_id' => $newZensuProduct["staff_code"],
           'datetime_touroku' => $newZensuProduct["datetime_touroku"],
         ]);

         $connection = ConnectionManager::get('default');//新DBに戻る

         $mess = "※下記のように登録されました";
         $this->set('mess',$mess);
         $connection->commit();

   			} else {

   				$mess = "※登録されませんでした";
   				$this->set('mess',$mess);
   				$this->Flash->error(__('The supplier could not be saved. Please, try again.'));
   				throw new Exception(Configure::read("M.ERROR.INVALID"));

   			}

      } catch (Exception $e) {

        $connection->rollback();

      }

  }

}
