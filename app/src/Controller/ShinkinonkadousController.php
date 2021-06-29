<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション
use Cake\Auth\DefaultPasswordHasher;//

use App\myClass\Rolecheck\htmlRolecheck;

class ShinkinonkadousController extends AppController {

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

     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['controller' => 'shinkies', 'action' => 'index']);
     }

     $arrNonKadouSeikeis = $this->NonKadouSeikeis->find()
     ->where(['delete_flag' => '0'])->order(["product_code"=>"ASC"])->toArray();
     $this->set('arrNonKadouSeikeis',$arrNonKadouSeikeis);

   }

   public function addform()
   {
     $user = $this->Users->newEntity();
     $this->set('user',$user);

     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['controller' => 'shinkies', 'action' => 'index']);
     }

     $arrOutsourceHandys = $this->OutsourceHandys->find('all', ['conditions' => ['flag' => '0']])->order(['name' => 'ASC']);
     $arrOutsourceHandy = array();
     foreach ($arrOutsourceHandys as $value) {
       $arrOutsourceHandy[] = array($value->id=>$value->name);
     }
     $this->set('arrOutsourceHandy',$arrOutsourceHandy);

   }

   public function addconfirm()
   {
     $user = $this->Users->newEntity();
     $this->set('user',$user);

     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['controller' => 'shinkies', 'action' => 'index']);
     }

     $data = $this->request->getData();
/*
     echo "<pre>";
     print_r($data);
     echo "</pre>";
*/
     $product_code = $data["product_code"];
     $this->set('product_code',$product_code);

     $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
     if(isset($Product[0])){
       $product_name = $Product[0]->product_name;
       $product_table_check = 0;
     }else{
       $product_name = "その品番は製品登録されていません。";
       $product_table_check = 1;
     }
     $this->set('product_table_check',$product_table_check);
     $this->set('product_name',$product_name);

     $outsource_handy_id = $data["outsource_handy_id"];
     $this->set('outsource_handy_id',$outsource_handy_id);

     $OutsourceHandys = $this->OutsourceHandys->find()->where(['id' => $outsource_handy_id])->toArray();
     $outsource_handy_name = $OutsourceHandys[0]->name;
     $this->set('outsource_handy_name',$outsource_handy_name);

   }

   public function adddo()
   {
     $user = $this->Users->newEntity();
     $this->set('user',$user);

     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['controller' => 'shinkies', 'action' => 'index']);
     }

     $data = $this->request->getData();

     $product_code = $data["product_code"];
     $this->set('product_code',$product_code);
     $product_name = $data["product_name"];
     $this->set('product_name',$product_name);
     $outsource_handy_id = $data["outsource_handy_id"];
     $this->set('outsource_handy_id',$outsource_handy_id);

     $OutsourceHandys = $this->OutsourceHandys->find()->where(['id' => $outsource_handy_id])->toArray();
     $outsource_handy_name = $OutsourceHandys[0]->name;
     $this->set('outsource_handy_name',$outsource_handy_name);

     $arrtouroku = array();
     $arrtouroku[] = array(
       'outsource_handy_id' => $outsource_handy_id,
       'product_code' => $product_code,
       'status' => 0,
       'delete_flag' => 0,
       'created_staff' => $sessionData['login']['staff_id'],
       'created_at' => date('Y-m-d H:i:s')
     );
/*
     echo "<pre>";
     print_r($arrtouroku[0]);
     echo "</pre>";
*/
     $NonKadouSeikeis = $this->NonKadouSeikeis->patchEntity($this->NonKadouSeikeis->newEntity(), $arrtouroku[0]);
     $connection = ConnectionManager::get('default');//トランザクション1
     // トランザクション開始2
     $connection->begin();//トランザクション3
     try {//トランザクション4
       if ($this->NonKadouSeikeis->save($NonKadouSeikeis)) {
         $mes = "※登録されました";
         $this->set('mes',$mes);
         $connection->commit();// コミット5
       } else {
         $mes = "※登録されませんでした";
         $this->set('mes',$mes);
         $this->Flash->error(__('The data could not be saved. Please, try again.'));
         throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
       }
     } catch (Exception $e) {//トランザクション7
     //ロールバック8
       $connection->rollback();//トランザクション9
     }//トランザクション10

   }

   public function editformpre()
   {
     $user = $this->Users->newEntity();
     $this->set('user',$user);

     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['controller' => 'shinkies', 'action' => 'index']);
     }

   }

   public function editform()
   {
     $user = $this->Users->newEntity();
     $this->set('user',$user);

     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['controller' => 'shinkies', 'action' => 'index']);
     }

     $data = $this->request->getData();

     $product_code = $data["product_code"];
     $this->set('product_code',$product_code);

     $NonKadouSeikeis = $this->NonKadouSeikeis->find()->where(['product_code' => $product_code])->toArray();
     if(!isset($NonKadouSeikeis[0])){
       $mess = "入力された品番: ".$product_code." は検査外注製品に登録されていません。";
       $this->set('mess',$mess);
       $product_table_check = 1;
       $outsource_handy_id = 0;
     }else{
       $product_table_check = 0;
       $outsource_handy_id = $NonKadouSeikeis[0]["outsource_handy_id"];
       $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
       $product_name = $Product[0]["product_name"];
       $this->set('product_name',$product_name);
     }
     $this->set('outsource_handy_id',$outsource_handy_id);
     $this->set('product_table_check',$product_table_check);
/*
     echo "<pre>";
     print_r($product_table_check);
     echo "</pre>";
*/
     $arrOutsourceHandys = $this->OutsourceHandys->find('all', ['conditions' => ['flag' => '0']])->order(['name' => 'ASC']);
     $arrOutsourceHandy = array();
     foreach ($arrOutsourceHandys as $value) {
       $arrOutsourceHandy[] = array($value->id=>$value->name);
     }
     $this->set('arrOutsourceHandy',$arrOutsourceHandy);

   }

   public function editconfirm()
   {
     $user = $this->Users->newEntity();
     $this->set('user',$user);

     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['controller' => 'shinkies', 'action' => 'index']);
     }

     $data = $this->request->getData();
     $product_code = $data["product_code"];
     $this->set('product_code',$product_code);
     $product_name = $data["product_name"];
     $this->set('product_name',$product_name);
     $check = $data["check"];
     $this->set('check',$check);

     if($data["check"] > 0){
       $mess = "以下のデータを削除します。よろしければ決定ボタンを押してください。";

       $NonKadouSeikeis = $this->NonKadouSeikeis->find()->where(['product_code' => $product_code])->toArray();
       $outsource_handy_id = $NonKadouSeikeis[0]["outsource_handy_id"];
       $this->set('outsource_handy_id',$outsource_handy_id);
       $OutsourceHandys = $this->OutsourceHandys->find()->where(['id' => $outsource_handy_id])->toArray();
       $outsource_handy_name = $OutsourceHandys[0]->name;
       $this->set('outsource_handy_name',$outsource_handy_name);

     }else{
       $mess = "以下のように更新します。よろしければ決定ボタンを押してください。";

       $outsource_handy_id = $data["outsource_handy_id"];
       $this->set('outsource_handy_id',$outsource_handy_id);

       $OutsourceHandys = $this->OutsourceHandys->find()->where(['id' => $outsource_handy_id])->toArray();
       $outsource_handy_name = $OutsourceHandys[0]->name;
       $this->set('outsource_handy_name',$outsource_handy_name);
     }
     $this->set('mess',$mess);
     /*
     echo "<pre>";
     print_r($data);
     echo "</pre>";
*/
   }

   public function editdo()
   {
     $user = $this->Users->newEntity();
     $this->set('user',$user);

     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['controller' => 'shinkies', 'action' => 'index']);
     }

     $data = $this->request->getData();
     $product_code = $data["product_code"];
     $this->set('product_code',$product_code);
     $product_name = $data["product_name"];
     $this->set('product_name',$product_name);
     $check = $data["check"];
     $this->set('check',$check);
     $outsource_handy_id = $data["outsource_handy_id"];
     $this->set('outsource_handy_id',$outsource_handy_id);

     $OutsourceHandys = $this->OutsourceHandys->find()->where(['id' => $outsource_handy_id])->toArray();
     $outsource_handy_name = $OutsourceHandys[0]->name;
     $this->set('outsource_handy_name',$outsource_handy_name);
/*
     echo "<pre>";
     print_r($data);
     echo "</pre>";
*/
     $NonKadouSeikeis = $this->NonKadouSeikeis->patchEntity($this->NonKadouSeikeis->newEntity(), $data);
     $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        if ($this->NonKadouSeikeis->updateAll(//検査終了時間の更新
          ['outsource_handy_id' => $outsource_handy_id, 'delete_flag' => $check, 'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $sessionData['login']['staff_id']],
          ['product_code'  => $product_code, 'delete_flag' => 0]
        )){

          if($check > 0){
            $mes = "※以下のデータが削除されました";
            $this->set('mes',$mes);
          }else{
            $mes = "※以下のように更新されました";
            $this->set('mes',$mes);
          }
          $connection->commit();// コミット5

      } else {

        $mes = "※更新されませんでした";
        $this->set('mes',$mes);
        $this->Flash->error(__('The product could not be saved. Please, try again.'));
        throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6

      }

    } catch (Exception $e) {//トランザクション7
    //ロールバック8
      $connection->rollback();//トランザクション9
    }//トランザクション10

   }

   public function chokusouikisakimenu()
   {
     $user = $this->Users->newEntity();
     $this->set('user',$user);

     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['controller' => 'shinkies', 'action' => 'index']);
     }

     $arrPlaceDelivers = $this->PlaceDelivers->find()
     ->where(['delete_flag' => '0'])->order(["id_from_order"=>"ASC"])->toArray();
     $this->set('arrPlaceDelivers',$arrPlaceDelivers);

   }

   public function chokusouikisakiform()
   {
     $user = $this->Users->newEntity();
     $this->set('user',$user);

     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['controller' => 'shinkies', 'action' => 'index']);
     }

     $arrCustomers = $this->Customers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['customer_code' => 'ASC']);//Customersテーブルの'delete_flag' => '0'となるものを見つけ、customer_code順に並べる
     $arrCustomer = array();//配列の初期化
     foreach ($arrCustomers as $value) {//2行上のCustomersテーブルのデータそれぞれに対して
       $arrCustomer[] = array($value->id=>$value->customer_code.':'.$value->name);//配列に3行上のCustomersテーブルのデータそれぞれのcustomer_code:name
     }
     $this->set('arrCustomer',$arrCustomer);//4行上$arrCustomerをctpで使えるようにセット

   }

   public function chokusouikisakiconfirm()
   {
     $user = $this->Users->newEntity();
     $this->set('user',$user);

     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['controller' => 'shinkies', 'action' => 'index']);
     }

     $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける

     $customer_id = $data['customer'];
     $CustomersData = $this->Customers->find()->where(['id' => $customer_id])->toArray();
     $Customer = $CustomersData[0]->customer_code.":".$CustomersData[0]->name;
     $this->set('Customer',$Customer);

     $this->set('customer_id',$customer_id);
     $cs_code = $CustomersData[0]->customer_code;
     $this->set('cs_code',$cs_code);

   }

   public function chokusouikisakido()
   {
     $user = $this->Users->newEntity();
     $this->set('user',$user);

     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['controller' => 'shinkies', 'action' => 'index']);
       return $this->redirect(['controller' => 'shinkies', 'action' => 'index']);
     }

     $data = $this->request->getData();

     $customer_id = $data['customer_id'];
     $CustomersData = $this->Customers->find()->where(['id' => $customer_id])->toArray();
     $Customer = $CustomersData[0]->customer_code.":".$CustomersData[0]->name;
     $this->set('Customer',$Customer);

     $arrtouroku = array();
     $arrtouroku[] = array(
       'id_from_order' => $data["id_from_order"],
       'name' => $data["name"],
       'cs_code' => $data["cs_code"],
       'status' => 0,
       'created_staff' => $sessionData['login']['staff_id'],
       'created_at' => date('Y-m-d H:i:s')
     );

     $arrtourokuhandy = array();
     $arrtourokuhandy[] = array(
       'place_deliver_code' => $data["id_from_order"],
       'name' => $data["name"],
       'flag' => 0
     );

/*
     echo "<pre>";
     print_r($arrtouroku);
     echo "</pre>";
*/
     $PlaceDelivers = $this->PlaceDelivers->patchEntity($this->PlaceDelivers->newEntity(), $arrtouroku[0]);
     $connection = ConnectionManager::get('default');//トランザクション1
     // トランザクション開始2
     $connection->begin();//トランザクション3
     try {//トランザクション4
       if ($this->PlaceDelivers->save($PlaceDelivers)) {

         //customers_handys登録
         $CustomersHandys = $this->CustomersHandys->patchEntity($this->CustomersHandys->newEntity(), $arrtourokuhandy[0]);
         $this->CustomersHandys->save($CustomersHandys);

         //旧DBに登録
        $connection = ConnectionManager::get('DB_ikou_test');
        $table = TableRegistry::get('placedeliver');
        $table->setConnection($connection);

         $connection->insert('placedeliver', [
             'id_from_order' => $arrtouroku[0]["id_from_order"],
             'name' => $arrtouroku[0]["name"],
             'cs_id' => $arrtouroku[0]["cs_code"]
         ]);

         $connection->insert('customers_handy', [
             'place_deliver_id' => $arrtourokuhandy[0]["place_deliver_code"],
             'name' => $arrtourokuhandy[0]["name"],
             'flag' => $arrtourokuhandy[0]["flag"]
         ]);

         $connection = ConnectionManager::get('default');//新DBに戻る
         $table->setConnection($connection);

         $mes = "※登録されました";
         $this->set('mes',$mes);
         $connection->commit();// コミット5

       } else {
         $mes = "※登録されませんでした";
         $this->set('mes',$mes);
         $this->Flash->error(__('The data could not be saved. Please, try again.'));
         throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
       }
     } catch (Exception $e) {//トランザクション7
     //ロールバック8
       $connection->rollback();//トランザクション9
     }//トランザクション10

   }

   public function chokusouikisakieditform()
   {
     $user = $this->Users->newEntity();
     $this->set('user',$user);

     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['controller' => 'shinkies', 'action' => 'index']);
     }

     $arrPlaceDelivers = $this->PlaceDelivers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['id_from_order' => 'ASC']);
     $arrPlaceDeliver = array();//配列の初期化
     foreach ($arrPlaceDelivers as $value) {
       $arrPlaceDeliver[] = array($value->id=>$value->id_from_order.':'.$value->name);
     }
     $this->set('arrPlaceDeliver',$arrPlaceDeliver);

   }

   public function chokusouikisakieditformsyousai()
   {
     $user = $this->Users->newEntity();
     $this->set('user',$user);

     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $data = $this->request->getData();

     $PlaceDeliversid = $data['id'];
     $this->set('PlaceDeliversid',$PlaceDeliversid);
     $PlaceDeliversData = $this->PlaceDelivers->find()->where(['id' => $PlaceDeliversid])->toArray();
     $PlaceDelivers = $PlaceDeliversData[0]->id_from_order.":".$PlaceDeliversData[0]->name;
     $this->set('PlaceDelivers',$PlaceDelivers);
     $customer = $PlaceDeliversData[0]->id_from_order.":".$PlaceDeliversData[0]->name;
     $this->set('PlaceDelivers',$PlaceDelivers);
     $name = $PlaceDeliversData[0]->name;
     $this->set('name',$name);
     $id_from_order = $PlaceDeliversData[0]->id_from_order;
     $this->set('id_from_order',$id_from_order);
     $customer = $PlaceDeliversData[0]->cs_code;
     $this->set('customer',$customer);

     $CustomersHandysData = $this->CustomersHandys->find()->where(['place_deliver_code' => $PlaceDeliversData[0]->id_from_order])->toArray();
     if(isset($CustomersHandysData[0])){
       $CustomersHandysid = $CustomersHandysData[0]->id;
     }else{
       $CustomersHandysid = 0;
     }
     $this->set('CustomersHandysid',$CustomersHandysid);

     $arrCustomers = $this->Customers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['customer_code' => 'ASC'])->toArray();//Customersテーブルの'delete_flag' => '0'となるものを見つけ、customer_code順に並べる
     $arrCustomer = array();
       for ($k=0; $k<count($arrCustomers); $k++){
         $num = $arrCustomers[$k]["customer_code"];
         $arrCustomer[$num] =$arrCustomers[$k]["customer_code"].':'.$arrCustomers[$k]["name"];
       }
       $this->set('arrCustomer',$arrCustomer);//4行上$arrCustomerをctpで使えるようにセット

   }

   public function chokusouikisakieditconfirm()
   {
     $user = $this->Users->newEntity();
     $this->set('user',$user);

     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
/*
     echo "<pre>";
     print_r($data);
     echo "</pre>";
*/
     $cs_code = $data['cs_code'];
     $CustomersData = $this->Customers->find()->where(['customer_code' => $cs_code])->toArray();
     $Customer = $CustomersData[0]->customer_code.":".$CustomersData[0]->name;
     $this->set('Customer',$Customer);
     $this->set('cs_code',$cs_code);

     $status = $data['status'];
     if($status == 1){
       $status_hyouji = "不使用";
     }else{
       $status_hyouji = "使用";
     }
     $this->set('status_hyouji',$status_hyouji);

   }

   public function chokusouikisakieditdo()
   {
     $user = $this->Users->newEntity();
     $this->set('user',$user);

     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
/*
     echo "<pre>";
     print_r($data);
     echo "</pre>";
*/
     $cs_code = $data['cs_code'];
     $CustomersData = $this->Customers->find()->where(['customer_code' => $cs_code])->toArray();
     $Customer = $CustomersData[0]->customer_code.":".$CustomersData[0]->name;
     $this->set('Customer',$Customer);
     $this->set('cs_code',$cs_code);

     $status = $data['status'];
     if($status == 1){
       $status_hyouji = "不使用";
     }else{
       $status_hyouji = "使用";
     }
     $this->set('status_hyouji',$status_hyouji);

     $PlaceDeliversData = $this->PlaceDelivers->find()->where(['id' => $data["PlaceDeliversid"]])->toArray();
     $motoPlaceDeliver = $PlaceDeliversData[0]->id_from_order;

     $CustomersHandysData = $this->CustomersHandys->find()->where(['id' => $data["CustomersHandysid"]])->toArray();
     if(isset($CustomersHandysData[0])){
       $motoCustomersHandy = $CustomersHandysData[0]->place_deliver_code;
     }else{
       $motoCustomersHandy = 0;
     }

     $PlaceDelivers = $this->PlaceDelivers->patchEntity($this->PlaceDelivers->newEntity(), $data);
     $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        if ($this->PlaceDelivers->updateAll(//検査終了時間の更新
          ['id_from_order' => $data["id_from_order"], 'name' => $data["name"], 'cs_code' => $data["cs_code"], 'status' => $data["status"],
           'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $sessionData['login']['staff_id']],
          ['id'  => $data["PlaceDeliversid"]]
        )){

          $this->CustomersHandys->updateAll(
          ['place_deliver_code' => $data["id_from_order"], 'name' => $data["name"], 'flag' => $data["status"]],
          ['id'  => $data["CustomersHandysid"]]
          );

          //旧DBに単価登録
          $connection = ConnectionManager::get('DB_ikou_test');
          $table = TableRegistry::get('placedeliver');
          $table->setConnection($connection);

          $updater = "UPDATE placedeliver set id_from_order = '".$data["id_from_order"]."' , name ='".$data["name"]."'
          , cs_id = '".$data["cs_code"]."'
          where id_from_order ='".$motoPlaceDeliver."'";
          $connection->execute($updater);

          $updater = "UPDATE customers_handy set place_deliver_id = '".$data["id_from_order"]."' , name ='".$data["name"]."'
          , flag = '".$data["status"]."'
          where place_deliver_id ='".$motoCustomersHandy."'";
          $connection->execute($updater);

          $connection = ConnectionManager::get('default');//新DBに戻る
          $table->setConnection($connection);

        $mes = "※更新されました";
        $this->set('mes',$mes);
        $connection->commit();// コミット5

      } else {

        $mes = "※更新されませんでした";
        $this->set('mes',$mes);
        $this->Flash->error(__('The product could not be saved. Please, try again.'));
        throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6

      }

    } catch (Exception $e) {//トランザクション7
    //ロールバック8
      $connection->rollback();//トランザクション9
    }//トランザクション10

   }

   public function zensuproductform()
   {
     $user = $this->Users->newEntity();
     $this->set('user',$user);

     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }else{
       $staff_id = $sessionData['login']['staff_id'];
       $htmlRolecheck = new htmlRolecheck();//クラスを使用
       $roleCheck = $htmlRolecheck->Rolecheck($staff_id);//管理者なら「２」そうでなければ「１」
       $this->set('roleCheck',$roleCheck);
     }


/*
     echo "<pre>";
     print_r($roleCheck);
     echo "</pre>";
*/
   }

   public function zensuproductconfirm()
   {
     $user = $this->Users->newEntity();
     $this->set('user',$user);

     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $data = $this->request->getData();
     $ZensuProducts = $this->ZensuProducts->find()->where(['product_code' => $data["product_code"], 'delete_flag' => 0])->toArray();
     if(isset($ZensuProducts[0])){//存在するなら「２」そうでなければ「１」
       $tourokucheck = 2;

       if($ZensuProducts[0]->status == 1){
         $mes1 = "運用中（status = 1）";
         $this->set('mes1',$mes1);
         $mes2 = "不使用（status = 0）";
         $this->set('mes2',$mes2);
       }else{
         $mes1 = "不使用（status = 0）";
         $this->set('mes1',$mes1);
         $mes2 = "運用中（status = 1）";
         $this->set('mes2',$mes2);
       }

     }else{
       $tourokucheck = 1;
     }
     $this->set('tourokucheck',$tourokucheck);


   }

   public function zensuproductdo()
   {
     $user = $this->Users->newEntity();
     $this->set('user',$user);

     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $data = $this->request->getData();
     $ZensuProducts = $this->ZensuProducts->find()->where(['product_code' => $data["product_code"], 'delete_flag' => 0])->toArray();

     if($ZensuProducts[0]->status == 1){
       $mes = "不使用（status = 0）";
       $this->set('mes',$mes);
       $newstatus = 0;
     }else{
       $mes = "運用中（status = 1）";
       $this->set('mes',$mes);
       $newstatus = 1;
     }

     $ZensuProducts = $this->ZensuProducts->patchEntity($this->ZensuProducts->newEntity(), $data);
     $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        if ($this->ZensuProducts->updateAll(//検査終了時間の更新
          ['status' => $newstatus,
           'update_at' => date('Y-m-d H:i:s'), 'update_staff' => $sessionData['login']['staff_id']],
          ['product_code' => $data["product_code"], 'delete_flag' => 0]
        )){

          //旧DB
          $connection = ConnectionManager::get('sakaeMotoDB');
          $table = TableRegistry::get('zensu_product');
          $table->setConnection($connection);

          $updater = "UPDATE zensu_product set status = '".$newstatus."' , update_at ='".date('Y-m-d H:i:s')."'
          , update_staff = '".$sessionData['login']['staff_id']."'
          where product_id ='".$data["product_code"]."'";
          $connection->execute($updater);

          $connection = ConnectionManager::get('default');//新DBに戻る
          $table->setConnection($connection);

          $mess = "以下のように変更されました。";
          $this->set('mess',$mess);
          $connection->commit();// コミット5

      } else {

        $mess = "※更新されませんでした";
        $this->set('mess',$mess);
        $this->Flash->error(__('The product could not be saved. Please, try again.'));
        throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6

      }

    } catch (Exception $e) {//トランザクション7
    //ロールバック8
      $connection->rollback();//トランザクション9
    }//トランザクション10

   }


}
