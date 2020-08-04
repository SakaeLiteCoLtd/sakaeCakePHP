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
  }

  public function index()
  {
   $this->request->session()->destroy(); // セッションの破棄
   $user = $this->Users->newEntity();
   $this->set('user',$user);
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
       if ($this->PriceMaterials->save($PriceMaterials)) {

         //旧DBに製品登録
         $connection = ConnectionManager::get('DB_ikou_test');
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
         $connection = ConnectionManager::get('DB_ikou_test');
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
            $connection = ConnectionManager::get('DB_ikou_test');
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
         $connection = ConnectionManager::get('DB_ikou_test');
         $table = TableRegistry::get('outsource_handy');
         $table->setConnection($connection);

         $connection->insert('outsource_handy', [
           'name' => $data["handy_name"],
           'flag' => $data["flag"]
         ]);

         $sql = "SELECT id FROM outsource_handy".
               " where name ='".$data["handy_name"]."'";
         $connection = ConnectionManager::get('DB_ikou_test');
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
         $connection = ConnectionManager::get('DB_ikou_test');
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
         $connection = ConnectionManager::get('DB_ikou_test');
         $table = TableRegistry::get('product_gaityu');
         $table->setConnection($connection);

         $sql = "SELECT id FROM product_supplier".
               " where name ='".$product_supplier_name."'";
         $connection = ConnectionManager::get('DB_ikou_test');
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
         $connection = ConnectionManager::get('DB_ikou_test');
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

}
