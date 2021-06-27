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
		 $this->Materials = TableRegistry::get('materials');
		}

		//json出力
    //参考　https://qiita.com/tatamix/items/1758ed25442cc6940411
		//http://192.168.4.246/Apimaterials/materails/aip.json
		//http://localhost:5000/Apimaterials/materails/aip.json
    public function materails()
		{
			header("Access-Control-Allow-Origin: *");//https://helog.jp/php/ajax-php-cors/ ブラウザ側に安全を保証してますよって伝えてる
	//		echo $json;

			$Materials = $this->Materials->find()->where(['delete_flag' => 0])->toArray();

			$arrMaterials = array();//空の配列を作る
			for($k=0; $k<count($Materials); $k++){

				$arrMaterials[] = $Materials[$k]["grade"]."_".$Materials[$k]["color"];//配列に追加する

			}

      $this->viewBuilder()->className('Json');

			unset($Materials[0]['id']);

      $this->set([
				'arrMaterials' => $arrMaterials,
        '_serialize' => ['arrMaterials']
      ]);

    }

		public function test1()//http://localhost:5000/Apimaterials/test1/aip.json
		{

			$Materials = $this->Materials->find()->where(['delete_flag' => 0])->toArray();

			$arrMaterials = array();//空の配列を作る
			for($k=0; $k<count($Materials); $k++){

				$arrMaterials[] = $Materials[$k]["grade"]."_".$Materials[$k]["color"];//配列に追加する

			}

      $this->viewBuilder()->className('Json');

			unset($Materials[0]['id']);
			$Materials[0]['created_at'] = date('Y-m-d H:i:s');

      $this->set([
	//			'arrMaterials' => $arrMaterials,
				'arrMaterials' => $Materials[0],
        '_serialize' => ['arrMaterials']
      ]);

    }

		public function test2()//http://localhost:5000/Apimaterials/test2/aip.json
		{

	//		$url="http://192.168.4.246/Apimaterials/test1/aip.json";
			$url="http://192.168.4.246/Apimaterials/materails/aip.json";
      $json=file_get_contents($url);
      $arr=json_decode($json,true);

      echo "<pre>";
      print_r($arr);
      echo "</pre>";

    }

	}
