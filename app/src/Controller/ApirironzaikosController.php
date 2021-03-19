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

class ApirironzaikosController extends AppController
	{

		public function initialize()
		{
		 parent::initialize();
		 $this->RironStockProducts = TableRegistry::get('rironStockProducts');
		 $this->MinusRironStockProducts = TableRegistry::get('minusRironStockProducts');
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

		//http://localhost:5000/Apirironzaikos/minuszaiko/api/start.xml
		//http://192.168.4.246/Apirironzaikos/minuszaiko/api/start.xml
		//http://localhost:5000/Apirironzaikos/minuszaiko/api/主要_2021-3-12_P002X-15310_2021-3-20_-500.xml
		//http://192.168.4.246/Apirironzaikos/minuszaiko/api/「シートID」_「理論在庫日」_「品番」_「マイナス日」_「マイナス数量」.xml
		//http://localhost:5000/Apirironzaikos/minuszaiko/api/end.xml
		//http://192.168.4.246/Apirironzaikos/minuszaiko/api/end.xml
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

			if($urlarr[4] == "start.xml"){

				$_SESSION['minusrironzaiko'] = array();
				$_SESSION['minusrironzaikoupdate'] = array();

			}elseif(isset($dataarr[2])){

				$arramount = explode(".",$dataarr[4]);//切り離し
				$amount = $arramount[0];

				$minusrironzaikovba['sheet_id'] = $dataarr[0];
				$minusrironzaikovba['date_riron_stock'] = $dataarr[1];
				$minusrironzaikovba['product_code'] = $dataarr[2];
				$minusrironzaikovba['date_minus'] = $dataarr[3];
				$minusrironzaikovba['amount_minus'] = $amount;
				$minusrironzaikovba['created_at'] = date('Y-m-d H:i:s');

				$MinusRironStockProducts = $this->MinusRironStockProducts->find()->where(['date_riron_stock' => $dataarr[1], 'product_code' => $dataarr[2]])->toArray();
				if(!isset($MinusRironStockProducts[0])){

					$session = $this->request->getSession();
					$_SESSION['minusrironzaiko'][] = $minusrironzaikovba;

				}else{

					$minusrironzaikovba['id'] = $MinusRironStockProducts[0]->id;

					$session = $this->request->getSession();
					$_SESSION['minusrironzaikoupdate'][] = $minusrironzaikovba;

				}

			}elseif($urlarr[4] == "end.xml"){

				$session = $this->request->getSession();

				//新しいデータを登録
				if(count($_SESSION['minusrironzaiko']) > 0) {

					$MinusRironStockProducts = $this->MinusRironStockProducts->patchEntities($this->MinusRironStockProducts->newEntity(), $_SESSION['minusrironzaiko']);

				}

				$connection = ConnectionManager::get('default');//トランザクション1
				// トランザクション開始2
				$connection->begin();//トランザクション3
				try {//トランザクション4

					if(count($_SESSION['minusrironzaiko']) < 1){//新規登録データがない場合

						if(isset($_SESSION['minusrironzaikoupdate'][0])){

							for($k=0; $k<count($_SESSION['minusrironzaikoupdate']); $k++){

								$this->MinusRironStockProducts->updateAll(
								['sheet_id' => $_SESSION['minusrironzaikoupdate'][$k]["sheet_id"],
								 'date_riron_stock' => $_SESSION['minusrironzaikoupdate'][$k]["date_riron_stock"],
								 'product_code' => $_SESSION['minusrironzaikoupdate'][$k]["product_code"],
								 'date_minus' => $_SESSION['minusrironzaikoupdate'][$k]["date_minus"],
								 'amount_minus' => $_SESSION['minusrironzaikoupdate'][$k]["amount_minus"],
								 'updated_at' => date('Y-m-d H:i:s')],
								['id' => $_SESSION['minusrironzaikoupdate'][$k]["id"]]
								);

							}

						}

						$connection->commit();// コミット5
						$_SESSION['minusrironzaiko'] = array();
						$_SESSION['minusrironzaikoupdate'] = array();

					}

					if(count($_SESSION['minusrironzaiko']) > 0 && $this->MinusRironStockProducts->saveMany($MinusRironStockProducts)) {

						if(isset($_SESSION['minusrironzaikoupdate'][0])){

							for($k=0; $k<count($_SESSION['minusrironzaikoupdate']); $k++){

								$this->MinusRironStockProducts->updateAll(
									['sheet_id' => $_SESSION['minusrironzaikoupdate'][$k]["sheet_id"],
									 'date_riron_stock' => $_SESSION['minusrironzaikoupdate'][$k]["date_riron_stock"],
									 'product_code' => $_SESSION['minusrironzaikoupdate'][$k]["product_code"],
									 'date_minus' => $_SESSION['minusrironzaikoupdate'][$k]["date_minus"],
									 'amount_minus' => $_SESSION['minusrironzaikoupdate'][$k]["amount_minus"],
									 'updated_at' => date('Y-m-d H:i:s')],
									['id' => $_SESSION['minusrironzaikoupdate'][$k]["id"]]
								);

							}

						}

						$connection->commit();// コミット5
						$_SESSION['minusrironzaiko'] = array();
						$_SESSION['minusrironzaikoupdate'] = array();

					} else {

						for($k=0; $k<count($_SESSION['minusrironzaikoupdate']); $k++){

							$this->MinusRironStockProducts->updateAll(
								['sheet_id' => $_SESSION['minusrironzaikoupdate'][$k]["sheet_id"],
								 'date_riron_stock' => $_SESSION['minusrironzaikoupdate'][$k]["date_riron_stock"],
								 'product_code' => $_SESSION['minusrironzaikoupdate'][$k]["product_code"],
								 'date_minus' => $_SESSION['minusrironzaikoupdate'][$k]["date_minus"],
								 'amount_minus' => $_SESSION['minusrironzaikoupdate'][$k]["amount_minus"],
								 'updated_at' => date('Y-m-d H:i:s')],
								['id' => $_SESSION['minusrironzaikoupdate'][$k]["id"]]
							);

						}

						$this->Flash->error(__('The data could not be saved. Please, try again.'));
						throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6

						$_SESSION['minusrironzaiko'] = array();
						$_SESSION['minusrironzaikoupdate'] = array();

					}

				} catch (Exception $e) {//トランザクション7
				//ロールバック8
					$connection->rollback();//トランザクション9
				}//トランザクション10

				$_SESSION['minusrironzaiko'] = array();
				$_SESSION['minusrironzaikoupdate'] = array();

			}

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

	}
