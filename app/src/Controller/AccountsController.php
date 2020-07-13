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
			$this->AccountPriceProducts = TableRegistry::get('accountPriceProducts');
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

    public function kaikakemenu()
		{
		 $user = $this->Users->newEntity();
		 $this->set('user',$user);
		}

    public function materialkaikakemenu()
		{
		 $user = $this->Users->newEntity();
		 $this->set('user',$user);
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
