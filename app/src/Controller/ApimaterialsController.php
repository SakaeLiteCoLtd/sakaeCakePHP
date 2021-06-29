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
		}

		//json出力
    //参考　https://qiita.com/tatamix/items/1758ed25442cc6940411
		//http://192.168.4.246/Apimaterials/materails/aip.json
		//http://localhost:5000/Apimaterials/materails/aip.json
    public function materails()
		{
	//		header("Access-Control-Allow-Origin: *");//https://helog.jp/php/ajax-php-cors/ ブラウザ側に安全を保証してますよって伝えてる
	//		echo $json;

			$Materials = $this->Materials->find()->where(['delete_flag' => 0])->toArray();

			$arrMaterials = array();//空の配列を作る
			for($k=0; $k<count($Materials); $k++){

				$arrMaterials[] = [
					'id' => $Materials[$k]["id"],//配列に追加する
					'grade_color' => $Materials[$k]["grade"]."_".$Materials[$k]["color"]//配列に追加する
				];

			}

      $this->viewBuilder()->className('Json');

		//	unset($Materials[0]['id']);

      $this->set([
				'arrMaterials' => $arrMaterials,
        '_serialize' => ['arrMaterials']
      ]);

//			echo json_encode($arrMaterials,JSON_PRETTY_PRINT);

    }

//http://192.168.4.246/Apimaterials/test1/aip.json
		public function test1()//http://localhost:5000/Apimaterials/test1/aip.json
		{
			$arrStockEndMaterials = array();//空の配列を作る
			$arrStockEndMaterials[] = [
				'grade' => '1010N2',
				'color' => 'N',
				'status_material' => 0,
				'amount' => 5,
				'state' => 0,
			];

			$arrStockEndMaterials[] = [
				'grade' => '1010N2',
				'color' => 'N',
				'status_material' => 0,
				'amount' => 30,
				'state' => 0,
			];

			$arrStockEndMaterials[] = [
				'grade' => '1010N2',
				'color' => 'N',
				'status_material' => 0,
				'amount' => 40,
				'state' => 0,
			];

			$arrStockEndMaterials[] = [
				'grade' => 'A-125',
				'color' => 'N',
				'status_material' => 1,
				'amount' => 10,
				'state' => 0,
			];

			$arrStockEndMaterials[] = [
				'grade' => 'DC',
				'color' => 'PP-21076',
				'status_material' => 2,
				'amount' => 15,
				'state' => 0,
			];

			$arrStockEndMaterials[] = [
				'grade' => 'DC',
				'color' => 'PP-21076',
				'status_material' => 2,
				'amount' => 55,
				'state' => 0,
			];

      $this->set([
				'arrStockEndMaterials' => $arrStockEndMaterials,
        '_serialize' => ['arrStockEndMaterials']
      ]);

//			echo json_encode($arrStockEndMaterials,JSON_PRETTY_PRINT);//これではcakeは受け取れない

    }

		public function test2()//http://localhost:5000/Apimaterials/test2/aip.json
		{

	//		$url = "http://192.168.4.246/Apimaterials/test1/aip.json";
			$url = "http://192.168.4.246/Apimaterials/test1/aip.json";
      $json = file_get_contents($url);
      $arr = json_decode($json,true);

      echo "<pre>";
      print_r($arr["arrStockEndMaterials"]);
      echo "</pre>";

			$arrTourokuStockEndMaterials = array();//空の配列を作る
			for($k=0; $k<count($arr["arrStockEndMaterials"]); $k++){

				$arrTourokuStockEndMaterials[] = [
					'id' => $Materials[0]["id"],
				];

			}
			echo "<pre>";
      print_r($arrTourokuStockEndMaterials);
      echo "</pre>";

    }

	}
