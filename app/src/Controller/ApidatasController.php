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

		public function preadd()//http://localhost:5000 http://192.168.4.246/Apidatas/preadd  http://localhost:5000/Apidatas/preadd
		{
		//	session_start();
		//	$session = $this->request->getSession();

		//	echo "<pre>";
		//	print_r($_SESSION);
		//	echo "</pre>";

	//		$this->request->session()->destroy();
			$staff = $this->Products->newEntity();//newentityに$staffという名前を付ける
			$this->set('staff',$staff);//1行上の$staffをctpで使えるようにセット

//実験
			session_start();
			$session = $this->request->getSession();
			$_SESSION['test'][0] = 1;

			echo "<pre>";
			print_r($_SESSION);
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
													//http://192.168.4.246/Apidatas/test/api/2020-10-28_2020-11-4_2020-10-28 08:00:00_2_CAS-NDS-20002_0_粉砕量注意！.xml
		public function test()//http://localhost:5000/Apidatas/test/api/2020-10-28_2020-11-4_2020-10-28 08:00:00_2_CAS-NDS-20002_0_粉砕量注意！.xml
 	 {
		 			$access_url = $_SERVER['REQUEST_URI'];

		 			//URLをデコードして表示
		 			$data = urldecode($_SERVER['REQUEST_URI']);
		 			//	 echo Router::reverse($this->request, false);//文字化けする

		 			$urlarr = explode("/",$data);//切り離し
		 			$dataarr = explode("_",$urlarr[4]);//切り離し

		 			$daystart = $dataarr[0]." 08:00:00";//1週間の初めの日付の取得
		 			$dayfinish = $dataarr[1]." 07:59:59";//1週間の終わりの日付の取得
		 			$datetime = str_replace("%20", " ", $dataarr[2]);//datetimeの取得
		 			$datetime = str_replace("%3A", ":", $datetime);//datetimeの取得
		 			$seikeiki = $dataarr[3];//seikeikiの取得
		 			$product_code = $dataarr[4];//product_codeの取得
		 			$Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
		 			if(isset($Product[0])){
		 			$product_name = $Product[0]->product_name;
		 			}else{
		 			$product_name = "";
		 			}

		 			$present_kensahyou = $dataarr[5];//present_kensahyouの取得

		 			$tantouarr = explode(".",$dataarr[6]);//切り離し

		 			$tantou = $tantouarr[0];//tantouの取得

		 			$kouteivba['datetime'] = date('Y-m-d H:i:s');
		 			$kouteivba['seikeiki'] = $seikeiki;
		 			$kouteivba['product_code'] = $product_code;
		 			$kouteivba['present_kensahyou'] = $present_kensahyou;
		 			$kouteivba['product_name'] = $product_name;
		 			$kouteivba['tantou'] = $tantou;

		 			$this->set([
		 			'tourokutest' => $kouteivba,
		 			'_serialize' => ['tourokutest']
		 			]);
/*
		 			//1週間分のデータを削除
		 			$ScheduleKouteisdelete = $this->ScheduleKouteis->find()->where(['datetime >=' => $daystart, 'datetime <=' => $dayfinish, 'delete_flag' => 0])->toArray();
		 			if(isset($ScheduleKouteisdelete[0])){

		 				for($k=0; $k<count($ScheduleKouteisdelete); $k++){
		 					$id = $ScheduleKouteisdelete[$k]->id;

		 					$this->ScheduleKouteis->updateAll(
		 					['delete_flag' => 1],
		 					['id'   => $id]
		 					);

		 				}

		 			}
*/
		 			//新しいデータを登録
					$ScheduleKouteisTests = $this->ScheduleKouteisTests->patchEntity($this->ScheduleKouteisTests->newEntity(), $kouteivba);
		 			$this->ScheduleKouteisTests->save($ScheduleKouteisTests);

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

	 public function vbatest()//http://localhost:5000/Apidatas/vbatest/api/test.xml
	{
/*
		$http = new Client();

		$response = $http->put('http://192.168.4.246/Apidatas/vbatest/api/test.xml');//参考https://codelab.website/cakephp3-api/
		$array = json_decode($response->body(), true);//trueがあれば配列として受け取れる　参考https://qiita.com/muramount/items/6be585bf9c031a997d9a

		echo "<pre>";
		print_r($array);
		echo "</pre>";

		$this->set([
				'message' => $array["tourokutestproduct"],
				'_serialize' => ['message']
		]);

		$Products = $this->Products->newEntity($this->request->getData());
		if ($this->Products->save($Products)) {
				$message = '登録されました。';
		} else {
				$message = '登録されませんでした。';
		}
		$this->set([
				'message' => $message,
				'Products' => $Products,
				'_serialize' => ['message', 'Products']
		]);
*/
		if ($this->request->is(['post'])) {//post,put,get
/*
			echo "<pre>";
			print_r('post');
			echo "</pre>";
*/
			$name = $response->getHeaderLine('content-type');
			$count = $response->headers;
			$count = count($count);

			$present_kensahyou = 0;

			$kouteivba = [
				'datetime' => date('Y-m-d H:i:s'),
				'seikeiki' => 1,
				'product_code' => 'post',
				'present_kensahyou' => $present_kensahyou,
				'product_name' => 'post',
				'tantou' => 'post'
			];

			$ScheduleKouteis = $this->ScheduleKouteis->patchEntity($this->ScheduleKouteis->newEntity(), $kouteivba);
			$this->ScheduleKouteis->save($ScheduleKouteis);

		}elseif($this->request->is(['put'])){
/*
			echo "<pre>";
			print_r('put');
			echo "</pre>";
*/
			$jsonData = $this->request->input('json_decode');
			$data = $this->request->input('Cake\Utility\Xml::build', ['return' => 'domdocument']);

			$present_kensahyou = 0;

			$kouteivba = [
				'datetime' => date('Y-m-d H:i:s'),
				'seikeiki' => 1,
				'product_code' => 'put',
				'present_kensahyou' => $present_kensahyou,
				'product_name' => 'put',
				'tantou' => $data
			];

			$ScheduleKouteis = $this->ScheduleKouteis->patchEntity($this->ScheduleKouteis->newEntity(), $kouteivba);
			$this->ScheduleKouteis->save($ScheduleKouteis);

		}elseif($this->request->is(['get'])){
/*
			echo "<pre>";
			print_r('get');
			echo "</pre>";
*/
			$jsonData = $this->request->input('json_decode');

/*
			$http = new Client();
			$response = $http->get('http://localhost:5000/Apidatas/vbatest/api/test.json');
			$name = $response->json;
*/

			$present_kensahyou = 0;

			$kouteivba = [
				'datetime' => date('Y-m-d H:i:s'),
				'seikeiki' => 1,
				'product_code' => 'get',
				'present_kensahyou' => $present_kensahyou,
				'product_name' => 'get',
				'tantou' => $jsonData
			];

			$ScheduleKouteis = $this->ScheduleKouteis->patchEntity($this->ScheduleKouteis->newEntity(), $kouteivba);
			$this->ScheduleKouteis->save($ScheduleKouteis);

		}

		$this->set([
		'tourokutest' => $kouteivba,
		'_serialize' => ['tourokutest']
		]);

	}

																	//http://192.168.4.246/Apidatas/vbakoutei/api/2020-10-28_2020-11-4.xml　//http://192.168.4.246/Apidatas/vbakoutei/api/2020-10-28 08:00:00_2_CAS-NDS-20002_粉砕量注意！.xml
			public function vbakoutei210115()//http://localhost:5000/Apidatas/vbakoutei/api/2020-10-28_2020-11-4.xml　//http://localhost:5000/Apidatas/vbakoutei/api/2020-10-28_08:00:00_2_CAS-NDS-20002_粉砕量注意！.xml
			{
				//URLをデコードして表示
		//		$data = urldecode($_SERVER['REQUEST_URI']);//urlのベタ打ちなら読み込めるが、VBAからだと日本語が読めない
				$data = Router::reverse($this->request, false);//文字化けする後で2回変換すると日本語OK
				$data = urldecode($data);
/*
				echo "<pre>";
				print_r($data);
				echo "</pre>";
*/
				$urlarr = explode("/",$data);//切り離し
				$dataarr = explode("_",$urlarr[4]);//切り離し

					if(isset($dataarr[2])){//ScheduleKouteis登録用の配列に追加

						$datetime = str_replace("%20", " ", $dataarr[0]);//datetimeの取得
						$datetime = str_replace("%3A", ":", $datetime);//datetimeの取得
						$seikeiki = $dataarr[1];//seikeikiの取得
						$product_code = $dataarr[2];//product_codeの取得
						$Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
						if(isset($Product[0])){
						$product_name = $Product[0]->product_name;
						}else{
						$product_name = "";
						}

						$tantouarr = explode(".",$dataarr[3]);//切り離し

						$tantou = $tantouarr[0];//tantouの取得
						$tantou = mb_convert_encoding($tantou,"UTF-8",mb_detect_encoding($tantou, "ASCII,JIS,UTF-8,CP51932,SJIS-win", true));

						$present_kensahyou = 0;

						$kouteivba['datetime'] = $datetime;
						$kouteivba['seikeiki'] = $seikeiki;
						$kouteivba['product_code'] = $product_code;
						$kouteivba['present_kensahyou'] = $present_kensahyou;
						$kouteivba['product_name'] = date('Y-m-d H:i:s');
						$kouteivba['tantou'] = $tantou;

						$this->set([
						'tourokutest' => $kouteivba,
						'_serialize' => ['tourokutest']
						]);

						session_start();
						$session = $this->request->getSession();
						$_SESSION['kouteivba'] = array();
						$_SESSION['kouteivba'][] = $kouteivba;

					}elseif(isset($dataarr[1])){//ScheduleKouteisのdelete_flagを1に変更

			//			$this->request->session()->destroy(); // セッションの破棄

						$dayarr = explode(".",$dataarr[1]);//切り離し
						$dayfinish = $dayarr[0];//tantouの取得

						$daystart = $dataarr[0]." 08:00:00";//1週間の初めの日付の取得
						$dayfinish = $dayfinish." 07:59:59";//1週間の終わりの日付の取得

						session_start();
						$session = $this->request->getSession();
						$_SESSION['deleteday'] = array();
						$_SESSION['deleteday'][0] = $daystart;
						$_SESSION['deleteday'][1] = $dayfinish;

/*
						//1週間分のデータを削除
						$ScheduleKouteisdelete = $this->ScheduleKouteis->find()->where(['datetime >=' => $_SESSION['deleteday'][0], 'datetime <=' => $_SESSION['deleteday'][1], 'delete_flag' => 0])->toArray();
						if(isset($ScheduleKouteisdelete[0])){

							for($k=0; $k<count($ScheduleKouteisdelete); $k++){
								$id = $ScheduleKouteisdelete[$k]->id;

								$this->ScheduleKouteis->updateAll(
								['delete_flag' => 1],
								['id'   => $id]
								);

							}

						}
*/
					}elseif($dataarr[0] == "end.xml"){//終了の時に一括でデータを登録してセッションを削除

						session_start();
						$session = $this->request->getSession();
/*
						$present_kensahyou = 0;

						$kouteivba = [
							'datetime' => date('Y-m-d H:i:s'),
							'seikeiki' => 1,
							'product_code' => 'end',
							'present_kensahyou' => $present_kensahyou,
							'product_name' => 'end',
							'tantou' => 'end'
						];
*/
						//新しいデータを登録
						$ScheduleKouteis = $this->ScheduleKouteis->patchEntities($this->ScheduleKouteis->newEntity(), $_SESSION['kouteivba']);
						$connection = ConnectionManager::get('default');//トランザクション1
						// トランザクション開始2
						$connection->begin();//トランザクション3
						try {//トランザクション4

							$ScheduleKouteisdelete = $this->ScheduleKouteis->find()->where(['datetime >=' => $_SESSION['deleteday'][0], 'datetime <=' => $_SESSION['deleteday'][1], 'delete_flag' => 0])->toArray();
							if(isset($ScheduleKouteisdelete[0])){

								for($k=0; $k<count($ScheduleKouteisdelete); $k++){
									$id = $ScheduleKouteisdelete[$k]->id;

									$this->ScheduleKouteis->updateAll(
									['delete_flag' => 1],
									['id'   => $id]
									);

								}

							}

							//旧DB更新
							$connection = ConnectionManager::get('DB_ikou_test');
							$table = TableRegistry::get('schedule_koutei');
							$table->setConnection($connection);

							for($k=0; $k<count($_SESSION['kouteivba']); $k++){
								$connection->insert('schedule_koutei', [
										'datetime' => $_SESSION['kouteivba'][$k]["datetime"],
										'seikeiki' => $_SESSION['kouteivba'][$k]["seikeiki"],
										'product_id' => $_SESSION['kouteivba'][$k]["product_code"],
										'present_kensahyou' => $_SESSION['kouteivba'][$k]["present_kensahyou"],
										'product_name' => $_SESSION['kouteivba'][$k]["product_name"],
										'tantou' => $_SESSION['kouteivba'][$k]["tantou"],
								]);
							}

							$connection = ConnectionManager::get('default');//新DBに戻る
							$table->setConnection($connection);

							if ($this->ScheduleKouteis->saveMany($ScheduleKouteis)) {

								$connection->commit();// コミット5
				//				$this->request->session()->destroy(); // セッションの破棄
								$_SESSION['kouteivba'] = array();
								$_SESSION['deleteday'] = array();
								$_SESSION['session'] = array();
								$_SESSION['sessionstarttime'] = array();

							} else {

								$this->Flash->error(__('The data could not be saved. Please, try again.'));
								throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
				//				$this->request->session()->destroy(); // セッションの破棄
								$_SESSION['kouteivba'] = array();
								$_SESSION['deleteday'] = array();
								$_SESSION['session'] = array();
								$_SESSION['sessionstarttime'] = array();

							}
						} catch (Exception $e) {//トランザクション7
						//ロールバック8
							$connection->rollback();//トランザクション9
						}//トランザクション10

					}

			}

															 //http://192.168.4.246/Apidatas/vbakoutei/api/2020-10-28_2020-11-4.xml　//http://192.168.4.246/Apidatas/vbakoutei/api/2020-10-28_08:00:00_2_CAS-NDS-20002_粉砕量注意！.xml
		public function vbakoutei()//http://localhost:5000/Apidatas/vbakoutei/api/2020-10-28_2020-11-4.xml　//http://localhost:5000/Apidatas/vbakoutei/api/2020-10-28_08:00:00_2_CAS-NDS-20002_粉砕量注意！.xml
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
		//			$tantou = mb_convert_encoding($tantou,"UTF-8",mb_detect_encoding($tantou, "ASCII,SJIS,UTF-8,CP51932,SJIS-win", true));
		//			$product_code = mb_convert_encoding($product_code,"UTF-8",mb_detect_encoding($product_code, "ASCII,SJIS,UTF-8,CP51932,SJIS-win", true));
/*
					echo "<pre>";
					print_r($product_code);
					echo "</pre>";
*/
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

					session_start();
					$session = $this->request->getSession();
					$_SESSION['kouteivba'][] = $kouteivba;

				}elseif(!isset($dataarr[2])){//まずここにくる

					session_start();
					$session = $this->request->getSession();

					$dayarr = explode(".",$dataarr[1]);//切り離し
					$dayfinish = $dayarr[0];

					$dayfinish = strtotime($dayfinish);
					$dayfinish = date('Y-m-d', strtotime('+1 day', $dayfinish));

					$daystart = $dataarr[0]." 08:00:00";//1週間の初めの日付の取得
					$dayfinish = $dayfinish." 07:59:59";//1週間の終わりの日付の取得

					if(isset($_SESSION['session'][0])){//誰かがボタンを押して終了していない場合

						sleep(20);//20秒待機

				//		$this->request->session()->destroy();//セッションの破棄
						$_SESSION['kouteivba'] = array();
						$_SESSION['deleteday'] = array();
						$_SESSION['session'] = array();
						$_SESSION['sessionstarttime'] = array();

						$_SESSION['session'][0] = 0;
						$_SESSION['sessionstarttime'] = date('Y-m-d H:i:s');

					}else{//同時に誰もスタートしていない場合

						$_SESSION['session'][0] = 0;
						$_SESSION['sessionstarttime'] = date('Y-m-d H:i:s');

					}

					$_SESSION['deletesta'][0] = $daystart;
					$_SESSION['deletefin'][0] = $dayfinish;

				}elseif($dataarr[2] == "end.xml"){//終了の時に一括でデータを登録してそのセッションを削除

					session_start();
					$session = $this->request->getSession();

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
/*
							$connection = ConnectionManager::get('DB_ikou_test');
							$table = TableRegistry::get('schedule_koutei');
							$table->setConnection($connection);

							$delete_schedule_koutei= "DELETE FROM schedule_koutei where datetime >= '".$_SESSION['deletesta'][0]."' and datetime <= '".$_SESSION['deletefin'][0]."'";
							$connection->execute($delete_schedule_koutei);

							for($k=0; $k<count($_SESSION['kouteivba']); $k++){
								$connection->insert('schedule_koutei', [
										'datetime' => $_SESSION['kouteivba'][$k]["datetime"],
										'seikeiki' => $_SESSION['kouteivba'][$k]["seikeiki"],
										'product_id' => $_SESSION['kouteivba'][$k]["product_code"],
										'present_kensahyou' => $_SESSION['kouteivba'][$k]["present_kensahyou"],
										'product_name' => $_SESSION['kouteivba'][$k]["product_name"],
										'tantou' => $_SESSION['kouteivba'][$k]["tantou"],
								]);
							}

							$connection = ConnectionManager::get('default');//新DBに戻る
							$table->setConnection($connection);
*/
							$connection->commit();// コミット5
			//				$this->request->session()->destroy(); // セッションの破棄
							$_SESSION['kouteivba'] = array();
							$_SESSION['deleteday'] = array();
							$_SESSION['session'] = array();
							$_SESSION['sessionstarttime'] = array();

						} else {

							$this->Flash->error(__('The data could not be saved. Please, try again.'));
							throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
			//				$this->request->session()->destroy(); // セッションの破棄
							$_SESSION['kouteivba'] = array();
							$_SESSION['deleteday'] = array();
							$_SESSION['session'] = array();
							$_SESSION['sessionstarttime'] = array();

						}
					} catch (Exception $e) {//トランザクション7
					//ロールバック8
						$connection->rollback();//トランザクション9
					}//トランザクション10

				}

		}

		public function vbaredirect()
		{

			$Data = $this->request->query('s');
			$returndata = $Data["returndata"];
			$dataarr = explode("_",$returndata);//切り離し
/*
			echo "<pre>";
			print_r($dataarr);
			echo "</pre>";
*/
	//		sleep(10);

	//		return $this->redirect(['action' => 'vbakoutei/api/'.$dataarr[0]."=".$dataarr[1].".xml"]);

		}

	}
