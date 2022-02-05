<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

use App\myClass\Apizaiko\apizaikoprogram;//myClassフォルダに配置したクラスを使用

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
		 $this->Konpous = TableRegistry::get('konpous');
		 $this->ResultZensuHeads = TableRegistry::get('resultZensuHeads');
		 $this->RironStockProducts = TableRegistry::get('rironStockProducts');
		 $this->LabelSetikkatsues = TableRegistry::get('labelSetikkatsues');
		 $this->StockInoutWorklogs = TableRegistry::get('stockInoutWorklogs');
		 $this->NonKadouSeikeis = TableRegistry::get('nonKadouSeikeis');
		}

		public function xmlday()
		{
		//	$day = substr(Router::reverse($this->request, false), -14, 10);//urlの取得（use Cake\Routing\Routerが必要）
			$data = Router::reverse($this->request, false);
			$urlarr = explode("/",$data);//切り離し
			$dayarr = explode(".",$urlarr[4]);//切り離し
			$day = $dayarr[0];

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

				if(isset($kensabi)){
					array_multisort($product_code, array_map( "strtotime", $kensabi ), SORT_ASC, SORT_NUMERIC, $arrAssembleProducts);
				}

				$time = $ScheduleKouteis[0]->datetime->format('H:i');

			}

			$arrScheduleKoutei_csv = array();
			for($k=0; $k<count($ScheduleKouteis); $k++){

				$Product = $this->Products->find()->where(['product_code' => $ScheduleKouteis[$k]["product_code"]])->toArray();
				$product_name = $Product[0]->product_name;
	 //			$product_name = mb_convert_encoding($Product[0]->product_name, 'SJIS-win', 'UTF-8');//UTF-8の文字列をSJIS-winに変更する

				$tantou = str_replace(array(" ", "　"), "", $ScheduleKouteis[$k]["tantou"]);

				$arrScheduleKoutei_csv[] = [
					'seikeiki' => $ScheduleKouteis[$k]["seikeiki"]."号機",
					'time' => $ScheduleKouteis[$k]->datetime->format('H:i'),
					'product_code' => $ScheduleKouteis[$k]["product_code"],
					'product_name' => $product_name,
					'tantou' => $tantou
			 ];

			}

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

				$time = $ScheduleKouteis[0]->datetime->format('H:i');

			}

			$arrScheduleKoutei_csv = array();
			for($k=0; $k<count($ScheduleKouteis); $k++){

				$Product = $this->Products->find()->where(['product_code' => $ScheduleKouteis[$k]["product_code"]])->toArray();
				if(isset($Product[0])){
					$product_name = $Product[0]->product_name;
				}else{
					$product_name = "";
				}

				$tantou = str_replace(array(" ", "　"), "", $ScheduleKouteis[$k]["tantou"]);

				$arrScheduleKoutei_csv[] = [
					'day' => $ScheduleKouteis[$k]->datetime->format('j'),//0なしの日付
					'seikeiki' => $ScheduleKouteis[$k]["seikeiki"]."号機",
					'time' => $ScheduleKouteis[$k]->datetime->format('H:i'),
					'product_code' => $ScheduleKouteis[$k]["product_code"],
					'product_name' => $product_name,
					'tantou' => $tantou
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

			$date1d = $day." 08:00:00";
			$date1d0 = strtotime($date1d);
			$date1d0 = date('Y-m-d', strtotime('+1 day', $date1d0));
			$date1d0 = $date1d0." 07:59:59";

			$ScheduleKouteis = $this->ScheduleKouteis->find()
			->where(['datetime >=' => $date1d, 'datetime <=' => $date1d0, 'delete_flag' => 0])->toArray();

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

				$tantou = str_replace(array(" ", "　"), "", $ScheduleKouteis[$k]["tantou"]);

				$arrScheduleKoutei_csv[] = [
					'seikeiki' => $ScheduleKouteis[$k]["seikeiki"]."号機",
					'time' => $ScheduleKouteis[$k]->datetime->format('H:i'),
					'product_code' => $ScheduleKouteis[$k]["product_code"],
					'product_name' => $product_name,
					'tantou' => $tantou,
					'date' => $ScheduleKouteis[$k]->datetime->format('Y-m-d')
			 ];

			}

			$this->set([
					'sample_list' => $arrScheduleKoutei_csv,
					'_serialize' => ['sample_list']
			]);

		}

		public function kouteihyouweek()//http://192.168.4.246/Apis/kouteihyouweek/api/2021-6-5.xml
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
			->where(['datetime >=' => $date1w, 'datetime <=' => $date1w0, 'delete_flag' => 0])->order(["datetime"=>"ASC"])->toArray();

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
				$time = $ScheduleKouteis[0]->datetime->format('H:i');
			}

			$arrScheduleKoutei_csv = array();
			for($k=0; $k<count($ScheduleKouteis); $k++){
				$Product = $this->Products->find()->where(['product_code' => $ScheduleKouteis[$k]["product_code"]])->toArray();
				if(isset($Product[0])){
					$product_name = $Product[0]->product_name;
				}else{
					$product_name = "　";
				}
				$tantou = str_replace(array(" ", "　"), "", $ScheduleKouteis[$k]["tantou"]);

				$arrScheduleKoutei_csv[] = [
					'day' => $ScheduleKouteis[$k]->datetime->format('j'),//0なしの日付
					'seikeiki' => $ScheduleKouteis[$k]["seikeiki"]."号機",
					'time' => $ScheduleKouteis[$k]->datetime->format('H:i'),
					'product_code' => $ScheduleKouteis[$k]["product_code"],
					'product_name' => $product_name,
					'tantou' => $tantou,
					'date' => $ScheduleKouteis[$k]->datetime->format('Y-m-d')
			 ];

			}

			$this->set([
					'sample_list' => $arrScheduleKoutei_csv,
					'_serialize' => ['sample_list']
			]);

		}

		//http://192.168.4.246/Apis/zaikocyou/api/2020-10_primary.xml
		//http://localhost:5000/Apis/zaikocyou/api/2020-10_primary.xml
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
			$todaySyoyouKeikakus = date('Y-m-d');
			$this->SyoyouKeikakus->deleteAll(['date_deliver <' => $todaySyoyouKeikakus]);//当日の前日までの所要計画のデータは削除する

			$date1 = $day."-1";//選択した月の初日
			$date1st = strtotime($date1);
			$datenext1 = date('Y-m-d', strtotime('+1 month', $date1st));//選択した月の次の月の初日
			$datelast = strtotime($datenext1);
			$datelast = date('Y-m-d', strtotime('-1 day', $datelast));//選択した月の最後の日
			$dateback1 = date('Y-m-d', strtotime('-1 month', $date1st));//選択した月の前の月の初日
			$dateback = strtotime($dateback1);
			$datebacklast = date('Y-m-d', strtotime('-1 day', $date1st));//選択した月の前の月の最後の日
			$date16 = $day."-16";

			$daystart = $date1." 08:00:00";
			$dayfin = $datenext1." 07:59:59";

			$arrOrderEdis = array();
			$arrStockProducts = array();
			$arrAssembleProducts = array();
			$arrSyoyouKeikakus = array();
			$arrSeisans = array();

			if($sheet === "primary"){

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'primary_p' => 1,
				'OR' => [['product_code like' => 'P%'], ['product_code like' => 'AR%']]])->toArray();//primaryに該当するproductを取得する

				$OrderEdis = $this->OrderEdis->find()//primaryに該当するOrderEdis呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0,
				'OR' => [['product_code like' => 'P%'], ['product_code like' => 'AR%']]])
				->order(["date_deliver"=>"ASC"])->toArray();

				$StockProducts = $this->StockProducts->find()//primaryに該当する月末在庫呼び出し（先月末のデータ）
				->where(['date_stock' => $datebacklast,
				'OR' => [['product_code like' => 'P%'], ['product_code like' => 'AR%']]])
				->order(["date_stock"=>"DESC"])->toArray();

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//primaryに該当する所要計画呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0,
				'OR' => [['product_code like' => 'P%'], ['product_code like' => 'AR%']]])
				->order(["date_deliver"=>"ASC"])->toArray();

				$KadouSeikeis = $this->KadouSeikeis->find()//primaryに該当する生産数呼び出し
				->where(['starting_tm >=' => $daystart, 'starting_tm <=' => $dayfin,
				'OR' => [['product_code like' => 'P%'], ['product_code like' => 'AR%']]])
				->order(["starting_tm"=>"ASC"])->toArray();

				$StockInoutWorklogs = $this->StockInoutWorklogs->find()//primaryに該当する仕入れ数の呼出
				->where(['date_work >=' => $date1, 'date_work <=' => $datenext1, 'outsource_code !=' => 22,
				'OR' => [['product_code like' => 'P%'], ['product_code like' => 'AR%']]])
				->order(["date_work"=>"ASC"])->toArray();

			}elseif($sheet === "primary_dnp"){

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'primary_p' => 1,
				'OR' => [['customer_code like' => '2%']]])->toArray();

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0,
				'OR' => [['customer_code like' => '2%']]])//productsの絞込みprimary_dnp
				->order(["date_deliver"=>"ASC"])->toArray();

				$StockProducts = $this->StockProducts->find()//月末在庫呼び出し
				->where(['date_stock' => $datebacklast])
				->order(["date_stock"=>"DESC"])->toArray();

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0])
				->order(["date_deliver"=>"ASC"])->toArray();

				$KadouSeikeis = $this->KadouSeikeis->find()//生産数呼び出し
				->where(['starting_tm >=' => $daystart, 'starting_tm <=' => $dayfin])
				->order(["starting_tm"=>"ASC"])->toArray();

				$StockInoutWorklogs = $this->StockInoutWorklogs->find()//仕入れ数の呼出
				->where(['date_work >=' => $date1, 'date_work <=' => $datenext1, 'outsource_code !=' => 22])
				->order(["date_work"=>"ASC"])->toArray();

			}elseif($sheet === "primary_w"){

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'primary_p' => 1, 'customer_code' => '10002',
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])->toArray();

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0, 'customer_code' => '10002',
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みprimary_w
				->order(["date_deliver"=>"ASC"])->toArray();

				$StockProducts = $this->StockProducts->find()//月末在庫呼び出し
				->where(['date_stock' => $datebacklast,
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みprimary_w
				->order(["date_stock"=>"DESC"])->toArray();

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0,
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みprimary_w
				->order(["date_deliver"=>"ASC"])->toArray();

				$KadouSeikeis = $this->KadouSeikeis->find()//生産数呼び出し
				->where(['starting_tm >=' => $daystart, 'starting_tm <=' => $dayfin,
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みprimary_w
				->order(["starting_tm"=>"ASC"])->toArray();

				$StockInoutWorklogs = $this->StockInoutWorklogs->find()//仕入れ数の呼出
				->where(['date_work >=' => $date1, 'date_work <=' => $datenext1, 'outsource_code !=' => 22,
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みprimary_w
				->order(["date_work"=>"ASC"])->toArray();

			}elseif($sheet === "primary_h"){

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'customer_code' => '10002',
				'OR' => [['product_code like' => 'H%']]])->toArray();

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0, 'customer_code' => '10002',
				'OR' => [['product_code like' => 'H%']]])//productsの絞込みprimary_h
				->order(["date_deliver"=>"ASC"])->toArray();

				$StockProducts = $this->StockProducts->find()//月末在庫呼び出し
				->where(['date_stock' => $datebacklast,
				'OR' => ['product_code like' => 'H%']])//productsの絞込みprimary_h
				->order(["date_stock"=>"DESC"])->toArray();

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0,
				'OR' => ['product_code like' => 'H%']])//productsの絞込みprimary_h
				->order(["date_deliver"=>"ASC"])->toArray();

				$KadouSeikeis = $this->KadouSeikeis->find()//生産数呼び出し
				->where(['starting_tm >=' => $daystart, 'starting_tm <=' => $dayfin,
				'OR' => ['product_code like' => 'H%']])//productsの絞込みprimary_h
				->order(["starting_tm"=>"ASC"])->toArray();

				$StockInoutWorklogs = $this->StockInoutWorklogs->find()//仕入れ数の呼出
				->where(['date_work >=' => $date1, 'date_work <=' => $datenext1, 'outsource_code !=' => 22,
				'OR' => ['product_code like' => 'H%']])//productsの絞込みprimary_h
				->order(["date_work"=>"ASC"])->toArray();

			}elseif($sheet === "reizouko"){

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'customer_code' => '10005'])->toArray();

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0,
				'OR' => [['customer_code' => '10005']]])//productsの絞込みreizouko
				->order(["date_deliver"=>"ASC"])->toArray();

				$StockProducts = $this->StockProducts->find()//月末在庫呼び出し
				->where(['date_stock' => $datebacklast])
				->order(["date_stock"=>"DESC"])->toArray();

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0])
				->order(["date_deliver"=>"ASC"])->toArray();

				$KadouSeikeis = $this->KadouSeikeis->find()//生産数呼び出し
				->where(['starting_tm >=' => $daystart, 'starting_tm <=' => $dayfin])
				->order(["starting_tm"=>"ASC"])->toArray();

				$StockInoutWorklogs = $this->StockInoutWorklogs->find()//仕入れ数の呼出
				->where(['date_work >=' => $date1, 'date_work <=' => $datenext1, 'outsource_code !=' => 22])
				->order(["date_work"=>"ASC"])->toArray();

			}elseif($sheet === "uwawaku"){

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'customer_code' => '10003'])->toArray();

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0,
				'OR' => [['customer_code' => '10003']]])//productsの絞込みuwawaku
				->order(["date_deliver"=>"ASC"])->toArray();

				$StockProducts = $this->StockProducts->find()//月末在庫呼び出し
				->where(['date_stock' => $datebacklast])
				->order(["date_stock"=>"DESC"])->toArray();

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0])
				->order(["date_deliver"=>"ASC"])->toArray();

				$KadouSeikeis = $this->KadouSeikeis->find()//生産数呼び出し
				->where(['starting_tm >=' => $daystart, 'starting_tm <=' => $dayfin])
				->order(["starting_tm"=>"ASC"])->toArray();

				$StockInoutWorklogs = $this->StockInoutWorklogs->find()//仕入れ数の呼出
				->where(['date_work >=' => $date1, 'date_work <=' => $datenext1, 'outsource_code !=' => 22])
				->order(["date_work"=>"ASC"])->toArray();

			}elseif($sheet === "other"){

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0,
				'AND' => [['customer_code not like' => '1%'], ['customer_code not like' => '2%']]])->toArray();

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0, 'AND' => [['customer_code not like' => '1%'], ['customer_code not like' => '2%']]])//productsの絞込みother
				->order(["date_deliver"=>"ASC"])->toArray();

				$StockProducts = $this->StockProducts->find()//月末在庫呼び出し
				->where(['date_stock' => $datebacklast])
				->order(["date_stock"=>"DESC"])->toArray();

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0])
				->order(["date_deliver"=>"ASC"])->toArray();

				$KadouSeikeis = $this->KadouSeikeis->find()//生産数呼び出し
				->where(['starting_tm >=' => $daystart, 'starting_tm <=' => $dayfin])
				->order(["starting_tm"=>"ASC"])->toArray();

				$StockInoutWorklogs = $this->StockInoutWorklogs->find()//仕入れ数の呼出
				->where(['date_work >=' => $date1, 'date_work <=' => $datenext1, 'outsource_code !=' => 22])
				->order(["date_work"=>"ASC"])->toArray();

			}elseif($sheet === "p0"){

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'customer_code' => '10001',
				'OR' => [['product_code like' => 'P0%']]])->toArray();

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0, 'customer_code' => '10001',
				'OR' => [['product_code like' => 'P0%']]])//productsの絞込みp0
				->order(["date_deliver"=>"ASC"])->toArray();

				$StockProducts = $this->StockProducts->find()//月末在庫呼び出し
				->where(['date_stock' => $datebacklast,
				'OR' => ['product_code like' => 'P0%']])//productsの絞込みp0
				->order(["date_stock"=>"DESC"])->toArray();

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0,
				'OR' => ['product_code like' => 'P0%']])//productsの絞込みp0
				->order(["date_deliver"=>"ASC"])->toArray();

				$KadouSeikeis = $this->KadouSeikeis->find()//生産数呼び出し
				->where(['starting_tm >=' => $daystart, 'starting_tm <=' => $dayfin,
				'OR' => ['product_code like' => 'P0%']])//productsの絞込みp0
				->order(["starting_tm"=>"ASC"])->toArray();

				$StockInoutWorklogs = $this->StockInoutWorklogs->find()//仕入れ数の呼出
				->where(['date_work >=' => $date1, 'date_work <=' => $datenext1, 'outsource_code !=' => 22,
				'OR' => ['product_code like' => 'P0%']])//productsの絞込みp0
				->order(["date_work"=>"ASC"])->toArray();

			}elseif($sheet === "p1"){

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'customer_code' => '10001',
				'OR' => [['product_code like' => 'P1%'], ['product_code like' => 'P2%']]])->toArray();

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0, 'customer_code' => '10001',
				'OR' => [['product_code like' => 'P1%'], ['product_code like' => 'P2%']]])//productsの絞込みp1
				->order(["date_deliver"=>"ASC"])->toArray();

				$StockProducts = $this->StockProducts->find()//月末在庫呼び出し
				->where(['date_stock' => $datebacklast,
				'OR' => [['product_code like' => 'P1%'], ['product_code like' => 'P2%']]])//productsの絞込みp1
				->order(["date_stock"=>"DESC"])->toArray();

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0,
				'OR' => [['product_code like' => 'P1%'], ['product_code like' => 'P2%']]])//productsの絞込みp1
				->order(["date_deliver"=>"ASC"])->toArray();

				$KadouSeikeis = $this->KadouSeikeis->find()//生産数呼び出し
				->where(['starting_tm >=' => $daystart, 'starting_tm <=' => $dayfin,
				'OR' => [['product_code like' => 'P1%'], ['product_code like' => 'P2%']]])//productsの絞込みp1
				->order(["starting_tm"=>"ASC"])->toArray();

				$StockInoutWorklogs = $this->StockInoutWorklogs->find()//仕入れ数の呼出
				->where(['date_work >=' => $date1, 'date_work <=' => $datenext1, 'outsource_code !=' => 22,
				'OR' => [['product_code like' => 'P1%'], ['product_code like' => 'P2%']]])//productsの絞込みp1
				->order(["date_work"=>"ASC"])->toArray();

			}elseif($sheet === "w"){

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'customer_code' => '10002',
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])->toArray();

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0, 'customer_code' => '10002',
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みw
				->order(["date_deliver"=>"ASC"])->toArray();

				$StockProducts = $this->StockProducts->find()//月末在庫呼び出し
				->where(['date_stock' => $datebacklast,
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みw
				->order(["date_stock"=>"DESC"])->toArray();

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0,
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みw
				->order(["date_deliver"=>"ASC"])->toArray();

				$KadouSeikeis = $this->KadouSeikeis->find()//生産数呼び出し
				->where(['starting_tm >=' => $daystart, 'starting_tm <=' => $dayfin,
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みw
				->order(["starting_tm"=>"ASC"])->toArray();

				$StockInoutWorklogs = $this->StockInoutWorklogs->find()//仕入れ数の呼出
				->where(['date_work >=' => $date1, 'date_work <=' => $datenext1, 'outsource_code !=' => 22,
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みw
				->order(["date_work"=>"ASC"])->toArray();

			}elseif($sheet === "dnp"){

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'customer_code like' => '2%'//, 'primary_p' => 0
				])->toArray();

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0,
				'OR' => [['customer_code like' => '2%']]])//productsの絞込みdnp
				->order(["date_deliver"=>"ASC"])->toArray();

				$StockProducts = $this->StockProducts->find()//月末在庫呼び出し
				->where(['date_stock' => $datebacklast])
				->order(["date_stock"=>"DESC"])->toArray();

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0])
				->order(["date_deliver"=>"ASC"])->toArray();

				$KadouSeikeis = $this->KadouSeikeis->find()//生産数呼び出し
				->where(['starting_tm >=' => $daystart, 'starting_tm <=' => $dayfin])
				->order(["starting_tm"=>"ASC"])->toArray();

				$StockInoutWorklogs = $this->StockInoutWorklogs->find()//仕入れ数の呼出
				->where(['date_work >=' => $date1, 'date_work <=' => $datenext1, 'outsource_code !=' => 22])
				->order(["date_work"=>"ASC"])->toArray();

			}elseif($sheet === "sinsei"){

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0,
				'OR' => [['product_code like' => 'W0602%'], ['product_code like' => 'P160K%'], ['product_code like' => 'P12%']]])->toArray();

				$OrderEdis = $this->OrderEdis->find()//注文呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0,
				'OR' => [['product_code like' => 'W0602%'], ['product_code like' => 'P160K%'], ['product_code like' => 'P12%']]])//productsの絞込みsinsei
				->order(["date_deliver"=>"ASC"])->toArray();

				$StockProducts = $this->StockProducts->find()//月末在庫呼び出し
				->where(['date_stock' => $datebacklast,
				'OR' => [['product_code like' => 'W0602%'], ['product_code like' => 'P160K%'], ['product_code like' => 'P12%']]])//productsの絞込みsinsei
				->order(["date_stock"=>"DESC"])->toArray();

				$SyoyouKeikakus = $this->SyoyouKeikakus->find()//所要計画呼び出し
				->where(['date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0,
				'OR' => [['product_code like' => 'W0602%'], ['product_code like' => 'P160K%'], ['product_code like' => 'P12%']]])//productsの絞込みsinsei
				->order(["date_deliver"=>"ASC"])->toArray();

				$KadouSeikeis = $this->KadouSeikeis->find()//生産数呼び出し
				->where(['starting_tm >=' => $daystart, 'starting_tm <=' => $dayfin,
				'OR' => [['product_code like' => 'W0602%'], ['product_code like' => 'P160K%'], ['product_code like' => 'P12%']]])//productsの絞込みsinsei
				->order(["starting_tm"=>"ASC"])->toArray();

				$StockInoutWorklogs = $this->StockInoutWorklogs->find()//仕入れ数の呼出
				->where(['date_work >=' => $date1, 'date_work <=' => $datenext1, 'outsource_code !=' => 22,
				'OR' => [['product_code like' => 'W0602%'], ['product_code like' => 'P160K%'], ['product_code like' => 'P12%']]])//productsの絞込みsinsei
				->order(["date_work"=>"ASC"])->toArray();

			}

				if(!isset($_SESSION)){
				session_start();
				}
				$_SESSION['zaikoarrProducts'] = array();
				$_SESSION['zaikoarrProducts'] = $arrProducts;//クラスで使用するためセッションとして定義する

				$apizaikoprogram = new apizaikoprogram();
				$arrProductsmoto = $apizaikoprogram->classProductsmoto($date16);//RironStockProductsに登録されているかチェック

				$session = $this->request->getSession();
				$session->delete('zaikoarrProducts');//指定のセッションを削除

//ここからarrAssembleProducts

				$date1_datenext1 = $date1."_".$datenext1;
				$apizaikoprogram = new apizaikoprogram();
				$arrResultZensuHeadsmoto = $apizaikoprogram->classResultZensuHeads($date1_datenext1);//ResultZensuHeadsからデータを取得

				for($l=0; $l<count($arrResultZensuHeadsmoto); $l++){//arrResultZensuHeadsmotoに対して

					$AssembleProducts = $this->AssembleProducts->find()->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

					if(isset($AssembleProducts[0])){//AssembleProductsが存在する場合//組立品の場合

//シートごとに場合分け
						if($sheet === "primary"){

							$OrderEdisAssemble = $this->OrderEdis->find()//primaryに該当する、かつ'product_code' => $arrResultZensuHeadsmoto[$l]["product_code"]であるOrderEdis呼び出し
							->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'delete_flag' => 0,
							'OR' => [['product_code like' => 'P%'], ['product_code like' => 'AR%']]])
							->toArray();

						}elseif($sheet === "primary_dnp"){

							$OrderEdisAssemble = $this->OrderEdis->find()//注文呼び出し
							->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0,
							'OR' => [['customer_code like' => '2%']]])//productsの絞込みprimary_dnp
							->order(["date_deliver"=>"ASC"])->toArray();

						}elseif($sheet === "primary_w"){

							$OrderEdisAssemble = $this->OrderEdis->find()//注文呼び出し
							->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0, 'customer_code' => '10002',
							'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みprimary_w
							->order(["date_deliver"=>"ASC"])->toArray();

						}elseif($sheet === "primary_h"){

							$OrderEdisAssemble = $this->OrderEdis->find()//注文呼び出し
							->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0, 'customer_code' => '10002',
							'OR' => [['product_code like' => 'H%']]])//productsの絞込みprimary_h
							->order(["date_deliver"=>"ASC"])->toArray();

						}elseif($sheet === "reizouko"){

							$OrderEdisAssemble = $this->OrderEdis->find()//注文呼び出し
							->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0,
							'OR' => [['customer_code' => '10005']]])//productsの絞込みreizouko
							->order(["date_deliver"=>"ASC"])->toArray();

						}elseif($sheet === "uwawaku"){

							$OrderEdisAssemble = $this->OrderEdis->find()//注文呼び出し
							->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0,
							'OR' => [['customer_code' => '10003']]])//productsの絞込みuwawaku
							->order(["date_deliver"=>"ASC"])->toArray();

						}elseif($sheet === "other"){

							$OrderEdisAssemble = $this->OrderEdis->find()//注文呼び出し
							->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0, 'AND' => [['customer_code not like' => '1%'], ['customer_code not like' => '2%']]])//productsの絞込みother
							->order(["date_deliver"=>"ASC"])->toArray();

						}elseif($sheet === "p0"){

							$OrderEdisAssemble = $this->OrderEdis->find()//注文呼び出し
							->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'delete_flag' => 0, 'customer_code' => '10001',
							'OR' => [['product_code like' => 'P0%']]])//productsの絞込みp0
							->order(["date_deliver"=>"ASC"])->toArray();

						}elseif($sheet === "p1"){

							$OrderEdisAssemble = $this->OrderEdis->find()//注文呼び出し
							->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0, 'customer_code' => '10001',
							'OR' => [['product_code like' => 'P1%'], ['product_code like' => 'P2%']]])//productsの絞込みp1
							->order(["date_deliver"=>"ASC"])->toArray();

						}elseif($sheet === "w"){

							$OrderEdisAssemble = $this->OrderEdis->find()//注文呼び出し
							->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0, 'customer_code' => '10002',
							'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みw
							->order(["date_deliver"=>"ASC"])->toArray();

						}elseif($sheet === "dnp"){

							$OrderEdisAssemble = $this->OrderEdis->find()//注文呼び出し
							->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0,
							'OR' => [['customer_code like' => '2%']]])//productsの絞込みdnp
							->order(["date_deliver"=>"ASC"])->toArray();

						}elseif($sheet === "sinsei"){

							$OrderEdisAssemble = $this->OrderEdis->find()//注文呼び出し
							->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'date_deliver >=' => $date1, 'date_deliver <=' => $datelast, 'delete_flag' => 0,
							'OR' => [['product_code like' => 'W0602%'], ['product_code like' => 'P160K%'], ['product_code like' => 'P12%']]])//productsの絞込みsinsei
							->order(["date_deliver"=>"ASC"])->toArray();

						}

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

//arrAssembleProductsここまで
//ここからarrOrderEdis

				$arrOrderEdis = array();
				$RironStockProducts = $this->RironStockProducts->find()->select('product_code')
				->where(['date_culc' => $date16])->toArray();

				for($k=0; $k<count($OrderEdis); $k++){

					//シートごとに場合分け
					if($sheet === "primary"){

						$Product = $this->Products->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'status' => 0, 'primary_p' => 1])->toArray();//productsの絞込み　primary

					}elseif($sheet === "primary_dnp"){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $OrderEdis[$k]["product_code"], 'products.status' => 0, 'primary_p' => 1, 'customer_code like' => '2%'])->toArray();//productsの絞込みprimary_dnp

					}elseif($sheet === "primary_w"){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $OrderEdis[$k]["product_code"], 'products.status' => 0, 'primary_p' => 1, 'customer_code' => '10002'])->toArray();//productsの絞込みprimary_w

					}elseif($sheet === "primary_h"){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $OrderEdis[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10002'])->toArray();//productsの絞込みprimary_h

					}elseif($sheet === "reizouko"){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $OrderEdis[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10005'])->toArray();//productsの絞込みreizouko

					}elseif($sheet === "uwawaku"){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $OrderEdis[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10003'])->toArray();//productsの絞込みuwawaku

					}elseif($sheet === "other"){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $OrderEdis[$k]["product_code"], 'products.status' => 0, 'AND' => [['customer_code not like' => '1%'], ['customer_code not like' => '2%']]])//productsの絞込みother
						->toArray();//productsの絞込みother

					}elseif($sheet === "p0"){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $OrderEdis[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10001'])->toArray();//productsの絞込みp0

					}elseif($sheet === "p1"){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $OrderEdis[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10001'])->toArray();//productsの絞込みp1

					}elseif($sheet === "w"){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $OrderEdis[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10002'])->toArray();//productsの絞込みw

					}elseif($sheet === "dnp"){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $OrderEdis[$k]["product_code"], 'products.status' => 0, 'customer_code like' => '2%'])->toArray();//productsの絞込みdnp

					}elseif($sheet === "sinsei"){

						$Product = $this->Products->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'status' => 0])->toArray();//productsの絞込みsinsei

					}

					if(isset($Product[0])){//'primary_p' => 1の場合配列に追加する

						$product_name = $Product[0]->product_name;
						$riron_check = 0;
						$key = array_search($OrderEdis[$k]["product_code"], array_column($RironStockProducts, 'product_code'));//配列の検索
						if(strlen($key) > 0){//登録されていれば「１」
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

						 for($l=0; $l<count($arrProductsmoto); $l++){//最初に作った空のデータに差し替え
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
				$_SESSION['zaikoarrProductsmoto'] = array();
				$_SESSION['zaikoarrProductsmoto'] = $arrProductsmoto;

				$arrOrderEdismoto = $arrOrderEdis;
				$apizaikoprogram = new apizaikoprogram();
				$arrOrderEdis = $apizaikoprogram->classOrderEdis($arrOrderEdismoto);//arrOrderEdisの作成用クラス

				$session = $this->request->getSession();
				$session->delete('zaikoarrProductsmoto');//指定のセッションを削除

//arrOrderEdisここまで
//ここからarrStockProducts

					$arrStockProducts = array();
					for($k=0; $k<count($StockProducts); $k++){

						//シートごとに場合分け
						if($sheet === "primary"){

							$Product = $this->Products->find()->where(['product_code' => $StockProducts[$k]["product_code"], 'status' => 0, 'primary_p' => 1])->toArray();//productsの絞込み　primary

						}elseif($sheet === "primary_dnp"){

							$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
							->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'primary_p' => 1, 'customer_code like' => '2%'])->toArray();//productsの絞込みprimary_dnp

						}elseif($sheet === "primary_w"){

							$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
							->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'primary_p' => 1, 'customer_code' => '10002'])->toArray();//productsの絞込みprimary_w

						}elseif($sheet === "primary_h"){

							$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
							->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10002'])->toArray();//productsの絞込みprimary_h

						}elseif($sheet === "reizouko"){

							$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
							->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10005'])->toArray();//productsの絞込みreizouko

						}elseif($sheet === "uwawaku"){

							$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
							->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10003'])->toArray();//productsの絞込みuwawaku

						}elseif($sheet === "other"){

							$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
							->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'AND' => [['customer_code not like' => '1%'], ['customer_code not like' => '2%']]])//productsの絞込みother
							->toArray();//productsの絞込みother

						}elseif($sheet === "p0"){

							$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
							->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10001'])->toArray();//productsの絞込みp0

						}elseif($sheet === "p1"){

							$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
							->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10001'])->toArray();//productsの絞込みp1

						}elseif($sheet === "w"){

							$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
							->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10002'])->toArray();//productsの絞込みw

						}elseif($sheet === "dnp"){

							$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
							->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'customer_code like' => '2%'])->toArray();//productsの絞込みdnp

						}elseif($sheet === "sinsei"){

							$Product = $this->Products->find()->where(['product_code' => $StockProducts[$k]["product_code"], 'status' => 0])->toArray();//productsの絞込みsinsei

						}

						if(isset($Product[0])){//'primary_p' => 1（primaryに該当する場合）
							$arrStockProducts[] = [
								'product_code' => $StockProducts[$k]["product_code"],
								'date_stock' => $StockProducts[$k]["date_stock"],
								'amount' => $StockProducts[$k]["amount"]
						 ];
						}
					}
					$arrStockProductsmoto = $arrStockProducts;
					$apizaikoprogram = new apizaikoprogram();
					$arrStockProducts = $apizaikoprogram->classStockProducts($arrStockProductsmoto);//データの並び替え

//arrStockProductsここまで
//ここからarrSyoyouKeikakus

				$arrSyoyouKeikakus = array();
				for($k=0; $k<count($SyoyouKeikakus); $k++){

					//シートごとに場合分け
					if($sheet === "primary" || $sheet === "primary_dnp"){

						$Product = $this->Products->find()->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'status' => 0, 'primary_p' => 1])->toArray();//productsの絞込み　primary

					}else{

						$Product = $this->Products->find()->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'status' => 0])->toArray();//productsの絞込み　primary

					}

					if(isset($Product[0])){//'primary_p' => 1（primaryに該当する場合）
						$arrSyoyouKeikakus[] = [
							'product_code' => $SyoyouKeikakus[$k]["product_code"],
							'date_deliver' => $SyoyouKeikakus[$k]["date_deliver"],
							'amount' => $SyoyouKeikakus[$k]["amount"]
					 ];
					 //child_pidを追加
					 $AssembleProductcilds = $this->AssembleProducts->find()->where(['product_code' => $SyoyouKeikakus[$k]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();
					 if(isset($AssembleProductcilds[0])){//組み立て品の場合、child_pidを追加
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

				$arrSyoyouKeikakusmoto = $arrSyoyouKeikakus;
				$apizaikoprogram = new apizaikoprogram();
				$arrSyoyouKeikakus = $apizaikoprogram->classSyoyouKeikakus($arrSyoyouKeikakusmoto);//データの並び替え

//arrSyoyouKeikakusここまで
//ここからarrSeisans

				if(!isset($_SESSION)){
				session_start();
				}
				$_SESSION['zaikoKadouSeikeis'] = array();
				$_SESSION['zaikoKadouSeikeis'] = $KadouSeikeis;
				$_SESSION['zaikoarrSeisans'] = array();

					for($k=0; $k<count($KadouSeikeis); $k++){

						//シートごとに場合分け
						if($sheet === "primary"){

							$Product = $this->Products->find()->where(['product_code' => $KadouSeikeis[$k]["product_code"], 'status' => 0, 'primary_p' => 1])->toArray();//productsの絞込み　primary

						}elseif($sheet === "primary_dnp"){

							$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
							->where(['product_code' => $KadouSeikeis[$k]["product_code"], 'products.status' => 0, 'primary_p' => 1, 'customer_code like' => '2%'])->toArray();//productsの絞込みprimary_dnp

						}elseif($sheet === "primary_w"){

							$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
							->where(['product_code' => $KadouSeikeis[$k]["product_code"], 'products.status' => 0, 'primary_p' => 1, 'customer_code' => '10002'])->toArray();//productsの絞込みprimary_w

						}elseif($sheet === "primary_h"){

							$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
							->where(['product_code' => $KadouSeikeis[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10002'])->toArray();//productsの絞込みprimary_h

						}elseif($sheet === "reizouko"){

							$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
							->where(['product_code' => $KadouSeikeis[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10005'])->toArray();//productsの絞込みreizouko

						}elseif($sheet === "uwawaku"){

							$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
							->where(['product_code' => $KadouSeikeis[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10003'])->toArray();//productsの絞込みuwawaku

						}elseif($sheet === "other"){

							$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
							->where(['product_code' => $KadouSeikeis[$k]["product_code"], 'products.status' => 0, 'AND' => [['customer_code not like' => '1%'], ['customer_code not like' => '2%']]])//productsの絞込みother
							->toArray();//productsの絞込みother

						}elseif($sheet === "p0"){

							$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
							->where(['product_code' => $KadouSeikeis[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10001'])->toArray();//productsの絞込みp0

						}elseif($sheet === "p1"){

							$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
							->where(['product_code' => $KadouSeikeis[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10001'])->toArray();//productsの絞込みp1

						}elseif($sheet === "w"){

							$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
							->where(['product_code' => $KadouSeikeis[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10002'])->toArray();//productsの絞込みw

						}elseif($sheet === "dnp"){

							$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
							->where(['product_code' => $KadouSeikeis[$k]["product_code"], 'products.status' => 0, 'customer_code like' => '2%'])->toArray();//productsの絞込みdnp

						}elseif($sheet === "sinsei"){

							$Product = $this->Products->find()->where(['product_code' => $KadouSeikeis[$k]["product_code"], 'status' => 0])->toArray();//productsの絞込みsinsei

						}

						if(isset($Product[0])){//'primary_p' => 1（primaryに該当する場合）
							$_SESSION['zaikoarrSeisans'] = $arrSeisans;
							$apizaikoprogram = new apizaikoprogram();
							$arrSeisans = $apizaikoprogram->classSeisanskadou($k);//arrSeisans配列にデータを追加
						}
					}

					$session = $this->request->getSession();
					$session->delete('zaikoKadouSeikeis');//指定のセッションを削除
					$session->delete('zaikoarrSeisans');//指定のセッションを削除
/*
					$StockInoutWorklogs = $this->StockInoutWorklogs->find()//primaryに該当する仕入れ数の呼出
					->where(['date_work >=' => $date1, 'date_work <=' => $datenext1, 'outsource_code !=' => 22,
					'OR' => [['product_code like' => 'P%'], ['product_code like' => 'AR%']]])
					->order(["date_work"=>"ASC"])->toArray();
*/
					for($k=0; $k<count($StockInoutWorklogs); $k++){

						//シートごとに場合分け
						if($sheet === "primary"){

							$Product = $this->Products->find()->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'status' => 0, 'primary_p' => 1])->toArray();//productsの絞込み　primary

						}elseif($sheet === "primary_dnp"){

							$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
							->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'products.status' => 0, 'primary_p' => 1, 'customer_code like' => '2%'])->toArray();//productsの絞込みprimary_dnp

						}elseif($sheet === "primary_w"){

							$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
							->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'products.status' => 0, 'primary_p' => 1, 'customer_code' => '10002'])->toArray();//productsの絞込みprimary_w

						}elseif($sheet === "primary_h"){

							$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
							->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10002'])->toArray();//productsの絞込みprimary_h

						}elseif($sheet === "reizouko"){

							$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
							->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10005'])->toArray();//productsの絞込みreizouko

						}elseif($sheet === "uwawaku"){

							$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
							->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10003'])->toArray();//productsの絞込みuwawaku

						}elseif($sheet === "other"){

							$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
							->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'products.status' => 0, 'AND' => [['customer_code not like' => '1%'], ['customer_code not like' => '2%']]])//productsの絞込みother
							->toArray();//productsの絞込みother

						}elseif($sheet === "p0"){

							$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
							->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10001'])->toArray();//productsの絞込みp0

						}elseif($sheet === "p1"){

							$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
							->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10001'])->toArray();//productsの絞込みp1

						}elseif($sheet === "w"){

							$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
							->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10002'])->toArray();//productsの絞込みw

						}elseif($sheet === "dnp"){

							$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
							->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'products.status' => 0, 'customer_code like' => '2%'])->toArray();//productsの絞込みdnp

						}elseif($sheet === "sinsei"){

							$Product = $this->Products->find()->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'status' => 0])->toArray();//productsの絞込みsinsei

						}

						$NonKadouSeikeis = $this->NonKadouSeikeis->find()->where(['product_code' => $StockInoutWorklogs[$k]["product_code"], 'outsource_handy_id' => $StockInoutWorklogs[$k]["outsource_code"], 'status' => 0, 'delete_flag' => 0])->toArray();

						if(isset($Product[0]) && !isset($NonKadouSeikeis[0])){//primaryに該当するかつNonKadouSeikeisではない場合
							$arrSeisans[] = [
								'dateseikei' => $StockInoutWorklogs[$k]["date_work"]->format('Y/m/d'),
								'product_code' => $StockInoutWorklogs[$k]["product_code"],
								'amount_shot' => $StockInoutWorklogs[$k]["amount"],
								'torisu' => 1
						 ];
						}

					}

					$arrSeisansmoto = $arrSeisans;
					$apizaikoprogram = new apizaikoprogram();
					$arrSeisans = $apizaikoprogram->classSeisans($arrSeisansmoto);//データの並び替え

//arrSeisansここまで

/*//内容表示テスト
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

		}

		//http://192.168.4.246/Apis/kouteivbatest/api/2020-10-28_2020-11-4_2020-10-28 08:00:00_2_CAS-NDS-20002_0_粉砕量注意！.xml
		//http://localhost:5000/Apis/kouteivbatest/api/2020-10-28_2020-11-4_2020-10-28 08:00:00_2_CAS-NDS-20002_0_粉砕量注意！.xml
		public function kouteivbatest()//実験用
 	{
		$data = Router::reverse($this->request, false);//urlを取得

		$urlarr = explode("/",$data);//切り離し
		$dataarr = explode("_",$urlarr[4]);//切り離し

		$daystart = $dataarr[0];//1週間の初めの日付の取得
		$dayfinish = $dataarr[1];//1週間の終わりの日付の取得
		$datetime = str_replace("%20", " ", $dataarr[2]);//datetimeの取得
		$datetime = str_replace("%3A", ":", $datetime);//datetimeの取得
		$seikeiki = $dataarr[3];//seikeikiの取得
		$product_code = $dataarr[4];//product_codeの取得
		$Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
		if(isset($Product[0])){
			$product_name = $Product[0]->product_name;
		}else{
			$product_name = "";
		}

		$present_kensahyou = $dataarr[5];//present_kensahyouの取得

		$tantouarr = explode(".",$dataarr[6]);//切り離し

		$tantou = $tantouarr[0];//tantouの取得

		$tantou = mb_convert_encoding($tantou,"sjis","utf-8");

		$tantou = str_replace(array(" ", "　"), "", $tantou);

		$kouteivba['datetime'] = $datetime;
		$kouteivba['seikeiki'] = $seikeiki;
		$kouteivba['product_code'] = $product_code;
		$kouteivba['present_kensahyou'] = $present_kensahyou;
		$kouteivba['product_name'] = $product_name;
		$kouteivba['tantou'] = $tantou;

		$this->set([
			'tourokutest' => $kouteivba,
  		 '_serialize' => ['tourokutest']
		 ]);

	}


	}
