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

    public function form()
    {
    	$priceProduct = $this->PriceProducts->newEntity();//newentityに$priceProductという名前を付ける
        $this->set('priceProduct',$priceProduct);//1行上の$priceProductをctpで使えるようにセット

        $arrCustomers = $this->Customers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['customer_code' => 'ASC']);//Customersテーブルの'delete_flag' => '0'となるものを見つけ、id順に並べる
        $arrCustomer = array();//配列の初期化
        foreach ($arrCustomers as $value) {//2行上のCustomersテーブルのデータそれぞれに対して
            $arrCustomer[] = array($value->id=>$value->customer_code.':'.$value->name);//配列に3行上のCustomersテーブルのデータそれぞれのcustomer_code:name
        }
        $this->set('arrCustomer',$arrCustomer);//4行上$arrCustomerをctpで使えるようにセット

        $arrProducts = $this->Products->find('all', ['conditions' => ['delete_flag' => '0']])->order(['product_code' => 'ASC']);//Productsテーブルの'delete_flag' => '0'となるものを見つけ、id順に並べる
        $arrProduct = array();//配列の初期化
        foreach ($arrProducts as $value) {//2行上のProductsテーブルのデータそれぞれに対して
            $arrProduct[] = array($value->id=>$value->product_code.':'.$value->product_name);//配列に3行上のProductsテーブルのデータそれぞれのproduct_code:product_name
        }
        $this->set('arrProduct',$arrProduct);//4行上$arrProductをctpで使えるようにセット

    	$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
    	$priceProduct['created_staff'] = $staff_id;//$priceProductのupdated_staffを$staff_idにする
    }

     public function confirm()
    {
	$priceProduct = $this->PriceProducts->newEntity();//newentityに$priceProductという名前を付ける
    $this->set('priceProduct',$priceProduct);//1行上の$priceProductをctpで使えるようにセット
    }

     public function do()
    {
	$priceProduct = $this->PriceProducts->newEntity();//newentityに$priceProductという名前を付ける
    $this->set('priceProduct',$priceProduct);//1行上の$priceProductをctpで使えるようにセット

	$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
	$created_staff = $data['created_staff'];//$dataのcreated_staffに$created_staffという名前を付ける
	$Created = $this->Staffs->find()->where(['id' => $created_staff])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
	$CreatedStaff = $Created[0]->f_name.$Created[0]->l_name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
	$this->set('CreatedStaff',$CreatedStaff);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット

    	if ($this->request->is('post')) {//postの場合
    		$priceProduct = $this->PriceProducts->patchEntity($priceProduct, $this->request->getData());//$priceProductデータ（空の行）を$this->request->getData()に更新する
    		$connection = ConnectionManager::get('default');//トランザクション1
    		// トランザクション開始2
    		$connection->begin();//トランザクション3
    		try {//トランザクション4
    			if ($this->PriceProducts->save($priceProduct)) {
    				$connection->commit();// コミット5
    			} else {
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

        $arrCustomers = $this->Customers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['customer_code' => 'ASC']);//Customersテーブルの'delete_flag' => '0'となるものを見つけ、id順に並べる
        $arrCustomer = array();//配列の初期化
        foreach ($arrCustomers as $value) {//2行上のCustomersテーブルのデータそれぞれに対して
            $arrCustomer[] = array($value->id=>$value->customer_code.':'.$value->name);//配列に3行上のCustomersテーブルのデータそれぞれのcustomer_code:name
        }
        $this->set('arrCustomer',$arrCustomer);//4行上$arrCustomerをctpで使えるようにセット

        $arrProducts = $this->Products->find('all', ['conditions' => ['delete_flag' => '0']])->order(['product_code' => 'ASC']);//Productsテーブルの'delete_flag' => '0'となるものを見つけ、id順に並べる
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
