<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

/**
 * SupplierSections Controller
 *
 * @property \App\Model\Table\SupplierSectionsTable $SupplierSections
 *
 * @method \App\Model\Entity\SupplierSection[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SupplierSectionsController extends AppController
{
	public $paginate = [//ページネーションを定義（indexで使う）
		'limit' => 20,//データを1ページに20個ずつ表示する
		'conditions' => ['delete_flag' => '0']//'delete_flag' => '0'を満たすものだけ表示する
	];

     public function initialize()
     {
	parent::initialize();
	$this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
	$this->Users = TableRegistry::get('users');//staffsテーブルを使う
     }

    public function index()
    {
	$this->set('supplierSections', $this->SupplierSections->find('all'));//テーブルから'delete_flag' => '0'となるものを見つける※ページネーションに条件を追加してある
	$this->set('supplierSections', $this->paginate());//※ページネーションに必要
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
	$supplierSection = $this->SupplierSections->newEntity();//newentityに$supplierSectionという名前を付ける
	$this->set('supplierSection',$supplierSection);//1行上の$supplierSectionをctpで使えるようにセット

	$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
	$supplierSection['created_staff'] = $staff_id;//$supplierSectionのcreated_staffを$staff_idにする
    }

     public function confirm()
    {
			$supplierSection = $this->SupplierSections->newEntity();//newentityに$supplierSectionという名前を付ける
			$this->set('supplierSection',$supplierSection);//1行上の$supplierSectionをctpで使えるようにセット
    }

		public function preadd()
		{
			$supplierSection = $this->SupplierSections->newEntity();//newentityに$supplierSectionという名前を付ける
			$this->set('supplierSection',$supplierSection);//1行上の$supplierSectionをctpで使えるようにセット
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
	//		$this->request->session()->destroy(); // セッションの破棄
			return $this->redirect(['controller' => 'Shinkies', 'action' => 'index']);//ログアウト後に移るページ
		}

     public function do()
    {
	$supplierSection = $this->SupplierSections->newEntity();//newentityに$supplierSectionという名前を付ける
	$this->set('supplierSection',$supplierSection);//1行上の$supplierSectionをctpで使えるようにセット

	$session = $this->request->getSession();
	$data = $session->read();//postデータ取得し、$dataと名前を付ける

	$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
	$data['supplierSectiondata']['created_staff'] = $staff_id;//$userのcreated_staffを$staff_idにする

//	$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
	$created_staff = $data['supplierSectiondata']['created_staff'];//$dataのcreated_staffに$created_staffという名前を付ける
	$Created = $this->Staffs->find()->where(['id' => $created_staff])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
	$CreatedStaff = $Created[0]->f_name.$Created[0]->l_name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
	$this->set('CreatedStaff',$CreatedStaff);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット

	if ($this->request->is('get')) {
		$supplierSection = $this->SupplierSections->patchEntity($supplierSection, $data['supplierSectiondata']);
		$connection = ConnectionManager::get('default');//トランザクション1
		// トランザクション開始2
		$connection->begin();//トランザクション3
		try {//トランザクション4
			if ($this->SupplierSections->save($supplierSection)) {
				$mes = "※下記のように登録されました";
				$this->set('mes',$mes);
				$connection->commit();// コミット5
			} else {
				$mes = "※登録されませんでした";
				$this->set('mes',$mes);
				$this->Flash->error(__('The supplier could not be saved. Please, try again.'));
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
     * @param string|null $id Supplier Section id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
	$supplierSection = $this->SupplierSections->get($id);//選んだidに関するSupplierSectionsテーブルのデータに$supplierSectionと名前を付ける
	$this->set('supplierSection',$supplierSection);//1行上の$supplierSectionをctpで使えるようにセット
	$updated_staff = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
	$supplierSection['updated_staff'] = $updated_staff;//$productのupdated_staffを$staff_idにする

	if ($this->request->is(['patch', 'post', 'put'])) {//'patch', 'post', 'put'の場合
		$supplierSection = $this->SupplierSections->patchEntity($supplierSection, $this->request->getData());//109行目でとったもともとの$supplierSectionデータを$this->request->getData()に更新する
		$connection = ConnectionManager::get('default');//トランザクション1
			// トランザクション開始2
		$connection->begin();//トランザクション3
		try {//トランザクション4
			if ($this->SupplierSections->save($supplierSection)) {
				$this->Flash->success(__('The supplier section has been updated.'));
				$connection->commit();// コミット5
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('The supplierSection could not be updated. Please, try again.'));
				throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
			}
		} catch (Exception $e) {//トランザクション7
		//ロールバック8
			$connection->rollback();//トランザクション9
		}//トランザクション10
	}
    }
}
