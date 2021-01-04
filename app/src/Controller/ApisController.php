<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

use Cake\Routing\Router;//urlの取得

class ApisController extends AppController
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
//		 $this->belongsTo('Customers');
		}

		public function xmlday()
		{
		//	$day = substr(Router::reverse($this->request, false), -14, 10);//urlの取得（use Cake\Routing\Routerが必要）
			$data = Router::reverse($this->request, false);
			$urlarr = explode("/",$data);//切り離し
			$dayarr = explode(".",$urlarr[4]);//切り離し
			$day = $dayarr[0];
			/*
			echo "<pre>";
			print_r($daya);
			echo "</pre>";
*/
			$date1d = $day." 08:00:00";
			$date1d0 = strtotime($date1d);
			$date1d0 = date('Y-m-d', strtotime('+1 day', $date1d0));
			$date1d0 = $date1d0." 07:59:59";

			$ScheduleKouteis = $this->ScheduleKouteis->find()
			->where(['datetime >=' => $date1d, 'datetime <=' => $date1d0])->toArray();

			if(isset($ScheduleKouteis[0])){

        foreach($ScheduleKouteis as $key => $row ) {
          $tmp_seikeiki[$key] = $row["seikeiki"];
          $tmp_datetime[$key] = $row["datetime"];
        }

				array_multisort($tmp_seikeiki, SORT_ASC, $tmp_datetime, SORT_ASC, $ScheduleKouteis);

				$time = $ScheduleKouteis[0]->datetime->format('H:i');

			}

			$arrScheduleKoutei_csv = array();
			for($k=0; $k<count($ScheduleKouteis); $k++){

				$Product = $this->Products->find()->where(['product_code' => $ScheduleKouteis[$k]["product_code"]])->toArray();
				$product_name = $Product[0]->product_name;
	 //			$product_name = mb_convert_encoding($Product[0]->product_name, 'SJIS-win', 'UTF-8');//UTF-8の文字列をSJIS-winに変更する

				$arrScheduleKoutei_csv[] = [
					'seikeiki' => $ScheduleKouteis[$k]["seikeiki"]."号機",
					'time' => $ScheduleKouteis[$k]->datetime->format('H:i'),
					'product_code' => $ScheduleKouteis[$k]["product_code"],
					'product_name' => $product_name,
					'tantou' => $ScheduleKouteis[$k]["tantou"]."　"
			 ];

			}
/*
			$this->set([
				'sample_list1' => $arrScheduleKoutei_csv,
				'sample_list2' => array("id" => "aaa"),
				'_serialize' => ['sample_list1', 'sample_list2']
			]);
*/
			$this->set([
					'sample_list' => $arrScheduleKoutei_csv,
					'_serialize' => ['sample_list']
			]);

		}

		public function xmlweek()
		{
			$data = Router::reverse($this->request, false);
			$urlarr = explode("/",$data);//切り離し
			$dayarr = explode(".",$urlarr[4]);//切り離し
			$day = $dayarr[0];

			$date1w = $day." 08:00:00";
			$date1w0 = strtotime($date1w);
			$date1w0 = date('Y-m-d', strtotime('+7 day', $date1w0));
			$date1w0 = $date1w0." 07:59:59";

			$ScheduleKouteis = $this->ScheduleKouteis->find()
			->where(['datetime >=' => $date1w, 'datetime <=' => $date1w0])->order(["datetime"=>"ASC"])->toArray();

			for($k=0; $k<count($ScheduleKouteis); $k++){

				$day = $ScheduleKouteis[$k]->datetime->format('Y-m-j');
				$ScheduleKouteis[$k]['present_kensahyou'] = $day;

			}

			if(isset($ScheduleKouteis[0])){

        foreach($ScheduleKouteis as $key => $row ) {
					$tmp_day[$key] = $row["present_kensahyou"];
					$tmp_seikeiki[$key] = $row["seikeiki"];
        }

				array_multisort(array_map( "strtotime", $tmp_day ), SORT_ASC, $tmp_seikeiki, SORT_ASC, $ScheduleKouteis);
		//		array_multisort($tmp_seikeiki, SORT_ASC, $ScheduleKouteis);

				$time = $ScheduleKouteis[0]->datetime->format('H:i');

			}

			$arrScheduleKoutei_csv = array();
			for($k=0; $k<count($ScheduleKouteis); $k++){

				$Product = $this->Products->find()->where(['product_code' => $ScheduleKouteis[$k]["product_code"]])->toArray();
				if(isset($Product[0])){
					$product_name = $Product[0]->product_name;
		 //			$product_name = mb_convert_encoding($Product[0]->product_name, 'SJIS-win', 'UTF-8');//UTF-8の文字列をSJIS-winに変更する
				}else{
					$product_name = "";
				}

				$arrScheduleKoutei_csv[] = [
					'day' => $ScheduleKouteis[$k]->datetime->format('j'),//0なしの日付
					'seikeiki' => $ScheduleKouteis[$k]["seikeiki"]."号機",
					'time' => $ScheduleKouteis[$k]->datetime->format('H:i'),
					'product_code' => $ScheduleKouteis[$k]["product_code"],
					'product_name' => $product_name,
					'tantou' => $ScheduleKouteis[$k]["tantou"]."　"
			 ];

			}

			$this->set([
					'sample_list' => $arrScheduleKoutei_csv,
					'_serialize' => ['sample_list']
			]);

		}

		public function kouteihyouday()
		{
		//	$day = substr(Router::reverse($this->request, false), -14, 10);//urlの取得（use Cake\Routing\Routerが必要）
			$data = Router::reverse($this->request, false);
			$urlarr = explode("/",$data);//切り離し
			$dayarr = explode(".",$urlarr[4]);//切り離し
			$day = $dayarr[0];
			/*
			echo "<pre>";
			print_r($daya);
			echo "</pre>";
*/
			$date1d = $day." 08:00:00";
			$date1d0 = strtotime($date1d);
			$date1d0 = date('Y-m-d', strtotime('+1 day', $date1d0));
			$date1d0 = $date1d0." 07:59:59";

			$ScheduleKouteis = $this->ScheduleKouteis->find()
			->where(['datetime >=' => $date1d, 'datetime <=' => $date1d0])->toArray();

			if(isset($ScheduleKouteis[0])){

        foreach($ScheduleKouteis as $key => $row ) {
          $tmp_seikeiki[$key] = $row["seikeiki"];
          $tmp_datetime[$key] = $row["datetime"];
        }

				array_multisort($tmp_seikeiki, SORT_ASC, $tmp_datetime, SORT_ASC, $ScheduleKouteis);

				$time = $ScheduleKouteis[0]->datetime->format('H:i');

			}

			$arrScheduleKoutei_csv = array();
			for($k=0; $k<count($ScheduleKouteis); $k++){

				$Product = $this->Products->find()->where(['product_code' => $ScheduleKouteis[$k]["product_code"]])->toArray();
				if(isset($Product[0])){
					$product_name = $Product[0]->product_name;
		 //			$product_name = mb_convert_encoding($Product[0]->product_name, 'SJIS-win', 'UTF-8');//UTF-8の文字列をSJIS-winに変更する
				}else{
					$product_name = "　";
				}

				$arrScheduleKoutei_csv[] = [
					'seikeiki' => $ScheduleKouteis[$k]["seikeiki"]."号機",
					'time' => $ScheduleKouteis[$k]->datetime->format('H:i'),
					'product_code' => $ScheduleKouteis[$k]["product_code"],
					'product_name' => $product_name,
					'tantou' => $ScheduleKouteis[$k]["tantou"]."　"
			 ];

			}
/*
			$this->set([
				'sample_list1' => $arrScheduleKoutei_csv,
				'sample_list2' => array("id" => "aaa"),
				'_serialize' => ['sample_list1', 'sample_list2']
			]);
*/
			$this->set([
					'sample_list' => $arrScheduleKoutei_csv,
					'_serialize' => ['sample_list']
			]);

		}

		public function kouteihyouweek()
		{
			$data = Router::reverse($this->request, false);
			$urlarr = explode("/",$data);//切り離し
			$dayarr = explode(".",$urlarr[4]);//切り離し
			$day = $dayarr[0];

			$date1w = $day." 08:00:00";
			$date1w0 = strtotime($date1w);
			$date1w0 = date('Y-m-d', strtotime('+7 day', $date1w0));
			$date1w0 = $date1w0." 07:59:59";

			$ScheduleKouteis = $this->ScheduleKouteis->find()
			->where(['datetime >=' => $date1w, 'datetime <=' => $date1w0])->order(["datetime"=>"ASC"])->toArray();

			for($k=0; $k<count($ScheduleKouteis); $k++){

				$day = $ScheduleKouteis[$k]->datetime->format('Y-m-j');
				$ScheduleKouteis[$k]['present_kensahyou'] = $day;

			}

			if(isset($ScheduleKouteis[0])){

        foreach($ScheduleKouteis as $key => $row ) {
					$tmp_day[$key] = $row["present_kensahyou"];
					$tmp_seikeiki[$key] = $row["seikeiki"];
        }

				array_multisort(array_map( "strtotime", $tmp_day ), SORT_ASC, $tmp_seikeiki, SORT_ASC, $ScheduleKouteis);
		//		array_multisort($tmp_seikeiki, SORT_ASC, $ScheduleKouteis);

				$time = $ScheduleKouteis[0]->datetime->format('H:i');

			}

			$arrScheduleKoutei_csv = array();
			for($k=0; $k<count($ScheduleKouteis); $k++){

				$Product = $this->Products->find()->where(['product_code' => $ScheduleKouteis[$k]["product_code"]])->toArray();
				if(isset($Product[0])){
					$product_name = $Product[0]->product_name;
		 //			$product_name = mb_convert_encoding($Product[0]->product_name, 'SJIS-win', 'UTF-8');//UTF-8の文字列をSJIS-winに変更する
				}else{
					$product_name = "　";
				}

				$arrScheduleKoutei_csv[] = [
					'day' => $ScheduleKouteis[$k]->datetime->format('j'),//0なしの日付
					'seikeiki' => $ScheduleKouteis[$k]["seikeiki"]."号機",
					'time' => $ScheduleKouteis[$k]->datetime->format('H:i'),
					'product_code' => $ScheduleKouteis[$k]["product_code"],
					'product_name' => $product_name,
					'tantou' => $ScheduleKouteis[$k]["tantou"]."　"
			 ];

			}

			$this->set([
					'sample_list' => $arrScheduleKoutei_csv,
					'_serialize' => ['sample_list']
			]);

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

			$day = $dayarr[0];//日付の取得

			//http://192.168.4.246/Apis/zaikocyou/api/2020-10_primary.xml
			//http://localhost:5000/Apis/zaikocyou/api/2020-10_primary.xml

			if($sheet === "primary"){

				$date1 = $day."-1";//選択した月の初日
				$date1st = strtotime($date1);
				$datenext1 = date('Y-m-d', strtotime('+1 month', $date1st));//選択した月の次の月の初日
				$datelast = strtotime($datenext1);
				$datelast = date('Y-m-d', strtotime('-1 day', $datelast));//選択した月の最後の日
				$dateback1 = date('Y-m-d', strtotime('-1 month', $date1st));//選択した月の前の月の初日
				$dateback = strtotime($dateback1);
				$datebacklast = date('Y-m-d', strtotime('-1 day', $date1st));//選択した月の前の月の最後の日

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'primary_p' => 1,
				'OR' => [['product_code like' => 'P%'], ['product_code like' => 'AR%']]])->toArray();

				$arrProductsmoto = array();
				for($k=0; $k<count($arrProducts); $k++){

					$arrProductsmoto[] = [
						'date_order' => "",
						'num_order' => "",
						'product_code' => $arrProducts[$k]["product_code"],
						'product_name' => $arrProducts[$k]["product_name"],
						'price' => "",
						'date_deliver' => "",
						'amount' => "",
						'denpyoumaisu' => ""
				 ];

				}

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0,
				'OR' => [['product_code like' => 'P%'], ['product_code like' => 'AR%']]])//productsの絞込み　primary
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
				$arrAssembleProducts = array();

				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'status' => 0, 'primary_p' => 1])->toArray();//productsの絞込み　primary

					if(isset($Product[0])){

						$product_name = $Product[0]->product_name;
			//			$product_name = mb_convert_encoding($Product[0]->product_name, 'SJIS-win', 'UTF-8');//UTF-8の文字列をSJIS-winに変更する

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

						 //組立品呼び出し
	 					$AssembleProducts = $this->AssembleProducts->find()->where(['child_pid' => $OrderEdis[$k]["product_code"], 'flag' => 0])->toArray();

	 					if(isset($AssembleProducts[0])){

	 							$arrAssembleProducts[] = [
	 								'product_code' => $AssembleProducts[0]["product_code"],
	 								'inzu' => $AssembleProducts[0]["inzu"]
	 						 ];

	 					}

					}

				}

				//同一のproduct_code、date_deliverの注文は一つにまとめ、amountとdenpyoumaisuを更新
				for($l=0; $l<count($arrOrderEdis); $l++){

					for($m=$l+1; $m<count($arrOrderEdis); $m++){

						if($arrOrderEdis[$l]["product_code"] == $arrOrderEdis[$m]["product_code"] && $arrOrderEdis[$l]["date_deliver"] == $arrOrderEdis[$m]["date_deliver"]){
/*
							echo "<pre>";
							print_r("同一です".$arrOrderEdis[$m]["product_code"]." ".$arrOrderEdis[$l]["amount"]." + ".$arrOrderEdis[$m]["amount"]);
							echo "</pre>";
*/
							$amount = $arrOrderEdis[$l]["amount"] + $arrOrderEdis[$m]["amount"];
							$denpyoumaisu = $arrOrderEdis[$l]["denpyoumaisu"] + 1;

							$arrOrderEdis[$l]["amount"] = $amount;
							$arrOrderEdis[$l]["denpyoumaisu"] = $denpyoumaisu;

							unset($arrOrderEdis[$m]);
							$arrOrderEdis = array_values($arrOrderEdis);

						}

					}

				}

				$arrOrderEdis = array_merge($arrOrderEdis, $arrProductsmoto);

				//並べかえ
				$tmp_product_array = array();
				$tmp_date_deliver_array = array();
				foreach($arrOrderEdis as $key => $row ) {
					$tmp_product_array[$key] = $row["product_code"];
					$tmp_date_deliver_array[$key] = $row["date_deliver"];
				}

				if(count($OrderEdis) > 0){
					array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_deliver_array ), SORT_ASC, SORT_NUMERIC, $arrOrderEdis);
				}

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
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast,
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
/*
					echo "<pre>";
					var_dump($tmp_product_array);
					echo "</pre>";
					echo "<pre>";
					var_dump($tmp_dateseikei_array);
					echo "</pre>";
*/
			}elseif($sheet === "primary_dnp"){

				$date1 = $day."-1";//選択した月の初日
				$date1st = strtotime($date1);
				$datenext1 = date('Y-m-d', strtotime('+1 month', $date1st));//選択した月の次の月の初日
				$datelast = strtotime($datenext1);
				$datelast = date('Y-m-d', strtotime('-1 day', $datelast));//選択した月の最後の日
				$dateback1 = date('Y-m-d', strtotime('-1 month', $date1st));//選択した月の前の月の初日
				$dateback = strtotime($dateback1);
				$datebacklast = date('Y-m-d', strtotime('-1 day', $date1st));//選択した月の前の月の最後の日

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'primary_p' => 1,
				'OR' => [['customer_code like' => '2%']]])->toArray();

				$arrProductsmoto = array();
				for($k=0; $k<count($arrProducts); $k++){

					$arrProductsmoto[] = [
						'date_order' => "",
						'num_order' => "",
						'product_code' => $arrProducts[$k]["product_code"],
						'product_name' => $arrProducts[$k]["product_name"],
						'price' => "",
						'date_deliver' => "",
						'amount' => "",
						'denpyoumaisu' => ""
				 ];

				}

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0,
				'OR' => [['customer_code like' => '2%']]])//productsの絞込みprimary_dnp
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
				$arrAssembleProducts = array();
				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $OrderEdis[$k]["product_code"], 'products.status' => 0, 'primary_p' => 1, 'customer_code like' => '2%'])->toArray();//productsの絞込みprimary_dnp

					if(isset($Product[0])){

						$product_name = $Product[0]->product_name;
			//			$product_name = mb_convert_encoding($Product[0]->product_name, 'SJIS-win', 'UTF-8');//UTF-8の文字列をSJIS-winに変更する

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

						 //組立品呼び出し
	 					$AssembleProducts = $this->AssembleProducts->find()->where(['child_pid' => $OrderEdis[$k]["product_code"], 'flag' => 0])->toArray();

	 					if(isset($AssembleProducts[0])){

	 							$arrAssembleProducts[] = [
	 								'product_code' => $AssembleProducts[0]["product_code"],
	 								'inzu' => $AssembleProducts[0]["inzu"]
	 						 ];

	 					}

					}

				}
				//同一のproduct_code、date_deliverの注文は一つにまとめ、amountとdenpyoumaisuを更新
				for($l=0; $l<count($arrOrderEdis); $l++){

					for($m=$l+1; $m<count($arrOrderEdis); $m++){

						if($arrOrderEdis[$l]["product_code"] == $arrOrderEdis[$m]["product_code"] && $arrOrderEdis[$l]["date_deliver"] == $arrOrderEdis[$m]["date_deliver"]){
/*
							echo "<pre>";
							print_r("同一です".$arrOrderEdis[$m]["product_code"]." ".$arrOrderEdis[$l]["amount"]." + ".$arrOrderEdis[$m]["amount"]);
							echo "</pre>";
*/
							$amount = $arrOrderEdis[$l]["amount"] + $arrOrderEdis[$m]["amount"];
							$denpyoumaisu = $arrOrderEdis[$l]["denpyoumaisu"] + 1;

							$arrOrderEdis[$l]["amount"] = $amount;
							$arrOrderEdis[$l]["denpyoumaisu"] = $denpyoumaisu;

							unset($arrOrderEdis[$m]);
							$arrOrderEdis = array_values($arrOrderEdis);

						}

					}

				}

				$arrOrderEdis = array_merge($arrOrderEdis, $arrProductsmoto);

/*
				for($j=0; $j<count($arrProducts); $j++){

					for($k=0; $k<count($OrderEdis); $k++){

						if($arrProducts[$j]["product_code"] === $OrderEdis[$k]["product_code"]){

							$product_name = $Product[0]->product_name;
				//			$product_name = mb_convert_encoding($Product[0]->product_name, 'SJIS-win', 'UTF-8');//UTF-8の文字列をSJIS-winに変更する

							$arrOrderEdis[] = [
								'date_order' => "",
								'num_order' => "",
								'product_code' => $arrProducts[$j]["product_code"],
								'product_name' => $product_name,
								'price' => "",
								'date_deliver' => "",
								'amount' => ""
						 ];

						}

					}

				}
*/

				//並べかえ
				$tmp_product_array = array();
				$tmp_date_deliver_array = array();
				foreach($arrOrderEdis as $key => $row ) {
					$tmp_product_array[$key] = $row["product_code"];
					$tmp_date_deliver_array[$key] = $row["date_deliver"];
				}

				if(count($OrderEdis) > 0){
					array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_deliver_array ), SORT_ASC, SORT_NUMERIC, $arrOrderEdis);
				}
/*
				echo "<pre>";
				print_r($arrOrderEdis);
				echo "</pre>";
*/
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
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast])
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrSyoyouKeikakus = array();
				for($k=0; $k<count($SyoyouKeikakus); $k++){

					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'products.status' => 0, 'primary_p' => 1, 'customer_code like' => '2%'])->toArray();//productsの絞込みprimary_dnp

					if(isset($Product[0])){

						$arrSyoyouKeikakus[] = [
							'product_code' => $SyoyouKeikakus[$k]["product_code"],
							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
							'amount' => $SyoyouKeikakus[$k]["amount"]
					 ];

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

							if(substr($KadouSeikeis[$k]['starting_tm'], 10, 2) < 8){
								$starting_tm = strtotime($starting_tm);
								$nippouday = date('Y-m-d', strtotime('-1 day', $starting_tm));
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

				$date1 = $day."-1";//選択した月の初日
				$date1st = strtotime($date1);
				$datenext1 = date('Y-m-d', strtotime('+1 month', $date1st));//選択した月の次の月の初日
				$datelast = strtotime($datenext1);
				$datelast = date('Y-m-d', strtotime('-1 day', $datelast));//選択した月の最後の日
				$dateback1 = date('Y-m-d', strtotime('-1 month', $date1st));//選択した月の前の月の初日
				$dateback = strtotime($dateback1);
				$datebacklast = date('Y-m-d', strtotime('-1 day', $date1st));//選択した月の前の月の最後の日

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'primary_p' => 1, 'customer_code' => '10002',
				'OR' => [['product_code like' => 'W%', 'product_code like' => 'AW%']]])->toArray();

				$arrProductsmoto = array();
				for($k=0; $k<count($arrProducts); $k++){

					$arrProductsmoto[] = [
						'date_order' => "",
						'num_order' => "",
						'product_code' => $arrProducts[$k]["product_code"],
						'product_name' => $arrProducts[$k]["product_name"],
						'price' => "",
						'date_deliver' => "",
						'amount' => "",
						'denpyoumaisu' => ""
				 ];

				}

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0, 'customer_code' => '10002',
				'OR' => [['product_code like' => 'W%', 'product_code like' => 'AW%']]])//productsの絞込みprimary_w
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
				$arrAssembleProducts = array();
				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $OrderEdis[$k]["product_code"], 'products.status' => 0, 'primary_p' => 1, 'customer_code' => '10002'])->toArray();//productsの絞込みprimary_w

					if(isset($Product[0])){

						$product_name = $Product[0]->product_name;
			//			$product_name = mb_convert_encoding($Product[0]->product_name, 'SJIS-win', 'UTF-8');//UTF-8の文字列をSJIS-winに変更する

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

						 //組立品呼び出し
	 					$AssembleProducts = $this->AssembleProducts->find()->where(['child_pid' => $OrderEdis[$k]["product_code"], 'flag' => 0])->toArray();

	 					if(isset($AssembleProducts[0])){

	 							$arrAssembleProducts[] = [
	 								'product_code' => $AssembleProducts[0]["product_code"],
	 								'inzu' => $AssembleProducts[0]["inzu"]
	 						 ];

	 					}

					}

				}

				//同一のproduct_code、date_deliverの注文は一つにまとめ、amountとdenpyoumaisuを更新
				for($l=0; $l<count($arrOrderEdis); $l++){

					for($m=$l+1; $m<count($arrOrderEdis); $m++){

						if($arrOrderEdis[$l]["product_code"] == $arrOrderEdis[$m]["product_code"] && $arrOrderEdis[$l]["date_deliver"] == $arrOrderEdis[$m]["date_deliver"]){
/*
							echo "<pre>";
							print_r("同一です".$arrOrderEdis[$m]["product_code"]." ".$arrOrderEdis[$l]["amount"]." + ".$arrOrderEdis[$m]["amount"]);
							echo "</pre>";
*/
							$amount = $arrOrderEdis[$l]["amount"] + $arrOrderEdis[$m]["amount"];
							$denpyoumaisu = $arrOrderEdis[$l]["denpyoumaisu"] + 1;

							$arrOrderEdis[$l]["amount"] = $amount;
							$arrOrderEdis[$l]["denpyoumaisu"] = $denpyoumaisu;

							unset($arrOrderEdis[$m]);
							$arrOrderEdis = array_values($arrOrderEdis);

						}

					}

				}

				$arrOrderEdis = array_merge($arrOrderEdis, $arrProductsmoto);

				//並べかえ
				$tmp_product_array = array();
				$tmp_date_deliver_array = array();
				foreach($arrOrderEdis as $key => $row ) {
					$tmp_product_array[$key] = $row["product_code"];
					$tmp_date_deliver_array[$key] = $row["date_deliver"];
				}

				if(count($OrderEdis) > 0){
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
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast,
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みprimary_w
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrSyoyouKeikakus = array();
				for($k=0; $k<count($SyoyouKeikakus); $k++){

					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'products.status' => 0, 'primary_p' => 1, 'customer_code' => '10002'])->toArray();//productsの絞込みprimary_w

					if(isset($Product[0])){

						$arrSyoyouKeikakus[] = [
							'product_code' => $SyoyouKeikakus[$k]["product_code"],
							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
							'amount' => $SyoyouKeikakus[$k]["amount"]
					 ];

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

							if(substr($KadouSeikeis[$k]['starting_tm'], 10, 2) < 8){
								$starting_tm = strtotime($starting_tm);
								$nippouday = date('Y-m-d', strtotime('-1 day', $starting_tm));
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

				$date1 = $day."-1";//選択した月の初日
				$date1st = strtotime($date1);
				$datenext1 = date('Y-m-d', strtotime('+1 month', $date1st));//選択した月の次の月の初日
				$datelast = strtotime($datenext1);
				$datelast = date('Y-m-d', strtotime('-1 day', $datelast));//選択した月の最後の日
				$dateback1 = date('Y-m-d', strtotime('-1 month', $date1st));//選択した月の前の月の初日
				$dateback = strtotime($dateback1);
				$datebacklast = date('Y-m-d', strtotime('-1 day', $date1st));//選択した月の前の月の最後の日

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'customer_code' => '10002',
				'OR' => [['product_code like' => 'H%']]])->toArray();

				$arrProductsmoto = array();
				for($k=0; $k<count($arrProducts); $k++){

					$arrProductsmoto[] = [
						'date_order' => "",
						'num_order' => "",
						'product_code' => $arrProducts[$k]["product_code"],
						'product_name' => $arrProducts[$k]["product_name"],
						'price' => "",
						'date_deliver' => "",
						'amount' => "",
						'denpyoumaisu' => ""
				 ];

				}

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0, 'customer_code' => '10002',
				'OR' => [['product_code like' => 'H%']]])//productsの絞込みprimary_h
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
				$arrAssembleProducts = array();
				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $OrderEdis[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10002'])->toArray();//productsの絞込みprimary_h

					if(isset($Product[0])){

						$product_name = $Product[0]->product_name;
			//			$product_name = mb_convert_encoding($Product[0]->product_name, 'SJIS-win', 'UTF-8');//UTF-8の文字列をSJIS-winに変更する

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

						 //組立品呼び出し
	 					$AssembleProducts = $this->AssembleProducts->find()->where(['child_pid' => $OrderEdis[$k]["product_code"], 'flag' => 0])->toArray();

	 					if(isset($AssembleProducts[0])){

	 							$arrAssembleProducts[] = [
	 								'product_code' => $AssembleProducts[0]["product_code"],
	 								'inzu' => $AssembleProducts[0]["inzu"]
	 						 ];

	 					}

					}

				}

				//同一のproduct_code、date_deliverの注文は一つにまとめ、amountとdenpyoumaisuを更新
				for($l=0; $l<count($arrOrderEdis); $l++){

					for($m=$l+1; $m<count($arrOrderEdis); $m++){

						if($arrOrderEdis[$l]["product_code"] == $arrOrderEdis[$m]["product_code"] && $arrOrderEdis[$l]["date_deliver"] == $arrOrderEdis[$m]["date_deliver"]){
/*
							echo "<pre>";
							print_r("同一です".$arrOrderEdis[$m]["product_code"]." ".$arrOrderEdis[$l]["amount"]." + ".$arrOrderEdis[$m]["amount"]);
							echo "</pre>";
*/
							$amount = $arrOrderEdis[$l]["amount"] + $arrOrderEdis[$m]["amount"];
							$denpyoumaisu = $arrOrderEdis[$l]["denpyoumaisu"] + 1;

							$arrOrderEdis[$l]["amount"] = $amount;
							$arrOrderEdis[$l]["denpyoumaisu"] = $denpyoumaisu;

							unset($arrOrderEdis[$m]);
							$arrOrderEdis = array_values($arrOrderEdis);

						}

					}

				}

				$arrOrderEdis = array_merge($arrOrderEdis, $arrProductsmoto);

				//並べかえ
				$tmp_product_array = array();
				$tmp_date_deliver_array = array();
				foreach($arrOrderEdis as $key => $row ) {
					$tmp_product_array[$key] = $row["product_code"];
					$tmp_date_deliver_array[$key] = $row["date_deliver"];
				}

				if(count($OrderEdis) > 0){
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
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast,
				'OR' => ['product_code like' => 'H%']])//productsの絞込みprimary_h
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrSyoyouKeikakus = array();
				for($k=0; $k<count($SyoyouKeikakus); $k++){

					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10002'])->toArray();//productsの絞込みprimary_h

					if(isset($Product[0])){

						$arrSyoyouKeikakus[] = [
							'product_code' => $SyoyouKeikakus[$k]["product_code"],
							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
							'amount' => $SyoyouKeikakus[$k]["amount"]
					 ];

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

							if(substr($KadouSeikeis[$k]['starting_tm'], 10, 2) < 8){
								$starting_tm = strtotime($starting_tm);
								$nippouday = date('Y-m-d', strtotime('-1 day', $starting_tm));
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

				$date1 = $day."-1";//選択した月の初日
				$date1st = strtotime($date1);
				$datenext1 = date('Y-m-d', strtotime('+1 month', $date1st));//選択した月の次の月の初日
				$datelast = strtotime($datenext1);
				$datelast = date('Y-m-d', strtotime('-1 day', $datelast));//選択した月の最後の日
				$dateback1 = date('Y-m-d', strtotime('-1 month', $date1st));//選択した月の前の月の初日
				$dateback = strtotime($dateback1);
				$datebacklast = date('Y-m-d', strtotime('-1 day', $date1st));//選択した月の前の月の最後の日

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'customer_code' => '10005'])->toArray();

				$arrProductsmoto = array();
				for($k=0; $k<count($arrProducts); $k++){

					$arrProductsmoto[] = [
						'date_order' => "",
						'num_order' => "",
						'product_code' => $arrProducts[$k]["product_code"],
						'product_name' => $arrProducts[$k]["product_name"],
						'price' => "",
						'date_deliver' => "",
						'amount' => "",
						'denpyoumaisu' => ""
				 ];

				}

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0,
				'OR' => [['customer_code' => '10005']]])//productsの絞込みreizouko
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
				$arrAssembleProducts = array();
				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $OrderEdis[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10005'])->toArray();//productsの絞込みreizouko

					if(isset($Product[0])){

						$product_name = $Product[0]->product_name;
			//			$product_name = mb_convert_encoding($Product[0]->product_name, 'SJIS-win', 'UTF-8');//UTF-8の文字列をSJIS-winに変更する

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

						 //組立品呼び出し
	 					$AssembleProducts = $this->AssembleProducts->find()->where(['child_pid' => $OrderEdis[$k]["product_code"], 'flag' => 0])->toArray();

	 					if(isset($AssembleProducts[0])){

	 							$arrAssembleProducts[] = [
	 								'product_code' => $AssembleProducts[0]["product_code"],
	 								'inzu' => $AssembleProducts[0]["inzu"]
	 						 ];

	 					}

					}

				}

				//同一のproduct_code、date_deliverの注文は一つにまとめ、amountとdenpyoumaisuを更新
				for($l=0; $l<count($arrOrderEdis); $l++){

					for($m=$l+1; $m<count($arrOrderEdis); $m++){

						if($arrOrderEdis[$l]["product_code"] == $arrOrderEdis[$m]["product_code"] && $arrOrderEdis[$l]["date_deliver"] == $arrOrderEdis[$m]["date_deliver"]){
/*
							echo "<pre>";
							print_r("同一です".$arrOrderEdis[$m]["product_code"]." ".$arrOrderEdis[$l]["amount"]." + ".$arrOrderEdis[$m]["amount"]);
							echo "</pre>";
*/
							$amount = $arrOrderEdis[$l]["amount"] + $arrOrderEdis[$m]["amount"];
							$denpyoumaisu = $arrOrderEdis[$l]["denpyoumaisu"] + 1;

							$arrOrderEdis[$l]["amount"] = $amount;
							$arrOrderEdis[$l]["denpyoumaisu"] = $denpyoumaisu;

							unset($arrOrderEdis[$m]);
							$arrOrderEdis = array_values($arrOrderEdis);

						}

					}

				}

				$arrOrderEdis = array_merge($arrOrderEdis, $arrProductsmoto);

				//並べかえ
				$tmp_product_array = array();
				$tmp_date_deliver_array = array();
				foreach($arrOrderEdis as $key => $row ) {
					$tmp_product_array[$key] = $row["product_code"];
					$tmp_date_deliver_array[$key] = $row["date_deliver"];
				}

				if(count($OrderEdis) > 0){
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
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast])
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrSyoyouKeikakus = array();
				for($k=0; $k<count($SyoyouKeikakus); $k++){

					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10005'])->toArray();//productsの絞込みreizouko

					if(isset($Product[0])){

						$arrSyoyouKeikakus[] = [
							'product_code' => $SyoyouKeikakus[$k]["product_code"],
							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
							'amount' => $SyoyouKeikakus[$k]["amount"]
					 ];

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

							if(substr($KadouSeikeis[$k]['starting_tm'], 10, 2) < 8){
								$starting_tm = strtotime($starting_tm);
								$nippouday = date('Y-m-d', strtotime('-1 day', $starting_tm));
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

				$date1 = $day."-1";//選択した月の初日
				$date1st = strtotime($date1);
				$datenext1 = date('Y-m-d', strtotime('+1 month', $date1st));//選択した月の次の月の初日
				$datelast = strtotime($datenext1);
				$datelast = date('Y-m-d', strtotime('-1 day', $datelast));//選択した月の最後の日
				$dateback1 = date('Y-m-d', strtotime('-1 month', $date1st));//選択した月の前の月の初日
				$dateback = strtotime($dateback1);
				$datebacklast = date('Y-m-d', strtotime('-1 day', $date1st));//選択した月の前の月の最後の日

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'customer_code' => '10003'])->toArray();

				$arrProductsmoto = array();
				for($k=0; $k<count($arrProducts); $k++){

					$arrProductsmoto[] = [
						'date_order' => "",
						'num_order' => "",
						'product_code' => $arrProducts[$k]["product_code"],
						'product_name' => $arrProducts[$k]["product_name"],
						'price' => "",
						'date_deliver' => "",
						'amount' => "",
						'denpyoumaisu' => ""
				 ];

				}

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0,
				'OR' => [['customer_code' => '10003']]])//productsの絞込みuwawaku
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
				$arrAssembleProducts = array();
				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $OrderEdis[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10003'])->toArray();//productsの絞込みuwawaku

					if(isset($Product[0])){

						$product_name = $Product[0]->product_name;
			//			$product_name = mb_convert_encoding($Product[0]->product_name, 'SJIS-win', 'UTF-8');//UTF-8の文字列をSJIS-winに変更する

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

						 //組立品呼び出し
	 					$AssembleProducts = $this->AssembleProducts->find()->where(['child_pid' => $OrderEdis[$k]["product_code"], 'flag' => 0])->toArray();

	 					if(isset($AssembleProducts[0])){

	 							$arrAssembleProducts[] = [
	 								'product_code' => $AssembleProducts[0]["product_code"],
	 								'inzu' => $AssembleProducts[0]["inzu"]
	 						 ];

	 					}

					}

				}

				//同一のproduct_code、date_deliverの注文は一つにまとめ、amountとdenpyoumaisuを更新
				for($l=0; $l<count($arrOrderEdis); $l++){

					for($m=$l+1; $m<count($arrOrderEdis); $m++){

						if($arrOrderEdis[$l]["product_code"] == $arrOrderEdis[$m]["product_code"] && $arrOrderEdis[$l]["date_deliver"] == $arrOrderEdis[$m]["date_deliver"]){
/*
							echo "<pre>";
							print_r("同一です".$arrOrderEdis[$m]["product_code"]." ".$arrOrderEdis[$l]["amount"]." + ".$arrOrderEdis[$m]["amount"]);
							echo "</pre>";
*/
							$amount = $arrOrderEdis[$l]["amount"] + $arrOrderEdis[$m]["amount"];
							$denpyoumaisu = $arrOrderEdis[$l]["denpyoumaisu"] + 1;

							$arrOrderEdis[$l]["amount"] = $amount;
							$arrOrderEdis[$l]["denpyoumaisu"] = $denpyoumaisu;

							unset($arrOrderEdis[$m]);
							$arrOrderEdis = array_values($arrOrderEdis);

						}

					}

				}

				$arrOrderEdis = array_merge($arrOrderEdis, $arrProductsmoto);

				//並べかえ
				$tmp_product_array = array();
				$tmp_date_deliver_array = array();
				foreach($arrOrderEdis as $key => $row ) {
					$tmp_product_array[$key] = $row["product_code"];
					$tmp_date_deliver_array[$key] = $row["date_deliver"];
				}

				if(count($OrderEdis) > 0){
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
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast])
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrSyoyouKeikakus = array();
				for($k=0; $k<count($SyoyouKeikakus); $k++){

					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10003'])->toArray();//productsの絞込みuwawaku

					if(isset($Product[0])){

						$arrSyoyouKeikakus[] = [
							'product_code' => $SyoyouKeikakus[$k]["product_code"],
							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
							'amount' => $SyoyouKeikakus[$k]["amount"]
					 ];

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

							if(substr($KadouSeikeis[$k]['starting_tm'], 10, 2) < 8){
								$starting_tm = strtotime($starting_tm);
								$nippouday = date('Y-m-d', strtotime('-1 day', $starting_tm));
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

				$date1 = $day."-1";//選択した月の初日
				$date1st = strtotime($date1);
				$datenext1 = date('Y-m-d', strtotime('+1 month', $date1st));//選択した月の次の月の初日
				$datelast = strtotime($datenext1);
				$datelast = date('Y-m-d', strtotime('-1 day', $datelast));//選択した月の最後の日
				$dateback1 = date('Y-m-d', strtotime('-1 month', $date1st));//選択した月の前の月の初日
				$dateback = strtotime($dateback1);
				$datebacklast = date('Y-m-d', strtotime('-1 day', $date1st));//選択した月の前の月の最後の日

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
		//		->where(['products.status' => 0, 'customer_code not like' => '1%', 'customer_code not like' => '2%'])->toArray();
				->where(['products.status' => 0,
				'AND' => [['customer_code not like' => '1%'], ['customer_code not like' => '2%']]])->toArray();
/*
				echo "<pre>";
				print_r($arrProducts);
				echo "</pre>";
*/
				$arrProductsmoto = array();
				for($k=0; $k<count($arrProducts); $k++){

					$arrProductsmoto[] = [
						'date_order' => "",
						'num_order' => "",
						'product_code' => $arrProducts[$k]["product_code"],
						'product_name' => $arrProducts[$k]["product_name"],
						'price' => "",
						'date_deliver' => "",
						'amount' => "",
						'denpyoumaisu' => ""
				 ];

				}

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
		//		->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0, 'customer_code not like' => '1%', 'customer_code not like' => '2%'])//productsの絞込みother
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0, 'AND' => [['customer_code not like' => '1%'], ['customer_code not like' => '2%']]])//productsの絞込みother
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
			//			$product_name = mb_convert_encoding($Product[0]->product_name, 'SJIS-win', 'UTF-8');//UTF-8の文字列をSJIS-winに変更する

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

						 //組立品呼び出し
	 					$AssembleProducts = $this->AssembleProducts->find()->where(['child_pid' => $OrderEdis[$k]["product_code"], 'flag' => 0])->toArray();

	 					if(isset($AssembleProducts[0])){

	 							$arrAssembleProducts[] = [
	 								'product_code' => $AssembleProducts[0]["product_code"],
	 								'inzu' => $AssembleProducts[0]["inzu"]
	 						 ];

	 					}

					}

				}

				//同一のproduct_code、date_deliverの注文は一つにまとめ、amountとdenpyoumaisuを更新
				for($l=0; $l<count($arrOrderEdis); $l++){

					for($m=$l+1; $m<count($arrOrderEdis); $m++){

						if($arrOrderEdis[$l]["product_code"] == $arrOrderEdis[$m]["product_code"] && $arrOrderEdis[$l]["date_deliver"] == $arrOrderEdis[$m]["date_deliver"]){
/*
							echo "<pre>";
							print_r("同一です".$arrOrderEdis[$m]["product_code"]." ".$arrOrderEdis[$l]["amount"]." + ".$arrOrderEdis[$m]["amount"]);
							echo "</pre>";
*/
							$amount = $arrOrderEdis[$l]["amount"] + $arrOrderEdis[$m]["amount"];
							$denpyoumaisu = $arrOrderEdis[$l]["denpyoumaisu"] + 1;

							$arrOrderEdis[$l]["amount"] = $amount;
							$arrOrderEdis[$l]["denpyoumaisu"] = $denpyoumaisu;

							unset($arrOrderEdis[$m]);
							$arrOrderEdis = array_values($arrOrderEdis);

						}

					}

				}

				$arrOrderEdis = array_merge($arrOrderEdis, $arrProductsmoto);

				//並べかえ
				$tmp_product_array = array();
				$tmp_date_deliver_array = array();
				foreach($arrOrderEdis as $key => $row ) {
					$tmp_product_array[$key] = $row["product_code"];
					$tmp_date_deliver_array[$key] = $row["date_deliver"];
				}

				if(count($OrderEdis) > 0){
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
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast])
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrSyoyouKeikakus = array();
				for($k=0; $k<count($SyoyouKeikakus); $k++){

					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'products.status' => 0, 'AND' => [['customer_code not like' => '1%'], ['customer_code not like' => '2%']]])//productsの絞込みother
					->toArray();//productsの絞込みother

					if(isset($Product[0])){

						$arrSyoyouKeikakus[] = [
							'product_code' => $SyoyouKeikakus[$k]["product_code"],
							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
							'amount' => $SyoyouKeikakus[$k]["amount"]
					 ];

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

							if(substr($KadouSeikeis[$k]['starting_tm'], 10, 2) < 8){
								$starting_tm = strtotime($starting_tm);
								$nippouday = date('Y-m-d', strtotime('-1 day', $starting_tm));
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

				$date1 = $day."-1";//選択した月の初日
				$date1st = strtotime($date1);
				$datenext1 = date('Y-m-d', strtotime('+1 month', $date1st));//選択した月の次の月の初日
				$datelast = strtotime($datenext1);
				$datelast = date('Y-m-d', strtotime('-1 day', $datelast));//選択した月の最後の日
				$dateback1 = date('Y-m-d', strtotime('-1 month', $date1st));//選択した月の前の月の初日
				$dateback = strtotime($dateback1);
				$datebacklast = date('Y-m-d', strtotime('-1 day', $date1st));//選択した月の前の月の最後の日

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'primary_p' => 0, 'customer_code' => '10001',
				'OR' => [['product_code like' => 'P0%']]])->toArray();

				$arrProductsmoto = array();
				for($k=0; $k<count($arrProducts); $k++){

					$arrProductsmoto[] = [
						'date_order' => "",
						'num_order' => "",
						'product_code' => $arrProducts[$k]["product_code"],
						'product_name' => $arrProducts[$k]["product_name"],
						'price' => "",
						'date_deliver' => "",
						'amount' => "",
						'denpyoumaisu' => ""
				 ];

				}

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0, 'customer_code' => '10001',
				'OR' => [['product_code like' => 'P0%']]])//productsの絞込みp0
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
				$arrAssembleProducts = array();
				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $OrderEdis[$k]["product_code"], 'products.status' => 0, 'primary_p' => 0, 'customer_code' => '10001'])->toArray();//productsの絞込みp0

					if(isset($Product[0])){

						$product_name = $Product[0]->product_name;
			//			$product_name = mb_convert_encoding($Product[0]->product_name, 'SJIS-win', 'UTF-8');//UTF-8の文字列をSJIS-winに変更する

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

						 //組立品呼び出し
	 					$AssembleProducts = $this->AssembleProducts->find()->where(['child_pid' => $OrderEdis[$k]["product_code"], 'flag' => 0])->toArray();

	 					if(isset($AssembleProducts[0])){

	 							$arrAssembleProducts[] = [
	 								'product_code' => $AssembleProducts[0]["product_code"],
	 								'inzu' => $AssembleProducts[0]["inzu"]
	 						 ];

	 					}

					}

				}

				//同一のproduct_code、date_deliverの注文は一つにまとめ、amountとdenpyoumaisuを更新
				for($l=0; $l<count($arrOrderEdis); $l++){

					for($m=$l+1; $m<count($arrOrderEdis); $m++){

						if($arrOrderEdis[$l]["product_code"] == $arrOrderEdis[$m]["product_code"] && $arrOrderEdis[$l]["date_deliver"] == $arrOrderEdis[$m]["date_deliver"]){
/*
							echo "<pre>";
							print_r("同一です".$arrOrderEdis[$m]["product_code"]." ".$arrOrderEdis[$l]["amount"]." + ".$arrOrderEdis[$m]["amount"]);
							echo "</pre>";
*/
							$amount = $arrOrderEdis[$l]["amount"] + $arrOrderEdis[$m]["amount"];
							$denpyoumaisu = $arrOrderEdis[$l]["denpyoumaisu"] + 1;

							$arrOrderEdis[$l]["amount"] = $amount;
							$arrOrderEdis[$l]["denpyoumaisu"] = $denpyoumaisu;

							unset($arrOrderEdis[$m]);
							$arrOrderEdis = array_values($arrOrderEdis);

						}

					}

				}

				$arrOrderEdis = array_merge($arrOrderEdis, $arrProductsmoto);

				//並べかえ
				$tmp_product_array = array();
				$tmp_date_deliver_array = array();
				foreach($arrOrderEdis as $key => $row ) {
					$tmp_product_array[$key] = $row["product_code"];
					$tmp_date_deliver_array[$key] = $row["date_deliver"];
				}

				if(count($OrderEdis) > 0){
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
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast,
				'OR' => ['product_code like' => 'P0%']])//productsの絞込みp0
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrSyoyouKeikakus = array();
				for($k=0; $k<count($SyoyouKeikakus); $k++){

					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'products.status' => 0, 'primary_p' => 0, 'customer_code' => '10001'])->toArray();//productsの絞込みp0

					if(isset($Product[0])){

						$arrSyoyouKeikakus[] = [
							'product_code' => $SyoyouKeikakus[$k]["product_code"],
							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
							'amount' => $SyoyouKeikakus[$k]["amount"]
					 ];

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

							if(substr($KadouSeikeis[$k]['starting_tm'], 10, 2) < 8){
								$starting_tm = strtotime($starting_tm);
								$nippouday = date('Y-m-d', strtotime('-1 day', $starting_tm));
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

				$date1 = $day."-1";//選択した月の初日
				$date1st = strtotime($date1);
				$datenext1 = date('Y-m-d', strtotime('+1 month', $date1st));//選択した月の次の月の初日
				$datelast = strtotime($datenext1);
				$datelast = date('Y-m-d', strtotime('-1 day', $datelast));//選択した月の最後の日
				$dateback1 = date('Y-m-d', strtotime('-1 month', $date1st));//選択した月の前の月の初日
				$dateback = strtotime($dateback1);
				$datebacklast = date('Y-m-d', strtotime('-1 day', $date1st));//選択した月の前の月の最後の日

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'primary_p' => 0, 'customer_code' => '10001',
				'OR' => [['product_code like' => 'P1%'], ['product_code like' => 'P2%']]])->toArray();

				$arrProductsmoto = array();
				for($k=0; $k<count($arrProducts); $k++){

					$arrProductsmoto[] = [
						'date_order' => "",
						'num_order' => "",
						'product_code' => $arrProducts[$k]["product_code"],
						'product_name' => $arrProducts[$k]["product_name"],
						'price' => "",
						'date_deliver' => "",
						'amount' => "",
						'denpyoumaisu' => ""
				 ];

				}

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0, 'customer_code' => '10001',
				'OR' => [['product_code like' => 'P1%'], ['product_code like' => 'P2%']]])//productsの絞込みp1
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
				$arrAssembleProducts = array();
				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $OrderEdis[$k]["product_code"], 'products.status' => 0, 'primary_p' => 0, 'customer_code' => '10001'])->toArray();//productsの絞込みp1

					if(isset($Product[0])){

						$product_name = $Product[0]->product_name;
			//			$product_name = mb_convert_encoding($Product[0]->product_name, 'SJIS-win', 'UTF-8');//UTF-8の文字列をSJIS-winに変更する

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

						 //組立品呼び出し
	 					$AssembleProducts = $this->AssembleProducts->find()->where(['child_pid' => $OrderEdis[$k]["product_code"], 'flag' => 0])->toArray();

	 					if(isset($AssembleProducts[0])){

	 							$arrAssembleProducts[] = [
	 								'product_code' => $AssembleProducts[0]["product_code"],
	 								'inzu' => $AssembleProducts[0]["inzu"]
	 						 ];

	 					}

					}

				}

				//同一のproduct_code、date_deliverの注文は一つにまとめ、amountとdenpyoumaisuを更新
				for($l=0; $l<count($arrOrderEdis); $l++){

					for($m=$l+1; $m<count($arrOrderEdis); $m++){

						if($arrOrderEdis[$l]["product_code"] == $arrOrderEdis[$m]["product_code"] && $arrOrderEdis[$l]["date_deliver"] == $arrOrderEdis[$m]["date_deliver"]){
/*
							echo "<pre>";
							print_r("同一です".$arrOrderEdis[$m]["product_code"]." ".$arrOrderEdis[$l]["amount"]." + ".$arrOrderEdis[$m]["amount"]);
							echo "</pre>";
*/
							$amount = $arrOrderEdis[$l]["amount"] + $arrOrderEdis[$m]["amount"];
							$denpyoumaisu = $arrOrderEdis[$l]["denpyoumaisu"] + 1;

							$arrOrderEdis[$l]["amount"] = $amount;
							$arrOrderEdis[$l]["denpyoumaisu"] = $denpyoumaisu;

							unset($arrOrderEdis[$m]);
							$arrOrderEdis = array_values($arrOrderEdis);

						}

					}

				}

				$arrOrderEdis = array_merge($arrOrderEdis, $arrProductsmoto);

				//並べかえ
				$tmp_product_array = array();
				$tmp_date_deliver_array = array();
				foreach($arrOrderEdis as $key => $row ) {
					$tmp_product_array[$key] = $row["product_code"];
					$tmp_date_deliver_array[$key] = $row["date_deliver"];
				}

				if(count($OrderEdis) > 0){
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
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast,
				'OR' => [['product_code like' => 'P1%'], ['product_code like' => 'P2%']]])//productsの絞込みp1
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrSyoyouKeikakus = array();
				for($k=0; $k<count($SyoyouKeikakus); $k++){

					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'products.status' => 0, 'primary_p' => 0, 'customer_code' => '10001'])->toArray();//productsの絞込みp1

					if(isset($Product[0])){

						$arrSyoyouKeikakus[] = [
							'product_code' => $SyoyouKeikakus[$k]["product_code"],
							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
							'amount' => $SyoyouKeikakus[$k]["amount"]
					 ];

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

							if(substr($KadouSeikeis[$k]['starting_tm'], 10, 2) < 8){
								$starting_tm = strtotime($starting_tm);
								$nippouday = date('Y-m-d', strtotime('-1 day', $starting_tm));
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

				$date1 = $day."-1";//選択した月の初日
				$date1st = strtotime($date1);
				$datenext1 = date('Y-m-d', strtotime('+1 month', $date1st));//選択した月の次の月の初日
				$datelast = strtotime($datenext1);
				$datelast = date('Y-m-d', strtotime('-1 day', $datelast));//選択した月の最後の日
				$dateback1 = date('Y-m-d', strtotime('-1 month', $date1st));//選択した月の前の月の初日
				$dateback = strtotime($dateback1);
				$datebacklast = date('Y-m-d', strtotime('-1 day', $date1st));//選択した月の前の月の最後の日

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'customer_code' => '10002', 'primary_p' => 0,
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])->toArray();

				$arrProductsmoto = array();
				for($k=0; $k<count($arrProducts); $k++){

					$arrProductsmoto[] = [
						'date_order' => "",
						'num_order' => "",
						'product_code' => $arrProducts[$k]["product_code"],
						'product_name' => $arrProducts[$k]["product_name"],
						'price' => "",
						'date_deliver' => "",
						'amount' => "",
						'denpyoumaisu' => ""
				 ];

				}

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0, 'customer_code' => '10002',
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みw
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
				$arrAssembleProducts = array();
				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $OrderEdis[$k]["product_code"], 'products.status' => 0, 'primary_p' => 0, 'customer_code' => '10002'])->toArray();//productsの絞込みw

					if(isset($Product[0])){

						$product_name = $Product[0]->product_name;
			//			$product_name = mb_convert_encoding($Product[0]->product_name, 'SJIS-win', 'UTF-8');//UTF-8の文字列をSJIS-winに変更する

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

						 //組立品呼び出し
	 					$AssembleProducts = $this->AssembleProducts->find()->where(['child_pid' => $OrderEdis[$k]["product_code"], 'flag' => 0])->toArray();

	 					if(isset($AssembleProducts[0])){

	 							$arrAssembleProducts[] = [
	 								'product_code' => $AssembleProducts[0]["product_code"],
	 								'inzu' => $AssembleProducts[0]["inzu"]
	 						 ];

	 					}

					}

				}

				//同一のproduct_code、date_deliverの注文は一つにまとめ、amountとdenpyoumaisuを更新
				for($l=0; $l<count($arrOrderEdis); $l++){

					for($m=$l+1; $m<count($arrOrderEdis); $m++){

						if($arrOrderEdis[$l]["product_code"] == $arrOrderEdis[$m]["product_code"] && $arrOrderEdis[$l]["date_deliver"] == $arrOrderEdis[$m]["date_deliver"]){
/*
							echo "<pre>";
							print_r("同一です".$arrOrderEdis[$m]["product_code"]." ".$arrOrderEdis[$l]["amount"]." + ".$arrOrderEdis[$m]["amount"]);
							echo "</pre>";
*/
							$amount = $arrOrderEdis[$l]["amount"] + $arrOrderEdis[$m]["amount"];
							$denpyoumaisu = $arrOrderEdis[$l]["denpyoumaisu"] + 1;

							$arrOrderEdis[$l]["amount"] = $amount;
							$arrOrderEdis[$l]["denpyoumaisu"] = $denpyoumaisu;

							unset($arrOrderEdis[$m]);
							$arrOrderEdis = array_values($arrOrderEdis);

						}

					}

				}

				$arrOrderEdis = array_merge($arrOrderEdis, $arrProductsmoto);

				//並べかえ
				$tmp_product_array = array();
				$tmp_date_deliver_array = array();
				foreach($arrOrderEdis as $key => $row ) {
					$tmp_product_array[$key] = $row["product_code"];
					$tmp_date_deliver_array[$key] = $row["date_deliver"];
				}

				if(count($OrderEdis) > 0){
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
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast,
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みw
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrSyoyouKeikakus = array();
				for($k=0; $k<count($SyoyouKeikakus); $k++){

					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'products.status' => 0, 'primary_p' => 0, 'customer_code' => '10002'])->toArray();//productsの絞込みw

					if(isset($Product[0])){

						$arrSyoyouKeikakus[] = [
							'product_code' => $SyoyouKeikakus[$k]["product_code"],
							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
							'amount' => $SyoyouKeikakus[$k]["amount"]
					 ];

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

							if(substr($KadouSeikeis[$k]['starting_tm'], 10, 2) < 8){
								$starting_tm = strtotime($starting_tm);
								$nippouday = date('Y-m-d', strtotime('-1 day', $starting_tm));
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

				$date1 = $day."-1";//選択した月の初日
				$date1st = strtotime($date1);
				$datenext1 = date('Y-m-d', strtotime('+1 month', $date1st));//選択した月の次の月の初日
				$datelast = strtotime($datenext1);
				$datelast = date('Y-m-d', strtotime('-1 day', $datelast));//選択した月の最後の日
				$dateback1 = date('Y-m-d', strtotime('-1 month', $date1st));//選択した月の前の月の初日
				$dateback = strtotime($dateback1);
				$datebacklast = date('Y-m-d', strtotime('-1 day', $date1st));//選択した月の前の月の最後の日

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'customer_code like' => '2%', 'primary_p' => 0,
				'OR' => [['product_code like' => '2%']]])->toArray();

				$arrProductsmoto = array();
				for($k=0; $k<count($arrProducts); $k++){

					$arrProductsmoto[] = [
						'date_order' => "",
						'num_order' => "",
						'product_code' => $arrProducts[$k]["product_code"],
						'product_name' => $arrProducts[$k]["product_name"],
						'price' => "",
						'date_deliver' => "",
						'amount' => "",
						'denpyoumaisu' => ""
				 ];

				}

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0,
				'OR' => [['customer_code like' => '2%']]])//productsの絞込みdnp
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
				$arrAssembleProducts = array();
				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $OrderEdis[$k]["product_code"], 'products.status' => 0, 'primary_p' => 0, 'customer_code like' => '2%'])->toArray();//productsの絞込みdnp

					if(isset($Product[0])){

						$product_name = $Product[0]->product_name;
			//			$product_name = mb_convert_encoding($Product[0]->product_name, 'SJIS-win', 'UTF-8');//UTF-8の文字列をSJIS-winに変更する

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

						 //組立品呼び出し
	 					$AssembleProducts = $this->AssembleProducts->find()->where(['child_pid' => $OrderEdis[$k]["product_code"], 'flag' => 0])->toArray();

	 					if(isset($AssembleProducts[0])){

	 							$arrAssembleProducts[] = [
	 								'product_code' => $AssembleProducts[0]["product_code"],
	 								'inzu' => $AssembleProducts[0]["inzu"]
	 						 ];

	 					}

					}

				}

				$arrOrderEdis = array_merge($arrOrderEdis, $arrProductsmoto);

				//並べかえ
				$tmp_product_array = array();
				$tmp_date_deliver_array = array();
				foreach($arrOrderEdis as $key => $row ) {
					$tmp_product_array[$key] = $row["product_code"];
					$tmp_date_deliver_array[$key] = $row["date_deliver"];
				}

				if(count($OrderEdis) > 0){
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
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast])
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrSyoyouKeikakus = array();
				for($k=0; $k<count($SyoyouKeikakus); $k++){

					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'products.status' => 0, 'primary_p' => 0, 'customer_code like' => '2%'])->toArray();//productsの絞込みdnp

					if(isset($Product[0])){

						$arrSyoyouKeikakus[] = [
							'product_code' => $SyoyouKeikakus[$k]["product_code"],
							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
							'amount' => $SyoyouKeikakus[$k]["amount"]
					 ];

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

							if(substr($KadouSeikeis[$k]['starting_tm'], 10, 2) < 8){
								$starting_tm = strtotime($starting_tm);
								$nippouday = date('Y-m-d', strtotime('-1 day', $starting_tm));
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

				$date1 = $day."-1";//選択した月の初日
				$date1st = strtotime($date1);
				$datenext1 = date('Y-m-d', strtotime('+1 month', $date1st));//選択した月の次の月の初日
				$datelast = strtotime($datenext1);
				$datelast = date('Y-m-d', strtotime('-1 day', $datelast));//選択した月の最後の日
				$dateback1 = date('Y-m-d', strtotime('-1 month', $date1st));//選択した月の前の月の初日
				$dateback = strtotime($dateback1);
				$datebacklast = date('Y-m-d', strtotime('-1 day', $date1st));//選択した月の前の月の最後の日

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0,  'primary_p' => 0,
				'OR' => [['product_code like' => 'W0602%'], ['product_code like' => 'P160K%'], ['product_code like' => 'P12%']]])->toArray();

				$arrProductsmoto = array();
				for($k=0; $k<count($arrProducts); $k++){

					$arrProductsmoto[] = [
						'date_order' => "",
						'num_order' => "",
						'product_code' => $arrProducts[$k]["product_code"],
						'product_name' => $arrProducts[$k]["product_name"],
						'price' => "",
						'date_deliver' => "",
						'amount' => "",
						'denpyoumaisu' => ""
				 ];

				}

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0,
				'OR' => [['product_code like' => 'W0602%'], ['product_code like' => 'P160K%'], ['product_code like' => 'P12%']]])//productsの絞込みsinsei
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
				$arrAssembleProducts = array();
				for($k=0; $k<count($OrderEdis); $k++){

					$Product = $this->Products->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'status' => 0, 'primary_p' => 0])->toArray();//productsの絞込みsinsei

					if(isset($Product[0])){

						$product_name = $Product[0]->product_name;
			//			$product_name = mb_convert_encoding($Product[0]->product_name, 'SJIS-win', 'UTF-8');//UTF-8の文字列をSJIS-winに変更する

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

						 //組立品呼び出し
	 					$AssembleProducts = $this->AssembleProducts->find()->where(['child_pid' => $OrderEdis[$k]["product_code"], 'flag' => 0])->toArray();

	 					if(isset($AssembleProducts[0])){

	 							$arrAssembleProducts[] = [
	 								'product_code' => $AssembleProducts[0]["product_code"],
	 								'inzu' => $AssembleProducts[0]["inzu"]
	 						 ];

	 					}

					}

				}

				$arrOrderEdis = array_merge($arrOrderEdis, $arrProductsmoto);

				//並べかえ
				$tmp_product_array = array();
				$tmp_date_deliver_array = array();
				foreach($arrOrderEdis as $key => $row ) {
					$tmp_product_array[$key] = $row["product_code"];
					$tmp_date_deliver_array[$key] = $row["date_deliver"];
				}

				if(count($OrderEdis) > 0){
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
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast,
				'OR' => [['product_code like' => 'W0602%'], ['product_code like' => 'P160K%'], ['product_code like' => 'P12%']]])//productsの絞込みsinsei
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrSyoyouKeikakus = array();
				for($k=0; $k<count($SyoyouKeikakus); $k++){

					$Product = $this->Products->find()->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'status' => 0, 'primary_p' => 0])->toArray();//productsの絞込みsinsei

					if(isset($Product[0])){

						$arrSyoyouKeikakus[] = [
							'product_code' => $SyoyouKeikakus[$k]["product_code"],
							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
							'amount' => $SyoyouKeikakus[$k]["amount"]
					 ];

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

							if(substr($KadouSeikeis[$k]['starting_tm'], 10, 2) < 8){
								$starting_tm = strtotime($starting_tm);
								$nippouday = date('Y-m-d', strtotime('-1 day', $starting_tm));
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

			}elseif($sheet === "testtouroku"){

				$arrOrderEdis = array();
				$arrStockProducts = array();
				$arrAssembleProducts = array();
				$arrSyoyouKeikakus = array();
				$arrSeisans = array();

				$tourokutestproduct = [
					'product_code' => date('Y-m-d H:i:s').'acbd',
					'product_name' => 'APIテスト',
					'weight' => '9999',
					'primary_p' => '0',
					'status' => '0',
					'delete_flag' => '0',
					'created_at' => date('Y-m-d H:i:s'),
					'created_staff' => '9999',
				];
/*
			  $Products = $this->Products->patchEntity($this->Products->newEntity(), $tourokutestproduct);
				$this->Products->save($Products);

				$this->Products->updateAll(
				['product_code' => "dcba" , 'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => "9999"],
				['id'   => 1434]
				);
*/
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

/*
				$arrOrderEdis2 = array();
				$arrStockProducts2 = array();
				$arrAssembleProducts2 = array();
				$arrSyoyouKeikakus2 = array();
				$arrSeisans2 = array();

				for($k=0; $k<10; $k++){
					if(isset($arrOrderEdis[$k])){
						$arrOrderEdis2[] = $arrOrderEdis[$k];
					}
					if(isset($arrStockProducts[$k])){
						$arrStockProducts2[] = $arrStockProducts[$k];
					}
					if(isset($arrAssembleProducts[$k])){
						$arrAssembleProducts2[] = $arrAssembleProducts[$k];
					}
					if(isset($arrSyoyouKeikakus[$k])){
						$arrSyoyouKeikakus2[] = $arrSyoyouKeikakus[$k];
					}
					if(isset($arrSeisans[$k])){
						$arrSeisans2[] = $arrSeisans[$k];
					}
				}
*/
			$this->set([
				'OrderEdis' => $arrOrderEdis,
				'StockProducts' => $arrStockProducts,
				'AssembleProducts' => $arrAssembleProducts,
				'SyoyouKeikakus' => $arrSyoyouKeikakus,
				'Seisans' => $arrSeisans,
				'_serialize' => ['OrderEdis', 'StockProducts', 'AssembleProducts', 'SyoyouKeikakus', 'Seisans']
			]);
/*
			$this->set([
				'tourokutestproduct' => $tourokutestproduct,
				'_serialize' => ['tourokutestproduct']
			]);
*/
		}

	}
