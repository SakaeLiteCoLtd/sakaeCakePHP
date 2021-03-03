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

class ApikouteisController extends AppController
	{

		public function initialize()
		{
		 parent::initialize();
		 $this->Katakouzous = TableRegistry::get('katakouzous');
		 $this->Products = TableRegistry::get('products');
     $this->Customers = TableRegistry::get('customers');
     $this->Users = TableRegistry::get('users');
     $this->KouteiImSokuteidataHeads = TableRegistry::get('kouteiImSokuteidataHeads');
     $this->KouteiImKikakus = TableRegistry::get('kouteiImKikakus');
     $this->KouteiImSokuteidataResults = TableRegistry::get('kouteiImSokuteidataResults');
     $this->KouteiImKikakuTaious = TableRegistry::get('kouteiImKikakuTaious');
     $this->KouteiKensahyouHeads = TableRegistry::get('kouteiKensahyouHeads');
     $this->KouteiFileCopyChecks = TableRegistry::get('kouteiFileCopyChecks');
     $this->KensahyouHeads = TableRegistry::get('kensahyouHeads');
		 $this->KensahyouSokuteidatas = TableRegistry::get('kensahyouSokuteidatas');
		 $this->CheckKouteis = TableRegistry::get('checkKouteis');
		 $this->ResultCheckKouteis = TableRegistry::get('resultCheckKouteis');
		}

//http://192.168.4.246/Apikouteis/test/api/test.xml  http://localhost:5000/Apikouteis/test/api/test.xml
		public function test()
		{
		//	$this->request->session()->destroy();//セッションの破棄
//実験
			session_start();
			$session = $this->request->getSession();
			$_SESSION['test'][0] = 1;

			echo "<pre>";
			print_r($_SESSION);
			echo "</pre>";

			$this->set([
  			 'test' => "セッション表示中",
  			 '_serialize' => ['test']
  		 ]);

		}

//http://192.168.4.246/Apikouteis/kikakuyobidashi/api/MLD-MD-20035.xml
		public function kikakuyobidashi()//http://localhost:5000/Apikouteis/kikakuyobidashi/api/MLD-MD-20035.xml
		{
			$data = Router::reverse($this->request, false);//文字化けする後で2回変換すると日本語OK
			$data = urldecode($data);

			$urlarr = explode("/",$data);//切り離し
			if(isset($urlarr[5])){
				$urlarr[4] = $urlarr[4]."/".$urlarr[5];
			}
			$dataarr = explode(".",$urlarr[4]);//切り離し
			$product_code = $dataarr[0];

			$Katakouzous = $this->Katakouzous->find()->where(['product_code' => $product_code, 'delete_flag' => 0])->toArray();
			if(isset($Katakouzous[0])){
			$torisu = $Katakouzous[0]->torisu;
			}else{
			$torisu = 0;
			}

			$Product = $this->Products->find()->where(['product_code' => $product_code, 'delete_flag' => 0])->toArray();
			if(isset($Product[0])){
			$product_name = $Product[0]->product_name;
			}else{
			$product_name = "";
			}

			$kikakuyobidashi['product_code'] = $product_code;
			$kikakuyobidashi['product_name'] = $product_name;
			$kikakuyobidashi['torisu'] = $torisu;

			$KouteiKensahyouHeads = $this->KouteiKensahyouHeads->find()->where(['product_code' => $product_code, 'delete_flag' => 0])->toArray();
			if(isset($KouteiKensahyouHeads[0])){
/*
				for($i=1; $i<=9; $i++){//size_1～9までセット
          $kikakuyobidashi["size_".$i] = $KouteiKensahyouHeads[0]->{"size_{$i}"};
        }
*/
				for($j=1; $j<=8; $j++){//upper_1～8,lowerr_1～8までセット

					$KouteiImKikakuTaious = $this->KouteiImKikakuTaious->find()->where(['product_code' => $product_code, 'kensahyou_size' => $j])->toArray();

					if(isset($KouteiImKikakuTaious[0])){
						$kikakuyobidashi["kind_kensa_".$j] = $KouteiImKikakuTaious[0]->kind_kensa;
					}else{
						$kikakuyobidashi["kind_kensa_".$j] = "";
					}
					$kikakuyobidashi["size_".$j] = $KouteiKensahyouHeads[0]->{"size_{$j}"};
          $kikakuyobidashi["upper_".$j] = $KouteiKensahyouHeads[0]->{"upper_{$j}"};
          $kikakuyobidashi["lower_".$j] = $KouteiKensahyouHeads[0]->{"lower_{$j}"};
        }

				$KouteiImKikakuTaious = $this->KouteiImKikakuTaious->find()->where(['product_code' => $product_code, 'kensahyou_size' => 9])->toArray();
				if(isset($KouteiImKikakuTaious[0])){
					$kikakuyobidashi["kind_kensa_9"] = $KouteiImKikakuTaious[0]->kind_kensa;
				}else{
					$kikakuyobidashi["kind_kensa_9"] = "";
				}
				$kikakuyobidashi["size_9"] = $KouteiKensahyouHeads[0]->size_9;
				$kikakuyobidashi['text_10'] = $KouteiKensahyouHeads[0]->text_10;
				$kikakuyobidashi['text_11'] = $KouteiKensahyouHeads[0]->text_11;
				$kikakuyobidashi['bik'] = $KouteiKensahyouHeads[0]->bik;

			}else{
/*
				for($i=1; $i<=9; $i++){//size_1～9までセット
          $kikakuyobidashi["size_".$i] = "";
        }
	*/
				for($j=1; $j<=8; $j++){//upper_1～8,lowerr_1～8までセット
					$kikakuyobidashi["size_".$j] = "";
          $kikakuyobidashi["upper_".$j] = "";
          $kikakuyobidashi["lower_".$j] = "";
        }

				$kikakuyobidashi["size_9"] = "";
				$kikakuyobidashi['text_10'] = "";
				$kikakuyobidashi['text_11'] = "";
				$kikakuyobidashi['bik'] = "";

			}

			$this->set([
					'kikakuyobidashi' => $kikakuyobidashi,
					'_serialize' => ['kikakuyobidashi']
			]);

		}

		//http://192.168.4.246/Apikouteis/sokuteiyobidashi/api/IN.210217-112_MLD-MD-20035.xml
		public function sokuteiyobidashi()//http://localhost:5000/Apikouteis/sokuteiyobidashi/api/IN.210217-112_MLD-MD-20035.xml
		{
			$data = Router::reverse($this->request, false);//文字化けする後で2回変換すると日本語OK
			$data = urldecode($data);

			$urlarr = explode("/",$data);//切り離し
			if(isset($urlarr[5])){
				$urlarr[4] = $urlarr[4]."/".$urlarr[5];
			}

			$dataarr = explode("_",$urlarr[4]);//切り離し
			$lot_num = $dataarr[0];

			$product_arr = explode(".",$dataarr[1]);//切り離し
			$product_code = $product_arr[0];
/*
			echo "<pre>";
			print_r($lot_num);
			echo "</pre>";
			echo "<pre>";
			print_r($product_code);
			echo "</pre>";
*/
			$Katakouzous = $this->Katakouzous->find()->where(['product_code' => $product_code, 'delete_flag' => 0])->toArray();
			if(isset($Katakouzous[0])){
			$torisu = $Katakouzous[0]->torisu;
			}else{
			$torisu = 0;
			}

			$Product = $this->Products->find()->where(['product_code' => $product_code, 'delete_flag' => 0])->toArray();
			if(isset($Product[0])){
			$product_name = $Product[0]->product_name;
			}else{
			$product_name = "";
			}

			$sokuteiyobidashi = array();

			$KouteiImKikakuTaious = $this->KouteiImKikakuTaious->find()->where(['product_code' => $product_code])->toArray();
			if(isset($KouteiImKikakuTaious[0])){

				for($i=0; $i<count($KouteiImKikakuTaious); $i++){

					$sokutei['product_code'] = $product_code;
					$sokutei['product_name'] = $product_name;
					$sokutei['torisu'] = $torisu;
					$sokutei['kensahyou_size'] = $KouteiImKikakuTaious[$i]->kensahyou_size;
					$sokutei['kind_kensa'] = $KouteiImKikakuTaious[$i]->kind_kensa;
					$sokutei['im_size_num'] = $KouteiImKikakuTaious[$i]->im_size_num;

					$KouteiImSokuteidataHeads = $this->KouteiImSokuteidataHeads->find()
					->where(['kind_kensa' => $product_code."_".$KouteiImKikakuTaious[$i]->kind_kensa, 'lot_num' => $lot_num])
					->order(["id"=>"DESC"])->toArray();
					$check_kind_kensa = $KouteiImSokuteidataHeads[0]->kind_kensa;
/*
					echo "<pre>";
					print_r($i." ".$check_kind_kensa." ".$KouteiImSokuteidataHeads[0]->id." ".$KouteiImKikakuTaious[$i]->im_size_num);
					echo "</pre>";
*/
					for($j=0; $j<count($KouteiImSokuteidataHeads); $j++){

						$KouteiImSokuteidataResults = $this->KouteiImSokuteidataResults->find()
						->where(['im_sokuteidata_head_id' => $KouteiImSokuteidataHeads[$j]->id, 'size_num' => $KouteiImKikakuTaious[$i]->im_size_num])
						->toArray();

						for($k=0; $k<count($KouteiImSokuteidataResults); $k++){

							$sokutei['type_im'] = $KouteiImSokuteidataHeads[$j]['type_im'];
							$sokutei['result'] = $KouteiImSokuteidataResults[$k]['result'];
							$sokutei['serial'] = floor($KouteiImSokuteidataResults[$k]['serial']);
							$sokutei['koutei_im_sokuteidata_heads_id'] = $KouteiImSokuteidataHeads[$j]->id;
							$sokutei['inspec_datetime'] = $KouteiImSokuteidataResults[$k]['inspec_datetime'];
				//			$sokutei['Headsid'] = floor($KouteiImSokuteidataHeads[$j]['id']);
							$sokutei['Headsid'] = floor(-$KouteiImSokuteidataHeads[$j]['id']);
							$sokutei['Resultsid'] = floor(-$KouteiImSokuteidataResults[$k]['id']);

							$sokuteiyobidashi[] = $sokutei;
						}

					}

				}

			}
/*
			$Headsid = array();
			$Resultsid = array();
			foreach($sokuteiyobidashi as $key => $row ) {
				$Headsid[$key] = $row["Headsid"];
				$Resultsid[$key] = $row["Resultsid"];
			}

			if(count($sokuteiyobidashi) > 0){
				array_multisort($Headsid, $Resultsid, SORT_DESC, SORT_NUMERIC, $sokuteiyobidashi);
			}
*/
			$Headsid = array();
			$serialarr = array();
			foreach($sokuteiyobidashi as $key => $row ) {
				$Headsid[$key] = $row["Headsid"];
				$serialarr[$key] = $row["serial"];
			}

			if(count($sokuteiyobidashi) > 0){
				array_multisort($Headsid, $serialarr, SORT_ASC, SORT_NUMERIC, $sokuteiyobidashi);
			}

/*
			echo "<pre>";
			print_r($sokuteiyobidashi);
			echo "</pre>";
*/

			for($k=0; $k<count($sokuteiyobidashi); $k++){

				unset($sokuteiyobidashi[$k]['Headsid']);
				unset($sokuteiyobidashi[$k]['Resultsid']);

			}
/*
			$this->set([
					'kikakuyobidashi' => $sokuteiyobidashi,
					'_serialize' => ['kikakuyobidashi']
			]);
*/

			$sokuteiyobidashidatas = array();
			$KouteiImKikakuTaious = $this->KouteiImKikakuTaious->find()->where(['product_code' => $product_code])
			->order(["kensahyou_size"=>"DESC"])->toArray();
			$kensahyou_size_max = $KouteiImKikakuTaious[0]->kensahyou_size;
			$type_im = $sokuteiyobidashi[0]['type_im'];

		//	$sokuteiyobidashidatas = $kensahyou_size_max." ".$torisu." ".$type_im;

			for($j=1; $j<=$torisu; $j++){

				$sokuteituika = array();
				$kensahyou_size = array();

				for($k=1; $k<=$kensahyou_size_max; $k++){

					for($m=0; $m<count($sokuteiyobidashi); $m++){

						if($sokuteiyobidashi[$m]["type_im"] == $type_im && $sokuteiyobidashi[$m]["serial"] == $j && $sokuteiyobidashi[$m]["kensahyou_size"] == $k){

							$kensahyou_size["kensahyou_size"][] = "";
							$kensahyou_size["kensahyou_size"][] = "";
							$kensahyou_size["kensahyou_size"][] = $sokuteiyobidashi[$m]["kensahyou_size"];
							$sokuteituika["result_".$j."_".$k."_id"][] = $sokuteiyobidashi[$m]["koutei_im_sokuteidata_heads_id"];
							$sokuteituika["result_".$j."_".$k."_type_im"][] = $sokuteiyobidashi[$m]["type_im"];
							$sokuteituika["result_".$j."_".$k][] = $sokuteiyobidashi[$m]["result"];
/*
							echo "<pre>";
							print_r($sokuteiyobidashi[$m]["result"]);
							echo "</pre>";
*/
						}

					}

				}


				if(!isset($sokuteiyobidashinum[0])){
					$sokuteiyobidashinum[] = $kensahyou_size;
				}

				$sokuteiyobidashidatas[] = $sokuteituika;

			}
/*
			echo "<pre>";
			print_r($sokuteiyobidashidatas);
			echo "</pre>";
*/
			$this->set([
				'kikakuyobidashinum' => $sokuteiyobidashinum,
				'kikakuyobidashi' => $sokuteiyobidashidatas,
				'_serialize' => ['kikakuyobidashinum','kikakuyobidashi']
			]);

		}

		//http://192.168.4.246/Apikouteis/kouteicheck/api/IN.210217-112_MLD-MD-20035.xml
		public function kouteicheck()//http://localhost:5000/Apikouteis/kouteicheck/api/IN.210217-112_MLD-MD-20035_hirokawa.xml
		{
			$data = Router::reverse($this->request, false);//文字化けする後で2回変換すると日本語OK
			$data = urldecode($data);

			$urlarr = explode("/",$data);//切り離し
			$dataarr = explode("_",$urlarr[4]);//切り離し
			$lot_num = $dataarr[0];
			$product_code = $dataarr[1];

			$emp_arr = explode(".",$dataarr[2]);//切り離し
			$emp = $emp_arr[0];
/*
			echo "<pre>";
			print_r($lot_num);
			echo "</pre>";
			echo "<pre>";
			print_r($product_code);
			echo "</pre>";
			echo "<pre>";
			print_r($emp);
			echo "</pre>";
*/
			$kouteicheck['product_code'] = $product_code;
			$kouteicheck['lot_num'] = $lot_num;
			$kouteicheck['emp'] = $emp;
			$kouteicheck['datetime_graph'] = date('Y-m-d H:i:s');

			$CheckKouteis = $this->CheckKouteis->patchEntity($this->CheckKouteis->newEntity(), $kouteicheck);
			$connection = ConnectionManager::get('default');//トランザクション1
			 // トランザクション開始2
			 $connection->begin();//トランザクション3
			 try {//トランザクション4
				 if ($this->CheckKouteis->save($CheckKouteis)) {
				 $connection->commit();// コミット5

			 } else {

				 $this->Flash->error(__('The product could not be saved. Please, try again.'));
				 throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6

			 }

		 } catch (Exception $e) {//トランザクション7
		 //ロールバック8
			 $connection->rollback();//トランザクション9
		 }//トランザクション10

			$this->set([
					'kikakuyobidashi' => $kouteicheck,
					'_serialize' => ['kikakuyobidashi']
			]);

		}

		//http://localhost:5000/Apikouteis/bunpujoukyou/api/start.xml
		//http://localhost:5000/Apikouteis/bunpujoukyou/api/IN.210217-112_MLD-MD-20035_3_0.xml
		//http://localhost:5000/Apikouteis/bunpujoukyou/api/IN.210217-112_BON-MD-20023_4_1.xml
		//http://localhost:5000/Apikouteis/bunpujoukyou/api/end.xml

		//http://192.168.4.246/Apikouteis/bunpujoukyou/api/start.xml
		//http://192.168.4.246/Apikouteis/bunpujoukyou/api/IN.210217-112_MLD-MD-20035_3_0.xml
		//http://192.168.4.246/Apikouteis/bunpujoukyou/api/IN.210217-112_BON-MD-20023_4_1.xml
		//http://192.168.4.246/Apikouteis/bunpujoukyou/api/end.xml
		public function bunpujoukyou()
		{
			$data = Router::reverse($this->request, false);//文字化けする後で2回変換すると日本語OK
			$data = urldecode($data);

			$urlarr = explode("/",$data);//切り離し

			$dataarr = explode("_",$urlarr[4]);//切り離し

			if($dataarr[0] == "start.xml"){

				session_start();
				if(isset($_SESSION['sessionbunpu'][0])){//誰かがボタンを押して終了していない場合

					sleep(5);//5秒待機

					$_SESSION['sessionbunpu'] = array();
					$_SESSION['bunpuvba'] = array();
					$_SESSION['resultbunpu'] = array();
					$_SESSION['sessionbunpu'][0] = 0;

				}else{//同時に誰もスタートしていない場合

					$_SESSION['bunpuvba'] = array();
					$_SESSION['resultbunpu'] = array();
					$_SESSION['sessionbunpu'][0] = 0;

				}
				$bunpujoukyou['start'] = "start";

			}elseif(isset($dataarr[2])){

				session_start();
				$session = $this->request->getSession();

				$lot_num = $dataarr[0];
				$product_code = $dataarr[1];
				$size_num = $dataarr[2];

				$status_arr = explode(".",$dataarr[3]);//切り離し
				$status = $status_arr[0];

				$bunpujoukyou['product_code'] = $product_code;
				$bunpujoukyou['lot_num'] = $lot_num;
				$bunpujoukyou['status'] = $status;
				$bunpujoukyou['update_datetime'] = date('Y-m-d H:i:s');

				$_SESSION['bunpuvba'][] = $bunpujoukyou;

				if($status > 0){

					$CheckKouteis = $this->CheckKouteis->find('all')
					->where(['product_code' => $product_code, 'lot_num' => $lot_num])->toArray();

					for($l=0; $l<count($CheckKouteis); $l++){

						$check_koutei_id = $CheckKouteis[$l]->id;

						$resultbunpu['check_koutei_id'] = $check_koutei_id;
						$resultbunpu['size_num'] = $size_num;
						$resultbunpu['status'] = $status;
						$resultbunpu['update_datetime'] = date('Y-m-d H:i:s');

						$_SESSION['resultbunpu'][] = $resultbunpu;

					}

				}

				$this->set([
						'kikakuyobidashi' => $bunpujoukyou,
						'_serialize' => ['kikakuyobidashi']
				]);

			}elseif($dataarr[0] == "end.xml"){//終了の時に一括でデータを登録してそのセッションを削除

				$bunpujoukyou['end'] = "end";

				session_start();
				$session = $this->request->getSession();

				for($k=0; $k<count($_SESSION['bunpuvba']); $k++){

					$this->CheckKouteis->updateAll(
					['status' => $_SESSION['bunpuvba'][$k]["status"],
					 'update_datetime' => date('Y-m-d H:i:s')],
					['product_code' => $_SESSION['bunpuvba'][$k]["product_code"], 'lot_num' => $_SESSION['bunpuvba'][$k]["lot_num"]]
					);

				}

				//新しいデータを登録
				$ResultCheckKouteis = $this->ResultCheckKouteis->patchEntities($this->ResultCheckKouteis->newEntity(), $_SESSION['resultbunpu']);
				$connection = ConnectionManager::get('default');//トランザクション1
				// トランザクション開始2
				$connection->begin();//トランザクション3
				try {//トランザクション4

					if ($this->ResultCheckKouteis->saveMany($ResultCheckKouteis)) {

						$connection->commit();// コミット5
						$_SESSION['sessionbunpu'] = array();
						$_SESSION['bunpuvba'] = array();
						$_SESSION['resultbunpu'] = array();

					} else {

						$this->Flash->error(__('The data could not be saved. Please, try again.'));
						throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
						$_SESSION['sessionbunpu'] = array();
						$_SESSION['bunpuvba'] = array();
						$_SESSION['resultbunpu'] = array();

					}

				} catch (Exception $e) {//トランザクション7
				//ロールバック8
					$connection->rollback();//トランザクション9
				}//トランザクション10

			}

			$this->set([
					'kikakuyobidashi' => $bunpujoukyou,
					'_serialize' => ['kikakuyobidashi']
			]);

		}


	}
