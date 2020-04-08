<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション
use Cake\ORM\TableRegistry;//独立したテーブルを扱う

/**
 * MaterialTypes Controller
 *
 * @property \App\Model\Table\MaterialTypesTable $MaterialTypes
 *
 * @method \App\Model\Entity\MaterialType[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MaterialTypesController extends AppController
{

	public $paginate = [//ページネーションを定義（indexで使う）
		'limit' => 20,//データを1ページに20個ずつ表示する
		'conditions' => ['delete_flag' => '0']//'delete_flag' => '0'を満たすものだけ表示する
	];

	public function initialize()
	{
		 parent::initialize();
		 $this->Users = TableRegistry::get('users');//staffsテーブルを使う
	}
/*
	public function getRemoteData()//Tableのコードのみでデータベースが決まる。関係なし…
	{
		$conn1 = ConnectionManager::get('default');//local
		$conn2 = ConnectionManager::get('DB_sakae');//192
		$conn3 = ConnectionManager::get('test_desktop');//test_desktop
    $this->MaterialTypes = TableRegistry::get('material_types', ['table' => 'sakaedb', 'connection' => $conn3]);
	}
*/
    public function index()
    {
//			$this->MaterialTypes->defaultConnectionName('default');//local
//			$this->MaterialTypes->defaultConnectionName('DB_sakae');//192
//			$this->MaterialTypes->defaultConnectionName('test_desktop');//test_desktop
			$this->set('materialType', $this->MaterialTypes->find('all'));//テーブルから'delete_flag' => '0'となるものを見つける※ページネーションに条件を追加してある
			$this->set('materialType', $this->paginate());//※ページネーションに必要
    }

    public function form()
    {
	$materialType = $this->MaterialTypes->newEntity();//newentityに$materialTypeという名前を付ける
	$this->set('materialType',$materialType);//1行上の$materialTypeをctpで使えるようにセット
    }

     public function confirm()
    {
			$materialType = $this->MaterialTypes->newEntity();//newentityに$materialTypeという名前を付ける
			$this->set('materialType',$materialType);//1行上の$materialTypeをctpで使えるようにセット
    }

		public function preadd()
		{
			$materialType = $this->MaterialTypes->newEntity();//newentityに$materialTypeという名前を付ける
			$this->set('materialType',$materialType);//1行上の$materialTypeをctpで使えるようにセット
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
			$materialType = $this->MaterialTypes->newEntity();//newentityに$materialTypeという名前を付ける
			$this->set('materialType',$materialType);//1行上の$materialTypeをctpで使えるようにセット

			$session = $this->request->getSession();
			$data = $session->read();//postデータ取得し、$dataと名前を付ける

			$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
			$data['materialTypedata']['created_staff'] = $staff_id;//$userのcreated_staffを$staff_idにする
		/*
			echo "<pre>";
		 	print_r($data['materialTypedata']);
			echo "</pre>";
		*/
			if ($this->request->is('get')) {//postの場合
				$supplierSection = $this->MaterialTypes->patchEntity($materialType, $data['materialTypedata']);//$materialTypeデータ（空の行）を$this->request->getData()に更新する
				$connection = ConnectionManager::get('default');//トランザクション1
				// トランザクション開始2
				$connection->begin();//トランザクション3
				try {//トランザクション4
					if ($this->MaterialTypes->save($materialType)) {
						$mes = "※下記のように登録されました";
						$this->set('mes',$mes);
						$connection->commit();// コミット5
					} else {
						$mes = "※登録されませんでした";
						$this->set('mes',$mes);
						$this->Flash->error(__('The materialType could not be saved. Please, try again.'));
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
			$materialType = $this->MaterialTypes->newEntity();//newentityに$materialTypeという名前を付ける
			$this->set('materialType',$materialType);//1行上の$materialTypeをctpで使えるようにセット
			$materialType = $this->MaterialTypes->get($id);//選んだidに関するMaterialTypesテーブルのデータに$materialTypeと名前を付ける
			$this->set('materialType',$materialType);//1行上の$materialTypeをctpで使えるようにセット

			$data = $this->request->getData();
/*
			echo "<pre>";
		 	print_r($data);
			echo "</pre>";
/*
	if ($this->request->is(['patch', 'post', 'put'])) {//'patch', 'post', 'put'の場合

			$this->MaterialTypes->updateAll(
				//			['name' => 1 ,'name' => $KariKadouSeikeistarting_tm ,'created_at' => $KariKadouSeikeicreated_at ,'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => $this->Auth->user('staff_id')],//この方法だとupdated_atは自動更新されない
			['name' => $data['name'] ,'delete_flag' => $data['delete_flag']],
			['id'   => $data['id'] ]
			);
*/
/*
			if ($this->request->is(['patch', 'post', 'put'])) {//'patch', 'post', 'put'の場合

				$materialType = $this->MaterialTypes->patchEntity($materialType, $data);//98行目でとったもともとの$materialTypeデータを$this->request->getData()に更新する
				$connection = ConnectionManager::get('default');//トランザクション1
					// トランザクション開始2
				$connection->begin();//トランザクション3
				try {//トランザクション4
					if ($this->MaterialTypes->save($materialType)) {
						$this->Flash->success(__('The materialType has been updated.'));
						$connection->commit();// コミット5
						return $this->redirect(['action' => 'index']);
					} else {
						$this->Flash->error(__('The materialType could not be updated. Please, try again.'));
						throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
					}
				} catch (Exception $e) {//トランザクション7
				//ロールバック8
					$connection->rollback();//トランザクション9
				}//トランザクション10
			}
*/

			if ($this->request->is(['patch', 'post', 'put'])) {//'patch', 'post', 'put'の場合
				$connection = ConnectionManager::get('default');//トランザクション1
					// トランザクション開始2
				$connection->begin();//トランザクション3
				try {//トランザクション4
					if ($this->MaterialTypes->updateAll(['name' => $data['name'] ,'delete_flag' => $data['delete_flag']],['id' => $data['id']])) {
						$this->Flash->success(__('The materialType has been updated.'));
						$connection->commit();// コミット5
						return $this->redirect(['action' => 'index']);
					} else {
						$this->Flash->error(__('The materialType could not be updated. Please, try again.'));
						throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
					}
				} catch (Exception $e) {//トランザクション7
				//ロールバック8
					$connection->rollback();//トランザクション9
				}//トランザクション10
			}

    }

}
