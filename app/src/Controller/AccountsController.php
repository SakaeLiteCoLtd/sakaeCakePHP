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

    public function yusyouzaimenu()
		{
		 $user = $this->Users->newEntity();
		 $this->set('user',$user);
		}

    public function soukomenu()
		{
		 $user = $this->Users->newEntity();
		 $this->set('user',$user);
		}

    public function pricemenu()
		{
		 $user = $this->Users->newEntity();
		 $this->set('user',$user);
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
