<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

use App\myClass\Logins\htmlLogin;//myClassフォルダに配置したクラスを使用

class MaterialtypesController extends AppController
{

    public function initialize()
    {
			parent::initialize();
			$this->Staffs = TableRegistry::get('staffs');
			$this->Users = TableRegistry::get('users');
			$this->PriceMaterials = TableRegistry::get('priceMaterials');
			$this->MaterialTypes = TableRegistry::get('materialTypes');
    }

    public function index()
    {

			$session = $this->request->getSession();
			$sessionData = $session->read();

			if(!isset($sessionData['login'])){
				return $this->redirect(['controller' => 'Shinkies', 'action' => 'index']);
			}

      $MaterialTypes = $this->MaterialTypes->find()//CSV未出力データ
      ->where(['delete_flag' => 0])->toArray();
      $this->set('MaterialTypes',$MaterialTypes);

    }

    public function addform()
    {
			$session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['controller' => 'Shinkies', 'action' => 'index']);
      }

			$materialTypes = $this->MaterialTypes->newEntity();
      $this->set('materialTypes',$materialTypes);

			if(!isset($_SESSION)){
				session_start();
			}
				header('Expires:-1');
				header('Cache-Control:');
				header('Pragma:');

    }

     public function addconfirm()
    {
			$session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['controller' => 'Shinkies', 'action' => 'index']);
      }

			$materialTypes = $this->MaterialTypes->newEntity();
      $this->set('materialTypes',$materialTypes);

			$data = $this->request->getData();
			$this->set('name',$data["name"]);
    }

     public function adddo()
    {
			$session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['controller' => 'Shinkies', 'action' => 'index']);
      }

			$materialTypes = $this->MaterialTypes->newEntity();
      $this->set('materialTypes',$materialTypes);

			$data = $this->request->getData();
			$this->set('name',$data["name"]);

			$tourokumaterialTypes = [
				'name' => $data["name"],
				'delete_flag' => 0,
				'created_at' => date('Y-m-d H:i:s'),
				'created_staff' => $sessionData['login']['staff_id'],
			];

			$MaterialTypes = $this->MaterialTypes->patchEntity($this->MaterialTypes->newEntity(), $tourokumaterialTypes);
			$connection = ConnectionManager::get('default');//トランザクション1
			 // トランザクション開始2
			 $connection->begin();//トランザクション3
			 try {//トランザクション4
				 if ($this->MaterialTypes->save($MaterialTypes)) {

					 $mes = "※以下のデータが登録されました";
					 $this->set('mes',$mes);
					 $connection->commit();// コミット5

					 } else {

						 $mes = "※登録されませんでした";
						 $this->set('mes',$mes);
						 $this->Flash->error(__('The product could not be saved. Please, try again.'));
						 throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6

					 }

			 } catch (Exception $e) {//トランザクション7
			 //ロールバック8
				 $connection->rollback();//トランザクション9
			 }//トランザクション10

    }

    public function editform()
    {
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['controller' => 'Shinkies', 'action' => 'index']);
      }

			$materialTypes = $this->MaterialTypes->newEntity();
      $this->set('materialTypes',$materialTypes);

      $Data=$this->request->query('s');
      if(isset($Data["mess"])){
        $mess = $Data["mess"];
        $this->set('mess',$mess);
      }else{
        $data = $this->request->getData();
        $mess = "";
        $this->set('mess',$mess);
      }

      $MaterialTypes_list = $this->MaterialTypes->find()
      ->where(['delete_flag' => 0])->toArray();
      $arrMaterialTypes_list = array();
      for($j=0; $j<count($MaterialTypes_list); $j++){
        array_push($arrMaterialTypes_list,$MaterialTypes_list[$j]["name"]);
      }
      $arrMaterialTypes_list = array_unique($arrMaterialTypes_list);
      $arrMaterialTypes_list = array_values($arrMaterialTypes_list);
      $this->set('arrMaterialTypes_list', $arrMaterialTypes_list);

      if(!isset($_SESSION)){
        session_start();
        header('Expires:-1');
        header('Cache-Control:');
        header('Pragma:');
      }

    }

    public function editformsyousai()
    {
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['controller' => 'Shinkies', 'action' => 'index']);
      }

      $Data=$this->request->query('s');
      if(isset($Data["mess"])){
        $name = $Data["name"];
        $mess = $Data["mess"];
        $this->set('mess',$mess);
      }else{
        $data = $this->request->getData();
        $name = $data["name"];
        $mess = "";
        $this->set('mess',$mess);
      }

      $MaterialTypes = $this->MaterialTypes->find()
      ->where(['name' => $name, 'delete_flag' => 0])->toArray();

      if(!isset($MaterialTypes[0])){

        return $this->redirect(['action' => 'editform',
        's' => ['mess' => "入力された原料種類は登録されていません。"]]);

      }
      $this->set('MaterialTypeId',$MaterialTypes[0]["id"]);

			$materialTypes = $this->MaterialTypes->newEntity();
      $this->set('materialTypes',$materialTypes);

      if(!isset($_SESSION)){
        session_start();
        header('Expires:-1');
        header('Cache-Control:');
        header('Pragma:');
      }

    }

    public function editconfirm()
    {
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['controller' => 'Shinkies', 'action' => 'index']);
      }

      $data = $this->request->getData();

      $this->set('MaterialTypeId',$data["MaterialTypeId"]);
      $this->set('name',$data["name"]);

/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/

			$materialTypes = $this->MaterialTypes->newEntity();
      $this->set('materialTypes',$materialTypes);

      if($data["check"] > 0){
        $mess = "以下のデータを削除します。よろしければ「決定」ボタンを押してください。";
        $delete_flag = 1;

        $MaterialTypes = $this->MaterialTypes->find()
        ->where(['id' => $data["MaterialTypeId"]])->toArray();
        $this->set('name',$MaterialTypes[0]["name"]);

      }else{

        $MaterialTypes = $this->MaterialTypes->find()
        ->where(['name' => $data["name"], 'delete_flag' => 0])->toArray();

        if(isset($MaterialTypes[0])){

          return $this->redirect(['action' => 'editformsyousai',
          's' => ['name' => $data["name"], 'mess' => "入力された原料種類は既に存在します。"]]);

        }

        $mess = "以下のように更新します。よろしければ「決定」ボタンを押してください。";
        $delete_flag = 0;
      }
      $this->set('mess', $mess);
      $this->set('delete_flag', $delete_flag);

      if(!isset($_SESSION)){
        session_start();
        header('Expires:-1');
        header('Cache-Control:');
        header('Pragma:');
      }

    }

    public function editdo()
    {
      $session = $this->request->getSession();
      $sessionData = $session->read();

      if(!isset($sessionData['login'])){
        return $this->redirect(['controller' => 'Shinkies', 'action' => 'index']);
      }

      $data = $this->request->getData();
      $this->set('name',$data["name"]);
/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
			$materialTypes = $this->MaterialTypes->newEntity();
      $this->set('materialTypes',$materialTypes);

      $MaterialTypes = $this->MaterialTypes->patchEntity($this->MaterialTypes->newEntity(), $data);
      $connection = ConnectionManager::get('default');//トランザクション1
       // トランザクション開始2
       $connection->begin();//トランザクション3
       try {//トランザクション4

         if($data["delete_flag"] > 0){

           if ($this->MaterialTypes->updateAll(
             ['delete_flag' => 1, 'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $sessionData['login']['staff_id']],
             ['id'  => $data["MaterialTypeId"]]
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

           if ($this->MaterialTypes->updateAll(
             ['name' => $data["name"], 'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $sessionData['login']['staff_id']],
             ['id'  => $data["MaterialTypeId"]]
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

}
