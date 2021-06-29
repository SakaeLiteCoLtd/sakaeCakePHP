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

     $arrOutsourceHandys = $this->OutsourceHandys->find('all', ['conditions' => ['flag' => '0']])->order(['name' => 'ASC']);
     $arrOutsourceHandy = array();
     foreach ($arrOutsourceHandys as $value) {
       $arrOutsourceHandy[] = array($value->id=>$value->name);
     }
     $this->set('arrOutsourceHandy',$arrOutsourceHandy);

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
     $outsource_handy_id = $data["outsource_handy_id"];
     $this->set('outsource_handy_id',$outsource_handy_id);

     $OutsourceHandys = $this->OutsourceHandys->find()->where(['id' => $outsource_handy_id])->toArray();
     $outsource_handy_name = $OutsourceHandys[0]->name;
     $this->set('outsource_handy_name',$outsource_handy_name);

     $NonKadouSeikeis = $this->NonKadouSeikeis->find()
     ->where(['product_code' => $product_code, 'outsource_handy_id' => $outsource_handy_id, 'delete_flag' => 0])->toArray();
     if(!isset($NonKadouSeikeis[0])){
       $mess = "品番: ".$product_code." 仕入先： ".$outsource_handy_name."は検査外注製品に登録されていません。";
       $this->set('mess',$mess);
       $product_table_check = 1;
       $outsource_handy_id = 0;
     }else{
       $NonKadouSeikeisId = $NonKadouSeikeis[0]["id"];
       $this->set('NonKadouSeikeisId',$NonKadouSeikeisId);
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
     $NonKadouSeikeisId = $data["NonKadouSeikeisId"];
     $this->set('NonKadouSeikeisId',$NonKadouSeikeisId);
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
     $NonKadouSeikeisId = $data["NonKadouSeikeisId"];
     $this->set('NonKadouSeikeisId',$NonKadouSeikeisId);
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
          ['id'  => $NonKadouSeikeisId]
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

}
