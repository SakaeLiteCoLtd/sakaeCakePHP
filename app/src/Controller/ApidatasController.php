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
		 $this->Users = TableRegistry::get('users');//staffsテーブルを使う

		 $this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
		 $this->OrderSyoumouShiireHeaders = TableRegistry::get('orderSyoumouShiireHeaders');

		 $this->ScheduleKouteisTests = TableRegistry::get('scheduleKouteisTests');

		}

		public function preadd0()//http://localhost:5000 http://192.168.4.246/Apidatas/preadd  http://localhost:5000/Apidatas/preadd
		{

			session_start();
			$session = $this->request->getSession();
			echo "<pre>";
			print_r($_SESSION);
			echo "</pre>";

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
/*
		//		$xmlArray = Xml::toArray(Xml::build('http://localhost:5000/Apidatas/test/api/test.xml'));
				$http = new Client();

				//			$response = $http->get('http://192.168.4.246/Apidatas/test/api/test.xml');//参考https://book.cakephp.org/3/ja/core-libraries/httpclient.html
				//			$response = $http->post('http://192.168.4.246/Apidatas/test/api/test.xml');//参考https://book.cakephp.org/3/ja/core-libraries/httpclient.html
				//			$response = $http->put('http://192.168.4.246/Apidatas/test/api/test.xml');//参考https://book.cakephp.org/3/ja/core-libraries/httpclient.html

		//		$response = $http->post('https://qiita.com/api/v2/users/TakahiRoyte');//参考https://book.cakephp.org/3/ja/core-libraries/httpclient.html

		$response = $http->post('http://192.168.4.246/Apidatas/test/api/test.json');//参考https://codelab.website/cakephp3-api/
	//	$response = $http->post('http://192.168.4.246/Apidatas/test/api/test.json');//参考https://codelab.website/cakephp3-api/
				$array = json_decode($response->body(), true);//trueがあれば配列として受け取れる　参考https://qiita.com/muramount/items/6be585bf9c031a997d9a

				echo "<pre>";
				print_r($array);
				echo "</pre>";
				echo "<pre>";
				print_r($array["tourokutestproduct"]["product_name"]);
				echo "</pre>";
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

			public function preadd()//http://localhost:5000 http://192.168.4.246/Apidatas/preadd  http://localhost:5000/Apidatas/preadd
			{
				session_start();
				$session = $this->request->getSession();
//				$_SESSION['kouteivba'] = array();
				echo "<pre>";
				print_r($_SESSION);
				echo "</pre>";

				$staff = $this->Products->newEntity();//newentityに$staffという名前を付ける
				$this->set('staff',$staff);//1行上の$staffをctpで使えるようにセット

				//					$this->request->session()->destroy(); // セッションの破棄

			}

			//http://192.168.4.246/Apidatas/vbakoutei/api/2020-10-28_2020-11-4.xml　
			//http://192.168.4.246/Apidatas/vbakoutei/api/2020-10-28_08:00:00_2_CAS-NDS-20002_粉砕量注意！.xml
			//http://localhost:5000/Apidatas/vbakoutei/api/2020-10-28_2020-11-4_hirokawa.xml
			//http://localhost:5000/Apidatas/vbakoutei/api/2020-10-28_08:00:00_2_CAS-NDS-20002_粉砕量注意！_hirokawa.xml
			//http://localhost:5000/Apidatas/vbakoutei/api/2020-10-28_08:00:00_2_CAS-NDS-20002__hirokawa.xml
			//http://localhost:5000/Apidatas/vbakoutei/api/2020-10-28_2020-11-4_end_hirokawa.xml
		public function vbakoutei()
		{
			$data = Router::reverse($this->request, false);//文字化けする後で2回変換すると日本語OK
			$data = urldecode($data);
/*
			echo "<pre>";
			print_r($data);
			echo "</pre>";
*/
			$urlarr = explode("/",$data);//切り離し
			if(isset($urlarr[5])){
				$urlarr[4] = $urlarr[4]."/".$urlarr[5];
			}
			$urlarr[4] = mb_convert_encoding($urlarr[4],"UTF-8",mb_detect_encoding($urlarr[4], "ASCII,SJIS,UTF-8,CP51932,SJIS-win", true));
			$dataarr = explode("_",$urlarr[4]);//切り離し

				if(isset($dataarr[4])){//ScheduleKouteis登録用の配列に追加

					session_start();
					$session = $this->request->getSession();

					if($dataarr[5] == $_SESSION['sessionstartstaff']){

						$datetime = $dataarr[0]." ".$dataarr[1];//datetimeの取得
						$seikeiki = $dataarr[2];//seikeikiの取得
						$product_code = $dataarr[3];//product_codeの取得
						$Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
						if(isset($Product[0])){
						$product_name = $Product[0]->product_name;
						}else{
						$product_name = "";
						}

						$tantouarr = explode(".",$dataarr[4]);//切り離し
						$tantou = $tantouarr[0];//tantouの取得

						$present_kensahyou = 0;

						$kouteivba['datetime'] = $datetime;
						$kouteivba['seikeiki'] = $seikeiki;
						$kouteivba['product_code'] = $product_code;
						$kouteivba['present_kensahyou'] = $present_kensahyou;
						$kouteivba['product_name'] = $product_name;
						$kouteivba['tantou'] = $tantou;
						$kouteivba['created_at'] = date('Y-m-d H:i:s');

						$this->set([
						'tourokutest' => $kouteivba,
						'_serialize' => ['tourokutest']
						]);

						$_SESSION['kouteivba'][] = $kouteivba;

					}

				}elseif(!isset($dataarr[3]) && $dataarr[2] != "end"){//まずここにくる

					session_start();
					$session = $this->request->getSession();

					$dayarr = explode(".",$dataarr[1]);//切り離し
					$dayfinish = $dayarr[0];

					$dayfinish = strtotime($dayfinish);
					$dayfinish = date('Y-m-d', strtotime('+1 day', $dayfinish));

					$daystart = $dataarr[0]." 08:00:00";//1週間の初めの日付の取得
					$dayfinish = $dayfinish." 07:59:59";//1週間の終わりの日付の取得

					if(isset($_SESSION['session'][0])){//誰かがボタンを押して終了していない場合,セッションが削除されずに終わっている場合

						sleep(20);//20秒待機

						$_SESSION['kouteivba'] = array();
						$_SESSION['deleteday'] = array();
						$_SESSION['session'] = array();
						$_SESSION['sessionstartstaff'] = array();
						$_SESSION['sessionstarttime'] = array();

						$_SESSION['session'][0] = 0;
						$_SESSION['sessionstarttime'] = date('Y-m-d H:i:s');
						$_SESSION['sessionstartstaff'] = $dataarr[2];

					}else{//同時に誰もスタートしていない場合

						$_SESSION['session'][0] = 0;
						$_SESSION['sessionstarttime'] = date('Y-m-d H:i:s');
						$_SESSION['sessionstartstaff'] = $dataarr[2];

					}

					$_SESSION['deletesta'][0] = $daystart;
					$_SESSION['deletefin'][0] = $dayfinish;

				}elseif($dataarr[2] == "end"){//終了の時に一括でデータを登録してそのセッションを削除

					session_start();
					$session = $this->request->getSession();

					if($dataarr[3] == $_SESSION['sessionstartstaff']){

						$daystart = $dataarr[0];//1週間の初めの日付の取得
						$dayfinish = $dataarr[1];//1週間の終わりの日付の取得

						//新しいデータを登録
						$ScheduleKouteis = $this->ScheduleKouteis->patchEntities($this->ScheduleKouteis->newEntity(), $_SESSION['kouteivba']);
						$connection = ConnectionManager::get('default');//トランザクション1
						// トランザクション開始2
						$connection->begin();//トランザクション3
						try {//トランザクション4

							$ScheduleKouteisdelete = $this->ScheduleKouteis->find()->where(['datetime >=' => $_SESSION['deletesta'][0], 'datetime <=' => $_SESSION['deletefin'][0], 'delete_flag' => 0])->toArray();
							if(isset($ScheduleKouteisdelete[0])){

								for($k=0; $k<count($ScheduleKouteisdelete); $k++){
									$id = $ScheduleKouteisdelete[$k]->id;
									$created_at_moto = $ScheduleKouteisdelete[$k]->created_at;

									$this->ScheduleKouteis->updateAll(
									['delete_flag' => 1, 'created_at' => $created_at_moto, 'updated_at' => date('Y-m-d H:i:s')],
									['id'   => $id]
									);

								}

							}

							if ($this->ScheduleKouteis->saveMany($ScheduleKouteis)) {

								$connection->commit();// コミット5
								$_SESSION['kouteivba'] = array();
								$_SESSION['deleteday'] = array();
								$_SESSION['session'] = array();
								$_SESSION['sessionstarttime'] = array();
								$_SESSION['sessionstartstaff'] = array();

							} else {

								$this->Flash->error(__('The data could not be saved. Please, try again.'));
								throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
								$_SESSION['kouteivba'] = array();
								$_SESSION['deleteday'] = array();
								$_SESSION['session'] = array();
								$_SESSION['sessionstarttime'] = array();
								$_SESSION['sessionstartstaff'] = array();

							}
						} catch (Exception $e) {//トランザクション7
						//ロールバック8
							$connection->rollback();//トランザクション9
						}//トランザクション10

					}

				}

		}

		public function kouteisessioncheck()//http://localhost:5000/Apidatas/kouteisessioncheck/api/kouteisessioncheck.xml
		{
			session_start();
			$session = $this->request->getSession();

//			$_SESSION['session'] = array();
//			$_SESSION['session'][0] = 0;
//			$this->request->session()->destroy(); // セッションの破棄

			if(isset($_SESSION['session'][0])){
				$arr[] = [
					'check' => 1,
				];
			}else{
				$arr[] = [
					'check' => 0,
			 ];
			}

			$this->set([
  			 'arrcheck' => $arr,
  			 '_serialize' => ['arrcheck']
  		 ]);

		}


	}
