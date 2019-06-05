<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

	public $paginate = [//ページネーションを定義（indexで使う）
	        'limit' => 20,//データを1ページに20個ずつ表示する
			'conditions' => ['delete_flag' => '0']//'delete_flag' => '0'を満たすものだけ表示する
	    ];

     public function initialize()
     {
	parent::initialize();
	$this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
	$this->Roles = TableRegistry::get('roles');//rolesテーブルを使う
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

    public function index()
    {
	$this->set('users', $this->Users->find('all'));//テーブルから'delete_flag' => '0'となるものを見つける※ページネーションに条件を追加してある
	$this->set('users', $this->paginate());//定義したページネーションを使用
    }

    public function form()
    {
	$user = $this->Users->newEntity();//newentityに$userという名前を付ける
    $this->set('user',$user);//1行上の$userをctpで使えるようにセット

	$arrStaffs = $this->Staffs->find('all', ['conditions' => ['delete_flag' => '0']])->order(['staff_code' => 'ASC']);//Staffsテーブルの'delete_flag' => '0'となるものを見つけ、id順に並べる
	$arrStaff = array();//配列の初期化
	foreach ($arrStaffs as $value) {//2行上のStaffsテーブルのデータそれぞれに対して
		$arrStaff[] = array($value->id=>$value->staff_code.':'.$value->f_name.$value->l_name);//配列に3行上のStaffsテーブルのデータそれぞれのstaff_code:f_name:l_name
	}
	$this->set('arrStaff',$arrStaff);//4行上$arrStaffをctpで使えるようにセット

	$arrRoles = $this->Roles->find('all', ['conditions' => ['delete_flag' => '0']])->order(['role_code' => 'ASC']);//Rolesテーブルの'delete_flag' => '0'となるものを見つけ、id順に並べる
	$arrRole = array();
	foreach ($arrRoles as $value) {//2行上のRolesテーブルのデータそれぞれに対して
		$arrRole[] = array($value->id=>$value->role_code.':'.$value->name);//配列に3行上のRolesテーブルのデータそれぞれのrole_code:name
	}
	$this->set('arrRole',$arrRole);//4行上$arrRoleをctpで使えるようにセット

	$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
	$user['created_staff'] = $staff_id;//$userのcreated_staffを$staff_idにする
    }

     public function confirm()
    {
	$user = $this->Users->newEntity();//newentityに$userという名前を付ける
    $this->set('user',$user);//1行上の$userをctpで使えるようにセット
    }

     public function do()
    {
	$user = $this->Users->newEntity();//newentityに$userという名前を付ける
    $this->set('user',$user);//1行上の$userをctpで使えるようにセット

	$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
	$created_staff = $data['created_staff'];//$dataのcreated_staffに$created_staffという名前を付ける
	$Created = $this->Staffs->find()->where(['id' => $created_staff])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
	$CreatedStaff = $Created[0]->f_name.$Created[0]->l_name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
	$this->set('CreatedStaff',$CreatedStaff);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット

	if ($this->request->is('post')) {
		$user = $this->Users->patchEntity($user, $this->request->getData());
		$connection = ConnectionManager::get('default');//トランザクション1
		// トランザクション開始2
		$connection->begin();//トランザクション3
		try {//トランザクション4
			if ($this->Users->save($user)) {
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
	$this->set(compact('user'));
    }

     public function confirmcsv()//「出荷検査表登録」確認画面
    {
	$user = $this->Users->newEntity();//newentityに$userという名前を付ける
	$this->set('user',$user);//1行上の$userをctpで使えるようにセット

    $fp = fopen("staffs.csv", "r");//csvファイルはwebrootに入れる
    $this->set('fp',$fp);
                    
    $fpcount = fopen("staffs.csv", 'r' );
    for( $count = 0; fgets( $fpcount ); $count++ );
        $this->set('count',$count);
        
        $arrFp = array();//空の配列を作る
//        $line = fgets($fp);//ファイル$fpの上の１行を取る（１行目）
        for ($k=1; $k<=$count; $k++) {//行数分
            $line = fgets($fp);//ファイル$fpの上の１行を取る（２行目から）
            $sample = explode(',',$line);//$lineを","毎に配列に入れる
                        
            $keys=array_keys($sample);
            $keys[array_search('3',$keys)]='username';//名前の変更
            $keys[array_search('4',$keys)]='password';
            $keys[array_search('0',$keys)]='staff_code';
            $sample = array_combine( $keys, $sample );
                        
            unset($sample['1']);//削除
            unset($sample['2']);//削除
                        
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
            	    echo "<pre>";
//                    print_r($data);
                    var_dump($data);
                    echo "<br>";

	$user = $this->Users->newEntity();//newentityに$userという名前を付ける
	$this->set('user',$user);//1行上の$userをctpで使えるようにセット

			if ($this->request->is('post')) {//postなら登録
				$user = $this->Users->patchEntities($user, $this->request->getData('userdata'));//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
				$connection = ConnectionManager::get('default');//トランザクション1
				// トランザクション開始2
				$connection->begin();//トランザクション3
				try {//トランザクション4
						if ($this->Users->saveMany($user)) {//saveManyで一括登録
							$connection->commit();// コミット5
						} else {
							$this->Flash->error(__('The Users could not be saved. Please, try again.'));
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
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
	$user = $this->Users->get($id);//選んだidに関するUsersテーブルのデータに$userと名前を付ける
    $this->set('user',$user);//1行上の$userをctpで使えるようにセット

	$arrStaffs = $this->Staffs->find('all', ['conditions' => ['delete_flag' => '0']])->order(['staff_code' => 'ASC']);//Staffsテーブルの'delete_flag' => '0'となるものを見つけ、id順に並べる
	$arrStaff = array();//配列の初期化
	foreach ($arrStaffs as $value) {//2行上のStaffsテーブルのデータそれぞれに対して
		$arrStaff[] = array($value->id=>$value->staff_code.':'.$value->f_name.$value->l_name);//配列に3行上のStaffsテーブルのデータそれぞれのstaff_code:f_name:l_name
	}
	$this->set('arrStaff',$arrStaff);//4行上$arrStaffをctpで使えるようにセット

	$arrRoles = $this->Roles->find('all', ['conditions' => ['delete_flag' => '0']])->order(['role_code' => 'ASC']);//Rolesテーブルの'delete_flag' => '0'となるものを見つけ、id順に並べる
	$arrRole = array();
	foreach ($arrRoles as $value) {//2行上のRolesテーブルのデータそれぞれに対して
		$arrRole[] = array($value->id=>$value->role_code.':'.$value->name);//配列に3行上のRolesテーブルのデータそれぞれのrole_code:name
	}
	$this->set('arrRole',$arrRole);//4行上$arrRoleをctpで使えるようにセット

	$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
	$user['updated_staff'] = $staff_id;//$userのupdated_staffを$staff_idにする

		if ($this->request->is(['patch', 'post', 'put'])) {//'patch', 'post', 'put'の場合
			$user = $this->Users->patchEntity($user, $this->request->getData());//125行目でとったもともとの$priceProductデータを$this->request->getData()に更新する
			$connection = ConnectionManager::get('default');//トランザクション1
				// トランザクション開始2
			$connection->begin();//トランザクション3
			try {//トランザクション4
				if ($this->Users->save($user)) {
					$this->Flash->success(__('The user has been updated.'));
					$connection->commit();// コミット5
					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->error(__('The user could not be updated. Please, try again.'));
					throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
				}
			} catch (Exception $e) {//トランザクション7
			//ロールバック8
				$connection->rollback();//トランザクション9
			}//トランザクション10
		}
    }
}
