<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション
use Cake\ORM\TableRegistry;//独立したテーブルを扱う

class DepartmentsController extends AppController
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
        $departments = $this->paginate($this->Departments);

        $this->set(compact('departments'));
    }

    public function view($id = null)
    {
        $department = $this->Departments->get($id, [
            'contain' => ['Offices', 'Staffs']
        ]);

        $this->set('department', $department);
    }

    public function addform()
    {
      $department = $this->Departments->newEntity();
      $this->set('department', $department);

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
      $department = $this->Departments->newEntity();
      $this->set('department', $department);

      $data = $this->request->getData();

      $Offices = $this->Offices->find()
      ->where(['id' => $data['office_id']])->toArray();
      $Office_name = $Offices[0]['name'];
      $this->set('Office_name', $Office_name);

    }

    public function adddo()
    {
      $department = $this->Departments->newEntity();
      $this->set('department', $department);

      $data = $this->request->getData();

      $Offices = $this->Offices->find()
      ->where(['id' => $data['office_id']])->toArray();
      $Office_name = $Offices[0]['name'];
      $this->set('Office_name', $Office_name);

      $session = $this->request->getSession();
      $datasession = $session->read();

      $staff_id = $datasession['Auth']['User']['staff_id'];

      $arrtourokudepartment = array();
      $arrtourokudepartment = [
        'department' => $data["department"],
        'office_id' => $data["office_id"],
        'delete_flag' => 0,
        'created_at' => date("Y-m-d H:i:s"),
        'created_staff' => $staff_id
      ];
/*
      echo "<pre>";
      print_r($arrtourokudepartment);
      echo "</pre>";
*/
      //新しいデータを登録
      $Departments = $this->Departments->patchEntity($this->Departments->newEntity(), $arrtourokudepartment);
      $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        if ($this->Departments->save($Departments)) {

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
        $department = $this->Departments->get($id, [
            'contain' => []
        ]);
        $this->set(compact('department'));
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
      $department = $this->Departments->newEntity();
      $this->set('department', $department);

      $data = $this->request->getData();

      $Offices = $this->Offices->find()
      ->where(['id' => $data['office_id']])->toArray();
      $Office_name = $Offices[0]['name'];
      $this->set('Office_name', $Office_name);
    }

    public function editdo()
    {
      $department = $this->Departments->newEntity();
      $this->set('department', $department);

      $session = $this->request->getSession();
      $datasession = $session->read();

      $data = $this->request->getData();

      $Offices = $this->Offices->find()
      ->where(['id' => $data['office_id']])->toArray();
      $Office_name = $Offices[0]['name'];
      $this->set('Office_name', $Office_name);

      $staff_id = $datasession['Auth']['User']['staff_id'];

      $arrupdatedepartment = array();
      $arrupdatedepartment = [
        'id' => $data["id"],
        'department' => $data["department"],
        'office_id' => $data["office_id"],
      ];
/*
      echo "<pre>";
      print_r($arrupdatedepartment);
      echo "</pre>";
*/
      $Departments = $this->Departments->patchEntity($this->Departments->newEntity(), $arrupdatedepartment);
      $connection = ConnectionManager::get('default');//トランザクション1
       // トランザクション開始2
       $connection->begin();//トランザクション3
       try {//トランザクション4
         if ($this->Departments->updateAll(
           [ 'department' => $arrupdatedepartment['department'],
             'office_id' => $arrupdatedepartment['office_id'],
             'updated_at' => date('Y-m-d H:i:s'),
             'updated_staff' => $staff_id],
           ['id'  => $arrupdatedepartment['id']]
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
        $department = $this->Departments->get($id);
        if ($this->Departments->delete($department)) {
            $this->Flash->success(__('The department has been deleted.'));
        } else {
            $this->Flash->error(__('The department could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
