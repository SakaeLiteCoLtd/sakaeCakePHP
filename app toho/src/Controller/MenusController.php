<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション
use Cake\ORM\TableRegistry;//独立したテーブルを扱う

class MenusController extends AppController
{

    public function index()
    {
        $menus = $this->paginate($this->Menus);

        $this->set(compact('menus'));
    }

    public function view($id = null)
    {
        $menu = $this->Menus->get($id, [
            'contain' => ['Groups', 'StaffAbilities']
        ]);

        $this->set('menu', $menu);
    }

    public function addform()
    {
      $menu = $this->Menus->newEntity();
      $this->set('menu', $menu);
    }

    public function addcomfirm()
    {
      $menu = $this->Menus->newEntity();
      $this->set('menu', $menu);
    }

    public function adddo()
    {
      $menus = $this->Menus->newEntity();
      $this->set('menus', $menus);

      $session = $this->request->getSession();
      $datasession = $session->read();

      $data = $this->request->getData();

      $staff_id = $datasession['Auth']['User']['staff_id'];

      $arrtourokumenu = array();
      $arrtourokumenu = [
        'name_menu' => $data["name_menu"],
        'delete_flag' => 0,
        'created_at' => date("Y-m-d H:i:s"),
        'created_staff' => $staff_id
      ];

      //新しいデータを登録
      $Menus = $this->Menus->patchEntity($this->Menus->newEntity(), $arrtourokumenu);
      $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        if ($this->Menus->save($Menus)) {

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
        $menu = $this->Menus->get($id, [
            'contain' => []
        ]);
        $this->set(compact('menu'));
        $this->set('id', $id);
    }

    public function editconfirm()
    {
      $menu = $this->Menus->newEntity();
      $this->set('menu', $menu);
    }

    public function editdo()
    {
      $menu = $this->Menus->newEntity();
      $this->set('menu', $menu);

      $session = $this->request->getSession();
      $datasession = $session->read();

      $data = $this->request->getData();

      $staff_id = $datasession['Auth']['User']['staff_id'];

      $arrupdatemenus = array();
      $arrupdatemenus = [
        'id' => $data["id"],
        'name_menu' => $data["name_menu"],
      ];
/*
      echo "<pre>";
      print_r($arrupdatemenus);
      echo "</pre>";
*/
      $Menus = $this->Menus->patchEntity($this->Menus->newEntity(), $arrupdatemenus);
      $connection = ConnectionManager::get('default');//トランザクション1
       // トランザクション開始2
       $connection->begin();//トランザクション3
       try {//トランザクション4
         if ($this->Menus->updateAll(
           [ 'name_menu' => $arrupdatemenus['name_menu'],
             'updated_at' => date('Y-m-d H:i:s'),
             'updated_staff' => $staff_id],
           ['id'  => $arrupdatemenus['id']]
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
        $menu = $this->Menus->get($id);
        if ($this->Menus->delete($menu)) {
            $this->Flash->success(__('The menu has been deleted.'));
        } else {
            $this->Flash->error(__('The menu could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
