<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

/**
 * PriceProducts Controller
 *
 * @property \App\Model\Table\PriceProductsTable $PriceProducts
 *
 * @method \App\Model\Entity\PriceProduct[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PriceProductsController extends AppController
{

	public $paginate = [//ページネーションを定義（indexで使う）
		'limit' => 20,//データを1ページに20個ずつ表示する
		'conditions' => ['delete_flag' => '0']//'delete_flag' => '0'を満たすものだけ表示する
	];

     public function initialize()
     {
			 parent::initialize();
		 	$this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
		 	$this->Products = TableRegistry::get('products');//productsテーブルを使う
		 	$this->Customers = TableRegistry::get('customers');//customersテーブルを使う
			$this->Users = TableRegistry::get('users');//staffsテーブルを使う
     }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
			$this->set('priceProducts', $this->PriceProducts->find('all'));//テーブルから'delete_flag' => '0'となるものを見つける※ページネーションに条件を追加してある
			$this->set('priceProducts', $this->paginate());//定義したページネーションを使用
    }
/*
    public function login()
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
	$priceProduct = $this->PriceProducts->newEntity();//newentityに$priceProductという名前を付ける
	$this->set('priceProduct',$priceProduct);//1行上の$priceProductをctpで使えるようにセット

	$arrCustomers = $this->Customers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['customer_code' => 'ASC']);//Customersテーブルの'delete_flag' => '0'となるものを見つけ、customer_code順に並べる
	$arrCustomer = array();//配列の初期化
	foreach ($arrCustomers as $value) {//2行上のCustomersテーブルのデータそれぞれに対して
		$arrCustomer[] = array($value->id=>$value->customer_code.':'.$value->name);//配列に3行上のCustomersテーブルのデータそれぞれのcustomer_code:name
	}
	$this->set('arrCustomer',$arrCustomer);//4行上$arrCustomerをctpで使えるようにセット

	$arrProducts = $this->Products->find('all', ['conditions' => ['delete_flag' => '0']])->order(['product_code' => 'ASC']);//Productsテーブルの'delete_flag' => '0'となるものを見つけ、product_code順に並べる
	$arrProduct = array();//配列の初期化
	foreach ($arrProducts as $value) {//2行上のProductsテーブルのデータそれぞれに対して
		$arrProduct[] = array($value->id=>$value->product_code.':'.$value->product_name);//配列に3行上のProductsテーブルのデータそれぞれのproduct_code:product_name
	}
	$this->set('arrProduct',$arrProduct);//4行上$arrProductをctpで使えるようにセット

	$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
	$priceProduct['created_staff'] = $staff_id;//$priceProductのcreated_staffを$staff_idにする
    }

     public function confirm()
    {
			$priceProduct = $this->PriceProducts->newEntity();//newentityに$priceProductという名前を付ける
			$this->set('priceProduct',$priceProduct);//1行上の$priceProductをctpで使えるようにセット

			$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける

			$product_id = $data['product_id'];//$dataのproduct_idに$product_idという名前を付ける
			$ProductData = $this->Products->find()->where(['id' => $product_id])->toArray();//'id' => $product_idとなるデータをProductsテーブルから配列で取得
			$Product = $ProductData[0]->product_code.":".$ProductData[0]->product_name;//配列の0番目（0番目しかない）のcustomer_codeとnameをつなげたものに$Productと名前を付ける
			$this->set('Product',$Product);//登録者の表示のため1行上の$Productをctpで使えるようにセット

			$customer_id = $data['customer_id'];//$dataのcreated_staffに$customer_idという名前を付ける
			$CustomerData = $this->Customers->find()->where(['id' => $customer_id])->toArray();//'id' => $customer_idとなるデータをCustomersテーブルから配列で取得
			$Customer = $CustomerData[0]->customer_code.":".$CustomerData[0]->name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
			$this->set('Customer',$Customer);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット
    }

		public function preadd()
		{
			$priceProduct = $this->PriceProducts->newEntity();//newentityに$priceProductという名前を付ける
			$this->set('priceProduct',$priceProduct);//1行上の$priceProductをctpで使えるようにセット
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
	$priceProduct = $this->PriceProducts->newEntity();//newentityに$priceProductという名前を付ける
	$this->set('priceProduct',$priceProduct);//1行上の$priceProductをctpで使えるようにセット

//	$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
	$session = $this->request->getSession();
	$data = $session->read();//postデータ取得し、$dataと名前を付ける

	$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
	$data['priceProductdata']['created_staff'] = $staff_id;//$userのcreated_staffを$staff_idにする

	$product_id = $data['priceProductdata']['product_id'];//$dataのproduct_idに$product_idという名前を付ける
	$ProductData = $this->Products->find()->where(['id' => $product_id])->toArray();//'id' => $product_idとなるデータをProductsテーブルから配列で取得
	$Product = $ProductData[0]->product_code.":".$ProductData[0]->product_name;//配列の0番目（0番目しかない）のcustomer_codeとnameをつなげたものに$Productと名前を付ける
	$this->set('Product',$Product);//登録者の表示のため1行上の$Productをctpで使えるようにセット

	$customer_id = $data['priceProductdata']['customer_id'];//$dataのcreated_staffに$customer_idという名前を付ける
	$CustomerData = $this->Customers->find()->where(['id' => $customer_id])->toArray();//'id' => $customer_idとなるデータをCustomersテーブルから配列で取得
	$Customer = $CustomerData[0]->customer_code.":".$CustomerData[0]->name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
	$this->set('Customer',$Customer);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット

	$created_staff = $data['priceProductdata']['created_staff'];//$dataのcreated_staffに$created_staffという名前を付ける
	$Created = $this->Staffs->find()->where(['id' => $created_staff])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
	$CreatedStaff = $Created[0]->f_name.$Created[0]->l_name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
	$this->set('CreatedStaff',$CreatedStaff);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット

	if ($this->request->is('get')) {//postの場合
		$priceProduct = $this->PriceProducts->patchEntity($priceProduct, $data['priceProductdata']);//$priceProductデータ（空の行）を$this->request->getData()に更新する
		$connection = ConnectionManager::get('default');//トランザクション1
		// トランザクション開始2
		$connection->begin();//トランザクション3
		try {//トランザクション4
			if ($this->PriceProducts->save($priceProduct)) {
				$mes = "※下記のように登録されました";
				$this->set('mes',$mes);
				$connection->commit();// コミット5
			} else {
				$mes = "※登録されませんでした";
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

    /**
     * Edit method
     *
     * @param string|null $id Price Product id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
	$priceProduct = $this->PriceProducts->get($id);//選んだidに関するPriceProductsテーブルのデータに$priceProductと名前を付ける
	$this->set('priceProduct',$priceProduct);//1行上の$priceProductをctpで使えるようにセット

	$arrCustomers = $this->Customers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['customer_code' => 'ASC']);//Customersテーブルの'delete_flag' => '0'となるものを見つけ、customer_code順に並べる
	$arrCustomer = array();//配列の初期化
	foreach ($arrCustomers as $value) {//2行上のCustomersテーブルのデータそれぞれに対して
		$arrCustomer[] = array($value->id=>$value->customer_code.':'.$value->name);//配列に3行上のCustomersテーブルのデータそれぞれのcustomer_code:name
	}
	$this->set('arrCustomer',$arrCustomer);//4行上$arrCustomerをctpで使えるようにセット

	$arrProducts = $this->Products->find('all', ['conditions' => ['delete_flag' => '0']])->order(['product_code' => 'ASC']);//Productsテーブルの'delete_flag' => '0'となるものを見つけ、product_code順に並べる
	$arrProduct = array();//配列の初期化
	foreach ($arrProducts as $value) {//2行上のProductsテーブルのデータそれぞれに対して
		$arrProduct[] = array($value->id=>$value->product_code.':'.$value->product_name);//配列に3行上のProductsテーブルのデータそれぞれのproduct_code:product_name
	}
	$this->set('arrProduct',$arrProduct);//4行上$arrProductをctpで使えるようにセット

	$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
	$priceProduct['created_staff'] = $staff_id;//$priceProductのupdated_staffを$staff_idにする

	if ($this->request->is(['patch', 'post', 'put'])) {//'patch', 'post', 'put'の場合
		$priceProduct = $this->PriceProducts->patchEntity($priceProduct, $this->request->getData());//130行目でとったもともとの$priceProductデータを$this->request->getData()に更新する
		$connection = ConnectionManager::get('default');//トランザクション1
			// トランザクション開始2
		$connection->begin();//トランザクション3
		try {//トランザクション4
			if ($this->PriceProducts->save($priceProduct)) {
				$this->Flash->success(__('The priceProduct has been updated.'));
				$connection->commit();// コミット5
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('The priceProduct could not be updated. Please, try again.'));
				throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
			}
		} catch (Exception $e) {//トランザクション7
		//ロールバック8
			$connection->rollback();//トランザクション9
		}//トランザクション10
	}
    }
}
