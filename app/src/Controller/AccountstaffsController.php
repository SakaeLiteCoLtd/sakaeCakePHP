<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション
use Cake\Auth\DefaultPasswordHasher;//

use App\myClass\Rolecheck\htmlRolecheck;

class AccountstaffsController extends AppController
{

     public function initialize()
     {
			parent::initialize();
			$this->Users = TableRegistry::get('users');
      $this->Staffs = TableRegistry::get('staffs');
      $this->StatusRoles = TableRegistry::get('statusRoles');

      $session = $this->request->getSession();
      $data = $session->read();

      if(!isset($data['login'])){
        return $this->redirect(['controller' => 'accounts', 'action' => 'index']);
      }

     }

		public function menu()
		{
		 $user = $this->Users->newEntity();
		 $this->set('user',$user);
/*
		 echo "<pre>";
		 print_r($data);
		 echo "</pre>";
*/
		}

    public function staffmenu()
		{
		 $user = $this->Users->newEntity();
		 $this->set('user',$user);
		}

    public function usermenu()
		{
		 $user = $this->Users->newEntity();
		 $this->set('user',$user);
		}

    public function rolemenu()
		{
		 $user = $this->Users->newEntity();
		 $this->set('user',$user);
		}

    public function staffaddform()
		{
		 $user = $this->Users->newEntity();
		 $this->set('user',$user);
		}

    public function staffaddconfirm()
		{
		 $user = $this->Users->newEntity();
		 $this->set('user',$user);

     $data = $this->request->getData();
     /*
     echo "<pre>";
		 print_r($data);
		 echo "</pre>";
*/
     $f_name = $data['f_name'];
     $this->set('f_name',$f_name);
     $l_name = $data['l_name'];
     $this->set('l_name',$l_name);
     $staff_code = $data['staff_code'];
     $this->set('staff_code',$staff_code);
     $sex = $data['sex'];
     $this->set('sex',$sex);

     if($sex == 0){
       $sexhyouji = "男";
     }else{
       $sexhyouji = "女";
     }
     $this->set('sexhyouji',$sexhyouji);

     $tel = $data['tel'];
     $this->set('tel',$tel);
     $address = $data['address'];
     $this->set('address',$address);

     if($data['birth']['year'] > 0){
       $birth = $data['birth']['year']."-".$data['birth']['month']."-".$data['birth']['day'];
     }else{
       $birth = "";
     }
     $this->set('birth',$birth);

     if($data['date_start']['year'] > 0){
       $date_start = $data['date_start']['year']."-".$data['date_start']['month']."-".$data['date_start']['day'];
     }else{
       $date_start = "";
     }
     $this->set('date_start',$date_start);

		}

    public function staffadddo()
		{
      $session = $this->request->getSession();
      $sessionData = $session->read();

      $user = $this->Users->newEntity();
      $this->set('user',$user);

      $data = $this->request->getData();

      $f_name = $data['f_name'];
      $this->set('f_name',$f_name);
      $l_name = $data['l_name'];
      $this->set('l_name',$l_name);
      $staff_code = $data['staff_code'];
      $this->set('staff_code',$staff_code);
      $sex = $data['sex'];
      $this->set('sex',$sex);
      $sexhyouji = $data['sexhyouji'];
      $this->set('sexhyouji',$sexhyouji);

      $tel = $data['tel'];
      $this->set('tel',$tel);
      $address = $data['address'];
      $this->set('address',$address);
      $birth = $data['birth'];
      $this->set('birth',$birth);
      $date_start = $data['date_start'];
      $this->set('date_start',$date_start);

      $tourokuStaffs = [
        'f_name' => $f_name,
        'l_name' => $l_name,
        'staff_code' => $staff_code,
        'sex' => $sex,
        'tel' => $tel,
        'address' => $address,
        'birth' => $birth,
        'date_start' => $date_start,
        'status' => 0,
        'role_id' => 4,
        'delete_flag' => 0,
        'created_at' => date('Y-m-d H:i:s'),
        'created_staff' => $sessionData['login']['staff_id'],
      ];
/*
      echo "<pre>";
      print_r($tourokuStaffs);
      echo "</pre>";
*/
     $Staffs = $this->Staffs->patchEntity($this->Staffs->newEntity(), $tourokuStaffs);
     $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        if ($this->Staffs->save($Staffs)) {

          $mes = "※以下のデータが登録されました";
          $this->set('mes',$mes);
          $connection->commit();// コミット5

          } else {

            $mes = "※登録されませんでした";
            $this->set('mes',$mes);
            $this->Flash->error(__('The data could not be saved. Please, try again.'));
            throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6

          }

      } catch (Exception $e) {//トランザクション7
      //ロールバック8
        $connection->rollback();//トランザクション9
      }//トランザクション10

		}

    public function staffeditkensaku()
		{
		 $user = $this->Users->newEntity();
		 $this->set('user',$user);

     $Data=$this->request->query('s');
     if(isset($Data["mess"])){
       $mess = $Data["mess"];
       $this->set('mess',$mess);
     }else{
       $data = $this->request->getData();
       $mess = "";
       $this->set('mess',$mess);
     }

     $Staffs_list = $this->Staffs->find()
     ->where(['delete_flag' => 0])->toArray();
     $arrStaffs_list = array();
     for($j=0; $j<count($Staffs_list); $j++){
       array_push($arrStaffs_list,$Staffs_list[$j]["f_name"]."_".$Staffs_list[$j]["l_name"]);
     }
     $arrStaffs_list = array_unique($arrStaffs_list);
     $arrStaffs_list = array_values($arrStaffs_list);
     $this->set('arrStaffs_list', $arrStaffs_list);

		}

    public function staffeditform()
		{
		 $user = $this->Users->newEntity();
		 $this->set('user',$user);

     $data = $this->request->getData();
     $arrname = explode('_', $data["name"]);

     $f_name = $arrname[0];
     if(isset($arrname[1])){
       $l_name = $arrname[1];

       $Staffs = $this->Staffs->find()
       ->where(['f_name' => $f_name, 'l_name' => $l_name, 'delete_flag' => 0])->toArray();

       if(!isset($Staffs[0])){

         return $this->redirect(['action' => 'staffeditkensaku',
         's' => ['mess' => "入力された社員名は登録されていません。"]]);

       }
       $this->set('StaffId',$Staffs[0]["id"]);

     }else{

       return $this->redirect(['action' => 'staffeditkensaku',
       's' => ['mess' => "姓と名を「_」（アンダーバー）でつないで入力してください。"]]);

     }

     $f_name = $Staffs[0]['f_name'];
     $this->set('f_name',$f_name);
     $l_name = $Staffs[0]['l_name'];
     $this->set('l_name',$l_name);
     $staff_code = $Staffs[0]['staff_code'];
     $this->set('staff_code',$staff_code);
     $tel = $Staffs[0]['tel'];
     $this->set('tel',$tel);
     $address = $Staffs[0]['address'];
     $this->set('address',$address);

     if(strlen($Staffs[0]['birth']) > 0){
       $birth = $Staffs[0]['birth']->format('Y-m-d');
     }else{
       $birth = "";
     }
     $this->set('birth',$birth);

     if(strlen($Staffs[0]['date_start']) > 0){
       $date_start = $Staffs[0]['date_start']->format('Y-m-d');
     }else{
       $date_start = "";
     }
     $this->set('date_start',$date_start);

     header('Expires:-1');
     header('Cache-Control:');
     header('Pragma:');

/*
     echo "<pre>";
     print_r($Staffs);
     echo "</pre>";
*/
		}

    public function staffeditconfirm()
		{
		 $user = $this->Users->newEntity();
		 $this->set('user',$user);

     $data = $this->request->getData();
/*
     echo "<pre>";
		 print_r($data);
		 echo "</pre>";
*/
     $f_name = $data['f_name'];
     $this->set('f_name',$f_name);
     $l_name = $data['l_name'];
     $this->set('l_name',$l_name);
     $staff_code = $data['staff_code'];
     $this->set('staff_code',$staff_code);
     $sex = $data['sex'];
     $this->set('sex',$sex);

     $Staffs = $this->Staffs->find()
     ->where(['id IS NOT' => $data['StaffId'], 'staff_code' => $staff_code, 'delete_flag' => 0])->toArray();

     if(isset($Staffs[0])){

       return $this->redirect(['action' => 'staffeditkensaku',
       's' => ['mess' => "入力された社員コードは既に登録されています。"]]);

     }

     if($sex == 0){
       $sexhyouji = "男";
     }else{
       $sexhyouji = "女";
     }
     $this->set('sexhyouji',$sexhyouji);

     $tel = $data['tel'];
     $this->set('tel',$tel);
     $address = $data['address'];
     $this->set('address',$address);
     $StaffId = $data['StaffId'];
     $this->set('StaffId',$StaffId);

     if($data['birth']['year'] > 0){
       $birth = $data['birth']['year']."-".$data['birth']['month']."-".$data['birth']['day'];
     }else{
       $birth = "";
     }
     $this->set('birth',$birth);

     if($data['date_start']['year'] > 0){
       $date_start = $data['date_start']['year']."-".$data['date_start']['month']."-".$data['date_start']['day'];
     }else{
       $date_start = "";
     }
     $this->set('date_start',$date_start);

     if($data['date_finish']['year'] > 0){
       $date_finish = $data['date_finish']['year']."-".$data['date_finish']['month']."-".$data['date_finish']['day'];
     }else{
       $date_finish = "";
     }
     $this->set('date_finish',$date_finish);

     if($data["check"] > 0){

       $mess = "以下のデータを削除します。よろしければ「決定」ボタンを押してください。";
       $delete_flag = 1;

     }else{

       $mess = "以下のように更新します。よろしければ「決定」ボタンを押してください。";
       $delete_flag = 0;

     }
     $this->set('mess', $mess);
     $this->set('delete_flag', $delete_flag);

     header('Expires:-1');
     header('Cache-Control:');
     header('Pragma:');

		}

    public function staffeditdo()
		{
     $session = $this->request->getSession();
     $sessionData = $session->read();

		 $user = $this->Users->newEntity();
		 $this->set('user',$user);

     $data = $this->request->getData();
/*
     echo "<pre>";
		 print_r($data);
		 echo "</pre>";
*/
     $f_name = $data['f_name'];
     $this->set('f_name',$f_name);
     $l_name = $data['l_name'];
     $this->set('l_name',$l_name);
     $staff_code = $data['staff_code'];
     $this->set('staff_code',$staff_code);
     $sex = $data['sex'];
     $this->set('sex',$sex);
     $sexhyouji = $data['sexhyouji'];
     $this->set('sexhyouji',$sexhyouji);

     $tel = $data['tel'];
     $this->set('tel',$tel);
     $address = $data['address'];
     $this->set('address',$address);
     $StaffId = $data['StaffId'];
     $this->set('StaffId',$StaffId);

     if(strlen($data['birth']) > 0){
       $birth = $data['birth'];
     }else{
       $birth = null;
     }
     $this->set('birth',$birth);

     if(strlen($data['date_start']) > 0){
       $date_start = $data['date_start'];
     }else{
       $date_start = null;
     }
     $this->set('date_start',$date_start);

     if(strlen($data['date_finish']) > 0){
       $date_finish = $data['date_finish'];
     }else{
       $date_finish = null;
     }
     $this->set('date_finish',$date_finish);

     $Staffs = $this->Staffs->patchEntity($this->Staffs->newEntity(), $data);
     $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4

        if($data["delete_flag"] > 0){

          if ($this->Staffs->updateAll(
            ['delete_flag' => 1, 'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $sessionData['login']['staff_id']],
            ['id'  => $data["StaffId"]]
          )){

            $mes = "※削除されました";
            $this->set('mes',$mes);
            $connection->commit();// コミット5

          } else {

            $mes = "※削除されませんでした";
            $this->set('mes',$mes);
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
            throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6

          }

        }else{

          if ($this->Staffs->updateAll(
            [
              'f_name' => $data["f_name"],
              'l_name' => $data["l_name"],
              'staff_code' => $data["staff_code"],
              'sex' => $data["sex"],
              'tel' => $data["tel"],
              'address' => $data["address"],
              'birth' => $birth,
              'date_start' => $date_start,
              'date_finish' => $date_finish,
              'updated_at' => date('Y-m-d H:i:s'),
              'updated_staff' => $sessionData['login']['staff_id']],
              ['id'  => $data["StaffId"]]
          )){

            $mes = "※更新されました";
            $this->set('mes',$mes);
            $connection->commit();// コミット5

          } else {

            $mes = "※更新されませんでした";
            $this->set('mes',$mes);
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
            throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6

          }

        }

      } catch (Exception $e) {//トランザクション7
      //ロールバック8
        $connection->rollback();//トランザクション9
      }//トランザクション10

		}

    public function useraddform()
		{
		 $user = $this->Users->newEntity();
		 $this->set('user',$user);

     $Data=$this->request->query('s');
     if(isset($Data["mess"])){
       $mess = $Data["mess"];
       $this->set('mess',$mess);
     }else{
       $data = $this->request->getData();
       $mess = "";
       $this->set('mess',$mess);
     }

     $arrStaffs = $this->Staffs->find('all', ['conditions' => ['delete_flag' => '0']])->order(['staff_code' => 'ASC']);//Staffsテーブルの'delete_flag' => '0'となるものを見つけ、staff_code順に並べる
     $arrStaff = array();//配列の初期化
     foreach ($arrStaffs as $value) {//2行上のStaffsテーブルのデータそれぞれに対して
       $arrStaff[] = array($value->id=>$value->staff_code.':'.$value->f_name.$value->l_name);//配列に3行上のStaffsテーブルのデータそれぞれのstaff_code:f_name:l_name
     }
     $this->set('arrStaff',$arrStaff);//4行上$arrStaffをctpで使えるようにセット
		}

    public function useraddconfirm()
		{
		 $user = $this->Users->newEntity();
		 $this->set('user',$user);

     $data = $this->request->getData();

     $Users = $this->Users->find()
     ->where(['staff_id' => $data['staff_id'], 'delete_flag' => 1])->toArray();

     if(isset($Users[0])){

       return $this->redirect(['action' => 'useraddform',
       's' => ['mess' => "選択された社員のユーザー情報は既に登録されています。"]]);

     }

     echo "<pre>";
		 print_r($Users);
		 echo "</pre>";

		}

}
