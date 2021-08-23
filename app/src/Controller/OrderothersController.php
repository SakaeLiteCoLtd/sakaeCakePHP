<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

use App\myClass\Logins\htmlLogin;//myClassフォルダに配置したクラスを使用

class OrderothersController extends AppController
{

    public function initialize()
    {
			parent::initialize();
			$this->Staffs = TableRegistry::get('staffs');
      $this->Customers = TableRegistry::get('customers');
      $this->Products = TableRegistry::get('products');
			$this->Users = TableRegistry::get('users');
      $this->OrderSpecials = TableRegistry::get('orderSpecials');
    }

    public function menu()
    {
      $OrderSpecials = $this->OrderSpecials->newEntity();
      $this->set('OrderSpecials',$OrderSpecials);
    }

    public function addpreadd()
    {
      $OrderSpecials = $this->OrderSpecials->newEntity();
      $this->set('OrderSpecials',$OrderSpecials);

      $Data=$this->request->query('s');
      if(isset($Data["mess"])){
        $mess = $Data["mess"];
        $this->set('mess',$mess);
      }else{
        $mess = "";
        $this->set('mess',$mess);
      }
    }

    public function addlogin()
    {
      if ($this->request->is('post')) {
        $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける

        $userdata = $data['username'];

        if(isset($data['prelogin'])){

          $htmllogin = new htmlLogin();
          $qrcheck = $htmllogin->qrcheckprogram($userdata);

          if($qrcheck > 0){
            return $this->redirect(['action' => 'materialpreadd',
            's' => ['mess' => "QRコードを読み込んでください。"]]);
          }

        }

        $htmllogin = new htmlLogin();
        $arraylogindate = $htmllogin->htmlloginprogram($userdata);

        $username = $arraylogindate[0];
        $delete_flag = $arraylogindate[1];
        $this->set('username',$username);
        $this->set('delete_flag',$delete_flag);

        $user = $this->Auth->identify();//$delete_flag = 0だとログインできない

        if ($user) {
          $this->Auth->setUser($user);
          return $this->redirect(['action' => 'addform']);
        }
      }
    }

    public function addform()
    {
      $OrderSpecials = $this->OrderSpecials->newEntity();
      $this->set('OrderSpecials',$OrderSpecials);

      $Customers = $this->Customers->find()
      ->where(['delete_flag' => 0])->toArray();
      $arrCustomers = array();//配列の初期化
      foreach ($Customers as $value) {
        $arrCustomers[] = array($value->customer_code => $value->name);
      }
      $this->set('arrCustomers',$arrCustomers);

      $arrElements = [
        "0"=>"",
        "kanagata"=>"金型",
        "shisaku"=>"試作",
        "genryou"=>"原料",
        "zumen"=>"図面",
        "sessakuhin"=>"切削品",
        "seihin"=>"製品",
        "yuusyouzai"=>"有償支給材",
        "sonota"=>"その他"
      ];
      $this->set('arrElements',$arrElements);
    }

    public function addconfirm()
    {
      $OrderSpecials = $this->OrderSpecials->newEntity();
      $this->set('OrderSpecials',$OrderSpecials);

      $data = $this->request->getData();
      /*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
      $date_order = $data["date_order"]["year"]."-".$data["date_order"]["month"]."-".$data["date_order"]["day"];
      $this->set('date_order',$date_order);
      $num_order = $data["num_order"];
      $this->set('num_order',$num_order);
      $cs_id = $data["cs_id"];
      $this->set('cs_id',$cs_id);
      $Customers = $this->Customers->find()->where(['customer_code' => $data["cs_id"]])->toArray();
      $cs_name = $Customers[0]->name;
      $this->set('cs_name',$cs_name);
      $order_name = $data["order_name"];
      $this->set('order_name',$order_name);
      $element_id = $data["element_id"];
      $this->set('element_id',$element_id);

      if($data["element_id"] == "0"){
        $element_name = "";
      }elseif($data["element_id"] == "kanagata"){
        $element_name = "金型";
      }elseif($data["element_id"] == "shisaku"){
        $element_name = "試作";
      }elseif($data["element_id"] == "genryou"){
        $element_name = "原料";
      }elseif($data["element_id"] == "zumen"){
        $element_name = "図面";
      }elseif($data["element_id"] == "sessakuhin"){
        $element_name = "切削品";
      }elseif($data["element_id"] == "seihin"){
        $element_name = "製品";
      }elseif($data["element_id"] == "yuusyouzai"){
        $element_name = "有償支給材";
      }elseif($data["element_id"] == "sonota"){
        $element_name = "その他";
      }
      $this->set('element_name',$element_name);
      $price = $data["price"];
      $this->set('price',$price);
      $amount = $data["amount"];
      $this->set('amount',$amount);
      $date_deliver = $data["date_deliver"]["year"]."-".$data["date_deliver"]["month"]."-".$data["date_deliver"]["day"];
      $this->set('date_deliver',$date_deliver);

    }

    public function adddo()
    {
      $OrderSpecials = $this->OrderSpecials->newEntity();
      $this->set('OrderSpecials',$OrderSpecials);

      if(!isset($_SESSION)){
      session_start();
      }
      $staff_id = $this->Auth->user('staff_id');
      $data = $this->request->getData();

      $date_order = $data["date_order"];
      $this->set('date_order',$date_order);
      $num_order = $data["num_order"];
      $this->set('num_order',$num_order);
      $cs_id = $data["cs_id"];
      $this->set('cs_id',$cs_id);
      $Customers = $this->Customers->find()->where(['customer_code' => $data["cs_id"]])->toArray();
      $cs_name = $Customers[0]->name;
      $this->set('cs_name',$cs_name);
      $order_name = $data["order_name"];
      $this->set('order_name',$order_name);
      $element_id = $data["element_id"];
      $this->set('element_id',$element_id);
      $element_name = $data["element_name"];
      $this->set('element_name',$element_name);
      $price = $data["price"];
      $this->set('price',$price);
      $amount = $data["amount"];
      $this->set('amount',$amount);
      $date_deliver = $data["date_deliver"];
      $this->set('date_deliver',$date_deliver);

      $order_name_save = $order_name."(".$element_id.")";

      $tourokuOrderSpecials = array();
      $tourokuOrderSpecials = [
        'date_order' => $date_order,
        'num_order' => $num_order,
        'order_name' => $order_name_save,
        'price' => $price,
        'amount' => $amount,
        'date_deliver' => $date_deliver,
        'cs_id' => $cs_id,
        'kannou' => 0,
        'delete_flag' => 0,
        'created_at' => date("Y-m-d H:i:s")
    //    'created_staff' => $staff_id
      ];
/*
      echo "<pre>";
      print_r($tourokuOrderSpecials);
      echo "</pre>";
*/
      $OrderSpecials = $this->OrderSpecials->patchEntity($this->OrderSpecials->newEntity(), $tourokuOrderSpecials);
      $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        if ($this->OrderSpecials->save($OrderSpecials)) {

          $connection = ConnectionManager::get('DB_ikou_test');
          $table = TableRegistry::get('order_special');
          $table->setConnection($connection);

          $connection->insert('order_special', [
            'date_order' => $date_order,
            'num_order' => $num_order,
            'order_name' => $order_name_save,
            'price' => $price,
            'amount' => $amount,
            'date_deliver' => $date_deliver,
            'cs_id' => $cs_id,
            'kannou' => 0,
            'delete_flag' => 0,
            'created_at' => date("Y-m-d H:i:s")
      //      'created_staff' => $staff_id
          ]);
          $connection = ConnectionManager::get('default');

          $mes = "※登録されました";
          $this->set('mes',$mes);
          $connection->commit();// コミット5

        } else {
          $this->Flash->error(__('The product could not be saved. Please, try again.'));
          throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
        }
      } catch (Exception $e) {//トランザクション7
      //ロールバック8
        $connection->rollback();//トランザクション9
      }//トランザクション10

    }

    public function kensakuform()
    {
      $OrderSpecials = $this->OrderSpecials->newEntity();
      $this->set('OrderSpecials',$OrderSpecials);

      $Customers = $this->Customers->find()
      ->where(['delete_flag' => 0])->toArray();
      $arrCustomers = array();//配列の初期化
      foreach ($Customers as $value) {
        $arrCustomers[] = array($value->customer_code => $value->name);
      }
      $this->set('arrCustomers',$arrCustomers);
    }

    public function kensakuichiran()
    {
      $OrderSpecials = $this->OrderSpecials->newEntity();
      $this->set('OrderSpecials',$OrderSpecials);

      $data = $this->request->getData();
      echo "<pre>";
      print_r($data);
      echo "</pre>";

      $date_sta = $data['date_sta']['year']."-".$data['date_sta']['month']."-".$data['date_sta']['day'];
      $date_fin = $data['date_fin']['year']."-".$data['date_fin']['month']."-".$data['date_fin']['day'];
      $cs_id = $data['cs_id'];

      $OrderSpecials = $this->OrderSpecials->find()
      ->where(['cs_id like' => '%'.$cs_id.'%', 'delete_flag' => '0', 'date_deliver >=' => $date_sta, 'date_deliver <=' => $date_fin])
      ->toArray();
      
      echo "<pre>";
      print_r($OrderSpecials);
      echo "</pre>";

    }

}
