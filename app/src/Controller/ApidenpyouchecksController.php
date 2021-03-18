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

class ApidenpyouchecksController extends AppController
	{

		public function initialize()
		{
		 parent::initialize();
		 $this->Konpous = TableRegistry::get('konpous');
		 $this->Products = TableRegistry::get('products');
     $this->Customers = TableRegistry::get('customers');
     $this->Users = TableRegistry::get('users');
		 $this->OrderEdis = TableRegistry::get('orderEdis');
		 $this->DenpyouDnpMinoukannous = TableRegistry::get('denpyouDnpMinoukannous');
		 $this->KensahyouJyunbiInsatsus = TableRegistry::get('kensahyouJyunbiInsatsus');
		 $this->KensahyouSokuteidatas = TableRegistry::get('kensahyouSokuteidatas');
		 $this->KensahyouHeads = TableRegistry::get('kensahyouHeads');//kensahyouHeadsテーブルを使う
		}

//http://192.168.4.246/Apidenpyouchecks/test/api/test.xml  http://localhost:5000/Apidenpyouchecks/test/api/test.xml
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

//http://192.168.4.246/Apidenpyouchecks/yobidashi/api/2021-3-9.xml
		public function yobidashi()//http://localhost:5000/Apidenpyouchecks/yobidashi/api/2021-3-9.xml
		{
			$data = Router::reverse($this->request, false);//文字化けする後で2回変換すると日本語OK
			$data = urldecode($data);

			$urlarr = explode("/",$data);//切り離し
			if(isset($urlarr[5])){
				$urlarr[4] = $urlarr[4]."/".$urlarr[5];
			}
			$dataarr = explode(".",$urlarr[4]);//切り離し
			$check_date = $dataarr[0];

			$OrderEdis = $this->OrderEdis->find()
			->where(['date_deliver' => $check_date, 'delete_flag' => 0, 'place_deliver_code IS NOT' => '00000'])
			->order(["product_code"=>"ASC"])->toArray();
/*
			echo "<pre>";
			print_r(count($OrderEdis));
			echo "</pre>";
*/
			$denpyoucheckyobidashi = array();

			for($k=0; $k<count($OrderEdis); $k++){

				$Product = $this->Products->find()
				->where(['product_code' => $OrderEdis[$k]->product_code])->toArray();

				$Konpous = $this->Konpous->find()
				->where(['product_code' => $OrderEdis[$k]->product_code, 'delete_flag' => 0])->toArray();
				if(isset($Konpous[0])){
					$hakosu = floor($OrderEdis[$k]->amount / $Konpous[0]->irisu);
					$amari = $OrderEdis[$k]->amount % $Konpous[0]->irisu;
				}else{
					$hakosu = "";
					$amari = "";
				}

				$denpyoucheck['date_deliver'] = $check_date;
				$denpyoucheck['num_order'] = $OrderEdis[$k]->num_order;
				$denpyoucheck['product_code'] = $OrderEdis[$k]->product_code;
				$denpyoucheck['product_name'] = $Product[0]->product_name;
				$denpyoucheck['amount'] = $OrderEdis[$k]->amount;
				$denpyoucheck['place_line'] = $OrderEdis[$k]->place_line;
				$denpyoucheck['hakosu'] = $hakosu;
				$denpyoucheck['amari'] = $amari;

				$denpyoucheckyobidashi[] = $denpyoucheck;

			}

			$count = 0;
			$total = 0;
			for($l=1; $l<count($denpyoucheckyobidashi); $l++){

				if($denpyoucheckyobidashi[$l-1]['product_code'] == $denpyoucheckyobidashi[$l]['product_code'] && $denpyoucheckyobidashi[$l-1]['place_line'] == $denpyoucheckyobidashi[$l]['place_line']){

					$count = $count + 1;

					$denpyoucheckyobidashi[$l-1]['hakosu'] = 0;
					$denpyoucheckyobidashi[$l-1]['amari'] = 0;

				}elseif($count > 0){

					for($m=0; $m<=$count; $m++){

						$total = $total + $denpyoucheckyobidashi[$l-$m-1]['amount'];

					}

					$Konpous = $this->Konpous->find()
					->where(['product_code' => $denpyoucheckyobidashi[$l-1]['product_code'], 'delete_flag' => 0])->toArray();
					if(isset($Konpous[0])){
						$hakosu = floor($total / $Konpous[0]->irisu);
						$amari = $total % $Konpous[0]->irisu;
					}else{
						$hakosu = "";
						$amari = "";
					}
					$denpyoucheckyobidashi[$l-1]['hakosu'] = $hakosu;
					$denpyoucheckyobidashi[$l-1]['amari'] = $amari;
/*
					echo "<pre>";
					print_r($total." / ".$Konpous[0]->irisu." = ".$hakosu." ... ".$amari);
					echo "</pre>";
*/
					$count = 0;
					$total = 0;

				}

			}


			$this->set([
					'kikakuyobidashi' => $denpyoucheckyobidashi,
					'_serialize' => ['kikakuyobidashi']
			]);

		}


		public function dnpnouhin()//http://localhost:5000/Apidenpyouchecks/dnpnouhin/api/2021-1-6.xml
		{
			$data = Router::reverse($this->request, false);//文字化けする後で2回変換すると日本語OK
			$data = urldecode($data);

			$urlarr = explode("/",$data);//切り離し
			if(isset($urlarr[5])){
				$urlarr[4] = $urlarr[4]."/".$urlarr[5];
			}
			$dataarr = explode(".",$urlarr[4]);//切り離し
			$check_date = $dataarr[0];

			$DenpyouDnpMinoukannous = $this->DenpyouDnpMinoukannous->find()->contain(["OrderEdis"])
			->where(['date_deliver' => $check_date])
			->order(["product_code"=>"ASC"])->toArray();
/*
			echo "<pre>";
			print_r($DenpyouDnpMinoukannous);
			echo "</pre>";
*/
			$arrdnpyobidashi = array();

			for($k=0; $k<count($DenpyouDnpMinoukannous); $k++){

				$Konpous = $this->Konpous->find()
				->where(['product_code' => $DenpyouDnpMinoukannous[$k]['order_edi']->product_code, 'delete_flag' => 0])->toArray();
				if(isset($Konpous[0])){
					$irisu = $Konpous[0]->irisu;
				}else{
					$irisu = "入数が登録されていません";
				}

				$dnpyobidashi['num_order'] = $DenpyouDnpMinoukannous[$k]['order_edi']->num_order;
				$dnpyobidashi['product_code'] = $DenpyouDnpMinoukannous[$k]['order_edi']->product_code;
				$dnpyobidashi['name_order'] = $DenpyouDnpMinoukannous[$k]->name_order;
				$dnpyobidashi['line_code'] = $DenpyouDnpMinoukannous[$k]['order_edi']->line_code;
				$dnpyobidashi['place_line'] = $DenpyouDnpMinoukannous[$k]['order_edi']->place_line;
				$dnpyobidashi['date_order'] = $DenpyouDnpMinoukannous[$k]['order_edi']->date_order;
				$dnpyobidashi['amount'] = $DenpyouDnpMinoukannous[$k]['order_edi']->amount;
				$dnpyobidashi['date_deliver'] = $DenpyouDnpMinoukannous[$k]['order_edi']->date_deliver;
				$dnpyobidashi['kannou'] = $DenpyouDnpMinoukannous[$k]['order_edi']->kannou;
				$dnpyobidashi['irisu'] = $irisu;

				$arrdnpyobidashi[] = $dnpyobidashi;

			}

			$product_code = array();
			$num_order = array();
			foreach ($arrdnpyobidashi as $key => $value) {
				 $product_code[$key] = $value['product_code'];
				 $num_order[$key] = $value["num_order"];
			 }

			 if(isset($product_code)){
				 array_multisort($product_code, $num_order, SORT_ASC, SORT_NUMERIC, $arrdnpyobidashi);
			 }

			$this->set([
  			 'test' => $arrdnpyobidashi,
  			 '_serialize' => ['test']
  		 ]);

		}

//http://localhost:5000/Apidenpyouchecks/insatsujunbi/api/kusatsu.xml
//http://localhost:5000/Apidenpyouchecks/insatsujunbi/api/other.xml
//http://localhost:5000/Apidenpyouchecks/insatsujunbi/api/dnp.xml
		public function insatsujunbi()
		{
			$data = Router::reverse($this->request, false);//文字化けする後で2回変換すると日本語OK
			$data = urldecode($data);

			$urlarr = explode("/",$data);//切り離し
			$dataarr = explode(".",$urlarr[4]);//切り離し
			$check_kind = $dataarr[0];

			$KensahyouJyunbiInsatsus = $this->KensahyouJyunbiInsatsus->find('all')->toArray();

			$arrinsatsujunbi = array();

			if($check_kind == "kusatsu"){//草津

				for($k=0; $k<count($KensahyouJyunbiInsatsus); $k++){

					if($KensahyouJyunbiInsatsus[$k]["field"] == "10001"){

						$KensahyouSokuteidatas = $this->KensahyouSokuteidatas->find()
		        ->where(['id' => $KensahyouJyunbiInsatsus[$k]["kensahyou_heads_id"]])->toArray();
						$product_code = $KensahyouSokuteidatas[0]->product_code;
						$lot_num = $KensahyouSokuteidatas[0]->lot_num;

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $product_code])->toArray();

						$insatsujunbi['kensahyou_heads_id'] = $KensahyouJyunbiInsatsus[$k]->kensahyou_heads_id;
						$insatsujunbi['product_code'] = $product_code;
						$insatsujunbi['product_name'] = $Product[0]->product_name;
						$insatsujunbi['date_deliver'] = $KensahyouJyunbiInsatsus[$k]->date_deliver;
						$insatsujunbi['amount'] = $KensahyouJyunbiInsatsus[$k]->amount;
						$insatsujunbi['manu_date'] = $KensahyouSokuteidatas[0]->manu_date;
						$insatsujunbi['place_line'] = $KensahyouJyunbiInsatsus[$k]->place_line;

						$arrinsatsujunbi[] = $insatsujunbi;

						$this->KensahyouJyunbiInsatsus->deleteAll(['id' => $KensahyouJyunbiInsatsus[$k]["id"]]);

						$kensahyou_sokuteidata_head_id = $product_code."-".$lot_num;

						$connection = ConnectionManager::get('DB_ikou_test');
						$table = TableRegistry::get('kensahyou_jyunbi_insatsu');
						$table->setConnection($connection);

						$delete_kensahyou_jyunbi_insatsu = "DELETE FROM kensahyou_jyunbi_insatsu where kensahyou_sokuteidata_head_id = '".$kensahyou_sokuteidata_head_id."'";
						$connection->execute($delete_kensahyou_jyunbi_insatsu);

						$connection = ConnectionManager::get('default');//新DBに戻る
						$table->setConnection($connection);


					}

				}

			}elseif($check_kind == "other"){//その他

				for($k=0; $k<count($KensahyouJyunbiInsatsus); $k++){

					if($KensahyouJyunbiInsatsus[$k]["field"] == "99999"){

						$KensahyouSokuteidatas = $this->KensahyouSokuteidatas->find()
						->where(['id' => $KensahyouJyunbiInsatsus[$k]["kensahyou_heads_id"]])->toArray();
						$product_code = $KensahyouSokuteidatas[0]->product_code;
						$lot_num = $KensahyouSokuteidatas[0]->lot_num;

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $product_code,
						'OR' => [['customer_code not like' => '2%']]])->toArray();

						if(isset($Product[0])){

							$insatsujunbi['kensahyou_heads_id'] = $KensahyouJyunbiInsatsus[$k]->kensahyou_heads_id;
							$insatsujunbi['product_code'] = $product_code;
							$insatsujunbi['product_name'] = $Product[0]->product_name;
							$insatsujunbi['date_deliver'] = $KensahyouJyunbiInsatsus[$k]->date_deliver;
							$insatsujunbi['amount'] = $KensahyouJyunbiInsatsus[$k]->amount;
							$insatsujunbi['manu_date'] = $KensahyouSokuteidatas[0]->manu_date;
			//				$insatsujunbi['place_line'] = $KensahyouJyunbiInsatsus[$k]->place_line;

							$arrinsatsujunbi[] = $insatsujunbi;

							$this->KensahyouJyunbiInsatsus->deleteAll(['id' => $KensahyouJyunbiInsatsus[$k]["id"]]);

							$kensahyou_sokuteidata_head_id = $product_code."-".$lot_num;

							$connection = ConnectionManager::get('DB_ikou_test');
							$table = TableRegistry::get('kensahyou_jyunbi_insatsu');
							$table->setConnection($connection);

							$delete_kensahyou_jyunbi_insatsu = "DELETE FROM kensahyou_jyunbi_insatsu where kensahyou_sokuteidata_head_id = '".$kensahyou_sokuteidata_head_id."'";
							$connection->execute($delete_kensahyou_jyunbi_insatsu);

							$connection = ConnectionManager::get('default');//新DBに戻る
							$table->setConnection($connection);

						}

					}

				}

			}else{//dnp

				for($k=0; $k<count($KensahyouJyunbiInsatsus); $k++){

					if($KensahyouJyunbiInsatsus[$k]["field"] == "99999"){

						$KensahyouSokuteidatas = $this->KensahyouSokuteidatas->find()
						->where(['id' => $KensahyouJyunbiInsatsus[$k]["kensahyou_heads_id"]])->toArray();
						$product_code = $KensahyouSokuteidatas[0]->product_code;
						$lot_num = $KensahyouSokuteidatas[0]->lot_num;

						$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
						->where(['product_code' => $product_code,
						'OR' => [['customer_code like' => '2%']]])->toArray();

						if(isset($Product[0])){

							$insatsujunbi['kensahyou_heads_id'] = $KensahyouJyunbiInsatsus[$k]->kensahyou_heads_id;
							$insatsujunbi['product_code'] = $product_code;
							$insatsujunbi['product_name'] = $Product[0]->product_name;
							$insatsujunbi['date_deliver'] = $KensahyouJyunbiInsatsus[$k]->date_deliver;
							$insatsujunbi['amount'] = $KensahyouJyunbiInsatsus[$k]->amount;
							$insatsujunbi['manu_date'] = $KensahyouSokuteidatas[0]->manu_date;
							$insatsujunbi['place_line'] = $KensahyouJyunbiInsatsus[$k]->place_line;

							$arrinsatsujunbi[] = $insatsujunbi;

							$this->KensahyouJyunbiInsatsus->deleteAll(['id' => $KensahyouJyunbiInsatsus[$k]["id"]]);

							$kensahyou_sokuteidata_head_id = $product_code."-".$lot_num;

							$connection = ConnectionManager::get('DB_ikou_test');
							$table = TableRegistry::get('kensahyou_jyunbi_insatsu');
							$table->setConnection($connection);

							$delete_kensahyou_jyunbi_insatsu = "DELETE FROM kensahyou_jyunbi_insatsu where kensahyou_sokuteidata_head_id = '".$kensahyou_sokuteidata_head_id."'";
							$connection->execute($delete_kensahyou_jyunbi_insatsu);

							$connection = ConnectionManager::get('default');//新DBに戻る
							$table->setConnection($connection);

						}

					}

				}

			}

			$this->set([
  			 'insatsujunbi' => $arrinsatsujunbi,
  			 '_serialize' => ['insatsujunbi']
  		 ]);

		}

		//http://localhost:5000/Apidenpyouchecks/kensahyousyuturyoku/api/87621.xml
		public function kensahyousyuturyoku()
		{
			$data = Router::reverse($this->request, false);//文字化けする後で2回変換すると日本語OK
			$data = urldecode($data);

			$urlarr = explode("/",$data);//切り離し
			$dataarr = explode(".",$urlarr[4]);//切り離し
			$sokuteidata_id = $dataarr[0];

			$arrkensahyousyuturyoku = array();

			$KensahyouSokuteidatas = $this->KensahyouSokuteidatas->find()
			->where(['id' => $sokuteidata_id])->toArray();

			$kensahyousyuturyoku['code'] = $KensahyouSokuteidatas[0]->product_code."-".$KensahyouSokuteidatas[0]->lot_num;
			$kensahyousyuturyoku['lot_num'] = $KensahyouSokuteidatas[0]->lot_num;
			$kensahyousyuturyoku['manu_date'] = $KensahyouSokuteidatas[0]->manu_date;
			$kensahyousyuturyoku['inspec_date'] = $KensahyouSokuteidatas[0]->inspec_date;

			$arrkensahyousyuturyoku[] = $kensahyousyuturyoku;

			$this->set([
  			 'test' => $arrkensahyousyuturyoku,
  			 '_serialize' => ['test']
  		 ]);

		}

		//http://localhost:5000/Apidenpyouchecks/kensahyoukikaku/api/P002X-05Z20.xml
		public function kensahyoukikaku()
		{
			$data = Router::reverse($this->request, false);//文字化けする後で2回変換すると日本語OK
			$data = urldecode($data);

			$urlarr = explode("/",$data);//切り離し
			$dataarr = explode(".",$urlarr[4]);//切り離し
			$product_code = $dataarr[0];

			$KensahyouHeads = $this->KensahyouHeads->find()
			->where(['product_code' => $product_code])->order(["version"=>"DESC"])->toArray();

			$arrkensahyoukikaku = array();

			$kensahyoukikaku['size_1'] = $KensahyouHeads[0]->size_1;
			$kensahyoukikaku['upper_1'] = $KensahyouHeads[0]->upper_1;
			$kensahyoukikaku['lower_1'] = $KensahyouHeads[0]->lower_1;
			$kensahyoukikaku['size_2'] = $KensahyouHeads[0]->size_2;
			$kensahyoukikaku['upper_2'] = $KensahyouHeads[0]->upper_2;
			$kensahyoukikaku['lower_2'] = $KensahyouHeads[0]->lower_2;
			$kensahyoukikaku['size_3'] = $KensahyouHeads[0]->size_3;
			$kensahyoukikaku['upper_3'] = $KensahyouHeads[0]->upper_3;
			$kensahyoukikaku['lower_3'] = $KensahyouHeads[0]->lower_3;
			$kensahyoukikaku['size_4'] = $KensahyouHeads[0]->size_4;
			$kensahyoukikaku['upper_4'] = $KensahyouHeads[0]->upper_4;
			$kensahyoukikaku['lower_4'] = $KensahyouHeads[0]->lower_4;
			$kensahyoukikaku['size_5'] = $KensahyouHeads[0]->size_5;
			$kensahyoukikaku['upper_5'] = $KensahyouHeads[0]->upper_5;
			$kensahyoukikaku['lower_5'] = $KensahyouHeads[0]->lower_5;
			$kensahyoukikaku['size_6'] = $KensahyouHeads[0]->size_6;
			$kensahyoukikaku['upper_6'] = $KensahyouHeads[0]->upper_6;
			$kensahyoukikaku['lower_6'] = $KensahyouHeads[0]->lower_6;
			$kensahyoukikaku['size_7'] = $KensahyouHeads[0]->size_7;
			$kensahyoukikaku['upper_7'] = $KensahyouHeads[0]->upper_7;
			$kensahyoukikaku['lower_7'] = $KensahyouHeads[0]->lower_7;
			$kensahyoukikaku['size_8'] = $KensahyouHeads[0]->size_8;
			$kensahyoukikaku['upper_8'] = $KensahyouHeads[0]->upper_8;
			$kensahyoukikaku['lower_8'] = $KensahyouHeads[0]->lower_8;
			$kensahyoukikaku['size_9'] = $KensahyouHeads[0]->size_9;
			$kensahyoukikaku['bik'] = $KensahyouHeads[0]->bik;

			$arrkensahyoukikaku[] = $kensahyoukikaku;

			$this->set([
  			 'KensahyouHeads' => $arrkensahyoukikaku,
  			 '_serialize' => ['KensahyouHeads']
  		 ]);

		}

		//http://localhost:5000/Apidenpyouchecks/kensahyousokutei/api/87621.xml
		public function kensahyousokutei()
		{
			$data = Router::reverse($this->request, false);//文字化けする後で2回変換すると日本語OK
			$data = urldecode($data);

			$urlarr = explode("/",$data);//切り離し
			$dataarr = explode(".",$urlarr[4]);//切り離し
			$sokuteidata_id = $dataarr[0];

			$KensahyouSokuteidatas = $this->KensahyouSokuteidatas->find()
			->where(['id' => $sokuteidata_id])->toArray();
			$product_code = $KensahyouSokuteidatas[0]->product_code;
			$lot_num = $KensahyouSokuteidatas[0]->lot_num;

			$Product = $this->Products->find()->contain(["Customers"])//ProductsテーブルとCustomersテーブルを関連付ける
			->where(['product_code' => $product_code])->toArray();

			$KensahyouSokuteidatas = $this->KensahyouSokuteidatas->find()
			->where(['product_code' => $product_code, 'lot_num' => $lot_num])->order(["cavi_num"=>"ASC"])->toArray();

			$arrkensahyousokutei = array();

			for($k=0; $k<count($KensahyouSokuteidatas); $k++){

//				$kensahyousokutei['cavi_num'] = $KensahyouSokuteidatas[$k]->cavi_num;
				$kensahyousokutei['result_size_1'] = $KensahyouSokuteidatas[$k]->result_size_1;
				$kensahyousokutei['result_size_2'] = $KensahyouSokuteidatas[$k]->result_size_2;
				$kensahyousokutei['result_size_3'] = $KensahyouSokuteidatas[$k]->result_size_3;
				$kensahyousokutei['result_size_4'] = $KensahyouSokuteidatas[$k]->result_size_4;
				$kensahyousokutei['result_size_5'] = $KensahyouSokuteidatas[$k]->result_size_5;
				$kensahyousokutei['result_size_6'] = $KensahyouSokuteidatas[$k]->result_size_6;
				$kensahyousokutei['result_size_7'] = $KensahyouSokuteidatas[$k]->result_size_7;
				$kensahyousokutei['result_size_8'] = $KensahyouSokuteidatas[$k]->result_size_8;
				$kensahyousokutei['result_size_9'] = $KensahyouSokuteidatas[$k]->result_size_9;
				$kensahyousokutei['situation_dist1'] = $KensahyouSokuteidatas[$k]->situation_dist1;
				$kensahyousokutei['situation_dist2'] = $KensahyouSokuteidatas[$k]->situation_dist2;
				$kensahyousokutei['result_weight'] = $KensahyouSokuteidatas[$k]->result_weight;

				$kensahyousokutei['customer_code'] = $Product[0]["customer"]->customer_code;

				$arrkensahyousokutei[] = $kensahyousokutei;

			}

			$this->set([
  			 'test' => $arrkensahyousokutei,
  			 '_serialize' => ['test']
  		 ]);

		}

	}
