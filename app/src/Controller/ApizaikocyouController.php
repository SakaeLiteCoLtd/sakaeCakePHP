<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

use App\myClass\Apifind\htmlApifind;//myClassフォルダに配置したクラスを使用
use App\myClass\Apizaiko\apizaikoprogram;//myClassフォルダに配置したクラスを使用

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
		 $this->LabelSetikkatsues = TableRegistry::get('labelSetikkatsues');
		 $this->StockInoutWorklogs = TableRegistry::get('stockInoutWorklogs');
		 $this->NonKadouSeikeis = TableRegistry::get('nonKadouSeikeis');
		}

//http://192.168.4.246/Apizaikocyou/zaikocyou/api/2021-1-16_primary.xml
//http://localhost:5000/Apizaikocyou/zaikocyou/api/2021-1-16_primary.xml
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

			$datestart = $dayarr[0];
			$datestartstr = strtotime($datestart);
			$dateend = date('Y-m-d', strtotime('+31 day', $datestartstr));
			$dateendnext = date('Y-m-d', strtotime('+32 day', $datestartstr));//kodouseikeisで使用
			$date16 = $yaermonth."-16";

			$todaySyoyouKeikakus = date('Y-m-d');
			$this->SyoyouKeikakus->deleteAll(['date_deliver <' => $todaySyoyouKeikakus]);//当日の前日までの所要計画のデータは削除する

			//http://192.168.4.246/Apizaikocyou/zaikocyou/api/2020-12-3_primary.xml
			//http://localhost:5000/Apizaikocyou/zaikocyou/api/2020-12-13_primary.xml
			if($sheet === "primary"){

//$arrProductsmotoスタート

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'primary_p' => 1,
				'OR' => [['product_code like' => 'P%'], ['product_code like' => 'AR%']]])//productsの絞込み　primary
				->toArray();

				if(!isset($_SESSION)){
				session_start();
				}
				$_SESSION['zaikoarrProductstarget'] = array();
				$_SESSION['zaikoarrProductstarget'] = $arrProducts;//クラスで使用するためセッションとして定義する

				$apizaikoprogram = new apizaikoprogram();
				$arrProductsmoto = $apizaikoprogram->classProductsmototarget($date16);

				$session = $this->request->getSession();
				$session->delete('zaikoarrProductstarget');//指定のセッションを削除

//$arrProductsmoto完成
//$arrResultZensuHeadsmotoスタート

				$date1_datenext1 = $datestart."_".$dateend;
				$apizaikoprogram = new apizaikoprogram();
				$arrResultZensuHeadsmoto = $apizaikoprogram->classResultZensuHeads($date1_datenext1);//ResultZensuHeadsからデータを取得

//$arrResultZensuHeadsmoto完成
//$arrAssembleProductsスタート

for($l=0; $l<count($arrResultZensuHeadsmoto); $l++){//arrResultZensuHeadsmotoに対して

	$AssembleProducts = $this->AssembleProducts->find()->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

	if(isset($AssembleProducts[0])){//AssembleProductsが存在する場合//組立品の場合

		$OrderEdisAssemble = $this->OrderEdis->find()//primaryに該当する、かつ'product_code' => $arrResultZensuHeadsmoto[$l]["product_code"]であるOrderEdis呼び出し
		->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'delete_flag' => 0,
		'OR' => [['product_code like' => 'P%'], ['product_code like' => 'AR%']]])
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

//$arrAssembleProducts完成
//$arrOrderEdisスタート

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

		          $arrOrderEdis[] = [
		            'date_order' => $OrderEdis[$k]["date_order"],
		            'num_order' => $OrderEdis[$k]["num_order"],
		            'product_code' => $OrderEdis[$k]["product_code"],
		            'product_name' => $product_name,
		            'price' => $OrderEdis[$k]["price"],
		            'date_deliver' => $OrderEdis[$k]["date_deliver"],
		            'amount' => $OrderEdis[$k]["amount"],
		            'denpyoumaisu' => 1
		         ];

		         for($l=0; $l<count($arrProductsmoto); $l++){

		           if($arrProductsmoto[$l]["product_code"] === $OrderEdis[$k]["product_code"]){

		             unset($arrProductsmoto[$l]);
		             $arrProductsmoto = array_values($arrProductsmoto);

		           }

		        }

		      }

		    }

				if(!isset($_SESSION)){
				session_start();
				}
				$_SESSION['classarrProductsmoto'] = array();
				$_SESSION['classarrProductsmoto'] = $arrProductsmoto;
				$_SESSION['classOrderEdis'] = array();
				$_SESSION['classOrderEdis'] = $OrderEdis;
				$_SESSION['classarrOrderEdis'] = array();
				$_SESSION['classarrOrderEdis'] = $arrOrderEdis;

				//OrderEdisクラス使用
				$htmlApifind = new htmlApifind();//クラスを使用
				$arrOrderEdis = $htmlApifind->OrderEdis($date16);//クラスを使用

//$arrOrderEdis完成
//$StockProductsスタート

				$StockProducts = $this->RironStockProducts->find()//月末在庫呼び出し
				->where(['date_culc >=' => $day, 'date_culc <=' => $day,
				'OR' => [['product_code like' => 'P%'], ['product_code like' => 'AR%']]])//productsの絞込み　primary
				->order(["date_culc"=>"ASC"])->toArray();

					$arrStockProducts = array();
					for($k=0; $k<count($StockProducts); $k++){

						$Product = $this->Products->find()->where(['product_code' => $StockProducts[$k]["product_code"], 'status' => 0, 'primary_p' => 1])->toArray();//productsの絞込み　primary

						if(isset($Product[0])){

							if(!isset($StockProducts[$k]["date_culc"])){
								$StockProducts[$k]["date_culc"] = $StockProducts[$k]["date_stock"];
							}

							$arrStockProducts[] = [
								'product_code' => $StockProducts[$k]["product_code"],
								'date_stock' => $StockProducts[$k]["date_culc"],
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

//$StockProducts完成
//$SyoyouKeikakusスタート

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0,
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

//$SyoyouKeikakus完成
//$arrSeisansスタート

				$daystart = $datestart." 08:00:00";
				$dayfin = $dateendnext." 07:59:59";

				$KadouSeikeis = $this->KadouSeikeis->find()//生産数呼び出し
				->where(['starting_tm >=' => $daystart, 'starting_tm <=' => $dayfin,
				'OR' => [['product_code like' => 'P%'], ['product_code like' => 'AR%']]])//productsの絞込み　primary
//						'OR' => [['product_code like' => 'P%']]])//productsの絞込み　primary
				->order(["starting_tm"=>"ASC"])->toArray();

					$arrSeisans = array();
					for($k=0; $k<count($KadouSeikeis); $k++){

						$Product = $this->Products->find()->where(['product_code' => $KadouSeikeis[$k]["product_code"], 'status' => 0, 'primary_p' => 1])->toArray();//productsの絞込み　primary

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

						 $LabelSetikkatsu1 = $this->LabelSetikkatsues->find()->where(['product_id1' => $KadouSeikeis[$k]['product_code'], 'kind_set_assemble' => 0])->toArray();
	           $LabelSetikkatsu2 = $this->LabelSetikkatsues->find()->where(['product_id2' => $KadouSeikeis[$k]['product_code'], 'kind_set_assemble' => 0])->toArray();

						 if(isset($LabelSetikkatsu1[0])){

							 $arrSeisans[] = [
 								'dateseikei' => $nippouday,
 								'product_code' => $LabelSetikkatsu1[0]["product_id2"],
 								'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
 								'torisu' => $torisu
 						 ];

						 }elseif(isset($LabelSetikkatsu2[0])){

							 $arrSeisans[] = [
 								'dateseikei' => $nippouday,
 								'product_code' => $LabelSetikkatsu2[0]["product_id1"],
 								'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
 								'torisu' => $torisu
 						 ];

						 }

						}

					}

					$StockInoutWorklogs = $this->StockInoutWorklogs->find()//仕入れ数の呼出
					->where(['date_work >=' => $datestart, 'date_work <=' => $dateendnext, 'outsource_code !=' => 22,
					'OR' => [['product_code like' => 'P%'], ['product_code like' => 'AR%']]])//productsの絞込み　primary
//						'OR' => [['product_code like' => 'P%']]])//productsの絞込み　primary
					->order(["date_work"=>"ASC"])->toArray();
					for($k=0; $k<count($StockInoutWorklogs); $k++){

						$Product = $this->Products->find()->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'status' => 0, 'primary_p' => 1])->toArray();//productsの絞込み　primary

						$NonKadouSeikeis = $this->NonKadouSeikeis->find()->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'outsource_handy_id' => $StockInoutWorklogs[$k]["outsource_code"], 'status' => 0, 'delete_flag' => 0])->toArray();

						if(isset($Product[0]) && !isset($NonKadouSeikeis[0])){

							$arrSeisans[] = [
								'dateseikei' => $StockInoutWorklogs[$k]["date_work"]->format('Y/m/d'),
								'product_code' => $StockInoutWorklogs[$k]["product_code"],
								'amount_shot' => $StockInoutWorklogs[$k]["amount"],
								'torisu' => 1
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

//$arrSeisans完成

			}elseif($sheet === "primary_dnp"){

				//$arrProductsmotoスタート

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'primary_p' => 1,
				'OR' => [['customer_code like' => '2%']]])->toArray();

				if(!isset($_SESSION)){
				session_start();
				}
				$_SESSION['classarrProducts'] = array();
				$_SESSION['classarrProducts'] = $arrProducts;

				//OrderEdisクラス使用
				$htmlApifind = new htmlApifind();//クラスを使用
				$arrProductsmoto = $htmlApifind->Productsmoto($date16);//クラスを使用

				//$arrProductsmoto完成

				//$arrResultZensuHeadsmotoスタート

				$_SESSION['classarrdatestart'] = array();
				$_SESSION['classarrdatestart'] = $datestart;

				$htmlApifind = new htmlApifind();//クラスを使用
				$arrResultZensuHeadsmoto = $htmlApifind->ResultZensuHeadsmoto($dateend);//クラスを使用

				//$arrResultZensuHeadsmoto完成

				//$arrAssembleProductsスタート

				$arrAssembleProducts = array();//ここから組立品
				for($l=0; $l<count($arrResultZensuHeadsmoto); $l++){

					$AssembleProducts = $this->AssembleProducts->find()->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

					if(isset($AssembleProducts[0])){//AssembleProductsが存在する場合//組立

						$OrderEdisAssemble = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
						->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'delete_flag' => 0,
						'OR' => [['customer_code like' => '2%']]])//productsの絞込みprimary_dnp
						->order(["date_deliver"=>"ASC"])->toArray();

						if(isset($OrderEdisAssemble[0])){

							$Konpou = $this->Konpous->find()->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"]])->toArray();
							$irisu = $Konpou[0]->irisu;//製品の入数を取得

							$amount = $irisu * $arrResultZensuHeadsmoto[$l]["count"];//入数をかけてamountを取得

							 $arrAssembleProducts[] = [//配列$arrAssembleProductsに追加
								 'product_code' => $arrResultZensuHeadsmoto[$l]["product_code"],
								 'kensabi' => $arrResultZensuHeadsmoto[$l]["datetime_finish"],
								 'amount' => $amount
							];

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

				//$arrAssembleProducts完成

				//$arrOrderEdisスタート

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0,
				'OR' => [['customer_code like' => '2%']]])//productsの絞込みprimary_dnp
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'status' => 0, 'primary_p' => 1])->toArray();//productsの絞込み　primary

					if(isset($Product[0])){

						$product_name = $Product[0]->product_name;

							$arrOrderEdis[] = [
								'date_order' => $OrderEdis[$k]["date_order"],
								'num_order' => $OrderEdis[$k]["num_order"],
								'product_code' => $OrderEdis[$k]["product_code"],
								'product_name' => $product_name,
								'price' => $OrderEdis[$k]["price"],
								'date_deliver' => $OrderEdis[$k]["date_deliver"],
								'amount' => $OrderEdis[$k]["amount"],
								'denpyoumaisu' => 1
						 ];

						 for($l=0; $l<count($arrProductsmoto); $l++){

							 if($arrProductsmoto[$l]["product_code"] === $OrderEdis[$k]["product_code"]){

								 unset($arrProductsmoto[$l]);
								 $arrProductsmoto = array_values($arrProductsmoto);

							 }

						}

					}

				}

				if(!isset($_SESSION)){
				session_start();
				}
				$_SESSION['classarrProductsmoto'] = array();
				$_SESSION['classarrProductsmoto'] = $arrProductsmoto;
				$_SESSION['classOrderEdis'] = array();
				$_SESSION['classOrderEdis'] = $OrderEdis;
				$_SESSION['classarrOrderEdis'] = array();
				$_SESSION['classarrOrderEdis'] = $arrOrderEdis;

				//OrderEdisクラス使用
				$htmlApifind = new htmlApifind();//クラスを使用
				$arrOrderEdis = $htmlApifind->OrderEdis($date16);//クラスを使用

				//$arrOrderEdis完成
				//$StockProductsスタート

				$StockProducts = $this->RironStockProducts->find()//月末在庫呼び出し
				->where(['date_culc >=' => $day, 'date_culc <=' => $day])
				//->where(['date_culc >=' => $day, 'date_culc <=' => $dateend,
				->order(["date_culc"=>"ASC"])->toArray();

				$arrStockProducts = array();
				for($k=0; $k<count($StockProducts); $k++){

		//			$Product = $this->Products->find()->where(['product_code' => $StockProducts[$k]["product_code"], 'status' => 0, 'primary_p' => 1])->toArray();//productsの絞込み　primary
					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'primary_p' => 1,
					'OR' => [['customer_code like' => '2%']]])->toArray();

					if(isset($Product[0])){

						if(!isset($StockProducts[$k]["date_culc"])){
							$StockProducts[$k]["date_culc"] = $StockProducts[$k]["date_stock"];
						}

						$arrStockProducts[] = [
							'product_code' => $StockProducts[$k]["product_code"],
							'date_stock' => $StockProducts[$k]["date_culc"],
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

				//$StockProducts完成

				//$SyoyouKeikakusスタート

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0])
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrSyoyouKeikakus = array();
				for($k=0; $k<count($SyoyouKeikakus); $k++){

			//		$Product = $this->Products->find()->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'status' => 0, 'primary_p' => 1])->toArray();//productsの絞込み　primary
					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'products.status' => 0, 'primary_p' => 1,
					'OR' => [['customer_code like' => '2%']]])->toArray();

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

				//$SyoyouKeikakus完成

				//$arrSeisansスタート

				$daystart = $datestart." 08:00:00";
				$dayfin = $dateend." 07:59:59";

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
						 $LabelSetikkatsu1 = $this->LabelSetikkatsues->find()->where(['product_id1' => $KadouSeikeis[$k]['product_code'], 'kind_set_assemble' => 0])->toArray();
						 $LabelSetikkatsu2 = $this->LabelSetikkatsues->find()->where(['product_id2' => $KadouSeikeis[$k]['product_code'], 'kind_set_assemble' => 0])->toArray();

						 if(isset($LabelSetikkatsu1[0])){

							 $arrSeisans[] = [
									'dateseikei' => $nippouday,
									'product_code' => $LabelSetikkatsu1[0]["product_id2"],
									'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
									'torisu' => $torisu
							 ];

						 }elseif(isset($LabelSetikkatsu2[0])){

							 $arrSeisans[] = [
									'dateseikei' => $nippouday,
									'product_code' => $LabelSetikkatsu2[0]["product_id1"],
									'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
									'torisu' => $torisu
							 ];

						 }

						}

					}

					$StockInoutWorklogs = $this->StockInoutWorklogs->find()//仕入れ数の呼出
					->where(['date_work >=' => $datestart, 'date_work <=' => $dateendnext, 'outsource_code !=' => 22])
					->order(["date_work"=>"ASC"])->toArray();

					for($k=0; $k<count($StockInoutWorklogs); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'products.status' => 0, 'primary_p' => 1, 'customer_code like' => '2%'])->toArray();//productsの絞込みprimary_dnp

						$NonKadouSeikeis = $this->NonKadouSeikeis->find()->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'outsource_handy_id' => $StockInoutWorklogs[$k]["outsource_code"], 'status' => 0, 'delete_flag' => 0])->toArray();

						if(isset($Product[0]) && !isset($NonKadouSeikeis[0])){

							$arrSeisans[] = [
								'dateseikei' => $StockInoutWorklogs[$k]["date_work"]->format('Y/m/d'),
								'product_code' => $StockInoutWorklogs[$k]["product_code"],
								'amount_shot' => $StockInoutWorklogs[$k]["amount"],
								'torisu' => 1
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

					//$arrSeisans完成

			}elseif($sheet === "primary_w"){

				//$arrProductsmotoスタート

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'primary_p' => 1, 'customer_code' => '10002',
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])->toArray();

				if(!isset($_SESSION)){
				session_start();
				}
				$_SESSION['classarrProducts'] = array();
				$_SESSION['classarrProducts'] = $arrProducts;

				//OrderEdisクラス使用
				$htmlApifind = new htmlApifind();//クラスを使用
				$arrProductsmoto = $htmlApifind->Productsmoto($date16);//クラスを使用

				//$arrProductsmoto完成

				//$arrResultZensuHeadsmotoスタート

				$_SESSION['classarrdatestart'] = array();
				$_SESSION['classarrdatestart'] = $datestart;

				$htmlApifind = new htmlApifind();//クラスを使用
				$arrResultZensuHeadsmoto = $htmlApifind->ResultZensuHeadsmoto($dateend);//クラスを使用

				//$arrResultZensuHeadsmoto完成

				//$arrAssembleProductsスタート

				$arrAssembleProducts = array();//ここから組立品
				for($l=0; $l<count($arrResultZensuHeadsmoto); $l++){

					$AssembleProducts = $this->AssembleProducts->find()->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

					if(isset($AssembleProducts[0])){//AssembleProductsが存在する場合//組立

						$OrderEdisAssemble = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
						->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0, 'customer_code' => '10002',
						'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みprimary_w
						->order(["date_deliver"=>"ASC"])->toArray();

						if(isset($OrderEdisAssemble[0])){

							$Konpou = $this->Konpous->find()->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"]])->toArray();
							$irisu = $Konpou[0]->irisu;//製品の入数を取得

							$amount = $irisu * $arrResultZensuHeadsmoto[$l]["count"];//入数をかけてamountを取得

							 $arrAssembleProducts[] = [//配列$arrAssembleProductsに追加
								 'product_code' => $arrResultZensuHeadsmoto[$l]["product_code"],
								 'kensabi' => $arrResultZensuHeadsmoto[$l]["datetime_finish"],
								 'amount' => $amount
							];

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

				//$arrAssembleProducts完成

				//$arrOrderEdisスタート

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0, 'customer_code' => '10002',
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みprimary_w
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'status' => 0, 'primary_p' => 1])->toArray();//productsの絞込み　primary

					if(isset($Product[0])){

						$product_name = $Product[0]->product_name;
	//					$riron_check = 0;

							$arrOrderEdis[] = [
								'date_order' => $OrderEdis[$k]["date_order"],
								'num_order' => $OrderEdis[$k]["num_order"],
								'product_code' => $OrderEdis[$k]["product_code"],
								'product_name' => $product_name,
								'price' => $OrderEdis[$k]["price"],
								'date_deliver' => $OrderEdis[$k]["date_deliver"],
								'amount' => $OrderEdis[$k]["amount"],
								'denpyoumaisu' => 1
		       //     'riron_zaiko_check' => $riron_check
						 ];

						 for($l=0; $l<count($arrProductsmoto); $l++){

							 if($arrProductsmoto[$l]["product_code"] === $OrderEdis[$k]["product_code"]){

								 unset($arrProductsmoto[$l]);
								 $arrProductsmoto = array_values($arrProductsmoto);

							 }

						}

					}

				}

				if(!isset($_SESSION)){
				session_start();
				}
				$_SESSION['classarrProductsmoto'] = array();
				$_SESSION['classarrProductsmoto'] = $arrProductsmoto;
				$_SESSION['classOrderEdis'] = array();
				$_SESSION['classOrderEdis'] = $OrderEdis;
				$_SESSION['classarrOrderEdis'] = array();
				$_SESSION['classarrOrderEdis'] = $arrOrderEdis;

				//OrderEdisクラス使用
				$htmlApifind = new htmlApifind();//クラスを使用
				$arrOrderEdis = $htmlApifind->OrderEdis($date16);//クラスを使用

				//$arrOrderEdis完成

				//$StockProductsスタート

				$StockProducts = $this->RironStockProducts->find()//月末在庫呼び出し
				->where(['date_culc >=' => $day, 'date_culc <=' => $day,
				//->where(['date_culc >=' => $day, 'date_culc <=' => $dateend,
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みprimary_w
				->order(["date_culc"=>"ASC"])->toArray();

				$arrStockProducts = array();
				for($k=0; $k<count($StockProducts); $k++){

					$Product = $this->Products->find()->where(['product_code' => $StockProducts[$k]["product_code"], 'status' => 0, 'primary_p' => 1])->toArray();//productsの絞込み　primary

					if(isset($Product[0])){

						if(!isset($StockProducts[$k]["date_culc"])){
							$StockProducts[$k]["date_culc"] = $StockProducts[$k]["date_stock"];
						}

						$arrStockProducts[] = [
							'product_code' => $StockProducts[$k]["product_code"],
							'date_stock' => $StockProducts[$k]["date_culc"],
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

				//$StockProducts完成

				//$SyoyouKeikakusスタート

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0,
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

				//$SyoyouKeikakus完成

				//$arrSeisansスタート

				$daystart = $datestart." 08:00:00";
				$dayfin = $dateend." 07:59:59";

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
						 $LabelSetikkatsu1 = $this->LabelSetikkatsues->find()->where(['product_id1' => $KadouSeikeis[$k]['product_code'], 'kind_set_assemble' => 0])->toArray();
						 $LabelSetikkatsu2 = $this->LabelSetikkatsues->find()->where(['product_id2' => $KadouSeikeis[$k]['product_code'], 'kind_set_assemble' => 0])->toArray();

						 if(isset($LabelSetikkatsu1[0])){

							 $arrSeisans[] = [
									'dateseikei' => $nippouday,
									'product_code' => $LabelSetikkatsu1[0]["product_id2"],
									'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
									'torisu' => $torisu
							 ];

						 }elseif(isset($LabelSetikkatsu2[0])){

							 $arrSeisans[] = [
									'dateseikei' => $nippouday,
									'product_code' => $LabelSetikkatsu2[0]["product_id1"],
									'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
									'torisu' => $torisu
							 ];

						 }

						}

					}

					$StockInoutWorklogs = $this->StockInoutWorklogs->find()//仕入れ数の呼出
					->where(['date_work >=' => $datestart, 'date_work <=' => $dateendnext, 'outsource_code !=' => 22,
					'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みprimary_w
					->order(["date_work"=>"ASC"])->toArray();

					for($k=0; $k<count($StockInoutWorklogs); $k++){

						$Product = $this->Products->find()->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'status' => 0, 'primary_p' => 1])->toArray();//productsの絞込み　primary

						$NonKadouSeikeis = $this->NonKadouSeikeis->find()->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'outsource_handy_id' => $StockInoutWorklogs[$k]["outsource_code"], 'status' => 0, 'delete_flag' => 0])->toArray();

						if(isset($Product[0]) && !isset($NonKadouSeikeis[0])){

							$arrSeisans[] = [
								'dateseikei' => $StockInoutWorklogs[$k]["date_work"]->format('Y/m/d'),
								'product_code' => $StockInoutWorklogs[$k]["product_code"],
								'amount_shot' => $StockInoutWorklogs[$k]["amount"],
								'torisu' => 1
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

					//$arrSeisans完成

			}elseif($sheet === "primary_h"){

				//$arrProductsmotoスタート

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'customer_code' => '10002',
				'OR' => [['product_code like' => 'H%']]])->toArray();

				if(!isset($_SESSION)){
				session_start();
				}
				$_SESSION['classarrProducts'] = array();
				$_SESSION['classarrProducts'] = $arrProducts;

				$htmlApifind = new htmlApifind();//クラスを使用
				$arrProductsmoto = $htmlApifind->Productsmoto($date16);//クラスを使用

				//$arrProductsmoto完成

				//$arrResultZensuHeadsmotoスタート

				$_SESSION['classarrdatestart'] = array();
				$_SESSION['classarrdatestart'] = $datestart;

				$htmlApifind = new htmlApifind();//クラスを使用
				$arrResultZensuHeadsmoto = $htmlApifind->ResultZensuHeadsmoto($dateend);//クラスを使用

				//$arrResultZensuHeadsmoto完成

				//$arrAssembleProductsスタート

				$arrAssembleProducts = array();//ここから組立品
				for($l=0; $l<count($arrResultZensuHeadsmoto); $l++){

					$AssembleProducts = $this->AssembleProducts->find()->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

					if(isset($AssembleProducts[0])){//AssembleProductsが存在する場合//組立

						$OrderEdisAssemble = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
						->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0, 'customer_code' => '10002',
						'OR' => [['product_code like' => 'H%']]])//productsの絞込みprimary_h
						->order(["date_deliver"=>"ASC"])->toArray();

						if(isset($OrderEdisAssemble[0])){

							$Konpou = $this->Konpous->find()->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"]])->toArray();
							$irisu = $Konpou[0]->irisu;//製品の入数を取得

							$amount = $irisu * $arrResultZensuHeadsmoto[$l]["count"];//入数をかけてamountを取得

							 $arrAssembleProducts[] = [//配列$arrAssembleProductsに追加
								 'product_code' => $arrResultZensuHeadsmoto[$l]["product_code"],
								 'kensabi' => $arrResultZensuHeadsmoto[$l]["datetime_finish"],
								 'amount' => $amount
							];

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

				//$arrAssembleProducts完成

				//$arrOrderEdisスタート

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0, 'customer_code' => '10002',
				'OR' => [['product_code like' => 'H%']]])//productsの絞込みprimary_h
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'status' => 0])->toArray();//productsの絞込み　primary

					if(isset($Product[0])){

						$product_name = $Product[0]->product_name;

						$riron_check = 0;

							$arrOrderEdis[] = [
								'date_order' => $OrderEdis[$k]["date_order"],
								'num_order' => $OrderEdis[$k]["num_order"],
								'product_code' => $OrderEdis[$k]["product_code"],
								'product_name' => $product_name,
								'price' => $OrderEdis[$k]["price"],
								'date_deliver' => $OrderEdis[$k]["date_deliver"],
								'amount' => $OrderEdis[$k]["amount"],
								'denpyoumaisu' => 1
						 ];

						 for($l=0; $l<count($arrProductsmoto); $l++){

							 if($arrProductsmoto[$l]["product_code"] === $OrderEdis[$k]["product_code"]){

								 unset($arrProductsmoto[$l]);
								 $arrProductsmoto = array_values($arrProductsmoto);

							 }

						}

					}

				}

				if(!isset($_SESSION)){
				session_start();
				}
				$_SESSION['classarrProductsmoto'] = array();
				$_SESSION['classarrProductsmoto'] = $arrProductsmoto;
				$_SESSION['classOrderEdis'] = array();
				$_SESSION['classOrderEdis'] = $OrderEdis;
				$_SESSION['classarrOrderEdis'] = array();
				$_SESSION['classarrOrderEdis'] = $arrOrderEdis;

				//OrderEdisクラス使用
				$htmlApifind = new htmlApifind();//クラスを使用
				$arrOrderEdis = $htmlApifind->OrderEdis($date16);//クラスを使用

				//$arrOrderEdis完成

				//$StockProductsスタート

				$StockProducts = $this->RironStockProducts->find()//月末在庫呼び出し
				->where(['date_culc >=' => $day, 'date_culc <=' => $day,
				//->where(['date_culc >=' => $day, 'date_culc <=' => $dateend,
				'OR' => ['product_code like' => 'H%']])//productsの絞込みprimary_h
				->order(["date_culc"=>"ASC"])->toArray();

				$arrStockProducts = array();
				for($k=0; $k<count($StockProducts); $k++){

					$Product = $this->Products->find()->where(['product_code' => $StockProducts[$k]["product_code"], 'status' => 0])->toArray();//productsの絞込み　primary

					if(isset($Product[0])){

						if(!isset($StockProducts[$k]["date_culc"])){
							$StockProducts[$k]["date_culc"] = $StockProducts[$k]["date_stock"];
						}

						$arrStockProducts[] = [
							'product_code' => $StockProducts[$k]["product_code"],
							'date_stock' => $StockProducts[$k]["date_culc"],
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

				//$StockProducts完成

				//$SyoyouKeikakusスタート

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0,
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

				//$SyoyouKeikakus完成

				//$arrSeisansスタート

				$daystart = $datestart." 08:00:00";
				$dayfin = $dateend." 07:59:59";

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
						 $LabelSetikkatsu1 = $this->LabelSetikkatsues->find()->where(['product_id1' => $KadouSeikeis[$k]['product_code'], 'kind_set_assemble' => 0])->toArray();
						 $LabelSetikkatsu2 = $this->LabelSetikkatsues->find()->where(['product_id2' => $KadouSeikeis[$k]['product_code'], 'kind_set_assemble' => 0])->toArray();

						 if(isset($LabelSetikkatsu1[0])){

							 $arrSeisans[] = [
									'dateseikei' => $nippouday,
									'product_code' => $LabelSetikkatsu1[0]["product_id2"],
									'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
									'torisu' => $torisu
							 ];

						 }elseif(isset($LabelSetikkatsu2[0])){

							 $arrSeisans[] = [
									'dateseikei' => $nippouday,
									'product_code' => $LabelSetikkatsu2[0]["product_id1"],
									'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
									'torisu' => $torisu
							 ];

						 }

						}

					}

					$StockInoutWorklogs = $this->StockInoutWorklogs->find()//仕入れ数の呼出
					->where(['date_work >=' => $datestart, 'date_work <=' => $dateendnext, 'outsource_code !=' => 22,
					'OR' => ['product_code like' => 'H%']])//productsの絞込みprimary_h
					->order(["date_work"=>"ASC"])->toArray();

					for($k=0; $k<count($StockInoutWorklogs); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10002'])->toArray();//productsの絞込みprimary_h

						$NonKadouSeikeis = $this->NonKadouSeikeis->find()->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'outsource_handy_id' => $StockInoutWorklogs[$k]["outsource_code"], 'status' => 0, 'delete_flag' => 0])->toArray();

						if(isset($Product[0]) && !isset($NonKadouSeikeis[0])){

							$arrSeisans[] = [
								'dateseikei' => $StockInoutWorklogs[$k]["date_work"]->format('Y/m/d'),
								'product_code' => $StockInoutWorklogs[$k]["product_code"],
								'amount_shot' => $StockInoutWorklogs[$k]["amount"],
								'torisu' => 1
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

					//$arrSeisans完成

			}elseif($sheet === "reizouko"){

				//$arrProductsmotoスタート

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'customer_code' => '10005'])->toArray();

				if(!isset($_SESSION)){
				session_start();
				}
				$_SESSION['classarrProducts'] = array();
				$_SESSION['classarrProducts'] = $arrProducts;

				$htmlApifind = new htmlApifind();//クラスを使用
				$arrProductsmoto = $htmlApifind->Productsmoto($date16);//クラスを使用

				//$arrProductsmoto完成

				//$arrResultZensuHeadsmotoスタート

				$_SESSION['classarrdatestart'] = array();
				$_SESSION['classarrdatestart'] = $datestart;

				$htmlApifind = new htmlApifind();//クラスを使用
				$arrResultZensuHeadsmoto = $htmlApifind->ResultZensuHeadsmoto($dateend);//クラスを使用

				//$arrResultZensuHeadsmoto完成

				//$arrAssembleProductsスタート

				$arrAssembleProducts = array();//ここから組立品
				for($l=0; $l<count($arrResultZensuHeadsmoto); $l++){

					$AssembleProducts = $this->AssembleProducts->find()->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

					if(isset($AssembleProducts[0])){//AssembleProductsが存在する場合//組立

						$OrderEdisAssemble = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
						->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0, 'customer_code' => '10002',
						'OR' => [['customer_code' => '10005']]])//productsの絞込みreizouko
						->order(["date_deliver"=>"ASC"])->toArray();

						if(isset($OrderEdisAssemble[0])){

							$Konpou = $this->Konpous->find()->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"]])->toArray();
							$irisu = $Konpou[0]->irisu;//製品の入数を取得

							$amount = $irisu * $arrResultZensuHeadsmoto[$l]["count"];//入数をかけてamountを取得

							 $arrAssembleProducts[] = [//配列$arrAssembleProductsに追加
								 'product_code' => $arrResultZensuHeadsmoto[$l]["product_code"],
								 'kensabi' => $arrResultZensuHeadsmoto[$l]["datetime_finish"],
								 'amount' => $amount
							];

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

				//$arrAssembleProducts完成

				//$arrOrderEdisスタート

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0,
				'OR' => [['customer_code' => '10005']]])//productsの絞込みreizouko
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'status' => 0])->toArray();//productsの絞込み　primary

					if(isset($Product[0])){

						$product_name = $Product[0]->product_name;

							$arrOrderEdis[] = [
								'date_order' => $OrderEdis[$k]["date_order"],
								'num_order' => $OrderEdis[$k]["num_order"],
								'product_code' => $OrderEdis[$k]["product_code"],
								'product_name' => $product_name,
								'price' => $OrderEdis[$k]["price"],
								'date_deliver' => $OrderEdis[$k]["date_deliver"],
								'amount' => $OrderEdis[$k]["amount"],
								'denpyoumaisu' => 1
						 ];

						 for($l=0; $l<count($arrProductsmoto); $l++){

							 if($arrProductsmoto[$l]["product_code"] === $OrderEdis[$k]["product_code"]){

								 unset($arrProductsmoto[$l]);
								 $arrProductsmoto = array_values($arrProductsmoto);

							 }

						}

					}

				}

				if(!isset($_SESSION)){
				session_start();
				}
				$_SESSION['classarrProductsmoto'] = array();
				$_SESSION['classarrProductsmoto'] = $arrProductsmoto;
				$_SESSION['classOrderEdis'] = array();
				$_SESSION['classOrderEdis'] = $OrderEdis;
				$_SESSION['classarrOrderEdis'] = array();
				$_SESSION['classarrOrderEdis'] = $arrOrderEdis;

				//OrderEdisクラス使用
				$htmlApifind = new htmlApifind();//クラスを使用
				$arrOrderEdis = $htmlApifind->OrderEdis($date16);//クラスを使用

				//$arrOrderEdis完成

				//$StockProductsスタート

				$StockProducts = $this->RironStockProducts->find()//月末在庫呼び出し
				->where(['date_culc >=' => $day, 'date_culc <=' => $day])
				->order(["date_culc"=>"ASC"])->toArray();

					$arrStockProducts = array();
					for($k=0; $k<count($StockProducts); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10005'])->toArray();//productsの絞込みreizouko

						if(isset($Product[0])){

							if(!isset($StockProducts[$k]["date_culc"])){
								$StockProducts[$k]["date_culc"] = $StockProducts[$k]["date_stock"];
							}

							$arrStockProducts[] = [
								'product_code' => $StockProducts[$k]["product_code"],
								'date_stock' => $StockProducts[$k]["date_culc"],
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

					//$StockProducts完成

					//$SyoyouKeikakusスタート

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0])
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrSyoyouKeikakus = array();
				for($k=0; $k<count($SyoyouKeikakus); $k++){

			//		$Product = $this->Products->find()->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'status' => 0])->toArray();//productsの絞込み　primary
					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10005'])->toArray();

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

				//$SyoyouKeikakus完成

				//$arrSeisansスタート

				$daystart = $datestart." 08:00:00";
				$dayfin = $dateend." 07:59:59";

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
						 $LabelSetikkatsu1 = $this->LabelSetikkatsues->find()->where(['product_id1' => $KadouSeikeis[$k]['product_code'], 'kind_set_assemble' => 0])->toArray();
						 $LabelSetikkatsu2 = $this->LabelSetikkatsues->find()->where(['product_id2' => $KadouSeikeis[$k]['product_code'], 'kind_set_assemble' => 0])->toArray();

						 if(isset($LabelSetikkatsu1[0])){

							 $arrSeisans[] = [
									'dateseikei' => $nippouday,
									'product_code' => $LabelSetikkatsu1[0]["product_id2"],
									'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
									'torisu' => $torisu
							 ];

						 }elseif(isset($LabelSetikkatsu2[0])){

							 $arrSeisans[] = [
									'dateseikei' => $nippouday,
									'product_code' => $LabelSetikkatsu2[0]["product_id1"],
									'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
									'torisu' => $torisu
							 ];

						 }

						}

					}

					$StockInoutWorklogs = $this->StockInoutWorklogs->find()//仕入れ数の呼出
					->where(['date_work >=' => $datestart, 'date_work <=' => $dateendnext, 'outsource_code !=' => 22])
					->order(["date_work"=>"ASC"])->toArray();

					for($k=0; $k<count($StockInoutWorklogs); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10005'])->toArray();//productsの絞込みreizouko

						$NonKadouSeikeis = $this->NonKadouSeikeis->find()->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'outsource_handy_id' => $StockInoutWorklogs[$k]["outsource_code"], 'status' => 0, 'delete_flag' => 0])->toArray();

						if(isset($Product[0]) && !isset($NonKadouSeikeis[0])){

							$arrSeisans[] = [
								'dateseikei' => $StockInoutWorklogs[$k]["date_work"]->format('Y/m/d'),
								'product_code' => $StockInoutWorklogs[$k]["product_code"],
								'amount_shot' => $StockInoutWorklogs[$k]["amount"],
								'torisu' => 1
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

					//$arrSeisans完成

			}elseif($sheet === "uwawaku"){

				//$arrProductsmotoスタート

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'customer_code' => '10003'])->toArray();

				if(!isset($_SESSION)){
				session_start();
				}
				$_SESSION['classarrProducts'] = array();
				$_SESSION['classarrProducts'] = $arrProducts;

				$htmlApifind = new htmlApifind();//クラスを使用
				$arrProductsmoto = $htmlApifind->Productsmoto($date16);//クラスを使用

				//$arrProductsmoto完成

				//$arrResultZensuHeadsmotoスタート

				$_SESSION['classarrdatestart'] = array();
				$_SESSION['classarrdatestart'] = $datestart;

				$htmlApifind = new htmlApifind();//クラスを使用
				$arrResultZensuHeadsmoto = $htmlApifind->ResultZensuHeadsmoto($dateend);//クラスを使用

				//$arrResultZensuHeadsmoto完成

				//$arrAssembleProductsスタート

				$arrAssembleProducts = array();//ここから組立品
				for($l=0; $l<count($arrResultZensuHeadsmoto); $l++){

					$AssembleProducts = $this->AssembleProducts->find()->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

					if(isset($AssembleProducts[0])){//AssembleProductsが存在する場合//組立

						$OrderEdisAssemble = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
						->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0,
						'OR' => [['customer_code' => '10003']]])//productsの絞込みuwawaku
						->order(["date_deliver"=>"ASC"])->toArray();

						if(isset($OrderEdisAssemble[0])){

							$Konpou = $this->Konpous->find()->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"]])->toArray();
							$irisu = $Konpou[0]->irisu;//製品の入数を取得

							$amount = $irisu * $arrResultZensuHeadsmoto[$l]["count"];//入数をかけてamountを取得

							 $arrAssembleProducts[] = [//配列$arrAssembleProductsに追加
								 'product_code' => $arrResultZensuHeadsmoto[$l]["product_code"],
								 'kensabi' => $arrResultZensuHeadsmoto[$l]["datetime_finish"],
								 'amount' => $amount
							];

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

				//$arrAssembleProducts完成

				//$arrOrderEdisスタート

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0,
				'OR' => [['customer_code' => '10003']]])//productsの絞込みuwawaku
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'status' => 0])->toArray();//productsの絞込み　primary

					if(isset($Product[0])){

						$product_name = $Product[0]->product_name;

							$arrOrderEdis[] = [
								'date_order' => $OrderEdis[$k]["date_order"],
								'num_order' => $OrderEdis[$k]["num_order"],
								'product_code' => $OrderEdis[$k]["product_code"],
								'product_name' => $product_name,
								'price' => $OrderEdis[$k]["price"],
								'date_deliver' => $OrderEdis[$k]["date_deliver"],
								'amount' => $OrderEdis[$k]["amount"],
								'denpyoumaisu' => 1
						 ];

						 for($l=0; $l<count($arrProductsmoto); $l++){

							 if($arrProductsmoto[$l]["product_code"] === $OrderEdis[$k]["product_code"]){

								 unset($arrProductsmoto[$l]);
								 $arrProductsmoto = array_values($arrProductsmoto);

							 }

						}

					}

				}

				if(!isset($_SESSION)){
				session_start();
				}
				$_SESSION['classarrProductsmoto'] = array();
				$_SESSION['classarrProductsmoto'] = $arrProductsmoto;
				$_SESSION['classOrderEdis'] = array();
				$_SESSION['classOrderEdis'] = $OrderEdis;
				$_SESSION['classarrOrderEdis'] = array();
				$_SESSION['classarrOrderEdis'] = $arrOrderEdis;

				//OrderEdisクラス使用
				$htmlApifind = new htmlApifind();//クラスを使用
				$arrOrderEdis = $htmlApifind->OrderEdis($date16);//クラスを使用

				//$arrOrderEdis完成

				//$StockProductsスタート

				$StockProducts = $this->RironStockProducts->find()//月末在庫呼び出し
				->where(['date_culc >=' => $day, 'date_culc <=' => $day])
				//->where(['date_culc >=' => $day, 'date_culc <=' => $dateend])
				->order(["date_culc"=>"ASC"])->toArray();

					$arrStockProducts = array();
					for($k=0; $k<count($StockProducts); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10003'])->toArray();//productsの絞込みuwawaku

						if(isset($Product[0])){

							if(!isset($StockProducts[$k]["date_culc"])){
								$StockProducts[$k]["date_culc"] = $StockProducts[$k]["date_stock"];
							}

							$arrStockProducts[] = [
								'product_code' => $StockProducts[$k]["product_code"],
								'date_stock' => $StockProducts[$k]["date_culc"],
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

					//$StockProducts完成

					//$SyoyouKeikakusスタート

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0])
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrSyoyouKeikakus = array();
				for($k=0; $k<count($SyoyouKeikakus); $k++){

		//			$Product = $this->Products->find()->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'status' => 0])->toArray();//productsの絞込み　primary
					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10003'])->toArray();

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

				//$SyoyouKeikakus完成

				//$arrSeisansスタート

				$daystart = $datestart." 08:00:00";
				$dayfin = $dateend." 07:59:59";

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
						 $LabelSetikkatsu1 = $this->LabelSetikkatsues->find()->where(['product_id1' => $KadouSeikeis[$k]['product_code'], 'kind_set_assemble' => 0])->toArray();
						 $LabelSetikkatsu2 = $this->LabelSetikkatsues->find()->where(['product_id2' => $KadouSeikeis[$k]['product_code'], 'kind_set_assemble' => 0])->toArray();

						 if(isset($LabelSetikkatsu1[0])){

							 $arrSeisans[] = [
									'dateseikei' => $nippouday,
									'product_code' => $LabelSetikkatsu1[0]["product_id2"],
									'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
									'torisu' => $torisu
							 ];

						 }elseif(isset($LabelSetikkatsu2[0])){

							 $arrSeisans[] = [
									'dateseikei' => $nippouday,
									'product_code' => $LabelSetikkatsu2[0]["product_id1"],
									'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
									'torisu' => $torisu
							 ];

						 }

						}

					}

					$StockInoutWorklogs = $this->StockInoutWorklogs->find()//仕入れ数の呼出
					->where(['date_work >=' => $datestart, 'date_work <=' => $dateendnext, 'outsource_code !=' => 22])
					->order(["date_work"=>"ASC"])->toArray();

					for($k=0; $k<count($StockInoutWorklogs); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10003'])->toArray();//productsの絞込みuwawaku

						$NonKadouSeikeis = $this->NonKadouSeikeis->find()->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'outsource_handy_id' => $StockInoutWorklogs[$k]["outsource_code"], 'status' => 0, 'delete_flag' => 0])->toArray();

						if(isset($Product[0]) && !isset($NonKadouSeikeis[0])){

							$arrSeisans[] = [
								'dateseikei' => $StockInoutWorklogs[$k]["date_work"]->format('Y/m/d'),
								'product_code' => $StockInoutWorklogs[$k]["product_code"],
								'amount_shot' => $StockInoutWorklogs[$k]["amount"],
								'torisu' => 1
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

					//$arrSeisans完成

			}elseif($sheet === "other"){

				//$arrProductsmotoスタート

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0,
				'AND' => [['customer_code not like' => '1%'], ['customer_code not like' => '2%']]])->toArray();

				if(!isset($_SESSION)){
				session_start();
				}
				$_SESSION['classarrProducts'] = array();
				$_SESSION['classarrProducts'] = $arrProducts;

				$htmlApifind = new htmlApifind();//クラスを使用
				$arrProductsmoto = $htmlApifind->Productsmoto($date16);//クラスを使用

				//$arrProductsmoto完成

				//$arrResultZensuHeadsmotoスタート

				$_SESSION['classarrdatestart'] = array();
				$_SESSION['classarrdatestart'] = $datestart;

				$htmlApifind = new htmlApifind();//クラスを使用
				$arrResultZensuHeadsmoto = $htmlApifind->ResultZensuHeadsmoto($dateend);//クラスを使用

				//$arrResultZensuHeadsmoto完成

				//$arrAssembleProductsスタート

				$arrAssembleProducts = array();//ここから組立品
				for($l=0; $l<count($arrResultZensuHeadsmoto); $l++){

					$AssembleProducts = $this->AssembleProducts->find()->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

					if(isset($AssembleProducts[0])){//AssembleProductsが存在する場合//組立

						$OrderEdisAssemble = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
						->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0, 'AND' => [['customer_code not like' => '1%'], ['customer_code not like' => '2%']]])//productsの絞込みother
						->order(["date_deliver"=>"ASC"])->toArray();

						if(isset($OrderEdisAssemble[0])){

							$Konpou = $this->Konpous->find()->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"]])->toArray();
							$irisu = $Konpou[0]->irisu;//製品の入数を取得

							$amount = $irisu * $arrResultZensuHeadsmoto[$l]["count"];//入数をかけてamountを取得

							 $arrAssembleProducts[] = [//配列$arrAssembleProductsに追加
								 'product_code' => $arrResultZensuHeadsmoto[$l]["product_code"],
								 'kensabi' => $arrResultZensuHeadsmoto[$l]["datetime_finish"],
								 'amount' => $amount
							];

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

				//$arrAssembleProducts完成

				//$arrOrderEdisスタート

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0, 'AND' => [['customer_code not like' => '1%'], ['customer_code not like' => '2%']]])//productsの絞込みother
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'status' => 0])->toArray();//productsの絞込み　primary

					if(isset($Product[0])){

						$product_name = $Product[0]->product_name;

							$arrOrderEdis[] = [
								'date_order' => $OrderEdis[$k]["date_order"],
								'num_order' => $OrderEdis[$k]["num_order"],
								'product_code' => $OrderEdis[$k]["product_code"],
								'product_name' => $product_name,
								'price' => $OrderEdis[$k]["price"],
								'date_deliver' => $OrderEdis[$k]["date_deliver"],
								'amount' => $OrderEdis[$k]["amount"],
								'denpyoumaisu' => 1
						 ];

						 for($l=0; $l<count($arrProductsmoto); $l++){

							 if($arrProductsmoto[$l]["product_code"] === $OrderEdis[$k]["product_code"]){

								 unset($arrProductsmoto[$l]);
								 $arrProductsmoto = array_values($arrProductsmoto);

							 }

						}

					}

				}

				if(!isset($_SESSION)){
				session_start();
				}
				$_SESSION['classarrProductsmoto'] = array();
				$_SESSION['classarrProductsmoto'] = $arrProductsmoto;
				$_SESSION['classOrderEdis'] = array();
				$_SESSION['classOrderEdis'] = $OrderEdis;
				$_SESSION['classarrOrderEdis'] = array();
				$_SESSION['classarrOrderEdis'] = $arrOrderEdis;

				//OrderEdisクラス使用
				$htmlApifind = new htmlApifind();//クラスを使用
				$arrOrderEdis = $htmlApifind->OrderEdis($date16);//クラスを使用

				//$arrOrderEdis完成

				//$StockProductsスタート

				$StockProducts = $this->RironStockProducts->find()//月末在庫呼び出し
				->where(['date_culc >=' => $day, 'date_culc <=' => $day])
				->order(["date_culc"=>"ASC"])->toArray();

					$arrStockProducts = array();
					for($k=0; $k<count($StockProducts); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'AND' => [['customer_code not like' => '1%'], ['customer_code not like' => '2%']]])//productsの絞込みother
						->toArray();//productsの絞込みother

						if(isset($Product[0])){

							if(!isset($StockProducts[$k]["date_culc"])){
								$StockProducts[$k]["date_culc"] = $StockProducts[$k]["date_stock"];
							}

							$arrStockProducts[] = [
								'product_code' => $StockProducts[$k]["product_code"],
								'date_stock' => $StockProducts[$k]["date_culc"],
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

					//$StockProducts完成

					//$SyoyouKeikakusスタート

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0])
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrSyoyouKeikakus = array();
				for($k=0; $k<count($SyoyouKeikakus); $k++){

		//			$Product = $this->Products->find()->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'status' => 0])->toArray();//productsの絞込み　primary
					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'products.status' => 0,
					'AND' => [['customer_code not like' => '1%'], ['customer_code not like' => '2%']]])->toArray();

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

				//$SyoyouKeikakus完成

				//$arrSeisansスタート

				$daystart = $datestart." 08:00:00";
				$dayfin = $dateend." 07:59:59";

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
						 $LabelSetikkatsu1 = $this->LabelSetikkatsues->find()->where(['product_id1' => $KadouSeikeis[$k]['product_code'], 'kind_set_assemble' => 0])->toArray();
						 $LabelSetikkatsu2 = $this->LabelSetikkatsues->find()->where(['product_id2' => $KadouSeikeis[$k]['product_code'], 'kind_set_assemble' => 0])->toArray();

						 if(isset($LabelSetikkatsu1[0])){

							 $arrSeisans[] = [
									'dateseikei' => $nippouday,
									'product_code' => $LabelSetikkatsu1[0]["product_id2"],
									'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
									'torisu' => $torisu
							 ];

						 }elseif(isset($LabelSetikkatsu2[0])){

							 $arrSeisans[] = [
									'dateseikei' => $nippouday,
									'product_code' => $LabelSetikkatsu2[0]["product_id1"],
									'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
									'torisu' => $torisu
							 ];

						 }

						}

					}

					$StockInoutWorklogs = $this->StockInoutWorklogs->find()//仕入れ数の呼出
					->where(['date_work >=' => $datestart, 'date_work <=' => $dateendnext, 'outsource_code !=' => 22])
					->order(["date_work"=>"ASC"])->toArray();

					for($k=0; $k<count($StockInoutWorklogs); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'products.status' => 0, 'AND' => [['customer_code not like' => '1%'], ['customer_code not like' => '2%']]])//productsの絞込みother
						->toArray();//productsの絞込みother

						$NonKadouSeikeis = $this->NonKadouSeikeis->find()->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'outsource_handy_id' => $StockInoutWorklogs[$k]["outsource_code"], 'status' => 0, 'delete_flag' => 0])->toArray();

						if(isset($Product[0]) && !isset($NonKadouSeikeis[0])){

							$arrSeisans[] = [
								'dateseikei' => $StockInoutWorklogs[$k]["date_work"]->format('Y/m/d'),
								'product_code' => $StockInoutWorklogs[$k]["product_code"],
								'amount_shot' => $StockInoutWorklogs[$k]["amount"],
								'torisu' => 1
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

					//$arrSeisans完成

			}elseif($sheet === "p0"){

				//$arrProductsmotoスタート

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'customer_code' => '10001',
				'OR' => [['product_code like' => 'P0%']]])->toArray();

				if(!isset($_SESSION)){
				session_start();
				}
				$_SESSION['classarrProducts'] = array();
				$_SESSION['classarrProducts'] = $arrProducts;

				$htmlApifind = new htmlApifind();//クラスを使用
				$arrProductsmoto = $htmlApifind->Productsmoto($date16);//クラスを使用

				//$arrProductsmoto完成

				//$arrResultZensuHeadsmotoスタート

				$_SESSION['classarrdatestart'] = array();
				$_SESSION['classarrdatestart'] = $datestart;

				$htmlApifind = new htmlApifind();//クラスを使用
				$arrResultZensuHeadsmoto = $htmlApifind->ResultZensuHeadsmoto($dateend);//クラスを使用

				//$arrResultZensuHeadsmoto完成

				//$arrAssembleProductsスタート

				$arrAssembleProducts = array();//ここから組立品
				for($l=0; $l<count($arrResultZensuHeadsmoto); $l++){

					$AssembleProducts = $this->AssembleProducts->find()->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

					if(isset($AssembleProducts[0])){//AssembleProductsが存在する場合//組立

						$OrderEdisAssemble = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
						->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0, 'customer_code' => '10001',
						'OR' => [['product_code like' => 'P0%']]])//productsの絞込みp0
						->order(["date_deliver"=>"ASC"])->toArray();

						if(isset($OrderEdisAssemble[0])){

							$Konpou = $this->Konpous->find()->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"]])->toArray();
							$irisu = $Konpou[0]->irisu;//製品の入数を取得

							$amount = $irisu * $arrResultZensuHeadsmoto[$l]["count"];//入数をかけてamountを取得

							 $arrAssembleProducts[] = [//配列$arrAssembleProductsに追加
								 'product_code' => $arrResultZensuHeadsmoto[$l]["product_code"],
								 'kensabi' => $arrResultZensuHeadsmoto[$l]["datetime_finish"],
								 'amount' => $amount
							];

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

				//$arrAssembleProducts完成

				//$arrOrderEdisスタート

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0, 'customer_code' => '10001',
				'OR' => [['product_code like' => 'P0%']]])//productsの絞込みp0
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'status' => 0])->toArray();//productsの絞込み　primary

					if(isset($Product[0])){

						$product_name = $Product[0]->product_name;

							$arrOrderEdis[] = [
								'date_order' => $OrderEdis[$k]["date_order"],
								'num_order' => $OrderEdis[$k]["num_order"],
								'product_code' => $OrderEdis[$k]["product_code"],
								'product_name' => $product_name,
								'price' => $OrderEdis[$k]["price"],
								'date_deliver' => $OrderEdis[$k]["date_deliver"],
								'amount' => $OrderEdis[$k]["amount"],
								'denpyoumaisu' => 1
						 ];

						 for($l=0; $l<count($arrProductsmoto); $l++){

							 if($arrProductsmoto[$l]["product_code"] === $OrderEdis[$k]["product_code"]){

								 unset($arrProductsmoto[$l]);
								 $arrProductsmoto = array_values($arrProductsmoto);

							 }

						}

					}

				}

				if(!isset($_SESSION)){
				session_start();
				}
				$_SESSION['classarrProductsmoto'] = array();
				$_SESSION['classarrProductsmoto'] = $arrProductsmoto;
				$_SESSION['classOrderEdis'] = array();
				$_SESSION['classOrderEdis'] = $OrderEdis;
				$_SESSION['classarrOrderEdis'] = array();
				$_SESSION['classarrOrderEdis'] = $arrOrderEdis;

				//OrderEdisクラス使用
				$htmlApifind = new htmlApifind();//クラスを使用
				$arrOrderEdis = $htmlApifind->OrderEdis($date16);//クラスを使用

				//$arrOrderEdis完成

				//$StockProductsスタート

				$StockProducts = $this->RironStockProducts->find()//月末在庫呼び出し
				->where(['date_culc >=' => $day, 'date_culc <=' => $day,
				//->where(['date_culc >=' => $day, 'date_culc <=' => $dateend,
				'OR' => ['product_code like' => 'P0%']])//productsの絞込みp0
				->order(["date_culc"=>"ASC"])->toArray();

					$arrStockProducts = array();
					for($k=0; $k<count($StockProducts); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10001'])->toArray();//productsの絞込みp0

						if(isset($Product[0])){

							if(!isset($StockProducts[$k]["date_culc"])){
								$StockProducts[$k]["date_culc"] = $StockProducts[$k]["date_stock"];
							}

							$arrStockProducts[] = [
								'product_code' => $StockProducts[$k]["product_code"],
								'date_stock' => $StockProducts[$k]["date_culc"],
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

					//$StockProducts完成

					//$SyoyouKeikakusスタート

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0,
				'OR' => ['product_code like' => 'P0%']])//productsの絞込みp0
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

				//$SyoyouKeikakus完成

				//$arrSeisansスタート

				$daystart = $datestart." 08:00:00";
				$dayfin = $dateend." 07:59:59";

				$KadouSeikeis = $this->KadouSeikeis->find()//生産数呼び出し
				->where(['starting_tm >=' => $daystart, 'starting_tm <=' => $dayfin,
				'OR' => ['product_code like' => 'P0%']])//productsの絞込みp0
				->order(["starting_tm"=>"ASC"])->toArray();

					$arrSeisans = array();
					for($k=0; $k<count($KadouSeikeis); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $KadouSeikeis[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10001'])->toArray();//productsの絞込みp0

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
						 $LabelSetikkatsu1 = $this->LabelSetikkatsues->find()->where(['product_id1' => $KadouSeikeis[$k]['product_code'], 'kind_set_assemble' => 0])->toArray();
						 $LabelSetikkatsu2 = $this->LabelSetikkatsues->find()->where(['product_id2' => $KadouSeikeis[$k]['product_code'], 'kind_set_assemble' => 0])->toArray();

						 if(isset($LabelSetikkatsu1[0])){

							 $arrSeisans[] = [
									'dateseikei' => $nippouday,
									'product_code' => $LabelSetikkatsu1[0]["product_id2"],
									'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
									'torisu' => $torisu
							 ];

						 }elseif(isset($LabelSetikkatsu2[0])){

							 $arrSeisans[] = [
									'dateseikei' => $nippouday,
									'product_code' => $LabelSetikkatsu2[0]["product_id1"],
									'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
									'torisu' => $torisu
							 ];

						 }

						}

					}

					$StockInoutWorklogs = $this->StockInoutWorklogs->find()//仕入れ数の呼出
					->where(['date_work >=' => $datestart, 'date_work <=' => $dateendnext, 'outsource_code !=' => 22,
					'OR' => ['product_code like' => 'P0%']])//productsの絞込みp0
					->order(["date_work"=>"ASC"])->toArray();

					for($k=0; $k<count($StockInoutWorklogs); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10001'])->toArray();//productsの絞込みp0

						$NonKadouSeikeis = $this->NonKadouSeikeis->find()->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'outsource_handy_id' => $StockInoutWorklogs[$k]["outsource_code"], 'status' => 0, 'delete_flag' => 0])->toArray();

						if(isset($Product[0]) && !isset($NonKadouSeikeis[0])){

							$arrSeisans[] = [
								'dateseikei' => $StockInoutWorklogs[$k]["date_work"]->format('Y/m/d'),
								'product_code' => $StockInoutWorklogs[$k]["product_code"],
								'amount_shot' => $StockInoutWorklogs[$k]["amount"],
								'torisu' => 1
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

					//$arrSeisans完成

			}elseif($sheet === "p1"){

				//$arrProductsmotoスタート

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'customer_code' => '10001',
				'OR' => [['product_code like' => 'P1%'], ['product_code like' => 'P2%']]])->toArray();

				if(!isset($_SESSION)){
				session_start();
				}
				$_SESSION['classarrProducts'] = array();
				$_SESSION['classarrProducts'] = $arrProducts;

				$htmlApifind = new htmlApifind();//クラスを使用
				$arrProductsmoto = $htmlApifind->Productsmoto($date16);//クラスを使用

				//$arrProductsmoto完成

				//$arrResultZensuHeadsmotoスタート

				$_SESSION['classarrdatestart'] = array();
				$_SESSION['classarrdatestart'] = $datestart;

				$htmlApifind = new htmlApifind();//クラスを使用
				$arrResultZensuHeadsmoto = $htmlApifind->ResultZensuHeadsmoto($dateend);//クラスを使用

				//$arrResultZensuHeadsmoto完成

				//$arrAssembleProductsスタート

				$arrAssembleProducts = array();//ここから組立品
				for($l=0; $l<count($arrResultZensuHeadsmoto); $l++){

					$AssembleProducts = $this->AssembleProducts->find()->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

					if(isset($AssembleProducts[0])){//AssembleProductsが存在する場合//組立

						$OrderEdisAssemble = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
						->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0, 'customer_code' => '10001',
						'OR' => [['product_code like' => 'P1%'], ['product_code like' => 'P2%']]])//productsの絞込みp1
						->order(["date_deliver"=>"ASC"])->toArray();

						if(isset($OrderEdisAssemble[0])){

							$Konpou = $this->Konpous->find()->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"]])->toArray();
							$irisu = $Konpou[0]->irisu;//製品の入数を取得

							$amount = $irisu * $arrResultZensuHeadsmoto[$l]["count"];//入数をかけてamountを取得

							 $arrAssembleProducts[] = [//配列$arrAssembleProductsに追加
								 'product_code' => $arrResultZensuHeadsmoto[$l]["product_code"],
								 'kensabi' => $arrResultZensuHeadsmoto[$l]["datetime_finish"],
								 'amount' => $amount
							];

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

				//$arrAssembleProducts完成

				//$arrOrderEdisスタート

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0, 'customer_code' => '10001',
				'OR' => [['product_code like' => 'P1%'], ['product_code like' => 'P2%']]])//productsの絞込みp1
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'status' => 0])->toArray();//productsの絞込み　primary

					if(isset($Product[0])){

						$product_name = $Product[0]->product_name;

							$arrOrderEdis[] = [
								'date_order' => $OrderEdis[$k]["date_order"],
								'num_order' => $OrderEdis[$k]["num_order"],
								'product_code' => $OrderEdis[$k]["product_code"],
								'product_name' => $product_name,
								'price' => $OrderEdis[$k]["price"],
								'date_deliver' => $OrderEdis[$k]["date_deliver"],
								'amount' => $OrderEdis[$k]["amount"],
								'denpyoumaisu' => 1
						 ];

						 for($l=0; $l<count($arrProductsmoto); $l++){

							 if($arrProductsmoto[$l]["product_code"] === $OrderEdis[$k]["product_code"]){

								 unset($arrProductsmoto[$l]);
								 $arrProductsmoto = array_values($arrProductsmoto);

							 }

						}

					}

				}

				if(!isset($_SESSION)){
				session_start();
				}
				$_SESSION['classarrProductsmoto'] = array();
				$_SESSION['classarrProductsmoto'] = $arrProductsmoto;
				$_SESSION['classOrderEdis'] = array();
				$_SESSION['classOrderEdis'] = $OrderEdis;
				$_SESSION['classarrOrderEdis'] = array();
				$_SESSION['classarrOrderEdis'] = $arrOrderEdis;

				//OrderEdisクラス使用
				$htmlApifind = new htmlApifind();//クラスを使用
				$arrOrderEdis = $htmlApifind->OrderEdis($date16);//クラスを使用

				//$arrOrderEdis完成

				//$StockProductsスタート

				$StockProducts = $this->RironStockProducts->find()//月末在庫呼び出し
				->where(['date_culc >=' => $day, 'date_culc <=' => $day,
				//->where(['date_culc >=' => $day, 'date_culc <=' => $dateend,
				'OR' => [['product_code like' => 'P1%'], ['product_code like' => 'P2%']]])//productsの絞込みp1
				->order(["date_culc"=>"ASC"])->toArray();

					$arrStockProducts = array();
					for($k=0; $k<count($StockProducts); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10001'])->toArray();//productsの絞込みp1

						if(isset($Product[0])){

							if(!isset($StockProducts[$k]["date_culc"])){
								$StockProducts[$k]["date_culc"] = $StockProducts[$k]["date_stock"];
							}

							$arrStockProducts[] = [
								'product_code' => $StockProducts[$k]["product_code"],
								'date_stock' => $StockProducts[$k]["date_culc"],
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

					//$StockProducts完成

					//$SyoyouKeikakusスタート

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0,
				'OR' => [['product_code like' => 'P1%'], ['product_code like' => 'P2%']]])//productsの絞込みp1
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

				//$SyoyouKeikakus完成

				//$arrSeisansスタート

				$daystart = $datestart." 08:00:00";
				$dayfin = $dateend." 07:59:59";

				$KadouSeikeis = $this->KadouSeikeis->find()//生産数呼び出し
				->where(['starting_tm >=' => $daystart, 'starting_tm <=' => $dayfin,
				'OR' => [['product_code like' => 'P1%'], ['product_code like' => 'P2%']]])//productsの絞込みp1
				->order(["starting_tm"=>"ASC"])->toArray();

					$arrSeisans = array();
					for($k=0; $k<count($KadouSeikeis); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $KadouSeikeis[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10001'])->toArray();//productsの絞込みp1

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
						 $LabelSetikkatsu1 = $this->LabelSetikkatsues->find()->where(['product_id1' => $KadouSeikeis[$k]['product_code'], 'kind_set_assemble' => 0])->toArray();
						 $LabelSetikkatsu2 = $this->LabelSetikkatsues->find()->where(['product_id2' => $KadouSeikeis[$k]['product_code'], 'kind_set_assemble' => 0])->toArray();

						 if(isset($LabelSetikkatsu1[0])){

							 $arrSeisans[] = [
									'dateseikei' => $nippouday,
									'product_code' => $LabelSetikkatsu1[0]["product_id2"],
									'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
									'torisu' => $torisu
							 ];

						 }elseif(isset($LabelSetikkatsu2[0])){

							 $arrSeisans[] = [
									'dateseikei' => $nippouday,
									'product_code' => $LabelSetikkatsu2[0]["product_id1"],
									'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
									'torisu' => $torisu
							 ];

						 }

						}

					}

					$StockInoutWorklogs = $this->StockInoutWorklogs->find()//仕入れ数の呼出
					->where(['date_work >=' => $datestart, 'date_work <=' => $dateendnext, 'outsource_code !=' => 22,
					'OR' => [['product_code like' => 'P1%'], ['product_code like' => 'P2%']]])//productsの絞込みp1
					->order(["date_work"=>"ASC"])->toArray();

					for($k=0; $k<count($StockInoutWorklogs); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10001'])->toArray();//productsの絞込みp1

						$NonKadouSeikeis = $this->NonKadouSeikeis->find()->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'outsource_handy_id' => $StockInoutWorklogs[$k]["outsource_code"], 'status' => 0, 'delete_flag' => 0])->toArray();

						if(isset($Product[0]) && !isset($NonKadouSeikeis[0])){

							$arrSeisans[] = [
								'dateseikei' => $StockInoutWorklogs[$k]["date_work"]->format('Y/m/d'),
								'product_code' => $StockInoutWorklogs[$k]["product_code"],
								'amount_shot' => $StockInoutWorklogs[$k]["amount"],
								'torisu' => 1
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

					//$arrSeisans完成

			}elseif($sheet === "w"){

				//$arrProductsmotoスタート

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'customer_code' => '10002',
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])->toArray();

				if(!isset($_SESSION)){
				session_start();
				}
				$_SESSION['classarrProducts'] = array();
				$_SESSION['classarrProducts'] = $arrProducts;

				$htmlApifind = new htmlApifind();//クラスを使用
				$arrProductsmoto = $htmlApifind->Productsmoto($date16);//クラスを使用

				//$arrProductsmoto完成

				//$arrResultZensuHeadsmotoスタート

				$_SESSION['classarrdatestart'] = array();
				$_SESSION['classarrdatestart'] = $datestart;

				$htmlApifind = new htmlApifind();//クラスを使用
				$arrResultZensuHeadsmoto = $htmlApifind->ResultZensuHeadsmoto($dateend);//クラスを使用

				//$arrResultZensuHeadsmoto完成

				//$arrAssembleProductsスタート

				$arrAssembleProducts = array();//ここから組立品
				for($l=0; $l<count($arrResultZensuHeadsmoto); $l++){

					$AssembleProducts = $this->AssembleProducts->find()->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

					if(isset($AssembleProducts[0])){//AssembleProductsが存在する場合//組立

						$OrderEdisAssemble = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
						->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0, 'customer_code' => '10002',
						'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みw
						->order(["date_deliver"=>"ASC"])->toArray();

						if(isset($OrderEdisAssemble[0])){

							$Konpou = $this->Konpous->find()->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"]])->toArray();
							$irisu = $Konpou[0]->irisu;//製品の入数を取得

							$amount = $irisu * $arrResultZensuHeadsmoto[$l]["count"];//入数をかけてamountを取得

							 $arrAssembleProducts[] = [//配列$arrAssembleProductsに追加
								 'product_code' => $arrResultZensuHeadsmoto[$l]["product_code"],
								 'kensabi' => $arrResultZensuHeadsmoto[$l]["datetime_finish"],
								 'amount' => $amount
							];

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

				//$arrAssembleProducts完成

				//$arrOrderEdisスタート

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0, 'customer_code' => '10002',
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みw
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'status' => 0])->toArray();//productsの絞込み　primary

					if(isset($Product[0])){

						$product_name = $Product[0]->product_name;

							$arrOrderEdis[] = [
								'date_order' => $OrderEdis[$k]["date_order"],
								'num_order' => $OrderEdis[$k]["num_order"],
								'product_code' => $OrderEdis[$k]["product_code"],
								'product_name' => $product_name,
								'price' => $OrderEdis[$k]["price"],
								'date_deliver' => $OrderEdis[$k]["date_deliver"],
								'amount' => $OrderEdis[$k]["amount"],
								'denpyoumaisu' => 1
						 ];

						 for($l=0; $l<count($arrProductsmoto); $l++){

							 if($arrProductsmoto[$l]["product_code"] === $OrderEdis[$k]["product_code"]){

								 unset($arrProductsmoto[$l]);
								 $arrProductsmoto = array_values($arrProductsmoto);

							 }

						}

					}

				}

				if(!isset($_SESSION)){
				session_start();
				}
				$_SESSION['classarrProductsmoto'] = array();
				$_SESSION['classarrProductsmoto'] = $arrProductsmoto;
				$_SESSION['classOrderEdis'] = array();
				$_SESSION['classOrderEdis'] = $OrderEdis;
				$_SESSION['classarrOrderEdis'] = array();
				$_SESSION['classarrOrderEdis'] = $arrOrderEdis;

				//OrderEdisクラス使用
				$htmlApifind = new htmlApifind();//クラスを使用
				$arrOrderEdis = $htmlApifind->OrderEdis($date16);//クラスを使用

				//$arrOrderEdis完成

				//$StockProductsスタート

				$StockProducts = $this->RironStockProducts->find()//月末在庫呼び出し
				->where(['date_culc >=' => $day, 'date_culc <=' => $day,
				//->where(['date_culc >=' => $day, 'date_culc <=' => $dateend,
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みw
				->order(["date_culc"=>"ASC"])->toArray();

					$arrStockProducts = array();
					for($k=0; $k<count($StockProducts); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10002'])->toArray();//productsの絞込みw

						if(isset($Product[0])){

							if(!isset($StockProducts[$k]["date_culc"])){
								$StockProducts[$k]["date_culc"] = $StockProducts[$k]["date_stock"];
							}

							$arrStockProducts[] = [
								'product_code' => $StockProducts[$k]["product_code"],
								'date_stock' => $StockProducts[$k]["date_culc"],
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

					//$StockProducts完成

					//$SyoyouKeikakusスタート

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0,
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みw
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

				//$SyoyouKeikakus完成

				//$arrSeisansスタート

				$daystart = $datestart." 08:00:00";
				$dayfin = $dateend." 07:59:59";

				$KadouSeikeis = $this->KadouSeikeis->find()//生産数呼び出し
				->where(['starting_tm >=' => $daystart, 'starting_tm <=' => $dayfin,
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みw
				->order(["starting_tm"=>"ASC"])->toArray();

					$arrSeisans = array();
					for($k=0; $k<count($KadouSeikeis); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $KadouSeikeis[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10002'])->toArray();//productsの絞込みw

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
						 $LabelSetikkatsu1 = $this->LabelSetikkatsues->find()->where(['product_id1' => $KadouSeikeis[$k]['product_code'], 'kind_set_assemble' => 0])->toArray();
						 $LabelSetikkatsu2 = $this->LabelSetikkatsues->find()->where(['product_id2' => $KadouSeikeis[$k]['product_code'], 'kind_set_assemble' => 0])->toArray();

						 if(isset($LabelSetikkatsu1[0])){

							 $arrSeisans[] = [
									'dateseikei' => $nippouday,
									'product_code' => $LabelSetikkatsu1[0]["product_id2"],
									'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
									'torisu' => $torisu
							 ];

						 }elseif(isset($LabelSetikkatsu2[0])){

							 $arrSeisans[] = [
									'dateseikei' => $nippouday,
									'product_code' => $LabelSetikkatsu2[0]["product_id1"],
									'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
									'torisu' => $torisu
							 ];

						 }

						}

					}

					$StockInoutWorklogs = $this->StockInoutWorklogs->find()//仕入れ数の呼出
					->where(['date_work >=' => $datestart, 'date_work <=' => $dateendnext, 'outsource_code !=' => 22,
					'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みw
					->order(["date_work"=>"ASC"])->toArray();

					for($k=0; $k<count($StockInoutWorklogs); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10002'])->toArray();//productsの絞込みw

						$NonKadouSeikeis = $this->NonKadouSeikeis->find()->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'outsource_handy_id' => $StockInoutWorklogs[$k]["outsource_code"], 'status' => 0, 'delete_flag' => 0])->toArray();

						if(isset($Product[0]) && !isset($NonKadouSeikeis[0])){

							$arrSeisans[] = [
								'dateseikei' => $StockInoutWorklogs[$k]["date_work"]->format('Y/m/d'),
								'product_code' => $StockInoutWorklogs[$k]["product_code"],
								'amount_shot' => $StockInoutWorklogs[$k]["amount"],
								'torisu' => 1
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

					//$arrSeisans完成

			}elseif($sheet === "dnp"){

				//$arrProductsmotoスタート

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'customer_code like' => '2%'
				])->toArray();

				if(!isset($_SESSION)){
				session_start();
				}
				$_SESSION['classarrProducts'] = array();
				$_SESSION['classarrProducts'] = $arrProducts;

				$htmlApifind = new htmlApifind();//クラスを使用
				$arrProductsmoto = $htmlApifind->Productsmoto($date16);//クラスを使用

				//$arrProductsmoto完成

				//$arrResultZensuHeadsmotoスタート

				$_SESSION['classarrdatestart'] = array();
				$_SESSION['classarrdatestart'] = $datestart;

				$htmlApifind = new htmlApifind();//クラスを使用
				$arrResultZensuHeadsmoto = $htmlApifind->ResultZensuHeadsmoto($dateend);//クラスを使用

				//$arrResultZensuHeadsmoto完成

				//$arrAssembleProductsスタート

				$arrAssembleProducts = array();//ここから組立品
				for($l=0; $l<count($arrResultZensuHeadsmoto); $l++){

					$AssembleProducts = $this->AssembleProducts->find()->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

					if(isset($AssembleProducts[0])){//AssembleProductsが存在する場合//組立

						$OrderEdisAssemble = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
						->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0,
						'OR' => [['customer_code like' => '2%']]])//productsの絞込みdnp
						->order(["date_deliver"=>"ASC"])->toArray();

						if(isset($OrderEdisAssemble[0])){

							$Konpou = $this->Konpous->find()->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"]])->toArray();
							$irisu = $Konpou[0]->irisu;//製品の入数を取得

							$amount = $irisu * $arrResultZensuHeadsmoto[$l]["count"];//入数をかけてamountを取得

							 $arrAssembleProducts[] = [//配列$arrAssembleProductsに追加
								 'product_code' => $arrResultZensuHeadsmoto[$l]["product_code"],
								 'kensabi' => $arrResultZensuHeadsmoto[$l]["datetime_finish"],
								 'amount' => $amount
							];

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

				//$arrAssembleProducts完成

				//$arrOrderEdisスタート

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0,
				'OR' => [['customer_code like' => '2%']]])//productsの絞込みdnp
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'status' => 0])->toArray();//productsの絞込み　primary

					if(isset($Product[0])){

						$product_name = $Product[0]->product_name;

							$arrOrderEdis[] = [
								'date_order' => $OrderEdis[$k]["date_order"],
								'num_order' => $OrderEdis[$k]["num_order"],
								'product_code' => $OrderEdis[$k]["product_code"],
								'product_name' => $product_name,
								'price' => $OrderEdis[$k]["price"],
								'date_deliver' => $OrderEdis[$k]["date_deliver"],
								'amount' => $OrderEdis[$k]["amount"],
								'denpyoumaisu' => 1
						 ];

						 for($l=0; $l<count($arrProductsmoto); $l++){

							 if($arrProductsmoto[$l]["product_code"] === $OrderEdis[$k]["product_code"]){

								 unset($arrProductsmoto[$l]);
								 $arrProductsmoto = array_values($arrProductsmoto);

							 }

						}

					}

				}

				if(!isset($_SESSION)){
				session_start();
				}
				$_SESSION['classarrProductsmoto'] = array();
				$_SESSION['classarrProductsmoto'] = $arrProductsmoto;
				$_SESSION['classOrderEdis'] = array();
				$_SESSION['classOrderEdis'] = $OrderEdis;
				$_SESSION['classarrOrderEdis'] = array();
				$_SESSION['classarrOrderEdis'] = $arrOrderEdis;

				//OrderEdisクラス使用
				$htmlApifind = new htmlApifind();//クラスを使用
				$arrOrderEdis = $htmlApifind->OrderEdis($date16);//クラスを使用

				//$arrOrderEdis完成

				//$StockProductsスタート

				$StockProducts = $this->RironStockProducts->find()//月末在庫呼び出し
				->where(['date_culc >=' => $day, 'date_culc <=' => $day])
				//->where(['date_culc >=' => $day, 'date_culc <=' => $dateend])
				->order(["date_culc"=>"ASC"])->toArray();

					$arrStockProducts = array();
					for($k=0; $k<count($StockProducts); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'customer_code like' => '2%'])->toArray();//productsの絞込みdnp

						if(isset($Product[0])){

							if(!isset($StockProducts[$k]["date_culc"])){
								$StockProducts[$k]["date_culc"] = $StockProducts[$k]["date_stock"];
							}

							$arrStockProducts[] = [
								'product_code' => $StockProducts[$k]["product_code"],
								'date_stock' => $StockProducts[$k]["date_culc"],
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

					//$StockProducts完成

					//$SyoyouKeikakusスタート

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0])
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrSyoyouKeikakus = array();
				for($k=0; $k<count($SyoyouKeikakus); $k++){

			//		$Product = $this->Products->find()->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'status' => 0])->toArray();//productsの絞込み　primary
					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'products.status' => 0, 'customer_code like' => '2%'])->toArray();

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

				//$SyoyouKeikakus完成

				//$arrSeisansスタート

				$daystart = $datestart." 08:00:00";
				$dayfin = $dateend." 07:59:59";

				$KadouSeikeis = $this->KadouSeikeis->find()//生産数呼び出し
				->where(['starting_tm >=' => $daystart, 'starting_tm <=' => $dayfin])
				->order(["starting_tm"=>"ASC"])->toArray();

					$arrSeisans = array();
					for($k=0; $k<count($KadouSeikeis); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $KadouSeikeis[$k]["product_code"], 'products.status' => 0, 'customer_code like' => '2%'])->toArray();//productsの絞込みdnp

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
						 $LabelSetikkatsu1 = $this->LabelSetikkatsues->find()->where(['product_id1' => $KadouSeikeis[$k]['product_code'], 'kind_set_assemble' => 0])->toArray();
						 $LabelSetikkatsu2 = $this->LabelSetikkatsues->find()->where(['product_id2' => $KadouSeikeis[$k]['product_code'], 'kind_set_assemble' => 0])->toArray();

						 if(isset($LabelSetikkatsu1[0])){

							 $arrSeisans[] = [
									'dateseikei' => $nippouday,
									'product_code' => $LabelSetikkatsu1[0]["product_id2"],
									'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
									'torisu' => $torisu
							 ];

						 }elseif(isset($LabelSetikkatsu2[0])){

							 $arrSeisans[] = [
									'dateseikei' => $nippouday,
									'product_code' => $LabelSetikkatsu2[0]["product_id1"],
									'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
									'torisu' => $torisu
							 ];

						 }

						}

					}

					$StockInoutWorklogs = $this->StockInoutWorklogs->find()//仕入れ数の呼出
					->where(['date_work >=' => $datestart, 'date_work <=' => $dateendnext, 'outsource_code !=' => 22])
					->order(["date_work"=>"ASC"])->toArray();

					for($k=0; $k<count($StockInoutWorklogs); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'products.status' => 0, 'customer_code like' => '2%'])->toArray();//productsの絞込みdnp

						$NonKadouSeikeis = $this->NonKadouSeikeis->find()->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'outsource_handy_id' => $StockInoutWorklogs[$k]["outsource_code"], 'status' => 0, 'delete_flag' => 0])->toArray();

						if(isset($Product[0]) && !isset($NonKadouSeikeis[0])){

							$arrSeisans[] = [
								'dateseikei' => $StockInoutWorklogs[$k]["date_work"]->format('Y/m/d'),
								'product_code' => $StockInoutWorklogs[$k]["product_code"],
								'amount_shot' => $StockInoutWorklogs[$k]["amount"],
								'torisu' => 1
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

					//$arrSeisans完成

			}elseif($sheet === "sinsei"){

				//$arrProductsmotoスタート

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0,
				'OR' => [['product_code like' => 'W0602%'], ['product_code like' => 'P160K%'], ['product_code like' => 'P12%']]])->toArray();
				if(!isset($_SESSION)){
				session_start();
				}
				$_SESSION['classarrProducts'] = array();
				$_SESSION['classarrProducts'] = $arrProducts;

				$htmlApifind = new htmlApifind();//クラスを使用
				$arrProductsmoto = $htmlApifind->Productsmoto($date16);//クラスを使用

				//$arrProductsmoto完成

				//$arrResultZensuHeadsmotoスタート

				$_SESSION['classarrdatestart'] = array();
				$_SESSION['classarrdatestart'] = $datestart;

				$htmlApifind = new htmlApifind();//クラスを使用
				$arrResultZensuHeadsmoto = $htmlApifind->ResultZensuHeadsmoto($dateend);//クラスを使用

				//$arrResultZensuHeadsmoto完成

				//$arrAssembleProductsスタート

				$arrAssembleProducts = array();//ここから組立品
				for($l=0; $l<count($arrResultZensuHeadsmoto); $l++){

					$AssembleProducts = $this->AssembleProducts->find()->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

					if(isset($AssembleProducts[0])){//AssembleProductsが存在する場合//組立

						$OrderEdisAssemble = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
						->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0,
						'OR' => [['product_code like' => 'W0602%'], ['product_code like' => 'P160K%'], ['product_code like' => 'P12%']]])//productsの絞込みsinsei
						->order(["date_deliver"=>"ASC"])->toArray();

						if(isset($OrderEdisAssemble[0])){

							$Konpou = $this->Konpous->find()->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"]])->toArray();
							$irisu = $Konpou[0]->irisu;//製品の入数を取得

							$amount = $irisu * $arrResultZensuHeadsmoto[$l]["count"];//入数をかけてamountを取得

							 $arrAssembleProducts[] = [//配列$arrAssembleProductsに追加
								 'product_code' => $arrResultZensuHeadsmoto[$l]["product_code"],
								 'kensabi' => $arrResultZensuHeadsmoto[$l]["datetime_finish"],
								 'amount' => $amount
							];

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

				//$arrAssembleProducts完成

				//$arrOrderEdisスタート

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0,
				'OR' => [['product_code like' => 'W0602%'], ['product_code like' => 'P160K%'], ['product_code like' => 'P12%']]])//productsの絞込みsinsei
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'status' => 0])->toArray();//productsの絞込み　primary

					if(isset($Product[0])){

						$product_name = $Product[0]->product_name;

							$arrOrderEdis[] = [
								'date_order' => $OrderEdis[$k]["date_order"],
								'num_order' => $OrderEdis[$k]["num_order"],
								'product_code' => $OrderEdis[$k]["product_code"],
								'product_name' => $product_name,
								'price' => $OrderEdis[$k]["price"],
								'date_deliver' => $OrderEdis[$k]["date_deliver"],
								'amount' => $OrderEdis[$k]["amount"],
								'denpyoumaisu' => 1
						 ];

						 for($l=0; $l<count($arrProductsmoto); $l++){

							 if($arrProductsmoto[$l]["product_code"] === $OrderEdis[$k]["product_code"]){

								 unset($arrProductsmoto[$l]);
								 $arrProductsmoto = array_values($arrProductsmoto);

							 }

						}

					}

				}

				if(!isset($_SESSION)){
				session_start();
				}
				$_SESSION['classarrProductsmoto'] = array();
				$_SESSION['classarrProductsmoto'] = $arrProductsmoto;
				$_SESSION['classOrderEdis'] = array();
				$_SESSION['classOrderEdis'] = $OrderEdis;
				$_SESSION['classarrOrderEdis'] = array();
				$_SESSION['classarrOrderEdis'] = $arrOrderEdis;

				//OrderEdisクラス使用
				$htmlApifind = new htmlApifind();//クラスを使用
				$arrOrderEdis = $htmlApifind->OrderEdis($date16);//クラスを使用

				//$arrOrderEdis完成

				//$StockProductsスタート

				$StockProducts = $this->RironStockProducts->find()//月末在庫呼び出し
				->where(['date_culc >=' => $day, 'date_culc <=' => $day,
				//->where(['date_culc >=' => $day, 'date_culc <=' => $dateend,
				'OR' => [['product_code like' => 'W0602%'], ['product_code like' => 'P160K%'], ['product_code like' => 'P12%']]])//productsの絞込みsinsei
				->order(["date_culc"=>"ASC"])->toArray();

					$arrStockProducts = array();
					for($k=0; $k<count($StockProducts); $k++){

						$Product = $this->Products->find()->where(['product_code' => $StockProducts[$k]["product_code"], 'status' => 0])->toArray();//productsの絞込みsinsei

						if(isset($Product[0])){

							if(!isset($StockProducts[$k]["date_culc"])){
								$StockProducts[$k]["date_culc"] = $StockProducts[$k]["date_stock"];
							}

							$arrStockProducts[] = [
								'product_code' => $StockProducts[$k]["product_code"],
								'date_stock' => $StockProducts[$k]["date_culc"],
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

					//$StockProducts完成

					//$SyoyouKeikakusスタート

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0,
				'OR' => [['product_code like' => 'W0602%'], ['product_code like' => 'P160K%'], ['product_code like' => 'P12%']]])//productsの絞込みsinsei
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

				//$SyoyouKeikakus完成

				//$arrSeisansスタート

				$daystart = $datestart." 08:00:00";
				$dayfin = $dateend." 07:59:59";

				$KadouSeikeis = $this->KadouSeikeis->find()//生産数呼び出し
				->where(['starting_tm >=' => $daystart, 'starting_tm <=' => $dayfin,
				'OR' => [['product_code like' => 'W0602%'], ['product_code like' => 'P160K%'], ['product_code like' => 'P12%']]])//productsの絞込みsinsei
				->order(["starting_tm"=>"ASC"])->toArray();

					$arrSeisans = array();
					for($k=0; $k<count($KadouSeikeis); $k++){

						$Product = $this->Products->find()->where(['product_code' => $KadouSeikeis[$k]["product_code"], 'status' => 0])->toArray();//productsの絞込みsinsei

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
						 $LabelSetikkatsu1 = $this->LabelSetikkatsues->find()->where(['product_id1' => $KadouSeikeis[$k]['product_code'], 'kind_set_assemble' => 0])->toArray();
						 $LabelSetikkatsu2 = $this->LabelSetikkatsues->find()->where(['product_id2' => $KadouSeikeis[$k]['product_code'], 'kind_set_assemble' => 0])->toArray();

						 if(isset($LabelSetikkatsu1[0])){

							 $arrSeisans[] = [
									'dateseikei' => $nippouday,
									'product_code' => $LabelSetikkatsu1[0]["product_id2"],
									'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
									'torisu' => $torisu
							 ];

						 }elseif(isset($LabelSetikkatsu2[0])){

							 $arrSeisans[] = [
									'dateseikei' => $nippouday,
									'product_code' => $LabelSetikkatsu2[0]["product_id1"],
									'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
									'torisu' => $torisu
							 ];

						 }

						}

					}

					$StockInoutWorklogs = $this->StockInoutWorklogs->find()//仕入れ数の呼出
					->where(['date_work >=' => $datestart, 'date_work <=' => $dateendnext, 'outsource_code !=' => 22,
					'OR' => [['product_code like' => 'W0602%'], ['product_code like' => 'P160K%'], ['product_code like' => 'P12%']]])//productsの絞込みsinsei
					->order(["date_work"=>"ASC"])->toArray();

					for($k=0; $k<count($StockInoutWorklogs); $k++){

						$Product = $this->Products->find()->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'status' => 0])->toArray();//productsの絞込みsinsei

						$NonKadouSeikeis = $this->NonKadouSeikeis->find()->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'outsource_handy_id' => $StockInoutWorklogs[$k]["outsource_code"], 'status' => 0, 'delete_flag' => 0])->toArray();

						if(isset($Product[0]) && !isset($NonKadouSeikeis[0])){

							$arrSeisans[] = [
								'dateseikei' => $StockInoutWorklogs[$k]["date_work"]->format('Y/m/d'),
								'product_code' => $StockInoutWorklogs[$k]["product_code"],
								'amount_shot' => $StockInoutWorklogs[$k]["amount"],
								'torisu' => 1
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

					//$arrSeisans完成

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
