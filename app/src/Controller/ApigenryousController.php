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

class ApigenryousController extends AppController
	{

		public function initialize()
		{
		 parent::initialize();
		 $this->Products = TableRegistry::get('products');
		 $this->Users = TableRegistry::get('users');
		 $this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う

		 $this->ScheduleKouteisTests = TableRegistry::get('scheduleKouteisTests');

		}

													//http://192.168.4.246/Apigenryous/test/api/2020-10-28_2020-11-4_2020-10-28 08:00:00_2_CAS-NDS-20002_0_粉砕量注意！.xml
		public function test()//http://localhost:5000/Apigenryous/test/api/2020-10-28_2020-11-4_2020-10-28 08:00:00_2_CAS-NDS-20002_0_粉砕量注意！.xml
		{
			$data = Router::reverse($this->request, false);//文字化けする後で2回変換すると日本語OK
			$data = urldecode($data);
			$urlarr = explode("/",$data);//切り離し
			if(isset($urlarr[5])){
				$urlarr[4] = $urlarr[4]."/".$urlarr[5];
			}
			$dataarr = explode("_",$urlarr[4]);//切り離し
/*
			echo "<pre>";
			print_r($dataarr);
			echo "</pre>";
*/
			$present_kensahyou = 0;

			$kouteivba = [
				'datetime' => date('Y-m-d H:i:s'),
				'seikeiki' => 1,
				'product_code' => 'genryou',
				'present_kensahyou' => $present_kensahyou,
				'product_name' => 'test',
				'tantou' => $urlarr[4]
			];

			$ScheduleKouteisTests = $this->ScheduleKouteisTests->patchEntity($this->ScheduleKouteisTests->newEntity(), $kouteivba);
			$this->ScheduleKouteisTests->save($ScheduleKouteisTests);

			$this->set([
				'kouteivba' => $kouteivba,
				'_serialize' => ['kouteivba']
			]);
		}

		public function vbagenryouinsert()//http://localhost:5000/Apigenryous/vbagenryouinsert/api/2020-10-28_2020-11-4.xml　//http://localhost:5000/Apigenryous/vbagenryouinsert/api/2020-10-28_08:00:00_2_CAS-NDS-20002_粉砕量注意！.xml
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
					$tantou = mb_convert_encoding($tantou,"UTF-8",mb_detect_encoding($tantou, "ASCII,SJIS,UTF-8,CP51932,SJIS-win", true));
					$product_code = mb_convert_encoding($product_code,"UTF-8",mb_detect_encoding($product_code, "ASCII,SJIS,UTF-8,CP51932,SJIS-win", true));

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

					$daystart = $dataarr[0]." 08:00:00";//1週間の初めの日付の取得
					$dayfinish = $dayfinish." 07:59:59";//1週間の終わりの日付の取得

					if(isset($_SESSION['session'][0])){//誰かがボタンを押して終了していない場合

						sleep(20);//20秒待機

						$this->request->session()->destroy();//セッションの破棄
						$_SESSION['session'][0] = 0;
						$_SESSION['sessionstarttime'] = date('Y-m-d H:i:s');

					}else{//同時に誰もスタートしていない場合

						$_SESSION['session'][0] = 0;
						$_SESSION['sessionstarttime'] = date('Y-m-d H:i:s');

					}

					$_SESSION['deletesta'][0] = $daystart;
					$_SESSION['deletefin'][0] = $dayfinish;

				}elseif($dataarr[0] == "end.xml"){//終了の時に一括でデータを登録してそのセッションを削除

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

								$this->ScheduleKouteis->updateAll(
								['delete_flag' => 1],
								['id'   => $id]
								);

							}

						}

						if ($this->ScheduleKouteis->saveMany($ScheduleKouteis)) {

							$connection->commit();// コミット5
							$this->request->session()->destroy(); // セッションの破棄

						} else {

							$this->Flash->error(__('The data could not be saved. Please, try again.'));
							throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
							$this->request->session()->destroy(); // セッションの破棄

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

	//		return $this->redirect(['action' => 'vbagenryouinsert/api/'.$dataarr[0]."=".$dataarr[1].".xml"]);

		}

	}
