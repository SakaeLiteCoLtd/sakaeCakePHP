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
//use Cake\Http\ServerRequest;

class ApizaikocyouController extends AppController
	{

		public function initialize()
		{
		 parent::initialize();
		 $this->ScheduleKouteis = TableRegistry::get('scheduleKouteis');
		 $this->Products = TableRegistry::get('products');
		 $this->OrderEdis = TableRegistry::get('orderEdis');
		 $this->StockProducts = TableRegistry::get('stockProducts');
		 $this->SyoyouKeikakus = TableRegistry::get('syoyouKeikakus');
		 $this->KadouSeikeis = TableRegistry::get('kadouSeikeis');
		 $this->Katakouzous = TableRegistry::get('katakouzous');
		 $this->AssembleProducts = TableRegistry::get('assembleProducts');
		 $this->Customers = TableRegistry::get('customers');
		 $this->Konpous = TableRegistry::get('konpous');
		 $this->ResultZensuHeads = TableRegistry::get('resultZensuHeads');
		 $this->RironStockProducts = TableRegistry::get('rironStockProducts');
		}

		public function zaikocyou()
		{
			$data = Router::reverse($this->request, false);//urlを取得
			$urlarr = explode("/",$data);//切り離し
			$dayarr = explode("_",$urlarr[4]);//切り離し

			if(isset($dayarr[2])){
				$sheetarr = explode(".",$dayarr[2]);//切り離し
				$sheet = $dayarr[1]."_".$sheetarr[0];//シート名の取得
			}else{
				$sheetarr = explode(".",$dayarr[1]);//切り離し
				$sheet = $sheetarr[0];//シート名の取得
			}

			$arryaermonth = explode("-",$dayarr[0]);
			$yaermonth = $arryaermonth[0]."-".$arryaermonth[1];

			$day = $dayarr[0];//日付の取得

			$date1 = $yaermonth."-1";//選択した日程の月の初日
			$date1st = strtotime($date1);
			$datenext1 = date('Y-m-d', strtotime('+30 day', $date1st));//選択した月の次の月の初日
			$datelast = strtotime($datenext1);
			$datelast = date('Y-m-d', strtotime('-1 day', $datelast));//選択した月の最後の日
			$dateback1 = date('Y-m-d', strtotime('-1 month', $date1st));//選択した月の前の月の初日//stockProductsに使用
			$dateback = strtotime($dateback1);
			$datebacklast = date('Y-m-d', strtotime('-1 day', $date1st));//選択した月の前の月の最後の日//stockProductsに使用

			$datestart = $dayarr[0];
			$datestartstr = strtotime($datestart);
			$dateend = date('Y-m-d', strtotime('+31 day', $datestartstr));
			$dateendnext = date('Y-m-d', strtotime('+32 day', $datestartstr));//kodouseikeisで使用
/*
			echo "<pre>";
			print_r($datestart." ".$dateend);
			echo "</pre>";
*/
			//http://192.168.4.246/Apizaikocyou/zaikocyou/api/2020-12-3_primary.xml
			//http://localhost:5000/Apizaikocyou/zaikocyou/api/2020-12-13_primary.xml

			if($sheet === "primary"){

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'primary_p' => 1,
				'OR' => [['product_code like' => 'P%'], ['product_code like' => 'AR%']]])->toArray();

				$arrProductsmoto = array();
				for($k=0; $k<count($arrProducts); $k++){

					$riron_check = 0;
					$date16 = $yaermonth."-16";
					$RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $arrProducts[$k]["product_code"], 'date_culc' => $date16])->toArray();
					if(isset($RironStockProducts[0])){
						$riron_check = 1;
					}

					$arrProductsmoto[] = [
						'date_order' => "",
						'num_order' => "",
						'product_code' => $arrProducts[$k]["product_code"],
						'product_name' => $arrProducts[$k]["product_name"],
						'price' => "",
						'date_deliver' => "",
						'amount' => "",
						'denpyoumaisu' => "",
						'riron_zaiko_check' => $riron_check
				 ];

				}

				$arrAssembleProducts = array();//ここから組立品
				$ResultZensuHeads = $this->ResultZensuHeads->find()//組立品の元データを出しておく（ループで取り出すと時間がかかる）
				->where(['datetime_finish >=' => $datestart." 00:00:00", 'datetime_finish <' => $dateend." 00:00:00"])
				->order(["datetime_finish"=>"DESC"])->toArray();

				$arrResultZensuHeadsmoto = array();
				for($k=0; $k<count($ResultZensuHeads); $k++){

					$arrResultZensuHeadsmoto[] = [
						'product_code' => $ResultZensuHeads[$k]["product_code"],
						'datetime_finish' => $ResultZensuHeads[$k]["datetime_finish"]->format('Y-m-d'),
						'count' => 1
				 ];

				}

				$product_code_moto = array();//ここから配列の並び変え
				$datetime_finish_moto = array();
				foreach ($arrResultZensuHeadsmoto as $key => $value) {
					 $product_code[$key] = $value['product_code'];
					 $datetime_finish[$key] = $value["datetime_finish"];
				 }

				 if(isset($datetime_finish)){
					 array_multisort($product_code, array_map("strtotime", $datetime_finish), SORT_ASC, SORT_NUMERIC, $arrResultZensuHeadsmoto);
				 }

				//同一の$arrResultZensuHeadsmotoは一つにまとめ、countを更新
				for($l=0; $l<count($arrResultZensuHeadsmoto); $l++){

					for($m=$l+1; $m<count($arrResultZensuHeadsmoto); $m++){

						if($arrResultZensuHeadsmoto[$l]["product_code"] == $arrResultZensuHeadsmoto[$m]["product_code"] && $arrResultZensuHeadsmoto[$l]["datetime_finish"] == $arrResultZensuHeadsmoto[$m]["datetime_finish"]){

							$count = $arrResultZensuHeadsmoto[$l]["count"] + $arrResultZensuHeadsmoto[$m]["count"];

							$arrResultZensuHeadsmoto[$l]["count"] = $count;

							unset($arrResultZensuHeadsmoto[$m]);

						}

					}
					$arrResultZensuHeadsmoto = array_values($arrResultZensuHeadsmoto);

				}

				for($l=0; $l<count($arrResultZensuHeadsmoto); $l++){

					$AssembleProducts = $this->AssembleProducts->find()->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

					if(isset($AssembleProducts[0])){//AssembleProductsが存在する場合//組立

						$OrderEdisAssemble = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
						->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'delete_flag' => 0,
						'OR' => [['product_code like' => 'P%'], ['product_code like' => 'AR%']]])//productsの絞込み　primary
						->toArray();

						if(isset($OrderEdisAssemble[0])){

							$Konpou = $this->Konpous->find()->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"]])->toArray();
							$irisu = $Konpou[0]->irisu;//製品の入数を取得

							$amount = $irisu * $arrResultZensuHeadsmoto[$l]["count"];//入数をかけてamountを取得

							 $arrAssembleProducts[] = [//配列$arrAssembleProductsに追加
								 'product_code' => $arrResultZensuHeadsmoto[$l]["product_code"],
								 'kensabi' => $arrResultZensuHeadsmoto[$l]["datetime_finish"],
								 'amount' => $amount
							];

						}

					}

				}

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0,
				'OR' => [['product_code like' => 'P%'], ['product_code like' => 'AR%']]])//productsの絞込み　primary
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し

				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'status' => 0, 'primary_p' => 1])->toArray();//productsの絞込み　primary

					if(isset($Product[0])){

						$product_name = $Product[0]->product_name;

						$riron_check = 0;
						$date16 = $yaermonth."-16";
						$RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'date_culc' => $date16])->toArray();
						if(isset($RironStockProducts[0])){
							$riron_check = 1;
						}

							$arrOrderEdis[] = [
								'date_order' => $OrderEdis[$k]["date_order"],
								'num_order' => $OrderEdis[$k]["num_order"],
								'product_code' => $OrderEdis[$k]["product_code"],
								'product_name' => $product_name,
								'price' => $OrderEdis[$k]["price"],
								'date_deliver' => $OrderEdis[$k]["date_deliver"],
								'amount' => $OrderEdis[$k]["amount"],
								'denpyoumaisu' => 1,
								'riron_zaiko_check' => $riron_check
						 ];

						 for($l=0; $l<count($arrProductsmoto); $l++){

							 if($arrProductsmoto[$l]["product_code"] === $OrderEdis[$k]["product_code"]){

								 unset($arrProductsmoto[$l]);
								 $arrProductsmoto = array_values($arrProductsmoto);

							 }

						}

/*
						//組立品呼び出し//クラス使用
						$arrAssembleProducts[10000] = [
							'product_code' => $OrderEdis[$k]["product_code"],
							'kensabi' => $date1,
							'amount' => 0
					 ];

						$htmlApifind = new htmlApifind();//クラスを使用
						$arrAssembleProducts = $htmlApifind->Assemble($arrAssembleProducts);//クラスを使用
*/

					}

				}

				//同一のproduct_code、date_deliverの注文は一つにまとめ、amountとdenpyoumaisuを更新
				for($l=0; $l<count($arrOrderEdis); $l++){

					for($m=$l+1; $m<count($arrOrderEdis); $m++){

						if($arrOrderEdis[$l]["product_code"] == $arrOrderEdis[$m]["product_code"] && $arrOrderEdis[$l]["date_deliver"] == $arrOrderEdis[$m]["date_deliver"]){

							$amount = $arrOrderEdis[$l]["amount"] + $arrOrderEdis[$m]["amount"];
							$denpyoumaisu = $arrOrderEdis[$l]["denpyoumaisu"] + $arrOrderEdis[$m]["denpyoumaisu"];

							$arrOrderEdis[$l]["amount"] = $amount;
							$arrOrderEdis[$l]["denpyoumaisu"] = $denpyoumaisu;

							unset($arrOrderEdis[$m]);

						}

					}
					$arrOrderEdis = array_values($arrOrderEdis);

				}

				$arrOrderEdis = array_merge($arrOrderEdis, $arrProductsmoto);

				//並べかえ
				$tmp_product_array = array();
				$tmp_date_deliver_array = array();
				foreach($arrOrderEdis as $key => $row ) {
					$tmp_product_array[$key] = $row["product_code"];
					$tmp_date_deliver_array[$key] = $row["date_deliver"];
				}

				if(count($arrOrderEdis) > 0){
					array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_deliver_array ), SORT_ASC, SORT_NUMERIC, $arrOrderEdis);
				}

				//$arrOrderEdis完成

				$StockProducts = $this->StockProducts->find()//月末在庫呼び出し
				->where(['date_stock >=' => $dateback1, 'date_stock <=' => $datebacklast,
				'OR' => [['product_code like' => 'P%'], ['product_code like' => 'AR%']]])//productsの絞込み　primary
				->order(["date_stock"=>"ASC"])->toArray();

					$arrStockProducts = array();
					for($k=0; $k<count($StockProducts); $k++){

						$Product = $this->Products->find()->where(['product_code' => $StockProducts[$k]["product_code"], 'status' => 0, 'primary_p' => 1])->toArray();//productsの絞込み　primary

						if(isset($Product[0])){

							$arrStockProducts[] = [
								'product_code' => $StockProducts[$k]["product_code"],
								'date_stock' => $StockProducts[$k]["date_stock"],
								'amount' => $StockProducts[$k]["amount"]
						 ];

						}

					}

					//並べかえ
					$tmp_product_array = array();
					$tmp_date_stock_array = array();
					foreach($arrStockProducts as $key => $row ) {
						$tmp_product_array[$key] = $row["product_code"];
						$tmp_date_stock_array[$key] = $row["date_stock"];
					}

					if(count($arrStockProducts) > 0){
						array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_stock_array ), SORT_ASC, SORT_NUMERIC, $arrStockProducts);
					}

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $datelast, 'delete_flag' => 0,
				'OR' => [['product_code like' => 'P%'], ['product_code like' => 'AR%']]])//productsの絞込み　primary
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrSyoyouKeikakus = array();
				for($k=0; $k<count($SyoyouKeikakus); $k++){

					$Product = $this->Products->find()->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'status' => 0, 'primary_p' => 1])->toArray();//productsの絞込み　primary

					if(isset($Product[0])){

						$arrSyoyouKeikakus[] = [
							'product_code' => $SyoyouKeikakus[$k]["product_code"],
							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
							'amount' => $SyoyouKeikakus[$k]["amount"]
					 ];

					 //child_pidを追加
					 $AssembleProductcilds = $this->AssembleProducts->find()->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

					 if(isset($AssembleProductcilds[0])){

						 for($l=0; $l<count($AssembleProductcilds); $l++){

							 $arrSyoyouKeikakus[] = [
	 							'product_code' => $AssembleProductcilds[$l]->child_pid,
	 							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
	 							'amount' => $SyoyouKeikakus[$k]["amount"]
	 					 ];

						 }

					 }

					}

				}

				//並べかえ
				$tmp_product_array = array();
				$tmp_date_deliver_array = array();
				foreach($arrSyoyouKeikakus as $key => $row ) {
					$tmp_product_array[$key] = $row["product_code"];
					$tmp_date_deliver_array[$key] = $row["date_deliver"];
				}

				if(count($arrSyoyouKeikakus) > 0){
					array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_deliver_array ), SORT_ASC, SORT_NUMERIC, $arrSyoyouKeikakus);
				}

				$daystart = $datestart." 08:00:00";
				$dayfin = $dateendnext." 07:59:59";

				$KadouSeikeis = $this->KadouSeikeis->find()//生産数呼び出し
				->where(['starting_tm >=' => $daystart, 'starting_tm <=' => $dayfin,
				'OR' => [['product_code like' => 'P%'], ['product_code like' => 'AR%']]])//productsの絞込み　primary
				->order(["starting_tm"=>"ASC"])->toArray();

					$arrSeisans = array();
					for($k=0; $k<count($KadouSeikeis); $k++){

						$Product = $this->Products->find()->where(['product_code' => $KadouSeikeis[$k]["product_code"], 'status' => 0, 'primary_p' => 1])->toArray();//productsの絞込み　primary

						if(isset($Product[0])){

							$Katakouzous = $this->Katakouzous->find()->where(['product_code' => $KadouSeikeis[$k]["product_code"]])->toArray();

							$starting_tm = substr($KadouSeikeis[$k]['starting_tm'], 0, 10);
							$dateseikei = strtotime(substr($KadouSeikeis[$k]['starting_tm'], 10));
/*
							echo "<pre>";
							print_r(substr($KadouSeikeis[$k]['starting_tm'], 10));
							echo "</pre>";
							echo "<pre>";
							print_r($dateseikei." - ".strtotime(" 08:00:00"));
							echo "</pre>";
*/
							if($dateseikei < strtotime(" 08:00:00")){
								$starting_tm = strtotime($starting_tm);
								$nippouday = date('Y/m/d', strtotime('-1 day', $starting_tm));
							}else{
								$nippouday = substr($KadouSeikeis[$k]['starting_tm'], 0, 10);
							}

							if(isset($Katakouzous[0])){
								$torisu = $Katakouzous[0]["torisu"];
							}else{
								$torisu = "Katakouzousテーブルに登録なし";
							}

							$arrSeisans[] = [
								'dateseikei' => $nippouday,
								'product_code' => $KadouSeikeis[$k]["product_code"],
								'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
								'torisu' => $torisu
						 ];

						}

					}
/*
					echo "<pre>";
					var_dump($arrSeisans[0]);
					echo "</pre>";
*/
					//並べかえ
					$tmp_product_array2 = array();
					$tmp_dateseikei_array = array();
					foreach($arrSeisans as $key => $row ) {
						$tmp_product_array2[$key] = $row["product_code"];
						$tmp_dateseikei_array[$key] = $row["dateseikei"];
					}

					if(count($arrSeisans) > 0){
						array_multisort($tmp_product_array2, $tmp_dateseikei_array, SORT_ASC, SORT_NUMERIC, $arrSeisans);
					}





			}elseif($sheet === "primary_dnp"){

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'primary_p' => 1,
				'OR' => [['customer_code like' => '2%']]])->toArray();

				$arrProductsmoto = array();
				for($k=0; $k<count($arrProducts); $k++){

					$riron_check = 0;
					$date16 = $yaermonth."-16";
					$RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $arrProducts[$k]["product_code"], 'date_culc' => $date16])->toArray();
					if(isset($RironStockProducts[0])){
						$riron_check = 1;
					}

					$arrProductsmoto[] = [
						'date_order' => "",
						'num_order' => "",
						'product_code' => $arrProducts[$k]["product_code"],
						'product_name' => $arrProducts[$k]["product_name"],
						'price' => "",
						'date_deliver' => "",
						'amount' => "",
						'denpyoumaisu' => "",
						'riron_zaiko_check' => $riron_check
				 ];

				}

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0,
				'OR' => [['customer_code like' => '2%']]])//productsの絞込みprimary_dnp
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
				$arrAssembleProducts = array();
				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $OrderEdis[$k]["product_code"], 'products.status' => 0, 'primary_p' => 1, 'customer_code like' => '2%'])->toArray();//productsの絞込みprimary_dnp

					if(isset($Product[0])){

						$product_name = $Product[0]->product_name;

						$riron_check = 0;
						$date16 = $yaermonth."-16";
						$RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'date_culc' => $date16])->toArray();
						if(isset($RironStockProducts[0])){
							$riron_check = 1;
						}

							$arrOrderEdis[] = [
								'date_order' => $OrderEdis[$k]["date_order"],
								'num_order' => $OrderEdis[$k]["num_order"],
								'product_code' => $OrderEdis[$k]["product_code"],
								'product_name' => $product_name,
								'price' => $OrderEdis[$k]["price"],
								'date_deliver' => $OrderEdis[$k]["date_deliver"],
								'amount' => $OrderEdis[$k]["amount"],
								'denpyoumaisu' => 1,
								'riron_zaiko_check' => $riron_check
						 ];

						 for($l=0; $l<count($arrProductsmoto); $l++){

							 if($arrProductsmoto[$l]["product_code"] === $OrderEdis[$k]["product_code"]){

								 unset($arrProductsmoto[$l]);
								 $arrProductsmoto = array_values($arrProductsmoto);

							 }

						}

						//組立品呼び出し
						$ResultZensuHeads = $this->ResultZensuHeads->find()
						->where(['product_code' => $OrderEdis[$k]["product_code"], 'datetime_finish >=' => $datestart." 00:00:00", 'datetime_finish <' => $dateend." 00:00:00"])
						->order(["datetime_finish"=>"DESC"])->toArray();

						if(isset($ResultZensuHeads[0])){//210107データ確認ok

								$AssembleProducts = $this->AssembleProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

								if(isset($AssembleProducts[0])){

									$diff = floor((strtotime($datenext1) - $date1st) / (60 * 60 * 24));

									for($l=0; $l<$diff; $l++){//それぞれの日付に対して

										$datetime_finish = strtotime("+$l day " . $date1);
			              $datetime_finish = date("Y-m-d", $datetime_finish);

										$Konpou = $this->Konpous->find()->where(['product_code' => $OrderEdis[$k]["product_code"]])->toArray();
										$irisu = $Konpou[0]->irisu;

										$ResultZensuHeadsday = $this->ResultZensuHeads->find()
										->where(['product_code' => $OrderEdis[$k]["product_code"], 'datetime_finish >=' => $datetime_finish." 00:00:00", 'datetime_finish <=' => $datetime_finish." 23:59:59"])
										->order(["datetime_finish"=>"DESC"])->toArray();

										if(isset($ResultZensuHeadsday[0])){

											$amount = $irisu * count($ResultZensuHeadsday);

											 $arrAssembleProducts[] = [
												 'product_code' => $OrderEdis[$k]["product_code"],
												 'kensabi' => $datetime_finish,
												 'amount' => $amount
											];

										}

									}

								}

							$arrAssembleProducts = array_unique($arrAssembleProducts, SORT_REGULAR);
							$arrAssembleProducts = array_values($arrAssembleProducts);

							$product_code = array();
							$kensabi = array();
							foreach ($arrAssembleProducts as $key => $value) {
  							 $product_code[$key] = $value['product_code'];
  							 $kensabi[$key] = $value["kensabi"];
  						 }

							 if(isset($kensabi)){
								 array_multisort($product_code, array_map( "strtotime", $kensabi ), SORT_ASC, SORT_NUMERIC, $arrAssembleProducts);
							 }

						}

					}

				}


				//同一のproduct_code、date_deliverの注文は一つにまとめ、amountとdenpyoumaisuを更新
				for($l=0; $l<count($arrOrderEdis); $l++){

					for($m=$l+1; $m<count($arrOrderEdis); $m++){

						if($arrOrderEdis[$l]["product_code"] == $arrOrderEdis[$m]["product_code"] && $arrOrderEdis[$l]["date_deliver"] == $arrOrderEdis[$m]["date_deliver"]){

							$amount = $arrOrderEdis[$l]["amount"] + $arrOrderEdis[$m]["amount"];
							$denpyoumaisu = $arrOrderEdis[$l]["denpyoumaisu"] + $arrOrderEdis[$m]["denpyoumaisu"];

							$arrOrderEdis[$l]["amount"] = $amount;
							$arrOrderEdis[$l]["denpyoumaisu"] = $denpyoumaisu;

							unset($arrOrderEdis[$m]);

						}

					}
					$arrOrderEdis = array_values($arrOrderEdis);

				}

				$arrOrderEdis = array_merge($arrOrderEdis, $arrProductsmoto);


				//並べかえ
				$tmp_product_array = array();
				$tmp_date_deliver_array = array();
				foreach($arrOrderEdis as $key => $row ) {
					$tmp_product_array[$key] = $row["product_code"];
					$tmp_date_deliver_array[$key] = $row["date_deliver"];
				}

				if(count($arrOrderEdis) > 0){
					array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_deliver_array ), SORT_ASC, SORT_NUMERIC, $arrOrderEdis);
				}

				$StockProducts = $this->StockProducts->find()//月末在庫呼び出し
				->where(['date_stock >=' => $dateback1, 'date_stock <=' => $datebacklast])
				->order(["date_stock"=>"ASC"])->toArray();

					$arrStockProducts = array();
					for($k=0; $k<count($StockProducts); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'primary_p' => 1, 'customer_code like' => '2%'])->toArray();//productsの絞込みprimary_dnp

						if(isset($Product[0])){

							$arrStockProducts[] = [
								'product_code' => $StockProducts[$k]["product_code"],
								'date_stock' => $StockProducts[$k]["date_stock"],
								'amount' => $StockProducts[$k]["amount"]
						 ];

						}

					}
					//並べかえ
					$tmp_product_array = array();
					$tmp_date_stock_array = array();
					foreach($arrStockProducts as $key => $row ) {
						$tmp_product_array[$key] = $row["product_code"];
						$tmp_date_stock_array[$key] = $row["date_stock"];
					}

					if(count($arrStockProducts) > 0){
						array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_stock_array ), SORT_ASC, SORT_NUMERIC, $arrStockProducts);
					}

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0])
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrSyoyouKeikakus = array();
				for($k=0; $k<count($SyoyouKeikakus); $k++){

					$Product = $this->Products->find()->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'status' => 0, 'primary_p' => 1])->toArray();//productsの絞込み　primary

					if(isset($Product[0])){

						$arrSyoyouKeikakus[] = [
							'product_code' => $SyoyouKeikakus[$k]["product_code"],
							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
							'amount' => $SyoyouKeikakus[$k]["amount"]
					 ];

					 //child_pidを追加
					 $AssembleProductcilds = $this->AssembleProducts->find()->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

					 if(isset($AssembleProductcilds[0])){

						 for($l=0; $l<count($AssembleProductcilds); $l++){

							 $arrSyoyouKeikakus[] = [
	 							'product_code' => $AssembleProductcilds[$l]->child_pid,
	 							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
	 							'amount' => $SyoyouKeikakus[$k]["amount"]
	 					 ];

						 }

					 }

					}

				}

				//並べかえ
								$tmp_product_array = array();
								$tmp_date_deliver_array = array();
								foreach($arrSyoyouKeikakus as $key => $row ) {
									$tmp_product_array[$key] = $row["product_code"];
									$tmp_date_deliver_array[$key] = $row["date_deliver"];
								}

								if(count($arrSyoyouKeikakus) > 0){
									array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_deliver_array ), SORT_ASC, SORT_NUMERIC, $arrSyoyouKeikakus);
								}

				$daystart = $date1." 08:00:00";
				$dayfin = $datenext1." 07:59:59";

				$KadouSeikeis = $this->KadouSeikeis->find()//生産数呼び出し
				->where(['starting_tm >=' => $daystart, 'starting_tm <=' => $dayfin])
				->order(["starting_tm"=>"ASC"])->toArray();

					$arrSeisans = array();
					for($k=0; $k<count($KadouSeikeis); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $KadouSeikeis[$k]["product_code"], 'products.status' => 0, 'primary_p' => 1, 'customer_code like' => '2%'])->toArray();//productsの絞込みprimary_dnp

						if(isset($Product[0])){

							$Katakouzous = $this->Katakouzous->find()->where(['product_code' => $KadouSeikeis[$k]["product_code"]])->toArray();

							$starting_tm = substr($KadouSeikeis[$k]['starting_tm'], 0, 10);
							$dateseikei = strtotime(substr($KadouSeikeis[$k]['starting_tm'], 10));

							if($dateseikei < strtotime(" 08:00:00")){
								$starting_tm = strtotime($starting_tm);
								$nippouday = date('Y/m/d', strtotime('-1 day', $starting_tm));
							}else{
								$nippouday = substr($KadouSeikeis[$k]['starting_tm'], 0, 10);
							}

							if(isset($Katakouzous[0])){
								$torisu = $Katakouzous[0]["torisu"];
							}else{
								$torisu = "Katakouzousテーブルに登録なし";
							}

							$arrSeisans[] = [
								'dateseikei' => $nippouday,
								'product_code' => $KadouSeikeis[$k]["product_code"],
								'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
								'torisu' => $torisu
						 ];

						}

					}

					//並べかえ
					$tmp_product_array2 = array();
					$tmp_dateseikei_array = array();
					foreach($arrSeisans as $key => $row ) {
						$tmp_product_array2[$key] = $row["product_code"];
						$tmp_dateseikei_array[$key] = $row["dateseikei"];
					}

					if(count($arrSeisans) > 0){
						array_multisort($tmp_product_array2, $tmp_dateseikei_array, SORT_ASC, SORT_NUMERIC, $arrSeisans);
					}



			}elseif($sheet === "primary_w"){

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'primary_p' => 1, 'customer_code' => '10002',
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])->toArray();

				$arrProductsmoto = array();
				for($k=0; $k<count($arrProducts); $k++){

					$riron_check = 0;
					$date16 = $yaermonth."-16";
					$RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $arrProducts[$k]["product_code"], 'date_culc' => $date16])->toArray();
					if(isset($RironStockProducts[0])){
						$riron_check = 1;
					}

					$arrProductsmoto[] = [
						'date_order' => "",
						'num_order' => "",
						'product_code' => $arrProducts[$k]["product_code"],
						'product_name' => $arrProducts[$k]["product_name"],
						'price' => "",
						'date_deliver' => "",
						'amount' => "",
						'denpyoumaisu' => "",
						'riron_zaiko_check' => $riron_check
				 ];

				}

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0, 'customer_code' => '10002',
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みprimary_w
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
				$arrAssembleProducts = array();
				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $OrderEdis[$k]["product_code"], 'products.status' => 0, 'primary_p' => 1, 'customer_code' => '10002'])->toArray();//productsの絞込みprimary_w

					if(isset($Product[0])){

						$product_name = $Product[0]->product_name;

						$riron_check = 0;
						$date16 = $yaermonth."-16";
						$RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'date_culc' => $date16])->toArray();
						if(isset($RironStockProducts[0])){
							$riron_check = 1;
						}

							$arrOrderEdis[] = [
								'date_order' => $OrderEdis[$k]["date_order"],
								'num_order' => $OrderEdis[$k]["num_order"],
								'product_code' => $OrderEdis[$k]["product_code"],
								'product_name' => $product_name,
								'price' => $OrderEdis[$k]["price"],
								'date_deliver' => $OrderEdis[$k]["date_deliver"],
								'amount' => $OrderEdis[$k]["amount"],
								'denpyoumaisu' => 1,
								'riron_zaiko_check' => $riron_check
						 ];

						 						 for($l=0; $l<count($arrProductsmoto); $l++){

						 							 if($arrProductsmoto[$l]["product_code"] === $OrderEdis[$k]["product_code"]){

						 								 unset($arrProductsmoto[$l]);
						 								 $arrProductsmoto = array_values($arrProductsmoto);

						 							 }

						 		 				}

												//組立品呼び出し
												$ResultZensuHeads = $this->ResultZensuHeads->find()
												->where(['product_code' => $OrderEdis[$k]["product_code"], 'datetime_finish >=' => $datestart." 00:00:00", 'datetime_finish <' => $dateend." 00:00:00"])
												->order(["datetime_finish"=>"DESC"])->toArray();

												if(isset($ResultZensuHeads[0])){//210107データ確認ok

														$AssembleProducts = $this->AssembleProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

														if(isset($AssembleProducts[0])){

															$diff = floor((strtotime($datenext1) - $date1st) / (60 * 60 * 24));

															for($l=0; $l<$diff; $l++){//それぞれの日付に対して

																$datetime_finish = strtotime("+$l day " . $date1);
									              $datetime_finish = date("Y-m-d", $datetime_finish);

																$Konpou = $this->Konpous->find()->where(['product_code' => $OrderEdis[$k]["product_code"]])->toArray();
																$irisu = $Konpou[0]->irisu;

																$ResultZensuHeadsday = $this->ResultZensuHeads->find()
																->where(['product_code' => $OrderEdis[$k]["product_code"], 'datetime_finish >=' => $datetime_finish." 00:00:00", 'datetime_finish <=' => $datetime_finish." 23:59:59"])
																->order(["datetime_finish"=>"DESC"])->toArray();

																if(isset($ResultZensuHeadsday[0])){

																	$amount = $irisu * count($ResultZensuHeadsday);

																	 $arrAssembleProducts[] = [
																		 'product_code' => $OrderEdis[$k]["product_code"],
																		 'kensabi' => $datetime_finish,
																		 'amount' => $amount
																	];

																}

															}

														}

													$arrAssembleProducts = array_unique($arrAssembleProducts, SORT_REGULAR);
													$arrAssembleProducts = array_values($arrAssembleProducts);

													$product_code = array();
													$kensabi = array();
													foreach ($arrAssembleProducts as $key => $value) {
						  							 $product_code[$key] = $value['product_code'];
						  							 $kensabi[$key] = $value["kensabi"];
						  						 }

													 if(isset($kensabi)){
														 array_multisort($product_code, array_map( "strtotime", $kensabi ), SORT_ASC, SORT_NUMERIC, $arrAssembleProducts);
													 }

												}

											}

										}


										//同一のproduct_code、date_deliverの注文は一つにまとめ、amountとdenpyoumaisuを更新
										for($l=0; $l<count($arrOrderEdis); $l++){

											for($m=$l+1; $m<count($arrOrderEdis); $m++){

												if($arrOrderEdis[$l]["product_code"] == $arrOrderEdis[$m]["product_code"] && $arrOrderEdis[$l]["date_deliver"] == $arrOrderEdis[$m]["date_deliver"]){

													$amount = $arrOrderEdis[$l]["amount"] + $arrOrderEdis[$m]["amount"];
													$denpyoumaisu = $arrOrderEdis[$l]["denpyoumaisu"] + $arrOrderEdis[$m]["denpyoumaisu"];

													$arrOrderEdis[$l]["amount"] = $amount;
													$arrOrderEdis[$l]["denpyoumaisu"] = $denpyoumaisu;

													unset($arrOrderEdis[$m]);

												}

											}
											$arrOrderEdis = array_values($arrOrderEdis);

										}

										$arrOrderEdis = array_merge($arrOrderEdis, $arrProductsmoto);

				//並べかえ
				$tmp_product_array = array();
				$tmp_date_deliver_array = array();
				foreach($arrOrderEdis as $key => $row ) {
					$tmp_product_array[$key] = $row["product_code"];
					$tmp_date_deliver_array[$key] = $row["date_deliver"];
				}

				if(count($arrOrderEdis) > 0){
					array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_deliver_array ), SORT_ASC, SORT_NUMERIC, $arrOrderEdis);
				}

				$StockProducts = $this->StockProducts->find()//月末在庫呼び出し
				->where(['date_stock >=' => $dateback1, 'date_stock <=' => $datebacklast,
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みprimary_w
				->order(["date_stock"=>"ASC"])->toArray();

					$arrStockProducts = array();
					for($k=0; $k<count($StockProducts); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'primary_p' => 1, 'customer_code' => '10002'])->toArray();//productsの絞込みprimary_w

						if(isset($Product[0])){

							$arrStockProducts[] = [
								'product_code' => $StockProducts[$k]["product_code"],
								'date_stock' => $StockProducts[$k]["date_stock"],
								'amount' => $StockProducts[$k]["amount"]
						 ];

						}

					}
					//並べかえ
					$tmp_product_array = array();
					$tmp_date_stock_array = array();
					foreach($arrStockProducts as $key => $row ) {
						$tmp_product_array[$key] = $row["product_code"];
						$tmp_date_stock_array[$key] = $row["date_stock"];
					}

					if(count($arrStockProducts) > 0){
						array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_stock_array ), SORT_ASC, SORT_NUMERIC, $arrStockProducts);
					}

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0,
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みprimary_w
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrSyoyouKeikakus = array();
				for($k=0; $k<count($SyoyouKeikakus); $k++){

					$Product = $this->Products->find()->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'status' => 0, 'primary_p' => 1])->toArray();//productsの絞込み　primary

					if(isset($Product[0])){

						$arrSyoyouKeikakus[] = [
							'product_code' => $SyoyouKeikakus[$k]["product_code"],
							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
							'amount' => $SyoyouKeikakus[$k]["amount"]
					 ];

					 //child_pidを追加
					 $AssembleProductcilds = $this->AssembleProducts->find()->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

					 if(isset($AssembleProductcilds[0])){

						 for($l=0; $l<count($AssembleProductcilds); $l++){

							 $arrSyoyouKeikakus[] = [
	 							'product_code' => $AssembleProductcilds[$l]->child_pid,
	 							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
	 							'amount' => $SyoyouKeikakus[$k]["amount"]
	 					 ];

						 }

					 }

					}

				}

				//並べかえ
				$tmp_product_array = array();
				$tmp_date_deliver_array = array();
				foreach($arrSyoyouKeikakus as $key => $row ) {
					$tmp_product_array[$key] = $row["product_code"];
					$tmp_date_deliver_array[$key] = $row["date_deliver"];
				}

				if(count($arrSyoyouKeikakus) > 0){
					array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_deliver_array ), SORT_ASC, SORT_NUMERIC, $arrSyoyouKeikakus);
				}

				$daystart = $date1." 08:00:00";
				$dayfin = $datenext1." 07:59:59";

				$KadouSeikeis = $this->KadouSeikeis->find()//生産数呼び出し
				->where(['starting_tm >=' => $daystart, 'starting_tm <=' => $dayfin,
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みprimary_w
				->order(["starting_tm"=>"ASC"])->toArray();

					$arrSeisans = array();
					for($k=0; $k<count($KadouSeikeis); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $KadouSeikeis[$k]["product_code"], 'products.status' => 0, 'primary_p' => 1, 'customer_code' => '10002'])->toArray();//productsの絞込みprimary_w

						if(isset($Product[0])){

							$Katakouzous = $this->Katakouzous->find()->where(['product_code' => $KadouSeikeis[$k]["product_code"]])->toArray();

							$starting_tm = substr($KadouSeikeis[$k]['starting_tm'], 0, 10);
							$dateseikei = strtotime(substr($KadouSeikeis[$k]['starting_tm'], 10));

							if($dateseikei < strtotime(" 08:00:00")){
								$starting_tm = strtotime($starting_tm);
								$nippouday = date('Y/m/d', strtotime('-1 day', $starting_tm));
							}else{
								$nippouday = substr($KadouSeikeis[$k]['starting_tm'], 0, 10);
							}

							if(isset($Katakouzous[0])){
								$torisu = $Katakouzous[0]["torisu"];
							}else{
								$torisu = "Katakouzousテーブルに登録なし";
							}

							$arrSeisans[] = [
								'dateseikei' => $nippouday,
								'product_code' => $KadouSeikeis[$k]["product_code"],
								'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
								'torisu' => $torisu
						 ];

						}

					}

					//並べかえ
					$tmp_product_array2 = array();
					$tmp_dateseikei_array = array();
					foreach($arrSeisans as $key => $row ) {
						$tmp_product_array2[$key] = $row["product_code"];
						$tmp_dateseikei_array[$key] = $row["dateseikei"];
					}

					if(count($arrSeisans) > 0){
						array_multisort($tmp_product_array2, $tmp_dateseikei_array, SORT_ASC, SORT_NUMERIC, $arrSeisans);
					}

			}elseif($sheet === "primary_h"){

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'customer_code' => '10002',
				'OR' => [['product_code like' => 'H%']]])->toArray();

				$arrProductsmoto = array();
				for($k=0; $k<count($arrProducts); $k++){

					$riron_check = 0;
					$date16 = $yaermonth."-16";
					$RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $arrProducts[$k]["product_code"], 'date_culc' => $date16])->toArray();
					if(isset($RironStockProducts[0])){
						$riron_check = 1;
					}

					$arrProductsmoto[] = [
						'date_order' => "",
						'num_order' => "",
						'product_code' => $arrProducts[$k]["product_code"],
						'product_name' => $arrProducts[$k]["product_name"],
						'price' => "",
						'date_deliver' => "",
						'amount' => "",
						'denpyoumaisu' => "",
						'riron_zaiko_check' => $riron_check
				 ];

				}

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0, 'customer_code' => '10002',
				'OR' => [['product_code like' => 'H%']]])//productsの絞込みprimary_h
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
				$arrAssembleProducts = array();
				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $OrderEdis[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10002'])->toArray();//productsの絞込みprimary_h

					if(isset($Product[0])){

						$product_name = $Product[0]->product_name;

						$riron_check = 0;
						$date16 = $yaermonth."-16";
						$RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'date_culc' => $date16])->toArray();
						if(isset($RironStockProducts[0])){
							$riron_check = 1;
						}

							$arrOrderEdis[] = [
								'date_order' => $OrderEdis[$k]["date_order"],
								'num_order' => $OrderEdis[$k]["num_order"],
								'product_code' => $OrderEdis[$k]["product_code"],
								'product_name' => $product_name,
								'price' => $OrderEdis[$k]["price"],
								'date_deliver' => $OrderEdis[$k]["date_deliver"],
								'amount' => $OrderEdis[$k]["amount"],
								'denpyoumaisu' => 1,
								'riron_zaiko_check' => $riron_check
						 ];

						 for($l=0; $l<count($arrProductsmoto); $l++){

							 if($arrProductsmoto[$l]["product_code"] === $OrderEdis[$k]["product_code"]){

								 unset($arrProductsmoto[$l]);
								 $arrProductsmoto = array_values($arrProductsmoto);

							 }

						}

						//組立品呼び出し
						$ResultZensuHeads = $this->ResultZensuHeads->find()
						->where(['product_code' => $OrderEdis[$k]["product_code"], 'datetime_finish >=' => $datestart." 00:00:00", 'datetime_finish <' => $dateend." 00:00:00"])
						->order(["datetime_finish"=>"DESC"])->toArray();

						if(isset($ResultZensuHeads[0])){//210107データ確認ok

								$AssembleProducts = $this->AssembleProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

								if(isset($AssembleProducts[0])){

									$diff = floor((strtotime($datenext1) - $date1st) / (60 * 60 * 24));

									for($l=0; $l<$diff; $l++){//それぞれの日付に対して

										$datetime_finish = strtotime("+$l day " . $date1);
			              $datetime_finish = date("Y-m-d", $datetime_finish);

										$Konpou = $this->Konpous->find()->where(['product_code' => $OrderEdis[$k]["product_code"]])->toArray();
										$irisu = $Konpou[0]->irisu;

										$ResultZensuHeadsday = $this->ResultZensuHeads->find()
										->where(['product_code' => $OrderEdis[$k]["product_code"], 'datetime_finish >=' => $datetime_finish." 00:00:00", 'datetime_finish <=' => $datetime_finish." 23:59:59"])
										->order(["datetime_finish"=>"DESC"])->toArray();

										if(isset($ResultZensuHeadsday[0])){

											$amount = $irisu * count($ResultZensuHeadsday);

											 $arrAssembleProducts[] = [
												 'product_code' => $OrderEdis[$k]["product_code"],
												 'kensabi' => $datetime_finish,
												 'amount' => $amount
											];

										}

									}

								}

							$arrAssembleProducts = array_unique($arrAssembleProducts, SORT_REGULAR);
							$arrAssembleProducts = array_values($arrAssembleProducts);

							$product_code = array();
							$kensabi = array();
							foreach ($arrAssembleProducts as $key => $value) {
  							 $product_code[$key] = $value['product_code'];
  							 $kensabi[$key] = $value["kensabi"];
  						 }

							 if(isset($kensabi)){
								 array_multisort($product_code, array_map( "strtotime", $kensabi ), SORT_ASC, SORT_NUMERIC, $arrAssembleProducts);
							 }

						}

					}

				}


				//同一のproduct_code、date_deliverの注文は一つにまとめ、amountとdenpyoumaisuを更新
				for($l=0; $l<count($arrOrderEdis); $l++){

					for($m=$l+1; $m<count($arrOrderEdis); $m++){

						if($arrOrderEdis[$l]["product_code"] == $arrOrderEdis[$m]["product_code"] && $arrOrderEdis[$l]["date_deliver"] == $arrOrderEdis[$m]["date_deliver"]){

							$amount = $arrOrderEdis[$l]["amount"] + $arrOrderEdis[$m]["amount"];
							$denpyoumaisu = $arrOrderEdis[$l]["denpyoumaisu"] + $arrOrderEdis[$m]["denpyoumaisu"];

							$arrOrderEdis[$l]["amount"] = $amount;
							$arrOrderEdis[$l]["denpyoumaisu"] = $denpyoumaisu;

							unset($arrOrderEdis[$m]);

						}

					}
					$arrOrderEdis = array_values($arrOrderEdis);

				}

				$arrOrderEdis = array_merge($arrOrderEdis, $arrProductsmoto);

				//並べかえ
				$tmp_product_array = array();
				$tmp_date_deliver_array = array();
				foreach($arrOrderEdis as $key => $row ) {
					$tmp_product_array[$key] = $row["product_code"];
					$tmp_date_deliver_array[$key] = $row["date_deliver"];
				}

				if(count($arrOrderEdis) > 0){
					array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_deliver_array ), SORT_ASC, SORT_NUMERIC, $arrOrderEdis);
				}

				$StockProducts = $this->StockProducts->find()//月末在庫呼び出し
				->where(['date_stock >=' => $dateback1, 'date_stock <=' => $datebacklast,
				'OR' => ['product_code like' => 'H%']])//productsの絞込みprimary_h
				->order(["date_stock"=>"ASC"])->toArray();

					$arrStockProducts = array();
					for($k=0; $k<count($StockProducts); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10002'])->toArray();//productsの絞込みprimary_h

						if(isset($Product[0])){

							$arrStockProducts[] = [
								'product_code' => $StockProducts[$k]["product_code"],
								'date_stock' => $StockProducts[$k]["date_stock"],
								'amount' => $StockProducts[$k]["amount"]
						 ];

						}

					}
					//並べかえ
					$tmp_product_array = array();
					$tmp_date_stock_array = array();
					foreach($arrStockProducts as $key => $row ) {
						$tmp_product_array[$key] = $row["product_code"];
						$tmp_date_stock_array[$key] = $row["date_stock"];
					}

					if(count($arrStockProducts) > 0){
						array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_stock_array ), SORT_ASC, SORT_NUMERIC, $arrStockProducts);
					}

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0,
				'OR' => ['product_code like' => 'H%']])//productsの絞込みprimary_h
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrSyoyouKeikakus = array();
				for($k=0; $k<count($SyoyouKeikakus); $k++){

					$Product = $this->Products->find()->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'status' => 0])->toArray();//productsの絞込み　primary

					if(isset($Product[0])){

						$arrSyoyouKeikakus[] = [
							'product_code' => $SyoyouKeikakus[$k]["product_code"],
							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
							'amount' => $SyoyouKeikakus[$k]["amount"]
					 ];

					 //child_pidを追加
					 $AssembleProductcilds = $this->AssembleProducts->find()->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

					 if(isset($AssembleProductcilds[0])){

						 for($l=0; $l<count($AssembleProductcilds); $l++){

							 $arrSyoyouKeikakus[] = [
	 							'product_code' => $AssembleProductcilds[$l]->child_pid,
	 							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
	 							'amount' => $SyoyouKeikakus[$k]["amount"]
	 					 ];

						 }

					 }

					}

				}

				//並べかえ
								$tmp_product_array = array();
								$tmp_date_deliver_array = array();
								foreach($arrSyoyouKeikakus as $key => $row ) {
									$tmp_product_array[$key] = $row["product_code"];
									$tmp_date_deliver_array[$key] = $row["date_deliver"];
								}

								if(count($arrSyoyouKeikakus) > 0){
									array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_deliver_array ), SORT_ASC, SORT_NUMERIC, $arrSyoyouKeikakus);
								}

				$daystart = $date1." 08:00:00";
				$dayfin = $datenext1." 07:59:59";

				$KadouSeikeis = $this->KadouSeikeis->find()//生産数呼び出し
				->where(['starting_tm >=' => $daystart, 'starting_tm <=' => $dayfin,
				'OR' => ['product_code like' => 'H%']])//productsの絞込みprimary_h
				->order(["starting_tm"=>"ASC"])->toArray();

					$arrSeisans = array();
					for($k=0; $k<count($KadouSeikeis); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $KadouSeikeis[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10002'])->toArray();//productsの絞込みprimary_h

						if(isset($Product[0])){

							$Katakouzous = $this->Katakouzous->find()->where(['product_code' => $KadouSeikeis[$k]["product_code"]])->toArray();

							$starting_tm = substr($KadouSeikeis[$k]['starting_tm'], 0, 10);
							$dateseikei = strtotime(substr($KadouSeikeis[$k]['starting_tm'], 10));

							if($dateseikei < strtotime(" 08:00:00")){
								$starting_tm = strtotime($starting_tm);
								$nippouday = date('Y/m/d', strtotime('-1 day', $starting_tm));
							}else{
								$nippouday = substr($KadouSeikeis[$k]['starting_tm'], 0, 10);
							}

							if(isset($Katakouzous[0])){
								$torisu = $Katakouzous[0]["torisu"];
							}else{
								$torisu = "Katakouzousテーブルに登録なし";
							}

							$arrSeisans[] = [
								'dateseikei' => $nippouday,
								'product_code' => $KadouSeikeis[$k]["product_code"],
								'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
								'torisu' => $torisu
						 ];

						}

					}

					//並べかえ
					$tmp_product_array2 = array();
					$tmp_dateseikei_array = array();
					foreach($arrSeisans as $key => $row ) {
						$tmp_product_array2[$key] = $row["product_code"];
						$tmp_dateseikei_array[$key] = $row["dateseikei"];
					}

					if(count($arrSeisans) > 0){
						array_multisort($tmp_product_array2, $tmp_dateseikei_array, SORT_ASC, SORT_NUMERIC, $arrSeisans);
					}

			}elseif($sheet === "reizouko"){

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'customer_code' => '10005'])->toArray();

				$arrProductsmoto = array();
				for($k=0; $k<count($arrProducts); $k++){

					$riron_check = 0;
					$date16 = $yaermonth."-16";
					$RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $arrProducts[$k]["product_code"], 'date_culc' => $date16])->toArray();
					if(isset($RironStockProducts[0])){
						$riron_check = 1;
					}

					$arrProductsmoto[] = [
						'date_order' => "",
						'num_order' => "",
						'product_code' => $arrProducts[$k]["product_code"],
						'product_name' => $arrProducts[$k]["product_name"],
						'price' => "",
						'date_deliver' => "",
						'amount' => "",
						'denpyoumaisu' => "",
						'riron_zaiko_check' => $riron_check
				 ];

				}

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0,
				'OR' => [['customer_code' => '10005']]])//productsの絞込みreizouko
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
				$arrAssembleProducts = array();
				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $OrderEdis[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10005'])->toArray();//productsの絞込みreizouko

					if(isset($Product[0])){

						$product_name = $Product[0]->product_name;

						$riron_check = 0;
						$date16 = $yaermonth."-16";
						$RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'date_culc' => $date16])->toArray();
						if(isset($RironStockProducts[0])){
							$riron_check = 1;
						}

							$arrOrderEdis[] = [
								'date_order' => $OrderEdis[$k]["date_order"],
								'num_order' => $OrderEdis[$k]["num_order"],
								'product_code' => $OrderEdis[$k]["product_code"],
								'product_name' => $product_name,
								'price' => $OrderEdis[$k]["price"],
								'date_deliver' => $OrderEdis[$k]["date_deliver"],
								'amount' => $OrderEdis[$k]["amount"],
								'denpyoumaisu' => 1,
								'riron_zaiko_check' => $riron_check
						 ];

						 for($l=0; $l<count($arrProductsmoto); $l++){

							 if($arrProductsmoto[$l]["product_code"] === $OrderEdis[$k]["product_code"]){

								 unset($arrProductsmoto[$l]);
								 $arrProductsmoto = array_values($arrProductsmoto);

							 }

						}

						//組立品呼び出し
						$ResultZensuHeads = $this->ResultZensuHeads->find()
						->where(['product_code' => $OrderEdis[$k]["product_code"], 'datetime_finish >=' => $datestart." 00:00:00", 'datetime_finish <' => $dateend." 00:00:00"])
						->order(["datetime_finish"=>"DESC"])->toArray();

						if(isset($ResultZensuHeads[0])){//210107データ確認ok

								$AssembleProducts = $this->AssembleProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

								if(isset($AssembleProducts[0])){

									$diff = floor((strtotime($datenext1) - $date1st) / (60 * 60 * 24));

									for($l=0; $l<$diff; $l++){//それぞれの日付に対して

										$datetime_finish = strtotime("+$l day " . $date1);
			              $datetime_finish = date("Y-m-d", $datetime_finish);

										$Konpou = $this->Konpous->find()->where(['product_code' => $OrderEdis[$k]["product_code"]])->toArray();
										$irisu = $Konpou[0]->irisu;

										$ResultZensuHeadsday = $this->ResultZensuHeads->find()
										->where(['product_code' => $OrderEdis[$k]["product_code"], 'datetime_finish >=' => $datetime_finish." 00:00:00", 'datetime_finish <=' => $datetime_finish." 23:59:59"])
										->order(["datetime_finish"=>"DESC"])->toArray();

										if(isset($ResultZensuHeadsday[0])){

											$amount = $irisu * count($ResultZensuHeadsday);

											 $arrAssembleProducts[] = [
												 'product_code' => $OrderEdis[$k]["product_code"],
												 'kensabi' => $datetime_finish,
												 'amount' => $amount
											];

										}

									}

								}

							$arrAssembleProducts = array_unique($arrAssembleProducts, SORT_REGULAR);
							$arrAssembleProducts = array_values($arrAssembleProducts);

							$product_code = array();
							$kensabi = array();
							foreach ($arrAssembleProducts as $key => $value) {
  							 $product_code[$key] = $value['product_code'];
  							 $kensabi[$key] = $value["kensabi"];
  						 }

							 if(isset($kensabi)){
								 array_multisort($product_code, array_map( "strtotime", $kensabi ), SORT_ASC, SORT_NUMERIC, $arrAssembleProducts);
							 }

						}

					}

				}


				//同一のproduct_code、date_deliverの注文は一つにまとめ、amountとdenpyoumaisuを更新
				for($l=0; $l<count($arrOrderEdis); $l++){

					for($m=$l+1; $m<count($arrOrderEdis); $m++){

						if($arrOrderEdis[$l]["product_code"] == $arrOrderEdis[$m]["product_code"] && $arrOrderEdis[$l]["date_deliver"] == $arrOrderEdis[$m]["date_deliver"]){

							$amount = $arrOrderEdis[$l]["amount"] + $arrOrderEdis[$m]["amount"];
							$denpyoumaisu = $arrOrderEdis[$l]["denpyoumaisu"] + $arrOrderEdis[$m]["denpyoumaisu"];

							$arrOrderEdis[$l]["amount"] = $amount;
							$arrOrderEdis[$l]["denpyoumaisu"] = $denpyoumaisu;

							unset($arrOrderEdis[$m]);

						}

					}
					$arrOrderEdis = array_values($arrOrderEdis);

				}

				$arrOrderEdis = array_merge($arrOrderEdis, $arrProductsmoto);

				//並べかえ
				$tmp_product_array = array();
				$tmp_date_deliver_array = array();
				foreach($arrOrderEdis as $key => $row ) {
					$tmp_product_array[$key] = $row["product_code"];
					$tmp_date_deliver_array[$key] = $row["date_deliver"];
				}

				if(count($arrOrderEdis) > 0){
					array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_deliver_array ), SORT_ASC, SORT_NUMERIC, $arrOrderEdis);
				}

				$StockProducts = $this->StockProducts->find()//月末在庫呼び出し
				->where(['date_stock >=' => $dateback1, 'date_stock <=' => $datebacklast])
				->order(["date_stock"=>"ASC"])->toArray();

					$arrStockProducts = array();
					for($k=0; $k<count($StockProducts); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10005'])->toArray();//productsの絞込みreizouko

						if(isset($Product[0])){

							$arrStockProducts[] = [
								'product_code' => $StockProducts[$k]["product_code"],
								'date_stock' => $StockProducts[$k]["date_stock"],
								'amount' => $StockProducts[$k]["amount"]
						 ];

						}

					}
					//並べかえ
					$tmp_product_array = array();
					$tmp_date_stock_array = array();
					foreach($arrStockProducts as $key => $row ) {
						$tmp_product_array[$key] = $row["product_code"];
						$tmp_date_stock_array[$key] = $row["date_stock"];
					}

					if(count($arrStockProducts) > 0){
						array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_stock_array ), SORT_ASC, SORT_NUMERIC, $arrStockProducts);
					}

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0])
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrSyoyouKeikakus = array();
				for($k=0; $k<count($SyoyouKeikakus); $k++){

					$Product = $this->Products->find()->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'status' => 0, 'primary_p' => 1])->toArray();//productsの絞込み　primary

					if(isset($Product[0])){

						$arrSyoyouKeikakus[] = [
							'product_code' => $SyoyouKeikakus[$k]["product_code"],
							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
							'amount' => $SyoyouKeikakus[$k]["amount"]
					 ];

					 //child_pidを追加
					 $AssembleProductcilds = $this->AssembleProducts->find()->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

					 if(isset($AssembleProductcilds[0])){

						 for($l=0; $l<count($AssembleProductcilds); $l++){

							 $arrSyoyouKeikakus[] = [
	 							'product_code' => $AssembleProductcilds[$l]->child_pid,
	 							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
	 							'amount' => $SyoyouKeikakus[$k]["amount"]
	 					 ];

						 }

					 }

					}

				}

				//並べかえ
								$tmp_product_array = array();
								$tmp_date_deliver_array = array();
								foreach($arrSyoyouKeikakus as $key => $row ) {
									$tmp_product_array[$key] = $row["product_code"];
									$tmp_date_deliver_array[$key] = $row["date_deliver"];
								}

								if(count($arrSyoyouKeikakus) > 0){
									array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_deliver_array ), SORT_ASC, SORT_NUMERIC, $arrSyoyouKeikakus);
								}

				$daystart = $date1." 08:00:00";
				$dayfin = $datenext1." 07:59:59";

				$KadouSeikeis = $this->KadouSeikeis->find()//生産数呼び出し
				->where(['starting_tm >=' => $daystart, 'starting_tm <=' => $dayfin])
				->order(["starting_tm"=>"ASC"])->toArray();

					$arrSeisans = array();
					for($k=0; $k<count($KadouSeikeis); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $KadouSeikeis[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10005'])->toArray();//productsの絞込みreizouko

						if(isset($Product[0])){

							$Katakouzous = $this->Katakouzous->find()->where(['product_code' => $KadouSeikeis[$k]["product_code"]])->toArray();

							$starting_tm = substr($KadouSeikeis[$k]['starting_tm'], 0, 10);
							$dateseikei = strtotime(substr($KadouSeikeis[$k]['starting_tm'], 10));

							if($dateseikei < strtotime(" 08:00:00")){
								$starting_tm = strtotime($starting_tm);
								$nippouday = date('Y/m/d', strtotime('-1 day', $starting_tm));
							}else{
								$nippouday = substr($KadouSeikeis[$k]['starting_tm'], 0, 10);
							}

							if(isset($Katakouzous[0])){
								$torisu = $Katakouzous[0]["torisu"];
							}else{
								$torisu = "Katakouzousテーブルに登録なし";
							}

							$arrSeisans[] = [
								'dateseikei' => $nippouday,
								'product_code' => $KadouSeikeis[$k]["product_code"],
								'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
								'torisu' => $torisu
						 ];

						}

					}

					//並べかえ
					$tmp_product_array2 = array();
					$tmp_dateseikei_array = array();
					foreach($arrSeisans as $key => $row ) {
						$tmp_product_array2[$key] = $row["product_code"];
						$tmp_dateseikei_array[$key] = $row["dateseikei"];
					}

					if(count($arrSeisans) > 0){
						array_multisort($tmp_product_array2, $tmp_dateseikei_array, SORT_ASC, SORT_NUMERIC, $arrSeisans);
					}

			}elseif($sheet === "uwawaku"){

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'customer_code' => '10003'])->toArray();

				$arrProductsmoto = array();
				for($k=0; $k<count($arrProducts); $k++){

					$riron_check = 0;
					$date16 = $yaermonth."-16";
					$RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $arrProducts[$k]["product_code"], 'date_culc' => $date16])->toArray();
					if(isset($RironStockProducts[0])){
						$riron_check = 1;
					}

					$arrProductsmoto[] = [
						'date_order' => "",
						'num_order' => "",
						'product_code' => $arrProducts[$k]["product_code"],
						'product_name' => $arrProducts[$k]["product_name"],
						'price' => "",
						'date_deliver' => "",
						'amount' => "",
						'denpyoumaisu' => "",
						'riron_zaiko_check' => $riron_check
				 ];

				}

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0,
				'OR' => [['customer_code' => '10003']]])//productsの絞込みuwawaku
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
				$arrAssembleProducts = array();
				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $OrderEdis[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10003'])->toArray();//productsの絞込みuwawaku

					if(isset($Product[0])){

						$product_name = $Product[0]->product_name;

						$riron_check = 0;
						$date16 = $yaermonth."-16";
						$RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'date_culc' => $date16])->toArray();
						if(isset($RironStockProducts[0])){
							$riron_check = 1;
						}

							$arrOrderEdis[] = [
								'date_order' => $OrderEdis[$k]["date_order"],
								'num_order' => $OrderEdis[$k]["num_order"],
								'product_code' => $OrderEdis[$k]["product_code"],
								'product_name' => $product_name,
								'price' => $OrderEdis[$k]["price"],
								'date_deliver' => $OrderEdis[$k]["date_deliver"],
								'amount' => $OrderEdis[$k]["amount"],
								'denpyoumaisu' => 1,
								'riron_zaiko_check' => $riron_check
						 ];

						 for($l=0; $l<count($arrProductsmoto); $l++){

							 if($arrProductsmoto[$l]["product_code"] === $OrderEdis[$k]["product_code"]){

								 unset($arrProductsmoto[$l]);
								 $arrProductsmoto = array_values($arrProductsmoto);

							 }

						}

						//組立品呼び出し
						$ResultZensuHeads = $this->ResultZensuHeads->find()
						->where(['product_code' => $OrderEdis[$k]["product_code"], 'datetime_finish >=' => $datestart." 00:00:00", 'datetime_finish <' => $dateend." 00:00:00"])
						->order(["datetime_finish"=>"DESC"])->toArray();

						if(isset($ResultZensuHeads[0])){//210107データ確認ok

								$AssembleProducts = $this->AssembleProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

								if(isset($AssembleProducts[0])){

									$diff = floor((strtotime($datenext1) - $date1st) / (60 * 60 * 24));

									for($l=0; $l<$diff; $l++){//それぞれの日付に対して

										$datetime_finish = strtotime("+$l day " . $date1);
			              $datetime_finish = date("Y-m-d", $datetime_finish);

										$Konpou = $this->Konpous->find()->where(['product_code' => $OrderEdis[$k]["product_code"]])->toArray();
										$irisu = $Konpou[0]->irisu;

										$ResultZensuHeadsday = $this->ResultZensuHeads->find()
										->where(['product_code' => $OrderEdis[$k]["product_code"], 'datetime_finish >=' => $datetime_finish." 00:00:00", 'datetime_finish <=' => $datetime_finish." 23:59:59"])
										->order(["datetime_finish"=>"DESC"])->toArray();

										if(isset($ResultZensuHeadsday[0])){

											$amount = $irisu * count($ResultZensuHeadsday);

											 $arrAssembleProducts[] = [
												 'product_code' => $OrderEdis[$k]["product_code"],
												 'kensabi' => $datetime_finish,
												 'amount' => $amount
											];

										}

									}

								}

							$arrAssembleProducts = array_unique($arrAssembleProducts, SORT_REGULAR);
							$arrAssembleProducts = array_values($arrAssembleProducts);

							$product_code = array();
							$kensabi = array();
							foreach ($arrAssembleProducts as $key => $value) {
  							 $product_code[$key] = $value['product_code'];
  							 $kensabi[$key] = $value["kensabi"];
  						 }

							 if(isset($kensabi)){
								 array_multisort($product_code, array_map( "strtotime", $kensabi ), SORT_ASC, SORT_NUMERIC, $arrAssembleProducts);
							 }

						}

					}

				}


				//同一のproduct_code、date_deliverの注文は一つにまとめ、amountとdenpyoumaisuを更新
				for($l=0; $l<count($arrOrderEdis); $l++){

					for($m=$l+1; $m<count($arrOrderEdis); $m++){

						if($arrOrderEdis[$l]["product_code"] == $arrOrderEdis[$m]["product_code"] && $arrOrderEdis[$l]["date_deliver"] == $arrOrderEdis[$m]["date_deliver"]){

							$amount = $arrOrderEdis[$l]["amount"] + $arrOrderEdis[$m]["amount"];
							$denpyoumaisu = $arrOrderEdis[$l]["denpyoumaisu"] + $arrOrderEdis[$m]["denpyoumaisu"];

							$arrOrderEdis[$l]["amount"] = $amount;
							$arrOrderEdis[$l]["denpyoumaisu"] = $denpyoumaisu;

							unset($arrOrderEdis[$m]);

						}

					}
					$arrOrderEdis = array_values($arrOrderEdis);

				}

				$arrOrderEdis = array_merge($arrOrderEdis, $arrProductsmoto);

				//並べかえ
				$tmp_product_array = array();
				$tmp_date_deliver_array = array();
				foreach($arrOrderEdis as $key => $row ) {
					$tmp_product_array[$key] = $row["product_code"];
					$tmp_date_deliver_array[$key] = $row["date_deliver"];
				}

				if(count($arrOrderEdis) > 0){
					array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_deliver_array ), SORT_ASC, SORT_NUMERIC, $arrOrderEdis);
				}

				$StockProducts = $this->StockProducts->find()//月末在庫呼び出し
				->where(['date_stock >=' => $dateback1, 'date_stock <=' => $datebacklast])
				->order(["date_stock"=>"ASC"])->toArray();

					$arrStockProducts = array();
					for($k=0; $k<count($StockProducts); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10003'])->toArray();//productsの絞込みuwawaku

						if(isset($Product[0])){

							$arrStockProducts[] = [
								'product_code' => $StockProducts[$k]["product_code"],
								'date_stock' => $StockProducts[$k]["date_stock"],
								'amount' => $StockProducts[$k]["amount"]
						 ];

						}

					}
					//並べかえ
					$tmp_product_array = array();
					$tmp_date_stock_array = array();
					foreach($arrStockProducts as $key => $row ) {
						$tmp_product_array[$key] = $row["product_code"];
						$tmp_date_stock_array[$key] = $row["date_stock"];
					}

					if(count($arrStockProducts) > 0){
						array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_stock_array ), SORT_ASC, SORT_NUMERIC, $arrStockProducts);
					}

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0])
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrSyoyouKeikakus = array();
				for($k=0; $k<count($SyoyouKeikakus); $k++){

					$Product = $this->Products->find()->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'status' => 0, 'primary_p' => 1])->toArray();//productsの絞込み　primary

					if(isset($Product[0])){

						$arrSyoyouKeikakus[] = [
							'product_code' => $SyoyouKeikakus[$k]["product_code"],
							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
							'amount' => $SyoyouKeikakus[$k]["amount"]
					 ];

					 //child_pidを追加
					 $AssembleProductcilds = $this->AssembleProducts->find()->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

					 if(isset($AssembleProductcilds[0])){

						 for($l=0; $l<count($AssembleProductcilds); $l++){

							 $arrSyoyouKeikakus[] = [
	 							'product_code' => $AssembleProductcilds[$l]->child_pid,
	 							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
	 							'amount' => $SyoyouKeikakus[$k]["amount"]
	 					 ];

						 }

					 }

					}

				}

				//並べかえ
								$tmp_product_array = array();
								$tmp_date_deliver_array = array();
								foreach($arrSyoyouKeikakus as $key => $row ) {
									$tmp_product_array[$key] = $row["product_code"];
									$tmp_date_deliver_array[$key] = $row["date_deliver"];
								}

								if(count($arrSyoyouKeikakus) > 0){
									array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_deliver_array ), SORT_ASC, SORT_NUMERIC, $arrSyoyouKeikakus);
								}

				$daystart = $date1." 08:00:00";
				$dayfin = $datenext1." 07:59:59";

				$KadouSeikeis = $this->KadouSeikeis->find()//生産数呼び出し
				->where(['starting_tm >=' => $daystart, 'starting_tm <=' => $dayfin])
				->order(["starting_tm"=>"ASC"])->toArray();

					$arrSeisans = array();
					for($k=0; $k<count($KadouSeikeis); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $KadouSeikeis[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10003'])->toArray();//productsの絞込みuwawaku

						if(isset($Product[0])){

							$Katakouzous = $this->Katakouzous->find()->where(['product_code' => $KadouSeikeis[$k]["product_code"]])->toArray();

							$starting_tm = substr($KadouSeikeis[$k]['starting_tm'], 0, 10);
							$dateseikei = strtotime(substr($KadouSeikeis[$k]['starting_tm'], 10));

							if($dateseikei < strtotime(" 08:00:00")){
								$starting_tm = strtotime($starting_tm);
								$nippouday = date('Y/m/d', strtotime('-1 day', $starting_tm));
							}else{
								$nippouday = substr($KadouSeikeis[$k]['starting_tm'], 0, 10);
							}

							if(isset($Katakouzous[0])){
								$torisu = $Katakouzous[0]["torisu"];
							}else{
								$torisu = "Katakouzousテーブルに登録なし";
							}

							$arrSeisans[] = [
								'dateseikei' => $nippouday,
								'product_code' => $KadouSeikeis[$k]["product_code"],
								'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
								'torisu' => $torisu
						 ];

						}

					}

					//並べかえ
					$tmp_product_array2 = array();
					$tmp_dateseikei_array = array();
					foreach($arrSeisans as $key => $row ) {
						$tmp_product_array2[$key] = $row["product_code"];
						$tmp_dateseikei_array[$key] = $row["dateseikei"];
					}

					if(count($arrSeisans) > 0){
						array_multisort($tmp_product_array2, $tmp_dateseikei_array, SORT_ASC, SORT_NUMERIC, $arrSeisans);
					}

			}elseif($sheet === "other"){

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
		//		->where(['products.status' => 0, 'customer_code not like' => '1%', 'customer_code not like' => '2%'])->toArray();
				->where(['products.status' => 0,
				'AND' => [['customer_code not like' => '1%'], ['customer_code not like' => '2%']]])->toArray();

				$arrProductsmoto = array();
				for($k=0; $k<count($arrProducts); $k++){

					$riron_check = 0;
					$date16 = $yaermonth."-16";
					$RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $arrProducts[$k]["product_code"], 'date_culc' => $date16])->toArray();
					if(isset($RironStockProducts[0])){
						$riron_check = 1;
					}

					$arrProductsmoto[] = [
						'date_order' => "",
						'num_order' => "",
						'product_code' => $arrProducts[$k]["product_code"],
						'product_name' => $arrProducts[$k]["product_name"],
						'price' => "",
						'date_deliver' => "",
						'amount' => "",
						'denpyoumaisu' => "",
						'riron_zaiko_check' => $riron_check
				 ];

				}

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
		//		->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0, 'customer_code not like' => '1%', 'customer_code not like' => '2%'])//productsの絞込みother
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0, 'AND' => [['customer_code not like' => '1%'], ['customer_code not like' => '2%']]])//productsの絞込みother
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
				$arrAssembleProducts = array();
				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
		//			->where(['product_code' => $OrderEdis[$k]["product_code"], 'products.status' => 0, 'customer_code not like' => '1%', 'customer_code not like' => '2%'])//productsの絞込みother
					->where(['product_code' => $OrderEdis[$k]["product_code"], 'products.status' => 0, 'AND' => [['customer_code not like' => '1%'], ['customer_code not like' => '2%']]])//productsの絞込みother
					->toArray();//productsの絞込みother

					if(isset($Product[0])){

						$product_name = $Product[0]->product_name;

						$riron_check = 0;
						$date16 = $yaermonth."-16";
						$RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'date_culc' => $date16])->toArray();
						if(isset($RironStockProducts[0])){
							$riron_check = 1;
						}

							$arrOrderEdis[] = [
								'date_order' => $OrderEdis[$k]["date_order"],
								'num_order' => $OrderEdis[$k]["num_order"],
								'product_code' => $OrderEdis[$k]["product_code"],
								'product_name' => $product_name,
								'price' => $OrderEdis[$k]["price"],
								'date_deliver' => $OrderEdis[$k]["date_deliver"],
								'amount' => $OrderEdis[$k]["amount"],
								'denpyoumaisu' => 1,
								'riron_zaiko_check' => $riron_check
						 ];

						 						 for($l=0; $l<count($arrProductsmoto); $l++){

						 							 if($arrProductsmoto[$l]["product_code"] === $OrderEdis[$k]["product_code"]){

						 								 unset($arrProductsmoto[$l]);
						 								 $arrProductsmoto = array_values($arrProductsmoto);

						 							 }

						 		 				}

												//組立品呼び出し
												$ResultZensuHeads = $this->ResultZensuHeads->find()
												->where(['product_code' => $OrderEdis[$k]["product_code"], 'datetime_finish >=' => $datestart." 00:00:00", 'datetime_finish <' => $dateend." 00:00:00"])
												->order(["datetime_finish"=>"DESC"])->toArray();

												if(isset($ResultZensuHeads[0])){//210107データ確認ok

														$AssembleProducts = $this->AssembleProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

														if(isset($AssembleProducts[0])){

															$diff = floor((strtotime($datenext1) - $date1st) / (60 * 60 * 24));

															for($l=0; $l<$diff; $l++){//それぞれの日付に対して

																$datetime_finish = strtotime("+$l day " . $date1);
									              $datetime_finish = date("Y-m-d", $datetime_finish);

																$Konpou = $this->Konpous->find()->where(['product_code' => $OrderEdis[$k]["product_code"]])->toArray();
																$irisu = $Konpou[0]->irisu;

																$ResultZensuHeadsday = $this->ResultZensuHeads->find()
																->where(['product_code' => $OrderEdis[$k]["product_code"], 'datetime_finish >=' => $datetime_finish." 00:00:00", 'datetime_finish <=' => $datetime_finish." 23:59:59"])
																->order(["datetime_finish"=>"DESC"])->toArray();

																if(isset($ResultZensuHeadsday[0])){

																	$amount = $irisu * count($ResultZensuHeadsday);

																	 $arrAssembleProducts[] = [
																		 'product_code' => $OrderEdis[$k]["product_code"],
																		 'kensabi' => $datetime_finish,
																		 'amount' => $amount
																	];

																}

															}

														}

													$arrAssembleProducts = array_unique($arrAssembleProducts, SORT_REGULAR);
													$arrAssembleProducts = array_values($arrAssembleProducts);

													$product_code = array();
													$kensabi = array();
													foreach ($arrAssembleProducts as $key => $value) {
						  							 $product_code[$key] = $value['product_code'];
						  							 $kensabi[$key] = $value["kensabi"];
						  						 }

													 if(isset($kensabi)){
														 array_multisort($product_code, array_map( "strtotime", $kensabi ), SORT_ASC, SORT_NUMERIC, $arrAssembleProducts);
													 }

												}

											}

										}


										//同一のproduct_code、date_deliverの注文は一つにまとめ、amountとdenpyoumaisuを更新
										for($l=0; $l<count($arrOrderEdis); $l++){

											for($m=$l+1; $m<count($arrOrderEdis); $m++){

												if($arrOrderEdis[$l]["product_code"] == $arrOrderEdis[$m]["product_code"] && $arrOrderEdis[$l]["date_deliver"] == $arrOrderEdis[$m]["date_deliver"]){

													$amount = $arrOrderEdis[$l]["amount"] + $arrOrderEdis[$m]["amount"];
													$denpyoumaisu = $arrOrderEdis[$l]["denpyoumaisu"] + $arrOrderEdis[$m]["denpyoumaisu"];

													$arrOrderEdis[$l]["amount"] = $amount;
													$arrOrderEdis[$l]["denpyoumaisu"] = $denpyoumaisu;

													unset($arrOrderEdis[$m]);

												}

											}
											$arrOrderEdis = array_values($arrOrderEdis);

										}

										$arrOrderEdis = array_merge($arrOrderEdis, $arrProductsmoto);

				//並べかえ
				$tmp_product_array = array();
				$tmp_date_deliver_array = array();
				foreach($arrOrderEdis as $key => $row ) {
					$tmp_product_array[$key] = $row["product_code"];
					$tmp_date_deliver_array[$key] = $row["date_deliver"];
				}

				if(count($arrOrderEdis) > 0){
					array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_deliver_array ), SORT_ASC, SORT_NUMERIC, $arrOrderEdis);
				}

				$StockProducts = $this->StockProducts->find()//月末在庫呼び出し
				->where(['date_stock >=' => $dateback1, 'date_stock <=' => $datebacklast])
				->order(["date_stock"=>"ASC"])->toArray();

					$arrStockProducts = array();
					for($k=0; $k<count($StockProducts); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'AND' => [['customer_code not like' => '1%'], ['customer_code not like' => '2%']]])//productsの絞込みother
						->toArray();//productsの絞込みother

						if(isset($Product[0])){

							$arrStockProducts[] = [
								'product_code' => $StockProducts[$k]["product_code"],
								'date_stock' => $StockProducts[$k]["date_stock"],
								'amount' => $StockProducts[$k]["amount"]
						 ];

						}

					}
					//並べかえ
					$tmp_product_array = array();
					$tmp_date_stock_array = array();
					foreach($arrStockProducts as $key => $row ) {
						$tmp_product_array[$key] = $row["product_code"];
						$tmp_date_stock_array[$key] = $row["date_stock"];
					}

					if(count($arrStockProducts) > 0){
						array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_stock_array ), SORT_ASC, SORT_NUMERIC, $arrStockProducts);
					}

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0])
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrSyoyouKeikakus = array();
				for($k=0; $k<count($SyoyouKeikakus); $k++){

					$Product = $this->Products->find()->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'status' => 0, 'primary_p' => 1])->toArray();//productsの絞込み　primary

					if(isset($Product[0])){

						$arrSyoyouKeikakus[] = [
							'product_code' => $SyoyouKeikakus[$k]["product_code"],
							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
							'amount' => $SyoyouKeikakus[$k]["amount"]
					 ];

					 //child_pidを追加
					 $AssembleProductcilds = $this->AssembleProducts->find()->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

					 if(isset($AssembleProductcilds[0])){

						 for($l=0; $l<count($AssembleProductcilds); $l++){

							 $arrSyoyouKeikakus[] = [
	 							'product_code' => $AssembleProductcilds[$l]->child_pid,
	 							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
	 							'amount' => $SyoyouKeikakus[$k]["amount"]
	 					 ];

						 }

					 }

					}

				}

				//並べかえ
								$tmp_product_array = array();
								$tmp_date_deliver_array = array();
								foreach($arrSyoyouKeikakus as $key => $row ) {
									$tmp_product_array[$key] = $row["product_code"];
									$tmp_date_deliver_array[$key] = $row["date_deliver"];
								}

								if(count($arrSyoyouKeikakus) > 0){
									array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_deliver_array ), SORT_ASC, SORT_NUMERIC, $arrSyoyouKeikakus);
								}

				$daystart = $date1." 08:00:00";
				$dayfin = $datenext1." 07:59:59";

				$KadouSeikeis = $this->KadouSeikeis->find()//生産数呼び出し
				->where(['starting_tm >=' => $daystart, 'starting_tm <=' => $dayfin])
				->order(["starting_tm"=>"ASC"])->toArray();

					$arrSeisans = array();
					for($k=0; $k<count($KadouSeikeis); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $KadouSeikeis[$k]["product_code"], 'products.status' => 0, 'AND' => [['customer_code not like' => '1%'], ['customer_code not like' => '2%']]])//productsの絞込みother
						->toArray();//productsの絞込みother

						if(isset($Product[0])){

							$Katakouzous = $this->Katakouzous->find()->where(['product_code' => $KadouSeikeis[$k]["product_code"]])->toArray();

							$starting_tm = substr($KadouSeikeis[$k]['starting_tm'], 0, 10);
							$dateseikei = strtotime(substr($KadouSeikeis[$k]['starting_tm'], 10));

							if($dateseikei < strtotime(" 08:00:00")){
								$starting_tm = strtotime($starting_tm);
								$nippouday = date('Y/m/d', strtotime('-1 day', $starting_tm));
							}else{
								$nippouday = substr($KadouSeikeis[$k]['starting_tm'], 0, 10);
							}

							if(isset($Katakouzous[0])){
								$torisu = $Katakouzous[0]["torisu"];
							}else{
								$torisu = "Katakouzousテーブルに登録なし";
							}

							$arrSeisans[] = [
								'dateseikei' => $nippouday,
								'product_code' => $KadouSeikeis[$k]["product_code"],
								'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
								'torisu' => $torisu
						 ];

						}

					}

					//並べかえ
					$tmp_product_array2 = array();
					$tmp_dateseikei_array = array();
					foreach($arrSeisans as $key => $row ) {
						$tmp_product_array2[$key] = $row["product_code"];
						$tmp_dateseikei_array[$key] = $row["dateseikei"];
					}

					if(count($arrSeisans) > 0){
						array_multisort($tmp_product_array2, $tmp_dateseikei_array, SORT_ASC, SORT_NUMERIC, $arrSeisans);
					}

			}elseif($sheet === "p0"){

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'primary_p' => 0, 'customer_code' => '10001',
				'OR' => [['product_code like' => 'P0%']]])->toArray();

				$arrProductsmoto = array();
				for($k=0; $k<count($arrProducts); $k++){

					$riron_check = 0;
					$date16 = $yaermonth."-16";
					$RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $arrProducts[$k]["product_code"], 'date_culc' => $date16])->toArray();
					if(isset($RironStockProducts[0])){
						$riron_check = 1;
					}

					$arrProductsmoto[] = [
						'date_order' => "",
						'num_order' => "",
						'product_code' => $arrProducts[$k]["product_code"],
						'product_name' => $arrProducts[$k]["product_name"],
						'price' => "",
						'date_deliver' => "",
						'amount' => "",
						'denpyoumaisu' => "",
						'riron_zaiko_check' => $riron_check
				 ];

				}

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0, 'customer_code' => '10001',
				'OR' => [['product_code like' => 'P0%']]])//productsの絞込みp0
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
				$arrAssembleProducts = array();
				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $OrderEdis[$k]["product_code"], 'products.status' => 0, 'primary_p' => 0, 'customer_code' => '10001'])->toArray();//productsの絞込みp0

					if(isset($Product[0])){

						$product_name = $Product[0]->product_name;

						$riron_check = 0;
						$date16 = $yaermonth."-16";
						$RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'date_culc' => $date16])->toArray();
						if(isset($RironStockProducts[0])){
							$riron_check = 1;
						}

							$arrOrderEdis[] = [
								'date_order' => $OrderEdis[$k]["date_order"],
								'num_order' => $OrderEdis[$k]["num_order"],
								'product_code' => $OrderEdis[$k]["product_code"],
								'product_name' => $product_name,
								'price' => $OrderEdis[$k]["price"],
								'date_deliver' => $OrderEdis[$k]["date_deliver"],
								'amount' => $OrderEdis[$k]["amount"],
								'denpyoumaisu' => 1,
								'riron_zaiko_check' => $riron_check
						 ];

						 for($l=0; $l<count($arrProductsmoto); $l++){

							 if($arrProductsmoto[$l]["product_code"] === $OrderEdis[$k]["product_code"]){

								 unset($arrProductsmoto[$l]);
								 $arrProductsmoto = array_values($arrProductsmoto);

							 }

						}

						//組立品呼び出し
						$ResultZensuHeads = $this->ResultZensuHeads->find()
						->where(['product_code' => $OrderEdis[$k]["product_code"], 'datetime_finish >=' => $datestart." 00:00:00", 'datetime_finish <' => $dateend." 00:00:00"])
						->order(["datetime_finish"=>"DESC"])->toArray();

						if(isset($ResultZensuHeads[0])){//210107データ確認ok

								$AssembleProducts = $this->AssembleProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

								if(isset($AssembleProducts[0])){

									$diff = floor((strtotime($datenext1) - $date1st) / (60 * 60 * 24));

									for($l=0; $l<$diff; $l++){//それぞれの日付に対して

										$datetime_finish = strtotime("+$l day " . $date1);
			              $datetime_finish = date("Y-m-d", $datetime_finish);

										$Konpou = $this->Konpous->find()->where(['product_code' => $OrderEdis[$k]["product_code"]])->toArray();
										$irisu = $Konpou[0]->irisu;

										$ResultZensuHeadsday = $this->ResultZensuHeads->find()
										->where(['product_code' => $OrderEdis[$k]["product_code"], 'datetime_finish >=' => $datetime_finish." 00:00:00", 'datetime_finish <=' => $datetime_finish." 23:59:59"])
										->order(["datetime_finish"=>"DESC"])->toArray();

										if(isset($ResultZensuHeadsday[0])){

											$amount = $irisu * count($ResultZensuHeadsday);

											 $arrAssembleProducts[] = [
												 'product_code' => $OrderEdis[$k]["product_code"],
												 'kensabi' => $datetime_finish,
												 'amount' => $amount
											];

										}

									}

								}

							$arrAssembleProducts = array_unique($arrAssembleProducts, SORT_REGULAR);
							$arrAssembleProducts = array_values($arrAssembleProducts);

							$product_code = array();
							$kensabi = array();
							foreach ($arrAssembleProducts as $key => $value) {
  							 $product_code[$key] = $value['product_code'];
  							 $kensabi[$key] = $value["kensabi"];
  						 }

							 if(isset($kensabi)){
								 array_multisort($product_code, array_map( "strtotime", $kensabi ), SORT_ASC, SORT_NUMERIC, $arrAssembleProducts);
							 }

						}

					}

				}


				//同一のproduct_code、date_deliverの注文は一つにまとめ、amountとdenpyoumaisuを更新
				for($l=0; $l<count($arrOrderEdis); $l++){

					for($m=$l+1; $m<count($arrOrderEdis); $m++){

						if($arrOrderEdis[$l]["product_code"] == $arrOrderEdis[$m]["product_code"] && $arrOrderEdis[$l]["date_deliver"] == $arrOrderEdis[$m]["date_deliver"]){

							$amount = $arrOrderEdis[$l]["amount"] + $arrOrderEdis[$m]["amount"];
							$denpyoumaisu = $arrOrderEdis[$l]["denpyoumaisu"] + $arrOrderEdis[$m]["denpyoumaisu"];

							$arrOrderEdis[$l]["amount"] = $amount;
							$arrOrderEdis[$l]["denpyoumaisu"] = $denpyoumaisu;

							unset($arrOrderEdis[$m]);

						}

					}
					$arrOrderEdis = array_values($arrOrderEdis);

				}

				$arrOrderEdis = array_merge($arrOrderEdis, $arrProductsmoto);

				//並べかえ
				$tmp_product_array = array();
				$tmp_date_deliver_array = array();
				foreach($arrOrderEdis as $key => $row ) {
					$tmp_product_array[$key] = $row["product_code"];
					$tmp_date_deliver_array[$key] = $row["date_deliver"];
				}

				if(count($arrOrderEdis) > 0){
					array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_deliver_array ), SORT_ASC, SORT_NUMERIC, $arrOrderEdis);
				}

				$StockProducts = $this->StockProducts->find()//月末在庫呼び出し
				->where(['date_stock >=' => $dateback1, 'date_stock <=' => $datebacklast,
				'OR' => ['product_code like' => 'P0%']])//productsの絞込みp0
				->order(["date_stock"=>"ASC"])->toArray();

					$arrStockProducts = array();
					for($k=0; $k<count($StockProducts); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'primary_p' => 0, 'customer_code' => '10001'])->toArray();//productsの絞込みp0

						if(isset($Product[0])){

							$arrStockProducts[] = [
								'product_code' => $StockProducts[$k]["product_code"],
								'date_stock' => $StockProducts[$k]["date_stock"],
								'amount' => $StockProducts[$k]["amount"]
						 ];

						}

					}
					//並べかえ
					$tmp_product_array = array();
					$tmp_date_stock_array = array();
					foreach($arrStockProducts as $key => $row ) {
						$tmp_product_array[$key] = $row["product_code"];
						$tmp_date_stock_array[$key] = $row["date_stock"];
					}

					if(count($arrStockProducts) > 0){
						array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_stock_array ), SORT_ASC, SORT_NUMERIC, $arrStockProducts);
					}

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0,
				'OR' => ['product_code like' => 'P0%']])//productsの絞込みp0
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrSyoyouKeikakus = array();
				for($k=0; $k<count($SyoyouKeikakus); $k++){

					$Product = $this->Products->find()->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'status' => 0, 'primary_p' => 1])->toArray();//productsの絞込み　primary

					if(isset($Product[0])){

						$arrSyoyouKeikakus[] = [
							'product_code' => $SyoyouKeikakus[$k]["product_code"],
							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
							'amount' => $SyoyouKeikakus[$k]["amount"]
					 ];

					 //child_pidを追加
					 $AssembleProductcilds = $this->AssembleProducts->find()->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

					 if(isset($AssembleProductcilds[0])){

						 for($l=0; $l<count($AssembleProductcilds); $l++){

							 $arrSyoyouKeikakus[] = [
	 							'product_code' => $AssembleProductcilds[$l]->child_pid,
	 							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
	 							'amount' => $SyoyouKeikakus[$k]["amount"]
	 					 ];

						 }

					 }

					}

				}

				//並べかえ
								$tmp_product_array = array();
								$tmp_date_deliver_array = array();
								foreach($arrSyoyouKeikakus as $key => $row ) {
									$tmp_product_array[$key] = $row["product_code"];
									$tmp_date_deliver_array[$key] = $row["date_deliver"];
								}

								if(count($arrSyoyouKeikakus) > 0){
									array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_deliver_array ), SORT_ASC, SORT_NUMERIC, $arrSyoyouKeikakus);
								}

				$daystart = $date1." 08:00:00";
				$dayfin = $datenext1." 07:59:59";

				$KadouSeikeis = $this->KadouSeikeis->find()//生産数呼び出し
				->where(['starting_tm >=' => $daystart, 'starting_tm <=' => $dayfin,
				'OR' => ['product_code like' => 'P0%']])//productsの絞込みp0
				->order(["starting_tm"=>"ASC"])->toArray();

					$arrSeisans = array();
					for($k=0; $k<count($KadouSeikeis); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $KadouSeikeis[$k]["product_code"], 'products.status' => 0, 'primary_p' => 0, 'customer_code' => '10001'])->toArray();//productsの絞込みp0

						if(isset($Product[0])){

							$Katakouzous = $this->Katakouzous->find()->where(['product_code' => $KadouSeikeis[$k]["product_code"]])->toArray();

							$starting_tm = substr($KadouSeikeis[$k]['starting_tm'], 0, 10);
							$dateseikei = strtotime(substr($KadouSeikeis[$k]['starting_tm'], 10));

							if($dateseikei < strtotime(" 08:00:00")){
								$starting_tm = strtotime($starting_tm);
								$nippouday = date('Y/m/d', strtotime('-1 day', $starting_tm));
							}else{
								$nippouday = substr($KadouSeikeis[$k]['starting_tm'], 0, 10);
							}

							if(isset($Katakouzous[0])){
								$torisu = $Katakouzous[0]["torisu"];
							}else{
								$torisu = "Katakouzousテーブルに登録なし";
							}

							$arrSeisans[] = [
								'dateseikei' => $nippouday,
								'product_code' => $KadouSeikeis[$k]["product_code"],
								'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
								'torisu' => $torisu
						 ];

						}

					}

					//並べかえ
					$tmp_product_array2 = array();
					$tmp_dateseikei_array = array();
					foreach($arrSeisans as $key => $row ) {
						$tmp_product_array2[$key] = $row["product_code"];
						$tmp_dateseikei_array[$key] = $row["dateseikei"];
					}

					if(count($arrSeisans) > 0){
						array_multisort($tmp_product_array2, $tmp_dateseikei_array, SORT_ASC, SORT_NUMERIC, $arrSeisans);
					}

			}elseif($sheet === "p1"){

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'primary_p' => 0, 'customer_code' => '10001',
				'OR' => [['product_code like' => 'P1%'], ['product_code like' => 'P2%']]])->toArray();

				$arrProductsmoto = array();
				for($k=0; $k<count($arrProducts); $k++){

					$riron_check = 0;
					$date16 = $yaermonth."-16";
					$RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $arrProducts[$k]["product_code"], 'date_culc' => $date16])->toArray();
					if(isset($RironStockProducts[0])){
						$riron_check = 1;
					}

					$arrProductsmoto[] = [
						'date_order' => "",
						'num_order' => "",
						'product_code' => $arrProducts[$k]["product_code"],
						'product_name' => $arrProducts[$k]["product_name"],
						'price' => "",
						'date_deliver' => "",
						'amount' => "",
						'denpyoumaisu' => "",
						'riron_zaiko_check' => $riron_check
				 ];

				}

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0, 'customer_code' => '10001',
				'OR' => [['product_code like' => 'P1%'], ['product_code like' => 'P2%']]])//productsの絞込みp1
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
				$arrAssembleProducts = array();
				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $OrderEdis[$k]["product_code"], 'products.status' => 0, 'primary_p' => 0, 'customer_code' => '10001'])->toArray();//productsの絞込みp1

					if(isset($Product[0])){

						$product_name = $Product[0]->product_name;

						$riron_check = 0;
						$date16 = $yaermonth."-16";
						$RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'date_culc' => $date16])->toArray();
						if(isset($RironStockProducts[0])){
							$riron_check = 1;
						}

							$arrOrderEdis[] = [
								'date_order' => $OrderEdis[$k]["date_order"],
								'num_order' => $OrderEdis[$k]["num_order"],
								'product_code' => $OrderEdis[$k]["product_code"],
								'product_name' => $product_name,
								'price' => $OrderEdis[$k]["price"],
								'date_deliver' => $OrderEdis[$k]["date_deliver"],
								'amount' => $OrderEdis[$k]["amount"],
								'denpyoumaisu' => 1,
								'riron_zaiko_check' => $riron_check
						 ];

						 						 for($l=0; $l<count($arrProductsmoto); $l++){

						 							 if($arrProductsmoto[$l]["product_code"] === $OrderEdis[$k]["product_code"]){

						 								 unset($arrProductsmoto[$l]);
						 								 $arrProductsmoto = array_values($arrProductsmoto);

						 							 }

						 		 				}

												//組立品呼び出し
												$ResultZensuHeads = $this->ResultZensuHeads->find()
												->where(['product_code' => $OrderEdis[$k]["product_code"], 'datetime_finish >=' => $datestart." 00:00:00", 'datetime_finish <' => $dateend." 00:00:00"])
												->order(["datetime_finish"=>"DESC"])->toArray();

												if(isset($ResultZensuHeads[0])){//210107データ確認ok

														$AssembleProducts = $this->AssembleProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

														if(isset($AssembleProducts[0])){

															$diff = floor((strtotime($datenext1) - $date1st) / (60 * 60 * 24));

															for($l=0; $l<$diff; $l++){//それぞれの日付に対して

																$datetime_finish = strtotime("+$l day " . $date1);
									              $datetime_finish = date("Y-m-d", $datetime_finish);

																$Konpou = $this->Konpous->find()->where(['product_code' => $OrderEdis[$k]["product_code"]])->toArray();
																$irisu = $Konpou[0]->irisu;

																$ResultZensuHeadsday = $this->ResultZensuHeads->find()
																->where(['product_code' => $OrderEdis[$k]["product_code"], 'datetime_finish >=' => $datetime_finish." 00:00:00", 'datetime_finish <=' => $datetime_finish." 23:59:59"])
																->order(["datetime_finish"=>"DESC"])->toArray();

																if(isset($ResultZensuHeadsday[0])){

																	$amount = $irisu * count($ResultZensuHeadsday);

																	 $arrAssembleProducts[] = [
																		 'product_code' => $OrderEdis[$k]["product_code"],
																		 'kensabi' => $datetime_finish,
																		 'amount' => $amount
																	];

																}

															}

														}

													$arrAssembleProducts = array_unique($arrAssembleProducts, SORT_REGULAR);
													$arrAssembleProducts = array_values($arrAssembleProducts);

													$product_code = array();
													$kensabi = array();
													foreach ($arrAssembleProducts as $key => $value) {
						  							 $product_code[$key] = $value['product_code'];
						  							 $kensabi[$key] = $value["kensabi"];
						  						 }

													 if(isset($kensabi)){
														 array_multisort($product_code, array_map( "strtotime", $kensabi ), SORT_ASC, SORT_NUMERIC, $arrAssembleProducts);
													 }

												}

											}

										}


										//同一のproduct_code、date_deliverの注文は一つにまとめ、amountとdenpyoumaisuを更新
										for($l=0; $l<count($arrOrderEdis); $l++){

											for($m=$l+1; $m<count($arrOrderEdis); $m++){

												if($arrOrderEdis[$l]["product_code"] == $arrOrderEdis[$m]["product_code"] && $arrOrderEdis[$l]["date_deliver"] == $arrOrderEdis[$m]["date_deliver"]){

													$amount = $arrOrderEdis[$l]["amount"] + $arrOrderEdis[$m]["amount"];
													$denpyoumaisu = $arrOrderEdis[$l]["denpyoumaisu"] + $arrOrderEdis[$m]["denpyoumaisu"];

													$arrOrderEdis[$l]["amount"] = $amount;
													$arrOrderEdis[$l]["denpyoumaisu"] = $denpyoumaisu;

													unset($arrOrderEdis[$m]);

												}

											}
											$arrOrderEdis = array_values($arrOrderEdis);

										}

										$arrOrderEdis = array_merge($arrOrderEdis, $arrProductsmoto);

				//並べかえ
				$tmp_product_array = array();
				$tmp_date_deliver_array = array();
				foreach($arrOrderEdis as $key => $row ) {
					$tmp_product_array[$key] = $row["product_code"];
					$tmp_date_deliver_array[$key] = $row["date_deliver"];
				}

				if(count($arrOrderEdis) > 0){
					array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_deliver_array ), SORT_ASC, SORT_NUMERIC, $arrOrderEdis);
				}

				$StockProducts = $this->StockProducts->find()//月末在庫呼び出し
				->where(['date_stock >=' => $dateback1, 'date_stock <=' => $datebacklast,
				'OR' => [['product_code like' => 'P1%'], ['product_code like' => 'P2%']]])//productsの絞込みp1
				->order(["date_stock"=>"ASC"])->toArray();

					$arrStockProducts = array();
					for($k=0; $k<count($StockProducts); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'primary_p' => 0, 'customer_code' => '10001'])->toArray();//productsの絞込みp1

						if(isset($Product[0])){

							$arrStockProducts[] = [
								'product_code' => $StockProducts[$k]["product_code"],
								'date_stock' => $StockProducts[$k]["date_stock"],
								'amount' => $StockProducts[$k]["amount"]
						 ];

						}

					}
					//並べかえ
					$tmp_product_array = array();
					$tmp_date_stock_array = array();
					foreach($arrStockProducts as $key => $row ) {
						$tmp_product_array[$key] = $row["product_code"];
						$tmp_date_stock_array[$key] = $row["date_stock"];
					}

					if(count($arrStockProducts) > 0){
						array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_stock_array ), SORT_ASC, SORT_NUMERIC, $arrStockProducts);
					}

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0,
				'OR' => [['product_code like' => 'P1%'], ['product_code like' => 'P2%']]])//productsの絞込みp1
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrSyoyouKeikakus = array();
				for($k=0; $k<count($SyoyouKeikakus); $k++){

					$Product = $this->Products->find()->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'status' => 0, 'primary_p' => 1])->toArray();//productsの絞込み　primary

					if(isset($Product[0])){

						$arrSyoyouKeikakus[] = [
							'product_code' => $SyoyouKeikakus[$k]["product_code"],
							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
							'amount' => $SyoyouKeikakus[$k]["amount"]
					 ];

					 //child_pidを追加
					 $AssembleProductcilds = $this->AssembleProducts->find()->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

					 if(isset($AssembleProductcilds[0])){

						 for($l=0; $l<count($AssembleProductcilds); $l++){

							 $arrSyoyouKeikakus[] = [
	 							'product_code' => $AssembleProductcilds[$l]->child_pid,
	 							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
	 							'amount' => $SyoyouKeikakus[$k]["amount"]
	 					 ];

						 }

					 }

					}

				}

				//並べかえ
								$tmp_product_array = array();
								$tmp_date_deliver_array = array();
								foreach($arrSyoyouKeikakus as $key => $row ) {
									$tmp_product_array[$key] = $row["product_code"];
									$tmp_date_deliver_array[$key] = $row["date_deliver"];
								}

								if(count($arrSyoyouKeikakus) > 0){
									array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_deliver_array ), SORT_ASC, SORT_NUMERIC, $arrSyoyouKeikakus);
								}

				$daystart = $date1." 08:00:00";
				$dayfin = $datenext1." 07:59:59";

				$KadouSeikeis = $this->KadouSeikeis->find()//生産数呼び出し
				->where(['starting_tm >=' => $daystart, 'starting_tm <=' => $dayfin,
				'OR' => [['product_code like' => 'P1%'], ['product_code like' => 'P2%']]])//productsの絞込みp1
				->order(["starting_tm"=>"ASC"])->toArray();

					$arrSeisans = array();
					for($k=0; $k<count($KadouSeikeis); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $KadouSeikeis[$k]["product_code"], 'products.status' => 0, 'primary_p' => 0, 'customer_code' => '10001'])->toArray();//productsの絞込みp1

						if(isset($Product[0])){

							$Katakouzous = $this->Katakouzous->find()->where(['product_code' => $KadouSeikeis[$k]["product_code"]])->toArray();

							$starting_tm = substr($KadouSeikeis[$k]['starting_tm'], 0, 10);
							$dateseikei = strtotime(substr($KadouSeikeis[$k]['starting_tm'], 10));

							if($dateseikei < strtotime(" 08:00:00")){
								$starting_tm = strtotime($starting_tm);
								$nippouday = date('Y/m/d', strtotime('-1 day', $starting_tm));
							}else{
								$nippouday = substr($KadouSeikeis[$k]['starting_tm'], 0, 10);
							}

							if(isset($Katakouzous[0])){
								$torisu = $Katakouzous[0]["torisu"];
							}else{
								$torisu = "Katakouzousテーブルに登録なし";
							}

							$arrSeisans[] = [
								'dateseikei' => $nippouday,
								'product_code' => $KadouSeikeis[$k]["product_code"],
								'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
								'torisu' => $torisu
						 ];

						}

					}

					//並べかえ
					$tmp_product_array2 = array();
					$tmp_dateseikei_array = array();
					foreach($arrSeisans as $key => $row ) {
						$tmp_product_array2[$key] = $row["product_code"];
						$tmp_dateseikei_array[$key] = $row["dateseikei"];
					}

					if(count($arrSeisans) > 0){
						array_multisort($tmp_product_array2, $tmp_dateseikei_array, SORT_ASC, SORT_NUMERIC, $arrSeisans);
					}

			}elseif($sheet === "w"){

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'customer_code' => '10002', 'primary_p' => 0,
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])->toArray();

				$arrProductsmoto = array();
				for($k=0; $k<count($arrProducts); $k++){

					$riron_check = 0;
					$date16 = $yaermonth."-16";
					$RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $arrProducts[$k]["product_code"], 'date_culc' => $date16])->toArray();
					if(isset($RironStockProducts[0])){
						$riron_check = 1;
					}

					$arrProductsmoto[] = [
						'date_order' => "",
						'num_order' => "",
						'product_code' => $arrProducts[$k]["product_code"],
						'product_name' => $arrProducts[$k]["product_name"],
						'price' => "",
						'date_deliver' => "",
						'amount' => "",
						'denpyoumaisu' => "",
						'riron_zaiko_check' => $riron_check
				 ];

				}

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0, 'customer_code' => '10002',
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みw
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
				$arrAssembleProducts = array();
				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $OrderEdis[$k]["product_code"], 'products.status' => 0, 'primary_p' => 0, 'customer_code' => '10002'])->toArray();//productsの絞込みw

					if(isset($Product[0])){

						$product_name = $Product[0]->product_name;

						$riron_check = 0;
						$date16 = $yaermonth."-16";
						$RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'date_culc' => $date16])->toArray();
						if(isset($RironStockProducts[0])){
							$riron_check = 1;
						}

							$arrOrderEdis[] = [
								'date_order' => $OrderEdis[$k]["date_order"],
								'num_order' => $OrderEdis[$k]["num_order"],
								'product_code' => $OrderEdis[$k]["product_code"],
								'product_name' => $product_name,
								'price' => $OrderEdis[$k]["price"],
								'date_deliver' => $OrderEdis[$k]["date_deliver"],
								'amount' => $OrderEdis[$k]["amount"],
								'denpyoumaisu' => 1,
								'riron_zaiko_check' => $riron_check
						 ];

						 						 for($l=0; $l<count($arrProductsmoto); $l++){

						 							 if($arrProductsmoto[$l]["product_code"] === $OrderEdis[$k]["product_code"]){

						 								 unset($arrProductsmoto[$l]);
						 								 $arrProductsmoto = array_values($arrProductsmoto);

						 							 }

						 		 				}

												//組立品呼び出し
												$ResultZensuHeads = $this->ResultZensuHeads->find()
												->where(['product_code' => $OrderEdis[$k]["product_code"], 'datetime_finish >=' => $datestart." 00:00:00", 'datetime_finish <' => $dateend." 00:00:00"])
												->order(["datetime_finish"=>"DESC"])->toArray();

												if(isset($ResultZensuHeads[0])){//210107データ確認ok

														$AssembleProducts = $this->AssembleProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

														if(isset($AssembleProducts[0])){

															$diff = floor((strtotime($datenext1) - $date1st) / (60 * 60 * 24));

															for($l=0; $l<$diff; $l++){//それぞれの日付に対して

																$datetime_finish = strtotime("+$l day " . $date1);
									              $datetime_finish = date("Y-m-d", $datetime_finish);

																$Konpou = $this->Konpous->find()->where(['product_code' => $OrderEdis[$k]["product_code"]])->toArray();
																$irisu = $Konpou[0]->irisu;

																$ResultZensuHeadsday = $this->ResultZensuHeads->find()
																->where(['product_code' => $OrderEdis[$k]["product_code"], 'datetime_finish >=' => $datetime_finish." 00:00:00", 'datetime_finish <=' => $datetime_finish." 23:59:59"])
																->order(["datetime_finish"=>"DESC"])->toArray();

																if(isset($ResultZensuHeadsday[0])){

																	$amount = $irisu * count($ResultZensuHeadsday);

																	 $arrAssembleProducts[] = [
																		 'product_code' => $OrderEdis[$k]["product_code"],
																		 'kensabi' => $datetime_finish,
																		 'amount' => $amount
																	];

																}

															}

														}

													$arrAssembleProducts = array_unique($arrAssembleProducts, SORT_REGULAR);
													$arrAssembleProducts = array_values($arrAssembleProducts);

													$product_code = array();
													$kensabi = array();
													foreach ($arrAssembleProducts as $key => $value) {
						  							 $product_code[$key] = $value['product_code'];
						  							 $kensabi[$key] = $value["kensabi"];
						  						 }

													 if(isset($kensabi)){
														 array_multisort($product_code, array_map( "strtotime", $kensabi ), SORT_ASC, SORT_NUMERIC, $arrAssembleProducts);
													 }

												}

											}

										}


										//同一のproduct_code、date_deliverの注文は一つにまとめ、amountとdenpyoumaisuを更新
										for($l=0; $l<count($arrOrderEdis); $l++){

											for($m=$l+1; $m<count($arrOrderEdis); $m++){

												if($arrOrderEdis[$l]["product_code"] == $arrOrderEdis[$m]["product_code"] && $arrOrderEdis[$l]["date_deliver"] == $arrOrderEdis[$m]["date_deliver"]){

													$amount = $arrOrderEdis[$l]["amount"] + $arrOrderEdis[$m]["amount"];
													$denpyoumaisu = $arrOrderEdis[$l]["denpyoumaisu"] + $arrOrderEdis[$m]["denpyoumaisu"];

													$arrOrderEdis[$l]["amount"] = $amount;
													$arrOrderEdis[$l]["denpyoumaisu"] = $denpyoumaisu;

													unset($arrOrderEdis[$m]);

												}

											}
											$arrOrderEdis = array_values($arrOrderEdis);

										}

										$arrOrderEdis = array_merge($arrOrderEdis, $arrProductsmoto);

				//並べかえ
				$tmp_product_array = array();
				$tmp_date_deliver_array = array();
				foreach($arrOrderEdis as $key => $row ) {
					$tmp_product_array[$key] = $row["product_code"];
					$tmp_date_deliver_array[$key] = $row["date_deliver"];
				}

				if(count($arrOrderEdis) > 0){
					array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_deliver_array ), SORT_ASC, SORT_NUMERIC, $arrOrderEdis);
				}

				$StockProducts = $this->StockProducts->find()//月末在庫呼び出し
				->where(['date_stock >=' => $dateback1, 'date_stock <=' => $datebacklast,
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みw
				->order(["date_stock"=>"ASC"])->toArray();

					$arrStockProducts = array();
					for($k=0; $k<count($StockProducts); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'primary_p' => 0, 'customer_code' => '10002'])->toArray();//productsの絞込みw

						if(isset($Product[0])){

							$arrStockProducts[] = [
								'product_code' => $StockProducts[$k]["product_code"],
								'date_stock' => $StockProducts[$k]["date_stock"],
								'amount' => $StockProducts[$k]["amount"]
						 ];

						}

					}
					//並べかえ
					$tmp_product_array = array();
					$tmp_date_stock_array = array();
					foreach($arrStockProducts as $key => $row ) {
						$tmp_product_array[$key] = $row["product_code"];
						$tmp_date_stock_array[$key] = $row["date_stock"];
					}

					if(count($arrStockProducts) > 0){
						array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_stock_array ), SORT_ASC, SORT_NUMERIC, $arrStockProducts);
					}

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0,
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みw
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrSyoyouKeikakus = array();
				for($k=0; $k<count($SyoyouKeikakus); $k++){

					$Product = $this->Products->find()->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'status' => 0, 'primary_p' => 1])->toArray();//productsの絞込み　primary

					if(isset($Product[0])){

						$arrSyoyouKeikakus[] = [
							'product_code' => $SyoyouKeikakus[$k]["product_code"],
							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
							'amount' => $SyoyouKeikakus[$k]["amount"]
					 ];

					 //child_pidを追加
					 $AssembleProductcilds = $this->AssembleProducts->find()->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

					 if(isset($AssembleProductcilds[0])){

						 for($l=0; $l<count($AssembleProductcilds); $l++){

							 $arrSyoyouKeikakus[] = [
	 							'product_code' => $AssembleProductcilds[$l]->child_pid,
	 							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
	 							'amount' => $SyoyouKeikakus[$k]["amount"]
	 					 ];

						 }

					 }

					}

				}

				//並べかえ
								$tmp_product_array = array();
								$tmp_date_deliver_array = array();
								foreach($arrSyoyouKeikakus as $key => $row ) {
									$tmp_product_array[$key] = $row["product_code"];
									$tmp_date_deliver_array[$key] = $row["date_deliver"];
								}

								if(count($arrSyoyouKeikakus) > 0){
									array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_deliver_array ), SORT_ASC, SORT_NUMERIC, $arrSyoyouKeikakus);
								}

				$daystart = $date1." 08:00:00";
				$dayfin = $datenext1." 07:59:59";

				$KadouSeikeis = $this->KadouSeikeis->find()//生産数呼び出し
				->where(['starting_tm >=' => $daystart, 'starting_tm <=' => $dayfin,
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みw
				->order(["starting_tm"=>"ASC"])->toArray();

					$arrSeisans = array();
					for($k=0; $k<count($KadouSeikeis); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $KadouSeikeis[$k]["product_code"], 'products.status' => 0, 'primary_p' => 0, 'customer_code' => '10002'])->toArray();//productsの絞込みw

						if(isset($Product[0])){

							$Katakouzous = $this->Katakouzous->find()->where(['product_code' => $KadouSeikeis[$k]["product_code"]])->toArray();

							$starting_tm = substr($KadouSeikeis[$k]['starting_tm'], 0, 10);
							$dateseikei = strtotime(substr($KadouSeikeis[$k]['starting_tm'], 10));

							if($dateseikei < strtotime(" 08:00:00")){
								$starting_tm = strtotime($starting_tm);
								$nippouday = date('Y/m/d', strtotime('-1 day', $starting_tm));
							}else{
								$nippouday = substr($KadouSeikeis[$k]['starting_tm'], 0, 10);
							}

							if(isset($Katakouzous[0])){
								$torisu = $Katakouzous[0]["torisu"];
							}else{
								$torisu = "Katakouzousテーブルに登録なし";
							}

							$arrSeisans[] = [
								'dateseikei' => $nippouday,
								'product_code' => $KadouSeikeis[$k]["product_code"],
								'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
								'torisu' => $torisu
						 ];

						}

					}

					//並べかえ
					$tmp_product_array2 = array();
					$tmp_dateseikei_array = array();
					foreach($arrSeisans as $key => $row ) {
						$tmp_product_array2[$key] = $row["product_code"];
						$tmp_dateseikei_array[$key] = $row["dateseikei"];
					}

					if(count($arrSeisans) > 0){
						array_multisort($tmp_product_array2, $tmp_dateseikei_array, SORT_ASC, SORT_NUMERIC, $arrSeisans);
					}

			}elseif($sheet === "dnp"){

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'customer_code like' => '2%', 'primary_p' => 0
		//		'OR' => [['product_code like' => '2%']]
				])->toArray();

				$arrProductsmoto = array();
				for($k=0; $k<count($arrProducts); $k++){

					$riron_check = 0;
					$date16 = $yaermonth."-16";
					$RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $arrProducts[$k]["product_code"], 'date_culc' => $date16])->toArray();
					if(isset($RironStockProducts[0])){
						$riron_check = 1;
					}

					$arrProductsmoto[] = [
						'date_order' => "",
						'num_order' => "",
						'product_code' => $arrProducts[$k]["product_code"],
						'product_name' => $arrProducts[$k]["product_name"],
						'price' => "",
						'date_deliver' => "",
						'amount' => "",
						'denpyoumaisu' => "",
						'riron_zaiko_check' => $riron_check
				 ];

				}

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0,
				'OR' => [['customer_code like' => '2%']]])//productsの絞込みdnp
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
				$arrAssembleProducts = array();
				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $OrderEdis[$k]["product_code"], 'products.status' => 0, 'primary_p' => 0, 'customer_code like' => '2%'])->toArray();//productsの絞込みdnp

					if(isset($Product[0])){

						$product_name = $Product[0]->product_name;

						$riron_check = 0;
						$date16 = $yaermonth."-16";
						$RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'date_culc' => $date16])->toArray();
						if(isset($RironStockProducts[0])){
							$riron_check = 1;
						}

							$arrOrderEdis[] = [
								'date_order' => $OrderEdis[$k]["date_order"],
								'num_order' => $OrderEdis[$k]["num_order"],
								'product_code' => $OrderEdis[$k]["product_code"],
								'product_name' => $product_name,
								'price' => $OrderEdis[$k]["price"],
								'date_deliver' => $OrderEdis[$k]["date_deliver"],
								'amount' => $OrderEdis[$k]["amount"],
								'denpyoumaisu' => 1,
								'riron_zaiko_check' => $riron_check
						 ];

						 						 for($l=0; $l<count($arrProductsmoto); $l++){

						 							 if($arrProductsmoto[$l]["product_code"] === $OrderEdis[$k]["product_code"]){

						 								 unset($arrProductsmoto[$l]);
						 								 $arrProductsmoto = array_values($arrProductsmoto);

						 							 }

						 		 				}

												//組立品呼び出し
												$ResultZensuHeads = $this->ResultZensuHeads->find()
												->where(['product_code' => $OrderEdis[$k]["product_code"], 'datetime_finish >=' => $datestart." 00:00:00", 'datetime_finish <' => $dateend." 00:00:00"])
												->order(["datetime_finish"=>"DESC"])->toArray();

												if(isset($ResultZensuHeads[0])){//210107データ確認ok

														$AssembleProducts = $this->AssembleProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

														if(isset($AssembleProducts[0])){

															$diff = floor((strtotime($datenext1) - $date1st) / (60 * 60 * 24));

															for($l=0; $l<$diff; $l++){//それぞれの日付に対して

																$datetime_finish = strtotime("+$l day " . $date1);
									              $datetime_finish = date("Y-m-d", $datetime_finish);

																$Konpou = $this->Konpous->find()->where(['product_code' => $OrderEdis[$k]["product_code"]])->toArray();
																$irisu = $Konpou[0]->irisu;

																$ResultZensuHeadsday = $this->ResultZensuHeads->find()
																->where(['product_code' => $OrderEdis[$k]["product_code"], 'datetime_finish >=' => $datetime_finish." 00:00:00", 'datetime_finish <=' => $datetime_finish." 23:59:59"])
																->order(["datetime_finish"=>"DESC"])->toArray();

																if(isset($ResultZensuHeadsday[0])){

																	$amount = $irisu * count($ResultZensuHeadsday);

																	 $arrAssembleProducts[] = [
																		 'product_code' => $OrderEdis[$k]["product_code"],
																		 'kensabi' => $datetime_finish,
																		 'amount' => $amount
																	];

																}

															}

														}

													$arrAssembleProducts = array_unique($arrAssembleProducts, SORT_REGULAR);
													$arrAssembleProducts = array_values($arrAssembleProducts);

													$product_code = array();
													$kensabi = array();
													foreach ($arrAssembleProducts as $key => $value) {
						  							 $product_code[$key] = $value['product_code'];
						  							 $kensabi[$key] = $value["kensabi"];
						  						 }

													 if(isset($kensabi)){
														 array_multisort($product_code, array_map( "strtotime", $kensabi ), SORT_ASC, SORT_NUMERIC, $arrAssembleProducts);
													 }

												}

											}

										}


										//同一のproduct_code、date_deliverの注文は一つにまとめ、amountとdenpyoumaisuを更新
										for($l=0; $l<count($arrOrderEdis); $l++){

											for($m=$l+1; $m<count($arrOrderEdis); $m++){

												if($arrOrderEdis[$l]["product_code"] == $arrOrderEdis[$m]["product_code"] && $arrOrderEdis[$l]["date_deliver"] == $arrOrderEdis[$m]["date_deliver"]){

													$amount = $arrOrderEdis[$l]["amount"] + $arrOrderEdis[$m]["amount"];
													$denpyoumaisu = $arrOrderEdis[$l]["denpyoumaisu"] + $arrOrderEdis[$m]["denpyoumaisu"];

													$arrOrderEdis[$l]["amount"] = $amount;
													$arrOrderEdis[$l]["denpyoumaisu"] = $denpyoumaisu;

													unset($arrOrderEdis[$m]);

												}

											}
											$arrOrderEdis = array_values($arrOrderEdis);

										}

										$arrOrderEdis = array_merge($arrOrderEdis, $arrProductsmoto);

				//並べかえ
				$tmp_product_array = array();
				$tmp_date_deliver_array = array();
				foreach($arrOrderEdis as $key => $row ) {
					$tmp_product_array[$key] = $row["product_code"];
					$tmp_date_deliver_array[$key] = $row["date_deliver"];
				}

				if(count($arrOrderEdis) > 0){
					array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_deliver_array ), SORT_ASC, SORT_NUMERIC, $arrOrderEdis);
				}

				$StockProducts = $this->StockProducts->find()//月末在庫呼び出し
				->where(['date_stock >=' => $dateback1, 'date_stock <=' => $datebacklast])
				->order(["date_stock"=>"ASC"])->toArray();

					$arrStockProducts = array();
					for($k=0; $k<count($StockProducts); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'primary_p' => 0, 'customer_code like' => '2%'])->toArray();//productsの絞込みdnp

						if(isset($Product[0])){

							$arrStockProducts[] = [
								'product_code' => $StockProducts[$k]["product_code"],
								'date_stock' => $StockProducts[$k]["date_stock"],
								'amount' => $StockProducts[$k]["amount"]
						 ];

						}

					}
					//並べかえ
					$tmp_product_array = array();
					$tmp_date_stock_array = array();
					foreach($arrStockProducts as $key => $row ) {
						$tmp_product_array[$key] = $row["product_code"];
						$tmp_date_stock_array[$key] = $row["date_stock"];
					}

					if(count($arrStockProducts) > 0){
						array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_stock_array ), SORT_ASC, SORT_NUMERIC, $arrStockProducts);
					}

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0])
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrSyoyouKeikakus = array();
				for($k=0; $k<count($SyoyouKeikakus); $k++){

					$Product = $this->Products->find()->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'status' => 0, 'primary_p' => 1])->toArray();//productsの絞込み　primary

					if(isset($Product[0])){

						$arrSyoyouKeikakus[] = [
							'product_code' => $SyoyouKeikakus[$k]["product_code"],
							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
							'amount' => $SyoyouKeikakus[$k]["amount"]
					 ];

					 //child_pidを追加
					 $AssembleProductcilds = $this->AssembleProducts->find()->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

					 if(isset($AssembleProductcilds[0])){

						 for($l=0; $l<count($AssembleProductcilds); $l++){

							 $arrSyoyouKeikakus[] = [
	 							'product_code' => $AssembleProductcilds[$l]->child_pid,
	 							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
	 							'amount' => $SyoyouKeikakus[$k]["amount"]
	 					 ];

						 }

					 }

					}

				}

				//並べかえ
								$tmp_product_array = array();
								$tmp_date_deliver_array = array();
								foreach($arrSyoyouKeikakus as $key => $row ) {
									$tmp_product_array[$key] = $row["product_code"];
									$tmp_date_deliver_array[$key] = $row["date_deliver"];
								}

								if(count($arrSyoyouKeikakus) > 0){
									array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_deliver_array ), SORT_ASC, SORT_NUMERIC, $arrSyoyouKeikakus);
								}

				$daystart = $date1." 08:00:00";
				$dayfin = $datenext1." 07:59:59";

				$KadouSeikeis = $this->KadouSeikeis->find()//生産数呼び出し
				->where(['starting_tm >=' => $daystart, 'starting_tm <=' => $dayfin])
				->order(["starting_tm"=>"ASC"])->toArray();

					$arrSeisans = array();
					for($k=0; $k<count($KadouSeikeis); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $KadouSeikeis[$k]["product_code"], 'products.status' => 0, 'primary_p' => 0, 'customer_code like' => '2%'])->toArray();//productsの絞込みdnp

						if(isset($Product[0])){

							$Katakouzous = $this->Katakouzous->find()->where(['product_code' => $KadouSeikeis[$k]["product_code"]])->toArray();

							$starting_tm = substr($KadouSeikeis[$k]['starting_tm'], 0, 10);
							$dateseikei = strtotime(substr($KadouSeikeis[$k]['starting_tm'], 10));

							if($dateseikei < strtotime(" 08:00:00")){
								$starting_tm = strtotime($starting_tm);
								$nippouday = date('Y/m/d', strtotime('-1 day', $starting_tm));
							}else{
								$nippouday = substr($KadouSeikeis[$k]['starting_tm'], 0, 10);
							}

							if(isset($Katakouzous[0])){
								$torisu = $Katakouzous[0]["torisu"];
							}else{
								$torisu = "Katakouzousテーブルに登録なし";
							}

							$arrSeisans[] = [
								'dateseikei' => $nippouday,
								'product_code' => $KadouSeikeis[$k]["product_code"],
								'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
								'torisu' => $torisu
						 ];

						}

					}

					//並べかえ
					$tmp_product_array2 = array();
					$tmp_dateseikei_array = array();
					foreach($arrSeisans as $key => $row ) {
						$tmp_product_array2[$key] = $row["product_code"];
						$tmp_dateseikei_array[$key] = $row["dateseikei"];
					}

					if(count($arrSeisans) > 0){
						array_multisort($tmp_product_array2, $tmp_dateseikei_array, SORT_ASC, SORT_NUMERIC, $arrSeisans);
					}

			}elseif($sheet === "sinsei"){

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0,  'primary_p' => 0,
				'OR' => [['product_code like' => 'W0602%'], ['product_code like' => 'P160K%'], ['product_code like' => 'P12%']]])->toArray();

				$arrProductsmoto = array();
				for($k=0; $k<count($arrProducts); $k++){

					$riron_check = 0;
					$date16 = $yaermonth."-16";
					$RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $arrProducts[$k]["product_code"], 'date_culc' => $date16])->toArray();
					if(isset($RironStockProducts[0])){
						$riron_check = 1;
					}

					$arrProductsmoto[] = [
						'date_order' => "",
						'num_order' => "",
						'product_code' => $arrProducts[$k]["product_code"],
						'product_name' => $arrProducts[$k]["product_name"],
						'price' => "",
						'date_deliver' => "",
						'amount' => "",
						'denpyoumaisu' => "",
						'riron_zaiko_check' => $riron_check
				 ];

				}

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0,
				'OR' => [['product_code like' => 'W0602%'], ['product_code like' => 'P160K%'], ['product_code like' => 'P12%']]])//productsの絞込みsinsei
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
				$arrAssembleProducts = array();
				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'status' => 0, 'primary_p' => 0])->toArray();//productsの絞込みsinsei

					if(isset($Product[0])){

						//			$product_name = mb_convert_encoding($Product[0]->product_name, 'SJIS-win', 'UTF-8');//UTF-8の文字列をSJIS-winに変更する
						$product_name = $Product[0]->product_name;

						$riron_check = 0;
						$date16 = $yaermonth."-16";
						$RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'date_culc' => $date16])->toArray();
						if(isset($RironStockProducts[0])){
							$riron_check = 1;
						}

							$arrOrderEdis[] = [
								'date_order' => $OrderEdis[$k]["date_order"],
								'num_order' => $OrderEdis[$k]["num_order"],
								'product_code' => $OrderEdis[$k]["product_code"],
								'product_name' => $product_name,
								'price' => $OrderEdis[$k]["price"],
								'date_deliver' => $OrderEdis[$k]["date_deliver"],
								'amount' => $OrderEdis[$k]["amount"],
								'denpyoumaisu' => 1,
								'riron_zaiko_check' => $riron_check
						 ];

						 for($l=0; $l<count($arrProductsmoto); $l++){

							 if($arrProductsmoto[$l]["product_code"] === $OrderEdis[$k]["product_code"]){

								 unset($arrProductsmoto[$l]);
								 $arrProductsmoto = array_values($arrProductsmoto);

							 }

						}

						//組立品呼び出し
						$ResultZensuHeads = $this->ResultZensuHeads->find()
						->where(['product_code' => $OrderEdis[$k]["product_code"], 'datetime_finish >=' => $datestart." 00:00:00", 'datetime_finish <' => $dateend." 00:00:00"])
						->order(["datetime_finish"=>"DESC"])->toArray();

						if(isset($ResultZensuHeads[0])){//210107データ確認ok

								$AssembleProducts = $this->AssembleProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

								if(isset($AssembleProducts[0])){

									$diff = floor((strtotime($datenext1) - $date1st) / (60 * 60 * 24));

									for($l=0; $l<$diff; $l++){//それぞれの日付に対して

										$datetime_finish = strtotime("+$l day " . $date1);
			              $datetime_finish = date("Y-m-d", $datetime_finish);

										$Konpou = $this->Konpous->find()->where(['product_code' => $OrderEdis[$k]["product_code"]])->toArray();
										$irisu = $Konpou[0]->irisu;

										$ResultZensuHeadsday = $this->ResultZensuHeads->find()
										->where(['product_code' => $OrderEdis[$k]["product_code"], 'datetime_finish >=' => $datetime_finish." 00:00:00", 'datetime_finish <=' => $datetime_finish." 23:59:59"])
										->order(["datetime_finish"=>"DESC"])->toArray();

										if(isset($ResultZensuHeadsday[0])){

											$amount = $irisu * count($ResultZensuHeadsday);

											 $arrAssembleProducts[] = [
												 'product_code' => $OrderEdis[$k]["product_code"],
												 'kensabi' => $datetime_finish,
												 'amount' => $amount
											];

										}

									}

								}

							$arrAssembleProducts = array_unique($arrAssembleProducts, SORT_REGULAR);
							$arrAssembleProducts = array_values($arrAssembleProducts);

							$product_code = array();
							$kensabi = array();
							foreach ($arrAssembleProducts as $key => $value) {
  							 $product_code[$key] = $value['product_code'];
  							 $kensabi[$key] = $value["kensabi"];
  						 }

							 if(isset($kensabi)){
								 array_multisort($product_code, array_map( "strtotime", $kensabi ), SORT_ASC, SORT_NUMERIC, $arrAssembleProducts);
							 }

						}

					}

				}


				//同一のproduct_code、date_deliverの注文は一つにまとめ、amountとdenpyoumaisuを更新
				for($l=0; $l<count($arrOrderEdis); $l++){

					for($m=$l+1; $m<count($arrOrderEdis); $m++){

						if($arrOrderEdis[$l]["product_code"] == $arrOrderEdis[$m]["product_code"] && $arrOrderEdis[$l]["date_deliver"] == $arrOrderEdis[$m]["date_deliver"]){

							$amount = $arrOrderEdis[$l]["amount"] + $arrOrderEdis[$m]["amount"];
							$denpyoumaisu = $arrOrderEdis[$l]["denpyoumaisu"] + $arrOrderEdis[$m]["denpyoumaisu"];

							$arrOrderEdis[$l]["amount"] = $amount;
							$arrOrderEdis[$l]["denpyoumaisu"] = $denpyoumaisu;

							unset($arrOrderEdis[$m]);

						}

					}
					$arrOrderEdis = array_values($arrOrderEdis);

				}

				$arrOrderEdis = array_merge($arrOrderEdis, $arrProductsmoto);

				//並べかえ
				$tmp_product_array = array();
				$tmp_date_deliver_array = array();
				foreach($arrOrderEdis as $key => $row ) {
					$tmp_product_array[$key] = $row["product_code"];
					$tmp_date_deliver_array[$key] = $row["date_deliver"];
				}

				if(count($arrOrderEdis) > 0){
					array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_deliver_array ), SORT_ASC, SORT_NUMERIC, $arrOrderEdis);
				}

				$StockProducts = $this->StockProducts->find()//月末在庫呼び出し
				->where(['date_stock >=' => $dateback1, 'date_stock <=' => $datebacklast,
				'OR' => [['product_code like' => 'W0602%'], ['product_code like' => 'P160K%'], ['product_code like' => 'P12%']]])//productsの絞込みsinsei
				->order(["date_stock"=>"ASC"])->toArray();

					$arrStockProducts = array();
					for($k=0; $k<count($StockProducts); $k++){

						$Product = $this->Products->find()->where(['product_code' => $StockProducts[$k]["product_code"], 'status' => 0, 'primary_p' => 0])->toArray();//productsの絞込みsinsei

						if(isset($Product[0])){

							$arrStockProducts[] = [
								'product_code' => $StockProducts[$k]["product_code"],
								'date_stock' => $StockProducts[$k]["date_stock"],
								'amount' => $StockProducts[$k]["amount"]
						 ];

						}

					}

					//並べかえ
					$tmp_product_array = array();
					$tmp_date_stock_array = array();
					foreach($arrStockProducts as $key => $row ) {
						$tmp_product_array[$key] = $row["product_code"];
						$tmp_date_stock_array[$key] = $row["date_stock"];
					}

					if(count($arrStockProducts) > 0){
						array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_stock_array ), SORT_ASC, SORT_NUMERIC, $arrStockProducts);
					}

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0,
				'OR' => [['product_code like' => 'W0602%'], ['product_code like' => 'P160K%'], ['product_code like' => 'P12%']]])//productsの絞込みsinsei
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrSyoyouKeikakus = array();
				for($k=0; $k<count($SyoyouKeikakus); $k++){

					$Product = $this->Products->find()->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'status' => 0, 'primary_p' => 1])->toArray();//productsの絞込み　primary

					if(isset($Product[0])){

						$arrSyoyouKeikakus[] = [
							'product_code' => $SyoyouKeikakus[$k]["product_code"],
							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
							'amount' => $SyoyouKeikakus[$k]["amount"]
					 ];

					 //child_pidを追加
					 $AssembleProductcilds = $this->AssembleProducts->find()->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

					 if(isset($AssembleProductcilds[0])){

						 for($l=0; $l<count($AssembleProductcilds); $l++){

							 $arrSyoyouKeikakus[] = [
	 							'product_code' => $AssembleProductcilds[$l]->child_pid,
	 							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
	 							'amount' => $SyoyouKeikakus[$k]["amount"]
	 					 ];

						 }

					 }

					}

				}

				//並べかえ
				$tmp_product_array = array();
				$tmp_date_deliver_array = array();
				foreach($arrSyoyouKeikakus as $key => $row ) {
					$tmp_product_array[$key] = $row["product_code"];
					$tmp_date_deliver_array[$key] = $row["date_deliver"];
				}

				if(count($arrSyoyouKeikakus) > 0){
					array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_deliver_array ), SORT_ASC, SORT_NUMERIC, $arrSyoyouKeikakus);
				}

				$daystart = $date1." 08:00:00";
				$dayfin = $datenext1." 07:59:59";

				$KadouSeikeis = $this->KadouSeikeis->find()//生産数呼び出し
				->where(['starting_tm >=' => $daystart, 'starting_tm <=' => $dayfin,
				'OR' => [['product_code like' => 'W0602%'], ['product_code like' => 'P160K%'], ['product_code like' => 'P12%']]])//productsの絞込みsinsei
				->order(["starting_tm"=>"ASC"])->toArray();

					$arrSeisans = array();
					for($k=0; $k<count($KadouSeikeis); $k++){

						$Product = $this->Products->find()->where(['product_code' => $KadouSeikeis[$k]["product_code"], 'status' => 0, 'primary_p' => 0])->toArray();//productsの絞込みsinsei

						if(isset($Product[0])){

							$Katakouzous = $this->Katakouzous->find()->where(['product_code' => $KadouSeikeis[$k]["product_code"]])->toArray();

							$starting_tm = substr($KadouSeikeis[$k]['starting_tm'], 0, 10);
							$dateseikei = strtotime(substr($KadouSeikeis[$k]['starting_tm'], 10));

							if($dateseikei < strtotime(" 08:00:00")){
								$starting_tm = strtotime($starting_tm);
								$nippouday = date('Y/m/d', strtotime('-1 day', $starting_tm));
							}else{
								$nippouday = substr($KadouSeikeis[$k]['starting_tm'], 0, 10);
							}

							if(isset($Katakouzous[0])){
								$torisu = $Katakouzous[0]["torisu"];
							}else{
								$torisu = "Katakouzousテーブルに登録なし";
							}

							$arrSeisans[] = [
								'dateseikei' => $nippouday,
								'product_code' => $KadouSeikeis[$k]["product_code"],
								'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
								'torisu' => $torisu
						 ];

						}

					}

					//並べかえ
					$tmp_product_array2 = array();
					$tmp_dateseikei_array = array();
					foreach($arrSeisans as $key => $row ) {
						$tmp_product_array2[$key] = $row["product_code"];
						$tmp_dateseikei_array[$key] = $row["dateseikei"];
					}

					if(count($arrSeisans) > 0){
						array_multisort($tmp_product_array2, $tmp_dateseikei_array, SORT_ASC, SORT_NUMERIC, $arrSeisans);
					}

			}else{

				echo "<pre>";
				print_r("エラーです。URLを確認してください。");
				echo "</pre>";

				$arrOrderEdis = array();
				$arrStockProducts = array();
				$arrAssembleProducts = array();
				$arrSyoyouKeikakus = array();
				$arrSeisans = array();

			}

			$this->set([
				'OrderEdis' => $arrOrderEdis,
				'StockProducts' => $arrStockProducts,
				'AssembleProducts' => $arrAssembleProducts,
				'SyoyouKeikakus' => $arrSyoyouKeikakus,
				'Seisans' => $arrSeisans,
				'_serialize' => ['OrderEdis', 'StockProducts', 'AssembleProducts', 'SyoyouKeikakus', 'Seisans']
			]);

		}

	}
