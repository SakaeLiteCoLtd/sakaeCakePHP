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

class ApiproductsController extends AppController
	{

		public function initialize()
		{
		 parent::initialize();
		 $this->loadComponent('RequestHandler');

		 $this->response->header("Access-Control-Allow-Origin: *");//https://shota-natuta.hatenablog.com/entry/2017/02/08/230211 ブラウザ側に安全を保証してますよって伝えてる
		 $this->response->header("Access-Control-Allow-Headers: Content-Type");
		 $this->response->header("Access-Control-Allow-Credentials: true");
		 $this->response->header("Access-Control-Allow-Methods: POST, PUT, DELETE, PATCH");

		 $this->PriceMaterials = TableRegistry::get('priceMaterials');
		 $this->Products = TableRegistry::get('products');
		}

																	//http://localhost:5000/Apiproducts/productcodes/api.json
    public function productcodes()//http://192.168.4.246/Apiproducts/productcodes/api.json
		{
			header("Access-Control-Allow-Origin: *");//ブラウザ側に安全を保証してますよって伝えてる

			$Products = $this->Products->find()
			->where(['delete_flag' => 0])->order(["product_code"=>"ASC"])->toArray();

			$arrProducts = array();//空の配列を作る
			for($k=0; $k<count($Products); $k++){

				$arrProducts[] = [
					'product_code' => $Products[$k]["product_code"]//配列に追加する
				];

			}

      $this->viewBuilder()->className('Json');
      $this->set([
				'arrProducts' => $arrProducts,
        '_serialize' => ['arrProducts']
      ]);

    }

																//http://192.168.4.246/Apiproducts/gradecolor/api/MLD-MD-20035.json
		public function gradecolor()//http://localhost:5000/Apiproducts/gradecolor/api/MLD-MD-20035.json
		{
			$data = Router::reverse($this->request, false);//文字化けする後で2回変換すると日本語OK
			$data = urldecode($data);

			$urlarr = explode("/",$data);//切り離し
			if(isset($urlarr[5])){
				$urlarr[4] = $urlarr[4]."/".$urlarr[5];
			}
			$dataarr = explode(".",$urlarr[4]);//切り離し
			$product_code = $dataarr[0];

			$Products = $this->Products->find()->where(['product_code' => $product_code])->toArray();
			if(isset($Products[0])){
				$grade_color = $Products[0]["m_grade"]."_".$Products[0]["col_num"];
			}else{
				$grade_color = "";
			}

			$this->viewBuilder()->className('Json');
      $this->set([
				'grade_color' => $grade_color,
        '_serialize' => ['grade_color']
      ]);

		}

	}
