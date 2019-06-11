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

    public function form()
    {
    	$data = $this->request->getData();//postの全データを取得
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
    }

     public function do()
    {
	$customersHandy = $this->CustomersHandy->newEntity();//newentityに$customersHandyという名前を付ける
    $this->set('customersHandy',$customersHandy);//1行上の$customersHandyをctpで使えるようにセット

	$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
	$created_staff = $data['created_staff'];//$dataのcreated_staffに$created_staffという名前を付ける
	$Created = $this->Staffs->find()->where(['id' => $created_staff])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
	$CreatedStaff = $Created[0]->f_name.$Created[0]->l_name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
	$this->set('CreatedStaff',$CreatedStaff);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット

    	if ($this->request->is('post')) {//postの場合
    		$customersHandy = $this->CustomersHandy->patchEntity($customersHandy, $this->request->getData());//$customersHandyデータ（空の行）を$this->request->getData()に更新する
    		$connection = ConnectionManager::get('default');//トランザクション1
    		// トランザクション開始2
    		$connection->begin();//トランザクション3
    		try {//トランザクション4
    			if ($this->CustomersHandy->save($customersHandy)) {
    				$connection->commit();// コミット5
    			} else {
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
