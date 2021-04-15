<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

use App\myClass\Logins\htmlLogin;//myClassフォルダに配置したクラスを使用
use App\myClass\Productcheck\htmlProductcheck;

class StockProductsController extends AppController
	{

		public function initialize()
		{
		 parent::initialize();
		 $this->Products = TableRegistry::get('products');
		 $this->Customers = TableRegistry::get('customers');
		 $this->Users = TableRegistry::get('users');
		 $this->Staffs = TableRegistry::get('staffs');
		 $this->StockProducts = TableRegistry::get('stockProducts');
		}

		public function yobidashicustomer()
		{
			$StockProducts = $this->StockProducts->newEntity();
			$this->set('StockProducts',$StockProducts);
		}

		public function yobidashipana()
    {
      $this->set('products', $this->Products->find()
       ->select(['product_code','delete_flag' => '0'])
       );
    }

		public function yobidashipanap0()
    {
			$StockProducts = $this->StockProducts->newEntity();
			$this->set('StockProducts',$StockProducts);

       $Products = $this->Products->find()->where(['delete_flag' => 0, "status" => 0])->order(['product_code' => 'ASC'])->toArray();

       $count = count($Products);

       $arrProduct = array();

       for ($k=0; $k<$count; $k++) {
         $product_code = $Products[$k]["product_code"];
         $customer_id = $Products[$k]["customer_id"];
         if((0 === strpos($product_code, "P0")) && ($customer_id == 1)){
             $arrProduct[] = ["product_code" => $product_code, "product_name" => $Products[$k]["product_name"]];
         }
       }

       $this->set('arrProduct',$arrProduct);

			 $Data=$this->request->query('s');
			 if(isset($Data["data"])){
				 $daymoto = $Data["data"];
       }else{
				 $daymoto = date('Y-m-d');
			 }
			 $this->set('daymoto',$daymoto);

    }

		public function yobidashipanap1()
    {
      $StockProducts = $this->StockProducts->newEntity();
      $this->set('StockProducts',$StockProducts);

			$Products = $this->Products->find()->where(['delete_flag' => 0, "status" => 0])->order(['product_code' => 'ASC'])->toArray();

       $count = count($Products);

       $arrProduct = array();

       for ($k=0; $k<$count; $k++) {
         $product_code = $Products[$k]["product_code"];
         $customer_id = $Products[$k]["customer_id"];
         if((0 === strpos($product_code, "P1")) && ($customer_id == 1)){
             $arrProduct[] = ["product_code" => $product_code, "product_name" => $Products[$k]["product_name"]];
         }
       }

       $this->set('arrProduct',$arrProduct);

			 $Data=$this->request->query('s');
			 if(isset($Data["data"])){
				 $daymoto = $Data["data"];
				}else{
				 $daymoto = date('Y-m-d');
			 }
			 $this->set('daymoto',$daymoto);

    }

		public function yobidashipanap2()
    {
      $StockProducts = $this->StockProducts->newEntity();
      $this->set('StockProducts',$StockProducts);

			$Products = $this->Products->find()->where(['delete_flag' => 0, "status" => 0])->order(['product_code' => 'ASC'])->toArray();

       $count = count($Products);

       $arrProduct = array();

       for ($k=0; $k<$count; $k++) {
         $product_code = $Products[$k]["product_code"];
         $customer_id = $Products[$k]["customer_id"];

				 if(((0 === strpos($product_code, "P2")) && ($customer_id == 1)) || ((0 === strpos($product_code, "P3")) && ($customer_id == 1)) || ((0 === strpos($product_code, "P4")) && ($customer_id == 1))){
					 //if(0 !== strpos($product_code, "P0") && 0 !== strpos($product_code, "P1") && 0 !== strpos($product_code, "W") && 0 !== strpos($product_code, "H") && 0 !== strpos($product_code, "RE") && ($customer_id == 1)){
             $arrProduct[] = ["product_code" => $product_code, "product_name" => $Products[$k]["product_name"]];
         }

       }

       $this->set('arrProduct',$arrProduct);

			 $Data=$this->request->query('s');
			 if(isset($Data["data"])){
				 $daymoto = $Data["data"];
				}else{
				 $daymoto = date('Y-m-d');
			 }
			 $this->set('daymoto',$daymoto);
    }

		public function yobidashipanaw()
    {
      $StockProducts = $this->StockProducts->newEntity();
      $this->set('StockProducts',$StockProducts);

			$Products = $this->Products->find()->where(['delete_flag' => 0, "status" => 0])->order(['product_code' => 'ASC'])->toArray();

       $count = count($Products);

       $arrProduct = array();

       for ($k=0; $k<$count; $k++) {
         $product_code = $Products[$k]["product_code"];
         $customer_id = $Products[$k]["customer_id"];
         if(((0 === strpos($product_code, "W")) && ($customer_id == 2)) || ((0 === strpos($product_code, "AW")) && ($customer_id == 2))){
             $arrProduct[] = ["product_code" => $product_code, "product_name" => $Products[$k]["product_name"]];
         }
       }

       $this->set('arrProduct',$arrProduct);

			 $Data=$this->request->query('s');
			 if(isset($Data["data"])){
				 $daymoto = $Data["data"];
				}else{
				 $daymoto = date('Y-m-d');
			 }
			 $this->set('daymoto',$daymoto);
    }

		public function yobidashipanah()
    {
      $StockProducts = $this->StockProducts->newEntity();
      $this->set('StockProducts',$StockProducts);

			$Products = $this->Products->find()->where(['delete_flag' => 0, "status" => 0])->order(['product_code' => 'ASC'])->toArray();

       $count = count($Products);

       $arrProduct = array();

       for ($k=0; $k<$count; $k++) {
         $product_code = $Products[$k]["product_code"];
         $customer_id = $Products[$k]["customer_id"];
         if((0 === strpos($product_code, "H")) && ($customer_id == 2)){
             $arrProduct[] = ["product_code" => $product_code, "product_name" => $Products[$k]["product_name"]];
         }
       }

       $this->set('arrProduct',$arrProduct);

			 $Data=$this->request->query('s');
			 if(isset($Data["data"])){
				 $daymoto = $Data["data"];
				}else{
				 $daymoto = date('Y-m-d');
			 }
			 $this->set('daymoto',$daymoto);
    }

		public function yobidashipanare()
    {
      $StockProducts = $this->StockProducts->newEntity();
      $this->set('StockProducts',$StockProducts);

			$Products = $this->Products->find()->where(['delete_flag' => 0, "status" => 0])->order(['product_code' => 'ASC'])->toArray();

       $count = count($Products);

       $arrProduct = array();

       for ($k=0; $k<$count; $k++) {
         $product_code = $Products[$k]["product_code"];
         $customer_id = $Products[$k]["customer_id"];
         if((0 === strpos($product_code, "R")) && ($customer_id == 3)){
             $arrProduct[] = ["product_code" => $product_code, "product_name" => $Products[$k]["product_name"]];
         }
       }

       $this->set('arrProduct',$arrProduct);

			 $Data=$this->request->query('s');
			 if(isset($Data["data"])){
				 $daymoto = $Data["data"];
				}else{
				 $daymoto = date('Y-m-d');
			 }
			 $this->set('daymoto',$daymoto);
    }

		public function yobidashipanaar()
		{
			$StockProducts = $this->StockProducts->newEntity();
			$this->set('StockProducts',$StockProducts);

			$Products = $this->Products->find()->where(['delete_flag' => 0, "status" => 0])->order(['product_code' => 'ASC'])->toArray();

			 $count = count($Products);

			 $arrProduct = array();

			 for ($k=0; $k<$count; $k++) {
				 $product_code = $Products[$k]["product_code"];
				 if((0 === strpos($product_code, "AR"))){
						 $arrProduct[] = ["product_code" => $product_code, "product_name" => $Products[$k]["product_name"]];
				 }
			 }

			 $this->set('arrProduct',$arrProduct);

			 $Data=$this->request->query('s');
			 if(isset($Data["data"])){
				 $daymoto = $Data["data"];
				}else{
				 $daymoto = date('Y-m-d');
			 }
			 $this->set('daymoto',$daymoto);
		}

		public function yobidashidnp()
    {
      $StockProducts = $this->StockProducts->newEntity();
      $this->set('StockProducts',$StockProducts);

			$Products = $this->Products->find()->where(['delete_flag' => 0, "status" => 0])->order(['product_code' => 'ASC'])->toArray();

       $count = count($Products);

       $arrProduct = array();

       for ($k=0; $k<$count; $k++) {
         $product_code = $Products[$k]["product_code"];
         $customer_id = $Products[$k]["customer_id"];
         if(($customer_id == 11) || ($customer_id == 12) || ($customer_id == 13) || ($customer_id == 14)){
             $arrProduct[] = ["product_code" => $product_code, "product_name" => $Products[$k]["product_name"]];
         }
       }

       $this->set('arrProduct',$arrProduct);

			 $Data=$this->request->query('s');
			 if(isset($Data["data"])){
				 $daymoto = $Data["data"];
				}else{
				 $daymoto = date('Y-m-d');
			 }
			 $this->set('daymoto',$daymoto);

    }

		public function yobidashiothers()
    {
      $StockProducts = $this->StockProducts->newEntity();
      $this->set('StockProducts',$StockProducts);

			$Products = $this->Products->find()->where(['delete_flag' => 0, "status" => 0])->order(['product_code' => 'ASC'])->toArray();

       $count = count($Products);

       $arrProduct = array();

       for ($k=0; $k<$count; $k++) {
         $product_code = $Products[$k]["product_code"];
         $customer_id = $Products[$k]["customer_id"];
         $Customers = $this->Customers->find('all', ['conditions' => ['id' => $customer_id]])->toArray();
         if(isset($Customers[0])){
           $customer_code = $Customers[0]->customer_code;
           if(0 !== strpos($customer_code, "1") && 0 !== strpos($customer_code, "2")){
             $arrProduct[] = ["product_code" => $Products[$k]["product_code"], "product_name" => $Products[$k]["product_name"]];
           }
         }
       }

       $this->set('arrProduct',$arrProduct);

			 $Data=$this->request->query('s');
			 if(isset($Data["data"])){
				 $daymoto = $Data["data"];
				}else{
				 $daymoto = date('Y-m-d');
			 }
			 $this->set('daymoto',$daymoto);
    }

		public function confirm()
	 {
	//	 $this->request->session()->destroy(); // セッションの破棄
		 if(!isset($_SESSION)){//sessionsyuuseituika
		 session_start();
		 }
		 $_SESSION['tourokustock'] = array();
		 $_SESSION['tourokustockupdate'] = array();

		 $StockProducts = $this->StockProducts->newEntity();
		 $this->set('StockProducts',$StockProducts);

		 $data = $this->request->getData();

		 if(isset($data["henkou"])){

			 $datehenkou = $data["datehenkou"]["year"]."-".$data["datehenkou"]["month"]."-".$data["datehenkou"]["day"];

			 return $this->redirect(['action' => $data["namecontroller"],
			 's' => ['data' => $datehenkou]]);

		 }

		 $tourokustock = array();
		 $tourokustockupdate = array();
		 for ($k=0; $k<=$data["num"]; $k++) {

			 if(strlen($data["amount".$k]) > 0){

				 $date = $data["date".$k]["year"]."-".$data["date".$k]["month"]."-".$data["date".$k]["day"];

				 $StockProducts = $this->StockProducts->find()
				 ->where(['date_stock' => $date, "product_code" => $data["product_code".$k], "delete_flag" => 0])
				 ->toArray();

				 if(isset($StockProducts[0])){

					 $tourokustockupdate[] = [
						 'id' => $StockProducts[0]->id,
						 'product_code' => $data["product_code".$k],
						 'amount' => $data["amount".$k],
						 'date_stock' => $date,
						 'updated_staff' => "",
						 'updated_at' => date('Y-m-d H:i:s')
					];

				 }else{

					 $tourokustock[] = [
	 					'product_code' => $data["product_code".$k],
						'amount' => $data["amount".$k],
	 					'date_stock' => $date,
						'created_staff' => "",
						'created_at' => date('Y-m-d H:i:s')
	 			 ];

				 }

			 }


		 }
		 $session = $this->request->getSession();
		 $_SESSION['tourokustock'] = $tourokustock;
		 $_SESSION['tourokustockupdate'] = $tourokustockupdate;

		 $tourokustock = array_merge($tourokustock, $tourokustockupdate);
		 $this->set('tourokustock',$tourokustock);
/*
		 echo "<pre>";
		 print_r($_SESSION);
		 echo "</pre>";
*/
	 }

	 public function preadd()
	 {
		 $StockProducts = $this->StockProducts->newEntity();
		 $this->set('StockProducts',$StockProducts);
	 }

	 public function login()
	 {
		 if ($this->request->is('post')) {
  			$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
  			$str = implode(',', $data);//preadd.ctpで入力したデータをカンマ区切りの文字列にする
  			$ary = explode(',', $str);//$strを配列に変換

  			$username = $ary[0];//入力したデータをカンマ区切りの最初のデータを$usernameとする
  			//※staff_codeをusernameに変換？・・・userが一人に決まらないから無理
  			$this->set('username', $username);
  			$Userdata = $this->Users->find()->where(['username' => $username])->toArray();

  				if(empty($Userdata)){
  					$delete_flag = "";
  				}else{
  					$delete_flag = $Userdata[0]->delete_flag;//配列の0番目（0番目しかない）のnameに$Roleと名前を付ける
  					$this->set('delete_flag',$delete_flag);//登録者の表示のため1行上の$Roleをctpで使えるようにセット
  				}
  					$user = $this->Auth->identify();
  				if ($user) {
  					$this->Auth->setUser($user);
  					return $this->redirect(['action' => 'do']);
  				}
  			}
			}

			public function do()
		 {
			 $StockProducts = $this->StockProducts->newEntity();
			 $this->set('StockProducts',$StockProducts);

			 session_start();
			 $session = $this->request->getSession();
			 $_SESSION = $session->read();//postデータ取得し、$dataと名前を付ける

			 for ($k=0; $k<count($_SESSION['tourokustock']); $k++) {

 				$_SESSION['tourokustock'][$k]['created_staff'] = $_SESSION['Auth']['User']['staff_id'];//created_staffを$staff_idにする

		   }

			 for ($k=0; $k<count($_SESSION['tourokustockupdate']); $k++) {

 				$_SESSION['tourokustockupdate'][$k]['updated_staff'] = $_SESSION['Auth']['User']['staff_id'];//created_staffを$staff_idにする

		   }

			 if(count($_SESSION['tourokustock']) > 0) {

				 $StockProduct = $this->StockProducts->patchEntities($this->StockProducts->newEntity(), $_SESSION['tourokustock']);

			 }
/*
			 echo "<pre>";
	     print_r($_SESSION['tourokustock']);
	     echo "</pre>";
			 echo "<pre>";
	     print_r($_SESSION['tourokustockupdate']);
	     echo "</pre>";
*/
			 $connection = ConnectionManager::get('default');//トランザクション1
			 // トランザクション開始2
			 $connection->begin();//トランザクション3
			 try {//トランザクション4

				 if(isset($_SESSION['tourokustockupdate'][0])){

					 for($k=0; $k<count($_SESSION['tourokustockupdate']); $k++){

						 $this->StockProducts->updateAll(
						 ['product_code' => $_SESSION['tourokustockupdate'][$k]["product_code"],
							'amount' => $_SESSION['tourokustockupdate'][$k]["amount"],
							'date_stock' => $_SESSION['tourokustockupdate'][$k]["date_stock"],
							'updated_staff' => $_SESSION['tourokustockupdate'][$k]["updated_staff"],
							'updated_at' => $_SESSION['tourokustockupdate'][$k]["updated_at"]],
						 ['id' => $_SESSION['tourokustockupdate'][$k]["id"]]
						 );
/*
						 //旧DBに登録
						$connection = ConnectionManager::get('sakaeMotoDB');
						$table = TableRegistry::get('stock_product');
						$table->setConnection($connection);

						 $sql = "SELECT product_id,date_stock FROM stock_product".
						 " where product_id = '".$_SESSION['tourokustockupdate'][$k]["product_code"]."' and date_stock = '".$_SESSION['tourokustockupdate'][$k]["date_stock"]."'";
						 $connection = ConnectionManager::get('sakaeMotoDB');
						 $date_stock_moto = $connection->execute($sql)->fetchAll('assoc');

						 if(isset($date_stock_moto[0])){
							 $updater = "UPDATE stock_product set amount = '".$_SESSION['tourokustockupdate'][$k]["amount"]."'
							 where product_id ='".$_SESSION['tourokustockupdate'][$k]["product_code"]."' and date_stock ='".$_SESSION['tourokustockupdate'][$k]["date_stock"]."'";
							 $connection->execute($updater);
						 }else{

							 $connection->insert('stock_product', [
									 'product_id' => $_SESSION['tourokustockupdate'][$k]["product_code"],
									 'date_stock' => $_SESSION['tourokustockupdate'][$k]["date_stock"],
									 'amount' => $_SESSION['tourokustockupdate'][$k]["amount"]
							 ]);

						 }

						 $connection = ConnectionManager::get('default');//新DBに戻る
						 $table->setConnection($connection);
*/
					 }

					 if(count($_SESSION['tourokustock']) > 0) {

						 if ($this->StockProducts->saveMany($StockProduct)) {
/*
							 //旧DBに登録
							$connection = ConnectionManager::get('sakaeMotoDB');
							$table = TableRegistry::get('stock_product');
							$table->setConnection($connection);

							 for ($k=0; $k<count($_SESSION['tourokustock']); $k++) {

									$connection->insert('stock_product', [
											'product_id' => $_SESSION['tourokustock'][$k]["product_code"],
											'date_stock' => $_SESSION['tourokustock'][$k]["date_stock"],
											'amount' => $_SESSION['tourokustock'][$k]["amount"]
									]);

							 }

							 $connection = ConnectionManager::get('default');//新DBに戻る
							 $table->setConnection($connection);
*/
							 $mes = "※以下のように登録されました";
							 $this->set('mes',$mes);
							 $connection->commit();// コミット5

						 } else {

							 $mes = "※登録されませんでした";
							 $this->set('mes',$mes);
							 $this->Flash->error(__('The data could not be saved. Please, try again.'));
							 throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
						 }

					 }else{

						 $mes = "※以下のように更新されました";
						 $this->set('mes',$mes);
						 $connection->commit();// コミット5

					 }

				 }else{

					 if ($this->StockProducts->saveMany($StockProduct)) {
/*
						 //旧DBに登録
						$connection = ConnectionManager::get('sakaeMotoDB');
						$table = TableRegistry::get('stock_product');
						$table->setConnection($connection);

						 for ($k=0; $k<count($_SESSION['tourokustock']); $k++) {

								$connection->insert('stock_product', [
										'product_id' => $_SESSION['tourokustock'][$k]["product_code"],
										'date_stock' => $_SESSION['tourokustock'][$k]["date_stock"],
										'amount' => $_SESSION['tourokustock'][$k]["amount"]
								]);

						 }

						 $connection = ConnectionManager::get('default');//新DBに戻る
						 $table->setConnection($connection);
*/
						 $mes = "※以下のように登録されました";
						 $this->set('mes',$mes);
						 $connection->commit();// コミット5

					 } else {

						 $mes = "※登録されませんでした";
						 $this->set('mes',$mes);
						 $this->Flash->error(__('The data could not be saved. Please, try again.'));
						 throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
					 }

				 }

				 $connection->commit();// コミット5

			 } catch (Exception $e) {//トランザクション7
			 //ロールバック8
				 $connection->rollback();//トランザクション9
			 }//トランザクション10

			 $tourokustock = array_merge($_SESSION['tourokustock'], $_SESSION['tourokustockupdate']);
			 $this->set('tourokustock',$tourokustock);
		 }

	}
