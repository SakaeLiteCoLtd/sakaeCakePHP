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

use App\myClass\Apizaiko\apizaikoprogram;//myClassフォルダに配置したクラスを使用

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
			session_start();
			$session = $this->request->getSession();

			$session = $this->request->getSession();
			$session->delete('rironzaiko');//指定のセッションを削除

			echo "<pre>";
			print_r($_SESSION);
			echo "</pre>";
		}

//文字化けの対応テスト
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

		}

		public function tourokuzaiko()
		{
			$data = Router::reverse($this->request, false);//文字化けする後で2回変換すると日本語OK
			$data = urldecode($data);

			$urlarr = explode("/",$data);//切り離し
			$dataarr = explode("_",$urlarr[4]);//切り離し

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

				$session = $this->request->getSession();

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

			$arryaermonthday = explode("-",$dateminus);
			$arr = array();
			$arr[] = [
				'yaer' => $arryaermonthday[0],
				'month' => $arryaermonthday[1],
				'day' => $arryaermonthday[2],
		 ];

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
				$sheet_date = "m-zaiko0-1";
				$dateminussta = $MinusRironStockProducts[0]['date_riron_stock']->format('Y-m-d');
				$dateminusstaminus = date('Y-m-d', strtotime('-2 day', $dateminusstr));
				$dateminusfin = date('Y-m-d', strtotime('+7 day', $dateminusstr));
			}else{
				$sheet_date = "m-zaiko1-2";
				$dateminussta = $MinusRironStockProducts[0]['date_riron_stock']->format('Y-m-d');
				$dateminusstaminus = date('Y-m-d', strtotime('+8 day', $dateminusstr));
				$dateminusfin = date('Y-m-d', strtotime('+14 day', $dateminusstr));
			}

			$arryaermonth = explode("-",$dateminussta);
			$yaermonth = $arryaermonth[0]."-".$arryaermonth[1];

			$date1 = $yaermonth."-1";//選択した日程の月の初日
			$date1st = strtotime($date1);
			$datenext1 = date('Y-m-d', strtotime('+30 day', $date1st));//選択した日程の月の30日後

			$datestart = $dateminussta;
			$datestartstr = strtotime($dateminussta);
			$dateend = date('Y-m-d', strtotime('+31 day', $datestartstr));

//$arrProductsmotoスタート

				$MinusRironStockProducts = $this->MinusRironStockProducts->find()//MinusRironStockProductsテーブルで、date_riron_stockから1週間以内（１～２週間以内）にマイナスになる品番を絞り込み
				->where(['date_riron_stock' => $dateminus, 'date_minus >=' => $dateminusstaminus, 'date_minus <=' => $dateminusfin])
				->order(["date_minus"=>"ASC"])->toArray();

					$arrProducts = array();
					for($k=0; $k<count($MinusRironStockProducts); $k++){
						$Product = $this->Products->find()->where(['product_code' => $MinusRironStockProducts[$k]["product_code"]])->toArray();
						if(isset($Product[0])){
							$arrProducts[] = [
								'product_code' => $MinusRironStockProducts[$k]["product_code"],
								'product_name' => $Product[0]["product_name"],
						 ];
						}
					}

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
				$arrProductsmotominus = $arrProductsmoto;

//$arrResultZensuHeadsmotoスタート

		$date1_datenext1 = $datestart."_".$dateend;
		$apizaikoprogram = new apizaikoprogram();
		$arrResultZensuHeadsmoto = $apizaikoprogram->classResultZensuHeads($date1_datenext1);//ResultZensuHeadsからデータを取得

//$arrResultZensuHeadsmoto完成
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
						}
					}
				}

//$arrAssembleProducts完成
//$arrOrderEdisスタート

				$OrderEdis = array();
				for($j=0; $j<count($arrProductsmoto); $j++){
					$OrderEdisdata = $this->OrderEdis->find()
					->where(['product_code' => $arrProductsmoto[$j]["product_code"], 'date_deliver >=' => $datestart, 'date_deliver <=' => $dateend, 'delete_flag' => 0])
					->order(["date_deliver"=>"ASC"])->toArray();
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
		         ];
		      }
		    }

				$countmax = count($arrOrderEdis);

		    //同一のproduct_code、date_deliverの注文は一つにまとめ、amountとdenpyoumaisuを更新
		    for($l=0; $l<count($arrOrderEdis); $l++){
		      for($m=$l+1; $m<$countmax; $m++){
		        if(isset($arrOrderEdis[$m]["product_code"])){
		          if($arrOrderEdis[$l]["product_code"] == $arrOrderEdis[$m]["product_code"] && $arrOrderEdis[$l]["date_deliver"] == $arrOrderEdis[$m]["date_deliver"]){
		            $amount = (int)$arrOrderEdis[$l]["amount"] + (int)$arrOrderEdis[$m]["amount"];
		            $denpyoumaisu = $arrOrderEdis[$l]["denpyoumaisu"] + $arrOrderEdis[$m]["denpyoumaisu"];
		            $arrOrderEdis[$l]["amount"] = $amount;
		            $arrOrderEdis[$l]["denpyoumaisu"] = $denpyoumaisu;
		            unset($arrOrderEdis[$m]);
		          }
		        }
		      }
		      $arrOrderEdis = array_values($arrOrderEdis);
		    }

//$arrOrderEdis完成
//$StockProductsスタート

			$StockProducts = array();
			for($j=0; $j<count($arrProductsmotominus); $j++){
				$RironStockProducts = $this->RironStockProducts->find()
				->where(['product_code' => $arrProductsmotominus[$j]["product_code"], 'date_culc >=' => $dateminussta, 'date_culc <=' => $dateminusfin])
				->order(["date_culc"=>"ASC"])->toArray();
				if(isset($RironStockProducts[0])){
					$StockProducts[] = [
						'product_code' => $RironStockProducts[0]["product_code"],
						'date_stock' => $RironStockProducts[0]["date_culc"],
						'amount' => $RironStockProducts[0]["amount"]
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

//$StockProducts完成
//$SyoyouKeikakusスタート

				$todaySyoyouKeikakus = date('Y-m-d');
				$this->SyoyouKeikakus->deleteAll(['date_deliver <' => $todaySyoyouKeikakus]);//当日の前日までの所要計画のデータは削除する
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

//$SyoyouKeikakus完成
//$arrSeisansスタート

				$daystart = $date1." 08:00:00";
				$dayfin = $datenext1." 07:59:59";
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

//$arrSeisans完成

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
