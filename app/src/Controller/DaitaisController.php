<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

use App\myClass\Logins\htmlLogin;//myClassフォルダに配置したクラスを使用

class DaitaisController extends AppController
{

    public function initialize()
    {
			parent::initialize();
			$this->Staffs = TableRegistry::get('staffs');
			$this->Users = TableRegistry::get('users');
      $this->Materials = TableRegistry::get('materials');
    }

    public function index()
    {
      $Materials = $this->Materials->newEntity();
      $this->set('Materials',$Materials);

			$session = $this->request->getSession();
			$sessionData = $session->read();

			if(!isset($sessionData['login'])){
				return $this->redirect(['controller' => 'Shinkies', 'action' => 'index']);
			}

      $arrMaterials = array();
      $Materials = $this->Materials->find()//CSV未出力データ
      ->where(['delete_flag' => 0])->order(["grade"=>"ASC"])->toArray();

      for($j=0; $j<count($Materials); $j++){

        if(strlen($Materials[$j]["grade"]) + strlen($Materials[$j]["color"]) + 1 > 20){

          if(strlen($Materials[$j]["name_substitute"]) > 0){
            $name_substitute = $Materials[$j]["name_substitute"];
          }else{
            $name_substitute = "登録されていません";
          }

          $arrMaterials[] = [
            "id" => $Materials[$j]["id"],
            "grade" => $Materials[$j]["grade"],
            "color" => $Materials[$j]["color"],
            "name_substitute" => $name_substitute
          ];
        }

      }

      $this->set('arrMaterials',$arrMaterials);

    }

    public function editkensaku()
    {
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['controller' => 'Shinkies', 'action' => 'index']);
      }

			$Materials = $this->Materials->newEntity();
      $this->set('Materials',$Materials);

      $Data=$this->request->query('s');
      if(isset($Data["mess"])){
        $mess = $Data["mess"];
        $this->set('mess',$mess);
      }else{
        $data = $this->request->getData();
        $mess = "";
        $this->set('mess',$mess);
      }

      $Material_list = $this->Materials->find()
      ->where(['delete_flag' => 0])->toArray();
      $arrMaterial_list = array();
      for($j=0; $j<count($Material_list); $j++){

        if(strlen($Material_list[$j]["grade"]) + strlen($Material_list[$j]["color"]) + 1 > 20){

          array_push($arrMaterial_list,$Material_list[$j]["grade"]."_".$Material_list[$j]["color"]);

        }

      }
      $arrMaterial_list = array_unique($arrMaterial_list);
      $arrMaterial_list = array_values($arrMaterial_list);
      $this->set('arrMaterial_list', $arrMaterial_list);

      if(!isset($_SESSION)){
        session_start();
        header('Expires:-1');
        header('Cache-Control:');
        header('Pragma:');
      }

    }

    public function editform()
    {
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['controller' => 'Shinkies', 'action' => 'index']);
      }

      $Data=$this->request->query('s');
      if(isset($Data["mess"])){
        $Id = $Data["Id"];
        $mess = $Data["mess"];
        $this->set('mess',$mess);
      }else{
        $data = $this->request->getData();
        $mess = "";
        $this->set('mess',$mess);
        $data = array_keys($data, '編集');
        $Id = $data[0];
      }

      $Materials = $this->Materials->find()
      ->where(['id' => $Id])->toArray();

      $materialgrade_color = $Materials[0]["grade"]."_".$Materials[0]["color"];
      $this->set('materialgrade_color',$materialgrade_color);
      $this->set('MaterialId',$Id);

			$Materials = $this->Materials->newEntity();
      $this->set('Materials',$Materials);

      header('Expires:-1');
      header('Cache-Control:');
      header('Pragma:');

    }

    public function editconfirm()
    {
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['controller' => 'Shinkies', 'action' => 'index']);
      }

      $data = $this->request->getData();
      $MaterialId = $data["MaterialId"];
      $this->set('MaterialId',$MaterialId);
      $materialgrade_color = $data["materialgrade_color"];
      $this->set('materialgrade_color',$materialgrade_color);
      $name_substitute = $data["name_substitute"];
      $this->set('name_substitute',$name_substitute);

      if(strlen($name_substitute) > 20){
        return $this->redirect(['action' => 'editform',
        's' => ['Id' => $MaterialId, 'mess' => "代替名は20字以下にしてください。"]]);
      }

      $Materials = $this->Materials->newEntity();
      $this->set('Materials',$Materials);

      header('Expires:-1');
      header('Cache-Control:');
      header('Pragma:');

    }

    public function editdo()
    {
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['controller' => 'Shinkies', 'action' => 'index']);
      }

      $data = $this->request->getData();

      $Materials = $this->Materials->newEntity();
      $this->set('Materials',$Materials);

      $MaterialId = $data["MaterialId"];
      $this->set('MaterialId',$MaterialId);
      $materialgrade_color = $data["materialgrade_color"];
      $this->set('materialgrade_color',$materialgrade_color);
      $name_substitute = $data["name_substitute"];
      $this->set('name_substitute',$name_substitute);

      $Materials = $this->Materials->patchEntity($this->Materials->newEntity(), $data);
      $connection = ConnectionManager::get('default');//トランザクション1
       // トランザクション開始2
       $connection->begin();//トランザクション3
       try {//トランザクション4

         if ($this->Materials->updateAll(
           ['name_substitute' => $data["name_substitute"], 'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $sessionData['login']['staff_id']],
           ['id'  => $data["MaterialId"]]
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

       } catch (Exception $e) {//トランザクション7
       //ロールバック8
         $connection->rollback();//トランザクション9
       }//トランザクション10

    }

}
