<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション
use Cake\Auth\DefaultPasswordHasher;//

use App\myClass\Rolecheck\htmlRolecheck;

class AccountsController extends AppController
{

     public function initialize()
     {
			parent::initialize();
			$this->Users = TableRegistry::get('users');
      $this->Staffs = TableRegistry::get('staffs');
      $this->Staffs = TableRegistry::get('staffs');
      $this->StatusRoles = TableRegistry::get('statusRoles');
      $this->Customers = TableRegistry::get('customers');
      $this->AccountUrikakeElements = TableRegistry::get('accountUrikakeElements');
      $this->AccountUrikakes = TableRegistry::get('accountUrikakes');
      $this->AccountUrikakeMaterials = TableRegistry::get('accountUrikakeMaterials');
      $this->ProductSuppliers = TableRegistry::get('productSuppliers');
      $this->AccountPriceProducts = TableRegistry::get('accountPriceProducts');
      $this->AccountKaikakeElements = TableRegistry::get('accountKaikakeElements');
      $this->AccountProductKaikakes = TableRegistry::get('accountProductKaikakes');
      $this->Suppliers = TableRegistry::get('suppliers');
      $this->AccountMaterialKaikakes = TableRegistry::get('accountMaterialKaikakes');
      $this->StockInoutWorklogs = TableRegistry::get('stockInoutWorklogs');
      $this->OutsourceHandys = TableRegistry::get('outsourceHandys');
      $this->OrderMaterials = TableRegistry::get('orderMaterials');
      $this->AccountYusyouzaiUkeires = TableRegistry::get('accountYusyouzaiUkeires');
      $this->AccountYusyouzaiMasters = TableRegistry::get('accountYusyouzaiMasters');
      $this->Products = TableRegistry::get('products');
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
/*
				echo "<pre>";
				print_r($data);
				echo "</pre>";
*/
				$username = $data['username'];
				$userData = $this->Users->find()->where(['username' => $username])->toArray();

				if(isset($userData[0])){
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
/*
		 echo "<pre>";
		 print_r($data);
		 echo "</pre>";
*/
		}

    public function urikakemenu()
		{
		 $user = $this->Users->newEntity();
		 $this->set('user',$user);
		}

    public function urikakeform()
		{
		 $user = $this->Users->newEntity();
		 $this->set('user',$user);

     $session = $this->request->getSession();
     $data = $session->read();

     if(!isset($data['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $staff_id = $data['login']['staff_id'];
     $htmlRolecheck = new htmlRolecheck();//クラスを使用
     $roleCheck = $htmlRolecheck->Rolecheck($staff_id);
     $this->set('roleCheck',$roleCheck);

     $arrCustomers = $this->Customers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['customer_code' => 'ASC']);
     $arrCustomer = array();
     foreach ($arrCustomers as $value) {
       $arrCustomer[] = array($value->id=>$value->customer_code.':'.$value->name);
     }
     $this->set('arrCustomer',$arrCustomer);//4行上$arrCustomerをctpで使えるようにセット

     $arrAccountUrikakeElements = $this->AccountUrikakeElements->find('all')->order(['id' => 'ASC']);
     $arrAccountUrikakeElement = array();
     foreach ($arrAccountUrikakeElements as $value) {
       $arrAccountUrikakeElement[] = array($value->id=>$value->element);
     }
     $this->set('arrAccountUrikakeElement',$arrAccountUrikakeElement);

		}

    public function urikakeconfirm()
		{
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $user = $this->Users->newEntity();
      $this->set('user',$user);

      $data = $this->request->getData();

      $CustomerData = $this->Customers->find()->where(['id' => $data['customer']])->toArray();
      $customer = $CustomerData[0]->name;
      $this->set('customer',$customer);

      $AccountUrikakeElementData = $this->AccountUrikakeElements->find()->where(['id' => $data['urikakeelement']])->toArray();
      $AccountUrikakeElement = $AccountUrikakeElementData[0]->element;
      $this->set('AccountUrikakeElement',$AccountUrikakeElement);

      $dateYMD = $data['date']['year']."-".$data['date']['month']."-".$data['date']['day'];
      $this->set('dateYMD',$dateYMD);

      $price = $data['price'];
      $this->set('price',$price);
		}

    public function urikakedo()
		{
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $user = $this->Users->newEntity();
      $this->set('user',$user);

      $data = $this->request->getData();

      $CustomerData = $this->Customers->find()->where(['id' => $data['customer']])->toArray();
      $customer = $CustomerData[0]->name;
      $this->set('customer',$customer);

      $AccountUrikakeElementData = $this->AccountUrikakeElements->find()->where(['id' => $data['urikakeelement']])->toArray();
      $AccountUrikakeElement = $AccountUrikakeElementData[0]->element;
      $this->set('AccountUrikakeElement',$AccountUrikakeElement);

      $dateYMD = $data['date'];
      $this->set('dateYMD',$dateYMD);

      $price = $data['price'];
      $this->set('price',$price);

      $arrtouroku = array();
      $arrtouroku[] = array(
        'customer_code' => $CustomerData[0]->customer_code,
        'urikake_element_id' => $data['urikakeelement'],
        'date' => $dateYMD,
        'kingaku' => $price,
        'delete_flag' => 0,
        'created_staff' => $sessionData['login']['staff_id'],
        'created_at' => date('Y-m-d H:i:s')
      );
/*
      echo "<pre>";
      print_r($arrtouroku[0]);
      echo "</pre>";
*/
      $AccountUrikakes = $this->AccountUrikakes->patchEntity($this->AccountUrikakes->newEntity(), $arrtouroku[0]);
      $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        if ($this->AccountUrikakes->save($AccountUrikakes)) {

          //旧DBに製品登録
          $connection = ConnectionManager::get('DB_ikou_test');
          $table = TableRegistry::get('account_urikake');
          $table->setConnection($connection);

          $connection->insert('account_urikake', [
              'cs_id' => $arrtouroku[0]["customer_code"],
              'kingaku' => $arrtouroku[0]["kingaku"],
              'date' => $arrtouroku[0]["date"],
              'urikake_element_id' => $arrtouroku[0]["urikake_element_id"],
              'delete_flag' => $arrtouroku[0]["delete_flag"],
              'emp_id' => $arrtouroku[0]["created_staff"],
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

    public function urikakekensakuform()
		{
		 $user = $this->Users->newEntity();
		 $this->set('user',$user);

     $session = $this->request->getSession();
     $data = $session->read();

     if(!isset($data['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $staff_id = $data['login']['staff_id'];
     $htmlRolecheck = new htmlRolecheck();//クラスを使用
     $roleCheck = $htmlRolecheck->Rolecheck($staff_id);
     $this->set('roleCheck',$roleCheck);

     $arrCustomers = $this->Customers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['customer_code' => 'ASC']);
     $arrCustomer = array();
     foreach ($arrCustomers as $value) {
       $arrCustomer[] = array($value->customer_code=>$value->customer_code.':'.$value->name);
     }
     $this->set('arrCustomer',$arrCustomer);

     $arrAccountUrikakeElements = $this->AccountUrikakeElements->find('all')->order(['id' => 'ASC']);
     $arrAccountUrikakeElement = array();
     foreach ($arrAccountUrikakeElements as $value) {
       $arrAccountUrikakeElement[] = array($value->id=>$value->element);
     }
     $this->set('arrAccountUrikakeElement',$arrAccountUrikakeElement);

		}

    public function urikakekensakuichiran()
		{
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $user = $this->Users->newEntity();
      $this->set('user',$user);

      $data = $this->request->getData();

      $date_sta = $data['date_sta']['year']."-".$data['date_sta']['month']."-".$data['date_sta']['day'];
      $date_fin = $data['date_fin']['year']."-".$data['date_fin']['month']."-".$data['date_fin']['day'];

      $date_fin = strtotime($date_fin);
      $date_fin = date('Y-m-d', strtotime('+1 day', $date_fin));

      if(empty($data['customer'])){//customerの入力がないとき

        if(empty($data['urikakeelement'])){//urikakeelementの入力がないとき

          $AccountUrikakes = $this->AccountUrikakes->find()
          ->where(['date >=' => $date_sta, 'date <=' => $date_fin, 'delete_flag' => 0])->order(["date"=>"ASC"])->toArray();
          $this->set('AccountUrikakes',$AccountUrikakes);

        }else{//urikake_element_idの入力があるとき
          $AccountUrikakes = $this->AccountUrikakes->find()
          ->where(['date >=' => $date_sta, 'date <=' => $date_fin, 'urikake_element_id' => $data['urikakeelement'], 'delete_flag' => 0])->order(["date"=>"ASC"])->toArray();
          $this->set('AccountUrikakes',$AccountUrikakes);

        }
      }else{//customerの入力があるとき
        if(empty($data['urikakeelement'])){//urikakeelementの入力がないとき
          $AccountUrikakes = $this->AccountUrikakes->find()
          ->where(['date >=' => $date_sta, 'date <=' => $date_fin, 'customer_code' => $data['customer'], 'delete_flag' => 0])->order(["date"=>"ASC"])->toArray();
          $this->set('AccountUrikakes',$AccountUrikakes);

        }else{//urikakeelementの入力があるとき

          $AccountUrikakes = $this->AccountUrikakes->find()
          ->where(['date >=' => $date_sta, 'date <=' => $date_fin, 'urikake_element_id' => $data['urikakeelement'], 'customer_code' => $data['customer'], 'delete_flag' => 0])->order(["date"=>"ASC"])->toArray();
          $this->set('AccountUrikakes',$AccountUrikakes);

        }
      }

		}

    public function urikakesyusei()
		{
      $session = $this->request->getSession();
      $data = $session->read();

      if(!isset($data['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $staff_id = $data['login']['staff_id'];
      $htmlRolecheck = new htmlRolecheck();//クラスを使用
      $roleCheck = $htmlRolecheck->Rolecheck($staff_id);
      $this->set('roleCheck',$roleCheck);

		 $user = $this->Users->newEntity();
		 $this->set('user',$user);

     $data = $this->request->getData();

     $data = array_keys($data, '編集');
/*
     echo "<pre>";
     print_r($data[0]);
     echo "</pre>";
*/
     $UrikakeId = $data[0];
     $this->set('UrikakeId',$UrikakeId);
     $AccountUrikakes = $this->AccountUrikakes->find()->where(['id' => $data[0]])->toArray();
     $customer_code = $AccountUrikakes[0]['customer_code'];
     $this->set('customer_code',$customer_code);
     $urikake_element_id = $AccountUrikakes[0]['urikake_element_id'];
     $this->set('urikake_element_id',$urikake_element_id);
     $kingaku = $AccountUrikakes[0]['kingaku'];
     $this->set('kingaku',$kingaku);
     $date = $AccountUrikakes[0]['date']->format('Y-m-d');
     $this->set('date',$date);

     $arrCustomers = $this->Customers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['customer_code' => 'ASC']);
     $arrCustomer = array();
     foreach ($arrCustomers as $value) {
       $arrCustomer[] = array($value->customer_code=>$value->customer_code.':'.$value->name);
     }
     $this->set('arrCustomer',$arrCustomer);

     $arrAccountUrikakeElements = $this->AccountUrikakeElements->find('all')->order(['id' => 'ASC']);
     $arrAccountUrikakeElement = array();
     foreach ($arrAccountUrikakeElements as $value) {
       $arrAccountUrikakeElement[] = array($value->id=>$value->element);
     }
     $this->set('arrAccountUrikakeElement',$arrAccountUrikakeElement);

		}

    public function urikakesyuseiconfirm()
		{
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $user = $this->Users->newEntity();
      $this->set('user',$user);

      $data = $this->request->getData();

      $CustomerData = $this->Customers->find()->where(['customer_code' => $data['customer']])->toArray();
      $customer = $CustomerData[0]->name;
      $this->set('customer',$customer);

      $AccountUrikakeElementData = $this->AccountUrikakeElements->find()->where(['id' => $data['urikakeelement']])->toArray();
      $AccountUrikakeElement = $AccountUrikakeElementData[0]->element;
      $this->set('AccountUrikakeElement',$AccountUrikakeElement);

      $dateYMD = $data['date']['year']."-".$data['date']['month']."-".$data['date']['day'];
      $this->set('dateYMD',$dateYMD);

      $price = $data['price'];
      $this->set('price',$price);
		}

    public function urikakesyuseido()
		{
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $AccountUrikakes = $this->AccountUrikakes->newEntity();
      $this->set('AccountUrikakes',$AccountUrikakes);

      $data = $this->request->getData();

      $CustomerData = $this->Customers->find()->where(['customer_code' => $data['customer']])->toArray();
      $customer = $CustomerData[0]->name;
      $this->set('customer',$customer);

      $AccountUrikakeElementData = $this->AccountUrikakeElements->find()->where(['id' => $data['urikakeelement']])->toArray();
      $AccountUrikakeElement = $AccountUrikakeElementData[0]->element;
      $this->set('AccountUrikakeElement',$AccountUrikakeElement);

      $dateYMD = $data['date'];
      $this->set('dateYMD',$dateYMD);

      $price = $data['price'];
      $this->set('price',$price);

      $AccountUrikakes = $this->AccountUrikakes->find()->where(['id' => $data['UrikakeId']])->toArray();
      $motocustomer = $AccountUrikakes[0]->customer_code;
      $motodate = $AccountUrikakes[0]->date->format('Y-m-d');
      $motoprice = $AccountUrikakes[0]->kingaku;
      $motourikake_element_id = $AccountUrikakes[0]->urikake_element_id;

      $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        if ($this->AccountUrikakes->updateAll(
          ['customer_code' => $data['customer'], 'kingaku' => $data['price'], 'date' => $data['date'], 'urikake_element_id' => $data['urikakeelement'],
           'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $sessionData['login']['staff_id']],
          ['id'  => $data['UrikakeId']]
        )){

          //旧DBも更新
          $connection = ConnectionManager::get('DB_ikou_test');
          $table = TableRegistry::get('account_urikake');
          $table->setConnection($connection);

          $updater = "UPDATE account_urikake set cs_id ='".$data['customer']."', kingaku ='".$data['price']."', date ='".$data['date']."',
          urikake_element_id ='".$data['urikakeelement']."', updated_at ='".date('Y-m-d H:i:s')."', updated_emp_id ='".$sessionData['login']['staff_id']."'
          where cs_id ='".$motocustomer."' and urikake_element_id = '".$motourikake_element_id."' and date = '".$motodate."' and kingaku = '".$motoprice."' ";
          $connection->execute($updater);

          $connection = ConnectionManager::get('default');//新DBに戻る
          $table->setConnection($connection);

          $mes = "※下記のように更新されました";
          $this->set('mes',$mes);
          $connection->commit();// コミット5
        } else {
          $mes = "※更新されませんでした";
          $this->set('mes',$mes);
          $this->Flash->error(__('The data could not be saved. Please, try again.'));
          throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
        }
      } catch (Exception $e) {//トランザクション7
      //ロールバック8
        $connection->rollback();//トランザクション9
      }//トランザクション10

		}

    public function materialurikakeform()
		{
      $user = $this->Users->newEntity();
 		 $this->set('user',$user);

      $session = $this->request->getSession();
      $data = $session->read();

      if(!isset($data['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $staff_id = $data['login']['staff_id'];
      $htmlRolecheck = new htmlRolecheck();//クラスを使用
      $roleCheck = $htmlRolecheck->Rolecheck($staff_id);
      $this->set('roleCheck',$roleCheck);

      $arrProductSuppliers = $this->ProductSuppliers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['id' => 'ASC']);
      $arrProductSupplier = array();
      foreach ($arrProductSuppliers as $value) {
        $arrProductSupplier[] = array($value->id=>$value->name);
      }
      $this->set('arrProductSupplier',$arrProductSupplier);//4行上$arrCustomerをctpで使えるようにセット

		}

    public function materialurikakeconfirm()
		{
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $user = $this->Users->newEntity();
      $this->set('user',$user);

      $data = $this->request->getData();
/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
      $SupplierData = $this->ProductSuppliers->find()->where(['id' => $data['sup_id']])->toArray();
      $Supplier = $SupplierData[0]->name;
      $this->set('Supplier',$Supplier);

      $dateYMD = $data['date']['year']."-".$data['date']['month']."-".$data['date']['day'];
      $this->set('dateYMD',$dateYMD);

      $grade = $data['grade'];
      $this->set('grade',$grade);
      $color = $data['color'];
      $this->set('color',$color);
      $amount = $data['amount'];
      $this->set('amount',$amount);
      $tanka = $data['tanka'];
      $this->set('tanka',$tanka);
		}

    public function materialurikakedo()
		{
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $user = $this->Users->newEntity();
      $this->set('user',$user);

      $data = $this->request->getData();

      $SupplierData = $this->ProductSuppliers->find()->where(['id' => $data['sup_id']])->toArray();
      $Supplier = $SupplierData[0]->name;
      $this->set('Supplier',$Supplier);

      $dateYMD = $data['date'];
      $this->set('dateYMD',$dateYMD);
      $grade = $data['grade'];
      $this->set('grade',$grade);
      $color = $data['color'];
      $this->set('color',$color);
      $amount = $data['amount'];
      $this->set('amount',$amount);
      $tanka = $data['tanka'];
      $this->set('tanka',$tanka);

      $arrtouroku = array();
      $arrtouroku[] = array(
        'sup_id' => $data['sup_id'],
        'date' => $dateYMD,
        'grade' => $grade,
        'color' => $color,
        'amount' => $amount,
        'tanka' => $tanka,
        'delete_flag' => 0,
        'created_staff' => $sessionData['login']['staff_id'],
        'created_at' => date('Y-m-d H:i:s')
      );
/*
      echo "<pre>";
      print_r($arrtouroku[0]);
      echo "</pre>";
*/
      $AccountUrikakeMaterials = $this->AccountUrikakeMaterials->patchEntity($this->AccountUrikakeMaterials->newEntity(), $arrtouroku[0]);
      $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        if ($this->AccountUrikakeMaterials->save($AccountUrikakeMaterials)) {

          //旧DBに製品登録
          $connection = ConnectionManager::get('DB_ikou_test');
          $table = TableRegistry::get('account_urikake_material');
          $table->setConnection($connection);

          $connection->insert('account_urikake_material', [
              'sup_id' => $arrtouroku[0]["sup_id"],
              'date' => $arrtouroku[0]["date"],
              'grade' => $arrtouroku[0]["grade"],
              'color' => $arrtouroku[0]["color"],
              'amount' => $arrtouroku[0]["amount"],
              'tanka' => $arrtouroku[0]["tanka"],
              'delete_flag' => $arrtouroku[0]["delete_flag"],
              'emp_id' => $arrtouroku[0]["created_staff"],
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

    public function materialurikakekensakuform()
		{
		 $user = $this->Users->newEntity();
		 $this->set('user',$user);

     $session = $this->request->getSession();
     $data = $session->read();

     if(!isset($data['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $staff_id = $data['login']['staff_id'];
     $htmlRolecheck = new htmlRolecheck();//クラスを使用
     $roleCheck = $htmlRolecheck->Rolecheck($staff_id);
     $this->set('roleCheck',$roleCheck);

     $arrProductSuppliers = $this->ProductSuppliers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['id' => 'ASC']);
     $arrProductSupplier = array();
     foreach ($arrProductSuppliers as $value) {
       $arrProductSupplier[] = array($value->id=>$value->name);
     }
     $this->set('arrProductSupplier',$arrProductSupplier);//4行上$arrCustomerをctpで使えるようにセット

     $arrAccountUrikakeElements = $this->AccountUrikakeElements->find('all')->order(['id' => 'ASC']);
     $arrAccountUrikakeElement = array();
     foreach ($arrAccountUrikakeElements as $value) {
       $arrAccountUrikakeElement[] = array($value->id=>$value->element);
     }
     $this->set('arrAccountUrikakeElement',$arrAccountUrikakeElement);

		}

    public function materialurikakekensakuichiran()
		{
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $user = $this->Users->newEntity();
      $this->set('user',$user);

      $data = $this->request->getData();

      $date_sta = $data['date_sta']['year']."-".$data['date_sta']['month']."-".$data['date_sta']['day'];
      $date_fin = $data['date_fin']['year']."-".$data['date_fin']['month']."-".$data['date_fin']['day'];

      $date_fin = strtotime($date_fin);
      $date_fin = date('Y-m-d', strtotime('+1 day', $date_fin));

        if(empty($data['sup_id'])){

          $AccountUrikakeMaterials = $this->AccountUrikakeMaterials->find()
          ->where(['date >=' => $date_sta, 'date <=' => $date_fin, 'delete_flag' => 0])->order(["date"=>"ASC"])->toArray();
          $this->set('AccountUrikakeMaterials',$AccountUrikakeMaterials);

        }else{
          $AccountUrikakeMaterials = $this->AccountUrikakeMaterials->find()
          ->where(['date >=' => $date_sta, 'date <=' => $date_fin, 'sup_id' => $data['sup_id'], 'delete_flag' => 0])->order(["date"=>"ASC"])->toArray();
          $this->set('AccountUrikakeMaterials',$AccountUrikakeMaterials);

        }

		}

    public function materialurikakesyusei()
		{
      $session = $this->request->getSession();
      $data = $session->read();

      if(!isset($data['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $staff_id = $data['login']['staff_id'];
      $htmlRolecheck = new htmlRolecheck();//クラスを使用
      $roleCheck = $htmlRolecheck->Rolecheck($staff_id);
      $this->set('roleCheck',$roleCheck);

		 $user = $this->Users->newEntity();
		 $this->set('user',$user);

     $data = $this->request->getData();

     $data = array_keys($data, '編集');
/*
     echo "<pre>";
     print_r($data[0]);
     echo "</pre>";
*/
     $Id = $data[0];
     $this->set('Id',$Id);
     $AccountUrikakeMaterials = $this->AccountUrikakeMaterials->find()->where(['id' => $data[0]])->toArray();
     $sup_id = $AccountUrikakeMaterials[0]['sup_id'];
     $this->set('sup_id',$sup_id);
     $date = $AccountUrikakeMaterials[0]['date']->format('Y-m-d');
     $this->set('date',$date);
     $grade = $AccountUrikakeMaterials[0]['grade'];
     $this->set('grade',$grade);
     $color = $AccountUrikakeMaterials[0]['color'];
     $this->set('color',$color);
     $amount = $AccountUrikakeMaterials[0]['amount'];
     $this->set('amount',$amount);
     $tanka = $AccountUrikakeMaterials[0]['tanka'];
     $this->set('tanka',$tanka);

     $arrProductSuppliers = $this->ProductSuppliers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['id' => 'ASC']);
     $arrProductSupplier = array();
     foreach ($arrProductSuppliers as $value) {
       $arrProductSupplier[] = array($value->id=>$value->name);
     }
     $this->set('arrProductSupplier',$arrProductSupplier);

		}

    public function materialurikakesyuseiconfirm()
		{
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $user = $this->Users->newEntity();
      $this->set('user',$user);

      $data = $this->request->getData();

      $SupplierData = $this->ProductSuppliers->find()->where(['id' => $data['sup_id']])->toArray();
      $Supplier = $SupplierData[0]->name;
      $this->set('Supplier',$Supplier);

      $dateYMD = $data['date']['year']."-".$data['date']['month']."-".$data['date']['day'];
      $this->set('dateYMD',$dateYMD);

      $grade = $data['grade'];
      $this->set('grade',$grade);
      $color = $data['color'];
      $this->set('color',$color);
      $amount = $data['amount'];
      $this->set('amount',$amount);
      $tanka = $data['tanka'];
      $this->set('tanka',$tanka);
		}

    public function materialurikakesyuseido()
		{
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $AccountUrikakeMaterials = $this->AccountUrikakeMaterials->newEntity();
      $this->set('AccountUrikakeMaterials',$AccountUrikakeMaterials);

      $data = $this->request->getData();
/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
      $SupplierData = $this->ProductSuppliers->find()->where(['id' => $data['sup_id']])->toArray();
      $Supplier = $SupplierData[0]->name;
      $this->set('Supplier',$Supplier);

      $dateYMD = $data['date'];
      $this->set('dateYMD',$dateYMD);

      $grade = $data['grade'];
      $this->set('grade',$grade);
      $color = $data['color'];
      $this->set('color',$color);
      $amount = $data['amount'];
      $this->set('amount',$amount);
      $tanka = $data['tanka'];
      $this->set('tanka',$tanka);

      $AccountUrikakeMaterials = $this->AccountUrikakeMaterials->find()->where(['id' => $data['Id']])->toArray();
      $motosup_id = $AccountUrikakeMaterials[0]->sup_id;
      $motodate = $AccountUrikakeMaterials[0]->date->format('Y-m-d');
      $motograde = $AccountUrikakeMaterials[0]->grade;
      $motocolor = $AccountUrikakeMaterials[0]->color;
      $motoamount = $AccountUrikakeMaterials[0]->amount;
      $mototanka = $AccountUrikakeMaterials[0]->tanka;

      $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        if ($this->AccountUrikakeMaterials->updateAll(
          ['sup_id' => $data['sup_id'], 'date' => $data['date'], 'grade' => $data['grade'], 'color' => $data['color'], 'amount' => $data['amount'], 'tanka' => $data['tanka'],
           'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $sessionData['login']['staff_id']],
          ['id'  => $data['Id']]
        )){

          //旧DBも更新
          $connection = ConnectionManager::get('DB_ikou_test');
          $table = TableRegistry::get('account_urikake_material');
          $table->setConnection($connection);

          $updater = "UPDATE account_urikake_material set sup_id ='".$data['sup_id']."', date ='".$data['date']."', grade ='".$data['grade']."',
          color ='".$data['color']."', amount ='".$data['amount']."', tanka ='".$data['tanka']."', updated_at ='".date('Y-m-d H:i:s')."', updated_emp_id ='".$sessionData['login']['staff_id']."'
          where sup_id ='".$motosup_id."' and grade = '".$motograde."' and date = '".$motodate."' and color = '".$motocolor."' and amount = '".$motoamount."' and tanka = '".$mototanka."' ";
          $connection->execute($updater);

          $connection = ConnectionManager::get('default');//新DBに戻る
          $table->setConnection($connection);

          $mes = "※下記のように更新されました";
          $this->set('mes',$mes);
          $connection->commit();// コミット5
        } else {
          $mes = "※更新されませんでした";
          $this->set('mes',$mes);
          $this->Flash->error(__('The data could not be saved. Please, try again.'));
          throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
        }
      } catch (Exception $e) {//トランザクション7
      //ロールバック8
        $connection->rollback();//トランザクション9
      }//トランザクション10

		}

    public function productkaikakemenu()
    {
     $user = $this->Users->newEntity();
     $this->set('user',$user);
    }

    public function productkaikakeform()
		{
		 $user = $this->Users->newEntity();
		 $this->set('user',$user);

     $session = $this->request->getSession();
     $data = $session->read();

     if(!isset($data['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $staff_id = $data['login']['staff_id'];
     $htmlRolecheck = new htmlRolecheck();//クラスを使用
     $roleCheck = $htmlRolecheck->Rolecheck($staff_id);
     $this->set('roleCheck',$roleCheck);

     $arrProductSuppliers = $this->ProductSuppliers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['id' => 'ASC']);
     $arrProductSupplier = array();
     foreach ($arrProductSuppliers as $value) {
       $arrProductSupplier[] = array($value->id=>$value->name);
     }
     $this->set('arrProductSupplier',$arrProductSupplier);

     $arrAccountKaikakeElements = $this->AccountKaikakeElements->find('all')->order(['id' => 'ASC']);
     $arrAccountKaikakeElement = array();
     foreach ($arrAccountKaikakeElements as $value) {
       $arrAccountKaikakeElement[] = array($value->id=>$value->element);
     }
     $this->set('arrAccountKaikakeElement',$arrAccountKaikakeElement);

		}

    public function productkaikakeconfirm()
		{
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $user = $this->Users->newEntity();
      $this->set('user',$user);

      $data = $this->request->getData();

      $SupplierData = $this->ProductSuppliers->find()->where(['id' => $data['sup_id']])->toArray();
      $Supplier = $SupplierData[0]->name;
      $this->set('Supplier',$Supplier);

      $AccountKaikakeElementData = $this->AccountKaikakeElements->find()->where(['id' => $data['element']])->toArray();
      $AccountKaikakeElement = $AccountKaikakeElementData[0]->element;
      $this->set('AccountKaikakeElement',$AccountKaikakeElement);

      $dateYMD = $data['date']['year']."-".$data['date']['month']."-".$data['date']['day'];
      $this->set('dateYMD',$dateYMD);

      $price = $data['price'];
      $this->set('price',$price);
		}

    public function productkaikakedo()
		{
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $user = $this->Users->newEntity();
      $this->set('user',$user);

      $data = $this->request->getData();

      $SupplierData = $this->ProductSuppliers->find()->where(['id' => $data['sup_id']])->toArray();
      $Supplier = $SupplierData[0]->name;
      $this->set('Supplier',$Supplier);

      $AccountKaikakeElementData = $this->AccountKaikakeElements->find()->where(['id' => $data['element']])->toArray();
      $AccountKaikakeElement = $AccountKaikakeElementData[0]->element;
      $this->set('AccountKaikakeElement',$AccountKaikakeElement);

      $dateYMD = $data['date'];
      $this->set('dateYMD',$dateYMD);

      $price = $data['price'];
      $this->set('price',$price);

      $arrtouroku = array();
      $arrtouroku[] = array(
        'sup_id' => $data['sup_id'],
        'kaikake_element_id' => $data['element'],
        'date' => $dateYMD,
        'kingaku' => $price,
        'delete_flag' => 0,
        'created_staff' => $sessionData['login']['staff_id'],
        'created_at' => date('Y-m-d H:i:s')
      );
/*
      echo "<pre>";
      print_r($arrtouroku[0]);
      echo "</pre>";
*/
      $AccountProductKaikakes = $this->AccountProductKaikakes->patchEntity($this->AccountProductKaikakes->newEntity(), $arrtouroku[0]);
      $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        if ($this->AccountProductKaikakes->save($AccountProductKaikakes)) {

          //旧DBに製品登録
          $connection = ConnectionManager::get('DB_ikou_test');
          $table = TableRegistry::get('account_product_kaikake');
          $table->setConnection($connection);

          $connection->insert('account_product_kaikake', [
              'sup_id' => $arrtouroku[0]["sup_id"],
              'kingaku' => $arrtouroku[0]["kingaku"],
              'date' => $arrtouroku[0]["date"],
              'kaikake_element_id' => $arrtouroku[0]["kaikake_element_id"],
              'delete_flag' => $arrtouroku[0]["delete_flag"],
              'emp_id' => $arrtouroku[0]["created_staff"],
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

    public function productkaikakekensakuform()
		{
		 $user = $this->Users->newEntity();
		 $this->set('user',$user);

     $session = $this->request->getSession();
     $data = $session->read();

     if(!isset($data['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $staff_id = $data['login']['staff_id'];
     $htmlRolecheck = new htmlRolecheck();//クラスを使用
     $roleCheck = $htmlRolecheck->Rolecheck($staff_id);
     $this->set('roleCheck',$roleCheck);

     $arrProductSuppliers = $this->ProductSuppliers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['id' => 'ASC']);
     $arrProductSupplier = array();
     foreach ($arrProductSuppliers as $value) {
       $arrProductSupplier[] = array($value->id=>$value->name);
     }
     $this->set('arrProductSupplier',$arrProductSupplier);

     $arrAccountKaikakeElements = $this->AccountKaikakeElements->find('all')->order(['id' => 'ASC']);
     $arrAccountKaikakeElement = array();
     foreach ($arrAccountKaikakeElements as $value) {
       $arrAccountKaikakeElement[] = array($value->id=>$value->element);
     }
     $this->set('arrAccountKaikakeElement',$arrAccountKaikakeElement);

		}

    public function productkaikakekensakuichiran()
		{
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $user = $this->Users->newEntity();
      $this->set('user',$user);

      $data = $this->request->getData();

      $date_sta = $data['date_sta']['year']."-".$data['date_sta']['month']."-".$data['date_sta']['day'];
      $date_fin = $data['date_fin']['year']."-".$data['date_fin']['month']."-".$data['date_fin']['day'];

      $date_fin = strtotime($date_fin);
      $date_fin = date('Y-m-d', strtotime('+1 day', $date_fin));

      if(empty($data['sup_id'])){//sup_idの入力がないとき

        if(empty($data['element'])){//elementの入力がないとき

          $AccountProductKaikakes = $this->AccountProductKaikakes->find()
          ->where(['date >=' => $date_sta, 'date <=' => $date_fin, 'delete_flag' => 0])->order(["date"=>"ASC"])->toArray();
          $this->set('AccountProductKaikakes',$AccountProductKaikakes);

        }else{//elementの入力があるとき

          $AccountProductKaikakes = $this->AccountProductKaikakes->find()
          ->where(['date >=' => $date_sta, 'date <=' => $date_fin, 'kaikake_element_id' => $data['element'], 'delete_flag' => 0])->order(["date"=>"ASC"])->toArray();
          $this->set('AccountProductKaikakes',$AccountProductKaikakes);

        }

      }else{//sup_idの入力があるとき

        if(empty($data['element'])){//elementの入力がないとき

          $AccountProductKaikakes = $this->AccountProductKaikakes->find()
          ->where(['date >=' => $date_sta, 'date <=' => $date_fin, 'sup_id' => $data['sup_id'], 'delete_flag' => 0])->order(["date"=>"ASC"])->toArray();
          $this->set('AccountProductKaikakes',$AccountProductKaikakes);

        }else{//elementの入力があるとき

          $AccountProductKaikakes = $this->AccountProductKaikakes->find()
          ->where(['date >=' => $date_sta, 'date <=' => $date_fin, 'kaikake_element_id' => $data['element'], 'sup_id' => $data['sup_id'], 'delete_flag' => 0])->order(["date"=>"ASC"])->toArray();
          $this->set('AccountProductKaikakes',$AccountProductKaikakes);

        }
      }

		}

    public function productkaikakesyusei()
		{
      $session = $this->request->getSession();
      $data = $session->read();

      if(!isset($data['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $staff_id = $data['login']['staff_id'];
      $htmlRolecheck = new htmlRolecheck();//クラスを使用
      $roleCheck = $htmlRolecheck->Rolecheck($staff_id);
      $this->set('roleCheck',$roleCheck);

		 $user = $this->Users->newEntity();
		 $this->set('user',$user);

     $data = $this->request->getData();

     $data = array_keys($data, '編集');
/*
     echo "<pre>";
     print_r($data[0]);
     echo "</pre>";
*/
     $Id = $data[0];
     $this->set('Id',$Id);
     $AccountProductKaikakes = $this->AccountProductKaikakes->find()->where(['id' => $data[0]])->toArray();
     $sup_id = $AccountProductKaikakes[0]['sup_id'];
     $this->set('sup_id',$sup_id);
     $element_id = $AccountProductKaikakes[0]['kaikake_element_id'];
     $this->set('element_id',$element_id);
     $kingaku = $AccountProductKaikakes[0]['kingaku'];
     $this->set('kingaku',$kingaku);
     $date = $AccountProductKaikakes[0]['date']->format('Y-m-d');
     $this->set('date',$date);

     $arrProductSuppliers = $this->ProductSuppliers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['id' => 'ASC']);
     $arrProductSupplier = array();
     foreach ($arrProductSuppliers as $value) {
       $arrProductSupplier[] = array($value->id=>$value->name);
     }
     $this->set('arrProductSupplier',$arrProductSupplier);

     $arrAccountKaikakeElements = $this->AccountKaikakeElements->find('all')->order(['id' => 'ASC']);
     $arrAccountKaikakeElement = array();
     foreach ($arrAccountKaikakeElements as $value) {
       $arrAccountKaikakeElement[] = array($value->id=>$value->element);
     }
     $this->set('arrAccountKaikakeElement',$arrAccountKaikakeElement);

		}

    public function productkaikakesyuseiconfirm()
		{
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $user = $this->Users->newEntity();
      $this->set('user',$user);

      $data = $this->request->getData();

      $SupplierData = $this->ProductSuppliers->find()->where(['id' => $data['sup_id']])->toArray();
      $Supplier = $SupplierData[0]->name;
      $this->set('Supplier',$Supplier);

      $AccountKaikakeElementData = $this->AccountKaikakeElements->find()->where(['id' => $data['element']])->toArray();
      $AccountKaikakeElement = $AccountKaikakeElementData[0]->element;
      $this->set('AccountKaikakeElement',$AccountKaikakeElement);

      $dateYMD = $data['date']['year']."-".$data['date']['month']."-".$data['date']['day'];
      $this->set('dateYMD',$dateYMD);

      $kingaku = $data['kingaku'];
      $this->set('kingaku',$kingaku);
		}

    public function productkaikakesyuseido()
		{
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $AccountUrikakes = $this->AccountUrikakes->newEntity();
      $this->set('AccountUrikakes',$AccountUrikakes);

      $data = $this->request->getData();

      $SupplierData = $this->ProductSuppliers->find()->where(['id' => $data['sup_id']])->toArray();
      $Supplier = $SupplierData[0]->name;
      $this->set('Supplier',$Supplier);

      $AccountKaikakeElementData = $this->AccountKaikakeElements->find()->where(['id' => $data['element']])->toArray();
      $AccountKaikakeElement = $AccountKaikakeElementData[0]->element;
      $this->set('AccountKaikakeElement',$AccountKaikakeElement);

      $dateYMD = $data['date'];
      $this->set('dateYMD',$dateYMD);

      $kingaku = $data['kingaku'];
      $this->set('kingaku',$kingaku);

      $AccountProductKaikakes = $this->AccountProductKaikakes->find()->where(['id' => $data['Id']])->toArray();
      $motosup_id = $AccountProductKaikakes[0]->sup_id;
      $motodate = $AccountProductKaikakes[0]->date->format('Y-m-d');
      $motokingaku = $AccountProductKaikakes[0]->kingaku;
      $motokaikake_element_id = $AccountProductKaikakes[0]->kaikake_element_id;

      $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        if ($this->AccountProductKaikakes->updateAll(
          ['sup_id' => $data['sup_id'], 'kingaku' => $data['kingaku'], 'date' => $data['date'], 'kaikake_element_id' => $data['element'],
           'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $sessionData['login']['staff_id']],
          ['id'  => $data['Id']]
        )){

          //旧DBも更新
          $connection = ConnectionManager::get('DB_ikou_test');
          $table = TableRegistry::get('account_product_kaikake');
          $table->setConnection($connection);

          $updater = "UPDATE account_product_kaikake set sup_id ='".$data['sup_id']."', kingaku ='".$data['kingaku']."', date ='".$data['date']."',
          kaikake_element_id ='".$data['element']."', updated_at ='".date('Y-m-d H:i:s')."', updated_emp_id ='".$sessionData['login']['staff_id']."'
          where sup_id ='".$motosup_id."' and kaikake_element_id = '".$motokaikake_element_id."' and date = '".$motodate."' and kingaku = '".$motokingaku."' ";
          $connection->execute($updater);

          $connection = ConnectionManager::get('default');//新DBに戻る
          $table->setConnection($connection);

          $mes = "※下記のように更新されました";
          $this->set('mes',$mes);
          $connection->commit();// コミット5
        } else {
          $mes = "※更新されませんでした";
          $this->set('mes',$mes);
          $this->Flash->error(__('The data could not be saved. Please, try again.'));
          throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
        }
      } catch (Exception $e) {//トランザクション7
      //ロールバック8
        $connection->rollback();//トランザクション9
      }//トランザクション10

		}

    public function materialkaikakemenu()
		{
		 $user = $this->Users->newEntity();
		 $this->set('user',$user);
		}

    public function materialkaikakeform()
		{
		 $user = $this->Users->newEntity();
		 $this->set('user',$user);

     $session = $this->request->getSession();
     $data = $session->read();

     if(!isset($data['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $staff_id = $data['login']['staff_id'];
     $htmlRolecheck = new htmlRolecheck();//クラスを使用
     $roleCheck = $htmlRolecheck->Rolecheck($staff_id);
     $this->set('roleCheck',$roleCheck);

     $arrSuppliers = $this->Suppliers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['id' => 'ASC']);
     $arrSupplier = array();
     foreach ($arrSuppliers as $value) {
       $arrSupplier[] = array($value->id=>$value->name);
     }
     $this->set('arrSupplier',$arrSupplier);

     $arrAccountKaikakeElements = $this->AccountKaikakeElements->find('all')->order(['id' => 'ASC']);
     $arrAccountKaikakeElement = array();
     foreach ($arrAccountKaikakeElements as $value) {
       $arrAccountKaikakeElement[] = array($value->id=>$value->element);
     }
     $this->set('arrAccountKaikakeElement',$arrAccountKaikakeElement);

		}

    public function materialkaikakeconfirm()
		{
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $user = $this->Users->newEntity();
      $this->set('user',$user);

      $data = $this->request->getData();

      $SupplierData = $this->Suppliers->find()->where(['id' => $data['sup_id']])->toArray();
      $Supplier = $SupplierData[0]->name;
      $this->set('Supplier',$Supplier);

      $AccountKaikakeElementData = $this->AccountKaikakeElements->find()->where(['id' => $data['element']])->toArray();
      $AccountKaikakeElement = $AccountKaikakeElementData[0]->element;
      $this->set('AccountKaikakeElement',$AccountKaikakeElement);

      $dateYMD = $data['date']['year']."-".$data['date']['month']."-".$data['date']['day'];
      $this->set('dateYMD',$dateYMD);

      $price = $data['price'];
      $this->set('price',$price);
		}

    public function materialkaikakedo()
		{
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $user = $this->Users->newEntity();
      $this->set('user',$user);

      $data = $this->request->getData();

      $SupplierData = $this->Suppliers->find()->where(['id' => $data['sup_id']])->toArray();
      $Supplier = $SupplierData[0]->name;
      $this->set('Supplier',$Supplier);

      $AccountKaikakeElementData = $this->AccountKaikakeElements->find()->where(['id' => $data['element']])->toArray();
      $AccountKaikakeElement = $AccountKaikakeElementData[0]->element;
      $this->set('AccountKaikakeElement',$AccountKaikakeElement);

      $dateYMD = $data['date'];
      $this->set('dateYMD',$dateYMD);

      $price = $data['price'];
      $this->set('price',$price);

      $arrtouroku = array();
      $arrtouroku[] = array(
        'sup_id' => $data['sup_id'],
        'kaikake_element_id' => $data['element'],
        'date' => $dateYMD,
        'kingaku' => $price,
        'delete_flag' => 0,
        'created_staff' => $sessionData['login']['staff_id'],
        'created_at' => date('Y-m-d H:i:s')
      );
/*
      echo "<pre>";
      print_r($arrtouroku[0]);
      echo "</pre>";
*/
      $AccountMaterialKaikakes = $this->AccountMaterialKaikakes->patchEntity($this->AccountMaterialKaikakes->newEntity(), $arrtouroku[0]);
      $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        if ($this->AccountMaterialKaikakes->save($AccountMaterialKaikakes)) {

          //旧DBに製品登録
          $connection = ConnectionManager::get('DB_ikou_test');
          $table = TableRegistry::get('account_material_kaikake');
          $table->setConnection($connection);

          $connection->insert('account_material_kaikake', [
              'sup_id' => $arrtouroku[0]["sup_id"],
              'kingaku' => $arrtouroku[0]["kingaku"],
              'date' => $arrtouroku[0]["date"],
              'kaikake_element_id' => $arrtouroku[0]["kaikake_element_id"],
              'delete_flag' => $arrtouroku[0]["delete_flag"],
              'emp_id' => $arrtouroku[0]["created_staff"],
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

    public function materialkaikakekensakuform()
		{
		 $user = $this->Users->newEntity();
		 $this->set('user',$user);

     $session = $this->request->getSession();
     $data = $session->read();

     if(!isset($data['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $staff_id = $data['login']['staff_id'];
     $htmlRolecheck = new htmlRolecheck();//クラスを使用
     $roleCheck = $htmlRolecheck->Rolecheck($staff_id);
     $this->set('roleCheck',$roleCheck);

     $arrSuppliers = $this->Suppliers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['id' => 'ASC']);
     $arrSupplier = array();
     foreach ($arrSuppliers as $value) {
       $arrSupplier[] = array($value->id=>$value->name);
     }
     $this->set('arrSupplier',$arrSupplier);

     $arrAccountKaikakeElements = $this->AccountKaikakeElements->find('all')->order(['id' => 'ASC']);
     $arrAccountKaikakeElement = array();
     foreach ($arrAccountKaikakeElements as $value) {
       $arrAccountKaikakeElement[] = array($value->id=>$value->element);
     }
     $this->set('arrAccountKaikakeElement',$arrAccountKaikakeElement);

		}

    public function materialkaikakekensakuichiran()
		{
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $user = $this->Users->newEntity();
      $this->set('user',$user);

      $data = $this->request->getData();

      $date_sta = $data['date_sta']['year']."-".$data['date_sta']['month']."-".$data['date_sta']['day'];
      $date_fin = $data['date_fin']['year']."-".$data['date_fin']['month']."-".$data['date_fin']['day'];

      $date_fin = strtotime($date_fin);
      $date_fin = date('Y-m-d', strtotime('+1 day', $date_fin));

      if(empty($data['sup_id'])){//sup_idの入力がないとき

        if(empty($data['element'])){//elementの入力がないとき

          $AccountMaterialKaikakes = $this->AccountMaterialKaikakes->find()
          ->where(['date >=' => $date_sta, 'date <=' => $date_fin, 'delete_flag' => 0])->order(["date"=>"ASC"])->toArray();
          $this->set('AccountMaterialKaikakes',$AccountMaterialKaikakes);

        }else{//elementの入力があるとき

          $AccountMaterialKaikakes = $this->AccountMaterialKaikakes->find()
          ->where(['date >=' => $date_sta, 'date <=' => $date_fin, 'kaikake_element_id' => $data['element'], 'delete_flag' => 0])->order(["date"=>"ASC"])->toArray();
          $this->set('AccountMaterialKaikakes',$AccountMaterialKaikakes);

        }

      }else{//sup_idの入力があるとき

        if(empty($data['element'])){//elementの入力がないとき

          $AccountMaterialKaikakes = $this->AccountMaterialKaikakes->find()
          ->where(['date >=' => $date_sta, 'date <=' => $date_fin, 'sup_id' => $data['sup_id'], 'delete_flag' => 0])->order(["date"=>"ASC"])->toArray();
          $this->set('AccountMaterialKaikakes',$AccountMaterialKaikakes);

        }else{//elementの入力があるとき

          $AccountMaterialKaikakes = $this->AccountMaterialKaikakes->find()
          ->where(['date >=' => $date_sta, 'date <=' => $date_fin, 'kaikake_element_id' => $data['element'], 'sup_id' => $data['sup_id'], 'delete_flag' => 0])->order(["date"=>"ASC"])->toArray();
          $this->set('AccountMaterialKaikakes',$AccountMaterialKaikakes);

        }
      }

		}

    public function materialkaikakesyusei()
		{
      $session = $this->request->getSession();
      $data = $session->read();

      if(!isset($data['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $staff_id = $data['login']['staff_id'];
      $htmlRolecheck = new htmlRolecheck();//クラスを使用
      $roleCheck = $htmlRolecheck->Rolecheck($staff_id);
      $this->set('roleCheck',$roleCheck);

		 $user = $this->Users->newEntity();
		 $this->set('user',$user);

     $data = $this->request->getData();

     $data = array_keys($data, '編集');
/*
     echo "<pre>";
     print_r($data[0]);
     echo "</pre>";
*/
     $Id = $data[0];
     $this->set('Id',$Id);
     $AccountMaterialKaikakes = $this->AccountMaterialKaikakes->find()->where(['id' => $data[0]])->toArray();
     $sup_id = $AccountMaterialKaikakes[0]['sup_id'];
     $this->set('sup_id',$sup_id);
     $element_id = $AccountMaterialKaikakes[0]['kaikake_element_id'];
     $this->set('element_id',$element_id);
     $kingaku = $AccountMaterialKaikakes[0]['kingaku'];
     $this->set('kingaku',$kingaku);
     $date = $AccountMaterialKaikakes[0]['date']->format('Y-m-d');
     $this->set('date',$date);

     $arrSuppliers = $this->Suppliers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['id' => 'ASC']);
     $arrSupplier = array();
     foreach ($arrSuppliers as $value) {
       $arrSupplier[] = array($value->id=>$value->name);
     }
     $this->set('arrSupplier',$arrSupplier);

     $arrAccountKaikakeElements = $this->AccountKaikakeElements->find('all')->order(['id' => 'ASC']);
     $arrAccountKaikakeElement = array();
     foreach ($arrAccountKaikakeElements as $value) {
       $arrAccountKaikakeElement[] = array($value->id=>$value->element);
     }
     $this->set('arrAccountKaikakeElement',$arrAccountKaikakeElement);

		}

    public function materialkaikakesyuseiconfirm()
		{
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $user = $this->Users->newEntity();
      $this->set('user',$user);

      $data = $this->request->getData();

      $SupplierData = $this->Suppliers->find()->where(['id' => $data['sup_id']])->toArray();
      $Supplier = $SupplierData[0]->name;
      $this->set('Supplier',$Supplier);

      $AccountKaikakeElementData = $this->AccountKaikakeElements->find()->where(['id' => $data['element']])->toArray();
      $AccountKaikakeElement = $AccountKaikakeElementData[0]->element;
      $this->set('AccountKaikakeElement',$AccountKaikakeElement);

      $dateYMD = $data['date']['year']."-".$data['date']['month']."-".$data['date']['day'];
      $this->set('dateYMD',$dateYMD);

      $kingaku = $data['kingaku'];
      $this->set('kingaku',$kingaku);
		}

    public function materialkaikakesyuseido()
		{
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $AccountUrikakes = $this->AccountUrikakes->newEntity();
      $this->set('AccountUrikakes',$AccountUrikakes);

      $data = $this->request->getData();

      $SupplierData = $this->Suppliers->find()->where(['id' => $data['sup_id']])->toArray();
      $Supplier = $SupplierData[0]->name;
      $this->set('Supplier',$Supplier);

      $AccountKaikakeElementData = $this->AccountKaikakeElements->find()->where(['id' => $data['element']])->toArray();
      $AccountKaikakeElement = $AccountKaikakeElementData[0]->element;
      $this->set('AccountKaikakeElement',$AccountKaikakeElement);

      $dateYMD = $data['date'];
      $this->set('dateYMD',$dateYMD);

      $kingaku = $data['kingaku'];
      $this->set('kingaku',$kingaku);

      $AccountMaterialKaikakes = $this->AccountMaterialKaikakes->find()->where(['id' => $data['Id']])->toArray();
      $motosup_id = $AccountMaterialKaikakes[0]->sup_id;
      $motodate = $AccountMaterialKaikakes[0]->date->format('Y-m-d');
      $motokingaku = $AccountMaterialKaikakes[0]->kingaku;
      $motokaikake_element_id = $AccountMaterialKaikakes[0]->kaikake_element_id;

      $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        if ($this->AccountMaterialKaikakes->updateAll(
          ['sup_id' => $data['sup_id'], 'kingaku' => $data['kingaku'], 'date' => $data['date'], 'kaikake_element_id' => $data['element'],
           'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $sessionData['login']['staff_id']],
          ['id'  => $data['Id']]
        )){

          //旧DBも更新
          $connection = ConnectionManager::get('DB_ikou_test');
          $table = TableRegistry::get('account_material_kaikake');
          $table->setConnection($connection);

          $updater = "UPDATE account_material_kaikake set sup_id ='".$data['sup_id']."', kingaku ='".$data['kingaku']."', date ='".$data['date']."',
          kaikake_element_id ='".$data['element']."', updated_at ='".date('Y-m-d H:i:s')."', updated_emp_id ='".$sessionData['login']['staff_id']."'
          where sup_id ='".$motosup_id."' and kaikake_element_id = '".$motokaikake_element_id."' and date = '".$motodate."' and kingaku = '".$motokingaku."' ";
          $connection->execute($updater);

          $connection = ConnectionManager::get('default');//新DBに戻る
          $table->setConnection($connection);

          $mes = "※下記のように更新されました";
          $this->set('mes',$mes);
          $connection->commit();// コミット5
        } else {
          $mes = "※更新されませんでした";
          $this->set('mes',$mes);
          $this->Flash->error(__('The data could not be saved. Please, try again.'));
          throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
        }
      } catch (Exception $e) {//トランザクション7
      //ロールバック8
        $connection->rollback();//トランザクション9
      }//トランザクション10

		}

    public function soukomenu()
    {
     $user = $this->Users->newEntity();
     $this->set('user',$user);
    }

    public function soukokensakuform()
    {
     $user = $this->Users->newEntity();
     $this->set('user',$user);

     $session = $this->request->getSession();
     $data = $session->read();

     if(!isset($data['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $staff_id = $data['login']['staff_id'];
     $htmlRolecheck = new htmlRolecheck();//クラスを使用
     $roleCheck = $htmlRolecheck->Rolecheck($staff_id);
     $this->set('roleCheck',$roleCheck);

     $arrType = [
       '1' => '入庫',
       '2' => '出荷'
     ];
      $this->set('arrType',$arrType);

    }

    public function soukokensakuichiran()
    {
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $user = $this->Users->newEntity();
      $this->set('user',$user);

      $data = $this->request->getData();
/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
      $date_sta = $data['date_sta']['year']."-".$data['date_sta']['month']."-".$data['date_sta']['day'];
      $date_fin = $data['date_fin']['year']."-".$data['date_fin']['month']."-".$data['date_fin']['day'];

      $date_fin = strtotime($date_fin);
      $date_fin = date('Y-m-d', strtotime('+1 day', $date_fin));

      if(empty($data['type'])){//typeの入力がないとき

        if(empty($data['product_code'])){//product_codeの入力がないとき

          $StockInoutWorklogs = $this->StockInoutWorklogs->find()
          ->where(['date_work >=' => $date_sta, 'date_work <=' => $date_fin, 'delete_flag' => 0])->order(["date_work"=>"ASC"])->toArray();
          $this->set('StockInoutWorklogs',$StockInoutWorklogs);

        }else{//product_codeの入力があるとき

          $StockInoutWorklogs = $this->StockInoutWorklogs->find()
          ->where(['date_work >=' => $date_sta, 'date_work <=' => $date_fin, 'product_code' => $data['product_code'], 'delete_flag' => 0])->order(["date_work"=>"ASC"])->toArray();
          $this->set('StockInoutWorklogs',$StockInoutWorklogs);

        }

      }else{//typeの入力があるとき

        if(empty($data['product_code'])){//typeの入力がないとき

          $StockInoutWorklogs = $this->StockInoutWorklogs->find()
          ->where(['date_work >=' => $date_sta, 'date_work <=' => $date_fin, 'type' => $data['type'], 'delete_flag' => 0])->order(["date_work"=>"ASC"])->toArray();
          $this->set('StockInoutWorklogs',$StockInoutWorklogs);

        }else{//product_codeの入力があるとき

          $StockInoutWorklogs = $this->StockInoutWorklogs->find()
          ->where(['date_work >=' => $date_sta, 'date_work <=' => $date_fin, 'type' => $data['type'], 'product_code' => $data['product_code'], 'delete_flag' => 0])->order(["date_work"=>"ASC"])->toArray();
          $this->set('StockInoutWorklogs',$StockInoutWorklogs);

        }
      }

    }

    public function soukosyusei()
    {
      $session = $this->request->getSession();
      $data = $session->read();

      if(!isset($data['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $staff_id = $data['login']['staff_id'];
      $htmlRolecheck = new htmlRolecheck();//クラスを使用
      $roleCheck = $htmlRolecheck->Rolecheck($staff_id);
      $this->set('roleCheck',$roleCheck);

     $user = $this->Users->newEntity();
     $this->set('user',$user);

     $data = $this->request->getData();

     $data = array_keys($data, '編集');

     $Id = $data[0];
     $this->set('Id',$Id);
     $StockInoutWorklogs = $this->StockInoutWorklogs->find()->where(['id' => $data[0]])->toArray();
     $type = $StockInoutWorklogs[0]['type'];
     $this->set('type',$type);
     $outsource_name = $StockInoutWorklogs[0]['outsource_name'];
     $OutsourceHandys = $this->OutsourceHandys->find()->where(['name' => $outsource_name])->toArray();
     $sup_id = $OutsourceHandys[0]['id'];
     $this->set('sup_id',$sup_id);
     $product_code = $StockInoutWorklogs[0]['product_code'];
     $this->set('product_code',$product_code);
     $amount = $StockInoutWorklogs[0]['amount'];
     $this->set('amount',$amount);
     $date_work = $StockInoutWorklogs[0]['date_work']->format('Y-m-d');
     $this->set('date_work',$date_work);

     $arrType = [
       '1' => '入庫',
       '2' => '出荷'
     ];
      $this->set('arrType',$arrType);

      $arrOutsourceHandys = $this->OutsourceHandys->find('all', ['conditions' => ['flag' => '0']])->order(['id' => 'ASC']);
      $arrOutsourceHandy = array();
      foreach ($arrOutsourceHandys as $value) {
        $arrOutsourceHandy[] = array($value->id=>$value->name);
      }
      $this->set('arrOutsourceHandy',$arrOutsourceHandy);

    }

    public function soukosyuseiconfirm()
    {
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $user = $this->Users->newEntity();
      $this->set('user',$user);

      $data = $this->request->getData();
/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
      if($data['type'] == 1){
        $type = "入庫";
      }else{
        $type = "出庫";
      }
      $this->set('type',$type);

      $OutsourceHandys = $this->OutsourceHandys->find()->where(['id' => $data['sup_id']])->toArray();
      $Supplier = $OutsourceHandys[0]['name'];
      $this->set('Supplier',$Supplier);

      $dateYMD = $data['date']['year']."-".$data['date']['month']."-".$data['date']['day'];
      $this->set('dateYMD',$dateYMD);

      $product_code = $data['product_code'];
      $this->set('product_code',$product_code);
      $amount = $data['amount'];
      $this->set('amount',$amount);
    }

    public function soukosyuseido()
    {
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $StockInoutWorklogs = $this->StockInoutWorklogs->newEntity();
      $this->set('StockInoutWorklogs',$StockInoutWorklogs);

      $data = $this->request->getData();
/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
      if($data['type'] == 1){
        $type = "入庫";
      }else{
        $type = "出庫";
      }
      $this->set('type',$type);

      $OutsourceHandys = $this->OutsourceHandys->find()->where(['id' => $data['sup_id']])->toArray();
      $Supplier = $OutsourceHandys[0]['name'];
      $this->set('Supplier',$Supplier);

      $dateYMD = $data['date'];
      $this->set('dateYMD',$dateYMD);

      $product_code = $data['product_code'];
      $this->set('product_code',$product_code);
      $amount = $data['amount'];
      $this->set('amount',$amount);

      $StockInoutWorklogs = $this->StockInoutWorklogs->find()->where(['id' => $data['Id']])->toArray();
      $mototype = $StockInoutWorklogs[0]->type;
      $motodate_work = $StockInoutWorklogs[0]->date_work->format('Y-m-d');
      $motooutsource_name = $StockInoutWorklogs[0]->outsource_name;
      $motoproduct_id = $StockInoutWorklogs[0]->product_code;
      $motoamount = $StockInoutWorklogs[0]->amount;

      $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        if ($this->StockInoutWorklogs->updateAll(
          ['type' => $data['type'], 'date_work' => $data['date'], 'outsource_code' => $data['sup_id'], 'outsource_name' => $Supplier, 'product_code' => $data['product_code'], 'amount' => $data['amount'],
           'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $sessionData['login']['staff_id']],
          ['id'  => $data['Id']]
        )){

          //旧DBも更新
          $connection = ConnectionManager::get('DB_ikou_test');
          $table = TableRegistry::get('stock_inout_worklog');
          $table->setConnection($connection);

          $updater = "UPDATE stock_inout_worklog set type ='".$data['type']."', outsource_id ='".$data['sup_id']."', outsource_name ='".$Supplier."', date_work ='".$data['date']."',
          product_id ='".$data['product_code']."', amount ='".$data['amount']."', updated_at ='".date('Y-m-d H:i:s')."', updated_emp_id ='".$sessionData['login']['staff_id']."'
          where type ='".$mototype."' and  date_work = '".$motodate_work."' and product_id = '".$motoproduct_id."' and amount = '".$motoamount."'";
          $connection->execute($updater);

          $connection = ConnectionManager::get('default');//新DBに戻る
          $table->setConnection($connection);

          $mes = "※下記のように更新されました";
          $this->set('mes',$mes);
          $connection->commit();// コミット5
        } else {
          $mes = "※更新されませんでした";
          $this->set('mes',$mes);
          $this->Flash->error(__('The data could not be saved. Please, try again.'));
          throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
        }
      } catch (Exception $e) {//トランザクション7
      //ロールバック8
        $connection->rollback();//トランザクション9
      }//トランザクション10

    }


    public function yusyouzaimenu()
		{
		 $user = $this->Users->newEntity();
		 $this->set('user',$user);
		}

    public function yusyouzaiform()
		{
		 $user = $this->Users->newEntity();
		 $this->set('user',$user);

     $session = $this->request->getSession();
     $data = $session->read();

     if(!isset($data['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $staff_id = $data['login']['staff_id'];
     $htmlRolecheck = new htmlRolecheck();//クラスを使用
     $roleCheck = $htmlRolecheck->Rolecheck($staff_id);
     $this->set('roleCheck',$roleCheck);

     $arrCustomers = $this->Customers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['customer_code' => 'ASC']);
     $arrCustomer = array();
     foreach ($arrCustomers as $value) {
       $arrCustomer[] = array($value->customer_code=>$value->name);
     }
     $this->set('arrCustomer',$arrCustomer);

     $arrType = [
       '0' => '製品',
       '1' => '原料'
     ];
      $this->set('arrType',$arrType);

		}

    public function yusyouzaiconfirm()
		{
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $user = $this->Users->newEntity();
      $this->set('user',$user);

      $data = $this->request->getData();

      $Customers = $this->Customers->find()->where(['customer_code' => $data['customer']])->toArray();
      $customer_name = $Customers[0]['name'];
      $this->set('customer_name',$customer_name);

      if($data['flag_product_material'] == 1){
        $Type = "原料";
      }else{
        $Type = "製品";
      }
      $this->set('Type',$Type);

      $price = $data['price'];
      $this->set('price',$price);
		}

    public function yusyouzaido()
		{
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $user = $this->Users->newEntity();
      $this->set('user',$user);

      $data = $this->request->getData();

      $Customers = $this->Customers->find()->where(['customer_code' => $data['customer']])->toArray();
      $customer_name = $Customers[0]['name'];
      $this->set('customer_name',$customer_name);

      $product_code = $data['product_code'];
      $this->set('product_code',$product_code);
      $product_name = $data['product_name'];
      $this->set('product_name',$product_name);
      $price = $data['price'];
      $this->set('price',$price);

      if($data['flag_product_material'] == 1){
        $Type = "原料";
      }else{
        $Type = "製品";
      }
      $this->set('Type',$Type);

      $arrtouroku = array();
      $arrtouroku[] = array(
        'product_code' => $data['product_code'],
        'product_name' => $data['product_name'],
        'customer_code' => $data['customer_code'],
        'flag_product_material' => $data['flag_product_material'],
        'price' => $data['price'],
        'delete_flag' => 0,
        'created_staff' => $sessionData['login']['staff_id'],
        'created_at' => date('Y-m-d H:i:s')
      );
/*
      echo "<pre>";
      print_r($arrtouroku[0]);
      echo "</pre>";
*/
      $AccountYusyouzaiMasters = $this->AccountYusyouzaiMasters->patchEntity($this->AccountYusyouzaiMasters->newEntity(), $arrtouroku[0]);
      $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        if ($this->AccountYusyouzaiMasters->save($AccountYusyouzaiMasters)) {

          //旧DBに製品登録
          $connection = ConnectionManager::get('DB_ikou_test');
          $table = TableRegistry::get('account_yusyouzai_master');
          $table->setConnection($connection);

          $connection->insert('account_yusyouzai_master', [
              'product_id' => $arrtouroku[0]["product_code"],
              'product_name' => $arrtouroku[0]["product_name"],
              'cs_id' => $arrtouroku[0]["customer_code"],
              'price' => $arrtouroku[0]["price"],
              'flag_product_material' => $arrtouroku[0]["flag_product_material"],
              'delete_flag' => $arrtouroku[0]["delete_flag"],
              'emp_id' => $arrtouroku[0]["created_staff"],
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

    public function yusyouzaiichiran()
    {
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $user = $this->Users->newEntity();
      $this->set('user',$user);

      $AccountYusyouzaiMasters = $this->AccountYusyouzaiMasters->find()
      ->where(['delete_flag' => 0])->order(["customer_code"=>"ASC"])->toArray();
      $this->set('AccountYusyouzaiMasters',$AccountYusyouzaiMasters);

    }

    public function yusyouzaisyusei()
    {
      $session = $this->request->getSession();
      $data = $session->read();

      if(!isset($data['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $staff_id = $data['login']['staff_id'];
      $htmlRolecheck = new htmlRolecheck();//クラスを使用
      $roleCheck = $htmlRolecheck->Rolecheck($staff_id);
      $this->set('roleCheck',$roleCheck);

     $user = $this->Users->newEntity();
     $this->set('user',$user);

     $data = $this->request->getData();

     $data = array_keys($data, '編集');

     $Id = $data[0];
     $this->set('Id',$Id);
     $AccountYusyouzaiMasters = $this->AccountYusyouzaiMasters->find()->where(['id' => $data[0]])->toArray();
     $product_code = $AccountYusyouzaiMasters[0]['product_code'];
     $this->set('product_code',$product_code);
     $product_name = $AccountYusyouzaiMasters[0]['product_name'];
     $this->set('product_name',$product_name);
     $customer_code = $AccountYusyouzaiMasters[0]['customer_code'];
     $this->set('customer_code',$customer_code);
     $price = $AccountYusyouzaiMasters[0]['price'];
     $this->set('price',$price);
     $flag_product_material = $AccountYusyouzaiMasters[0]['flag_product_material'];
     $this->set('flag_product_material',$flag_product_material);

     $arrCustomers = $this->Customers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['customer_code' => 'ASC']);
     $arrCustomer = array();
     foreach ($arrCustomers as $value) {
       $arrCustomer[] = array($value->customer_code=>$value->name);
     }
     $this->set('arrCustomer',$arrCustomer);

     $arrType = [
       '0' => '製品',
       '1' => '原料'
     ];
      $this->set('arrType',$arrType);

    }

    public function yusyouzaisyuseiconfirm()
    {
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $user = $this->Users->newEntity();
      $this->set('user',$user);

      $data = $this->request->getData();
/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
      $Customers = $this->Customers->find()->where(['customer_code' => $data['customer']])->toArray();
      $customer_name = $Customers[0]['name'];
      $this->set('customer_name',$customer_name);

      if($data['flag_product_material'] == 1){
        $Type = "原料";
      }else{
        $Type = "製品";
      }
      $this->set('Type',$Type);
    }

    public function yusyouzaisyuseido()
    {
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $AccountYusyouzaiMasters = $this->AccountYusyouzaiMasters->newEntity();
      $this->set('AccountYusyouzaiMasters',$AccountYusyouzaiMasters);

      $data = $this->request->getData();
/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
      $Customers = $this->Customers->find()->where(['customer_code' => $data['customer']])->toArray();
      $customer_name = $Customers[0]['name'];
      $this->set('customer_name',$customer_name);

      if($data['flag_product_material'] == 1){
        $Type = "原料";
      }else{
        $Type = "製品";
      }
      $this->set('Type',$Type);

      $product_code = $data['product_code'];
      $this->set('product_code',$product_code);
      $product_name = $data['product_name'];
      $this->set('product_name',$product_name);
      $customer_code = $data['customer_code'];
      $this->set('customer_code',$customer_code);
      $price = $data['price'];
      $this->set('price',$price);
      $flag_product_material = $data['flag_product_material'];
      $this->set('flag_product_material',$flag_product_material);

      $AccountYusyouzaiMasters = $this->AccountYusyouzaiMasters->find()->where(['id' => $data['Id']])->toArray();
      $motoproduct_code = $AccountYusyouzaiMasters[0]->product_code;
      $motoproduct_name = $AccountYusyouzaiMasters[0]->product_name;
      $motocustomer_code = $AccountYusyouzaiMasters[0]->customer_code;
      $motoprice = $AccountYusyouzaiMasters[0]->price;
      $motoflag_product_material = $AccountYusyouzaiMasters[0]->flag_product_material;

      $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        if ($this->AccountYusyouzaiMasters->updateAll(
          ['product_code' => $data['product_code'], 'product_name' => $data['product_name'], 'customer_code' => $data['customer_code'],
           'price' => $data['price'], 'flag_product_material' => $data['flag_product_material'],
           'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $sessionData['login']['staff_id']],
          ['id'  => $data['Id']]
        )){

          //旧DBも更新
          $connection = ConnectionManager::get('DB_ikou_test');
          $table = TableRegistry::get('account_yusyouzai_master');
          $table->setConnection($connection);

          $updater = "UPDATE account_yusyouzai_master set product_id ='".$data['product_code']."', product_name ='".$data['product_name']."', cs_id ='".$data['customer_code']."', price ='".$data['price']."',
          flag_product_material ='".$data['flag_product_material']."', updated_at ='".date('Y-m-d H:i:s')."', updated_emp_id ='".$sessionData['login']['staff_id']."'
          where product_id ='".$motoproduct_code."' and product_name = '".$motoproduct_name."' and cs_id = '".$motocustomer_code."' and price = '".$motoprice."' and flag_product_material = '".$motoflag_product_material."' ";
          $connection->execute($updater);

          $connection = ConnectionManager::get('default');//新DBに戻る
          $table->setConnection($connection);

          $mes = "※下記のように更新されました";
          $this->set('mes',$mes);
          $connection->commit();// コミット5
        } else {
          $mes = "※更新されませんでした";
          $this->set('mes',$mes);
          $this->Flash->error(__('The data could not be saved. Please, try again.'));
          throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
        }
      } catch (Exception $e) {//トランザクション7
      //ロールバック8
        $connection->rollback();//トランザクション9
      }//トランザクション10

    }

    public function pricemenu()
		{
		 $user = $this->Users->newEntity();
		 $this->set('user',$user);
		}

    public function pricematerialkensakuform()
    {
     $user = $this->Users->newEntity();
     $this->set('user',$user);

     $session = $this->request->getSession();
     $data = $session->read();

     if(!isset($data['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $staff_id = $data['login']['staff_id'];
     $htmlRolecheck = new htmlRolecheck();//クラスを使用
     $roleCheck = $htmlRolecheck->Rolecheck($staff_id);
     $this->set('roleCheck',$roleCheck);
    }

    public function pricematerialkensakuichiran()
    {
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $user = $this->Users->newEntity();
      $this->set('user',$user);

      $data = $this->request->getData();
/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
      $date_sta = $data['date_sta']['year']."-".$data['date_sta']['month']."-".$data['date_sta']['day'];
      $date_fin = $data['date_fin']['year']."-".$data['date_fin']['month']."-".$data['date_fin']['day'];

      $date_fin = strtotime($date_fin);
      $date_fin = date('Y-m-d', strtotime('+1 day', $date_fin));

      if(empty($data['grade'])){//gradeの入力がないとき

        if(empty($data['color'])){//colorの入力がないとき

          $OrderMaterials = $this->OrderMaterials->find()
          ->where(['date_order >=' => $date_sta, 'date_order <=' => $date_fin, 'delete_flag' => 0])->order(["date_order"=>"ASC"])->toArray();
          $this->set('OrderMaterials',$OrderMaterials);

        }else{//product_codeの入力があるとき

          $OrderMaterials = $this->OrderMaterials->find()
          ->where(['date_order >=' => $date_sta, 'date_order <=' => $date_fin, 'color' => $data['color'], 'delete_flag' => 0])->order(["date_order"=>"ASC"])->toArray();
          $this->set('OrderMaterials',$OrderMaterials);

        }

      }else{//gradeの入力があるとき

        if(empty($data['color'])){//colorの入力がないとき

          $OrderMaterials = $this->OrderMaterials->find()
          ->where(['date_order >=' => $date_sta, 'date_order <=' => $date_fin, 'grade' => $data['grade'], 'delete_flag' => 0])->order(["date_order"=>"ASC"])->toArray();
          $this->set('OrderMaterials',$OrderMaterials);

        }else{//product_codeの入力があるとき

          $OrderMaterials = $this->OrderMaterials->find()
          ->where(['date_order >=' => $date_sta, 'date_order <=' => $date_fin, 'grade' => $data['grade'], 'color' => $data['color'], 'delete_flag' => 0])->order(["date_order"=>"ASC"])->toArray();
          $this->set('OrderMaterials',$OrderMaterials);

        }
      }

    }

    public function pricematerialsyusei()
    {
      $session = $this->request->getSession();
      $data = $session->read();

      if(!isset($data['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $staff_id = $data['login']['staff_id'];
      $htmlRolecheck = new htmlRolecheck();//クラスを使用
      $roleCheck = $htmlRolecheck->Rolecheck($staff_id);
      $this->set('roleCheck',$roleCheck);

     $user = $this->Users->newEntity();
     $this->set('user',$user);

     $data = $this->request->getData();

     $data = array_keys($data, '編集');

     $Id = $data[0];
     $this->set('Id',$Id);
     $OrderMaterials = $this->OrderMaterials->find()->where(['id' => $data[0]])->toArray();
     $id_order = $OrderMaterials[0]['id_order'];
     $this->set('id_order',$id_order);
     $grade = $OrderMaterials[0]['grade'];
     $this->set('grade',$grade);
     $color = $OrderMaterials[0]['color'];
     $this->set('color',$color);
     $price = $OrderMaterials[0]['price'];
     $this->set('price',$price);
     $amount = $OrderMaterials[0]['amount'];
     $this->set('amount',$amount);
     $date_order = $OrderMaterials[0]['date_order']->format('Y-m-d');
     $this->set('date_order',$date_order);

    }

    public function pricematerialsyuseiconfirm()
    {
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $user = $this->Users->newEntity();
      $this->set('user',$user);

      $data = $this->request->getData();
/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
      $dateYMD = $data['date']['year']."-".$data['date']['month']."-".$data['date']['day'];
      $this->set('dateYMD',$dateYMD);

      $id_order = $data['id_order'];
      $this->set('id_order',$id_order);
      $grade = $data['grade'];
      $this->set('grade',$grade);
      $color = $data['color'];
      $this->set('color',$color);
      $price = $data['price'];
      $this->set('price',$price);
      $amount = $data['amount'];
      $this->set('amount',$amount);
      $price = $data['price'];
      $this->set('price',$price);
    }

    public function pricematerialsyuseido()
    {
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $OrderMaterials = $this->OrderMaterials->newEntity();
      $this->set('OrderMaterials',$OrderMaterials);

      $data = $this->request->getData();
/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
      $dateYMD = $data['date'];
      $this->set('dateYMD',$dateYMD);

      $id_order = $data['id_order'];
      $this->set('id_order',$id_order);
      $grade = $data['grade'];
      $this->set('grade',$grade);
      $color = $data['color'];
      $this->set('color',$color);
      $price = $data['price'];
      $this->set('price',$price);
      $amount = $data['amount'];
      $this->set('amount',$amount);
      $price = $data['price'];
      $this->set('price',$price);

      $OrderMaterials = $this->OrderMaterials->find()->where(['id' => $data['Id']])->toArray();
      $motoid_order = $OrderMaterials[0]->id_order;

      $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        if ($this->OrderMaterials->updateAll(
          ['date_order' => $data['date'], 'price' => $data['price'], 'amount' => $data['amount'],
           'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $sessionData['login']['staff_id']],
          ['id'  => $data['Id']]
        )){

          //旧DBも更新
          $connection = ConnectionManager::get('DB_ikou_test');
          $table = TableRegistry::get('order_material');
          $table->setConnection($connection);

          $updater = "UPDATE order_material set date_order ='".$data['date']."', price ='".$data['price']."',
          amount ='".$data['amount']."', updated_at ='".date('Y-m-d H:i:s')."', updated_staff ='".$sessionData['login']['staff_id']."'
          where id ='".$motoid_order."'";
          $connection->execute($updater);

          $connection = ConnectionManager::get('default');//新DBに戻る
          $table->setConnection($connection);

          $mes = "※下記のように更新されました";
          $this->set('mes',$mes);
          $connection->commit();// コミット5
        } else {
          $mes = "※更新されませんでした";
          $this->set('mes',$mes);
          $this->Flash->error(__('The data could not be saved. Please, try again.'));
          throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
        }
      } catch (Exception $e) {//トランザクション7
      //ロールバック8
        $connection->rollback();//トランザクション9
      }//トランザクション10

    }

    public function ukeirekensakuform()
		{
		 $user = $this->Users->newEntity();
		 $this->set('user',$user);

     $session = $this->request->getSession();
     $data = $session->read();

     if(!isset($data['login'])){
       return $this->redirect(['action' => 'index']);
     }

     $staff_id = $data['login']['staff_id'];
     $htmlRolecheck = new htmlRolecheck();//クラスを使用
     $roleCheck = $htmlRolecheck->Rolecheck($staff_id);
     $this->set('roleCheck',$roleCheck);

     $arrCustomers = $this->Customers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['customer_code' => 'ASC']);
     $arrCustomer = array();
     foreach ($arrCustomers as $value) {
       $arrCustomer[] = array($value->customer_code=>$value->name);
     }
     $this->set('arrCustomer',$arrCustomer);
		}

    public function ukeirekensakuichiran()
		{
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $user = $this->Users->newEntity();
      $this->set('user',$user);

      $data = $this->request->getData();

      $date_sta = $data['date_sta']['year']."-".$data['date_sta']['month']."-".$data['date_sta']['day'];
      $date_fin = $data['date_fin']['year']."-".$data['date_fin']['month']."-".$data['date_fin']['day'];

      $date_fin = strtotime($date_fin);
      $date_fin = date('Y-m-d', strtotime('+1 day', $date_fin));

        if(empty($data['customer_code'])){

          $AccountYusyouzaiUkeires = $this->AccountYusyouzaiUkeires->find()
          ->where(['date_ukeire >=' => $date_sta, 'date_ukeire <=' => $date_fin, 'delete_flag' => 0])->order(["date_ukeire"=>"ASC"])->toArray();
          $this->set('AccountYusyouzaiUkeires',$AccountYusyouzaiUkeires);

        }else{

          $AccountYusyouzaiUkeires = $this->AccountYusyouzaiUkeires->find()
          ->where(['date_ukeire >=' => $date_sta, 'date_ukeire <=' => $date_fin, 'delete_flag' => 0])->order(["date_ukeire"=>"ASC"])->toArray();

          $customer_code = $data['customer_code'];

          for($i=0; $i<count($AccountYusyouzaiUkeires); $i++){

            $product_code = $AccountYusyouzaiUkeires[$i]->product_code;
            $AccountYusyouzaiMasters = $this->AccountYusyouzaiMasters->find()->where(['product_code' => $product_code, 'customer_code' => $customer_code])->toArray();

            if(isset($AccountYusyouzaiMasters[0])){
              $product_code = $product_code;
            }else{
              unset($AccountYusyouzaiUkeires[$i]);
            }

          }

          $AccountYusyouzaiUkeires = array_values($AccountYusyouzaiUkeires);
          $this->set('AccountYusyouzaiUkeires',$AccountYusyouzaiUkeires);

        }

		}

    public function ukeiresyusei()
		{
      $session = $this->request->getSession();
      $data = $session->read();

      if(!isset($data['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $staff_id = $data['login']['staff_id'];
      $htmlRolecheck = new htmlRolecheck();//クラスを使用
      $roleCheck = $htmlRolecheck->Rolecheck($staff_id);
      $this->set('roleCheck',$roleCheck);

		 $user = $this->Users->newEntity();
		 $this->set('user',$user);

     $data = $this->request->getData();

     $data = array_keys($data, '編集');

     $Id = $data[0];
     $this->set('Id',$Id);
     $AccountYusyouzaiUkeires = $this->AccountYusyouzaiUkeires->find()->where(['id' => $data[0]])->toArray();
     $product_code = $AccountYusyouzaiUkeires[0]['product_code'];
     $this->set('product_code',$product_code);
     $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
     $product_name = $Product[0]->product_name;
     $this->set('product_name',$product_name);
     $date = $AccountYusyouzaiUkeires[0]['date_ukeire']->format('Y-m-d');
     $this->set('date',$date);
     $amount = $AccountYusyouzaiUkeires[0]['amount'];
     $this->set('amount',$amount);
     $tanka = $AccountYusyouzaiUkeires[0]['tanka'];
     $this->set('tanka',$tanka);
		}

    public function ukeiresyuseiconfirm()
		{
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $user = $this->Users->newEntity();
      $this->set('user',$user);

      $data = $this->request->getData();
      /*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
      $dateYMD = $data['date']['year']."-".$data['date']['month']."-".$data['date']['day'];
      $this->set('dateYMD',$dateYMD);
		}

    public function ukeiresyuseido()
		{
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['action' => 'index']);
      }

      $AccountYusyouzaiUkeires = $this->AccountYusyouzaiUkeires->newEntity();
      $this->set('AccountYusyouzaiUkeires',$AccountYusyouzaiUkeires);

      $data = $this->request->getData();
/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
      $dateYMD = $data['date'];
      $this->set('dateYMD',$dateYMD);

      $product_code = $data['product_code'];

      $amount = $data['amount'];
      $this->set('amount',$amount);
      $tanka = $data['tanka'];
      $this->set('tanka',$tanka);

      $AccountUrikakeMaterials = $this->AccountYusyouzaiUkeires->find()->where(['id' => $data['Id']])->toArray();
      $motoproduct_code = $AccountUrikakeMaterials[0]->product_code;
      $motodate_ukeire = $AccountUrikakeMaterials[0]->date_ukeire->format('Y-m-d');
      $motoamount = $AccountUrikakeMaterials[0]->amount;
      $mototanka = $AccountUrikakeMaterials[0]->tanka;

      $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        if ($this->AccountYusyouzaiUkeires->updateAll(
          ['date_ukeire' => $data['date'], 'amount' => $data['amount'], 'tanka' => $data['tanka'],
           'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $sessionData['login']['staff_id']],
          ['id'  => $data['Id']]
        )){

          //旧DBも更新
          $connection = ConnectionManager::get('DB_ikou_test');
          $table = TableRegistry::get('account_yusyouzai_ukeire');
          $table->setConnection($connection);

          $updater = "UPDATE account_yusyouzai_ukeire set date_ukeire ='".$data['date']."', amount ='".$data['amount']."', tanka ='".$data['tanka']."',
           updated_at ='".date('Y-m-d H:i:s')."', updated_emp_id ='".$sessionData['login']['staff_id']."'
          where product_id ='".$motoproduct_code."' and date_ukeire = '".$motodate_ukeire."' and amount = '".$motoamount."' and tanka = '".$mototanka."' ";
          $connection->execute($updater);

          $connection = ConnectionManager::get('default');//新DBに戻る
          $table->setConnection($connection);

          $mes = "※下記のように更新されました";
          $this->set('mes',$mes);
          $connection->commit();// コミット5
        } else {
          $mes = "※更新されませんでした";
          $this->set('mes',$mes);
          $this->Flash->error(__('The data could not be saved. Please, try again.'));
          throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
        }
      } catch (Exception $e) {//トランザクション7
      //ロールバック8
        $connection->rollback();//トランザクション9
      }//トランザクション10

		}

    public function form()
    {
    }

     public function confirm()
    {
    }

     public function do()
    {
    }

}
