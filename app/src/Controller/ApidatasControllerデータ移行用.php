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
		 $this->Users = TableRegistry::get('users');

		 $this->Staffs = TableRegistry::get('staffs');
		 $this->OrderSyoumouShiireHeaders = TableRegistry::get('orderSyoumouShiireHeaders');
		 $this->KensahyouHeads = TableRegistry::get('kensahyouHeads');
		 $this->KensahyouSokuteidatas = TableRegistry::get('kensahyouSokuteidatas');

		}

		public function preadd()//http://localhost:5000 http://192.168.4.246  http://localhost:5000/Apidatas/preadd
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

		//		$xmlArray = Xml::toArray(Xml::build('http://localhost:5000/Apidatas/test/api/test.xml'));
				$http = new Client();

				//			$response = $http->get('http://192.168.4.246/Apidatas/test/api/test.xml');//参考https://book.cakephp.org/3/ja/core-libraries/httpclient.html
				//			$response = $http->post('http://192.168.4.246/Apidatas/test/api/test.xml');//参考https://book.cakephp.org/3/ja/core-libraries/httpclient.html
				//			$response = $http->put('http://192.168.4.246/Apidatas/test/api/test.xml');//参考https://book.cakephp.org/3/ja/core-libraries/httpclient.html

		//		$response = $http->post('https://qiita.com/api/v2/users/TakahiRoyte');//参考https://book.cakephp.org/3/ja/core-libraries/httpclient.html

				$response = $http->post('http://192.168.4.246/Apidatas/test/api/test.json');//参考https://codelab.website/cakephp3-api/
				$array = json_decode($response->body(), true);//trueがあれば配列として受け取れる　参考https://qiita.com/muramount/items/6be585bf9c031a997d9a

				echo "<pre>";
				print_r($array);
				echo "</pre>";
				echo "<pre>";
				print_r($array["tourokutestproduct"]["product_name"]);
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

			//		 $url = 'http://localhost:5000/Apidatas/zaikocyoudata/api/2020-10_primary.xml';

			//		 $this->Auth->setUser($user);
			//		 return $this->redirect($url);

					 $this->Auth->setUser($user);
					 return $this->redirect(['action' => 'preadd']);

				 }
			 }
	 }

		public function updatedatas()//urlを使うパターン
		//http://localhost:5000/Apidatas/updatedatas/api/20-10_test1_test2_test3.xml
		{

			$data = Router::reverse($this->request, false);//urlを取得
			$urlarr = explode("/",$data);//切り離し
			$dataarr = explode("_",$urlarr[4]);//切り離し

			$day = $dataarr[0];//日付の取得
			$tourokutestproduct['day'] = $day;

			for ($k=1; $k<count($dataarr); $k++) {

				if($k == count($dataarr)-1){
					$datas = explode(".",$dataarr[$k]);//切り離し
					${"product".$k} = $datas[0];
				}else{
					${"product".$k} = $dataarr[$k];
				}

				$tourokutestproduct["product".$k] = ${"product".$k};

			}
			$tourokutestproduct["created_at"] = date('Y-m-d H:i:s');

 		 $this->set([
 			 'tourokutestproduct' => $tourokutestproduct,
 			 '_serialize' => ['tourokutestproduct']
 		 ]);

		}

		public function test()//http://localhost:5000/Apidatas/test/api/test.xml
 	 {

		 $tourokutestproduct = [
			 'product_code' => date('Y-m-d H:i:s').'acbd',
			 'product_name' => 'APIテスト192',
			 'weight' => '9999',
			 'primary_p' => '0',
			 'status' => '0',
			 'delete_flag' => '0',
			 'created_at' => date('Y-m-d H:i:s'),
			 'created_staff' => '9999',
		 ];

	//	 mb_convert_variables('UTF-8','SJIS-win',$tourokutestproduct);//文字コードを変換

		 $this->set([
			 'tourokutestproduct' => $tourokutestproduct,
			 '_serialize' => ['tourokutestproduct']
		 ]);

	 }

	 public function testupdate()//http://localhost:5000/Apidatas/testupdate/api/test.xml
	{
		$http = new Client();

		$response = $http->put('http://192.168.4.246/Apidatas/test/api/test.json');//参考https://codelab.website/cakephp3-api/
		$array = json_decode($response->body(), true);//trueがあれば配列として受け取れる　参考https://qiita.com/muramount/items/6be585bf9c031a997d9a

		if ($this->request->is(['post'])) {//post,put,get

			echo "<pre>";
			print_r('post');
			echo "</pre>";

		}elseif($this->request->is(['put'])){

			echo "<pre>";
			print_r('put');
			echo "</pre>";

		}elseif($this->request->is(['get'])){
/*
			echo "<pre>";
			print_r('get');
			echo "</pre>";
*/
	//		$Products = $this->Products->patchEntity($this->Products->newEntity(), $array["tourokutestproduct"]);
	//		$this->Products->save($Products);

				$connection = ConnectionManager::get('default');//トランザクション1
				 // トランザクション開始2
				 $connection->begin();//トランザクション3
				 try {//トランザクション4
					 if($this->Products->updateAll(
		 				['product_code' => "dcba".date('Y-m-d H:i:s') , 'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => "9999"],
		 				['id'   => 1500]
		 			)){

					 $connection->commit();// コミット5

				 } else {

					 $this->Flash->error(__('The product could not be saved. Please, try again.'));
					 throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6

				 }

			 } catch (Exception $e) {//トランザクション7
			 //ロールバック8
				 $connection->rollback();//トランザクション9
			 }//トランザクション10


		}else{

			$this->set([
					'message' => "エラー",
					'_serialize' => ['message']
			]);

		}
/*
		echo "<pre>";
		print_r($array);
		echo "</pre>";
		/*
		echo "<pre>";
		print_r($array["tourokutestproduct"]["product_name"]);
		echo "</pre>";
*/
/*
			  $Products = $this->Products->patchEntity($this->Products->newEntity(), $tourokutestproduct);
				$this->Products->save($Products);

				$this->Products->updateAll(
				['product_code' => "dcba" , 'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => "9999"],
				['id'   => 1434]
				);
*/

	}

	public function staffcodeupdate()
	{

		$OrderSyoumouShiireHeaders = $this->OrderSyoumouShiireHeaders->find('all')->where(['created_staff >' => 1000])->toArray();

		for($k=0; $k<count($OrderSyoumouShiireHeaders); $k++){
			$created_staff = $OrderSyoumouShiireHeaders[$k]->created_staff;
			$id = $OrderSyoumouShiireHeaders[$k]->id;

			$Staffs = $this->Staffs->find('all')->where(['staff_code' => $created_staff])->toArray();
			$staffid = $Staffs[0]->id;

			$this->OrderSyoumouShiireHeaders->updateAll(
			['created_staff' => $staffid],
			['id'   => $id]
			);

		}

/*
		$this->Products->updateAll(
		['product_code' => "dcba" , 'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => "9999"],
		['id'   => 1434]
		);
*/

	 }

	 public function kensahyou()//Apidatas/kensahyou //Tableファイルを名前変更
 	{
		$count1 = 0;
		$count2 = 0;
		$tourokuarr = array();

		$connection = ConnectionManager::get('DB_ikou_test');//旧DBを参照
		$table = TableRegistry::get('kensahyou_sokuteidata_head');
		$table->setConnection($connection);

		$date_start = "2021-02-01";//start
		  $date_end = "2021-01-01";//end
/*
		$date_2021 = "2021-01-01";
		$date_2020 = "2020-01-01";
		$date_2019 = "2019-01-01";
		$date_2018 = "2018-01-01";
		$date_2017 = "2017-01-01";
		$date_2016 = "2016-01-01";
		$date_2015 = "2015-01-01";
		$date_2014 = "2014-01-01";
		$date_2013 = "2013-01-01";
		$date_2012 = "2012-01-01";
		$date_2011 = "2011-01-01";
		$date_2010 = "2010-01-01";
		$date_2009 = "2009-01-01";
		$date_2008 = "2008-01-01";
*/
		$sql = "SELECT kensahyou_sokuteidata_head_id,product_id,manu_date,inspec_date,lot_num,timestamp
		FROM kensahyou_sokuteidata_head".
		" where manu_date < '".$date_start."' and inspec_date = '".$date_start."'";
//		" where manu_date >= '".$date_start."' and manu_date < '".$date_end."'";
		$connection = ConnectionManager::get('DB_ikou_test');
		$kensahyou_sokuteidata_heads = $connection->execute($sql)->fetchAll('assoc');
/*
		echo "<pre>";
		print_r(count($kensahyou_sokuteidata_heads));
		echo "</pre>";
*/
		for($k=0; $k<count($kensahyou_sokuteidata_heads); $k++){

			$connection = ConnectionManager::get('DB_ikou_test');//旧DBを参照
			$table = TableRegistry::get('kensahyou_sokuteidata_head');
			$table->setConnection($connection);

			$sql = "SELECT kensahyou_sokuteidata_result_id,cavi_num,result_size_a,result_size_b,result_size_c,result_size_d,result_size_e,result_size_f,result_size_g,result_size_h,result_size_i
			,result_text_j,result_text_k,result_size_12,result_size_13,result_size_14,result_size_15,result_size_16,result_size_17,result_size_18,result_size_19
			,result_size_20,result_weight
			FROM kensahyou_sokuteidata_result".
			" where kensahyou_sokuteidata_result_id = '".$kensahyou_sokuteidata_heads[$k]["kensahyou_sokuteidata_head_id"]."'";
			$connection = ConnectionManager::get('DB_ikou_test');
			$kensahyou_sokuteidata_results = $connection->execute($sql)->fetchAll('assoc');
/*
			echo "<pre>";
			print_r(count($kensahyou_sokuteidata_results));
			echo "</pre>";
*/
			$connection = ConnectionManager::get('default');
			$table->setConnection($connection);

			for($m=0; $m<count($kensahyou_sokuteidata_results); $m++){
				$count1 = $count1 + 1;

				$KensahyouHeads = $this->KensahyouHeads->find()->where(['product_code' => $kensahyou_sokuteidata_heads[$k]["product_id"]])->toArray();
				$KensahyouHeadsId = $KensahyouHeads[0]->id;

			//	$tourokuarr = [
				$tourokuarr[] = [
					'kensahyou_heads_id' => $KensahyouHeadsId,
					'product_code' => $kensahyou_sokuteidata_heads[$k]["product_id"],
					'lot_num' => $kensahyou_sokuteidata_heads[$k]["lot_num"],
					'manu_date' => $kensahyou_sokuteidata_heads[$k]["manu_date"],
					'inspec_date' => $kensahyou_sokuteidata_heads[$k]["inspec_date"],
					'cavi_num' => $kensahyou_sokuteidata_results[$m]["cavi_num"],
					'result_size_1' => $kensahyou_sokuteidata_results[$m]["result_size_a"],
					'result_size_2' => $kensahyou_sokuteidata_results[$m]["result_size_b"],
					'result_size_3' => $kensahyou_sokuteidata_results[$m]["result_size_c"],
					'result_size_4' => $kensahyou_sokuteidata_results[$m]["result_size_d"],
					'result_size_5' => $kensahyou_sokuteidata_results[$m]["result_size_e"],
					'result_size_6' => $kensahyou_sokuteidata_results[$m]["result_size_f"],
					'result_size_7' => $kensahyou_sokuteidata_results[$m]["result_size_g"],
					'result_size_8' => $kensahyou_sokuteidata_results[$m]["result_size_h"],
					'result_size_9' => $kensahyou_sokuteidata_results[$m]["result_size_i"],
					'result_size_10' => "",
					'result_size_11' => "",
					'result_size_12' => $kensahyou_sokuteidata_results[$m]["result_size_12"],
					'result_size_13' => $kensahyou_sokuteidata_results[$m]["result_size_13"],
					'result_size_14' => $kensahyou_sokuteidata_results[$m]["result_size_14"],
					'result_size_15' => $kensahyou_sokuteidata_results[$m]["result_size_15"],
					'result_size_16' => $kensahyou_sokuteidata_results[$m]["result_size_16"],
					'result_size_17' => $kensahyou_sokuteidata_results[$m]["result_size_17"],
					'result_size_18' => $kensahyou_sokuteidata_results[$m]["result_size_18"],
					'result_size_19' => $kensahyou_sokuteidata_results[$m]["result_size_19"],
					'result_size_20' => $kensahyou_sokuteidata_results[$m]["result_size_20"],
					'result_weight' => $kensahyou_sokuteidata_results[$m]["result_weight"],
					'situation_dist1' => $kensahyou_sokuteidata_results[$m]["result_text_j"],
					'situation_dist2' => $kensahyou_sokuteidata_results[$m]["result_text_k"],
					'delete_flag' => 0,
//					'created_at' => $kensahyou_sokuteidata_heads[$k]["timestamp"]
					'created_at' => date('Y-m-d H:i:s')
				];
/*
				echo "<pre>";
				print_r($tourokuarr);
				echo "</pre>";

				$KensahyouSokuteidatas = $this->KensahyouSokuteidatas->patchEntity($this->KensahyouSokuteidatas->newEntity(), $tourokuarr);
				$this->KensahyouSokuteidatas->save($KensahyouSokuteidatas);
*/

			}

		}

		$KensahyouSokuteidatas = $this->KensahyouSokuteidatas->patchEntities($this->KensahyouSokuteidatas->newEntity(), $tourokuarr);
		$connection = ConnectionManager::get('default');//トランザクション1
		// トランザクション開始2
		$connection->begin();//トランザクション3
		try {//トランザクション4
			if ($this->KensahyouSokuteidatas->saveMany($KensahyouSokuteidatas)) {

				$connection->commit();// コミット5

			} else {

				$this->Flash->error(__('The data could not be saved. Please, try again.'));
				throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6

			}
		} catch (Exception $e) {//トランザクション7
		//ロールバック8
			$connection->rollback();//トランザクション9
		}//トランザクション10

		echo "<pre>";
		print_r($date_start." ~ ".$date_end." ".$count1." ".count($tourokuarr));
		echo "</pre>";

	}


	}
