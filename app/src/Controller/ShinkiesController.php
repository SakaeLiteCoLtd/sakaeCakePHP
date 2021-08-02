<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション
use Cake\Auth\DefaultPasswordHasher;//

use App\myClass\Rolecheck\htmlRolecheck;

class ShinkiesController extends AppController {

  public function initialize()
  {
   parent::initialize();
   $this->Staffs = TableRegistry::get('staffs');
   $this->Users = TableRegistry::get('users');
   $this->StatusRoles = TableRegistry::get('statusRoles');
   $this->Materials = TableRegistry::get('materials');
   $this->PriceMaterials = TableRegistry::get('priceMaterials');
   $this->Suppliers = TableRegistry::get('suppliers');
   $this->AssembleProducts = TableRegistry::get('assembleProducts');
   $this->Products = TableRegistry::get('products');
   $this->OutsourceHandys = TableRegistry::get('outsourceHandys');
   $this->ProductSuppliers = TableRegistry::get('productSuppliers');
   $this->AccountUrikakePriceMaterials = TableRegistry::get('accountUrikakePriceMaterials');
   $this->DeliverCompanies = TableRegistry::get('deliverCompanies');
   $this->ProductGaityus = TableRegistry::get('productGaityus');
   $this->UnitOrderToSuppliers = TableRegistry::get('unitOrderToSuppliers');
   $this->SyoumouSuppliers = TableRegistry::get('syoumouSuppliers');
   $this->ProductChokusous = TableRegistry::get('productChokusous');
   $this->PlaceDelivers = TableRegistry::get('placeDelivers');
   $this->Customers = TableRegistry::get('customers');
   $this->CustomersHandys = TableRegistry::get('customersHandys');
   $this->ZensuProducts = TableRegistry::get('zensuProducts');
  }

  public function index()
  {
 //  $this->request->session()->destroy(); // セッションの破棄
   $user = $this->Users->newEntity();
   $this->set('user',$user);

   $session = $this->request->getSession();
   $data = $session->read();
   $session->delete("login");//ログインしたデータを削除

  }

   public function login()
   {
     if ($this->request->is('post')) {
       $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける

       $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
       $str = implode(',', $data);//preadd.ctpで入力したデータをカンマ区切りの文字列にする
       $ary = explode(',', $str);//$strを配列に変換
       $username = $ary[0];//入力したデータをカンマ区切りの最初のデータを$usernameとする

       $userData = $this->Users->find()->where(['username' => $username])->toArray();
       if(isset($userData[0])){
         $staff = $userData[0]->staff_id;
    //     $StatusRolesData = $this->StatusRoles->find()->where(['staff_id' => $staff])->toArray();
         $staffData = $this->Staffs->find()->where(['id' => $staff])->toArray();
         $role = $staffData[0]->role_id;
       }else{
         $role = 4;
       }

       if(isset($staffData[0]) && $role < 4){
         $pass = $userData[0]->password;
         $hasher = new DefaultPasswordHasher();
         if($hasher->check($data['password'], $pass)){
           $passCheck = 1;

           session_start();
           $staffData = $this->Staffs->find()->where(['id' => $userData[0]->staff_id])->toArray();
           $Staff = $staffData[0]->f_name.$staffData[0]->l_name;
           $_SESSION['login'] = array(
             'staff_id' => $userData[0]->staff_id,
             'username' => $username,
             'staffname' => $Staff
           );

         }else{
           $passCheck = 2;
         }
       }else{
         $passCheck = 3;
       }
       $this->set('passCheck',$passCheck);

     }

   }

   public function menu()
   {
    $user = $this->Users->newEntity();
    $this->set('user',$user);

    $session = $this->request->getSession();
    $data = $session->read();
   }

   public function materialsform()//原料
   {
     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $staff_id = $sessionData['login']['staff_id'];
     $htmlRolecheck = new htmlRolecheck();//クラスを使用
     $roleCheck = $htmlRolecheck->Rolecheck($staff_id);
     $this->set('roleCheck',$roleCheck);

     $priceMaterials = $this->PriceMaterials->newEntity();
     $this->set('priceMaterials',$priceMaterials);

     $arrSuppliers = $this->Suppliers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['id' => 'ASC']);
     $arrSupplier = array();
     foreach ($arrSuppliers as $value) {
       $arrSupplier[] = array($value->id=>$value->name);
     }
     $this->set('arrSupplier',$arrSupplier);

     $arrstatus_buying = [
       '0' => 'ナチュラル・練りこみ',
       '1' => 'MB・ドライカラー自社混合'
     ];
     $this->set('arrstatus_buying',$arrstatus_buying);

   }

   public function materialsconfirm()
   {
     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $priceMaterials = $this->PriceMaterials->newEntity();
     $this->set('priceMaterials',$priceMaterials);

     $data = $this->request->getData();
/*
     echo "<pre>";
     print_r($data);
     echo "</pre>";
*/
     $Suppliers = $this->Suppliers->find()->where(['id' => $data['sup_id']])->toArray();
     $Suppliername = $Suppliers[0]->name;
     $this->set('Suppliername',$Suppliername);

     if($data['status_buying'] == 0){
       $hyouji_status_buying = "ナチュラル・練りこみ";
     }else{
       $hyouji_status_buying = "MB・ドライカラー自社混合";
     }
     $this->set('hyouji_status_buying',$hyouji_status_buying);

   }

   public function materialsdo()
   {
     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $priceMaterials = $this->PriceMaterials->newEntity();
     $this->set('priceMaterials',$priceMaterials);

     $data = $this->request->getData();

     $arrtouroku = array();
     $arrtouroku[] = array(
       'grade' => $data['grade'],
       'color' => $data['color'],
       'status_buying' => $data['status_buying'],
       'lot_low' => $data['lot_low'],
       'lot_upper' => $data['lot_upper'],
       'tourokubi' => date('Y-m-d'),
       'price' => $data['price'],
       'sup_id' => $data['sup_id'],
       'delete_flag' => 0,
       'created_staff' => $sessionData['login']['staff_id'],
       'created_at' => date('Y-m-d H:i:s')
     );
/*
     echo "<pre>";
     print_r($arrtouroku[0]);
     echo "</pre>";
*/
     $PriceMaterials = $this->PriceMaterials->patchEntity($this->PriceMaterials->newEntity(), $arrtouroku[0]);
     $connection = ConnectionManager::get('default');//トランザクション1
     // トランザクション開始2
     $connection->begin();//トランザクション3
     try {//トランザクション4

       //既に登録されている場合はdeleteする
       $deletePriceMaterials = $this->PriceMaterials->find('all')
       ->where(['grade' => $arrtouroku[0]["grade"], 'color' => $arrtouroku[0]["color"], 'delete_flag' => 0])->toArray();
       if(isset($deletePriceMaterials[0])){

         $this->PriceMaterials->updateAll(
           ['delete_flag' => 1, 'updated_staff' => $arrtouroku[0]["created_staff"], 'updated_at' => date('Y-m-d H:i:s')],
           ['grade' => $arrtouroku[0]["grade"], 'color' => $arrtouroku[0]["color"]]
         );

       }

       if ($this->PriceMaterials->save($PriceMaterials)) {

         //旧DBに製品登録
         $connection = ConnectionManager::get('sakaeMotoDB');
         $table = TableRegistry::get('price_material');
         $table->setConnection($connection);

         $connection->insert('price_material', [
             'grade' => $arrtouroku[0]["grade"],
             'color' => $arrtouroku[0]["color"],
             'lot_low' => $arrtouroku[0]["lot_low"],
             'lot_upper' => $arrtouroku[0]["lot_upper"],
             'tourokubi' => $arrtouroku[0]["tourokubi"],
             'price' => $arrtouroku[0]["price"],
             'sup_id' => $arrtouroku[0]["sup_id"],
             'delete_flg' => $arrtouroku[0]["delete_flag"],
             'emp_id' => $arrtouroku[0]["created_staff"]
         ]);

         $connection = ConnectionManager::get('default');//新DBに戻る
         $table->setConnection($connection);

         $mes = "※下記のように登録されました";
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

   public function materialsyobidashi()
   {
     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $priceMaterials = $this->PriceMaterials->newEntity();
     $this->set('priceMaterials',$priceMaterials);

     $data = $this->request->getData();

     $PriceMaterials = $this->PriceMaterials->find()
     ->where(['delete_flag' => 0])->order(["grade"=>"ASC"])->toArray();
     $this->set('PriceMaterials',$PriceMaterials);

   }

   public function supplierform()//原料仕入れ
   {
     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $staff_id = $sessionData['login']['staff_id'];
     $htmlRolecheck = new htmlRolecheck();//クラスを使用
     $roleCheck = $htmlRolecheck->Rolecheck($staff_id);
     $this->set('roleCheck',$roleCheck);

     $priceMaterials = $this->PriceMaterials->newEntity();
     $this->set('priceMaterials',$priceMaterials);

     $arrSuppliers = $this->Suppliers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['id' => 'ASC']);
     $arrSupplier = array();
     foreach ($arrSuppliers as $value) {
       $arrSupplier[] = array($value->id=>$value->name);
     }
     $this->set('arrSupplier',$arrSupplier);
   }

   public function supplierconfirm()
   {
     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $priceMaterials = $this->PriceMaterials->newEntity();
     $this->set('priceMaterials',$priceMaterials);

     $data = $this->request->getData();
/*
     echo "<pre>";
     print_r($data);
     echo "</pre>";
*/
   }

   public function supplierdo()
   {
     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $suppliers = $this->Suppliers->newEntity();
     $this->set('suppliers',$suppliers);

     $data = $this->request->getData();

     $Suppliers = $this->Suppliers->find()->toArray();
     $supplier_code = count($Suppliers) + 2;

     $arrtouroku = array();
     $arrtouroku[] = array(
       'name' => $data['name'],
       'supplier_section_id' => 1,
       'supplier_code' => $supplier_code,
       'address' => $data['address'],
       'tel' => $data['tel'],
       'fax' => $data['fax'],
       'charge_p' => $data['charge_p'],
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
     $Suppliers = $this->Suppliers->patchEntity($this->Suppliers->newEntity(), $arrtouroku[0]);
     $connection = ConnectionManager::get('default');//トランザクション1
     // トランザクション開始2
     $connection->begin();//トランザクション3
     try {//トランザクション4
       if ($this->Suppliers->save($Suppliers)) {

         //旧DBに製品登録
         $connection = ConnectionManager::get('sakaeMotoDB');
         $table = TableRegistry::get('supplier');
         $table->setConnection($connection);

         $connection->insert('supplier', [
             'sup_name' => $arrtouroku[0]["name"],
             'address' => $arrtouroku[0]["address"],
             'tel' => $arrtouroku[0]["tel"],
             'fax' => $arrtouroku[0]["fax"],
             'charge_p' => $arrtouroku[0]["charge_p"],
             'flag' => 0,
             'created' => date('Y-m-d H:i:s')
         ]);

         $connection = ConnectionManager::get('default');//新DBに戻る
         $table->setConnection($connection);

         $mes = "※下記のように登録されました";
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

   public function kumitateproductform()//組み立て
   {
     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $staff_id = $sessionData['login']['staff_id'];
     $htmlRolecheck = new htmlRolecheck();//クラスを使用
     $roleCheck = $htmlRolecheck->Rolecheck($staff_id);
     $this->set('roleCheck',$roleCheck);

     $assembleProducts = $this->AssembleProducts->newEntity();
     $this->set('assembleProducts',$assembleProducts);
   }

   public function kumitateform()
   {
     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $staff_id = $sessionData['login']['staff_id'];
     $htmlRolecheck = new htmlRolecheck();//クラスを使用
     $roleCheck = $htmlRolecheck->Rolecheck($staff_id);
     $this->set('roleCheck',$roleCheck);

     $assembleProducts = $this->AssembleProducts->newEntity();
     $this->set('assembleProducts',$assembleProducts);

     $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける

     $product_code = $data['product_code'];
     $this->set('product_code',$product_code);
     $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
     $product_name = $Product[0]->product_name;
     $this->set('product_name',$product_name);

   }

   public function kumitateformtuika()
   {
     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $staff_id = $sessionData['login']['staff_id'];
     $htmlRolecheck = new htmlRolecheck();//クラスを使用
     $roleCheck = $htmlRolecheck->Rolecheck($staff_id);
     $this->set('roleCheck',$roleCheck);

     $assembleProducts = $this->AssembleProducts->newEntity();
     $this->set('assembleProducts',$assembleProducts);

     $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける

     $product_code = $data['product_code'];
     $this->set('product_code',$product_code);
     $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
     $product_name = $Product[0]->product_name;
     $this->set('product_name',$product_name);

     if(isset($data['tuika'])){
       $tuika = $data['num'] + 1;
       $this->set('tuika',$tuika);
     }elseif(isset($data['sakujo'])){
       if($data['num'] == 0){
         $tuika = 0;
         $this->set('tuika',$tuika);
       }else{
         $tuika = $data['num'] - 1;
         $this->set('tuika',$tuika);
       }
     }elseif(isset($data['kakunin'])){
       $tuika = $data['num'];
       $this->set('tuika',$tuika);
       return $this->redirect(['action' => 'kumitateconfirm',//以下のデータを持ってzensufinishconfirmに移動
       's' => ['data' => $data]]);//登録するデータを全部配列に入れておく
     }

   }

   public function kumitateconfirm()
   {
     $assembleProducts = $this->AssembleProducts->newEntity();
     $this->set('assembleProducts',$assembleProducts);

     $Data = $this->request->query('s');
     $data = $Data['data'];//postデータ取得し、$dataと名前を付ける
     $this->set('data',$data);

     $product_code = $data['product_code'];
     $this->set('product_code',$product_code);
     $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
     $product_name = $Product[0]->product_name;
     $this->set('product_name',$product_name);
     $tuika = $data['num'];
     $this->set('tuika',$tuika);
/*
     echo "<pre>";
     print_r($data);
     echo "</pre>";
*/
   }

   public function kumitatedo()
   {
     $assembleProducts = $this->AssembleProducts->newEntity();
     $this->set('assembleProducts',$assembleProducts);

     $data = $this->request->getData();
     $this->set('data',$data);
/*
     echo "<pre>";
     print_r($data);
     echo "</pre>";
*/
     $product_code = $data['product_code'];
     $this->set('product_code',$product_code);
     $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
     $product_name = $Product[0]->product_name;
     $this->set('product_name',$product_name);
     $tuika = $data['num'];
     $this->set('tuika',$tuika);

     $arrtouroku = array();
     for($n=0; $n<=$tuika; $n++){
       $arrtouroku[$n] = array(
         'product_code' => $product_code,
         'child_pid' => $data["product{$n}"],
         'inzu' => $data["inzu{$n}"],
         "flag" => 0,
         "created" => date('Y-m-d H:i:s')
       );
      }
/*
     echo "<pre>";
     print_r($arrtouroku);
     echo "</pre>";
*/
      $assembleProducts = $this->AssembleProducts->patchEntities($assembleProducts, $arrtouroku);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
      $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
          if ($this->AssembleProducts->saveMany($assembleProducts)) {//saveManyで一括登録

            //insert 旧DB
            $connection = ConnectionManager::get('sakaeMotoDB');
            $table = TableRegistry::get('assemble_products');
            $table->setConnection($connection);

            for($k=0; $k<count($arrtouroku); $k++){
              $connection->insert('assemble_products', [
                'product_id' => $product_code,
                'child_pid' => $data["product{$k}"],
                'inzu' => $data["inzu{$k}"],
                "flag" => 0,
                "created" => date('Y-m-d H:i:s')
              ]);
            }

         $connection = ConnectionManager::get('default');//新DBに戻る
         $table->setConnection($connection);

         $mes = "※下記のように登録されました";
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

   public function kumitateyobidashi()
   {
     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $assembleProducts = $this->AssembleProducts->newEntity();
     $this->set('assembleProducts',$assembleProducts);

     $AssembleProducts = $this->AssembleProducts->find()
     ->where(['flag' => 0])->order(["product_code"=>"ASC"])->toArray();
     $this->set('AssembleProducts',$AssembleProducts);

   }

   public function nyusyukkoform()
   {
     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $staff_id = $sessionData['login']['staff_id'];
     $htmlRolecheck = new htmlRolecheck();//クラスを使用
     $roleCheck = $htmlRolecheck->Rolecheck($staff_id);
     $this->set('roleCheck',$roleCheck);

     $outsourceHandys = $this->OutsourceHandys->newEntity();
     $this->set('outsourceHandys',$outsourceHandys);

     $arrDenpyou = [
       '0' => '無',
       '1' => '有'
             ];
      $this->set('arrDenpyou',$arrDenpyou);
   }

   public function nyusyukkoconfirm()
   {
     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $outsourceHandys = $this->OutsourceHandys->newEntity();
     $this->set('outsourceHandys',$outsourceHandys);

     $data = $this->request->getData();
/*
     echo "<pre>";
     print_r($data);
     echo "</pre>";
*/
   }

   public function nyusyukkodo()
   {
     $session = $this->request->getSession();
     $sessionData = $session->read();

     $outsourceHandys = $this->OutsourceHandys->newEntity();
     $this->set('outsourceHandys',$outsourceHandys);
     $productSuppliers = $this->ProductSuppliers->newEntity();
     $this->set('productSuppliers',$productSuppliers);

     $data = $this->request->getData();
     $this->set('data',$data);
/*
     echo "<pre>";
     print_r($data);
     echo "</pre>";
*/
     $arrtourokuOutsourceHandys = array();
     $arrtourokuOutsourceHandys[] = array(
       'name' => $data["handy_name"],
       'flag' => $data["flag"]
     );
/*
      echo "<pre>";
      print_r($arrtourokuOutsourceHandys);
      echo "</pre>";
*/
     $OutsourceHandys = $this->OutsourceHandys->patchEntity($this->OutsourceHandys->newEntity(), $arrtourokuOutsourceHandys[0]);
     $connection = ConnectionManager::get('default');//トランザクション1
     // トランザクション開始2
     $connection->begin();//トランザクション3
     try {//トランザクション4
       if ($this->OutsourceHandys->save($OutsourceHandys)) {

         $OutsourceHandys = $this->OutsourceHandys->find()->where(['name' => $data["handy_name"]])->toArray();
         $handy_id = $OutsourceHandys[0]->id;

         $arrtourokuProductSuppliers = array();
         $arrtourokuProductSuppliers[] = array(
           'name' => $data["sup_name"],
           'address' => $data["address"],
           'handy_id' => $handy_id,
           'flag_denpyou' => $data["flag"],
           'delete_flag' => 0,
           'created_at' => date('Y-m-d H:i:s'),
           'created_staff' => $sessionData['login']['staff_id']
         );

         $ProductSuppliers = $this->ProductSuppliers->patchEntity($this->ProductSuppliers->newEntity(), $arrtourokuProductSuppliers[0]);
         $this->ProductSuppliers->save($ProductSuppliers);

         //旧DBに製品登録
         $connection = ConnectionManager::get('sakaeMotoDB');
         $table = TableRegistry::get('outsource_handy');
         $table->setConnection($connection);

         $connection->insert('outsource_handy', [
           'name' => $data["handy_name"],
           'flag' => $data["flag"]
         ]);

         $sql = "SELECT id FROM outsource_handy".
               " where name ='".$data["handy_name"]."'";
         $connection = ConnectionManager::get('sakaeMotoDB');
         $outsource_handy_id = $connection->execute($sql)->fetchAll('assoc');
         $handy_id_old = $outsource_handy_id[0]['id'];

         $connection->insert('product_supplier', [
           'name' => $data["sup_name"],
           'address' => $data["address"],
           'handy_id' => $handy_id_old,
           'flag' => 0,
           'flag_denpyou' => $data["flag"],
           'created' => date('Y-m-d H:i:s')
         ]);

         $connection = ConnectionManager::get('default');//新DBに戻る
         $table->setConnection($connection);

         $mes = "※下記のように登録されました";
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

   public function nyusyukkoyobidashi()
   {
     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $outsourceHandys = $this->OutsourceHandys->newEntity();
     $this->set('outsourceHandys',$outsourceHandys);
     $productSuppliers = $this->ProductSuppliers->newEntity();
     $this->set('productSuppliers',$productSuppliers);

     $ProductSuppliers = $this->ProductSuppliers->find()
     ->where(['delete_flag' => 0])->order(["id"=>"ASC"])->toArray();
     $this->set('ProductSuppliers',$ProductSuppliers);

   }

   public function menugaityu()
   {
     $user = $this->Users->newEntity();
     $this->set('user',$user);

     $session = $this->request->getSession();
     $data = $session->read();
   }

   public function gaityuurikakeform()
   {
     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $staff_id = $sessionData['login']['staff_id'];
     $htmlRolecheck = new htmlRolecheck();//クラスを使用
     $roleCheck = $htmlRolecheck->Rolecheck($staff_id);
     $this->set('roleCheck',$roleCheck);

     $accountUrikakePriceMaterials = $this->AccountUrikakePriceMaterials->newEntity();
     $this->set('accountUrikakePriceMaterials',$accountUrikakePriceMaterials);

     $arrCompanies = $this->DeliverCompanies->find('all', ['conditions' => ['customer_code >' => 0]])->order(['id' => 'ASC']);
     $arrCompany = array();
     foreach ($arrCompanies as $value) {
       $arrCompany[] = array($value->customer_code=>$value->company);
     }
     $this->set('arrCompany',$arrCompany);
   }

   public function gaityuurikakeconfirm()
   {
     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $accountUrikakePriceMaterials = $this->AccountUrikakePriceMaterials->newEntity();
     $this->set('accountUrikakePriceMaterials',$accountUrikakePriceMaterials);

     $data = $this->request->getData();
/*
     echo "<pre>";
     print_r($data);
     echo "</pre>";
*/
     $Companies = $this->DeliverCompanies->find('all', ['conditions' => ['customer_code' => $data['customer_code']]])->toArray();
     $company = $Companies[0]->company;
     $this->set('company',$company);

   }

   public function gaityuurikakedo()
   {
     $session = $this->request->getSession();
     $sessionData = $session->read();

     $accountUrikakePriceMaterials = $this->AccountUrikakePriceMaterials->newEntity();
     $this->set('accountUrikakePriceMaterials',$accountUrikakePriceMaterials);

     $data = $this->request->getData();
     $this->set('data',$data);

     $Companies = $this->DeliverCompanies->find('all', ['conditions' => ['customer_code' => $data['customer_code']]])->toArray();
     $company = $Companies[0]->company;
     $this->set('company',$company);

     $arrtouroku = array();
     $arrtouroku[] = array(
       'grade' => $data['grade'],
       'color' => $data['color'],
       'price' => $data['price'],
       'customer_code' => $data['customer_code'],
       'delete_flag' => 0,
       'created_staff' => $sessionData['login']['staff_id'],
       'created_at' => date('Y-m-d H:i:s')
     );
/*
     echo "<pre>";
     print_r($arrtouroku);
     echo "</pre>";
*/
     $AccountUrikakePriceMaterials = $this->AccountUrikakePriceMaterials->patchEntity($this->AccountUrikakePriceMaterials->newEntity(), $arrtouroku[0]);
     $connection = ConnectionManager::get('default');//トランザクション1
     // トランザクション開始2
     $connection->begin();//トランザクション3
     try {//トランザクション4
       if ($this->AccountUrikakePriceMaterials->save($AccountUrikakePriceMaterials)) {

         //旧DBに製品登録
         $connection = ConnectionManager::get('sakaeMotoDB');
         $table = TableRegistry::get('account_urikake_price_material');
         $table->setConnection($connection);

         $connection->insert('account_urikake_price_material', [
           'grade' => $data['grade'],
           'color' => $data['color'],
           'price' => $data['price'],
           'cs_id' => $data['customer_code'],
           'emp_id' => $sessionData['login']['staff_id'],
           'delete_flag' => 0,
           'created_at' => date('Y-m-d H:i:s')
         ]);

         $connection = ConnectionManager::get('default');//新DBに戻る
         $table->setConnection($connection);

         $mes = "※下記のように登録されました";
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

   public function gaityuseihinproduct()
   {
     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $staff_id = $sessionData['login']['staff_id'];
     $htmlRolecheck = new htmlRolecheck();//クラスを使用
     $roleCheck = $htmlRolecheck->Rolecheck($staff_id);
     $this->set('roleCheck',$roleCheck);

     $accountUrikakePriceMaterials = $this->AccountUrikakePriceMaterials->newEntity();
     $this->set('accountUrikakePriceMaterials',$accountUrikakePriceMaterials);
   }

   public function gaityuseihinform()
   {
     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $staff_id = $sessionData['login']['staff_id'];
     $htmlRolecheck = new htmlRolecheck();//クラスを使用
     $roleCheck = $htmlRolecheck->Rolecheck($staff_id);
     $this->set('roleCheck',$roleCheck);

     $accountUrikakePriceMaterials = $this->AccountUrikakePriceMaterials->newEntity();
     $this->set('accountUrikakePriceMaterials',$accountUrikakePriceMaterials);

     $data = $this->request->getData();
     $product_code = $data['product_code'];
     $this->set('product_code',$product_code);
     $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
     $product_name = $Product[0]->product_name;
     $this->set('product_name',$product_name);

     $ProductSuppliers = $this->ProductSuppliers->find()
     ->where(['delete_flag' => 0])->order(["id"=>"ASC"])->toArray();
     $arrSuppliers = array();
     foreach ($ProductSuppliers as $value) {
       $arrSuppliers[] = array($value->id=>$value->name);
     }
     $this->set('arrSuppliers',$arrSuppliers);
   }

   public function gaityuseihinconfirm()
   {
     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $accountUrikakePriceMaterials = $this->AccountUrikakePriceMaterials->newEntity();
     $this->set('accountUrikakePriceMaterials',$accountUrikakePriceMaterials);

     $data = $this->request->getData();
     $product_code = $data['product_code'];
     $this->set('product_code',$product_code);
     $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
     $product_name = $Product[0]->product_name;
     $this->set('product_name',$product_name);

     $product_supplier_id = $data['product_supplier_id'];
     $ProductSupplier = $this->ProductSuppliers->find()->where(['id' => $product_supplier_id])->toArray();
     $product_supplier_name = $ProductSupplier[0]->name;
     $this->set('product_supplier_name',$product_supplier_name);
/*
     echo "<pre>";
     print_r($data);
     echo "</pre>";
*/
   }

   public function gaityuseihindo()
   {
     $session = $this->request->getSession();
     $sessionData = $session->read();

     $productGaityus = $this->ProductGaityus->newEntity();
     $this->set('productGaityus',$productGaityus);
     $unitOrderToSuppliers = $this->UnitOrderToSuppliers->newEntity();
     $this->set('unitOrderToSuppliers',$unitOrderToSuppliers);

     $data = $this->request->getData();
     $product_code = $data['product_code'];
     $this->set('product_code',$product_code);
     $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
     $product_name = $Product[0]->product_name;
     $this->set('product_name',$product_name);

     $product_supplier_id = $data['product_supplier_id'];
     $ProductSupplier = $this->ProductSuppliers->find()->where(['id' => $product_supplier_id])->toArray();
     $product_supplier_name = $ProductSupplier[0]->name;
     $this->set('product_supplier_name',$product_supplier_name);

     $arrtourokuproductgaityu = array();
     $arrtourokuproductgaityu[] = array(
       'product_code' => $data['product_code'],
       'id_supplier' => $data['product_supplier_id'],
       'price_shiire' => $data['price'],
       'flag_denpyou' => 0,
       'status' => 0,
       'created_at' => date('Y-m-d H:i:s')
     );

     $arrtourokuunitordertosupplier = array();
     $arrtourokuunitordertosupplier[] = array(
       'id_supplier' => $data['product_supplier_id'],
       'product_code' => $data['product_code'],
       'unit_amount' => $data['unit'],
       'kijyun_stock' => 0,
       'delete_flag' => 0,
       'created_staff' => $sessionData['login']['staff_id'],
       'created_at' => date('Y-m-d H:i:s')
     );
/*
     echo "<pre>";
     print_r($arrtourokuproductgaityu);
     echo "</pre>";

     echo "<pre>";
     print_r($arrtourokuunitordertosupplier);
     echo "</pre>";
*/
     $ProductGaityus = $this->ProductGaityus->patchEntity($this->ProductGaityus->newEntity(), $arrtourokuproductgaityu[0]);
     $connection = ConnectionManager::get('default');//トランザクション1
     // トランザクション開始2
     $connection->begin();//トランザクション3
     try {//トランザクション4
       if ($this->ProductGaityus->save($ProductGaityus)) {

         $UnitOrderToSuppliers = $this->UnitOrderToSuppliers->patchEntity($this->UnitOrderToSuppliers->newEntity(), $arrtourokuunitordertosupplier[0]);
         $this->UnitOrderToSuppliers->save($UnitOrderToSuppliers);

         $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
         $product_id = $Product[0]->id;
         $this->Products->updateAll(
           ['gaityu' => 1, 'updated_staff' => $sessionData['login']['staff_id'], 'updated_at' => date('Y-m-d H:i:s')],
           ['id'  => $product_id]
         );

         //旧DBに製品登録
         $connection = ConnectionManager::get('sakaeMotoDB');
         $table = TableRegistry::get('product_gaityu');
         $table->setConnection($connection);

         $sql = "SELECT id FROM product_supplier".
               " where name ='".$product_supplier_name."'";
         $connection = ConnectionManager::get('sakaeMotoDB');
         $product_supplier_id = $connection->execute($sql)->fetchAll('assoc');
         $id_supplier_old = $product_supplier_id[0]['id'];

         $connection->insert('product_gaityu', [
           'product_id' => $data['product_code'],
           'id_supplier' => $id_supplier_old,
           'price_shiire' => $data['price'],
           'flag_denpyou' => 0,
           'flag' => 0,
           'created_at' => date('Y-m-d H:i:s')
         ]);

         $connection->insert('unit_order_to_supplier', [
           'product_id' => $data['product_code'],
           'id_supplier' => $id_supplier_old,
           'unit_amount' => $data['unit'],
           'kijyun_stock' => 0,
           'delete_flag' => 0,
           'created_emp_id' => $sessionData['login']['staff_id'],
           'created_at' => date('Y-m-d H:i:s')
         ]);

         $gaityu = 1;
         $updater = "UPDATE product set gaityu = '".$gaityu."', update_at = '".date('Y-m-d H:i:s')."'
           where product_id ='".$data['product_code']."'";//もとのDBも更新
         $connection->execute($updater);

         $connection = ConnectionManager::get('default');//新DBに戻る
         $table->setConnection($connection);

         $mes = "※下記のように登録されました";
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

   public function syoumouhinform()
   {
     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $staff_id = $sessionData['login']['staff_id'];
     $htmlRolecheck = new htmlRolecheck();//クラスを使用
     $roleCheck = $htmlRolecheck->Rolecheck($staff_id);
     $this->set('roleCheck',$roleCheck);

     $syoumouSuppliers = $this->SyoumouSuppliers->newEntity();
     $this->set('syoumouSuppliers',$syoumouSuppliers);

     $arrTax = [
       '0' => '税別',
       '1' => '税込'
             ];
      $this->set('arrTax',$arrTax);
   }

   public function syoumouhinconfirm()
   {
     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $syoumouSuppliers = $this->SyoumouSuppliers->newEntity();
     $this->set('syoumouSuppliers',$syoumouSuppliers);
   }

   public function syoumouhindo()
   {
     $session = $this->request->getSession();
     $sessionData = $session->read();

     $syoumouSuppliers = $this->SyoumouSuppliers->newEntity();
     $this->set('syoumouSuppliers',$syoumouSuppliers);

     $data = $this->request->getData();
     $this->set('data',$data);

     $arrtouroku = array();
     $arrtouroku[] = array(
       'name' => $data["name"],
       'furigana' => $data["furigana"],
       'tax_include' => $data["tax_include"],
       'delete_flag' => 0,
       'created_staff' => $sessionData['login']['staff_id'],
       'created_at' => date('Y-m-d H:i:s')
     );
/*
      echo "<pre>";
      print_r($arrtouroku);
      echo "</pre>";
*/
     $SyoumouSuppliers = $this->SyoumouSuppliers->patchEntity($this->SyoumouSuppliers->newEntity(), $arrtouroku[0]);
     $connection = ConnectionManager::get('default');//トランザクション1
     // トランザクション開始2
     $connection->begin();//トランザクション3
     try {//トランザクション4
       if ($this->SyoumouSuppliers->save($SyoumouSuppliers)) {

         //旧DBに製品登録
         $connection = ConnectionManager::get('sakaeMotoDB');
         $table = TableRegistry::get('syoumou_suppliers');
         $table->setConnection($connection);

         $connection->insert('syoumou_suppliers', [
           'name' => $data["name"],
           'furigana' => $data["furigana"],
           'tax_include' => $data["tax_include"],
           'delete_flag' => 0,
           'created_emp_id' => $sessionData['login']['staff_id'],
           'created_at' => date('Y-m-d H:i:s')
         ]);

         $connection = ConnectionManager::get('default');//新DBに戻る
         $table->setConnection($connection);

         $mes = "※下記のように登録されました";
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

   public function syoumouhinyobidashi()
   {
     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $syoumouSuppliers = $this->SyoumouSuppliers->newEntity();
     $this->set('syoumouSuppliers',$syoumouSuppliers);

     $SyoumouSuppliers = $this->SyoumouSuppliers->find()
     ->where(['delete_flag' => 0])->order(["furigana"=>"ASC"])->toArray();
     $this->set('SyoumouSuppliers',$SyoumouSuppliers);

   }

   public function menuchokusou()
   {
     $user = $this->Users->newEntity();
     $this->set('user',$user);

     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

   }

   public function chokusoubuhinmenu()
   {
     $user = $this->Users->newEntity();
     $this->set('user',$user);

     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $arrProductChokusous = $this->ProductChokusous->find()
     ->where(['delete_flag' => '0'])->order(["product_code"=>"ASC"])->toArray();
     $this->set('arrProductChokusous',$arrProductChokusous);

   }

   public function chokusoubuhinform()
   {
     $user = $this->Users->newEntity();
     $this->set('user',$user);

     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

   }

   public function chokusoubuhinconfirm()
   {
     $user = $this->Users->newEntity();
     $this->set('user',$user);

     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $data = $this->request->getData();

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

     $ProductChokusous = $this->ProductChokusous->find()->where(['product_code' => $product_code])->toArray();
     if(isset($ProductChokusous[0])){
       $product_name = "その品番は既に登録されています。";
       $product_table_check = 1;
     }

     $this->set('product_name',$product_name);
     $this->set('product_table_check',$product_table_check);

   }

   public function chokusoubuhindo()
   {
     $user = $this->Users->newEntity();
     $this->set('user',$user);

     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $data = $this->request->getData();

     $product_code = $data["product_code"];
     $this->set('product_code',$product_code);
     $product_name = $data["product_name"];
     $this->set('product_name',$product_name);

     $arrtouroku = array();
     $arrtouroku[] = array(
       'product_code' => $product_code,
       'status' => 0,
  //     'delete_flag' => 0,
       'created_staff' => $sessionData['login']['staff_id'],
       'created_at' => date('Y-m-d H:i:s')
     );
/*
     echo "<pre>";
     print_r($arrtouroku);
     echo "</pre>";
*/
     $ProductChokusous = $this->ProductChokusous->patchEntity($this->ProductChokusous->newEntity(), $arrtouroku[0]);
     $connection = ConnectionManager::get('default');//トランザクション1
     // トランザクション開始2
     $connection->begin();//トランザクション3
     try {//トランザクション4
       if ($this->ProductChokusous->save($ProductChokusous)) {
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

   public function chokusoubuhineditform()
   {
     $user = $this->Users->newEntity();
     $this->set('user',$user);

     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

   }

   public function chokusoubuhineditstatus()
   {
     $user = $this->Users->newEntity();
     $this->set('user',$user);

     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $data = $this->request->getData();

     $product_code = $data["product_code"];
     $this->set('product_code',$product_code);
     $status = 0;
     $ProductChokusous = $this->ProductChokusous->find()->where(['product_code' => $product_code])->toArray();
     if(isset($ProductChokusous[0])){
       $status = $ProductChokusous[0]->status;
       if($status == 1){
         $status_hyouji = "不使用";
       }else{
         $status_hyouji = "使用中";
       }
       $ProductChokusous_check = 0;
     }else{
       $status_hyouji = "その品番は直送部品登録されていません。";
       $ProductChokusous_check = 1;
     }
     $this->set('status',$status);
     $this->set('status_hyouji',$status_hyouji);
     $this->set('ProductChokusous_check',$ProductChokusous_check);

   }

   public function chokusoubuhineditdo()
   {
     $user = $this->Users->newEntity();
     $this->set('user',$user);

     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $data = $this->request->getData();
/*
     echo "<pre>";
     print_r($data);
     echo "</pre>";
*/
     $product_code = $data["product_code"];
     $this->set('product_code',$product_code);
     $status = $data["status"];
     if($status == 1){
       $status_hyouji = "不使用";
     }else{
       $status_hyouji = "使用中";
     }
     $this->set('status_hyouji',$status_hyouji);

     $ProductChokusou = $this->ProductChokusous->find()->where(['product_code' => $product_code])->toArray();
     $id = $ProductChokusou[0]->id;

     $ProductChokusous = $this->ProductChokusous->patchEntity($this->ProductChokusous->newEntity(), $data);
     $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        if ($this->ProductChokusous->updateAll(//検査終了時間の更新
          ['status' => $status, 'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $sessionData['login']['staff_id']],
          ['id'  => $id]
        )){

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

   public function chokusouikisakimenu()
   {
     $user = $this->Users->newEntity();
     $this->set('user',$user);

     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
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
       return $this->redirect(['action' => 'index']);
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
       return $this->redirect(['action' => 'index']);
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
       return $this->redirect(['action' => 'index']);
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
        $connection = ConnectionManager::get('sakaeMotoDB');
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
       return $this->redirect(['action' => 'index']);
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
          $connection = ConnectionManager::get('sakaeMotoDB');
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

//ここから追加
   public function materialeditkensaku()
  {
    $session = $this->request->getSession();
    $sessionData = $session->read();

    if(!isset($sessionData['login'])){
      return $this->redirect(['action' => 'index']);
    }

    $priceMaterials = $this->PriceMaterials->newEntity();
    $this->set('priceMaterials',$priceMaterials);

    $Data=$this->request->query('s');
    if(isset($Data["mess"])){
      $username = $Data["username"];
      $mess = $Data["mess"];
      $this->set('mess',$mess);
    }else{
      $data = $this->request->getData();
      $mess = "";
      $this->set('mess',$mess);
    }

    $Material_list = $this->PriceMaterials->find()
    ->where(['delete_flag' => 0])->toArray();
    $arrMaterial_list = array();
    for($j=0; $j<count($Material_list); $j++){
      array_push($arrMaterial_list,$Material_list[$j]["grade"]."_".$Material_list[$j]["color"]);
    }
    $arrMaterial_list = array_unique($arrMaterial_list);
    $arrMaterial_list = array_values($arrMaterial_list);
    $this->set('arrMaterial_list', $arrMaterial_list);

  }

  public function materialeditform()
 {
   $session = $this->request->getSession();
   $sessionData = $session->read();

   if(!isset($sessionData['login'])){
     return $this->redirect(['action' => 'index']);
   }

   $priceMaterials = $this->PriceMaterials->newEntity();
   $this->set('priceMaterials',$priceMaterials);

   $Data=$this->request->query('s');
   if(isset($Data["mess"])){
     $username = $Data["username"];
     $mess = $Data["mess"];
     $this->set('mess',$mess);
   }else{
     $data = $this->request->getData();
     $mess = "";
     $this->set('mess',$mess);
   }

   $data = $this->request->getData();
/*
   echo "<pre>";
   print_r($data);
   echo "</pre>";
*/
   $materialgrade_color = $data["materialgrade_color"];
   $this->set('materialgrade_color',$materialgrade_color);
   $arrhazai = explode('_', $materialgrade_color);
   $grade = $arrhazai[0];
   $this->set('grade',$grade);

   if(isset($arrhazai[1])){

     $color = $arrhazai[1];
     $this->set('color',$color);

   }else{

     return $this->redirect(['action' => 'materialeditkensaku',
     's' => ['mess' => "グレードと色を「_」（アンダーバー）でつないで入力してください。"]]);

   }

   $PriceMaterials = $this->PriceMaterials->find()
   ->where(['grade' => $grade, 'color' => $color, 'delete_flag' => 0])->toArray();

   if(isset($PriceMaterials[0])){

     $PriceMaterialId = $PriceMaterials[0]["id"];
     $this->set('PriceMaterialId',$PriceMaterialId);
     $price = $PriceMaterials[0]["price"];
     $this->set('price',$price);
     $sup_id = $PriceMaterials[0]["sup_id"];
     $this->set('sup_id',$sup_id);

   }else{

     return $this->redirect(['action' => 'materialeditkensaku',
     's' => ['mess' => "入力された原料は登録されていません。"]]);

   }

   $arrSuppliers = $this->Suppliers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['id' => 'ASC']);
   $arrSupplier = array();
   foreach ($arrSuppliers as $value) {
     $arrSupplier[] = array($value->id=>$value->name);
   }
   $this->set('arrSupplier',$arrSupplier);

   if(!isset($_SESSION)){
     session_start();
     header('Expires:-1');
     header('Cache-Control:');
     header('Pragma:');
   }

 }

   public function materialeditconfirm()
  {
    $session = $this->request->getSession();
    $sessionData = $session->read();

    if(!isset($sessionData['login'])){
      return $this->redirect(['action' => 'index']);
    }

    $priceMaterials = $this->PriceMaterials->newEntity();
    $this->set('priceMaterials',$priceMaterials);

    $Data=$this->request->query('s');
    if(isset($Data["mess"])){
      $username = $Data["username"];
      $mess = $Data["mess"];
      $this->set('mess',$mess);
    }else{
      $data = $this->request->getData();
      $mess = "";
      $this->set('mess',$mess);
    }

    $data = $this->request->getData();

    $PriceMaterialId = $data['PriceMaterialId'];
    $this->set('PriceMaterialId',$PriceMaterialId);
    $grade = $data['grade'];
    $this->set('grade',$grade);
    $color = $data['color'];
    $this->set('color',$color);
    $price = $data['price'];
    $this->set('price',$price);
    $sup_id = $data['sup_id'];
    $this->set('sup_id',$sup_id);

    $Suppliers = $this->Suppliers->find('all', ['conditions' => ['id' => $sup_id]])->toArray();
    $sup_name = $Suppliers[0]["name"];
    $this->set('sup_name',$sup_name);

    if($data["check"] > 0){

      $mess = "以下のデータを削除します。よろしければ「決定」ボタンを押してください。";
      $delete_flag = 1;

    }else{

      $mess = "以下のように更新します。よろしければ「決定」ボタンを押してください。";
      $delete_flag = 0;

    }
    $this->set('mess', $mess);
    $this->set('delete_flag', $delete_flag);

    if(!isset($_SESSION)){
      session_start();
      header('Expires:-1');
      header('Cache-Control:');
      header('Pragma:');
    }

  }

    public function materialeditdo()
   {
     $session = $this->request->getSession();
     $sessionData = $session->read();

     if(!isset($sessionData['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $priceMaterials = $this->PriceMaterials->newEntity();
     $this->set('priceMaterials',$priceMaterials);

     $data = $this->request->getData();
/*
     echo "<pre>";
     print_r($data);
     echo "</pre>";
*/
     $PriceMaterialId = $data['PriceMaterialId'];
     $this->set('PriceMaterialId',$PriceMaterialId);
     $grade = $data['grade'];
     $this->set('grade',$grade);
     $color = $data['color'];
     $this->set('color',$color);
     $price = $data['price'];
     $this->set('price',$price);
     $sup_id = $data['sup_id'];
     $this->set('sup_id',$sup_id);
     $sup_name = $data['sup_name'];
     $this->set('sup_name',$sup_name);

     if(!isset($_SESSION)){
       session_start();
       header('Expires:-1');
       header('Cache-Control:');
       header('Pragma:');
     }

     $PriceMaterials = $this->PriceMaterials->patchEntity($this->PriceMaterials->newEntity(), $data);
     $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4

        if($data["delete_flag"] > 0){

          if ($this->PriceMaterials->updateAll(
            ['delete_flag' => 1, 'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $sessionData['login']['staff_id']],
            ['id'  => $PriceMaterialId]
          )){

            $mes = "※削除されました";
            $this->set('mes',$mes);
            $connection->commit();// コミット5

          } else {

            $mes = "※削除されませんでした";
            $this->set('mes',$mes);
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
            throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6

          }

        }else{

          $PriceMaterialsMoto = $this->PriceMaterials->find('all', ['conditions' => ['id' => $PriceMaterialId]])->toArray();

          $tourokunewpricematerials = [
            'grade' => $PriceMaterialsMoto[0]['grade'],
            'color' => $PriceMaterialsMoto[0]['color'],
            'tourokubi' => $PriceMaterialsMoto[0]['tourokubi']->format('Y-m-d'),
            'price' => $price,
            'material_type_id' =>$PriceMaterialsMoto[0]['material_type_id'],
            'status_buying' =>$PriceMaterialsMoto[0]['status_buying'],
            'tani' =>$PriceMaterialsMoto[0]['tani'],
            'lot_low' => $PriceMaterialsMoto[0]['lot_low'],
            'lot_upper' => $PriceMaterialsMoto[0]['lot_upper'],
            'sup_id' => $sup_id,
            'emp_id' => $PriceMaterialsMoto[0]['emp_id'],
            'delete_flag' => 0,
            'created_staff' => $PriceMaterialsMoto[0]['created_staff'],
            'created_at' => $PriceMaterialsMoto[0]['created_at']->format('Y-m-d H:i:s'),
          ];

          if ($this->PriceMaterials->updateAll(
            ['delete_flag' => 1, 'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $sessionData['login']['staff_id']],
            ['id'  => $PriceMaterialId]
          )){

            $PriceMaterials = $this->PriceMaterials->patchEntity($this->PriceMaterials->newEntity(), $tourokunewpricematerials);
            $this->PriceMaterials->save($PriceMaterials);

            $mes = "※更新されました";
            $this->set('mes',$mes);
            $connection->commit();// コミット5

          } else {

            $mes = "※更新されませんでした";
            $this->set('mes',$mes);
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
            throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6

          }

        }

      } catch (Exception $e) {//トランザクション7
      //ロールバック8
        $connection->rollback();//トランザクション9
      }//トランザクション10

   }

}
