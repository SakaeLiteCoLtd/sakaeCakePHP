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
class KadousController extends AppController
{

     public function initialize()
     {
			 parent::initialize();
       $this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
       $this->KariKadouSeikeis = TableRegistry::get('kariKadouSeikeis');
//       $this->KadouSeikeis = TableRegistry::get('kadouSeikeis');
       $this->Users = TableRegistry::get('users');
     }

    public function kariindex()
    {
      $this->request->session()->destroy(); // セッションの破棄

			$KariKadouSeikeis = $this->KariKadouSeikeis->newEntity();//newentityに$roleという名前を付ける
			$this->set('KariKadouSeikeis',$KariKadouSeikeis);//1行上の$roleをctpで使えるようにセット
    }

    public function kariform()
    {
			$KariKadouSeikeis = $this->KariKadouSeikeis->newEntity();//newentityに$roleという名前を付ける
			$this->set('KariKadouSeikeis',$KariKadouSeikeis);//1行上の$roleをctpで使えるようにセット
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
        $this->set('tuika1',$tuika1);
        $tuika2 = 1;
        $this->set('tuika2',$tuika2);
        $tuika3 = 1;
        $this->set('tuika3',$tuika3);
      }else{

        if (isset($data['tuika11']) && empty($data['sakujo11'])) {//1goukituika
          $dateye = $data['dateye'];
          $dateto = $data['dateto'];
          $this->set('dateye',$dateye);
          $this->set('dateto',$dateto);

          $tuika1 = $data['tuika1'] + 1;
  				$this->set('tuika1',$tuika1);//1行上の$roleをctpで使えるようにセット
          $tuika2 = $data['tuika2'];
          $this->set('tuika2',$tuika2);//1行上の$roleをctpで使えるようにセット
          $tuika3 = $data['tuika3'];
          $this->set('tuika3',$tuika3);//1行上の$roleをctpで使えるようにセット
/*
          echo "<pre>";
  				print_r($data['tuika1']);
  				echo "</pre>";
*/
}elseif(isset($data['sakujo11']) && $data['tuika1'] > 0){//1goukisakujo
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
          $tuika3 = $data['tuika3'];
          $this->set('tuika3',$tuika3);//1行上の$roleをctpで使えるようにセット

        }elseif(isset($data['sakujo11']) && $data['tuika1'] == 0){//1goukisakujo0
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
          $tuika3 = $data['tuika3'];
          $this->set('tuika3',$tuika3);//1行上の$roleをctpで使えるようにセット

        }elseif(isset($data['confirm']) && !isset($data['touroku'])){//?これがないとエラーが出る
          $this->set('confirm',$data['confirm']);//1行上の$roleをctpで使えるようにセット
//          $kadoujikan1_1 = ((strtotime($data['finishing_tm1_1']) - strtotime($data['starting_tm1_1']))/3600);//稼働時間
//          $this->set('kadoujikan1_1',$kadoujikan1_1);//1行上の$roleをctpで使えるようにセット
/*
          echo "<pre>";
          print_r($data['confirm']);
          echo "</pre>";
*/
          $tuika1 = $data['tuika1'];
          $this->set('tuika1',$tuika1);//1行上の$roleをctpで使えるようにセット
          $tuika2 = $data['tuika2'];
          $this->set('tuika2',$tuika2);//1行上の$roleをctpで使えるようにセット
          $tuika3 = $data['tuika3'];
          $this->set('tuika3',$tuika3);//1行上の$roleをctpで使えるようにセット

  //      }else{
        }

        elseif (isset($data['tuika22']) && empty($data['sakujo22'])) {//2goukituika
          $dateye = $data['dateye'];
          $dateto = $data['dateto'];
          $this->set('dateye',$dateye);
          $this->set('dateto',$dateto);

  				$tuika2 = $data['tuika2'] + 1;
  				$this->set('tuika2',$tuika2);//1行上の$roleをctpで使えるようにセット
          $tuika1 = $data['tuika1'];
  				$this->set('tuika1',$tuika1);//1行上の$roleをctpで使えるようにセット
          $tuika3 = $data['tuika3'];
          $this->set('tuika3',$tuika3);//1行上の$roleをctpで使えるようにセット

        }elseif(isset($data['sakujo22']) && $data['tuika2'] > 0){//2goukisakujo
          $dateye = $data['dateye'];
          $dateto = $data['dateto'];
          $this->set('dateye',$dateye);
          $this->set('dateto',$dateto);

  				$tuika2 = $data['tuika2'] - 1;
  				$this->set('tuika2',$tuika2);//1行上の$roleをctpで使えるようにセット
          $tuika1 = $data['tuika1'];
  				$this->set('tuika1',$tuika1);//1行上の$roleをctpで使えるようにセット
          $tuika3 = $data['tuika3'];
          $this->set('tuika3',$tuika3);//1行上の$roleをctpで使えるようにセット

        }elseif(isset($data['sakujo22']) && $data['tuika2'] == 0){//2goukisakujo0
          $dateye = $data['dateye'];
          $dateto = $data['dateto'];
          $this->set('dateye',$dateye);
          $this->set('dateto',$dateto);

  				$tuika2 = $data['tuika2'];
  				$this->set('tuika2',$tuika2);//1行上の$roleをctpで使えるようにセット
          $tuika1 = $data['tuika1'];
  				$this->set('tuika1',$tuika1);//1行上の$roleをctpで使えるようにセット
          $tuika3 = $data['tuika3'];
          $this->set('tuika3',$tuika3);//1行上の$roleをctpで使えるようにセット

        }elseif (isset($data['tuika33']) && empty($data['sakujo33'])) {//3goukituika
            $dateye = $data['dateye'];
            $dateto = $data['dateto'];
            $this->set('dateye',$dateye);
            $this->set('dateto',$dateto);

    				$tuika3 = $data['tuika3'] + 1;
    				$this->set('tuika3',$tuika3);//1行上の$roleをctpで使えるようにセット
            $tuika1 = $data['tuika1'];
    				$this->set('tuika1',$tuika1);//1行上の$roleをctpで使えるようにセット
            $tuika2 = $data['tuika2'];
    				$this->set('tuika2',$tuika2);//1行上の$roleをctpで使えるようにセット

          }elseif(isset($data['sakujo33']) && $data['tuika3'] > 0){//3goukisakujo
            $dateye = $data['dateye'];
            $dateto = $data['dateto'];
            $this->set('dateye',$dateye);
            $this->set('dateto',$dateto);

    				$tuika3 = $data['tuika3'] - 1;
    				$this->set('tuika3',$tuika3);//1行上の$roleをctpで使えるようにセット
            $tuika1 = $data['tuika1'];
    				$this->set('tuika1',$tuika1);//1行上の$roleをctpで使えるようにセット
            $tuika2 = $data['tuika2'];
    				$this->set('tuika2',$tuika2);//1行上の$roleをctpで使えるようにセット

          }elseif(isset($data['sakujo33']) && $data['tuika3'] == 0){//3goukisakujo0
            $dateye = $data['dateye'];
            $dateto = $data['dateto'];
            $this->set('dateye',$dateye);
            $this->set('dateto',$dateto);

            $tuika3 = $data['tuika3'];
    				$this->set('tuika3',$tuika3);//1行上の$roleをctpで使えるようにセット
            $tuika2 = $data['tuika2'];
    				$this->set('tuika2',$tuika2);//1行上の$roleをctpで使えるようにセット
            $tuika1 = $data['tuika1'];
    				$this->set('tuika1',$tuika1);//1行上の$roleをctpで使えるようにセット

  			}else{
  //        echo "<pre>";
  //        print_r("エラー");
  //        echo "</pre>";
          return $this->redirect(['action' => 'karipreadd']);
      	}
      }
    }


		public function karipreadd()
		{
      $KariKadouSeikei = $this->KariKadouSeikeis->newEntity();
      $this->set('KariKadouSeikei',$KariKadouSeikei);
		}

		public function karilogin()
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
						return $this->redirect(['action' => 'karido']);
					}
				}
		}

		public function karilogout()
		{
			$this->request->session()->destroy(); // セッションの破棄
			return $this->redirect(['controller' => 'Shinkies', 'action' => 'index']);//ログアウト後に移るページ
		}

    public function karido()
   {
     $KariKadouSeikeis = $this->KariKadouSeikeis->newEntity();
     $this->set('KariKadouSeikei',$KariKadouSeikeis);

     $session = $this->request->getSession();
     $data = $session->read();

     for($n=1; $n<=100; $n++){
       if(isset($_SESSION['karikadouseikei'][$n])){
         $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
         $_SESSION['karikadouseikei'][$n] = array_merge($_SESSION['karikadouseikei'][$n],$created_staff);
       }else{
         break;
       }
     }
/*
     echo "<pre>";
     print_r($_SESSION['karikadouseikei']);
     echo "</pre>";
*/
     if ($this->request->is('get')) {
       $KariKadouSeikeis = $this->KariKadouSeikeis->patchEntities($KariKadouSeikeis, $_SESSION['karikadouseikei']);//$roleデータ（空の行）を$this->request->getData()に更新する
       $connection = ConnectionManager::get('default');//トランザクション1
       // トランザクション開始2
       $connection->begin();//トランザクション3
       try {//トランザクション4
         if ($this->KariKadouSeikeis->saveMany($KariKadouSeikeis)) {
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
