<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;//ログインに使用
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション
use Cake\Auth\DefaultPasswordHasher;//パスワードの更新時のハッシュ化

class UsersController extends AppController
{

    public function initialize()
  {
   parent::initialize();
   $this->Groups = TableRegistry::get('Groups');
   $this->Staffs = TableRegistry::get('Staffs');
   $this->Menus = TableRegistry::get('Menus');
   $this->StaffAbilities = TableRegistry::get('StaffAbilities');
  }
/*
  public function login()
  {
    $Users = $this->Users->newEntity();
    $this->set('Users',$Users);

    if ($this->request->is('post')) {
      $user = $this->Auth->identify();

      if ($user) {
        $this->Auth->setUser($user);
        return $this->redirect($this->Auth->redirectUrl());
      //  return $this->redirect(['action' => 'menu']);
      }
      $this->Flash->error(__('ユーザ名もしくはパスワードが間違っています'));
    }

  }

  public function logout()
  {
    return $this->redirect($this->Auth->logout());
  }
*/
    public function index()
    {
        $this->paginate = [
            'contain' => ['Staffs']
        ];
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Staffs']
        ]);

        $this->set('user', $user);
    }

    public function addform()
    {
      $user = $this->Users->newEntity();
      $staffs = $this->Users->Staffs->find('list', ['limit' => 200]);
      $this->set(compact('user', 'staffs'));

      $Groups = $this->Groups->find()
      ->where(['delete_flag' => 0])->toArray();

      $Groupnames = array();
      for($k=0; $k<count($Groups); $k++){
        $Groupnames = array_merge($Groupnames,array($Groups[$k]['name_group']=>$Groups[$k]['name_group']));
      }

      $Groupnames = array_unique($Groupnames);
      $this->set('Groupnames', $Groupnames);
    }

    public function addcomfirm()
    {
      $Users = $this->Users->newEntity();
      $this->set('Users', $Users);

      $data = $this->request->getData();

      if($data['super_user'] == 0){
        $super_userhyouji = "いいえ";
      }else{
        $super_userhyouji = "はい";
      }
      $this->set('super_userhyouji', $super_userhyouji);

      $Staffs = $this->Staffs->find()
      ->where(['id' => $data['staff_id']])->toArray();
      $staffhyouji = $Staffs[0]["name"];
      $this->set('staffhyouji', $staffhyouji);
    }

    public function adddo()
    {
      $Users = $this->Users->newEntity();
      $this->set('Users', $Users);

      $session = $this->request->getSession();
      $datasession = $session->read();

      $data = $this->request->getData();

      if($data['super_user'] == 0){
        $super_userhyouji = "いいえ";
      }else{
        $super_userhyouji = "はい";
      }
      $this->set('super_userhyouji', $super_userhyouji);

      $Staffs = $this->Staffs->find()
      ->where(['id' => $data['staff_id']])->toArray();
      $staffhyouji = $Staffs[0]["name"];
      $this->set('staffhyouji', $staffhyouji);

      $staff_id = $datasession['Auth']['User']['staff_id'];

      $arrtourokuuser = array();
      $arrtourokuuser = [
        'user_code' => $data["user_code"],
        'password' => $data["password"],
        'staff_id' => $data["staff_id"],
        'super_user' => $data["super_user"],
        'group_name' => $data["group_name"],
        'delete_flag' => 0,
        'created_at' => date("Y-m-d H:i:s"),
        'created_staff' => $staff_id
      ];

      $Groups = $this->Groups->find()->contain(["Menus"])//GroupsテーブルとMenusテーブルを関連付ける
      ->where(['Groups.name_group' => $data["group_name"], 'Groups.delete_flag' => 0])->order(["menu_id"=>"ASC"])->toArray();

      $arrMenuids = array();
      for($k=0; $k<count($Groups); $k++){

        $StaffAbilities = $this->StaffAbilities->find()
        ->where(['staff_id' => $staff_id, 'menu_id' => $Groups[$k]['menu_id'], 'delete_flag' => 0])->toArray();

        if(count($StaffAbilities) < 1){
          $arrMenuids[] = array(
            'staff_id' => $staff_id,
            'menu_id' => $Groups[$k]['menu_id'],
            'delete_flag' => 0,
            'created_at' => date("Y-m-d H:i:s"),
            'created_staff' => $staff_id
          );
        }

      }
/*
      echo "<pre>";
      print_r($arrMenuids);
      echo "</pre>";
*/
      //新しいデータを登録
      $Users = $this->Users->patchEntity($this->Users->newEntity(), $arrtourokuuser);
      $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        if ($this->Users->save($Users)) {//ここでstaff_abilitiesテーブルも登録//グループが修正される場合は一度グループを削除して作り直す

          $StaffAbilities = $this->StaffAbilities->patchEntities($this->StaffAbilities->newEntity(), $arrMenuids);
          $this->StaffAbilities->saveMany($StaffAbilities);

          $connection->commit();// コミット5
          $mes = "以下のように登録されました。";
          $this->set('mes',$mes);

        } else {

          $this->Flash->error(__('The data could not be saved. Please, try again.'));
          throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
          $mes = "※登録されませんでした";
          $this->set('mes',$mes);

        }

      } catch (Exception $e) {//トランザクション7
      //ロールバック8
        $connection->rollback();//トランザクション9
      }//トランザクション10

    }

    public function editform($id = null)
    {
      $user = $this->Users->get($id, [
          'contain' => []
      ]);
      $staffs = $this->Users->Staffs->find('list', ['limit' => 200]);
      $this->set(compact('user', 'staffs'));
      $this->set('id', $id);

      $Groups = $this->Groups->find()
      ->where(['delete_flag' => 0])->toArray();

      $Groupnames = array();
      for($k=0; $k<count($Groups); $k++){
        $Groupnames = array_merge($Groupnames,array($Groups[$k]['name_group']=>$Groups[$k]['name_group']));
      }

      $Groupnames = array_unique($Groupnames);
      $this->set('Groupnames', $Groupnames);
    }

    public function editconfirm()
    {
      $user = $this->Users->newEntity();
      $this->set('user', $user);

      $data = $this->request->getData();

      if($data['super_user'] == 0){
        $super_userhyouji = "いいえ";
      }else{
        $super_userhyouji = "はい";
      }
      $this->set('super_userhyouji', $super_userhyouji);

      $Staffs = $this->Staffs->find()
      ->where(['id' => $data['staff_id']])->toArray();
      $staffhyouji = $Staffs[0]["name"];
      $this->set('staffhyouji', $staffhyouji);
    }

    public function editdo()
    {
      $user = $this->Users->newEntity();
      $this->set('user', $user);

      $session = $this->request->getSession();
      $datasession = $session->read();

      $data = $this->request->getData();

      if($data['super_user'] == 0){
        $super_userhyouji = "いいえ";
      }else{
        $super_userhyouji = "はい";
      }
      $this->set('super_userhyouji', $super_userhyouji);

      $Staffs = $this->Staffs->find()
      ->where(['id' => $data['staff_id']])->toArray();
      $staffhyouji = $Staffs[0]["name"];
      $this->set('staffhyouji', $staffhyouji);

      $staff_id = $datasession['Auth']['User']['staff_id'];

      $makepassword = new DefaultPasswordHasher();
      $password = $makepassword->hash($data["password"]);

      $arrupdateuser = array();
      $arrupdateuser = [
        'id' => $data["id"],
        'user_code' => $data["user_code"],
        'password' => $password,
        'staff_id' => $data["staff_id"],
        'super_user' => $data["super_user"],
        'group_name' => $data["group_name"],
      ];
/*
      echo "<pre>";
      print_r($arrupdateuser);
      echo "</pre>";
*/
      $Users = $this->Users->patchEntity($this->Users->newEntity(), $arrupdateuser);
      $connection = ConnectionManager::get('default');//トランザクション1
       // トランザクション開始2
       $connection->begin();//トランザクション3
       try {//トランザクション4
         if ($this->Users->updateAll(
           [ 'user_code' => $arrupdateuser['user_code'],
             'password' => $arrupdateuser['password'],
             'staff_id' => $arrupdateuser['staff_id'],
             'super_user' => $arrupdateuser['super_user'],
             'group_name' => $arrupdateuser['group_name'],
             'updated_at' => date('Y-m-d H:i:s'),
             'updated_staff' => $staff_id],
           ['id'  => $arrupdateuser['id']]
         )){

         $mes = "※下記のように更新されました";
         $this->set('mes',$mes);
         $connection->commit();// コミット5

       } else {

         $mes = "※更新されませんでした";
         $this->set('mes',$mes);
         $this->Flash->error(__('The data could not be saved. Please, try again.'));
         throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6

       }

     } catch (Exception $e) {//トランザクション7
     //ロールバック8
       $connection->rollback();//トランザクション9
     }//トランザクション10

    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
