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
		 $this->Materials = TableRegistry::get('materials');
		 $this->StockEndMaterials = TableRegistry::get('stockEndMaterials');
		 $this->Users = TableRegistry::get('users');
		}
/*
ルール参考　https://qiita.com/TakahiRoyte/items/949f4e88caecb02119aa
①登録 POST    https://192.168.4.246/Apimaterials/apimaterails/api.json
②取得 GET     https://192.168.4.246/Apimaterials/apimaterails/grade_color_lotnum.json
③更新 PUT     https://192.168.4.246/Apimaterials/apimaterails/grade_color_lotnum.json
④削除 DELETE  https://192.168.4.246/Apimaterials/apimaterails/grade_color_lotnum.json
*/
		//json出力
    //参考　https://qiita.com/tatamix/items/1758ed25442cc6940411
		//http://192.168.4.246/Apimaterials/materails/api.json
		//http://localhost:5000/Apimaterials/materails/api.json
    public function materails()
		{
	//		header("Access-Control-Allow-Origin: *");//https://helog.jp/php/ajax-php-cors/ ブラウザ側に安全を保証してますよって伝えてるappコントローラーに追加

			$Materials = $this->Materials->find()->where(['delete_flag' => 0])->toArray();

			$arrMaterials = array();//空の配列を作る
			for($k=0; $k<count($Materials); $k++){

				$arrMaterials[] = [
					'id' => $Materials[$k]["id"],//配列に追加する
					'grade_color' => $Materials[$k]["grade"]."_".$Materials[$k]["color"]//配列に追加する
				];

			}

      $this->viewBuilder()->className('Json');

      $this->set([
				'arrMaterials' => $arrMaterials,
        '_serialize' => ['arrMaterials']
      ]);

    }

		public function apimaterails($id)//http://localhost:5000/Apimaterials/apimaterails/3.json
		{

			if($this->request->is(['post'])) {
				$mess = "method = post ; id = ".$id;
			}elseif($this->request->is(['put'])){
				$mess = "method = put ; id = ".$id;
			}elseif($this->request->is(['get'])){
				$mess = "method = get ; id = ".$id;
			}

			$this->set([
				'mess' => "api_test_hirokawa... ".$mess,
        '_serialize' => ['mess']
      ]);

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

//			echo json_encode($arrStockEndMaterials,JSON_PRETTY_PRINT);//これではcakeは受け取れない

    }

		public function test2()//http://localhost:5000/Apimaterials/test2/api.json
		{

	//		$url = "http://192.168.4.246/Apimaterials/test1/api.json";
	//		$url = "https://qiita.com/api/v2/users/TakahiRoyte";//外部のデータ
	//		$url = "https://jsonplaceholder.typicode.com/posts";//外部のデータ
			$url = "http://192.168.4.246/Apimaterials/test1/api.json";
      $json = file_get_contents($url);
      $arr = json_decode($json,true);
/*
      echo "<pre>";
      print_r($arr);
      echo "</pre>";
*/
			$arrTourokuStockEndMaterials = array();//空の配列を作る
			for($k=0; $k<count($arr["arrStockEndMaterials"]); $k++){//jsonを配列に変換

				$Materials = $this->Materials->find()
				->where(['grade' => $arr["arrStockEndMaterials"][$k]["grade"], 'color' => $arr["arrStockEndMaterials"][$k]["color"]])->toArray();

				$Users = $this->Users->find()
				->where(['username' => $arr["arrStockEndMaterials"][$k]["username"]])->toArray();

				$arrTourokuStockEndMaterials[] = [
					'material_id' => $Materials[0]["id"],
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
				$sort[$key] = $value['material_id'];
			}
			array_multisort($sort, SORT_ASC, $arrTourokuStockEndMaterials);

			$material_idArray = array_column($arrTourokuStockEndMaterials, 'material_id');
			$arrCountmaterials = array_count_values($material_idArray);//カウントする

			$lotdate = date('y').date('m').date('d');

			for($k=0; $k<count($arrTourokuStockEndMaterials); $k++){//ロットナンバーを追加

				if($k == 0){//最初または前のidと違うときはロットナンバーを最初にする

					$countStockEndMaterials = $this->StockEndMaterials->find()
					->where(['material_id' => $arrTourokuStockEndMaterials[$k]["material_id"], 'lot_num like' => $lotdate.'%'])->toArray();
					$countLot = count($countStockEndMaterials) + 1;

				}elseif($arrTourokuStockEndMaterials[$k]["material_id"] !== $arrTourokuStockEndMaterials[$k-1]["material_id"]){//新しい原料に変わったとき

					$countStockEndMaterials = $this->StockEndMaterials->find()
					->where(['material_id' => $arrTourokuStockEndMaterials[$k]["material_id"], 'lot_num like' => $lotdate.'%'])->toArray();
					$countLot = count($countStockEndMaterials) + 1;

				}else{//idが前のidと同じとき

					$countLot = $countLot + 1;

				}
				$lot_num = $lotdate."-".sprintf('%03d', $countLot);

				$arrTourokuStockEndMaterials[$k] = array_merge($arrTourokuStockEndMaterials[$k],array('lot_num' => $lot_num));

			}
/*
			echo "<pre>";
      print_r($arrTourokuStockEndMaterials);
      echo "</pre>";
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


	}
