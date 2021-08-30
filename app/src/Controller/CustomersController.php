<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

use App\myClass\Logins\htmlLogin;//myClassフォルダに配置したクラスを使用
use App\myClass\Productcheck\htmlProductcheck;

class CustomersController extends AppController
{

     public function initialize()
     {
        parent::initialize();
         $this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
				 $this->Users = TableRegistry::get('users');
         $this->PlaceDelivers = TableRegistry::get('placeDelivers');
         $this->Customers = TableRegistry::get('customers');
         $this->CustomersHandys = TableRegistry::get('customersHandys');
		 }

    public function index()
    {
			$this->set('customers', $this->Customers->find('all'));//Customersテーブルから'delete_flag' => '0'となるものを見つける※ページネーションに条件を追加してある
    }

    public function form()
    {
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['controller' => 'Shinkies', 'action' => 'index']);
      }

			$customer = $this->Customers->newEntity();//newentityに$customerという名前を付ける
			$this->set('customer', $customer);//1行上の$customerをctpで使えるようにセット
    }

     public function confirm()
    {
      session_start();
			$customer = $this->Customers->newEntity();//newEntityを作成
			$this->set('customer', $customer);//1行上の$customerをctpで使えるようにセット
    }

		public function preadd()
		{
			$customer = $this->Customers->newEntity();//newEntityを作成
			$this->set('customer', $customer);//1行上の$customerをctpで使えるようにセット
		}

	 public function login()
	 {
		 if ($this->request->is('post')) {
			 $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
			 $str = implode(',', $data);//preadd.ctpで入力したデータをカンマ区切りの文字列にする
			 $ary = explode(',', $str);//$strを配列に変換

			 $username = $ary[0];//入力したデータをカンマ区切りの最初のデータを$usernameとする
			 //※staff_codeをusernameに変換？・・・userが一人に決まらないから無理
			 $this->set('username', $username);
			 $Userdata = $this->Users->find()->where(['username' => $username])->toArray();

				 if(empty($Userdata)){
					 $delete_flag = "";
				 }else{
					 $delete_flag = $Userdata[0]->delete_flag;//配列の0番目（0番目しかない）のnameに$Roleと名前を付ける
					 $this->set('delete_flag',$delete_flag);//登録者の表示のため1行上の$Roleをctpで使えるようにセット
				 }
					 $user = $this->Auth->identify();
				 if ($user) {
					 $this->Auth->setUser($user);
					 return $this->redirect(['action' => 'do']);
				 }
			 }
	 }

	 public function logout()
	 {
		 $this->request->session()->destroy(); // セッションの破棄
		 return $this->redirect(['controller' => 'Shinkies', 'action' => 'index']);//ログアウト後に移るページ
	 }

     public function do()
    {
			$customer = $this->Customers->newEntity();//newEntityを作成
			$this->set('customer', $customer);//1行上の$customerをctpで使えるようにセット

			$session = $this->request->getSession();
			$data = $session->read();//postデータ取得し、$dataと名前を付ける

	//		$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
	//		$data['customerdata']['created_staff'] = $staff_id;//$userのcreated_staffを$staff_idにする
/*
      echo "<pre>";
	    print_r($data['customerdata']);
	    echo "</pre>";
*/

      $_SESSION['hyoujitourokudata'] = array();
      $_SESSION['hyoujitourokudata'] = $data['customerdata'];

			if ($this->request->is('post')) {//getの場合
				$customer = $this->Customers->patchEntity($customer, $data['customerdata']);//$customerデータ（空の行）を$this->request->getData()に更新する
				$connection = ConnectionManager::get('default');//トランザクション1
				// トランザクション開始2
				$connection->begin();//トランザクション3
				try {//トランザクション4
					if ($this->Customers->save($customer)) {

            //旧DBに製品登録
						$connection = ConnectionManager::get('DB_ikou_test');
						$table = TableRegistry::get('customer');
						$table->setConnection($connection);

            $connection->insert('customer', [
                'cs_id' => $data['customerdata']["customer_code"],
                'cs_name' => $data['customerdata']["name"],
                'jyusho' => $data['customerdata']["address"],
                'tel' => $data['customerdata']["tel"],
                'fax' => $data['customerdata']["fax"],
                'shimebi' => 0
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
    }

    public function deliverform()
    {
	//		$this->request->session()->destroy(); // セッションの破棄

      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['controller' => 'Shinkies', 'action' => 'index']);
      }

			$customer = $this->Customers->newEntity();//newentityに$customerという名前を付ける
			$this->set('customer', $customer);//1行上の$customerをctpで使えるようにセット

      $arrCustomers = $this->Customers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['customer_code' => 'ASC']);//Customersテーブルの'delete_flag' => '0'となるものを見つけ、customer_code順に並べる
      $arrCustomer = array();//配列の初期化
      foreach ($arrCustomers as $value) {//2行上のCustomersテーブルのデータそれぞれに対して
        $arrCustomer[] = array($value->id=>$value->customer_code.':'.$value->name);//配列に3行上のCustomersテーブルのデータそれぞれのcustomer_code:name
      }
      $this->set('arrCustomer',$arrCustomer);//4行上$arrCustomerをctpで使えるようにセット

    }

     public function deliverconfirm()
    {
      session_start();
			$customer = $this->Customers->newEntity();//newEntityを作成
			$this->set('customer', $customer);//1行上の$customerをctpで使えるようにセット

      $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける

      $customer_id = $data['customer'];
			$CustomersData = $this->Customers->find()->where(['id' => $customer_id])->toArray();
			$Customer = $CustomersData[0]->customer_code.":".$CustomersData[0]->name;
			$this->set('Customer',$Customer);

      $cs_code = $CustomersData[0]->customer_code;
      $this->set('cs_code',$cs_code);
    }

		public function deliverpreadd()
		{
			$customer = $this->Customers->newEntity();//newEntityを作成
			$this->set('customer', $customer);//1行上の$customerをctpで使えるようにセット
		}

	 public function deliverlogin()
	 {
		 if ($this->request->is('post')) {
			 $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
			 $str = implode(',', $data);//preadd.ctpで入力したデータをカンマ区切りの文字列にする
			 $ary = explode(',', $str);//$strを配列に変換

			 $username = $ary[0];//入力したデータをカンマ区切りの最初のデータを$usernameとする
			 //※staff_codeをusernameに変換？・・・userが一人に決まらないから無理
			 $this->set('username', $username);
			 $Userdata = $this->Users->find()->where(['username' => $username])->toArray();

				 if(empty($Userdata)){
					 $delete_flag = "";
				 }else{
					 $delete_flag = $Userdata[0]->delete_flag;//配列の0番目（0番目しかない）のnameに$Roleと名前を付ける
					 $this->set('delete_flag',$delete_flag);//登録者の表示のため1行上の$Roleをctpで使えるようにセット
				 }
					 $user = $this->Auth->identify();
				 if ($user) {
					 $this->Auth->setUser($user);
					 return $this->redirect(['action' => 'deliverdo']);
				 }
			 }
	 }

     public function deliverdo()
    {
      $PlaceDeliver = $this->PlaceDelivers->newEntity();//newEntityを作成
			$this->set('PlaceDeliver', $PlaceDeliver);//1行上の$customerをctpで使えるようにセット
      $CustomersHandys = $this->CustomersHandys->newEntity();//newEntityを作成
			$this->set('CustomersHandys', $CustomersHandys);//1行上の$customerをctpで使えるようにセット

			$session = $this->request->getSession();
			$data = $session->read();//postデータ取得し、$dataと名前を付ける

	//		$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
	//		$data['placedata']['created_staff'] = $staff_id;//$userのcreated_staffを$staff_idにする
/*
      echo "<pre>";
	    print_r($data['cs_handydata']);
	    echo "</pre>";
*/
      $customer_code = $data['placedata']['cs_code'];
      $CustomersData = $this->Customers->find()->where(['customer_code' => $customer_code])->toArray();
      $Customer = $CustomersData[0]->customer_code.":".$CustomersData[0]->name;
      $this->set('Customer',$Customer);

			if ($this->request->is('post')) {//postの場合
				$PlaceDeliver = $this->PlaceDelivers->patchEntity($PlaceDeliver, $data['placedata']);//$customerデータ（空の行）を$this->request->getData()に更新する
				$connection = ConnectionManager::get('default');//トランザクション1
				// トランザクション開始2
				$connection->begin();//トランザクション3
				try {//トランザクション4
					if ($this->PlaceDelivers->save($PlaceDeliver)) {

          //CustomersHandys登録
          $CustomersHandys = $this->CustomersHandys->patchEntity($CustomersHandys, $data['cs_handydata']);
          $this->CustomersHandys->save($CustomersHandys);

            //旧DBに製品登録
						$connection = ConnectionManager::get('DB_ikou_test');
						$table = TableRegistry::get('placedeliver');
						$table->setConnection($connection);

            $connection->insert('placedeliver', [
                'id_from_order' => $data['placedata']["id_from_order"],
                'name' => $data['placedata']["name"],
                'cs_id' => $data['placedata']["cs_code"]
            ]);

            //旧DBにcustomers_handy登録
							$connection->insert('customers_handy', [
									'place_deliver_id' => $data['cs_handydata']["place_deliver_code"],
									'name' => $data['cs_handydata']["name"],
									'flag' => $data['cs_handydata']["flag"]
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

    }

    public function yobidashi()
		{
      $PlaceDeliver = $this->PlaceDelivers->newEntity();//newEntityを作成
			$this->set('PlaceDeliver', $PlaceDeliver);//1行上の$customerをctpで使えるようにセット

      $PlaceDelivers = $this->PlaceDelivers->find()->order(["cs_code"=>"ASC"]);
      $this->set('PlaceDelivers',$PlaceDelivers);
		}

}
