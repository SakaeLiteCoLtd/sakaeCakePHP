<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

/**
 * CustomersHandy Controller
 *
 * @property \App\Model\Table\CustomersHandyTable $CustomersHandy
 *
 * @method \App\Model\Entity\CustomersHandy[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CustomersHandyController extends AppController
{

	public $paginate = [//ページネーション※この設定にするには41行目も必要
		'limit' => 20,//データを1ページに20個ずつ表示する
		'conditions' => ['delete_flag' => '0']//'delete_flag' => '0'を満たすものだけ表示する
	];

     public function initialize()
     {
       parent::initialize();
     	$this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
     	$this->Customers = TableRegistry::get('customers');//customersテーブルを使う
     	$this->Delivers = TableRegistry::get('delivers');//deliversテーブルを使う
       $this->Users = TableRegistry::get('users');//staffsテーブルを使う
     }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
	$this->set('customersHandy', $this->CustomersHandy->find('all'));//テーブルから'delete_flag' => '0'となるものを見つける※ページネーションに条件を追加してある
	$this->set('customersHandy', $this->paginate());//※ページネーションを使う
    }
/*
    public function login()//login画面
    {
	if ($this->request->is('post')) {
		$user = $this->Auth->identify();
			if ($user) {
				$this->Auth->setUser($user);
				return $this->redirect($this->Auth->redirectUrl());
			}
			$this->Flash->error(__('Invalid username or password, try again'));
	}
    }

    public function logout()
    {
	$this->request->session()->destroy(); // セッションの破棄
	return $this->redirect($this->Auth->logout()); // ログアウト処理
    }
*/
    public function form()
    {
//	$data = $this->request->getData();//postの全データを取得
	$customersHandy = $this->CustomersHandy->newEntity();//newentityに$customersHandyという名前を付ける
	$this->set('customersHandy',$customersHandy);//1行上の$customersHandyをctpで使えるようにセット

	$arrCustomers = $this->Customers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['customer_code' => 'ASC']);//Customersテーブルの'delete_flag' => '0'となるものを見つけ、id順に並べる
	$arrCustomer = array();//配列の初期化
	foreach ($arrCustomers as $value) {//2行上のCustomersテーブルのデータそれぞれに対して
		$arrCustomer[] = array($value->id=>$value->customer_code.':'.$value->name);//配列に3行上のCustomersテーブルのデータそれぞれのcustomer_code:nameの形で配列に追加
	}
	$this->set('arrCustomer',$arrCustomer);//4行上$arrCustomerをctpで使えるようにセット

	$arrDelivers = $this->Delivers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['place_deliver_id' => 'ASC']);//Deliversテーブルの'delete_flag' => '0'となるものを見つけ、id順に並べる
	$arrDeliver = array();//配列の初期化
	foreach ($arrDelivers as $value) {//2行上のDeliversテーブルのデータそれぞれに対して
		$arrDeliver[] = array($value->id=>$value->place_deliver_id.':'.$value->name);//配列に3行上のDeliversテーブルのデータそれぞれのplace_deliver_id:nameの形で配列に追加
	}
	$this->set('arrDeliver',$arrDeliver);//4行上$arrDeliverをctpで使えるようにセット

	$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
	$customersHandy['created_staff'] = $staff_id;//$customerのupdated_staffを$staff_idにする
    }

     public function confirm()
    {
	$customersHandy = $this->CustomersHandy->newEntity();//newentityに$customersHandyという名前を付ける
	$this->set('customersHandy',$customersHandy);//1行上の$customersHandyをctpで使えるようにセット

	$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
/*
  echo "<pre>";
  print_r($data);
  echo "<br>";
*/
	$customer_id = $data['customer_id'];//$dataのcustomer_idに$customer_idという名前を付ける
	$customerData = $this->Customers->find()->where(['id' => $customer_id])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
	$Customer = $customerData[0]->customer_code.':'.$customerData[0]->name;//配列の0番目（0番目しかない）のnameに$Customerと名前を付ける
	$this->set('Customer',$Customer);//登録者の表示のため1行上の$Customerをctpで使えるようにセット

	$place_deliver_id = $data['place_deliver_id'];//$dataのcustomer_idに$customer_idという名前を付ける
	$place_deliver_idData = $this->Delivers->find()->where(['id' => $place_deliver_id])->toArray();//'id' => $place_deliver_idとなるデータをDeliversテーブルから配列で取得
	$Deliver = $place_deliver_idData[0]->place_deliver_id.':'.$place_deliver_idData[0]->name;//配列の0番目（0番目しかない）のnameに$Deliverと名前を付ける
	$this->set('Deliver',$Deliver);//登録者の表示のため1行上の$Deliverをctpで使えるようにセット
/*
	$created_staff = $data['created_staff'];//$dataのcreated_staffに$created_staffという名前を付ける
	$Created = $this->Staffs->find()->where(['id' => $created_staff])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
	$CreatedStaff = $Created[0]->f_name.$Created[0]->l_name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
	$this->set('CreatedStaff',$CreatedStaff);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット
*/    }

    public function preadd()
		{
      $customersHandy = $this->CustomersHandy->newEntity();//newentityに$customersHandyという名前を付ける
    	$this->set('customersHandy',$customersHandy);//1行上の$customersHandyをctpで使えるようにセット
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
			$customersHandy = $this->CustomersHandy->newEntity();//newentityに$customersHandyという名前を付ける
			$this->set('customersHandy',$customersHandy);//1行上の$customersHandyをctpで使えるようにセット

		  $session = $this->request->getSession();
		  $data = $session->read();//postデータ取得し、$dataと名前を付ける

		  $staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
		  $data['customershandydata']['created_staff'] = $staff_id;//$userのcreated_staffを$staff_idにする

		//	$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける

			$customer_id = $data['customershandydata']['customer_id'];//$dataのcustomer_idに$customer_idという名前を付ける
			$customerData = $this->Customers->find()->where(['id' => $customer_id])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
			$Customer = $customerData[0]->customer_code.':'.$customerData[0]->name;//配列の0番目（0番目しかない）のnameに$Customerと名前を付ける
			$this->set('Customer',$Customer);//登録者の表示のため1行上の$Customerをctpで使えるようにセット

			$place_deliver_id = $data['customershandydata']['place_deliver_id'];//$dataのcustomer_idに$customer_idという名前を付ける
			$place_deliver_idData = $this->Delivers->find()->where(['id' => $place_deliver_id])->toArray();//'id' => $place_deliver_idとなるデータをDeliversテーブルから配列で取得
			$Deliver = $place_deliver_idData[0]->place_deliver_id.':'.$place_deliver_idData[0]->name;//配列の0番目（0番目しかない）のnameに$Deliverと名前を付ける
			$this->set('Deliver',$Deliver);//登録者の表示のため1行上の$Deliverをctpで使えるようにセット

			$customer_id = $data['customershandydata']['customer_id'];//$dataのcustomer_idに$customer_idという名前を付ける
			$customerData = $this->Customers->find()->where(['id' => $customer_id])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
			$Customer = $customerData[0]->customer_code.':'.$customerData[0]->name;//配列の0番目（0番目しかない）のnameに$Customerと名前を付ける
			$this->set('Customer',$Customer);//登録者の表示のため1行上の$Customerをctpで使えるようにセット

			$created_staff = $data['customershandydata']['created_staff'];//$dataのcreated_staffに$created_staffという名前を付ける
			$Created = $this->Staffs->find()->where(['id' => $created_staff])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
			$CreatedStaff = $Created[0]->f_name.$Created[0]->l_name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
			$this->set('CreatedStaff',$CreatedStaff);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット

			if ($this->request->is('get')) {//postの場合
				$customersHandy = $this->CustomersHandy->patchEntity($customersHandy, $data['customershandydata']);//$customersHandyデータ（空の行）を$this->request->getData()に更新する
				$connection = ConnectionManager::get('default');//トランザクション1
				// トランザクション開始2
				$connection->begin();//トランザクション3
				try {//トランザクション4
					if ($this->CustomersHandy->save($customersHandy)) {
						$mes = "※下記のように登録されました";
						$this->set('mes',$mes);
						$connection->commit();// コミット5
					} else {
						$mes = "※登録されませんでした";
						$this->set('mes',$mes);
						$this->Flash->error(__('The deliver could not be saved. Please, try again.'));
						throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
					}
				} catch (Exception $e) {//トランザクション7
				//ロールバック8
					$connection->rollback();//トランザクション9
				}//トランザクション10
			}
    }


    /**
     * Edit method
     *
     * @param string|null $id Customers Handy id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
	$customersHandy = $this->CustomersHandy->get($id);//選んだidに関するCustomersHandyテーブルのデータに$customersHandyと名前を付ける
	$this->set('customersHandy',$customersHandy);//1行上の$customersHandyをctpで使えるようにセット

	$arrCustomers = $this->Customers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['customer_code' => 'ASC']);//Customersテーブルの'delete_flag' => '0'となるものを見つけ、id順に並べる
	$arrCustomer = array();//配列の初期化
	foreach ($arrCustomers as $value) {//2行上のCustomersテーブルのデータそれぞれに対して
		$arrCustomer[] = array($value->id=>$value->customer_code.':'.$value->name);//配列に3行上のCustomersテーブルのデータそれぞれのcustomer_code:nameの形で配列に追加
	}
	$this->set('arrCustomer',$arrCustomer);//4行上$arrCustomerをctpで使えるようにセット

	$arrDelivers = $this->Delivers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['place_deliver_id' => 'ASC']);//Deliversテーブルの'delete_flag' => '0'となるものを見つけ、id順に並べる
	$arrDeliver = array();//配列の初期化
	foreach ($arrDelivers as $value) {//2行上のDeliversテーブルのデータそれぞれに対して
		$arrDeliver[] = array($value->id=>$value->place_deliver_id.':'.$value->name);//配列に3行上のDeliversテーブルのデータそれぞれのplace_deliver_id:nameの形で配列に追加
	}
	$this->set('arrDeliver',$arrDeliver);//4行上$arrDeliverをctpで使えるようにセット

	$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
	$customersHandy['created_staff'] = $staff_id;//$customerのupdated_staffを$staff_idにする

	if ($this->request->is(['patch', 'post', 'put'])) {//'patch', 'post', 'put'の場合
		$customersHandy = $this->CustomersHandy->patchEntity($customersHandy, $this->request->getData());//132行目でとったもともとの$customersHandyデータを$this->request->getData()に更新する
		$connection = ConnectionManager::get('default');//トランザクション1
			// トランザクション開始2
		$connection->begin();//トランザクション3
		try {//トランザクション4
			if ($this->CustomersHandy->save($customersHandy)) {
				$this->Flash->success(__('The customersHandy has been updated.'));
				$connection->commit();// コミット5
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('The customersHandy could not be updated. Please, try again.'));
				throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
			}
		} catch (Exception $e) {//トランザクション7
		//ロールバック8
			$connection->rollback();//トランザクション9
		}//トランザクション10
	}
    }
}
