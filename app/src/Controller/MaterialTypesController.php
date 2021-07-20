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

}
