<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

/**
 * Roles Controller
 *
 * @property \App\Model\Table\RolesTable $Roles
 *
 * @method \App\Model\Entity\Role[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RolesController extends AppController
{

	public $paginate = [//ページネーションを定義（indexで使う）
		'limit' => 20,//データを1ページに20個ずつ表示する
		'conditions' => ['delete_flag' => '0'],//'delete_flag' => '0'を満たすものだけ表示する
		'order' => ['role_code' => 'asc']//role_code順に並べる
	];

     public function initialize()
     {
			 parent::initialize();
		 	$this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
		 	$this->Users = TableRegistry::get('users');//staffsテーブルを使う
     }

    public function index()
    {
			$this->set('roles', $this->Roles->find('all'));//テーブルから'delete_flag' => '0'となるものを見つける※ページネーションに条件を追加してある
			$this->set('roles', $this->paginate());//定義したページネーションを使用
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
			$role = $this->Roles->newEntity();//newentityに$roleという名前を付ける
			$this->set('role',$role);//1行上の$roleをctpで使えるようにセット
			$created_staff = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$created_staffという名前を付ける
			$role['created_staff'] = $created_staff;//$roleのcreated_staffを$staff_idにする
    }

     public function confirm()
    {
			$role = $this->Roles->newEntity();//newentityに$roleという名前を付ける
			$this->set('role',$role);//1行上の$roleをctpで使えるようにセット
    }

		public function preadd()
		{
			$role = $this->Roles->newEntity();//newentityに$roleという名前を付ける
			$this->set('role',$role);//1行上の$roleをctpで使えるようにセット
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
			$role = $this->Roles->newEntity();//newentityに$roleという名前を付ける
			$this->set('role',$role);//1行上の$roleをctpで使えるようにセット

	//		$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
			$session = $this->request->getSession();
			$data = $session->read();//postデータ取得し、$dataと名前を付ける

			$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
			$data['roledata']['created_staff'] = $staff_id;//$userのcreated_staffを$staff_idにする

			$created_staff = $data['roledata']['created_staff'];//$dataのcreated_staffに$created_staffという名前を付ける
			$Created = $this->Staffs->find()->where(['id' => $created_staff])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
			$CreatedStaff = $Created[0]->f_name.$Created[0]->l_name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
			$this->set('CreatedStaff',$CreatedStaff);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット

			if ($this->request->is('get')) {//postの場合
				$role = $this->Roles->patchEntity($role, $data['roledata']);//$roleデータ（空の行）を$this->request->getData()に更新する
				$connection = ConnectionManager::get('default');//トランザクション1
				// トランザクション開始2
				$connection->begin();//トランザクション3
				try {//トランザクション4
					if ($this->Roles->save($role)) {
						$mes = "※下記のように登録されました";
						$this->set('mes',$mes);
						$connection->commit();// コミット5
					} else {
						$mes = "※登録されませんでした";
						$this->set('mes',$mes);
						$this->Flash->error(__('The role could not be saved. Please, try again.'));
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
			$role = $this->Roles->get($id);//選んだidに関するRolesテーブルのデータに$roleと名前を付ける
			$this->set('role',$role);//1行上の$roleをctpで使えるようにセット
			$updated_staff = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
			$role['updated_staff'] = $updated_staff;//$roleのupdated_staffを$staff_idにする

			if ($this->request->is(['patch', 'post', 'put'])) {//'patch', 'post', 'put'の場合
				$role = $this->Roles->patchEntity($role, $this->request->getData());//106行目でとったもともとの$roleデータを$this->request->getData()に更新する
				$connection = ConnectionManager::get('default');//トランザクション1
					// トランザクション開始2
				$connection->begin();//トランザクション3
				try {//トランザクション4
					if ($this->Roles->save($role)) {
						$this->Flash->success(__('The role has been updated.'));
						$connection->commit();// コミット5
						return $this->redirect(['action' => 'index']);
					} else {
						$this->Flash->error(__('The role could not be updated. Please, try again.'));
						throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
					}
				} catch (Exception $e) {//トランザクション7
				//ロールバック8
					$connection->rollback();//トランザクション9
				}//トランザクション10
			}

    }

}
