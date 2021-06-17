<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

use Cake\Utility\Xml;//xmlのファイルを読み込みために必要
use Cake\Utility\Text;
use Cake\Routing\Router;//urlの取得
use Cake\Http\Client;//httpの読取に必要

class ApishiiresController extends AppController
	{

		public function initialize()
		{
		 parent::initialize();
		 $this->Products = TableRegistry::get('products');
		 $this->ProductGaityus = TableRegistry::get('productGaityus');
		 $this->ProductSuppliers = TableRegistry::get('productSuppliers');
		 $this->StockProducts = TableRegistry::get('stockProducts');
		 $this->OrderToSuppliers = TableRegistry::get('orderToSuppliers');
		 $this->OrderYobistockSuppliers = TableRegistry::get('orderYobistockSuppliers');
		 $this->UnitOrderToSuppliers = TableRegistry::get('unitOrderToSuppliers');
		 $this->OrderEdis = TableRegistry::get('orderEdis');
		 $this->StockInoutWorklogs = TableRegistry::get('stockInoutWorklogs');
		}

//http://192.168.4.246/Apishiires/test16/api/test.xml  http://localhost:5000/Apishiires/test16/api/test.xml
		public function test16()
		{
		//	$this->request->session()->destroy();//セッションの破棄
//実験
			session_start();
			$session = $this->request->getSession();
			$_SESSION['siiretest'][0] = 1;

			echo "<pre>";
			print_r($_SESSION);
			echo "</pre>";

			$this->set([
  			 'test' => "セッション表示中",
  			 '_serialize' => ['test']
  		 ]);

		}

		//http://192.168.4.246/Apishiires/zaiko/api/2021-6_9.xml  http://localhost:5000/Apishiires/zaiko/api/2021-6_9.xml
		public function zaiko()
		{
			$data = Router::reverse($this->request, false);//文字化けする後で2回変換すると日本語OK
			$data = urldecode($data);

			$urlarr = explode("/",$data);//切り離し
			$dataarr = explode("_",$urlarr[4]);//切り離し

			$arrsupplier_id = explode(".",$dataarr[1]);//切り離し
			$supplier_id = $arrsupplier_id[0];

			$day = $dataarr[0];//日付の取得

			$date1 = $day."-1";//選択した日程の月の初日2021-6-1
			$date1st = strtotime($date1);
			$datenext1st = date('Y-m-d', strtotime('+1 month', $date1st));
			$datenext = strtotime($datenext1st);
			$datetolast = date('Y-m-d', strtotime('-1 day', $datenext));//選択した月の最後の日2021-6-30

			$datelast = date('Y-m-d', strtotime('-1 day', $date1st));
			$dateback1st = date('Y-m-d', strtotime('-1 month', $date1st));//選択した月の前の月の初日2021-5-1
			$dateback = strtotime($dateback1st);
			$datebacklast = date('Y-m-d', strtotime('-1 day', $date1st));//選択した月の前の月の最後の日2021-5-31

			$arrShiireproducts = array();
			$arrStockproducts = array();
			$arrOrderToSuppliers = array();
			$arrUkeireSuppliers = array();
			$arrOrderEdis = array();
/*
			echo "<pre>";
			print_r($date1);
			echo "</pre>";
			echo "<pre>";
			print_r($datetolast);
			echo "</pre>";
			echo "<pre>";
			print_r($dateback1st);
			echo "</pre>";
			echo "<pre>";
			print_r($datebacklast);
			echo "</pre>";
*/
			$ProductSuppliers = $this->ProductSuppliers->find()->where(['id' => $supplier_id])->toArray();
			$supplier_name = $ProductSuppliers[0]->name;

			$ProductGaityus = $this->ProductGaityus->find()
			->where(['flag_denpyou' => 1, 'status' => 0, 'id_supplier' => $supplier_id])
			->order(["product_code"=>"ASC"])->toArray();

			for($k=0; $k<count($ProductGaityus); $k++){

				$Product = $this->Products->find()->where(['product_code' => $ProductGaityus[$k]["product_code"]])->toArray();

				if(isset($Product[0])){

					$product_name = $Product[0]->product_name;
					$UnitOrderToSuppliers = $this->UnitOrderToSuppliers->find()
					->where(['product_code' => $ProductGaityus[$k]["product_code"]])->toArray();

					if(isset($UnitOrderToSuppliers[0])){
						$kijyun_stock = $UnitOrderToSuppliers[0]->kijyun_stock;
					}else{
						$kijyun_stock = 0;
					}

					//元のデータの配列
					$arrShiireproducts[] = [
						'product_code' => $ProductGaityus[$k]["product_code"],
						'product_name' => $product_name,
						'supplier_name' => $supplier_name,
						'kijyun_stock' => $kijyun_stock,
						'supplier_id' => $supplier_id,
				 ];

					 //納入数（発注数）
					 $OrderToSuppliers = $this->OrderToSuppliers->find()
	 				->where(['product_code' => $ProductGaityus[$k]["product_code"], 'date_deliver >=' => $date1,
					 'date_deliver <=' => $datetolast, 'delete_flag' => 0])
	 				->order(["date_deliver"=>"ASC"])->toArray();

					for($n=0; $n<count($OrderToSuppliers); $n++){

						$amount = $OrderToSuppliers[$n]["amount"];

						$OrderYobistockSuppliers = $this->OrderYobistockSuppliers->find()
						->where(['product_code' => $ProductGaityus[$k]["product_code"],
						 'date_deliver' => $OrderToSuppliers[$n]["date_deliver"], 'delete_flag' => 0])
	 	 				->toArray();

						for($m=0; $m<count($OrderYobistockSuppliers); $m++){//予備在庫を合算

							$amount = $amount + $OrderYobistockSuppliers[$m]["amount"];

						}

						$arrOrderToSuppliers[] = [
							'product_code' => $ProductGaityus[$k]["product_code"],
							'date_deliver' => $OrderToSuppliers[$n]["date_deliver"],
							'amount' => $amount,
					 ];

					}

					//納品数（顧客納品数）
					if($ProductGaityus[$k]["product_code"] === "W0341-7PJ00T"){//1

						$OrderEdis = $this->OrderEdis->find()
					 ->where(['product_code like' => 'AWW003P%', 'date_deliver >=' => $date1,
					  'date_deliver <=' => $datetolast, 'delete_flag' => 0])
					 ->order(["date_deliver"=>"ASC"])->toArray();

					 for($n=0; $n<count($OrderEdis); $n++){

						 $arrOrderEdis[] = [
							 'product_code' => $ProductGaityus[$k]["product_code"],
							 'date_deliver' => $OrderEdis[$n]["date_deliver"],
							 'amount' => $OrderEdis[$n]["amount"],
						];

					 }

				 }elseif($ProductGaityus[$k]["product_code"] === "W0341-7PL00"){//2

 						$OrderEdis = $this->OrderEdis->find()
 					 ->where(['product_code' => 'W003P-7PL00', 'date_deliver >=' => $date1,
 					  'date_deliver <=' => $datetolast, 'delete_flag' => 0])
 					 ->order(["date_deliver"=>"ASC"])->toArray();

 					 for($n=0; $n<count($OrderEdis); $n++){

 						 $arrOrderEdis[] = [
 							 'product_code' => $ProductGaityus[$k]["product_code"],
 							 'date_deliver' => $OrderEdis[$n]["date_deliver"],
 							 'amount' => $OrderEdis[$n]["amount"],
 						];

 					 }

				 }elseif($ProductGaityus[$k]["product_code"] === "W1803-60000"){//3

 						$OrderEdis = $this->OrderEdis->find()
 					 ->where(['product_code' => 'W1803-6CB20', 'date_deliver >=' => $date1,
 					  'date_deliver <=' => $datetolast, 'delete_flag' => 0])
 					 ->order(["date_deliver"=>"ASC"])->toArray();

 					 for($n=0; $n<count($OrderEdis); $n++){

 						 $arrOrderEdis[] = [
 							 'product_code' => $ProductGaityus[$k]["product_code"],
 							 'date_deliver' => $OrderEdis[$n]["date_deliver"],
 							 'amount' => $OrderEdis[$n]["amount"],
 						];

 					 }

				 }elseif($ProductGaityus[$k]["product_code"] === "P2150-47400"){//4

 						$OrderEdis = $this->OrderEdis->find()
 					 ->where(['product_code' => 'P219A-47400', 'date_deliver >=' => $date1,
 					  'date_deliver <=' => $datetolast, 'delete_flag' => 0])
 					 ->order(["date_deliver"=>"ASC"])->toArray();

 					 for($n=0; $n<count($OrderEdis); $n++){

 						 $arrOrderEdis[] = [
 							 'product_code' => $ProductGaityus[$k]["product_code"],
 							 'date_deliver' => $OrderEdis[$n]["date_deliver"],
 							 'amount' => $OrderEdis[$n]["amount"],
 						];

 					 }

				 }elseif($ProductGaityus[$k]["product_code"] === "P2192-45910"){//5

 						$OrderEdis = $this->OrderEdis->find()
 					 ->where(['product_code' => 'P219A-47400', 'date_deliver >=' => $date1,
 					  'date_deliver <=' => $datetolast, 'delete_flag' => 0])
 					 ->order(["date_deliver"=>"ASC"])->toArray();

 					 for($n=0; $n<count($OrderEdis); $n++){

 						 $arrOrderEdis[] = [
 							 'product_code' => $ProductGaityus[$k]["product_code"],
 							 'date_deliver' => $OrderEdis[$n]["date_deliver"],
 							 'amount' => $OrderEdis[$n]["amount"],
 						];

 					 }

 					}else{

						$OrderEdis = $this->OrderEdis->find()
					 ->where(['product_code' => $ProductGaityus[$k]["product_code"], 'date_deliver >=' => $date1,
					  'date_deliver <=' => $datetolast, 'delete_flag' => 0])
					 ->order(["date_deliver"=>"ASC"])->toArray();

					 for($n=0; $n<count($OrderEdis); $n++){

						 $arrOrderEdis[] = [
							 'product_code' => $ProductGaityus[$k]["product_code"],
							 'date_deliver' => $OrderEdis[$n]["date_deliver"],
							 'amount' => $OrderEdis[$n]["amount"],
						];

					 }

				 }//納品数（顧客納品数）ここまで

					 //受入数
					 $StockInoutWorklogs = $this->StockInoutWorklogs->find()
					->where(['product_code' => $ProductGaityus[$k]["product_code"], 'date_work >=' => $date1,
					 'date_work <=' => $datetolast, 'flag_manual' => 1, 'delete_flag' => 0])
					->order(["date_work"=>"ASC"])->toArray();

					for($n=0; $n<count($StockInoutWorklogs); $n++){

						$arrUkeireSuppliers[] = [
							'product_code' => $ProductGaityus[$k]["product_code"],
							'date_work' => $StockInoutWorklogs[$n]["date_work"],
							'amount' => $StockInoutWorklogs[$n]["amount"],
					 ];

					}

				}

			}

			//月末在庫
			for($k=0; $k<count($arrShiireproducts); $k++){

				$StockProducts = $this->StockProducts->find()
				->where(['product_code' => $arrShiireproducts[$k]["product_code"],
				 'date_stock >=' => $dateback1st, 'date_stock <=' => $datebacklast])
				->order(["date_stock"=>"DESC"])->toArray();

				if(isset($StockProducts[0])){

					$arrStockproducts[] = [
						'product_code' => $StockProducts[0]["product_code"],
						'date_stock' => $StockProducts[0]["date_stock"],
						'amount' => $StockProducts[0]["amount"],
				 ];

				}

			}

			$this->set([
				'SupplierProducts' => $arrShiireproducts,
				'StockProducts' => $arrStockproducts,
				'OrderToSuppliers' => $arrOrderToSuppliers,
				'UkeireSuppliers' => $arrUkeireSuppliers,
				'OrderEdis' => $arrOrderEdis,
				'_serialize' => ['SupplierProducts','StockProducts','OrderToSuppliers','UkeireSuppliers','OrderEdis']
			 ]);

		}

		public function zaiko16()
		{
		}

	}
