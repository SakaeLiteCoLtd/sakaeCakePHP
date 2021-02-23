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
		 $this->OrderMaterials = TableRegistry::get('orderMaterials');
		 $this->OrderSpecials = TableRegistry::get('orderSpecials');
		 $this->PriceMaterials = TableRegistry::get('priceMaterials');
		 $this->DeliverCompanies = TableRegistry::get('deliverCompanies');
		 $this->Suppliers = TableRegistry::get('suppliers');

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

			$genryouvba = [
				'datetime' => date('Y-m-d H:i:s'),
				'seikeiki' => 1,
				'product_code' => 'genryou',
				'present_kensahyou' => $present_kensahyou,
				'product_name' => 'test',
				'tantou' => $urlarr[4]
			];

			$ScheduleKouteisTests = $this->ScheduleKouteisTests->patchEntity($this->ScheduleKouteisTests->newEntity(), $genryouvba);
			$this->ScheduleKouteisTests->save($ScheduleKouteisTests);

			$this->set([
				'genryouvba' => $genryouvba,
				'_serialize' => ['genryouvba']
			]);
		}

		//http://localhost:5000/Apigenryous/vbagenryouinsert/api/20210208_02_AP03B_N_200_2021-2-8_2_1001.xml
		//http://localhost:5000/Apigenryous/vbagenryouinsert/api/20210208_02_AP03B_N_200_2021-2-8_2_1001.xml
		//http://localhost:5000/Apigenryous/vbagenryouinsert/api/20210208_02_AP03B_N_200_2021-2-8_2_1001.xml
		public function vbagenryouinsert()
		{
			$data = Router::reverse($this->request, false);//文字化けする後で2回変換すると日本語OK
			$data = urldecode($data);
			$data = mb_convert_encoding($data,"UTF-8",mb_detect_encoding($data, "ASCII,SJIS,UTF-8,CP51932,SJIS-win", true));
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
/*
			echo "<pre>";
			print_r($urlarr[4]);
			echo "</pre>";
*/
			if($dataarr[0] == "start.xml"){
				$alertcheck = 0;

				session_start();
				if(isset($_SESSION['sessiongenryou'][0])){//誰かがボタンを押して終了していない場合

					sleep(5);//20秒待機

		//			$this->request->session()->destroy();//セッションの破棄
					$_SESSION['sessiongenryou'] = array();
					$_SESSION['alertcheck'] = array();
					$_SESSION['specialvba'] = array();
					$_SESSION['genryouvba'] = array();

					$_SESSION['sessiongenryou'][0] = 0;

				}else{//同時に誰もスタートしていない場合

					$_SESSION['sessiongenryou'][0] = 0;

				}

				$_SESSION['alertcheck'] = $alertcheck;
				$this->set([
						'alert' => $_SESSION['alertcheck'],
						'_serialize' => ['alert']
				]);

			}if($dataarr[0] == "stop.xml"){

				session_start();
				$_SESSION['specialvba'] = array();
				$_SESSION['genryouvba'] = array();
				$_SESSION['sessiongenryou'] = array();
				$_SESSION['alertcheck'] = array();

			}elseif(isset($dataarr[2])){
				$alertcheck = 0;

				$grade = $dataarr[2];
				$color = $dataarr[3];
				$purchaserarr = explode(".",$dataarr[7]);//切り離し
				$purchaser = $purchaserarr[0];//tantouの取得

				$PriceMaterials = $this->PriceMaterials->find('all')->where(['grade' => $grade, 'color' => $color, 'delete_flag' => 0])->toArray();
				if(isset($PriceMaterials[0])){
					$sup_id = $PriceMaterials[0]->sup_id;
					$price = $PriceMaterials[0]->price;
				}else{
					$sup_id = "";
					$price = "";
				}

				$Staffs = $this->Staffs->find('all')->where(['staff_code' => $purchaser])->toArray();
				$staffid = $Staffs[0]->id;

				$id_order = $dataarr[0]."_".$dataarr[1];
				$checkOrderMaterials = $this->OrderMaterials->find('all')->where(['id_order' => $id_order])
				->order(["id_order"=>"DESC"])->toArray();

				if(!isset($checkOrderMaterials[0])){

						$genryouvba['id_order'] = $dataarr[0]."_".$dataarr[1];
						$genryouvba['grade'] = $grade;
						$genryouvba['color'] = $color;
						$genryouvba['date_order'] = date('Y-m-d');
						$genryouvba['amount'] = $dataarr[4];
						$genryouvba['date_stored'] = $dataarr[5];
						$genryouvba['sup_id'] = $sup_id;
						$genryouvba['deliv_cp'] = $dataarr[6];
						$genryouvba['purchaser'] = $purchaser;
						$genryouvba['price'] = $price;
						$genryouvba['first_date_st'] = $dataarr[5];
						$genryouvba['created_at'] = date('Y-m-d H:i:s');
						$genryouvba['created_staff'] = $staffid;

						$this->set([
						'tourokutest' => $genryouvba,
						'_serialize' => ['tourokutest']
						]);

						session_start();
						$session = $this->request->getSession();
						$_SESSION['genryouvba'][] = $genryouvba;

						if($dataarr[6] > 1){

							$DeliverCompanies = $this->DeliverCompanies->find('all')->where(['id' => $dataarr[6]])->toArray();
							$cs_id = $DeliverCompanies[0]->customer_code;

							$specialvba['date_order'] = date('Y-m-d');
							$specialvba['num_order'] = $dataarr[0]."_".$dataarr[1];
							$specialvba['order_name'] = $grade."  ".$color."(genryou)";
							$specialvba['price'] = $price;
							$specialvba['date_deliver'] = $dataarr[5];
							$specialvba['amount'] = $dataarr[4];
							$specialvba['cs_id'] = $cs_id;
							$specialvba['kannou'] = 0;
							$specialvba['created_at'] = date('Y-m-d H:i:s');
							$specialvba['created_staff'] = $staffid;

							$_SESSION['specialvba'][] = $specialvba;

						}

					}else{

						$id_order_moto = $checkOrderMaterials[0]->id_order;
						$id_order_moto_arr = explode("_",$id_order_moto);//切り離し
						$count = str_pad(count($checkOrderMaterials)+1, 2, 0, STR_PAD_LEFT);
						$id_order = $id_order_moto_arr[0]."_".$count;

						$genryouvba['id_order'] = $id_order;
						$genryouvba['grade'] = $grade;
						$genryouvba['color'] = $color;
						$genryouvba['date_order'] = date('Y-m-d');
						$genryouvba['amount'] = $dataarr[4];
						$genryouvba['date_stored'] = $dataarr[5];
						$genryouvba['sup_id'] = $sup_id;
						$genryouvba['deliv_cp'] = $dataarr[6];
						$genryouvba['purchaser'] = $purchaser;
						$genryouvba['price'] = $price;
						$genryouvba['first_date_st'] = $dataarr[5];
						$genryouvba['created_at'] = date('Y-m-d H:i:s');
						$genryouvba['created_staff'] = $staffid;

						$this->set([
						'tourokutest' => $genryouvba,
						'_serialize' => ['tourokutest']
						]);

						session_start();
						$session = $this->request->getSession();
						$_SESSION['genryouvba'][] = $genryouvba;

						if($dataarr[6] > 1){

							$DeliverCompanies = $this->DeliverCompanies->find('all')->where(['id' => $dataarr[6]])->toArray();
							$cs_id = $DeliverCompanies[0]->customer_code;

							$specialvba['date_order'] = date('Y-m-d');
							$specialvba['num_order'] = $id_order;
							$specialvba['order_name'] = $grade."  ".$color."(genryou)";
							$specialvba['price'] = $price;
							$specialvba['date_deliver'] = $dataarr[5];
							$specialvba['amount'] = $dataarr[4];
							$specialvba['cs_id'] = $cs_id;
							$specialvba['kannou'] = 0;
							$specialvba['created_at'] = date('Y-m-d H:i:s');
							$specialvba['created_staff'] = $staffid;

							$_SESSION['specialvba'][] = $specialvba;

						}

						$alertcheck = $alertcheck + 1;

					}

					$_SESSION['alertcheck'] = $alertcheck;
					$this->set([
							'alert' => $_SESSION['alertcheck'],
							'_serialize' => ['alert']
					]);

			}elseif($dataarr[0] == "end.xml"){//終了の時に一括でデータを登録してそのセッションを削除

				session_start();
				$session = $this->request->getSession();

				//新しいデータを登録
				$OrderMaterials = $this->OrderMaterials->patchEntities($this->OrderMaterials->newEntity(), $_SESSION['genryouvba']);
				$connection = ConnectionManager::get('default');//トランザクション1
				// トランザクション開始2
				$connection->begin();//トランザクション3
				try {//トランザクション4

					if ($this->OrderMaterials->saveMany($OrderMaterials)) {

						if(isset($_SESSION['specialvba'][0])){
							$OrderSpecials = $this->OrderSpecials->patchEntities($this->OrderSpecials->newEntity(), $_SESSION['specialvba']);
							$this->OrderSpecials->saveMany($OrderSpecials);
						}

						$connection->commit();// コミット5
		//				$this->request->session()->destroy(); // セッションの破棄
						$_SESSION['specialvba'] = array();
						$_SESSION['genryouvba'] = array();
						$_SESSION['sessiongenryou'] = array();
						$_SESSION['alertcheck'] = array();
						$alertcheck = 0;

					} else {

						$this->Flash->error(__('The data could not be saved. Please, try again.'));
						throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
		//				$this->request->session()->destroy(); // セッションの破棄
						$_SESSION['specialvba'] = array();
						$_SESSION['genryouvba'] = array();
						$_SESSION['sessiongenryou'] = array();
						$_SESSION['alertcheck'] = array();
						$alertcheck = 0;

					}

				} catch (Exception $e) {//トランザクション7
				//ロールバック8
					$connection->rollback();//トランザクション9
				}//トランザクション10

				$this->set([
						'alert' => 0,
						'_serialize' => ['alert']
				]);

			}

		}

		public function vbaredirect()//http://localhost:5000/Apigenryous/vbaredirect/api/20210208_02_AP03B2_N_200_2021-2-8_2_1001.xml
		{
			session_start();
	//		$this->request->session()->destroy(); // セッションの破棄
/*
			$session = $this->request->getSession();

			echo "<pre>";
			print_r($_SESSION);
			echo "</pre>";

			$this->set([
			'tourokutest' => $_SESSION,
			'_serialize' => ['tourokutest']
			]);

			$OrderMaterials = $this->OrderMaterials->patchEntity($this->ScheduleKouteisTests->newEntity(), $_SESSION["genryouvba"][0]);
			$this->OrderMaterials->save($OrderMaterials);
*/

			$Data = $this->request->query('s');
			$returndata = $Data["returndata"];
//			$dataarr = explode("_",$returndata);//切り離し

			sleep(10);

			return $this->redirect(['action' => 'vbagenryouinsert/api/'.$returndata.".xml"]);

		}

		public function vbayobidashi()//http://localhost:5000/Apigenryous/vbayobidashi/api/2021-1-18.xml
		{
			$data = Router::reverse($this->request, false);//文字化けする後で2回変換すると日本語OK
			$data = urldecode($data);

			$urlarr = explode("/",$data);//切り離し
			if(isset($urlarr[5])){
				$urlarr[4] = $urlarr[4]."/".$urlarr[5];
			}
			$dataarr = explode(".",$urlarr[4]);//切り離し
/*
			echo "<pre>";
			print_r($dataarr[0]);
			echo "</pre>";
*/
			$OrderMaterials = $this->OrderMaterials->find()->where(['date_order' => $dataarr[0]])->toArray();
			$arrOrderMaterials = array();
			for($k=0; $k<count($OrderMaterials); $k++){

				$arrOrderMaterials[] = [
					'id_order' => $OrderMaterials[$k]["id_order"],
					'grade' => $OrderMaterials[$k]["grade"],
					'color' => $OrderMaterials[$k]["color"],
					'amount' => $OrderMaterials[$k]["amount"],
					'date_stored' => $OrderMaterials[$k]["date_stored"]->format('m月d日')
			 ];

			}

			$this->set([
					'OrderMaterials' => $arrOrderMaterials,
					'_serialize' => ['OrderMaterials']
			]);

		}

		public function vbasyousya()//http://localhost:5000/Apigenryous/vbasyousya/api/2021-1-18.xml
		{
			$data = Router::reverse($this->request, false);//文字化けする後で2回変換すると日本語OK
			$data = urldecode($data);

			$urlarr = explode("/",$data);//切り離し
			if(isset($urlarr[5])){
				$urlarr[4] = $urlarr[4]."/".$urlarr[5];
			}
			$dataarr = explode(".",$urlarr[4]);//切り離し
/*
			echo "<pre>";
			print_r($dataarr[0]);
			echo "</pre>";
*/
			$OrderMaterials = $this->OrderMaterials->find()->where(['date_order' => $dataarr[0]])->toArray();
			$arrSuppliers = array();
			for($k=0; $k<count($OrderMaterials); $k++){

				$sup_id = $OrderMaterials[$k]["sup_id"];

				$Suppliers = $this->Suppliers->find()->where(['id' => $sup_id])->toArray();
				$sup_name = $Suppliers[0]->name;

				$arrSuppliers[] = [
					'sup_id' => $sup_id,
					'sup_name' => $sup_name
			 ];

			}

			$arrSuppliers = array_unique($arrSuppliers, SORT_REGULAR);
			$arrSuppliers = array_values($arrSuppliers);

			$this->set([
					'Suppliers' => $arrSuppliers,
					'_serialize' => ['Suppliers']
			]);

		}

		public function vbatyuumonsyo()//http://localhost:5000/Apigenryous/vbatyuumonsyo/api/2021-1-22_14.xml
		{
			$data = Router::reverse($this->request, false);//文字化けする後で2回変換すると日本語OK
			$data = urldecode($data);

			$urlarr = explode("/",$data);//切り離し
			$dataarr = explode("_",$urlarr[4]);//切り離し
			$suparr = explode(".",$dataarr[1]);//切り離し

			$OrderMaterials = $this->OrderMaterials->find()->where(['date_order' => $dataarr[0], 'sup_id' => $suparr[0]])->order(['date_stored' => 'DESC'])->toArray();
			$arrTyuumons = array();

			for($k=0; $k<count($OrderMaterials); $k++){

				$sup_id = $OrderMaterials[$k]["sup_id"];

				$Suppliers = $this->Suppliers->find()->where(['id' => $sup_id])->toArray();
				$sup_name = $Suppliers[0]->name;
				$charge_p = $Suppliers[0]->charge_p;

				$deliv_cp = $OrderMaterials[$k]["deliv_cp"];
				$DeliverCompanies = $this->DeliverCompanies->find()->where(['id' => $deliv_cp])->toArray();
				$company = $DeliverCompanies[0]->company;

				$PriceMaterials = $this->PriceMaterials->find('all')->where(['delete_flag' => 0, 'grade' => $OrderMaterials[$k]["grade"], 'color' => $OrderMaterials[$k]["color"]])->toArray();
				if(isset($PriceMaterials[0])){
					$tani = $PriceMaterials[0]->tani;
				}else{
					$tani = "";
				}

				$arrTyuumons[] = [
					'grade' => $OrderMaterials[$k]["grade"],
					'color' => $OrderMaterials[$k]["color"],
					'amount' => $OrderMaterials[$k]["amount"],
					'tani' => $tani,
					'date_stored' => $OrderMaterials[$k]["date_stored"]->format('m/d'),
					'company' => $company,
					'sup_name' => $sup_name,
					'charge_p' => $charge_p
			 ];

			}

			$this->set([
					'Tyuumons' => $arrTyuumons,
					'_serialize' => ['Tyuumons']
			]);

		}


	}
