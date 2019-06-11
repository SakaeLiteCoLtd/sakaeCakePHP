<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

/**
 * Delivers Controller
 *
 * @property \App\Model\Table\DeliversTable $Delivers
 *
 * @method \App\Model\Entity\Deliver[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DeliversController extends AppController
{
	public $paginate = [//ページネーション※この設定にするには34行目も必要
	        'limit' => 20,//データを1ページに20個ずつ表示する
			'conditions' => ['delete_flag' => '0']//'delete_flag' => '0'を満たすものだけ表示する
	    ];

     public function initialize()
     {
        parent::initialize();
         $this->Staffs = TableRegistry::get('staffs');//Staffs,staffsテーブルを使う
         $this->Customers = TableRegistry::get('customers');//Customers,customersテーブルを使う
     }

    public function index()
    {
        $this->set('delivers', $this->Delivers->find('all'));//テーブルから'delete_flag' => '0'となるものを見つける※ページネーションに条件を追加してある
		$this->set('delivers', $this->paginate());//※ページネーションを使う
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
		$data = $this->request->getData();//postの全データを取得
		$deliver = $this->Delivers->newEntity();//newentityに$customersHandyという名前を付ける
	    $this->set('deliver',$deliver);//1行上の$deliverをctpで使えるようにセット

        $arrCustomers = $this->Customers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['customer_code' => 'ASC']);//Customersテーブルの'delete_flag' => '0'となるものを見つけ、customer_code順に並べる
        $arrCustomer = array();//配列の初期化
        foreach ($arrCustomers as $value) {//2行上のCustomersテーブルのデータそれぞれに対して
            $arrCustomer[] = array($value->id=>$value->customer_code.':'.$value->name);//配列に3行上のCustomersテーブルのデータそれぞれのcustomer_code:nameの形で配列に追加
        }
        $this->set('arrCustomer',$arrCustomer);//4行上$arrCustomerをctpで使えるようにセット

    	$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
		$deliver['created_staff'] = $staff_id;//$deliverのupdated_staffを$staff_idにする
    }

     public function confirm()
    {
	$deliver = $this->Delivers->newEntity();//newentityに$deliverという名前を付ける
	$this->set('deliver',$deliver);//1行上の$deliverをctpで使えるようにセット
    }

     public function do()
    {
	$deliver = $this->Delivers->newEntity();//newentityに$deliverという名前を付ける
	$this->set('deliver',$deliver);//1行上の$deliverをctpで使えるようにセット

	$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
	$created_staff = $data['created_staff'];//$dataのcreated_staffに$created_staffという名前を付ける
	$Created = $this->Staffs->find()->where(['id' => $created_staff])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
	$CreatedStaff = $Created[0]->f_name.$Created[0]->l_name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
	$this->set('CreatedStaff',$CreatedStaff);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット

		if ($this->request->is('post')) {//postの場合
			$deliver = $this->Delivers->patchEntity($deliver, $this->request->getData());//$deliverデータ（空の行）を$this->request->getData()に更新する
			$connection = ConnectionManager::get('default');//トランザクション1
			// トランザクション開始2
			$connection->begin();//トランザクション3
			try {//トランザクション4
				if ($this->Delivers->save($deliver)) {
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

    public function edit($id = null)
    {
	$deliver = $this->Delivers->get($id);//選んだidに関するDeliversテーブルのデータに$deliverと名前を付ける
	$this->set('deliver',$deliver);//1行上の$deliverをctpで使えるようにセット

        $arrCustomers = $this->Customers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['id' => 'ASC']);//Customersテーブルの'delete_flag' => '0'となるものを見つけ、id順に並べる
        $arrCustomer = array();//配列の初期化
        foreach ($arrCustomers as $value) {//2行上のCustomersテーブルのデータそれぞれに対して
            $arrCustomer[] = array($value->id=>$value->customer_code.':'.$value->name);//配列に3行上のCustomersテーブルのデータそれぞれのcustomer_code:nameの形で配列に追加
        }
        $this->set('arrCustomer',$arrCustomer);//4行上$arrCustomerをctpで使えるようにセット

		$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
		$deliver['updated_staff'] = $staff_id;//$customerのupdated_staffを$staff_idにする

		if ($this->request->is(['patch', 'post', 'put'])) {//'patch', 'post', 'put'の場合
			$deliver = $this->Delivers->patchEntity($deliver, $this->request->getData());//110行目でとったもともとの$deliverデータを$this->request->getData()に更新する
			$connection = ConnectionManager::get('default');//トランザクション1
				// トランザクション開始2
			$connection->begin();//トランザクション3
			try {//トランザクション4
				if ($this->Delivers->save($deliver)) {
					$this->Flash->success(__('The deliver has been updated.'));
					$connection->commit();// コミット5
					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->error(__('The deliver could not be updated. Please, try again.'));
					throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
				}
			} catch (Exception $e) {//トランザクション7
			//ロールバック8
				$connection->rollback();//トランザクション9
			}//トランザクション10
		}
    }
}
