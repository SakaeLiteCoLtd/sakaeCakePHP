<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;//ログインに使用
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

class GroupsController extends AppController
{

      public function initialize()
    {
     parent::initialize();
     $this->Groups = TableRegistry::get('Groups');
     $this->Menus = TableRegistry::get('Menus');
    }

    public function index()
    {
        $this->paginate = [
            'contain' => ['Menus']
        ];
        $groups = $this->paginate($this->Groups);

        $this->set(compact('groups'));
    }

    public function view($id = null)
    {
        $group = $this->Groups->get($id, [
            'contain' => ['Menus']
        ]);

        $this->set('group', $group);
    }

    public function addpre()
    {
      $Groups = $this->Groups->newEntity();
      $this->set('Groups', $Groups);
    }

    public function addform()
    {
      $Groups = $this->Groups->newEntity();
      $this->set('Groups', $Groups);

      $data = $this->request->getData();
      $dataselect = array_keys($data, '登録済みグループ選択はこちら');

      if(isset($dataselect[0])){
        $selectcheck = 1;
      }else{
        $selectcheck = 0;
      }
      $this->set('selectcheck', $selectcheck);

      $arrGroups = $this->Groups->find()
      ->where(['delete_flag' => 0])->toArray();

      $arrname_group = array();
      for($k=0; $k<count($arrGroups); $k++){
        $arrname_group = array_merge($arrname_group,array($arrGroups[$k]['name_group']=>$arrGroups[$k]['name_group']));
      }

      $arrname_group = array_unique($arrname_group);
      $this->set('arrname_group', $arrname_group);

      $Menus = $this->Menus->find()
      ->where(['delete_flag' => 0])->toArray();

      $arrmenu_id = array();
      for($k=0; $k<count($Menus); $k++){
        $arrmenu_id = array_merge($arrmenu_id,array($Menus[$k]['name_menu']=>$Menus[$k]['name_menu']));
      }
      $this->set('arrmenu_id', $arrmenu_id);
    }

    public function addcomfirm()
    {
      $Groups = $this->Groups->newEntity();
      $this->set('Groups', $Groups);

      $data = $this->request->getData();

      $Menus = $this->Menus->find()
      ->where(['name_menu' => $data['name_menu']])->toArray();
      $menu_id = $Menus[0]['id'];
      $this->set('menu_id', $menu_id);
    }

    public function adddo()
    {
      $Groups = $this->Groups->newEntity();
      $this->set('Groups', $Groups);

      $session = $this->request->getSession();
      $datasession = $session->read();

      $staff_id = $datasession['Auth']['User']['staff_id'];

      $data = $this->request->getData();

      $arrtourokugroup = array();
      $arrtourokugroup = [
        'name_group' => $data["name_group"],
        'menu_id' => $data["menu_id"],
        'delete_flag' => 0,
        'created_at' => date("Y-m-d H:i:s"),
        'created_staff' => $staff_id
      ];
/*
      echo "<pre>";
      print_r($arrtourokugroup);
      echo "</pre>";
*/
      //新しいデータを登録
      $Groups = $this->Groups->patchEntity($this->Groups->newEntity(), $arrtourokugroup);
      $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        if ($this->Groups->save($Groups)) {

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

    public function edit($id = null)
    {
        $group = $this->Groups->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $group = $this->Groups->patchEntity($group, $this->request->getData());
            if ($this->Groups->save($group)) {
                $this->Flash->success(__('The group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The group could not be saved. Please, try again.'));
        }
        $menus = $this->Groups->Menus->find('list', ['limit' => 200]);
        $this->set(compact('group', 'menus'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $group = $this->Groups->get($id);
        if ($this->Groups->delete($group)) {
            $this->Flash->success(__('The group has been deleted.'));
        } else {
            $this->Flash->error(__('The group could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
