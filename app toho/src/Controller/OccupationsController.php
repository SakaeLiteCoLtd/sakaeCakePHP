<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション
use Cake\ORM\TableRegistry;//独立したテーブルを扱う

class OccupationsController extends AppController
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
        $occupations = $this->paginate($this->Occupations);

        $this->set(compact('occupations'));
    }

    public function view($id = null)
    {
        $occupation = $this->Occupations->get($id, [
            'contain' => ['Offices', 'Staffs']
        ]);

        $this->set('occupation', $occupation);
    }

    public function addform()
    {
      $occupation = $this->Occupations->newEntity();
      $this->set('occupation', $occupation);

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
      $occupation = $this->Occupations->newEntity();
      $this->set('occupation', $occupation);

      $data = $this->request->getData();

      $Offices = $this->Offices->find()
      ->where(['id' => $data['office_id']])->toArray();
      $Office_name = $Offices[0]['name'];
      $this->set('Office_name', $Office_name);

    }

    public function adddo()
    {
      $occupation = $this->Occupations->newEntity();
      $this->set('occupation', $occupation);

      $data = $this->request->getData();

      $Offices = $this->Offices->find()
      ->where(['id' => $data['office_id']])->toArray();
      $Office_name = $Offices[0]['name'];
      $this->set('Office_name', $Office_name);

      $session = $this->request->getSession();
      $datasession = $session->read();

      $staff_id = $datasession['Auth']['User']['staff_id'];

      $arrtourokuoccupation = array();
      $arrtourokuoccupation = [
        'occupation' => $data["occupation"],
        'office_id' => $data["office_id"],
        'delete_flag' => 0,
        'created_at' => date("Y-m-d H:i:s"),
        'created_staff' => $staff_id
      ];
/*
      echo "<pre>";
      print_r($arrtourokuoccupation);
      echo "</pre>";
*/
      //新しいデータを登録
      $Occupations = $this->Occupations->patchEntity($this->Occupations->newEntity(), $arrtourokuoccupation);
      $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        if ($this->Occupations->save($Occupations)) {

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
        $occupation = $this->Occupations->get($id, [
            'contain' => []
        ]);
        $this->set(compact('occupation'));
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
      $occupation = $this->Occupations->newEntity();
      $this->set('occupation', $occupation);

      $data = $this->request->getData();

      $Offices = $this->Offices->find()
      ->where(['id' => $data['office_id']])->toArray();
      $Office_name = $Offices[0]['name'];
      $this->set('Office_name', $Office_name);
    }

    public function editdo()
    {
      $occupation = $this->Occupations->newEntity();
      $this->set('occupation', $occupation);

      $session = $this->request->getSession();
      $datasession = $session->read();

      $data = $this->request->getData();

      $Offices = $this->Offices->find()
      ->where(['id' => $data['office_id']])->toArray();
      $Office_name = $Offices[0]['name'];
      $this->set('Office_name', $Office_name);

      $staff_id = $datasession['Auth']['User']['staff_id'];

      $arrupdateoccupation = array();
      $arrupdateoccupation = [
        'id' => $data["id"],
        'occupation' => $data["occupation"],
        'office_id' => $data["office_id"],
      ];
/*
      echo "<pre>";
      print_r($arrupdateoccupation);
      echo "</pre>";
*/
      $Occupations = $this->Occupations->patchEntity($this->Occupations->newEntity(), $arrupdateoccupation);
      $connection = ConnectionManager::get('default');//トランザクション1
       // トランザクション開始2
       $connection->begin();//トランザクション3
       try {//トランザクション4
         if ($this->Occupations->updateAll(
           [ 'occupation' => $arrupdateoccupation['occupation'],
             'office_id' => $arrupdateoccupation['office_id'],
             'updated_at' => date('Y-m-d H:i:s'),
             'updated_staff' => $staff_id],
           ['id'  => $arrupdateoccupation['id']]
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
        $occupation = $this->Occupations->get($id);
        if ($this->Occupations->delete($occupation)) {
            $this->Flash->success(__('The occupation has been deleted.'));
        } else {
            $this->Flash->error(__('The occupation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
