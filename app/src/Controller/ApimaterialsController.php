<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

use Cake\Utility\Xml;//xmlのファイルを読み込みために必要

use Cake\Routing\Router;//urlの取得
use Cake\Http\Client;//httpの読取に必要
//use Cake\Http\ServerRequest;

class ApimaterialsController extends AppController
	{

		public function initialize()
		{
		 parent::initialize();
		 $this->loadComponent('RequestHandler');

		 $this->response->header("Access-Control-Allow-Origin: *");//https://shota-natuta.hatenablog.com/entry/2017/02/08/230211 ブラウザ側に安全を保証してますよって伝えてる
		 $this->response->header("Access-Control-Allow-Headers: Content-Type");
		 $this->response->header("Access-Control-Allow-Credentials: true");
		 $this->response->header("Access-Control-Allow-Methods: POST, PUT, DELETE, PATCH");

	//	 $this->Materials = TableRegistry::get('materials');
		 $this->PriceMaterials = TableRegistry::get('priceMaterials');
		 $this->StockEndMaterials = TableRegistry::get('stockEndMaterials');
		 $this->Users = TableRegistry::get('users');
		}
/*
ルール参考　https://qiita.com/TakahiRoyte/items/949f4e88caecb02119aa
①登録 POST    https://192.168.4.246/Apimaterials/hazaitouroku/api.json
②取得 GET     https://192.168.4.246/Apimaterials/hazaitouroku/grade_color_lotnum.json
③更新 PUT     https://192.168.4.246/Apimaterials/hazaitouroku/grade_color_lotnum.json
④削除 DELETE  https://192.168.4.246/Apimaterials/hazaitouroku/grade_color_lotnum.json
*/
		//json出力
    //参考　https://qiita.com/tatamix/items/1758ed25442cc6940411
		//http://192.168.4.246/Apimaterials/materails/api.json
		//http://localhost:5000/Apimaterials/materails/api.json
		
    public function materails()//ここは使用中
		{
			header("Access-Control-Allow-Origin: *");//https://helog.jp/php/ajax-php-cors/ ブラウザ側に安全を保証してますよって伝えてるappコントローラーに追加

			$PriceMaterials = $this->PriceMaterials->find()->where(['delete_flag' => 0])->toArray();

			$arrMaterials = array();//空の配列を作る
			for($k=0; $k<count($PriceMaterials); $k++){

				$arrMaterials[] = [
					'id' => $PriceMaterials[$k]["id"],//配列に追加する
					'grade_color' => $PriceMaterials[$k]["grade"]."_".$PriceMaterials[$k]["color"]//配列に追加する
				];

			}

      $this->viewBuilder()->className('Json');

      $this->set([
				'arrMaterials' => $arrMaterials,
        '_serialize' => ['arrMaterials']
      ]);

    }

//https://192.168.4.246/Apimaterials/hazaitouroku/api.json
		public function hazaitouroku($id)//http://localhost:5000/Apimaterials/hazaitouroku/3.json
		{

			if($this->request->is(['post'])) {//登録postの時

				$mess = "method = post";

				$arr = $this->request->getData();

				$arrTourokuStockEndMaterials = array();//空の配列を作る

				$PriceMaterials = $this->PriceMaterials->find()
				->where(['grade' => $arr["grade"], 'color' => $arr["color"]])->toArray();

				if(isset($PriceMaterials[0])){
					$id = $PriceMaterials[0]["id"];
				}else{
					$id = 999999;
				}
				$arrTourokuStockEndMaterials[] = [
					'price_material_id' => $id,
					'status_material' => $arr["status_material"],
					'amount' => $arr["amount"],
					'state' => 0,
					'status_import_tab' => 0,
					'delete_flag' => 0,
					'created_at' => date('Y-m-d H:i:s'),
					'created_staff' => $arr["staff_id"],
				];

				foreach ((array) $arrTourokuStockEndMaterials as $key => $value) {//並び替え
					$sort[$key] = $value['price_material_id'];
				}
				array_multisort($sort, SORT_ASC, $arrTourokuStockEndMaterials);

				$price_material_idArray = array_column($arrTourokuStockEndMaterials, 'price_material_id');
				$arrCountmaterials = array_count_values($price_material_idArray);//カウントする

				$lotdate = date('y').date('m').date('d');

				for($k=0; $k<count($arrTourokuStockEndMaterials); $k++){//ロットナンバーを追加

					if($k == 0){//最初または前のidと違うときはロットナンバーを最初にする

						$countStockEndMaterials = $this->StockEndMaterials->find()
						->where(['price_material_id' => $arrTourokuStockEndMaterials[$k]["price_material_id"], 'lot_num like' => $lotdate.'%'])->toArray();
						$countLot = count($countStockEndMaterials) + 1;

					}elseif($arrTourokuStockEndMaterials[$k]["price_material_id"] !== $arrTourokuStockEndMaterials[$k-1]["price_material_id"]){//新しい原料に変わったとき

						$countStockEndMaterials = $this->StockEndMaterials->find()
						->where(['price_material_id' => $arrTourokuStockEndMaterials[$k]["price_material_id"], 'lot_num like' => $lotdate.'%'])->toArray();
						$countLot = count($countStockEndMaterials) + 1;

					}else{//idが前のidと同じとき

						$countLot = $countLot + 1;

					}
					$lot_num = $lotdate."-".sprintf('%03d', $countLot);

					$arrTourokuStockEndMaterials[$k] = array_merge($arrTourokuStockEndMaterials[$k],array('lot_num' => $lot_num));

				}

				$StockEndMaterials = $this->StockEndMaterials->patchEntities($this->StockEndMaterials->newEntity(), $arrTourokuStockEndMaterials);
	      if ($this->StockEndMaterials->saveMany($StockEndMaterials)) {
	          $message = 'Saved';
	      } else {
	          $message = 'Error';
	      }

	      $this->viewBuilder()->className('Json');
	      $this->set([
	          'message' => $message,
	          'StockEndMaterials' => $StockEndMaterials,
	          '_serialize' => ['message', 'StockEndMaterials']
	      ]);

/*
				$arr = $this->request->getData();

				$this->set([
					'arr' => $arr,
					'mess' => "api_test_hirokawa... ".$mess,
	        '_serialize' => ['arr','mess']
	      ]);
*/

			}elseif($this->request->is(['put'])){//更新・削除putの時

				$mess = "method = put ; id = ".$id;
				$this->set([
					'mess' => "api_test_hirokawa... ".$mess,
	        '_serialize' => ['mess']
	      ]);

			}elseif($this->request->is(['get'])){//取得・一覧getの時

				$mess = "method = get ; id = ".$id;
				$arr = $this->request->getData();

				$this->set([
					'mess' => "api_test_hirokawa... ".$mess,
					'arr' => $arr,
	        '_serialize' => ['mess', 'arr']
	      ]);

			}else{

				$mess = "エラー（post,put,getではありません。）";
				$this->set([
					'mess' => "api_test_hirokawa... ".$mess,
					'_serialize' => ['mess']
				]);

			}

		}

//http://192.168.4.246/Apimaterials/test1/api.json
		public function test1()//http://localhost:5000/Apimaterials/test1/api.json
		{
			$arrStockEndMaterials = array();//空の配列を作る
			$arrStockEndMaterials[] = [
				'grade' => '1010N2',
				'color' => 'N',
				'status_material' => 0,
				'amount' => 30,
				'state' => 0,
				'username' => "test",
			];

			$arrStockEndMaterials[] = [
				'grade' => '1010N2',
				'color' => 'N',
				'status_material' => 0,
				'amount' => 40,
				'state' => 0,
				'username' => "test",
			];

			$arrStockEndMaterials[] = [
				'grade' => 'DC',
				'color' => 'PP-21076',
				'status_material' => 2,
				'amount' => 15,
				'state' => 0,
				'username' => "test",
			];

			$arrStockEndMaterials[] = [
				'grade' => '1010N2',
				'color' => 'N',
				'status_material' => 0,
				'amount' => 5,
				'state' => 0,
				'username' => "test",
			];

			$arrStockEndMaterials[] = [
				'grade' => 'DC',
				'color' => 'PP-21076',
				'status_material' => 2,
				'amount' => 55,
				'state' => 0,
				'username' => "test",
			];

			$arrStockEndMaterials[] = [
				'grade' => 'A-125',
				'color' => 'N',
				'status_material' => 1,
				'amount' => 10,
				'state' => 0,
				'username' => "test",
			];

      $this->set([
				'arrStockEndMaterials' => $arrStockEndMaterials,
        '_serialize' => ['arrStockEndMaterials']
      ]);

    }

		public function test2()//http://192.168.4.246/Apimaterials/test2/api.json http://localhost:5000/Apimaterials/test2/api.json
		{

	//		$url = "http://192.168.4.246/Apimaterials/test1/api.json";
	//		$url = "https://qiita.com/api/v2/users/TakahiRoyte";//外部のデータ
	//		$url = "https://jsonplaceholder.typicode.com/posts";//外部のデータ
			$url = "http://192.168.4.246/Apimaterials/test1/api.json";
      $json = file_get_contents($url);
      $arr = json_decode($json,true);

			$arrTourokuStockEndMaterials = array();//空の配列を作る
			for($k=0; $k<count($arr["arrStockEndMaterials"]); $k++){//jsonを配列に変換

				$PriceMaterials = $this->PriceMaterials->find()
				->where(['grade' => $arr["arrStockEndMaterials"][$k]["grade"], 'color' => $arr["arrStockEndMaterials"][$k]["color"]])->toArray();

				$Users = $this->Users->find()
				->where(['username' => $arr["arrStockEndMaterials"][$k]["username"]])->toArray();

				$arrTourokuStockEndMaterials[] = [
					'price_material_id' => $Materials[0]["id"],
					'status_material' => $arr["arrStockEndMaterials"][$k]["status_material"],
					'amount' => $arr["arrStockEndMaterials"][$k]["amount"],
					'state' => $arr["arrStockEndMaterials"][$k]["state"],
					'status_import_tab' => 0,
					'delete_flag' => 0,
	        'created_at' => date('Y-m-d H:i:s'),
	        'created_staff' => $Users[0]["staff_id"],
				];

			}

			foreach ((array) $arrTourokuStockEndMaterials as $key => $value) {//並び替え
				$sort[$key] = $value['price_material_id'];
			}
			array_multisort($sort, SORT_ASC, $arrTourokuStockEndMaterials);

			$price_material_idArray = array_column($arrTourokuStockEndMaterials, 'price_material_id');
			$arrCountmaterials = array_count_values($price_material_idArray);//カウントする

			$lotdate = date('y').date('m').date('d');

			for($k=0; $k<count($arrTourokuStockEndMaterials); $k++){//ロットナンバーを追加

				if($k == 0){//最初または前のidと違うときはロットナンバーを最初にする

					$countStockEndMaterials = $this->StockEndMaterials->find()
					->where(['price_material_id' => $arrTourokuStockEndMaterials[$k]["price_material_id"], 'lot_num like' => $lotdate.'%'])->toArray();
					$countLot = count($countStockEndMaterials) + 1;

				}elseif($arrTourokuStockEndMaterials[$k]["price_material_id"] !== $arrTourokuStockEndMaterials[$k-1]["price_material_id"]){//新しい原料に変わったとき

					$countStockEndMaterials = $this->StockEndMaterials->find()
					->where(['price_material_id' => $arrTourokuStockEndMaterials[$k]["price_material_id"], 'lot_num like' => $lotdate.'%'])->toArray();
					$countLot = count($countStockEndMaterials) + 1;

				}else{//idが前のidと同じとき

					$countLot = $countLot + 1;

				}
				$lot_num = $lotdate."-".sprintf('%03d', $countLot);

				$arrTourokuStockEndMaterials[$k] = array_merge($arrTourokuStockEndMaterials[$k],array('lot_num' => $lot_num));

			}

			$StockEndMaterials = $this->StockEndMaterials->patchEntities($this->StockEndMaterials->newEntity(), $arrTourokuStockEndMaterials);
      if ($this->StockEndMaterials->saveMany($StockEndMaterials)) {
          $message = 'Saved';
      } else {
          $message = 'Error';
      }

      $this->viewBuilder()->className('Json');
      $this->set([
          'message' => $message,
          'StockEndMaterials' => $StockEndMaterials,
          '_serialize' => ['message', 'StockEndMaterials']
      ]);

    }
																		//http://192.168.4.246/Apimaterials/hyoujitest/api.json
		public function hyoujitest($id)//http://localhost:5000/Apimaterials/hyoujitest/api.json
		{
			$post_data = $this->request->getData();

			if($this->request->is(['post'])) {//登録postの時

				$mess = "method = post ; id = ".$id;
				$this->set([
					'mess' => "api_test_hirokawa... ".$mess,
					'_serialize' => ['mess']
				]);

			}elseif($this->request->is(['put'])){//取得・一覧getの時

				$mess = "method = put ; id = ".$id;
				$this->set([
					'mess' => "api_test_hirokawa... ".$mess,
					'_serialize' => ['mess']
				]);

			}elseif($this->request->is(['get'])){//取得・一覧getの時

				$mess = "method = get ; id = ".$id;
				$this->set([
					'mess' => "api_test_hirokawa... ".$mess,
					'_serialize' => ['mess']
				]);

			}else{

				$mess = "エラー（post,put,getではありません。）";
				$this->set([
					'mess' => "api_test_hirokawa... ".$mess,
					'_serialize' => ['mess']
				]);

			}

			$arrTourokuStockEndMaterials[] = [
				'price_material_id' => 1,
				'status_material' => 1,
				'amount' => 1,
				'lot_num' => $post_data['title']['grade'],
				'state' => 0,
				'status_import_tab' => 0,
				'delete_flag' => 0,
				'created_at' => date('Y-m-d H:i:s'),
				'created_staff' => 1,
			];
/*
			$arrTourokuStockEndMaterials[] = [
				'price_material_id' => 1,
				'status_material' => 1,
				'amount' => 1,
				'lot_num' => $mess,
				'state' => 0,
				'status_import_tab' => 0,
				'delete_flag' => 0,
				'created_at' => date('Y-m-d H:i:s'),
				'created_staff' => 111,
			];
*/
			$StockEndMaterials = $this->StockEndMaterials->patchEntities($this->StockEndMaterials->newEntity(), $arrTourokuStockEndMaterials);
      if ($this->StockEndMaterials->saveMany($StockEndMaterials)) {
          $message = 'Saved';
      } else {
          $message = 'Error';
      }

      $this->viewBuilder()->className('Json');
      $this->set([
          'message' => $message,
          'StockEndMaterials' => $StockEndMaterials,
          '_serialize' => ['message', 'StockEndMaterials']
      ]);

		}
																  	//http://192.168.4.246/Apimaterials/ukewatasitest
		public function ukewatasitest()//http://localhost:5000/Apimaterials/ukewatasitest
		{
			$http = new Client();
			/*
			$response = $http->get('http://192.168.4.246/Apimaterials/hyoujitest/api.json', [//post,put,get
			  'title' => 'testing',
			  'body' => 'content in the put'
			]);
*/

			$data = array();//空の配列を作る
			$data = [
				'grade' => '1010N2',
				'color' => 'N',
				'status_material' => 0,
				'amount' => 30,
				'state' => 0,
				'username' => "test",
			];

			$response = $http->post('http://192.168.4.246/Apimaterials/hyoujitest/api.json', [//post,put,get
//			$response = $http->post('http://localhost:5000/Apimaterials/hyoujitest/api.json', [//localhostには送れない
				'title' => $data,
				['type' => 'json']
			]);

		}

	}
