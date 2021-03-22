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

				$MinusRironStockProducts = $this->MinusRironStockProducts->patchEntities($this->MinusRironStockProducts->newEntity(), $_SESSION['minusrironzaiko']);
				$connection = ConnectionManager::get('default');//トランザクション1
				// トランザクション開始2
				$connection->begin();//トランザクション3
				try {//トランザクション4

					$this->MinusRironStockProducts->deleteAll(['sheet_id' => $sheet_id]);

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

		//http://localhost:5000/Apirironzaikos/minuszaikoyobidashi/api/2021-3-10_m-zaiko0-1_primary.xml
		//http://192.168.4.246/Apirironzaikos/minuszaikoyobidashi/api/2021-3-10_m-zaiko0-1_primary.xml
		public function minuszaikoyobidashi()
		{
			$data = Router::reverse($this->request, false);//urlを取得
			$urlarr = explode("/",$data);//切り離し
			$dayarr = explode("_",$urlarr[4]);//切り離し

			if(isset($dayarr[3])){
				$sheetarr = explode(".",$dayarr[3]);//切り離し
				$sheet = $dayarr[2]."_".$sheetarr[0];//シート名の取得
			}else{
				$sheetarr = explode(".",$dayarr[2]);//切り離し
				$sheet = $sheetarr[0];//シート名の取得
			}

			$arryaermonth = explode("-",$dayarr[0]);
			$yaermonth = $arryaermonth[0]."-".$arryaermonth[1];

			$day = $dayarr[0];//日付の取得

			$date1 = $yaermonth."-1";//選択した日程の月の初日
			$date1st = strtotime($date1);
			$datenext1 = date('Y-m-d', strtotime('+30 day', $date1st));
			$datelast = strtotime($datenext1);
			$datelast = date('Y-m-d', strtotime('-1 day', $datelast));
			$dateback1 = date('Y-m-d', strtotime('-1 month', $date1st));//選択した月の前の月の初日//stockProductsに使用
			$dateback = strtotime($dateback1);
			$datebacklast = date('Y-m-d', strtotime('-1 day', $date1st));//選択した月の前の月の最後の日//stockProductsに使用

			$datestart = $dayarr[0];
			$datestartstr = strtotime($datestart);
			$dateend = date('Y-m-d', strtotime('+31 day', $datestartstr));
			$dateendnext = date('Y-m-d', strtotime('+32 day', $datestartstr));//kodouseikeisで使用

			$dateminus = $dayarr[0];
			$dateminussta = strtotime($datestart);

			if($dayarr[1] == "m-zaiko0-1"){
				$dateminussta = $dayarr[0];
				$dateminusfin = date('Y-m-d', strtotime('+7 day', $datestartstr));
			}else{
				$dateminussta = date('Y-m-d', strtotime('+7 day', $datestartstr));
				$dateminusfin = date('Y-m-d', strtotime('+14 day', $datestartstr));
			}

/*
			echo "<pre>";
			print_r($dateminussta);
			echo "</pre>";
			echo "<pre>";
			print_r($dateminusfin);
			echo "</pre>";
			echo "<pre>";
*/

			if($sheet === "primary"){

//$arrProductsmotoスタート

				$arrProducts = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
				->where(['products.status' => 0, 'primary_p' => 1,
				'OR' => [['product_code like' => 'P%'], ['product_code like' => 'AR%']]])->toArray();

				if(!isset($_SESSION)){
				session_start();
				}
				$_SESSION['classarrProducts'] = array();
				$_SESSION['classarrProducts'] = $arrProducts;
				$date16 = $yaermonth."-16";

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
				'OR' => [['product_code like' => 'P%'], ['product_code like' => 'AR%']]])//productsの絞込み　primary
				->order(["date_deliver"=>"ASC"])->toArray();

				$arrOrderEdis = array();//注文呼び出し
		    for($k=0; $k<count($OrderEdis); $k++){

		      $Product = $this->Products->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'status' => 0, 'primary_p' => 1])->toArray();//productsの絞込み　primary

		      if(isset($Product[0])){

		        $product_name = $Product[0]->product_name;

		        $riron_check = 0;
/*210223
		        $date16 = $yaermonth."-16";
		        $RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'date_culc' => $date16])->toArray();
		        if(isset($RironStockProducts[0])){
		          $riron_check = 1;
		        }
*/
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
				$date16 = $yaermonth."-16";

				//OrderEdisクラス使用
				$htmlApifind = new htmlApifind();//クラスを使用
				$arrOrderEdis = $htmlApifind->OrderEdis($date16);//クラスを使用

//$arrOrderEdis完成

//$StockProductsスタート

				$StockProducts = $this->MinusRironStockProducts->find()//月末在庫呼び出し//210216更新
				->where(['date_minus >=' => $dateminussta, 'date_minus <=' => $dateminusfin,
				//->where(['date_culc >=' => $day, 'date_culc <=' => $dateend,
				'OR' => [['product_code like' => 'P%'], ['product_code like' => 'AR%']]])
				->order(["date_minus"=>"ASC"])->toArray();

					$arrStockProducts = array();
					for($k=0; $k<count($StockProducts); $k++){

						$Product = $this->Products->find()->where(['product_code' => $StockProducts[$k]["product_code"], 'status' => 0, 'primary_p' => 1])->toArray();//productsの絞込み　primary

						if(isset($Product[0])){

							$arrStockProducts[] = [
								'product_code' => $StockProducts[$k]["product_code"],
								'date_stock' => $StockProducts[$k]["date_minus"],
								'amount' => $StockProducts[$k]["amount_minus"]
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
				$date16 = $yaermonth."-16";

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

						$riron_check = 0;
						/*210223
								        $date16 = $yaermonth."-16";
								        $RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'date_culc' => $date16])->toArray();
								        if(isset($RironStockProducts[0])){
								          $riron_check = 1;
								        }
						*/

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
				$date16 = $yaermonth."-16";

				//OrderEdisクラス使用
				$htmlApifind = new htmlApifind();//クラスを使用
				$arrOrderEdis = $htmlApifind->OrderEdis($date16);//クラスを使用

				//$arrOrderEdis完成

				//$StockProductsスタート

				$StockProducts = $this->MinusRironStockProducts->find()//月末在庫呼び出し
				->where(['date_minus >=' => $dateminussta, 'date_minus <=' => $dateminusfin])
				//->where(['date_culc >=' => $day, 'date_culc <=' => $dateend,
				->order(["date_minus"=>"ASC"])->toArray();

				$arrStockProducts = array();
				for($k=0; $k<count($StockProducts); $k++){

					$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
					->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'primary_p' => 1,
					'OR' => [['customer_code like' => '2%']]])->toArray();

					if(isset($Product[0])){

						$arrStockProducts[] = [
							'product_code' => $StockProducts[$k]["product_code"],
							'date_stock' => $StockProducts[$k]["date_minus"],
							'amount' => $StockProducts[$k]["amount_minus"]
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
				$date16 = $yaermonth."-16";

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

						$riron_check = 0;
						/*210223
								        $date16 = $yaermonth."-16";
								        $RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'date_culc' => $date16])->toArray();
								        if(isset($RironStockProducts[0])){
								          $riron_check = 1;
								        }
						*/

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
				$date16 = $yaermonth."-16";

				//OrderEdisクラス使用
				$htmlApifind = new htmlApifind();//クラスを使用
				$arrOrderEdis = $htmlApifind->OrderEdis($date16);//クラスを使用

				//$arrOrderEdis完成

				//$StockProductsスタート

				$StockProducts = $this->MinusRironStockProducts->find()//月末在庫呼び出し
				->where(['date_minus >=' => $dateminussta, 'date_minus <=' => $dateminusfin,
				//->where(['date_culc >=' => $day, 'date_culc <=' => $dateend,
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みprimary_w
				->order(["date_minus"=>"ASC"])->toArray();

				$arrStockProducts = array();
				for($k=0; $k<count($StockProducts); $k++){

					$Product = $this->Products->find()->where(['product_code' => $StockProducts[$k]["product_code"], 'status' => 0, 'primary_p' => 1])->toArray();//productsの絞込み　primary

					if(isset($Product[0])){

						$arrStockProducts[] = [
							'product_code' => $StockProducts[$k]["product_code"],
							'date_stock' => $StockProducts[$k]["date_minus"],
							'amount' => $StockProducts[$k]["amount_minus"]
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
				$date16 = $yaermonth."-16";

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
						/*210223
								        $date16 = $yaermonth."-16";
								        $RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'date_culc' => $date16])->toArray();
								        if(isset($RironStockProducts[0])){
								          $riron_check = 1;
								        }
						*/

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
				$date16 = $yaermonth."-16";

				//OrderEdisクラス使用
				$htmlApifind = new htmlApifind();//クラスを使用
				$arrOrderEdis = $htmlApifind->OrderEdis($date16);//クラスを使用

				//$arrOrderEdis完成

				//$StockProductsスタート

				$StockProducts = $this->MinusRironStockProducts->find()//月末在庫呼び出し
				->where(['date_minus >=' => $dateminussta, 'date_minus <=' => $dateminusfin,
				//->where(['date_culc >=' => $day, 'date_culc <=' => $dateend,
				'OR' => ['product_code like' => 'H%']])//productsの絞込みprimary_h
				->order(["date_minus"=>"ASC"])->toArray();

				$arrStockProducts = array();
				for($k=0; $k<count($StockProducts); $k++){

					$Product = $this->Products->find()->where(['product_code' => $StockProducts[$k]["product_code"], 'status' => 0])->toArray();//productsの絞込み　primary

					if(isset($Product[0])){

						$arrStockProducts[] = [
							'product_code' => $StockProducts[$k]["product_code"],
							'date_stock' => $StockProducts[$k]["date_minus"],
							'amount' => $StockProducts[$k]["amount_minus"]
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
				$date16 = $yaermonth."-16";

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

						$riron_check = 0;
						/*210223
								        $date16 = $yaermonth."-16";
								        $RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'date_culc' => $date16])->toArray();
								        if(isset($RironStockProducts[0])){
								          $riron_check = 1;
								        }
						*/

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
				$date16 = $yaermonth."-16";

				//OrderEdisクラス使用
				$htmlApifind = new htmlApifind();//クラスを使用
				$arrOrderEdis = $htmlApifind->OrderEdis($date16);//クラスを使用

				//$arrOrderEdis完成

				//$StockProductsスタート

				$StockProducts = $this->MinusRironStockProducts->find()//月末在庫呼び出し
				->where(['date_minus >=' => $dateminussta, 'date_minus <=' => $dateminusfin])
				->order(["date_minus"=>"ASC"])->toArray();

					$arrStockProducts = array();
					for($k=0; $k<count($StockProducts); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10005'])->toArray();//productsの絞込みreizouko

						if(isset($Product[0])){

							$arrStockProducts[] = [
								'product_code' => $StockProducts[$k]["product_code"],
								'date_stock' => $StockProducts[$k]["date_minus"],
								'amount' => $StockProducts[$k]["amount_minus"]
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
				$date16 = $yaermonth."-16";

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

						$riron_check = 0;
						/*210223
								        $date16 = $yaermonth."-16";
								        $RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'date_culc' => $date16])->toArray();
								        if(isset($RironStockProducts[0])){
								          $riron_check = 1;
								        }
						*/

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
				$date16 = $yaermonth."-16";

				//OrderEdisクラス使用
				$htmlApifind = new htmlApifind();//クラスを使用
				$arrOrderEdis = $htmlApifind->OrderEdis($date16);//クラスを使用

				//$arrOrderEdis完成

				//$StockProductsスタート

				$StockProducts = $this->MinusRironStockProducts->find()//月末在庫呼び出し
				->where(['date_minus >=' => $dateminussta, 'date_minus <=' => $dateminusfin])
				->order(["date_minus"=>"ASC"])->toArray();

					$arrStockProducts = array();
					for($k=0; $k<count($StockProducts); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10003'])->toArray();//productsの絞込みuwawaku

						if(isset($Product[0])){

							$arrStockProducts[] = [
								'product_code' => $StockProducts[$k]["product_code"],
								'date_stock' => $StockProducts[$k]["date_minus"],
								'amount' => $StockProducts[$k]["amount_minus"]
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
				$date16 = $yaermonth."-16";

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

						$riron_check = 0;
						/*210223
								        $date16 = $yaermonth."-16";
								        $RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'date_culc' => $date16])->toArray();
								        if(isset($RironStockProducts[0])){
								          $riron_check = 1;
								        }
						*/

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
				$date16 = $yaermonth."-16";

				//OrderEdisクラス使用
				$htmlApifind = new htmlApifind();//クラスを使用
				$arrOrderEdis = $htmlApifind->OrderEdis($date16);//クラスを使用

				//$arrOrderEdis完成

				//$StockProductsスタート

				$StockProducts = $this->MinusRironStockProducts->find()//月末在庫呼び出し
				->where(['date_minus >=' => $dateminussta, 'date_minus <=' => $dateminusfin])
				->order(["date_minus"=>"ASC"])->toArray();

					$arrStockProducts = array();
					for($k=0; $k<count($StockProducts); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'AND' => [['customer_code not like' => '1%'], ['customer_code not like' => '2%']]])//productsの絞込みother
						->toArray();//productsの絞込みother

						if(isset($Product[0])){

							$arrStockProducts[] = [
								'product_code' => $StockProducts[$k]["product_code"],
								'date_stock' => $StockProducts[$k]["date_minus"],
								'amount' => $StockProducts[$k]["amount_minus"]
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
				$date16 = $yaermonth."-16";

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

						$riron_check = 0;
						/*210223
								        $date16 = $yaermonth."-16";
								        $RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'date_culc' => $date16])->toArray();
								        if(isset($RironStockProducts[0])){
								          $riron_check = 1;
								        }
						*/

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
				$date16 = $yaermonth."-16";

				//OrderEdisクラス使用
				$htmlApifind = new htmlApifind();//クラスを使用
				$arrOrderEdis = $htmlApifind->OrderEdis($date16);//クラスを使用

				//$arrOrderEdis完成

				//$StockProductsスタート

				$StockProducts = $this->MinusRironStockProducts->find()//月末在庫呼び出し
				->where(['date_minus >=' => $dateminussta, 'date_minus <=' => $dateminusfin,
				'OR' => ['product_code like' => 'P0%']])//productsの絞込みp0
				->order(["date_minus"=>"ASC"])->toArray();

					$arrStockProducts = array();
					for($k=0; $k<count($StockProducts); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10001'])->toArray();//productsの絞込みp0

						if(isset($Product[0])){

							$arrStockProducts[] = [
								'product_code' => $StockProducts[$k]["product_code"],
								'date_stock' => $StockProducts[$k]["date_minus"],
								'amount' => $StockProducts[$k]["amount_minus"]
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
				$date16 = $yaermonth."-16";

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

						$riron_check = 0;
						/*210223
								        $date16 = $yaermonth."-16";
								        $RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'date_culc' => $date16])->toArray();
								        if(isset($RironStockProducts[0])){
								          $riron_check = 1;
								        }
						*/

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
				$date16 = $yaermonth."-16";

				//OrderEdisクラス使用
				$htmlApifind = new htmlApifind();//クラスを使用
				$arrOrderEdis = $htmlApifind->OrderEdis($date16);//クラスを使用

				//$arrOrderEdis完成

				//$StockProductsスタート

				$StockProducts = $this->MinusRironStockProducts->find()//月末在庫呼び出し
				->where(['date_minus >=' => $dateminussta, 'date_minus <=' => $dateminusfin,
				'OR' => [['product_code like' => 'P1%'], ['product_code like' => 'P2%']]])//productsの絞込みp1
				->order(["date_minus"=>"ASC"])->toArray();

					$arrStockProducts = array();
					for($k=0; $k<count($StockProducts); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10001'])->toArray();//productsの絞込みp1

						if(isset($Product[0])){

							$arrStockProducts[] = [
								'product_code' => $StockProducts[$k]["product_code"],
								'date_stock' => $StockProducts[$k]["date_minus"],
								'amount' => $StockProducts[$k]["amount_minus"]
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
				$date16 = $yaermonth."-16";

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

						$riron_check = 0;
						/*210223
								        $date16 = $yaermonth."-16";
								        $RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'date_culc' => $date16])->toArray();
								        if(isset($RironStockProducts[0])){
								          $riron_check = 1;
								        }
						*/

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
				$date16 = $yaermonth."-16";

				//OrderEdisクラス使用
				$htmlApifind = new htmlApifind();//クラスを使用
				$arrOrderEdis = $htmlApifind->OrderEdis($date16);//クラスを使用

				//$arrOrderEdis完成

				//$StockProductsスタート

				$StockProducts = $this->MinusRironStockProducts->find()//月末在庫呼び出し
				->where(['date_minus >=' => $dateminussta, 'date_minus <=' => $dateminusfin,
				'OR' => [['product_code like' => 'W%'], ['product_code like' => 'AW%']]])//productsの絞込みw
				->order(["date_minus"=>"ASC"])->toArray();

					$arrStockProducts = array();
					for($k=0; $k<count($StockProducts); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'customer_code' => '10002'])->toArray();//productsの絞込みw

						if(isset($Product[0])){

							$arrStockProducts[] = [
								'product_code' => $StockProducts[$k]["product_code"],
								'date_stock' => $StockProducts[$k]["date_minus"],
								'amount' => $StockProducts[$k]["amount_minus"]
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
				$date16 = $yaermonth."-16";

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

						$riron_check = 0;
						/*210223
								        $date16 = $yaermonth."-16";
								        $RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'date_culc' => $date16])->toArray();
								        if(isset($RironStockProducts[0])){
								          $riron_check = 1;
								        }
						*/

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
				$date16 = $yaermonth."-16";

				//OrderEdisクラス使用
				$htmlApifind = new htmlApifind();//クラスを使用
				$arrOrderEdis = $htmlApifind->OrderEdis($date16);//クラスを使用

				//$arrOrderEdis完成

				//$StockProductsスタート

				$StockProducts = $this->MinusRironStockProducts->find()//月末在庫呼び出し
				->where(['date_minus >=' => $dateminussta, 'date_minus <=' => $dateminusfin])
				->order(["date_minus"=>"ASC"])->toArray();

					$arrStockProducts = array();
					for($k=0; $k<count($StockProducts); $k++){

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $StockProducts[$k]["product_code"], 'products.status' => 0, 'customer_code like' => '2%'])->toArray();//productsの絞込みdnp

						if(isset($Product[0])){

							$arrStockProducts[] = [
								'product_code' => $StockProducts[$k]["product_code"],
								'date_stock' => $StockProducts[$k]["date_minus"],
								'amount' => $StockProducts[$k]["amount_minus"]
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
				$date16 = $yaermonth."-16";

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

						$riron_check = 0;
						/*210223
								        $date16 = $yaermonth."-16";
								        $RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $OrderEdis[$k]["product_code"], 'date_culc' => $date16])->toArray();
								        if(isset($RironStockProducts[0])){
								          $riron_check = 1;
								        }
						*/

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
				$date16 = $yaermonth."-16";

				//OrderEdisクラス使用
				$htmlApifind = new htmlApifind();//クラスを使用
				$arrOrderEdis = $htmlApifind->OrderEdis($date16);//クラスを使用

				//$arrOrderEdis完成

				//$StockProductsスタート

				$StockProducts = $this->MinusRironStockProducts->find()//月末在庫呼び出し
				->where(['date_minus >=' => $dateminussta, 'date_minus <=' => $dateminusfin,
				'OR' => [['product_code like' => 'W0602%'], ['product_code like' => 'P160K%'], ['product_code like' => 'P12%']]])//productsの絞込みsinsei
				->order(["date_minus"=>"ASC"])->toArray();

					$arrStockProducts = array();
					for($k=0; $k<count($StockProducts); $k++){

						$Product = $this->Products->find()->where(['product_code' => $StockProducts[$k]["product_code"], 'status' => 0])->toArray();//productsの絞込みsinsei

						if(isset($Product[0])){

							$arrStockProducts[] = [
								'product_code' => $StockProducts[$k]["product_code"],
								'date_stock' => $StockProducts[$k]["date_minus"],
								'amount' => $StockProducts[$k]["amount_minus"]
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
