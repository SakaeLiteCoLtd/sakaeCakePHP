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

class ApishiiredaichousController extends AppController
	{

		public function initialize()
		{
		 parent::initialize();
		 $this->Products = TableRegistry::get('products');
		 $this->StockInoutWorklogs = TableRegistry::get('stockInoutWorklogs');
		 $this->OutsourceHandys = TableRegistry::get('outsourceHandys');
		 $this->ProductSuppliers = TableRegistry::get('productSuppliers');
		 $this->ProductGaityus = TableRegistry::get('productGaityus');
		 $this->OrderSpecialShiires = TableRegistry::get('orderSpecialShiires');
		 $this->AccountProductKaikakes = TableRegistry::get('accountProductKaikakes');
		 $this->AccountKaikakeElements = TableRegistry::get('accountKaikakeElements');
		 $this->AccountYusyouzaiUkeires = TableRegistry::get('accountYusyouzaiUkeires');
		 $this->AccountYusyouzaiMasters = TableRegistry::get('accountYusyouzaiMasters');
		 $this->Customers = TableRegistry::get('customers');
		 $this->Products = TableRegistry::get('products');
		}

													     //http://192.168.4.246/Apishiiredaichous/yobidashi/api/2021-6-9_2021-6-20.xml
		public function yobidashi()//http://localhost:5000/Apishiiredaichous/yobidashi/api/2021-6-9_2021-6-20.xml
		{
			$data = Router::reverse($this->request, false);//文字化けする後で2回変換すると日本語OK
			$data = urldecode($data);

			$urlarr = explode("/",$data);//切り離し
			$dataarr = explode("_",$urlarr[4]);//切り離し

			$daysta = $dataarr[0];//日付の取得
			$dayfinarr = explode(".",$dataarr[1]);//切り離し
			$dayfin = $dayfinarr[0];//日付の取得

			$arrLoadShiire = array();
			$arrLoadOrderSpecialShiire = array();
			$arrLoadAccountElementsKaikakeZengetsuKurikoshi = array();
			$arrLoadAccountElementsKaikake = array();
			$arrLoadYusyouzaiUkeire = array();

			//ここから$arrLoadShiire
			$StockInoutWorklogs = $this->StockInoutWorklogs->find()
			->where(['type' => 1, 'date_work >=' => $daysta, 'date_work <=' => $dayfin, 'is_canceled' => 0, 'delete_flag' => 0])
			->toArray();

			if(count($StockInoutWorklogs) > 0){

 			 $date_work_array = array();
 	     $product_code_array = array();
 	     foreach($StockInoutWorklogs as $key => $row) {
 	       $date_work_array[$key] = $row["date_work"];
 	       $product_code_array[$key] = $row["product_code"];
 	     }

 			 array_multisort(array_map( "strtotime", $date_work_array ), SORT_ASC, $product_code_array, SORT_ASC, $StockInoutWorklogs);

		 }

		 $arrStockInoutWorklogs = array();
		 for($k=0; $k<count($StockInoutWorklogs); $k++){

			 $ProductSuppliers = $this->ProductSuppliers->find()
			 ->where(['handy_id' => $StockInoutWorklogs[$k]["outsource_code"]])->toArray();

			$ProductGaityus = $this->ProductGaityus->find()
			->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'status' => 0])->toArray();

			if(isset($ProductGaityus[0])){
				$price = $ProductGaityus[0]["price_shiire"];
			}else{
				$price = 0;
			}

			if($ProductSuppliers[0]["id"] != 22){

				$arrStockInoutWorklogs[] = [
 				 'id' => $StockInoutWorklogs[$k]["id"],
 				 'name' => $ProductSuppliers[0]["name"],
 				 'sup_id' => $ProductSuppliers[0]["id"],
 				 'product_code' => $StockInoutWorklogs[$k]["product_code"],
 				 'date_work' => $StockInoutWorklogs[$k]->date_work->format('Y-m-d'),
 				 'amount' => $StockInoutWorklogs[$k]["amount"],
 				 'lot_num' => $StockInoutWorklogs[$k]["lot_num"],
 				 'price' => $price,
 			 ];

			}

		 }

		 $arrLoadShiire = $arrStockInoutWorklogs;//$arrLoadShiire完成

		 //ここから$arrLoadOrderSpecialShiire
		 $OrderSpecialShiires = $this->OrderSpecialShiires->find()
		 ->where(['date_deliver >=' => $daysta, 'date_deliver <=' => $dayfin, 'kannou' => 1, 'delete_flag' => 0])
		 ->toArray();

		 if(count($OrderSpecialShiires) > 0){

			$date_deliver_array = array();
			$num_order_array = array();
			foreach($OrderSpecialShiires as $key => $row) {
				$date_deliver_array[$key] = $row["date_deliver"];
				$num_order_array[$key] = $row["num_order"];
			}

			array_multisort(array_map( "strtotime", $date_deliver_array ), SORT_ASC, $num_order_array, SORT_ASC, $OrderSpecialShiires);

		}

		$arrOrderSpecialShiire = array();
		for($k=0; $k<count($OrderSpecialShiires); $k++){

			$ProductSuppliers = $this->ProductSuppliers->find()
			->where(['id' => $OrderSpecialShiires[$k]["product_supplier_id"]])->toArray();

			$arrOrderSpecialShiire[] = [
			 'name' => $ProductSuppliers[0]["name"],
			 'date_deliver' => $OrderSpecialShiires[$k]->date_deliver->format('Y-m-d'),
			 'num_order' => "S".$OrderSpecialShiires[$k]["num_order"],
			 'order_name' => $OrderSpecialShiires[$k]["order_name"],
			 'amount' => $OrderSpecialShiires[$k]["amount"],
			 'price' => $OrderSpecialShiires[$k]["price"],
			 'sup_id' => $ProductSuppliers[0]["id"],
		 ];

		}

		$arrLoadOrderSpecialShiire = $arrOrderSpecialShiire;//$arrLoadOrderSpecialShiire完成

		//ここから$arrLoadAccountElementsKaikakeZengetsuKurikoshi,$arrLoadAccountElementsKaikake
		$AccountProductKaikakes = $this->AccountProductKaikakes->find()
		->where(['date >=' => $daysta, 'date <=' => $dayfin, 'delete_flag' => 0])
		->toArray();

		if(count($AccountProductKaikakes) > 0){

		 $date_array = array();
		 $sup_id_array = array();
		 foreach($AccountProductKaikakes as $key => $row) {
			 $date_array[$key] = $row["date"];
			 $sup_id_array[$key] = $row["sup_id"];
		 }

		 array_multisort($sup_id_array, SORT_ASC, array_map( "strtotime", $date_array ), SORT_ASC, $AccountProductKaikakes);

	 }

	 $arrAccountElementsKaikakeZengetsuKurikoshi = array();
	 $arrAccountElementsKaikake = array();
	 for($k=0; $k<count($AccountProductKaikakes); $k++){

		 $ProductSuppliers = $this->ProductSuppliers->find()
		 ->where(['id' => $AccountProductKaikakes[$k]["sup_id"]])->toArray();

		 $AccountKaikakeElements = $this->AccountKaikakeElements->find()
		 ->where(['id' => $AccountProductKaikakes[$k]["kaikake_element_id"]])->toArray();

		 if($AccountProductKaikakes[$k]["kaikake_element_id"] == 1){//前月繰越は1日マイナスする

			 $datemoto = strtotime($AccountProductKaikakes[$k]->date->format('Y-m-d'));
			 $date = date('Y-m-d', strtotime('-1 day', $datemoto));

			 $arrAccountElementsKaikakeZengetsuKurikoshi[] = [
				 'sup_id' => $ProductSuppliers[0]["id"],
				 'name' => $ProductSuppliers[0]["name"],
				 'kingaku' => $AccountProductKaikakes[$k]["kingaku"],
				 'date' => $date,
				 'kaikake_element_id' => $AccountProductKaikakes[$k]["kaikake_element_id"],
				 'element' => $AccountKaikakeElements[0]["element"],
				 'num_order' => 0,
			];

		 }else{

			 $date = $AccountProductKaikakes[$k]->date->format('Y-m-d');

			 $arrAccountElementsKaikake[] = [
				 'sup_id' => $ProductSuppliers[0]["id"],
				 'name' => $ProductSuppliers[0]["name"],
				 'kingaku' => $AccountProductKaikakes[$k]["kingaku"],
				 'date' => $date,
				 'kaikake_element_id' => $AccountProductKaikakes[$k]["kaikake_element_id"],
				 'element' => $AccountKaikakeElements[0]["element"],
				 'num_order' => 0,
			];

		 }

	 }

	 $arrLoadAccountElementsKaikakeZengetsuKurikoshi = $arrAccountElementsKaikakeZengetsuKurikoshi;//$arrLoadAccountElementsKaikakeZengetsuKurikoshi完成
	 $arrLoadAccountElementsKaikake = $arrAccountElementsKaikake;//$arrAccountElementsKaikake完成

	 //ここから$arrLoadYusyouzaiUkeire
	 $AccountYusyouzaiUkeires = $this->AccountYusyouzaiUkeires->find()
	 ->where(['date_ukeire >=' => $daysta, 'date_ukeire <=' => $dayfin, 'delete_flag' => 0])
	 ->toArray();

	 if(count($AccountYusyouzaiUkeires) > 0){

		$date_ukeire_array = array();
		$product_code_array = array();
		foreach($AccountYusyouzaiUkeires as $key => $row) {
			$date_ukeire_array[$key] = $row["date_ukeire"];
			$product_code_array[$key] = $row["product_code"];
		}

		array_multisort( array_map( "strtotime", $date_ukeire_array ), SORT_ASC, $product_code_array, SORT_ASC, $AccountYusyouzaiUkeires);

	}

	$arrAccountYusyouzaiUkeires = array();
	for($k=0; $k<count($AccountYusyouzaiUkeires); $k++){

		$AccountYusyouzaiMasters = $this->AccountYusyouzaiMasters->find()
		->where(['product_code' => $AccountYusyouzaiUkeires[$k]["product_code"]])->toArray();

		$Customers = $this->Customers->find()
		->where(['customer_code' => $AccountYusyouzaiMasters[0]["customer_code"]])->toArray();

		if(!isset($Customers[0])){

			$Products = $this->Products->find()
			->where(['product_code' => $AccountYusyouzaiUkeires[$k]["product_code"]])->toArray();

			$Customers = $this->Customers->find()
			->where(['id' => $Products[0]["customer_id"]])->toArray();

		}

		$arrAccountYusyouzaiUkeires[] = [
		 'name' => $Customers[0]["name"],
		 'date_ukeire' => $AccountYusyouzaiUkeires[$k]->date_ukeire->format('Y-m-d'),
		 'id' => $AccountYusyouzaiUkeires[$k]["id"],
		 'product_code' => $AccountYusyouzaiUkeires[$k]["product_code"],
		 'amount' => $AccountYusyouzaiUkeires[$k]["amount"],
		 'tanka' => $AccountYusyouzaiUkeires[$k]["tanka"],
		 'customer_code' => $AccountYusyouzaiUkeires[$k]["customer_code"],
	 ];

	}

	$arrLoadYusyouzaiUkeire = $arrAccountYusyouzaiUkeires;//$arrLoadYusyouzaiUkeire完成

/*
		 echo "<pre>";
		 print_r($arrLoadAccountElementsKaikake);
		 echo "</pre>";
*/
			$this->set([
				'LoadShiire' => $arrLoadShiire,
				'LoadOrderSpecialShiire' => $arrLoadOrderSpecialShiire,
				'LoadAccountElementsKaikakeZengetsuKurikoshi' => $arrLoadAccountElementsKaikakeZengetsuKurikoshi,
				'LoadAccountElementsKaikake' => $arrLoadAccountElementsKaikake,
				'LoadYusyouzaiUkeire' => $arrLoadYusyouzaiUkeire,
				'_serialize' => ['LoadShiire','LoadOrderSpecialShiire','LoadAccountElementsKaikakeZengetsuKurikoshi'
				,'LoadAccountElementsKaikake','LoadYusyouzaiUkeire']
			]);
		}

	}
