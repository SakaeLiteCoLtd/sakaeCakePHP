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


	}
