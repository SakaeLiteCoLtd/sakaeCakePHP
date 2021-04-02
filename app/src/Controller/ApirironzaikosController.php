<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

use App\myClass\Apifind\htmlApifind;//myClassフォルダに配置したクラスを使用

use Cake\Utility\Xml;//xmlのファイルを読み込みために必要
use Cake\Utility\Text;
use Cake\Routing\Router;//urlの取得
use Cake\Http\Client;//httpの読取に必要
//use Cake\Http\ServerRequest;

class ApirironzaikosController extends AppController
	{

		public function initialize()
		{
		 parent::initialize();
		 $this->RironStockProducts = TableRegistry::get('rironStockProducts');
		 $this->MinusRironStockProducts = TableRegistry::get('minusRironStockProducts');
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

		}

		public function preadd()//http://localhost:5000 http://192.168.4.246/Apidatas/preadd  http://localhost:5000/Apirironzaikos/preadd
		{
		//$this->request->session()->destroy(); // セッションの破棄

			session_start();
			$session = $this->request->getSession();
	//		$_SESSION['test'][0] = 0;
	/*
	$_SESSION['rironzaiko'] = array();
	$_SESSION['rironzaikoupdate'] = array();
	$_SESSION['checkrironzaiko'] = array();
	$_SESSION['sessionronzaikostarttime'] = array();
*/
			echo "<pre>";
			print_r($_SESSION);
			echo "</pre>";
/*
			for($k=0; $k<3; $k++){

				if($_SESSION['test'][0] < 5){

					$k = $k - 1;
					$_SESSION['test'][0] = $_SESSION['test'][0] + 1;

				}

				echo "<pre>";
				print_r($k." ".$_SESSION['test'][0]);
				echo "</pre>";

			}
*/
		}

		public function dajikken()//http://localhost:5000 http://192.168.4.246/Apidatas/preadd  http://localhost:5000/Apirironzaikos/preadd
		{//http://localhost:5000/Apirironzaikos/dajikken/api/start.xml

			$data = Router::reverse($this->request, false);//文字化けする後で2回変換すると日本語OK
			$data = urldecode($data);
			$urlarr = explode("/",$data);//切り離し
			$dataarr = explode(".",$urlarr[4]);//切り離し
			$datest = $dataarr[0];
			$datest = mb_convert_encoding($datest,"UTF-8",mb_detect_encoding($datest, "ASCII,SJIS,UTF-8,CP51932,SJIS-win", true));

			if(!isset($_SESSION)){
			session_start();
			}
			$session = $this->request->getSession();
			$_SESSION['dajikken'] = array();
			$_SESSION['dajikken'] = $datest;

			$tourokuarr = array();
			$tourokuarr['date_culc'] = '2022-01-16';
			$tourokuarr['product_code'] = $datest;
			$tourokuarr['amount'] = 9999;
			$tourokuarr['created_at'] = date('Y-m-d H:i:s');

			//新しいデータを登録
//			$RironStockProducts = $this->RironStockProducts->patchEntity($this->RironStockProducts->newEntity(), $tourokuarr);
//			$this->RironStockProducts->save($RironStockProducts);

//			sleep(5);//20秒待機


		}

		public function test()//http://localhost:5000/Apirironzaikos/test/api/start.xml
		//http://localhost:5000/Apirironzaikos/test/api/2021-01-16_AWW1097A1ZS0_406.xml
		//http://localhost:5000/Apirironzaikos/test/api/end.xml
 	 {
		 $data = Router::reverse($this->request, false);//文字化けする後で2回変換すると日本語OK
		 $data = urldecode($data);

		 $urlarr = explode("/",$data);//切り離し
		 $dataarr = explode("_",$urlarr[4]);//切り離し

		 session_start();
		 $session = $this->request->getSession();
		 echo "<pre>";
		 print_r($_SESSION);
		 echo "</pre>";

		 if($urlarr[4] == "start.xml"){

			 $rironzaikovba = 1;

		 }elseif(isset($dataarr[2])){

			 $arramount = explode(".",$dataarr[2]);//切り離し
			 $amount = $arramount[0];

			 $rironzaikovba['date_culc'] = $dataarr[0];
			 $rironzaikovba['product_code'] = $dataarr[1];
			 $rironzaikovba['amount'] = $amount;
			 $rironzaikovba['created_at'] = date('Y-m-d H:i:s');

		 }elseif($urlarr[4] == "end.xml"){

			 $rironzaikovba = 3;

		 }

		 $this->set([
		 'tourokutest' => $rironzaikovba,
		 '_serialize' => ['tourokutest']
		 ]);

	 }

		public function tourokuzaiko()
		{
			$data = Router::reverse($this->request, false);//文字化けする後で2回変換すると日本語OK
			$data = urldecode($data);

			$urlarr = explode("/",$data);//切り離し
			$dataarr = explode("_",$urlarr[4]);//切り離し
/*
			$this->set([
			'rironzaiko' => $urlarr[4],
			'_serialize' => ['rironzaiko']
			]);
*/
			if(!isset($_SESSION)){
			session_start();
			}

			if($urlarr[4] == "start.xml"){

				if(isset($_SESSION['checkrironzaiko'][0])){//誰かがボタンを押して終了していない場合

					$_SESSION['checkrironzaiko'][] = 0;
					$count = 5 * count($_SESSION['checkrironzaiko']);

					for($k=0; $k<count($_SESSION['checkrironzaiko']); $k++){

						if(isset($_SESSION['checkrironzaiko'][0])){

							sleep($count);//待機
							$k = $k - 1;

						}

					}

					$_SESSION['rironzaiko'] = array();
					$_SESSION['rironzaikoupdate'] = array();
					$_SESSION['checkrironzaiko'] = array();
					$_SESSION['sessionronzaikostarttime'] = array();

					$_SESSION['checkrironzaiko'][0] = 0;
					$_SESSION['sessionronzaikostarttime'] = date('Y-m-d H:i:s');

				}else{//同時に誰もスタートしていない場合

					$_SESSION['checkrironzaiko'][0] = 0;
					$_SESSION['sessionronzaikostarttime'] = date('Y-m-d H:i:s');
					$_SESSION['rironzaiko'] = array();
					$_SESSION['rironzaikoupdate'] = array();

				}

			}elseif(isset($dataarr[2])){

				$arramount = explode(".",$dataarr[2]);//切り離し
				$amount = $arramount[0];

				$rironzaikovba['date_culc'] = $dataarr[0];
				$rironzaikovba['product_code'] = $dataarr[1];
				$rironzaikovba['amount'] = $amount;
				$rironzaikovba['created_at'] = date('Y-m-d H:i:s');

				$RironStockProducts = $this->RironStockProducts->find()->where(['date_culc' => $dataarr[0], 'product_code' => $dataarr[1]])->toArray();
				if(!isset($RironStockProducts[0])){

					$session = $this->request->getSession();
					$_SESSION['rironzaiko'][] = $rironzaikovba;

				}else{

					$rironzaikovba['id'] = $RironStockProducts[0]->id;

					$session = $this->request->getSession();
					$_SESSION['rironzaikoupdate'][] = $rironzaikovba;

				}

			}elseif($urlarr[4] == "end.xml"){

//				sleep(10);//待機

				$session = $this->request->getSession();
/*
				echo "<pre>";
				print_r($_SESSION);
				echo "</pre>";
*/
					//新しいデータを登録
					if(count($_SESSION['rironzaiko']) > 0) {

						$RironStockProducts = $this->RironStockProducts->patchEntities($this->RironStockProducts->newEntity(), $_SESSION['rironzaiko']);

					}

					$connection = ConnectionManager::get('default');//トランザクション1
					// トランザクション開始2
					$connection->begin();//トランザクション3
					try {//トランザクション4

						if(count($_SESSION['rironzaiko']) < 1){//新規登録データがない場合

							if(isset($_SESSION['rironzaikoupdate'][0])){

								for($k=0; $k<count($_SESSION['rironzaikoupdate']); $k++){

									$this->RironStockProducts->updateAll(
									['date_culc' => $_SESSION['rironzaikoupdate'][$k]["date_culc"],
									 'product_code' => $_SESSION['rironzaikoupdate'][$k]["product_code"],
									 'amount' => $_SESSION['rironzaikoupdate'][$k]["amount"],
									 'updated_at' => $_SESSION['rironzaikoupdate'][$k]["created_at"]],
									['id' => $_SESSION['rironzaikoupdate'][$k]["id"]]
									);

								}

							}

							$connection->commit();// コミット5
							$_SESSION['rironzaiko'] = array();
							$_SESSION['checkrironzaiko'] = array();
							$_SESSION['sessionronzaikostarttime'] = array();
							$_SESSION['rironzaikoupdate'] = array();

						}

						if(count($_SESSION['rironzaiko']) > 0 && $this->RironStockProducts->saveMany($RironStockProducts)) {

							if(isset($_SESSION['rironzaikoupdate'][0])){

								for($k=0; $k<count($_SESSION['rironzaikoupdate']); $k++){

									$this->RironStockProducts->updateAll(
									['date_culc' => $_SESSION['rironzaikoupdate'][$k]["date_culc"],
									 'product_code' => $_SESSION['rironzaikoupdate'][$k]["product_code"],
									 'amount' => $_SESSION['rironzaikoupdate'][$k]["amount"],
									 'updated_at' => date('Y-m-d H:i:s')],
									['id' => $_SESSION['rironzaikoupdate'][$k]["id"]]
									);

								}

							}

							$connection->commit();// コミット5
							$_SESSION['rironzaiko'] = array();
							$_SESSION['checkrironzaiko'] = array();
							$_SESSION['sessionronzaikostarttime'] = array();
							$_SESSION['rironzaikoupdate'] = array();

						} else {

							for($k=0; $k<count($_SESSION['rironzaikoupdate']); $k++){

								$this->RironStockProducts->updateAll(
								['date_culc' => $_SESSION['rironzaikoupdate'][$k]["date_culc"],
								 'product_code' => $_SESSION['rironzaikoupdate'][$k]["product_code"],
								 'amount' => $_SESSION['rironzaikoupdate'][$k]["amount"],
								 'updated_at' => date('Y-m-d H:i:s')],
								['id' => $_SESSION['rironzaikoupdate'][$k]["id"]]
								);

							}

							$this->Flash->error(__('The data could not be saved. Please, try again.'));
							throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
							$_SESSION['rironzaiko'] = array();
							$_SESSION['checkrironzaiko'] = array();
							$_SESSION['sessionronzaikostarttime'] = array();
							$_SESSION['rironzaikoupdate'] = array();

						}

					} catch (Exception $e) {//トランザクション7
					//ロールバック8
						$connection->rollback();//トランザクション9
					}//トランザクション10

					$_SESSION['rironzaiko'] = array();
					$_SESSION['checkrironzaiko'] = array();
					$_SESSION['sessionronzaikostarttime'] = array();
					$_SESSION['rironzaikoupdate'] = array();

				}

		}

		//http://localhost:5000/Apirironzaikos/minuszaiko/api/start_sheet1.xml
		//http://192.168.4.246/Apirironzaikos/minuszaiko/api/start_sheet1.xml
		//http://localhost:5000/Apirironzaikos/minuszaiko/api/sheet1_2021-3-20_P002X-15310_2021-3-21_-500.xml
		//http://192.168.4.246/Apirironzaikos/minuszaiko/api/sheet1_P002X-15310_2021-3-20_-500.xml
		//http://192.168.4.246/Apirironzaikos/minuszaiko/api/「シートID」_「理論在庫日」_「品番」_「マイナス日」_「マイナス数量」.xml
		//http://localhost:5000/Apirironzaikos/minuszaiko/api/end_sheet1.xml
		//http://192.168.4.246/Apirironzaikos/minuszaiko/api/end_sheet1.xml
		public function minuszaiko()
		{
			$data = Router::reverse($this->request, false);//文字化けする後で2回変換すると日本語OK
			$data = urldecode($data);

			$urlarr = explode("/",$data);//切り離し
			$dataarr = explode("_",$urlarr[4]);//切り離し
/*
			echo "<pre>";
			print_r($dataarr);
			echo "</pre>";
*/
			$this->set([
			'minuszaiko' => $urlarr[4],
			'_serialize' => ['minuszaiko']
			]);

			if(!isset($_SESSION)){
			session_start();
			}

			if($dataarr[0] == "start"){

				$_SESSION['minusrironzaiko'] = array();

			}elseif(isset($dataarr[4])){

				if(isset($dataarr[5])){

					$arramount = explode(".",$dataarr[5]);//切り離し
					$amount = $arramount[0];

					$minusrironzaikovba['sheet_id'] = $dataarr[0]."_".$dataarr[1];
					$minusrironzaikovba['date_riron_stock'] = $dataarr[2];
					$minusrironzaikovba['product_code'] = $dataarr[3];
					$minusrironzaikovba['date_minus'] = $dataarr[4];
					$minusrironzaikovba['amount_minus'] = $amount;
					$minusrironzaikovba['created_at'] = date('Y-m-d H:i:s');

				}else{

					$arramount = explode(".",$dataarr[4]);//切り離し
					$amount = $arramount[0];

					$minusrironzaikovba['sheet_id'] = $dataarr[0];
					$minusrironzaikovba['date_riron_stock'] = $dataarr[1];
					$minusrironzaikovba['product_code'] = $dataarr[2];
					$minusrironzaikovba['date_minus'] = $dataarr[3];
					$minusrironzaikovba['amount_minus'] = $amount;
					$minusrironzaikovba['created_at'] = date('Y-m-d H:i:s');

				}

	//			$MinusRironStockProducts = $this->MinusRironStockProducts->find()->where(['date_minus' => $dataarr[3], 'product_code' => $dataarr[2]])->toArray();

				$session = $this->request->getSession();
				$_SESSION['minusrironzaiko'][] = $minusrironzaikovba;

			}elseif($dataarr[0] == "end"){

				$session = $this->request->getSession();

				$sheet_id = $_SESSION['minusrironzaiko'][0]['sheet_id'];
				$date_riron_stock = $_SESSION['minusrironzaiko'][0]['date_riron_stock'];

				$MinusRironStockProducts = $this->MinusRironStockProducts->patchEntities($this->MinusRironStockProducts->newEntity(), $_SESSION['minusrironzaiko']);
				$connection = ConnectionManager::get('default');//トランザクション1
				// トランザクション開始2
				$connection->begin();//トランザクション3
				try {//トランザクション4

					$param = array('sheet_id' => $sheet_id);
		//			$param = array('sheet_id' => $sheet_id, 'date_riron_stock' => $date_riron_stock);
					$this->MinusRironStockProducts->deleteAll($param);

					if($this->MinusRironStockProducts->saveMany($MinusRironStockProducts)) {

						$connection->commit();// コミット5
						$_SESSION['minusrironzaiko'] = array();
						$_SESSION['minusrironzaikoupdate'] = array();

					} else {

						$this->Flash->error(__('The data could not be saved. Please, try again.'));
						throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6

						$_SESSION['minusrironzaiko'] = array();

					}

				} catch (Exception $e) {//トランザクション7
				//ロールバック8
					$connection->rollback();//トランザクション9
				}//トランザクション10

				$_SESSION['minusrironzaiko'] = array();

			}

		}

		//http://localhost:5000/Apirironzaikos/dateminus/api/m-zaiko0-1.xml
		public function dateminus()
		{

			$MinusRironStockProducts = $this->MinusRironStockProducts->find()
			->order(["date_riron_stock"=>"DESC"])->toArray();
			$dateminus = $MinusRironStockProducts[0]['date_riron_stock']->format('Y-n-j');
	//		$dateminus = strtotime($dateminus);
	//		$dateminus = date('Y-m-d', strtotime('-2 day', $dateminus));

			$arryaermonthday = explode("-",$dateminus);
			$arr = array();
			$arr[] = [
				'yaer' => $arryaermonthday[0],
				'month' => $arryaermonthday[1],
				'day' => $arryaermonthday[2],
		 ];
/*
			$this->set([
				'yaer' => $arryaermonthday[0],
				'month' => $arryaermonthday[1],
				'day' => $arryaermonthday[2],
			'_serialize' => ['yaer', 'month', 'day']
			]);
*/
			$this->set([
				'arryaermonthday' => $arr,
				'_serialize' => ['arryaermonthday']
			]);

		}

		//http://localhost:5000/Apirironzaikos/minuszaikoyobidashi/api/m-zaiko0-1.xml
		//http://192.168.4.246/Apirironzaikos/minuszaikoyobidashi/api/m-zaiko0-1.xml
		public function minuszaikoyobidashi()
		{
			$data = Router::reverse($this->request, false);//urlを取得
			$urlarr = explode("/",$data);//切り離し

			$MinusRironStockProducts = $this->MinusRironStockProducts->find()
			->order(["date_riron_stock"=>"DESC"])->toArray();
			$dateminus = $MinusRironStockProducts[0]['date_riron_stock']->format('Y-m-d');
			$dateminusstr = strtotime($dateminus);

			if($urlarr[4] == "m-zaiko0-1.xml"){
	//			$dateminussta = $MinusRironStockProducts[0]['date_riron_stock']->format('Y-m-d');
				$dateminussta = $MinusRironStockProducts[0]['date_riron_stock']->format('Y-m-d');
				$dateminusstaminus = date('Y-m-d', strtotime('-2 day', $dateminusstr));
				$dateminusfin = date('Y-m-d', strtotime('+7 day', $dateminusstr));
			}else{
				$dateminussta = $MinusRironStockProducts[0]['date_riron_stock']->format('Y-m-d');
				$dateminusstaminus = date('Y-m-d', strtotime('+8 day', $dateminusstr));
				$dateminusfin = date('Y-m-d', strtotime('+14 day', $dateminusstr));
				$dateminusstr = strtotime($dateminussta);
			}
/*
			echo "<pre>";
			print_r($dateminusstaminus);
			echo "</pre>";
			echo "<pre>";
			print_r($dateminusfin);
			echo "</pre>";
*/
			$arryaermonth = explode("-",$dateminussta);
			$yaermonth = $arryaermonth[0]."-".$arryaermonth[1];

			$date1 = $yaermonth."-1";//選択した日程の月の初日
			$date1st = strtotime($date1);
			$datenext1 = date('Y-m-d', strtotime('+30 day', $date1st));
			$datelast = strtotime($datenext1);
			$datelast = date('Y-m-d', strtotime('-1 day', $datelast));
			$dateback1 = date('Y-m-d', strtotime('-1 month', $date1st));//選択した月の前の月の初日//stockProductsに使用
			$dateback = strtotime($dateback1);
			$datebacklast = date('Y-m-d', strtotime('-1 day', $date1st));//選択した月の前の月の最後の日//stockProductsに使用

			$datestart = $dateminussta;
			$datestartstr = strtotime($dateminussta);
			$dateend = date('Y-m-d', strtotime('+31 day', $datestartstr));
			$dateendnext = date('Y-m-d', strtotime('+31 day', $datestartstr));//kodouseikeisで使用

//$arrProductsmotoスタート
/*
echo "<pre>";
print_r($dateminus);
echo "</pre>";
*/
				$StockProducts = $this->MinusRironStockProducts->find()//MinusRironStockProductsテーブルで、date_riron_stockから1週間以内（１～２週間以内）にマイナスになる品番を絞り込み
				->where(['date_riron_stock' => $dateminus, 'date_minus >=' => $dateminusstaminus, 'date_minus <=' => $dateminusfin])
				->order(["date_minus"=>"ASC"])->toArray();
/*
				echo "<pre>";
				print_r($StockProducts);
				echo "</pre>";
*/
					$arrProducts = array();
					for($k=0; $k<count($StockProducts); $k++){

						$Product = $this->Products->find()->where(['product_code' => $StockProducts[$k]["product_code"]])->toArray();

						if(isset($Product[0])){

							$arrProducts[] = [
								'product_code' => $StockProducts[$k]["product_code"],
								'product_name' => $Product[0]["product_name"],
						 ];

						}

					}

				if(!isset($_SESSION)){
				session_start();
				}
				$_SESSION['classarrProducts'] = array();
				$_SESSION['classarrProducts'] = $arrProducts;
				$date16 = $yaermonth."-16";

				//Productsmotoクラス使用
				$htmlApifind = new htmlApifind();//クラスを使用
				$arrProductsmoto = $htmlApifind->Productsmoto($date16);//クラスを使用
				$arrProductsmotominus = $arrProductsmoto;

//$arrProductsmoto完成
/*
echo "<pre>";
print_r($arrProductsmotominus);
echo "</pre>";
*/
//$arrResultZensuHeadsmotoスタート

		$arrResultZensuHeadsmoto = array();
		for($j=0; $j<count($arrProductsmoto); $j++){

			$ResultZensuHeadsdatas = $this->ResultZensuHeads->find()//組立品の元データを出しておく（ループで取り出すと時間がかかる）
			->where(['product_code' => $arrProductsmoto[$j]["product_code"], 'datetime_finish >=' => $datestart." 00:00:00", 'datetime_finish <' => $dateend." 00:00:00"])
			->order(["datetime_finish"=>"DESC"])->toArray();

			for($k=0; $k<count($ResultZensuHeadsdatas); $k++){

				$arrResultZensuHeadsmoto[] = [
					'product_code' => $ResultZensuHeadsdatas[$k]["product_code"],
					'datetime_finish' => $ResultZensuHeadsdatas[$k]["datetime_finish"]->format('Y-m-d'),
					'count' => 1
			 ];

			}

		}
/*
		$product_code_moto = array();//ここから配列の並び変え
		$datetime_finish_moto = array();
		foreach ($arrResultZensuHeadsmoto as $key => $value) {
			 $product_code[$key] = $value['product_code'];
			 $datetime_finish[$key] = $value["datetime_finish"];
		 }

		 if(isset($datetime_finish)){
			 array_multisort($product_code, array_map("strtotime", $datetime_finish), SORT_ASC, SORT_NUMERIC, $arrResultZensuHeadsmoto);
		 }
*/
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

//$arrResultZensuHeadsmoto完成
/*
echo "<pre>";
print_r($arrResultZensuHeadsmoto);
echo "</pre>";
*/
//$arrAssembleProductsスタート

				$arrAssembleProducts = array();//ここから組立品
				for($l=0; $l<count($arrResultZensuHeadsmoto); $l++){

					$AssembleProducts = $this->AssembleProducts->find()->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

					if(isset($AssembleProducts[0])){//AssembleProductsが存在する場合//組立

						$OrderEdisAssemble = $this->OrderEdis->find()//注文呼び出し//主要シートの絞込み
						->where(['product_code' => $arrResultZensuHeadsmoto[$l]["product_code"], 'delete_flag' => 0])
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

							$arrAssembleProducts = array_unique($arrAssembleProducts, SORT_REGULAR);
							$arrAssembleProducts = array_values($arrAssembleProducts);
/*
							$product_code = array();
							$kensabi = array();
							foreach ($arrAssembleProducts as $key => $value) {
  							 $product_code[$key] = $value['product_code'];
  							 $kensabi[$key] = $value["kensabi"];
  						 }

							 if(isset($kensabi)){
								 array_multisort($product_code, array_map( "strtotime", $kensabi ), SORT_ASC, SORT_NUMERIC, $arrAssembleProducts);
							 }
*/
						}

					}

				}


//$arrAssembleProducts完成
/*
echo "<pre>";
print_r($arrAssembleProducts);
echo "</pre>";
*/
//$arrOrderEdisスタート

				$OrderEdis = array();
				for($j=0; $j<count($arrProductsmoto); $j++){

					$OrderEdisdata = $this->OrderEdis->find()
					->where(['product_code' => $arrProductsmoto[$j]["product_code"], 'date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0])->order(["date_deliver"=>"ASC"])->toArray();

					if(isset($OrderEdisdata[0])){

						for($k=0; $k<count($OrderEdisdata); $k++){

							$OrderEdis[] = [
								'date_order' => $OrderEdisdata[$k]["date_order"],
								'num_order' => $OrderEdisdata[$k]["num_order"],
								'product_code' => $OrderEdisdata[$k]["product_code"],
								'price' => $OrderEdisdata[$k]["price"],
								'date_deliver' => $OrderEdisdata[$k]["date_deliver"],
								'amount' => $OrderEdisdata[$k]["amount"],
								'denpyoumaisu' => 1
						 ];

						}

					}else{

						$OrderEdis[] = [
							'date_order' => "",
	            'num_order' => "",
	            'product_code' => $arrProductsmoto[$j]["product_code"],
	            'product_name' => $arrProductsmoto[$j]["product_name"],
	            'price' => "",
	            'date_deliver' => "",
	            'amount' => "",
	            'denpyoumaisu' => ""
					 ];

					}

				}

				$arrOrderEdis = array();//注文呼び出し
		    for($k=0; $k<count($OrderEdis); $k++){

		      $Product = $this->Products->find()->where(['product_code' => $OrderEdis[$k]["product_code"]])->toArray();//productsの絞込み　primary

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
		       //     'riron_zaiko_check' => $riron_check
		         ];

		         for($l=0; $l<count($arrProductsmoto); $l++){

		           if($arrProductsmoto[$l]["product_code"] === $OrderEdis[$k]["product_code"]){

		     //        unset($arrProductsmoto[$l]);
		      //       $arrProductsmoto = array_values($arrProductsmoto);

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

		//    $arrOrderEdis = array_merge($arrOrderEdis, $arrProductsmoto);

//$arrOrderEdis完成
/*
echo "<pre>";
print_r(count($arrOrderEdis));
echo "</pre>";
echo "<pre>";
print_r($arrOrderEdis);
echo "</pre>";
*/
//$StockProductsスタート

			$StockProducts = array();
			for($j=0; $j<count($arrProductsmotominus); $j++){

				$StockProductsdata = $this->RironStockProducts->find()
				->where(['product_code' => $arrProductsmotominus[$j]["product_code"], 'date_culc >=' => $dateminussta, 'date_culc <=' => $dateminusfin])
				->order(["date_culc"=>"ASC"])->toArray();

				if(isset($StockProductsdata[0])){

					$StockProducts[] = [
						'product_code' => $StockProductsdata[0]["product_code"],
						'date_stock' => $StockProductsdata[0]["date_culc"],
						'amount' => $StockProductsdata[0]["amount"]
				 ];

				}

			}

				$arrStockProducts = array();
				for($k=0; $k<count($StockProducts); $k++){

					$Product = $this->Products->find()->where(['product_code' => $StockProducts[$k]["product_code"]])->toArray();

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

				$arrStockProducts = array_unique($arrStockProducts, SORT_REGULAR);
				$arrStockProducts = array_values($arrStockProducts);

/*
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
*/
//$StockProducts完成
/*
echo "<pre>";
print_r(count($StockProducts));
echo "</pre>";
echo "<pre>";
print_r($StockProducts);
echo "</pre>";
*/
//$SyoyouKeikakusスタート

				$SyoyouKeikakus = array();
				for($j=0; $j<count($arrProductsmotominus); $j++){

					$SyoyouKeikakusdata = $this->SyoyouKeikakus->find()
					->where(['product_code' => $arrProductsmotominus[$j]["product_code"], 'date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0])
					->order(["date_deliver"=>"ASC"])->toArray();

					for($k=0; $k<count($SyoyouKeikakusdata); $k++){

						if(isset($SyoyouKeikakusdata[$k])){

							$SyoyouKeikakus[] = [
								'product_code' => $SyoyouKeikakusdata[$k]["product_code"],
								'date_deliver' => $SyoyouKeikakusdata[$k]["date_deliver"],
								'amount' => $SyoyouKeikakusdata[$k]["amount"]
						 ];

						}

					}



				}

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
/*
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
*/
//$SyoyouKeikakus完成
/*
echo "<pre>";
print_r($arrSyoyouKeikakus);
echo "</pre>";
*/
//$arrSeisansスタート

				$daystart = $datestart." 08:00:00";
				$dayfin = $dateendnext." 07:59:59";

				$KadouSeikeis = array();
				for($j=0; $j<count($arrProductsmotominus); $j++){

					$KadouSeikeisdata = $this->KadouSeikeis->find()
					->where(['product_code' => $arrProductsmotominus[$j]["product_code"], 'starting_tm >=' => $daystart, 'starting_tm <=' => $dayfin])
					->order(["starting_tm"=>"ASC"])->toArray();

					for($k=0; $k<count($KadouSeikeisdata); $k++){

							if(isset($KadouSeikeisdata[$k])){

								$KadouSeikeis[] = [
									'product_code' => $KadouSeikeisdata[$k]["product_code"],
									'amount_shot' => $KadouSeikeisdata[$k]["amount_shot"],
									'starting_tm' => $KadouSeikeisdata[$k]['starting_tm']
							 ];

						 }

					}

				}

					$arrSeisans = array();
					for($k=0; $k<count($KadouSeikeis); $k++){

						$Product = $this->Products->find()->where(['product_code' => $KadouSeikeis[$k]["product_code"]])->toArray();//productsの絞込み　primary

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

					$arrSeisans = array_unique($arrSeisans, SORT_REGULAR);
					$arrSeisans = array_values($arrSeisans);

/*
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
*/
//$arrSeisans完成
/*
echo "<pre>";
print_r($arrProductsmotominus);
echo "</pre>";
echo "<pre>";
print_r($arrSeisans);
echo "</pre>";
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


	}
