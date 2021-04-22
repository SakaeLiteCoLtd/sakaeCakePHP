<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション
use Cake\ORM\TableRegistry;//独立したテーブルを扱う

class PositionsController extends AppController
{

      public function initialize()
    {
     parent::initialize();
     $this->Offices = TableRegistry::get('Offices');
    }

    public function index()
    {
        $this->paginate = [
            'contain' => ['Offices']
        ];
        $positions = $this->paginate($this->Positions);

        $this->set(compact('positions'));
    }

    public function view($id = null)
    {
        $position = $this->Positions->get($id, [
            'contain' => ['Offices', 'Staffs']
        ]);

        $this->set('position', $position);
    }

    public function addform()
    {
      $position = $this->Positions->newEntity();
      $this->set('position', $position);

      $Offices = $this->Offices->find()
      ->where(['delete_flag' => 0])->toArray();
      $arrOffices = array();
      foreach ($Offices as $value) {
        $arrOffices[] = array($value->id=>$value->name);
      }
      $this->set('arrOffices', $arrOffices);

    }

    public function addcomfirm()
    {
      $position = $this->Positions->newEntity();
      $this->set('position', $position);

      $data = $this->request->getData();

      $Offices = $this->Offices->find()
      ->where(['id' => $data['office_id']])->toArray();
      $Office_name = $Offices[0]['name'];
      $this->set('Office_name', $Office_name);

    }

    public function adddo()
    {
      $position = $this->Positions->newEntity();
      $this->set('position', $position);

      $data = $this->request->getData();

      $Offices = $this->Offices->find()
      ->where(['id' => $data['office_id']])->toArray();
      $Office_name = $Offices[0]['name'];
      $this->set('Office_name', $Office_name);

      $session = $this->request->getSession();
      $datasession = $session->read();

      $staff_id = $datasession['Auth']['User']['staff_id'];

      $arrtourokuposition = array();
      $arrtourokuposition = [
        'position' => $data["position"],
        'office_id' => $data["office_id"],
        'delete_flag' => 0,
        'created_at' => date("Y-m-d H:i:s"),
        'created_staff' => $staff_id
      ];
/*
      echo "<pre>";
      print_r($arrtourokuposition);
      echo "</pre>";
*/
      //新しいデータを登録
      $Positions = $this->Positions->patchEntity($this->Positions->newEntity(), $arrtourokuposition);
      $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        if ($this->Positions->save($Positions)) {

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
        $position = $this->Positions->get($id, [
            'contain' => []
        ]);
        $this->set(compact('position'));
        $this->set('id', $id);

        $Offices = $this->Offices->find()
        ->where(['delete_flag' => 0])->toArray();
        $arrOffices = array();
        foreach ($Offices as $value) {
          $arrOffices[] = array($value->id=>$value->name);
        }
        $this->set('arrOffices', $arrOffices);

    }

    public function editconfirm()
    {
      $position = $this->Positions->newEntity();
      $this->set('position', $position);

      $data = $this->request->getData();

      $Offices = $this->Offices->find()
      ->where(['id' => $data['office_id']])->toArray();
      $Office_name = $Offices[0]['name'];
      $this->set('Office_name', $Office_name);
    }

    public function editdo()
    {
      $position = $this->Positions->newEntity();
      $this->set('position', $position);

      $session = $this->request->getSession();
      $datasession = $session->read();

      $data = $this->request->getData();

      $Offices = $this->Offices->find()
      ->where(['id' => $data['office_id']])->toArray();
      $Office_name = $Offices[0]['name'];
      $this->set('Office_name', $Office_name);

      $staff_id = $datasession['Auth']['User']['staff_id'];

      $arrupdateposition = array();
      $arrupdateposition = [
        'id' => $data["id"],
        'position' => $data["position"],
        'office_id' => $data["office_id"],
      ];
/*
      echo "<pre>";
      print_r($arrupdatedepartment);
      echo "</pre>";
*/
      $Positions = $this->Positions->patchEntity($this->Positions->newEntity(), $arrupdateposition);
      $connection = ConnectionManager::get('default');//トランザクション1
       // トランザクション開始2
       $connection->begin();//トランザクション3
       try {//トランザクション4
         if ($this->Positions->updateAll(
           [ 'position' => $arrupdateposition['position'],
             'office_id' => $arrupdateposition['office_id'],
             'updated_at' => date('Y-m-d H:i:s'),
             'updated_staff' => $staff_id],
           ['id'  => $arrupdateposition['id']]
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
        $position = $this->Positions->get($id);
        if ($this->Positions->delete($position)) {
            $this->Flash->success(__('The position has been deleted.'));
        } else {
            $this->Flash->error(__('The position could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
