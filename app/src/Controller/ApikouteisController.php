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
		}

//http://192.168.4.246/Apikouteis/test/api/test.xml  http://localhost:5000/Apikouteis/test/api/test.xml
		public function test()
		{
	//		$this->request->session()->destroy();//セッションの破棄
//実験
			session_start();
			$session = $this->request->getSession();
			$_SESSION['test'][0] = 1;

	//		echo "<pre>";
	//		print_r($_SESSION);
	//		echo "</pre>";

			$this->set([
  			 'test' => "aaa",
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

				for($i=1; $i<=9; $i++){//size_1～9までセット
          $kikakuyobidashi["size_".$i] = $KouteiKensahyouHeads[0]->{"size_{$i}"};//KensahyouHeadのsize_1～9まで
        }

				for($j=1; $j<=8; $j++){//upper_1～8,lowerr_1～8までセット
          $kikakuyobidashi["upper_".$j] = $KouteiKensahyouHeads[0]->{"upper_{$j}"};//KensahyouHeadのupper_1～8まで
          $kikakuyobidashi["lower_".$j] = $KouteiKensahyouHeads[0]->{"lower_{$j}"};//KensahyouHeadのlowerr_1～8まで
        }

				$kikakuyobidashi['text_10'] = $KouteiKensahyouHeads[0]->text_10;
				$kikakuyobidashi['text_11'] = $KouteiKensahyouHeads[0]->text_11;
				$kikakuyobidashi['bik'] = $KouteiKensahyouHeads[0]->bik;

			}else{

				for($i=1; $i<=9; $i++){//size_1～9までセット
          $kikakuyobidashi["size_".$i] = "";
        }
				for($j=1; $j<=8; $j++){//upper_1～8,lowerr_1～8までセット
          $kikakuyobidashi["upper_".$i] = "";
          $kikakuyobidashi["lower_".$i] = "";
        }
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
					->where(['kind_kensa' => $product_code."_".$KouteiImKikakuTaious[$i]->kind_kensa, 'lot_num' => $lot_num])->toArray();
					$check_kind_kensa = $KouteiImSokuteidataHeads[0]->kind_kensa;
/*
					echo "<pre>";
					print_r($i." ".$check_kind_kensa." ".$KouteiImSokuteidataHeads[0]->id." ".$KouteiImKikakuTaious[$i]->im_size_num);
					echo "</pre>";
*/
					for($j=0; $j<count($KouteiImSokuteidataHeads); $j++){

						$KouteiImSokuteidataResults = $this->KouteiImSokuteidataResults->find()
						->where(['im_sokuteidata_head_id' => $KouteiImSokuteidataHeads[0]->id, 'size_num' => $KouteiImKikakuTaious[$i]->im_size_num])->toArray();

						for($k=0; $k<count($KouteiImSokuteidataResults); $k++){

							$sokutei['type_im'] = $KouteiImSokuteidataHeads[$j]['type_im'];
							$sokutei['result'] = $KouteiImSokuteidataResults[$k]['result'];

							$sokuteiyobidashi[] = $sokutei;
						}

					}

				}

			}
/*
			echo "<pre>";
			print_r($sokuteiyobidashi);
			echo "</pre>";
*/
			$this->set([
					'kikakuyobidashi' => $sokuteiyobidashi,
					'_serialize' => ['kikakuyobidashi']
			]);

		}



	}
