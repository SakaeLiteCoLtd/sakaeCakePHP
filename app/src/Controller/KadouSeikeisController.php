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
class KadouSeikeisController extends AppController
{

     public function initialize()
     {
			 parent::initialize();
       $this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
       $this->KadouSeikeis = TableRegistry::get('kadouSeikeis');
       $this->Users = TableRegistry::get('users');
     }

    public function index()
    {
			$kadouSeikeis = $this->KadouSeikeis->newEntity();//newentityに$roleという名前を付ける
			$this->set('kadouSeikeis',$kadouSeikeis);//1行上の$roleをctpで使えるようにセット
    }

    public function form()
    {
			$kadouSeikeis = $this->KadouSeikeis->newEntity();//newentityに$roleという名前を付ける
			$this->set('kadouSeikeis',$kadouSeikeis);//1行上の$roleをctpで使えるようにセット
			$data = $this->request->getData();//postデータを$dataに
/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
      if(empty($data['formset']) && !isset($data['touroku'])){//最初のフォーム画面
        session_start();
        $dayye = sprintf('%02d', (int)$data['manu_date']['day']-1);
        $dateYMD = $data['manu_date']['year']."-".$data['manu_date']['month']."-".$data['manu_date']['day'];
        $this->set('dateYMD',$dateYMD);
        $dateYMDye = $data['manu_date']['year']."-".$data['manu_date']['month']."-".$dayye;
        $this->set('dateYMDye',$dateYMDye);
        $dateHI = date("08:00");
        $dateye = $dateYMDye."T".$dateHI;
        $dateto = $dateYMD."T".$dateHI;
        $this->set('dateye',$dateye);
        $this->set('dateto',$dateto);

        $tuika1 = 1;
        $this->set('tuika1',$tuika1);//1行上の$roleをctpで使えるようにセット
        $tuika2 = 1;
        $this->set('tuika2',$tuika2);//1行上の$roleをctpで使えるようにセット
      }else{

        if (isset($data['tuika11']) && empty($data['sakujo11'])) {//データがpostで送られたとき
          $dateye = $data['dateye'];
          $dateto = $data['dateto'];
          $this->set('dateye',$dateye);
          $this->set('dateto',$dateto);

          $tuika1 = $data['tuika1'] + 1;
  				$this->set('tuika1',$tuika1);//1行上の$roleをctpで使えるようにセット
          $tuika2 = $data['tuika2'];
          $this->set('tuika2',$tuika2);//1行上の$roleをctpで使えるようにセット
/*
          echo "<pre>";
  				print_r($data['tuika1']);
  				echo "</pre>";
*/
        }elseif(isset($data['sakujo11']) && $data['tuika1'] > 0){
/*  				echo "<pre>";
  				print_r("1-sa");
  				echo "</pre>";
*/
          $dateye = $data['dateye'];
          $dateto = $data['dateto'];
          $this->set('dateye',$dateye);
          $this->set('dateto',$dateto);

  				$tuika1 = $data['tuika1'] - 1;
  				$this->set('tuika1',$tuika1);//1行上の$roleをctpで使えるようにセット
          $tuika2 = $data['tuika2'];
          $this->set('tuika2',$tuika2);//1行上の$roleをctpで使えるようにセット

        }elseif(isset($data['sakujo11']) && $data['tuika1'] == 0){
  /*				echo "<pre>";
  				print_r($data['sakujo1']);
  				echo "</pre>";
  */
          $dateye = $data['dateye'];
          $dateto = $data['dateto'];
          $this->set('dateye',$dateye);
          $this->set('dateto',$dateto);

  				$tuika1 = $data['tuika1'];
  				$this->set('tuika1',$tuika1);//1行上の$roleをctpで使えるようにセット
          $tuika2 = $data['tuika2'];
          $this->set('tuika2',$tuika2);//1行上の$roleをctpで使えるようにセット

        }elseif(isset($data['confirm']) && !isset($data['touroku'])){
          $this->set('confirm',$data['confirm']);//1行上の$roleをctpで使えるようにセット
          $kadoujikan1_1 = ((strtotime($data['finishing_tm1_1']) - strtotime($data['starting_tm1_1']))/3600);//稼働時間
          $this->set('kadoujikan1_1',$kadoujikan1_1);//1行上の$roleをctpで使えるようにセット
/*
          echo "<pre>";
          print_r($data['confirm']);
          echo "</pre>";
*/

          $starting_tm1_1 = substr($data['starting_tm1_1'], 0, 10)." ".substr($data['starting_tm1_1'], 11, 5);
          $this->set('starting_tm1_1',$starting_tm1_1);//1行上の$roleをctpで使えるようにセット
          $finishing_tm1_1 = substr($data['finishing_tm1_1'], 0, 10)." ".substr($data['finishing_tm1_1'], 11, 5);
          $this->set('finishing_tm1_1',$finishing_tm1_1);//1行上の$roleをctpで使えるようにセット
          $tuika1 = $data['tuika1'];
          $this->set('tuika1',$tuika1);//1行上の$roleをctpで使えるようにセット
          $tuika2 = $data['tuika2'];
          $this->set('tuika2',$tuika2);//1行上の$roleをctpで使えるようにセット

  //      }else{
        }

        elseif (isset($data['tuika22']) && empty($data['sakujo22'])) {//データがpostで送られたとき
          $dateye = $data['dateye'];
          $dateto = $data['dateto'];
          $this->set('dateye',$dateye);
          $this->set('dateto',$dateto);

  				$tuika2 = $data['tuika2'] + 1;
  				$this->set('tuika2',$tuika2);//1行上の$roleをctpで使えるようにセット
          $tuika1 = $data['tuika1'];
  				$this->set('tuika1',$tuika1);//1行上の$roleをctpで使えるようにセット

        }elseif(isset($data['sakujo22']) && $data['tuika2'] > 0){
          $dateye = $data['dateye'];
          $dateto = $data['dateto'];
          $this->set('dateye',$dateye);
          $this->set('dateto',$dateto);

  				$tuika2 = $data['tuika2'] - 1;
  				$this->set('tuika2',$tuika2);//1行上の$roleをctpで使えるようにセット
          $tuika1 = $data['tuika1'];
  				$this->set('tuika1',$tuika1);//1行上の$roleをctpで使えるようにセット

        }elseif(isset($data['sakujo22']) && $data['tuika2'] == 0){
          $dateye = $data['dateye'];
          $dateto = $data['dateto'];
          $this->set('dateye',$dateye);
          $this->set('dateto',$dateto);

  				$tuika2 = $data['tuika2'];
  				$this->set('tuika2',$tuika2);//1行上の$roleをctpで使えるようにセット
          $tuika1 = $data['tuika1'];
  				$this->set('tuika1',$tuika1);//1行上の$roleをctpで使えるようにセット

  			}else{
          return $this->redirect(['action' => 'comfirm']);
      	}


      }

    }

     public function comfirm()
    {
      $kadouSeikei = $this->KadouSeikeis->newEntity();
			$this->set('kadouSeikei',$kadouSeikei);

      $session = $this->request->getSession();
      $data = $session->read();

      echo "<pre>";
      print_r($data['karikadouseikei']);
      echo "</pre>";

      if ($this->request->is('get')) {
        $kadouSeikei = $this->KadouSeikeis->patchEntities($kadouSeikei, $data['karikadouseikei']);//$roleデータ（空の行）を$this->request->getData()に更新する
				$connection = ConnectionManager::get('default');//トランザクション1
				// トランザクション開始2
				$connection->begin();//トランザクション3
				try {//トランザクション4
					if ($this->KadouSeikeis->saveMany($kadouSeikei)) {
						$connection->commit();// コミット5
					} else {
						$this->Flash->error(__('The data could not be saved. Please, try again.'));
						throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
					}
				} catch (Exception $e) {//トランザクション7
				//ロールバック8
					$connection->rollback();//トランザクション9
				}//トランザクション10

      }
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
			$this->request->session()->destroy(); // セッションの破棄
			return $this->redirect(['controller' => 'Shinkies', 'action' => 'index']);//ログアウト後に移るページ
		}

     public function do()
    {
			$role = $this->Roles->newEntity();//newentityに$roleという名前を付ける
			$this->set('role',$role);//1行上の$roleをctpで使えるようにセット

			$session = $this->request->getSession();
			$data = $session->read();

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
						$connection->commit();// コミット5
					} else {
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
