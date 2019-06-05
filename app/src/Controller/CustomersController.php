<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

/**
 * Customers Controller
 *
 * @property \App\Model\Table\CustomersTable $Customers
 *
 * @method \App\Model\Entity\Customer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CustomersController extends AppController
{

	public $paginate = [//ページネーション※この設定にするには39行目も必要
	        'limit' => 20,//データを1ページに20個ずつ表示する
			'conditions' => ['delete_flag' => '0']//'delete_flag' => '0'を満たすものだけ表示する
			];
    
     public function initialize()
     {
        parent::initialize();
         $this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
     }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
	$this->set('customers', $this->Customers->find('all'));//Customersテーブルから'delete_flag' => '0'となるものを見つける※ページネーションに条件を追加してある
	$this->set('customers', $this->paginate());//※ページネーションを使う
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
        $this->request->session()->destroy(); //セッションの破棄
        return $this->redirect($this->Auth->logout()); // ログアウト処理
    }

    public function form()
    {
	$customer = $this->Customers->newEntity();//newentityに$customerという名前を付ける
    $this->set('customer', $customer);//1行上の$customerをctpで使えるようにセット

	$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
	$customer['created_staff'] = $staff_id;//$customerのcreated_staffを$staff_idにする
    }

     public function confirm()
    {
	$customer = $this->Customers->newEntity();//newEntityを作成
    $this->set('customer', $customer);//1行上の$customerをctpで使えるようにセット
    }

     public function do()
    {
	$customer = $this->Customers->newEntity();//newEntityを作成
    $this->set('customer', $customer);//1行上の$customerをctpで使えるようにセット

	$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
	$created_staff = $data['created_staff'];//$dataのcreated_staffに$created_staffという名前を付ける
	$Created = $this->Staffs->find()->where(['id' => $created_staff])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
	$CreatedStaff = $Created[0]->f_name.$Created[0]->l_name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
	$this->set('CreatedStaff',$CreatedStaff);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット

		if ($this->request->is('post')) {//postの場合
			$customer = $this->Customers->patchEntity($customer, $this->request->getData());//$customerデータ（空の行）を$this->request->getData()に更新する
			$connection = ConnectionManager::get('default');//トランザクション1
			// トランザクション開始2
			$connection->begin();//トランザクション3
			try {//トランザクション4
				if ($this->Customers->save($customer)) {//
					$connection->commit();// コミット5
				} else {
					$this->Flash->error(__('The user could not be saved. Please, try again.'));
					throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
				}
			} catch (Exception $e) {//トランザクション7
			//ロールバック8
				$connection->rollback();//トランザクション9
			}//トランザクション10
		}
    }

     public function confirmcsv()//「出荷検査表登録」確認画面
    {
	$customer = $this->Customers->newEntity();//newentityに$supplierという名前を付ける
	$this->set('customer',$customer);//1行上の$supplierをctpで使えるようにセット
	
    $staff_id = $this->Auth->user('staff_id');
	$this->set('staff_id',$staff_id);//1行上の$supplierをctpで使えるようにセット

    $fp = fopen("customer.csv", "r");//csvファイルはwebrootに入れる
    $this->set('fp',$fp);
                    
    $fpcount = fopen("customer.csv", 'r' );
    for( $count = 0; fgets( $fpcount ); $count++ );
        $this->set('count',$count);
        
        $arrFp = array();//空の配列を作る
//        $line = fgets($fp);//ファイル$fpの上の１行を取る（１行目）
        for ($k=1; $k<=$count; $k++) {//行数分
            $line = fgets($fp);//ファイル$fpの上の１行を取る（２行目から）
            $sample = explode(',',$line);//$lineを","毎に配列に入れる
                       
            $keys=array_keys($sample);
            $keys[array_search('0',$keys)]='customer_code';//名前の変更
            $keys[array_search('1',$keys)]='name';
            $keys[array_search('2',$keys)]='yuubin';
            $keys[array_search('3',$keys)]='address';
            $keys[array_search('4',$keys)]='tel';
            $keys[array_search('5',$keys)]='fax';
            $keys[array_search('7',$keys)]='delete_flag';
            $sample = array_combine( $keys, $sample );
                        
            unset($sample['6']);//削除

            $arrFp[] = $sample;//配列に追加する
        }
        $this->set('arrFp',$arrFp);//$arrFpをctpで使用できるようセット
//            	    echo "<pre>";
//                    print_r($arrFp);
//                    echo "<br>";
    }

     public function docsv()
    {
	$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
//            	    echo "<pre>";
//                    print_r($data);
//                    var_dump($data);
//                    echo "<br>";

	$customer = $this->Customers->newEntity();//newentityに$userという名前を付ける
	$this->set('customer',$customer);//1行上の$userをctpで使えるようにセット

			if ($this->request->is('post')) {//postなら登録
				$customer = $this->Customers->patchEntities($customer, $this->request->getData('customerdata'));//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
				$connection = ConnectionManager::get('default');//トランザクション1
				// トランザクション開始2
				$connection->begin();//トランザクション3
				try {//トランザクション4
						if ($this->Customers->saveMany($customer)) {//saveManyで一括登録
							$connection->commit();// コミット5
						} else {
							$this->Flash->error(__('The Customers could not be saved. Please, try again.'));
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
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
	$customer = $this->Customers->get($id);//選んだidに関するCustomersテーブルのデータに$customerと名前を付ける
    $this->set('customer', $customer);//114行の$customerをctpで使えるようにセット

	$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
	$customer['updated_staff'] = $staff_id;//$customerのupdated_staffを$staff_idにする

		if ($this->request->is(['patch', 'post', 'put'])) {//'patch', 'post', 'put'の場合
			$customer = $this->Customers->patchEntity($customer, $this->request->getData());//3行上でとったもともとの$customerデータを$this->request->getData()に更新する
			$connection = ConnectionManager::get('default');//トランザクション1
				// トランザクション開始2
			$connection->begin();//トランザクション3
			try {//トランザクション4
				if ($this->Customers->save($customer)) {//saveできた場合
					$this->Flash->success(__('The customer has been updated.'));
					$connection->commit();// コミット5
					return $this->redirect(['action' => 'index']);//処理が終わったらindexへ移動
				} else {//saveできなかった場合
					$this->Flash->error(__('The customer could not be updated. Please, try again.'));
					throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
				}
			} catch (Exception $e) {//トランザクション7
			//ロールバック8
				$connection->rollback();//トランザクション9
			}//トランザクション10
		}
    }

}
