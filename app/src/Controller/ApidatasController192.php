<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

use Cake\Utility\Xml;//xmlのファイルを読み込みために必要

use Cake\Routing\Router;//urlの取得

class ApidatasController extends AppController
	{

		public function initialize()
		{
		 parent::initialize();
		 $this->ScheduleKouteis = TableRegistry::get('scheduleKouteis');
		 $this->Products = TableRegistry::get('products');
		 $this->OrderEdis = TableRegistry::get('orderEdis');
		 $this->StockProducts = TableRegistry::get('stockProducts');
		 $this->SyoyouKeikakus = TableRegistry::get('syoyouKeikakus');
		 $this->KadouSeikeis = TableRegistry::get('kadouSeikeis');
		 $this->Katakouzous = TableRegistry::get('katakouzous');
		 $this->AssembleProducts = TableRegistry::get('assembleProducts');
		 $this->Customers = TableRegistry::get('customers');
		 $this->Users = TableRegistry::get('users');//staffsテーブルを使う
		}

		public function preadd()//http://localhost:5000 http://192.168.4.246
		{
			$staff = $this->Products->newEntity();//newentityに$staffという名前を付ける
			$this->set('staff',$staff);//1行上の$staffをctpで使えるようにセット
/*
			$xmlArray = Xml::toArray(Xml::build('xmls/test.xml'));//これでxmlファイルがあれば表示は可能 https://book.cakephp.org/3/ja/core-libraries/xml.html
			echo "<pre>";
			print_r($xmlArray["response"]);
			echo "</pre>";
*/
/*
			$url = 'http://localhost:5000/Apidatas/test/api/test.xml';
			$curl = curl_init($url);
			$xml = curl_exec($curl);

			// 受け取ったXMLレスポンスをPHPの連想配列へ変換
			$xmlObj = simplexml_load_string($xml);
			$json = json_encode($xmlObj);
			$response = json_decode($json, true);

			echo "<pre>";
			print_r($response);
			echo "</pre>";

/*
			$xmlString = 'http://localhost:5000/Apidatas/test/api/test.xml';
			$xmlArray = Xml::toArray(Xml::build($xmlString));

			$xmlArray = [
					'root' => [
							'xmlns:' => 'http://localhost:5000/Apidatas/test/api/test.xml',
							'child' => 'value'
					]
			];

			$xml1 = Xml::fromArray($xmlArray);

			$xml = Xml::build('http://localhost:5000/Apidatas/test/api/test.xml');
			$xml = Xml::build('xmls/test.xml');

*/

				$xmlArray = Xml::toArray(Xml::build('http://localhost:5000/Apidatas/test/api/test.xml'));
				echo "<pre>";
				print_r($xmlArray);
				echo "</pre>";


		}

	 public function login()
	 {
		 if ($this->request->is('post')) {
			 $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
			 $str = implode(',', $data);//preadd.ctpで入力したデータをカンマ区切りの文字列にする
			 $ary = explode(',', $str);//$strを配列に変換

			 $username = $ary[0];//入力したデータをカンマ区切りの最初のデータを$usernameとする
			 //※staff_codeをusernameに変換？・・・userが一人に決まらないから無理
			 $this->set('username', $username);
			 $Userdata = $this->Users->find()->where(['username' => $username])->toArray();

				 if(empty($Userdata)){
					 $delete_flag = "";
				 }else{
					 $delete_flag = $Userdata[0]->delete_flag;//配列の0番目（0番目しかない）のnameに$Roleと名前を付ける
					 $this->set('delete_flag',$delete_flag);//登録者の表示のため1行上の$Roleをctpで使えるようにセット
				 }
					 $user = $this->Auth->identify();
				 if ($user) {

					 $url = 'http://localhost:5000/Apidatas/zaikocyoudata/api/2020-10_primary.xml';

					 $this->Auth->setUser($user);
					 return $this->redirect($url);
				 }
			 }
	 }

		public function zaikocyoudata()
		{
			$data = Router::reverse($this->request, false);//urlを取得
			$urlarr = explode("/",$data);//切り離し
			$dayarr = explode("_",$urlarr[4]);//切り離し
			if(isset($dayarr[2])){
				$sheetarr = explode(".",$dayarr[2]);//切り離し
				$sheet = $dayarr[1]."_".$sheetarr[0];//シート名の取得
			}else{
				$sheetarr = explode(".",$dayarr[1]);//切り離し
				$sheet = $sheetarr[0];//シート名の取得
			}

			$day = $dayarr[0];//日付の取得

			//http://192.168.4.246/Apidatas/zaikocyoudata/api/2020-10_primary.xml
			//http://localhost:5000/Apidatas/zaikocyoudata/api/2020-10_primary.xml

			if($sheet === "primary"){

		//		$xmlString = 'http://localhost:5000/Apidatas/zaikocyoudata/api/2020-10_testtouroku.xml';
		//		$xmlArray = Xml::toArray(Xml::build($xmlString));
/*
				$xmlArray = [
				    'root' => [
				        'xmlns:' => 'http://localhost:5000/Apidatas/zaikocyoudata/api/2020-10_testtouroku.xml',
				        'child' => 'value'
				    ]
				];
				$xml1 = Xml::fromArray($xmlArray);
*/
				$url = 'http://localhost:5000/Apidatas/test/api/test.xml';
				$curl = curl_init($url);
				$xml = curl_exec($curl);

				// 受け取ったXMLレスポンスをPHPの連想配列へ変換
				$xmlObj = simplexml_load_string($xml);
				$json = json_encode($xmlObj);
				$response = json_decode($json, true);

				echo "<pre>";
				print_r($xmlObj);
				echo "</pre>";

				$arrOrderEdis = array();
				$arrStockProducts = array();
				$arrAssembleProducts = array();
				$arrSyoyouKeikakus = array();
				$arrSeisans = array();

/*
			  $Products = $this->Products->patchEntity($this->Products->newEntity(), $tourokutestproduct);
				$this->Products->save($Products);

				$this->Products->updateAll(
				['product_code' => "dcba" , 'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => "9999"],
				['id'   => 1434]
				);
*/
			}else{

				echo "<pre>";
				print_r("エラーです。URLを確認してください。");
				echo "</pre>";

				$arrOrderEdis = array();
				$arrStockProducts = array();
				$arrAssembleProducts = array();
				$arrSyoyouKeikakus = array();
				$arrSeisans = array();

			}

			$this->set([
				'tourokutestproduct' => $arrOrderEdis,
				'_serialize' => ['tourokutestproduct']
			]);

		}

		public function test()//http://localhost:5000/Apidatas/test/api/test.xml
 	 {

		 $tourokutestproduct = [
			 'product_code' => date('Y-m-d H:i:s').'acbd',
			 'product_name' => 'APIテスト',
			 'weight' => '9999',
			 'primary_p' => '0',
			 'status' => '0',
			 'delete_flag' => '0',
			 'created_at' => date('Y-m-d H:i:s'),
			 'created_staff' => '9999',
		 ];

		 $this->set([
			 'tourokutestproduct' => $tourokutestproduct,
			 '_serialize' => ['tourokutestproduct']
		 ]);

	 }

	}