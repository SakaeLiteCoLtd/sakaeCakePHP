<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション
use Cake\Auth\DefaultPasswordHasher;//

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
		'conditions' => ['delete_flag' => '1']//'delete_flag' => '1'を満たすものだけ表示する
	];

     public function initialize()
     {
			parent::initialize();
			$this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
			$this->Roles = TableRegistry::get('roles');//rolesテーブルを使う
			$this->Products = TableRegistry::get('products');//rolesテーブルを使う
     }

		 public function preadd()
     {
			$user = $this->Users->newEntity();//newentityに$userという名前を付ける
		 	$this->set('user',$user);//1行上の$userをctpで使えるようにセット
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
						$delete_flag = $Userdata[0]->delete_flag;
						$this->set('delete_flag',$delete_flag);
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

    public function index()
    {
	//		$this->request->session()->destroy(); // セッションの破棄

			$this->set('users', $this->Users->find('all'));//テーブルから'delete_flag' => '0'となるものを見つける※ページネーションに条件を追加してある
			$this->set('users', $this->paginate());//定義したページネーションを使用
    }

    public function form()
    {
			$user = $this->Users->newEntity();//newentityに$userという名前を付ける
			$this->set('user',$user);//1行上の$userをctpで使えるようにセット

			$arrStaffs = $this->Staffs->find('all', ['conditions' => ['delete_flag' => '0']])->order(['staff_code' => 'ASC']);//Staffsテーブルの'delete_flag' => '0'となるものを見つけ、staff_code順に並べる
			$arrStaff = array();//配列の初期化
			foreach ($arrStaffs as $value) {//2行上のStaffsテーブルのデータそれぞれに対して
				$arrStaff[] = array($value->id=>$value->staff_code.':'.$value->f_name.$value->l_name);//配列に3行上のStaffsテーブルのデータそれぞれのstaff_code:f_name:l_name
			}
			$this->set('arrStaff',$arrStaff);//4行上$arrStaffをctpで使えるようにセット

			$arrRoles = $this->Roles->find('all', ['conditions' => ['delete_flag' => '0']])->order(['id' => 'ASC']);//Rolesテーブルの'delete_flag' => '0'となるものを見つけ、role_code順に並べる
			$arrRole = array();
			foreach ($arrRoles as $value) {//2行上のRolesテーブルのデータそれぞれに対して
				$arrRole[] = array($value->id=>$value->id.':'.$value->name);//配列に3行上のRolesテーブルのデータそれぞれのrole_code:name
			}
			$this->set('arrRole',$arrRole);//4行上$arrRoleをctpで使えるようにセット

			$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
			$user['created_staff'] = $staff_id;//$userのcreated_staffを$staff_idにする
    }

     public function confirm()
    {
			if(!isset($_SESSION)){//sessionsyuuseituika
      session_start();
      }
      $_SESSION['userdata'] = array();

			$user = $this->Users->newEntity();//newentityに$userという名前を付ける
			$this->set('user',$user);//1行上の$userをctpで使えるようにセット

			$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける

			$role = $data['role_id'];//$dataのrole_idに$roleという名前を付ける
			$roleData = $this->Roles->find()->where(['id' => $role])->toArray();//'id' => $roleとなるデータをRolesテーブルから配列で取得
			$Role = $roleData[0]->name;//配列の0番目（0番目しかない）のnameに$Roleと名前を付ける
			$this->set('Role',$Role);//登録者の表示のため1行上の$Roleをctpで使えるようにセット

			$staff = $data['staff_id'];//
			$staffData = $this->Staffs->find()->where(['id' => $staff])->toArray();//
			$Staff = $staffData[0]->f_name.$staffData[0]->l_name;//
			$this->set('Staff',$Staff);//
    }

     public function do()
    {
			$user = $this->Users->newEntity();//newentityに$userという名前を付ける
			$this->set('user',$user);//1行上の$userをctpで使えるようにセット

			$session = $this->request->getSession();
			$data = $session->read();//postデータ取得し、$dataと名前を付ける

			$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
			$data['userdata']['created_staff'] = $staff_id;//$userのcreated_staffを$staff_idにする
/*
			echo "<pre>";
			print_r($data['userdata']);
			echo "<br>";
*/
			$role = $data['userdata']['role_id'];//$dataのrole_idに$roleという名前を付ける
			$roleData = $this->Roles->find()->where(['id' => $role])->toArray();//'id' => $roleとなるデータをRolesテーブルから配列で取得
			$Role = $roleData[0]->name;//配列の0番目（0番目しかない）のnameに$Roleと名前を付ける
			$this->set('Role',$Role);//登録者の表示のため1行上の$Roleをctpで使えるようにセット

			$staff = $data['userdata']['staff_id'];//
			$staffData = $this->Staffs->find()->where(['id' => $staff])->toArray();//
			$Staff = $staffData[0]->f_name.$staffData[0]->l_name;//
			$this->set('Staff',$Staff);//

			$created_staff = $data['userdata']['created_staff'];//$dataのcreated_staffに$created_staffという名前を付ける
			$Created = $this->Staffs->find()->where(['id' => $created_staff])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
			$CreatedStaff = $Created[0]->f_name.$Created[0]->l_name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
			$this->set('CreatedStaff',$CreatedStaff);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット

			if ($this->request->is('post')) {//postの場合（postではないため、elseへいく）
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
				throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
			}else {
				$user = $this->Users->patchEntity($user, $data['userdata']);
				$connection = ConnectionManager::get('default');//トランザクション1
				// トランザクション開始2
				$connection->begin();//トランザクション3
				try {//トランザクション4
					if ($this->Users->save($user)) {
						$mes = "※下記のように登録されました";
						$this->set('mes',$mes);
						$connection->commit();// コミット5
					} else {
						$mes = "※登録されませんでした";
						$this->set('mes',$mes);
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

     public function confirmcsv()
    {
			$user = $this->Users->newEntity();//newentityに$userという名前を付ける
			$this->set('user',$user);//1行上の$userをctpで使えるようにセット

			$fp = fopen("staffs.csv", "r");//csvファイルはwebrootに入れる
			$this->set('fp',$fp);

			$fpcount = fopen("staffs.csv", 'r' );
			for( $count = 0; fgets( $fpcount ); $count++ );
			$this->set('count',$count);

			$arrFp = array();//空の配列を作る
		//	$line = fgets($fp);//ファイル$fpの上の１行を取る（１行目）
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
    }

     public function docsvmoto()
    {
		//	$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
		//	echo "<pre>";
		// 	print_r($data);
		//	var_dump($data);
		//	echo "<br>";

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

    public function edit($id = null)
    {
			$user = $this->Users->get($id);//選んだidに関するUsersテーブルのデータに$userと名前を付ける
			$this->set('user',$user);//1行上の$userをctpで使えるようにセット

			$arrStaffs = $this->Staffs->find('all', ['conditions' => ['delete_flag' => '0']])->order(['staff_code' => 'ASC']);//Staffsテーブルの'delete_flag' => '0'となるものを見つけ、staff_code順に並べる
			$arrStaff = array();//配列の初期化
			foreach ($arrStaffs as $value) {//2行上のStaffsテーブルのデータそれぞれに対して
				$arrStaff[] = array($value->id=>$value->staff_code.':'.$value->f_name.$value->l_name);//配列に3行上のStaffsテーブルのデータそれぞれのstaff_code:f_name:l_name
			}
			$this->set('arrStaff',$arrStaff);//4行上$arrStaffをctpで使えるようにセット

			$arrRoles = $this->Roles->find('all', ['conditions' => ['delete_flag' => '0']])->order(['id' => 'ASC']);//Rolesテーブルの'delete_flag' => '0'となるものを見つけ、role_code順に並べる
			$arrRole = array();
			foreach ($arrRoles as $value) {//2行上のRolesテーブルのデータそれぞれに対して
				$arrRole[] = array($value->id=>$value->id.':'.$value->name);//配列に3行上のRolesテーブルのデータそれぞれのrole_code:name
			}
			$this->set('arrRole',$arrRole);//4行上$arrRoleをctpで使えるようにセット

				if ($this->request->is(['patch', 'post', 'put'])) {//'patch', 'post', 'put'の場合
					$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
					return $this->redirect(['action' => 'editconfirm',
	        's' => ['id' => $data['id'], 'staff_id' => $data['staff_id'], 'username' => $data['username'], 'created_staff' => $data['created_staff'],
					 'role_id' => $data['role_id'], 'delete_flag' => $data['delete_flag'], 'password' => $data['password']]]);
				}
    }

		public function editconfirm()
	 {
		 $user = $this->Users->newEntity();//newentityに$userという名前を付ける
		 $this->set('user',$user);//1行上の$userをctpで使えるようにセット

		 $data = $this->request->query('s');//1度henkou5panaへ行って戻ってきたとき（検索を押したとき）
/*
		 echo "<pre>";
		 print_r($data);
		 echo "<br>";
*/
		 $role = $data['role_id'];//$dataのrole_idに$roleという名前を付ける
		 $roleData = $this->Roles->find()->where(['id' => $role])->toArray();//'id' => $roleとなるデータをRolesテーブルから配列で取得
		 $Role = $roleData[0]->name;//配列の0番目（0番目しかない）のnameに$Roleと名前を付ける
		 $this->set('Role',$Role);//登録者の表示のため1行上の$Roleをctpで使えるようにセット

		 $staff = $data['staff_id'];//
		 $staffData = $this->Staffs->find()->where(['id' => $staff])->toArray();//
		 $Staff = $staffData[0]->f_name.$staffData[0]->l_name;//
		 $this->set('Staff',$Staff);//
	 }

	 public function editpreadd()
	 {
		$user = $this->Users->newEntity();//newentityに$userという名前を付ける
		$this->set('user',$user);//1行上の$userをctpで使えるようにセット

		$session = $this->request->getSession();
 	 	$data = $session->read();//postデータ取得し、$dataと名前を付ける
	 }

	public function editlogin()
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
					$delete_flag = $Userdata[0]->delete_flag;
					$this->set('delete_flag',$delete_flag);
				}
					$user = $this->Auth->identify();
				if ($user) {
					$this->Auth->setUser($user);
					return $this->redirect(['action' => 'editdo']);
				}
			}
	}

	public function editdo()
 {

	 $user = $this->Users->newEntity();//newentityに$userという名前を付ける
	 $this->set('user',$user);//1行上の$userをctpで使えるようにセット

	 $session = $this->request->getSession();
	 $data = $session->read();//postデータ取得し、$dataと名前を付ける

	 $makepassword = new DefaultPasswordHasher();
	 $password = $makepassword->hash($data['userdata']['password']);
/*
	 echo "<pre>";
	 print_r($password);
	 echo "<br>";
*/
	 $role = $data['userdata']['role_id'];//$dataのrole_idに$roleという名前を付ける
	 $roleData = $this->Roles->find()->where(['id' => $role])->toArray();//'id' => $roleとなるデータをRolesテーブルから配列で取得
	 $Role = $roleData[0]->name;//配列の0番目（0番目しかない）のnameに$Roleと名前を付ける
	 $this->set('Role',$Role);//登録者の表示のため1行上の$Roleをctpで使えるようにセット

	 $staff = $data['userdata']['staff_id'];//
	 $staffData = $this->Staffs->find()->where(['id' => $staff])->toArray();//
	 $Staff = $staffData[0]->f_name.$staffData[0]->l_name;//
	 $this->set('Staff',$Staff);//

	 $created_staff = $data['userdata']['created_staff'];//$dataのcreated_staffに$created_staffという名前を付ける
	 $Created = $this->Staffs->find()->where(['id' => $created_staff])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
	 $CreatedStaff = $Created[0]->f_name.$Created[0]->l_name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
	 $this->set('CreatedStaff',$CreatedStaff);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット

	 if ($this->Users->updateAll(['username' => $data['userdata']['username'] ,'password' => $password, 'delete_flag' => $data['userdata']['delete_flag']
	 ,'role_id' => $data['userdata']['role_id'], 'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $this->Auth->user('staff_id')]
	 ,['id' => $data['userdata']['id']])) {
		 if($data['userdata']['delete_flag'] == 0){
			 $mes = "※削除されました";
			 $this->set('mes',$mes);
		 }else{
			 $mes = "※更新されました";
			 $this->set('mes',$mes);
		 }
	 }else{
		 $mes = "※更新されませんでした";
		 $this->set('mes',$mes);
		 $this->Flash->error(__('The data could not be saved. Please, try again.'));
		 throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
	 }
 }

 public function ryousan()
 {
	 $source_file = $_FILES['file']['tmp_name'];

	 $fp = fopen($source_file, "r");
	 $fpcount = fopen($source_file, 'r' );
		for($count = 0; fgets( $fpcount ); $count++ );
		$arrFp = array();//空の配列を作る
		$arrLot = array();//空の配列を作る
		$created_staff = $this->Auth->user('staff_id');
		for ($k=1; $k<=$count; $k++) {//最後の行まで
			$line = fgets($fp);//ファイル$fpの上の１行を取る（２行目から）
			$sample = explode("\t",$line);//$lineを"（スペース）"毎に配列に入れる
			$arrFp[] = $sample;//配列に追加する
	}
	echo "<pre>";
	print_r($arrFp);
	echo "<br>";

 }

 public function docsv()
{
$fp = fopen("ryousan.txt", "r");//csvファイルはwebrootに入れる
$this->set('fp',$fp);

$fpcount = fopen("ryousan.txt", 'r' );
for( $count = 0; fgets( $fpcount ); $count++ );
$this->set('count',$count);

$arrFp = array();//空の配列を作る
//$line = fgets($fp);//ファイル$fpの上の１行を取る（１行目）
for ($k=1; $k<=$count; $k++) {//行数分
$line = fgets($fp);//ファイル$fpの上の１行を取る（２行目から）
$sample = explode("\t",$line);//$lineを"（スペース）"毎に配列に入れる

$keys=array_keys($sample);
$keys[array_search('0',$keys)]='pro_code';//名前の変更
$keys[array_search('1',$keys)]='ryousan';
$sample = array_combine( $keys, $sample );

$arrFp[] = $sample;//配列に追加する
}

$this->set('arrFp',$arrFp);//$arrFpをctpで使用できるようセット
echo "<pre>";
print_r($arrFp);
echo "<br>";

for ($k=0; $k<$count; $k++) {

	$ProductsData = $this->Products->find()->where(['product_code' => $arrFp[$k]['pro_code']])->toArray();
	$ProductsDataid =  $ProductsData[0]->id;
	$this->Products->updateAll(//検査終了時間の更新
		['ryousan_flag' => $arrFp[$k]['ryousan']],
		['id'  => $ProductsDataid]
	);

}

}
}
