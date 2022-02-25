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

class ApiurikakedaichousController extends AppController
	{

		public function initialize()
		{
		 parent::initialize();
		 $this->Customers = TableRegistry::get('customers');
		 $this->Products = TableRegistry::get('products');
		 $this->OrderEdis = TableRegistry::get('orderEdis');
		 $this->AccountUrikakeMaterials = TableRegistry::get('accountUrikakeMaterials');
		 $this->ProductSuppliers = TableRegistry::get('productSuppliers');
		 $this->OrderSpecials = TableRegistry::get('orderSpecials');
		 $this->AccountUrikakes = TableRegistry::get('accountUrikakes');
		 $this->AccountUrikakeElements = TableRegistry::get('accountUrikakeElements');
		 $this->AccountUrikakeZaikohosyous = TableRegistry::get('accountUrikakeZaikohosyous');
		 $this->AccountYusyouzaiGaityuUrikakes = TableRegistry::get('accountYusyouzaiGaityuUrikakes');
		 $this->AccountYusyouzaiGaityues = TableRegistry::get('accountYusyouzaiGaityues');
		 $this->StockInoutWorklogs = TableRegistry::get('stockInoutWorklogs');
		 $this->AccountUrikakePriceMaterials = TableRegistry::get('accountUrikakePriceMaterials');
		}

													     //http://192.168.4.246/Apiurikakedaichous/yobidashi/api/2021-7-1_2021-7-31.xml
		public function yobidashi()//http://localhost:5000/Apiurikakedaichous/yobidashi/api/2021-7-20_2021-7-31.xml
		{
			$data = Router::reverse($this->request, false);//文字化けする後で2回変換すると日本語OK
			$data = urldecode($data);

			$urlarr = explode("/",$data);//切り離し
			$dataarr = explode("_",$urlarr[4]);//切り離し

			$daysta = $dataarr[0];//日付の取得
			$dayfinarr = explode(".",$dataarr[1]);//切り離し
			$dayfin = $dayfinarr[0];//日付の取得

			$arrLoadUrikake = array();
			$arrLoadGenryouUrikake = array();
			$arrLoadOrderSpecial = array();
			$arrLoadAccountElementsUrikakeZengetsuKurikoshi = array();
			$arrLoadAccountElementsUrikake = array();
			$arrLoadAccountElementsUrikakeZaikohosyou = array();
			$arrLoadAccountYusyouzaiGaityuUrikake = array();
			$arrLoadStockInoutUrikake = array();
/*
			echo "<pre>";
	   	print_r("start".date("Y-m-d H:i:s"));
	   	echo "</pre>";
*/
			//ここからarrLoadUrikake
			$OrderEdis = $this->OrderEdis->find()
			->where(['date_deliver >=' => $daysta, 'date_deliver <=' => $dayfin, 'kannou' => 1,
			 'delete_flag' => 0, 'num_order NOT like' => '%daigae%'])
			->toArray();

			if(count($OrderEdis) > 0){

				$date_deliver_array = array();
				$product_code_array = array();
				$num_order_array = array();
				foreach($OrderEdis as $key => $row) {
  	       $date_deliver_array[$key] = $row["date_deliver"];
					 $product_code_array[$key] = $row["product_code"];
	 				 $num_order_array[$key] = $row["num_order"];
  	     }

 			 array_multisort(array_map("strtotime", $date_deliver_array), SORT_ASC, $product_code_array, SORT_ASC,
			  $num_order_array, SORT_ASC, $OrderEdis);

		 }

		 $arrCustomers_name = array();
		 $Customers = $this->Customers->find()->where(['delete_flag' => 0])->toArray();
		 for($k=0; $k<count($Customers); $k++){
			 $arrCustomers_name[] = [
				 "name" => $Customers[$k]["name"],
				 "customer_code" => $Customers[$k]["customer_code"],
			 ];
		 }

		 $arrOrderEdis = array();
		 for($k=0; $k<count($OrderEdis); $k++){

			$keyIndex = array_search($OrderEdis[$k]["customer_code"], array_column($arrCustomers_name, 'customer_code'));//配列の検索
			$name = $arrCustomers_name[$keyIndex]["name"];

			$arrOrderEdis[] = [
				'name' => $name,
				'date_deliver' => $OrderEdis[$k]->date_deliver->format('Y-m-d'),
				'num_order' => $OrderEdis[$k]["num_order"],
				'product_code' => $OrderEdis[$k]["product_code"],
				'amount' => $OrderEdis[$k]["amount"],
				'price' => $OrderEdis[$k]["price"],
				'customer_code' => $OrderEdis[$k]["customer_code"],
		 ];

		 }

		 $arrLoadUrikake = $arrOrderEdis;//$arrLoadUrikake完成

		 //ここからarrLoadGenryouUrikake
		 $AccountUrikakeMaterials = $this->AccountUrikakeMaterials->find()
		 ->where(['date >=' => $daysta, 'date <=' => $dayfin, 'delete_flag' => 0])
		 ->toArray();

		 if(count($AccountUrikakeMaterials) > 0){

			 $date_array = array();
			 $grade_array = array();
			 $id_array = array();
			 foreach($AccountUrikakeMaterials as $key => $row) {
					$date_array[$key] = $row["date"];
					$grade_array[$key] = $row["grade"];
					$id_array[$key] = $row["id"];
				}

			array_multisort(array_map("strtotime", $date_array), SORT_ASC, $grade_array, SORT_ASC,
			 $id_array, SORT_ASC, $AccountUrikakeMaterials);

			}

			$arrProductSuppliers = array();
			$ProductSuppliers = $this->ProductSuppliers->find()->where(['delete_flag' => 0])->toArray();
			for($k=0; $k<count($ProductSuppliers); $k++){
				$arrProductSuppliers[] = [
					"name" => $ProductSuppliers[$k]["name"],
					"customer_code" => $ProductSuppliers[$k]["customer_code"],
					"id" => $ProductSuppliers[$k]["id"],
				];
			}

			$arrAccountUrikakeMaterials = array();
			for($k=0; $k<count($AccountUrikakeMaterials); $k++){

			 $keyIndex = array_search($AccountUrikakeMaterials[$k]["sup_id"], array_column($AccountUrikakeMaterials, 'id'));//配列の検索
			 $name = $arrProductSuppliers[$keyIndex]["name"];
			 $keyIndex = array_search($AccountUrikakeMaterials[$k]["sup_id"], array_column($AccountUrikakeMaterials, 'id'));//配列の検索
			 $customer_code = $arrProductSuppliers[$keyIndex]["customer_code"];

			 $arrAccountUrikakeMaterials[] = [
				 'name' => $name,
				 'date' => $AccountUrikakeMaterials[$k]->date->format('Y-m-d'),
				 'id' => $AccountUrikakeMaterials[$k]["id"],
				 'grade' => $AccountUrikakeMaterials[$k]["grade"],
				 'color' => $AccountUrikakeMaterials[$k]["color"],
				 'amount' => $AccountUrikakeMaterials[$k]["amount"],
				 'tanka' => $AccountUrikakeMaterials[$k]["tanka"],
				 'customer_code' => $customer_code,
			];

			}

			$arrLoadGenryouUrikake = $arrAccountUrikakeMaterials;//$arrLoadGenryouUrikake完成

			//ここからarrLoadOrderSpecial
			$OrderSpecials = $this->OrderSpecials->find()
			->where(['date_deliver >=' => $daysta, 'date_deliver <=' => $dayfin, 'kannou' => 1, 'delete_flag' => 0])
			->toArray();

			if(count($OrderSpecials) > 0){

				$date_deliver_array = array();
				$num_order_array = array();
				foreach($OrderSpecials as $key => $row) {
					 $date_deliver_array[$key] = $row["date_deliver"];
					 $num_order_array[$key] = $row["num_order"];
				 }

			 array_multisort(array_map("strtotime", $date_deliver_array), SORT_ASC, $num_order_array, SORT_ASC, $OrderSpecials);

		 }

		 $arrCustomers_name = array();
		 $Customers = $this->Customers->find()->where(['delete_flag' => 0])->toArray();
		 for($k=0; $k<count($Customers); $k++){
			 $arrCustomers_name[] = [
				 "name" => $Customers[$k]["name"],
				 "customer_code" => $Customers[$k]["customer_code"],
			 ];
		 }

		 $arrOrderSpecials = array();
		 for($k=0; $k<count($OrderSpecials); $k++){

			$keyIndex = array_search($OrderSpecials[$k]["customer_code"], array_column($arrCustomers_name, 'customer_code'));//配列の検索
			$name = $arrCustomers_name[$keyIndex]["name"];

			$arrOrderSpecials[] = [
				'name' => $name,
				'date_deliver' => $OrderSpecials[$k]->date_deliver->format('Y-m-d'),
				'num_order' => "S".$OrderSpecials[$k]["num_order"],
				'order_name' => $OrderSpecials[$k]["order_name"],
				'amount' => $OrderSpecials[$k]["amount"],
				'price' => $OrderSpecials[$k]["price"],
				'customer_code' => $OrderSpecials[$k]["customer_code"],
		 ];

		 }

		 $arrLoadOrderSpecial = $arrOrderSpecials;//$arrLoadOrderSpecial完成

		 //ここからarrLoadAccountElementsUrikakeZengetsuKurikoshi,arrLoadAccountElementsUrikake,arrAccountUrikakeZaikohosyous
		 $AccountUrikakes = $this->AccountUrikakes->find()
		 ->where(['date >=' => $daysta, 'date <=' => $dayfin, 'delete_flag' => 0])
		 ->toArray();

		 if(count($AccountUrikakes) > 0){

			 $customer_code_array = array();
			 $date_array = array();
			 foreach($AccountUrikakes as $key => $row) {
					$customer_code_array[$key] = $row["customer_code"];
					$date_array[$key] = $row["date"];
				}

				array_multisort($customer_code_array, SORT_ASC, array_map("strtotime", $date_array), SORT_ASC, $AccountUrikakes);

			}

			$arrCustomers_name = array();
			$Customers = $this->Customers->find()->where(['delete_flag' => 0])->toArray();
  		 for($k=0; $k<count($Customers); $k++){
  			 $arrCustomers_name[] = [
  				 "name" => $Customers[$k]["name"],
  				 "customer_code" => $Customers[$k]["customer_code"],
  			 ];
  		 }

			 $arrAccountUrikakeElements = array();
	 			$AccountUrikakeElements = $this->AccountUrikakeElements->find()->where(['delete_flag' => 0])->toArray();
	   		 for($k=0; $k<count($AccountUrikakeElements); $k++){
	   			 $arrAccountUrikakeElements[] = [
	   				 "id" => $AccountUrikakeElements[$k]["id"],
	   				 "element" => $AccountUrikakeElements[$k]["element"],
	   			 ];
	   		 }

				 $arrAccountUrikakeZaikohosyous_zaikohosyou = array();
				 $AccountUrikakeZaikohosyous = $this->AccountUrikakeZaikohosyous->find()->where(['delete_flag' => 0])->toArray();
					for($k=0; $k<count($AccountUrikakeZaikohosyous); $k++){
						$arrAccountUrikakeZaikohosyous_zaikohosyou[] = [
							"urikake_id" => $AccountUrikakeZaikohosyous[$k]["urikake_id"],
							"zaikohosyou" => $AccountUrikakeZaikohosyous[$k]["zaikohosyou"],
						];
					}

				 $arrAccountUrikakeZengetsuKurikoshis = array();
				 $arrAccountUrikakes = array();
				 $arrAccountUrikakeZaikohosyous = array();
				 for($k=0; $k<count($AccountUrikakes); $k++){

					$keyIndex = array_search($AccountUrikakes[$k]["customer_code"], array_column($arrCustomers_name, 'customer_code'));//配列の検索
					$name = $arrCustomers_name[$keyIndex]["name"];

					$keyIndex = array_search($AccountUrikakes[$k]["urikake_element_id"], array_column($arrAccountUrikakeElements, 'id'));//配列の検索
					$element = $arrAccountUrikakeElements[$keyIndex]["element"];

					if($AccountUrikakes[$k]["urikake_element_id"] == 1){//前月繰越は1日マイナスする

						$datemoto = strtotime($AccountUrikakes[$k]->date->format('Y-m-d'));
						$date = date('Y-m-d', strtotime('-1 day', $datemoto));

						$arrAccountUrikakeZengetsuKurikoshis[] = [
							'customer_code' => $AccountUrikakes[$k]["customer_code"],
							'name' => $name,
							'kingaku' => $AccountUrikakes[$k]["kingaku"],
							'date' => $date,
							'urikake_element_id' => $AccountUrikakes[$k]["urikake_element_id"],
							'element' => $element,
							'num_order' => 0,
					 ];

				 }elseif($AccountUrikakes[$k]["urikake_element_id"] != 1 && $AccountUrikakes[$k]["urikake_element_id"] != 9 && $AccountUrikakes[$k]["urikake_element_id"] != 10){

						$date = $AccountUrikakes[$k]->date->format('Y-m-d');
						$arrAccountUrikakes[] = [
							'customer_code' => $AccountUrikakes[$k]["customer_code"],
							'name' => $name,
							'kingaku' => $AccountUrikakes[$k]["kingaku"],
							'date' => $date,
							'urikake_element_id' => $AccountUrikakes[$k]["urikake_element_id"],
							'element' => $element,
							'num_order' => 0,
					 ];

				 }elseif($AccountUrikakes[$k]["urikake_element_id"] == 9 || $AccountUrikakes[$k]["urikake_element_id"] == 10){

					 $keyIndex = array_search($AccountUrikakes[$k]["id"], array_column($arrAccountUrikakeZaikohosyous_zaikohosyou, 'urikake_id'));//配列の検索
					 $zaikohosyou = $arrAccountUrikakeZaikohosyous_zaikohosyou[$keyIndex]["zaikohosyou"];

					 if($AccountUrikakes[$k]["urikake_element_id"] == 9){
						 $datemoto = strtotime($AccountUrikakes[$k]->date->format('Y-m-d'));
 						$date = date('Y-m-d', strtotime('+1 day', $datemoto));
					 }else{
						 $date = $AccountUrikakes[$k]->date->format('Y-m-d');
					 }
					 $arrAccountUrikakeZaikohosyous[] = [
						 'customer_code' => $AccountUrikakes[$k]["customer_code"],
						 'name' => $name,
						 'kingaku' => $AccountUrikakes[$k]["kingaku"],
						 'date' => $date,
						 'urikake_element_id' => $AccountUrikakes[$k]["urikake_element_id"],
						 'element' => $element,
						 'zaikohosyou' => $zaikohosyou,
						 'num_order' => 0,
					];

				 }

			 }

			 $arrLoadAccountElementsUrikakeZengetsuKurikoshi = $arrAccountUrikakeZengetsuKurikoshis;//$arrLoadAccountElementsUrikakeZengetsuKurikoshi完成
			 $arrLoadAccountElementsUrikake = $arrAccountUrikakes;//arrLoadAccountElementsUrikake完成
			 $arrLoadAccountElementsUrikakeZaikohosyou = $arrAccountUrikakeZaikohosyous;//arrAccountUrikakeZaikohosyous完成

			 //ここからarrLoadAccountYusyouzaiGaityuUrikake
 			$AccountYusyouzaiGaityuUrikakes = $this->AccountYusyouzaiGaityuUrikakes->find()
 			->where(['date_urikake >=' => $daysta, 'date_urikake <=' => $dayfin, 'delete_flag' => 0])
 			->toArray();

			$arrAccountYusyouzaiGaityus_sup_id = array();
			$AccountYusyouzaiGaityues = $this->AccountYusyouzaiGaityues->find()->toArray();
  		 for($k=0; $k<count($AccountYusyouzaiGaityues); $k++){
  			 $arrAccountYusyouzaiGaityus_sup_id[] = [
  				 "product_code" => $AccountYusyouzaiGaityues[$k]["product_code"],
  				 "customer_code" => $AccountYusyouzaiGaityues[$k]["customer_code"],
  			 ];
  		 }

			$arrCustomers_name = array();
			$Customers = $this->Customers->find()->where(['delete_flag' => 0])->toArray();
  		 for($k=0; $k<count($Customers); $k++){
  			 $arrCustomers_name[] = [
  				 "name" => $Customers[$k]["name"],
  				 "customer_code" => $Customers[$k]["customer_code"],
  			 ];
  		 }

			 $arrAccountYusyouzaiGaityuUrikakes = array();
			 for($k=0; $k<count($AccountYusyouzaiGaityuUrikakes); $k++){

				 $keyIndex = array_search($AccountYusyouzaiGaityuUrikakes[$k]["product_code"], array_column($arrAccountYusyouzaiGaityus_sup_id, 'product_code'));//配列の検索
				 $customer_code = $arrAccountYusyouzaiGaityus_sup_id[$keyIndex]["customer_code"];

				 $keyIndex = array_search($customer_code, array_column($arrCustomers_name, 'customer_code'));//配列の検索
				 $name = $arrCustomers_name[$keyIndex]["name"];

				 $arrAccountYusyouzaiGaityuUrikakes[] = [
 					'name' => $name,
 					'date_urikake' => $AccountYusyouzaiGaityuUrikakes[$k]->date_urikake->format('Y-m-d'),
					'id' => $AccountYusyouzaiGaityuUrikakes[$k]["id"],
					'product_code' => $AccountYusyouzaiGaityuUrikakes[$k]["product_code"],
					'amount' => $AccountYusyouzaiGaityuUrikakes[$k]["amount"],
					'tanka' => $AccountYusyouzaiGaityuUrikakes[$k]["tanka"],
 					'customer_code' => $customer_code,
 			 ];

			 }

			 if(count($arrAccountYusyouzaiGaityuUrikakes) > 0){

				 $date_urikake_array = array();
				 $customer_code_array = array();
				 foreach($arrAccountYusyouzaiGaityuUrikakes as $key => $row) {
						$date_urikake_array[$key] = $row["date_urikake"];
						$customer_code_array[$key] = $row["customer_code"];
					}

					array_multisort(array_map("strtotime", $date_urikake_array), SORT_ASC, $customer_code_array, SORT_ASC, $arrAccountYusyouzaiGaityuUrikakes);

				}

			$arrLoadAccountYusyouzaiGaityuUrikake = $arrAccountYusyouzaiGaityuUrikakes;//arrLoadAccountYusyouzaiGaityuUrikake完成

			//ここからarrLoadAccountYusyouzaiGaityuUrikake
			$StockInoutWorklogs = $this->StockInoutWorklogs->find()
			->where(['date_work >=' => $daysta, 'date_work <=' => $dayfin, 'type' => 2,
			 'delete_flag' => 0, 'product_code NOT like' => 'M_%'])
			->toArray();

			$arrProductSuppliers_name = array();
			$ProductSuppliers = $this->ProductSuppliers->find()->where(['delete_flag' => 0])->toArray();
  		 for($k=0; $k<count($ProductSuppliers); $k++){
  			 $arrProductSuppliers_name[] = [
  				 "customer_code" => $ProductSuppliers[$k]["customer_code"],
  				 "handy_id" => $ProductSuppliers[$k]["handy_id"],
  			 ];
  		 }

			 $arrCustomers_name = array();
			 $Customers = $this->Customers->find()->where(['delete_flag' => 0])->toArray();
				for($k=0; $k<count($Customers); $k++){
					$arrCustomers_name[] = [
						"name" => $Customers[$k]["name"],
						"customer_code" => $Customers[$k]["customer_code"],
					];
				}

				$arrStockInoutWorklogs = array();
				for($k=0; $k<count($StockInoutWorklogs); $k++){

					$price = "";
					$keyIndex = array_search($StockInoutWorklogs[$k]["outsource_code"], array_column($arrProductSuppliers_name, 'handy_id'));//配列の検索
					$customer_code = $arrProductSuppliers_name[$keyIndex]["customer_code"];

					 if(strlen($customer_code) > 0){
						 $keyIndex = array_search($customer_code, array_column($arrCustomers_name, 'customer_code'));//配列の検索
	  				 $name = $arrCustomers_name[$keyIndex]["name"];
					 }else{
						 $name = "";
					 }

					 $Products = $this->Products->find()->where(['product_code' => $StockInoutWorklogs[$k]["product_code"]])->toArray();
					 if(isset($Products[0])){
						 $product_code = $StockInoutWorklogs[$k]["product_code"];
						 $grade = "";
						 $color = "";
					 }else{
						 $product_code = $StockInoutWorklogs[$k]["product_code"];
						 $arr_grade_color = explode(" ",$product_code);//切り離し
						 $grade = $arr_grade_color[0];
						 if(isset($arr_grade_color[1])){
							 $color = $arr_grade_color[1];
						 }else{
							 $color = "N";
						 }
						 $AccountUrikakePriceMaterials = $this->AccountUrikakePriceMaterials->find()
						 ->where(['grade' => $grade, 'color' => $color])->toArray();
						 if(isset($AccountUrikakePriceMaterials[0])){
							 $price = $AccountUrikakePriceMaterials[0]["price"];
						 }

					 }

  				 $arrStockInoutWorklogs[] = [
						 'customer_code' => $customer_code,
						 'product_code' => $StockInoutWorklogs[$k]["product_code"],
						 'amount' => $StockInoutWorklogs[$k]["amount"],
						 'date_work' => $StockInoutWorklogs[$k]->date_work->format('Y-m-d'),
						 'name' => $name,
						 'num_order' => "-",
						 'grade' => $grade,
						 'color' => $color,
						 'price' => $price,
   			 ];

  			 }

			$arrLoadStockInoutUrikake = $arrStockInoutWorklogs;//arrLoadStockInoutUrikake完成
/*
			 echo "<pre>";
			 print_r($arrLoadStockInoutUrikake);
			 echo "</pre>";
*/
			$this->set([
				'LoadUrikake' => $arrLoadUrikake,
				'LoadGenryouUrikake' => $arrLoadGenryouUrikake,
				'LoadOrderSpecial' => $arrLoadOrderSpecial,
				'LoadAccountElementsUrikakeZengetsuKurikoshi' => $arrLoadAccountElementsUrikakeZengetsuKurikoshi,
				'LoadAccountElementsUrikake' => $arrLoadAccountElementsUrikake,
				'LoadAccountElementsUrikakeZaikohosyou' => $arrLoadAccountElementsUrikakeZaikohosyou,
				'LoadAccountYusyouzaiGaityuUrikake' => $arrLoadAccountYusyouzaiGaityuUrikake,
				'LoadStockInoutUrikake' => $arrLoadStockInoutUrikake,
				'_serialize' => ['LoadUrikake','LoadGenryouUrikake','LoadOrderSpecial'
				,'LoadAccountElementsUrikakeZengetsuKurikoshi','LoadAccountElementsUrikake'
				,'LoadAccountElementsUrikakeZaikohosyou', 'LoadAccountYusyouzaiGaityuUrikake', 'LoadStockInoutUrikake']
			]);
		}

	}
