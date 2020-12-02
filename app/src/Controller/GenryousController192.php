<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション
use App\myClass\Logins\htmlLogin;//myClassフォルダに配置したクラスを使用

use Cake\Routing\Router;//urlの取得

class GenryousController extends AppController
	{

		public function initialize()
		{
		 parent::initialize();
		 $this->OrderMaterials = TableRegistry::get('orderMaterials');
		 $this->ScheduleKouteis = TableRegistry::get('scheduleKouteis');
		 $this->Products = TableRegistry::get('products');
		}

		public function menu()
    {
			$Data=$this->request->query('s');//セッションが切れて戻ってきた場合
      if(isset($Data["mess"])){
        $mess = $Data["mess"];
        $this->set('mess',$mess);
      }else{
        $mess = "";
        $this->set('mess',$mess);
      }
    }

		public function tourokuzumisearch()
    {
			$OrderMaterials = $this->OrderMaterials->newEntity();
	    $this->set('OrderMaterials',$OrderMaterials);

			$dateYMD = date('Y-m-d');
      $dateYMD1 = strtotime($dateYMD);
      $dayyey = date('Y', strtotime('-1 day', $dateYMD1));
      $arrYears = array();
      for ($k=2009; $k<=$dayyey; $k++){
        $arrYears[$k]=$k;
      }
      $this->set('arrYears',$arrYears);

      $arrMonths = array();
			for ($k=1; $k<=12; $k++){
				$arrMonths[$k] =$k;
			}
      $this->set('arrMonths',$arrMonths);

      $arrDays = array();
			for ($k=1; $k<=31; $k++){
				$arrDays[$k] =$k;
			}
      $this->set('arrDays',$arrDays);

			$arrDelivCp = [
				'0' => NULL,
				'1' => '（株）栄ライト工業所',
				'2' => '三枝化工（株）',
				'3' => '（株）六幸産業',
				'4' => '三和化成工業（株）',
				'5' => '（株）愛和',
				'6' => '（株）大二',
				'7' => '（有）バンプラス'
			];
			$this->set('arrDelivCp',$arrDelivCp);

    }

		public function tourokuzumiitiran()
    {
			$data = $this->request->getData();

			$OrderMaterials = $this->OrderMaterials->newEntity();
	    $this->set('OrderMaterials',$OrderMaterials);

			$hattyu_date_sta = $data['hattyu_date_sta_year']."-".$data['hattyu_date_sta_month']."-".$data['hattyu_date_sta_date'];
			$hattyu_date_fin = $data['hattyu_date_fin_year']."-".$data['hattyu_date_fin_month']."-".$data['hattyu_date_fin_date'];
			$nyuuko_date_sta = $data['nyuuko_date_sta_year']."-".$data['nyuuko_date_sta_month']."-".$data['nyuuko_date_sta_date'];
			$nyuuko_date_fin = $data['nyuuko_date_fin_year']."-".$data['nyuuko_date_fin_month']."-".$data['nyuuko_date_fin_date'];

			$m_grade = $data['m_grade'];
			$col_num = $data['col_num'];
			$deliv_cp = $data['deliv_cp'];

			if(empty($data['m_grade'])){

				if(empty($data['col_num'])){

					if(empty($data['deliv_cp'])){//m_grade,col_num,deliv_cpがNULLの場合　//全部null

						$arrOrderMaterials = $this->OrderMaterials->find()
	          ->where(['date_order >=' => $hattyu_date_sta, 'date_order <=' => $hattyu_date_fin, 'date_stored >=' => $nyuuko_date_sta, 'date_stored <=' => $nyuuko_date_fin])->order(["date_order"=>"ASC"])->toArray();
	          $this->set('arrOrderMaterials',$arrOrderMaterials);

					}else{//m_grade,col_numがNULL　deliv_cpはあり　//deliv_cp〇

						$arrOrderMaterials = $this->OrderMaterials->find()
	          ->where(['deliv_cp' => $deliv_cp, 'date_order >=' => $hattyu_date_sta, 'date_order <=' => $hattyu_date_fin, 'date_stored >=' => $nyuuko_date_sta, 'date_stored <=' => $nyuuko_date_fin])->order(["date_order"=>"ASC"])->toArray();
	          $this->set('arrOrderMaterials',$arrOrderMaterials);

					}

				}else{

					if(empty($data['deliv_cp'])){//col_num〇

						$arrOrderMaterials = $this->OrderMaterials->find()
	          ->where(['color' => $col_num, 'date_order >=' => $hattyu_date_sta, 'date_order <=' => $hattyu_date_fin, 'date_stored >=' => $nyuuko_date_sta, 'date_stored <=' => $nyuuko_date_fin])->order(["date_order"=>"ASC"])->toArray();
	          $this->set('arrOrderMaterials',$arrOrderMaterials);

					}else{//col_num、deliv_cp〇

						$arrOrderMaterials = $this->OrderMaterials->find()
	          ->where(['color' => $col_num, 'deliv_cp' => $deliv_cp, 'date_order >=' => $hattyu_date_sta, 'date_order <=' => $hattyu_date_fin, 'date_stored >=' => $nyuuko_date_sta, 'date_stored <=' => $nyuuko_date_fin])->order(["date_order"=>"ASC"])->toArray();
	          $this->set('arrOrderMaterials',$arrOrderMaterials);

					}

				}

			}else{

				if(empty($data['col_num'])){

					if(empty($data['deliv_cp'])){//m_grade〇

						$arrOrderMaterials = $this->OrderMaterials->find()
	          ->where(['grade' => $m_grade, 'date_order >=' => $hattyu_date_sta, 'date_order <=' => $hattyu_date_fin, 'date_stored >=' => $nyuuko_date_sta, 'date_stored <=' => $nyuuko_date_fin])->order(["date_order"=>"ASC"])->toArray();
	          $this->set('arrOrderMaterials',$arrOrderMaterials);

					}else{//m_grade、deliv_cp〇

						$arrOrderMaterials = $this->OrderMaterials->find()
	          ->where(['deliv_cp' => $deliv_cp, 'grade' => $m_grade, 'date_order >=' => $hattyu_date_sta, 'date_order <=' => $hattyu_date_fin, 'date_stored >=' => $nyuuko_date_sta, 'date_stored <=' => $nyuuko_date_fin])->order(["date_order"=>"ASC"])->toArray();
	          $this->set('arrOrderMaterials',$arrOrderMaterials);

					}

				}else{

					if(empty($data['deliv_cp'])){//m_grade、col_num〇

						$arrOrderMaterials = $this->OrderMaterials->find()
	          ->where(['grade' => $m_grade, 'color' => $col_num, 'date_order >=' => $hattyu_date_sta, 'date_order <=' => $hattyu_date_fin, 'date_stored >=' => $nyuuko_date_sta, 'date_stored <=' => $nyuuko_date_fin])->order(["date_order"=>"ASC"])->toArray();
	          $this->set('arrOrderMaterials',$arrOrderMaterials);

					}else{//m_grade、col_num、deliv_cp〇

						$arrOrderMaterials = $this->OrderMaterials->find()
	          ->where(['grade' => $m_grade, 'color' => $col_num, 'deliv_cp' => $deliv_cp, 'date_order >=' => $hattyu_date_sta, 'date_order <=' => $hattyu_date_fin, 'date_stored >=' => $nyuuko_date_sta, 'date_stored <=' => $nyuuko_date_fin])->order(["date_order"=>"ASC"])->toArray();
	          $this->set('arrOrderMaterials',$arrOrderMaterials);

					}

				}

			}
/*
			echo "<pre>";
			print_r($arrOrderMaterials);
			echo "</pre>";
*/
    }

		public function nyuukopreadd()
    {
			$this->request->session()->destroy();// セッションの破棄
      session_start();//セッションの開始
			$OrderMaterials = $this->OrderMaterials->newEntity();
	    $this->set('OrderMaterials',$OrderMaterials);
    }

		public function nyuukologin()
    {
			if ($this->request->is('post')) {
        $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
        $this->set('data',$data);//セット
        $userdata = $data['username'];
        $this->set('userdata',$userdata);//セット

        $htmllogin = new htmlLogin();//クラスを使用
        $arraylogindate = $htmllogin->htmllogin($userdata);//クラスを使用（$userdataを持っていき、$arraylogindateを持って帰る）

        $username = $arraylogindate[0];
        $delete_flag = $arraylogindate[1];
        $this->set('username',$username);
        $this->set('delete_flag',$delete_flag);

        $user = $this->Auth->identify();

 					if ($user) {
 						$this->Auth->setUser($user);
            return $this->redirect(['action' => 'nyuukomenu']);//nyuukomenuへ移動
 					}
 				}
    }

		public function nyuukomenu()
    {
			$session = $this->request->getSession();
			$datasession = $session->read();

			if(!isset($datasession['Auth'])){
        return $this->redirect(['action' => 'menu',
        's' => ['mess' => "セッションが切れました。この画面からやり直してください。"]]);
      }
    }

		public function nyuukotyouka()
		{
			$OrderMaterials = $this->OrderMaterials->newEntity();
	    $this->set('OrderMaterials',$OrderMaterials);

			$session = $this->request->getSession();
			$datasession = $session->read();

			if(!isset($datasession['Auth'])){
        return $this->redirect(['action' => 'menu',
        's' => ['mess' => "セッションが切れました。この画面からやり直してください。"]]);
      }

			$dateYMD = date('Y-m-d');

			$arrOrderMaterials = $this->OrderMaterials->find()
			->where(['flg !=' => 1, 'date_stored <=' => $dateYMD])->order(["date_stored"=>"ASC"])->toArray();
			$this->set('arrOrderMaterials',$arrOrderMaterials);

			$arrGyousya = [
				'0' => '連絡なし',
				'1' => '済',
				'2' => 'メーカー回答待ち',
				'3' => '納期変更済み'
							];
			$this->set('arrGyousya',$arrGyousya);

			$arrFlag = [
				'0' => '-----',
				'1' => '入荷済'
							];
			$this->set('arrFlag',$arrFlag);
		}

		public function nyuukotyoukakousin()
		{
			$OrderMaterials = $this->OrderMaterials->newEntity();
			$this->set('OrderMaterials',$OrderMaterials);

			$session = $this->request->getSession();
			$datasession = $session->read();

			if(!isset($datasession['Auth'])){
        return $this->redirect(['action' => 'menu',
        's' => ['mess' => "セッションが切れました。この画面からやり直してください。"]]);
      }

			$data = $this->request->getData();

			$num = array_keys($data, '更新');
			$num = $num[0];

			$date_stored = $data['date_stored'.$num]['year']."-".$data['date_stored'.$num]['month']."-".$data['date_stored'.$num]['day'];
			$num_lot = $data['num_lot'.$num];
			$check_flag = $data['check_flag'.$num];
			$flg = $data['flg'.$num];
/*
			echo "<pre>";
			print_r($datasession['Auth']['User']['staff_id']);
			echo "</pre>";
*/
			$motoOrderMaterials = $this->OrderMaterials->find()
			->where(['id' => $data['id']])->toArray();
			$moto_id_order = $motoOrderMaterials[0]->id_order;

			$OrderMaterial = $this->OrderMaterials->patchEntity($OrderMaterials, $data);
			$connection = ConnectionManager::get('default');//トランザクション1
			 // トランザクション開始2
			 $connection->begin();//トランザクション3
			 try {//トランザクション4
				 if ($this->OrderMaterials->updateAll(//検査終了時間の更新
					 ['date_stored' => $date_stored, 'num_lot' => $num_lot, 'check_flag' => $check_flag,
					  'flg' => $flg, 'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $datasession['Auth']['User']['staff_id']],
					 ['id'  => $data['id']]
				 )){

					 //旧DBに単価登録
					 $connection = ConnectionManager::get('sakaeMotoDB');
					 $table = TableRegistry::get('order_material');
					 $table->setConnection($connection);

					 $updater = "UPDATE order_material set date_stored ='".$date_stored."', num_lot ='".$num_lot."',
					  check_flag ='".$check_flag."', flg ='".$flg."', updated_at ='".date('Y-m-d H:i:s')."', updated_staff ='".$datasession['Auth']['User']['staff_id']."'
					 where id ='".$moto_id_order."'";
					 $connection->execute($updater);

					 $connection = ConnectionManager::get('default');//新DBに戻る
					 $table->setConnection($connection);

					$mes = "※更新されました。";
					$this->set('mes',$mes);
					$connection->commit();// コミット5

			 } else {

				 $mes = "※更新されませんでした";
				 $this->set('mes',$mes);
				 $this->Flash->error(__('The date could not be saved. Please, try again.'));
				 throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6

			 }

		 } catch (Exception $e) {//トランザクション7
		 //ロールバック8
			 $connection->rollback();//トランザクション9
		 }//トランザクション10

		 $dateYMD = date('Y-m-d');

		 $arrOrderMaterials = $this->OrderMaterials->find()
		 ->where(['flg !=' => 1, 'date_stored <=' => $dateYMD])->order(["date_stored"=>"ASC"])->toArray();
		 $this->set('arrOrderMaterials',$arrOrderMaterials);

		 $arrGyousya = [
			 '0' => '連絡なし',
			 '1' => '済',
			 '2' => 'メーカー回答待ち',
			 '3' => '納期変更済み'
						 ];
		 $this->set('arrGyousya',$arrGyousya);

		 $arrFlag = [
			 '0' => '-----',
			 '1' => '入荷済'
						 ];
		 $this->set('arrFlag',$arrFlag);

		}


		public function nyuukominyuuka()
		{
			$OrderMaterials = $this->OrderMaterials->newEntity();
	    $this->set('OrderMaterials',$OrderMaterials);

			$session = $this->request->getSession();
			$datasession = $session->read();

			if(!isset($datasession['Auth'])){
        return $this->redirect(['action' => 'menu',
        's' => ['mess' => "セッションが切れました。この画面からやり直してください。"]]);
      }

			$arrOrderMaterials = $this->OrderMaterials->find()
			->where(['flg !=' => 1])->order(["date_stored"=>"ASC"])->toArray();
			$this->set('arrOrderMaterials',$arrOrderMaterials);

			$arrGyousya = [
				'0' => '連絡なし',
				'1' => '済',
				'2' => 'メーカー回答待ち',
				'3' => '納期変更済み'
							];
			$this->set('arrGyousya',$arrGyousya);

			$arrFlag = [
				'0' => '-----',
				'1' => '入荷済'
							];
			$this->set('arrFlag',$arrFlag);
		}

		public function nyuukominyuukakousin()
		{
			$OrderMaterials = $this->OrderMaterials->newEntity();
			$this->set('OrderMaterials',$OrderMaterials);

			$session = $this->request->getSession();
			$datasession = $session->read();

			if(!isset($datasession['Auth'])){
        return $this->redirect(['action' => 'menu',
        's' => ['mess' => "セッションが切れました。この画面からやり直してください。"]]);
      }

			$data = $this->request->getData();

			$num = array_keys($data, '更新');
			$num = $num[0];

			$date_stored = $data['date_stored'.$num]['year']."-".$data['date_stored'.$num]['month']."-".$data['date_stored'.$num]['day'];
			$num_lot = $data['num_lot'.$num];
			$check_flag = $data['check_flag'.$num];
			$flg = $data['flg'.$num];
/*
			echo "<pre>";
			print_r($datasession['Auth']['User']['staff_id']);
			echo "</pre>";
*/
			$motoOrderMaterials = $this->OrderMaterials->find()
			->where(['id' => $data['id']])->toArray();
			$moto_id_order = $motoOrderMaterials[0]->id_order;

			$OrderMaterial = $this->OrderMaterials->patchEntity($OrderMaterials, $data);
			$connection = ConnectionManager::get('default');//トランザクション1
			 // トランザクション開始2
			 $connection->begin();//トランザクション3
			 try {//トランザクション4
				 if ($this->OrderMaterials->updateAll(//検査終了時間の更新
					 ['date_stored' => $date_stored, 'num_lot' => $num_lot, 'check_flag' => $check_flag,
					  'flg' => $flg, 'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $datasession['Auth']['User']['staff_id']],
					 ['id'  => $data['id']]
				 )){

					 //旧DBに単価登録
					 $connection = ConnectionManager::get('sakaeMotoDB');
					 $table = TableRegistry::get('order_material');
					 $table->setConnection($connection);

					 $updater = "UPDATE order_material set date_stored ='".$date_stored."', num_lot ='".$num_lot."',
					  check_flag ='".$check_flag."', flg ='".$flg."', updated_at ='".date('Y-m-d H:i:s')."', updated_staff ='".$datasession['Auth']['User']['staff_id']."'
					 where id ='".$moto_id_order."'";
					 $connection->execute($updater);

					 $connection = ConnectionManager::get('default');//新DBに戻る
					 $table->setConnection($connection);

					$mes = "※更新されました。";
					$this->set('mes',$mes);
					$connection->commit();// コミット5

			 } else {

				 $mes = "※更新されませんでした";
				 $this->set('mes',$mes);
				 $this->Flash->error(__('The date could not be saved. Please, try again.'));
				 throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6

			 }

		 } catch (Exception $e) {//トランザクション7
		 //ロールバック8
			 $connection->rollback();//トランザクション9
		 }//トランザクション10

		 $arrOrderMaterials = $this->OrderMaterials->find()
		 ->where(['flg !=' => 1])->order(["date_stored"=>"ASC"])->toArray();
		 $this->set('arrOrderMaterials',$arrOrderMaterials);

		 $arrGyousya = [
			 '0' => '連絡なし',
			 '1' => '済',
			 '2' => 'メーカー回答待ち',
			 '3' => '納期変更済み'
						 ];
		 $this->set('arrGyousya',$arrGyousya);

		 $arrFlag = [
			 '0' => '-----',
			 '1' => '入荷済'
						 ];
		 $this->set('arrFlag',$arrFlag);

		}

		public function nyuukonouki()
		{
			$OrderMaterials = $this->OrderMaterials->newEntity();
			$this->set('OrderMaterials',$OrderMaterials);

			$session = $this->request->getSession();
			$datasession = $session->read();

			if(!isset($datasession['Auth'])){
				return $this->redirect(['action' => 'menu',
				's' => ['mess' => "セッションが切れました。この画面からやり直してください。"]]);
			}

		}

		public function nyuukonoukiitiran()
		{
			$OrderMaterials = $this->OrderMaterials->newEntity();
			$this->set('OrderMaterials',$OrderMaterials);

			$OrderMaterials = $this->OrderMaterials->newEntity();
			$this->set('OrderMaterials',$OrderMaterials);

			$session = $this->request->getSession();
			$datasession = $session->read();

			if(!isset($datasession['Auth'])){
				return $this->redirect(['action' => 'menu',
				's' => ['mess' => "セッションが切れました。この画面からやり直してください。"]]);
			}

			$data = $this->request->getData();

			$dateYMD = date('Y-m-d');

			if(empty($data['m_grade'])){//col_numで絞込み

				$arrOrderMaterials = $this->OrderMaterials->find()
				->where(['flg !=' => 1, 'color' => $data['col_num']])->order(["date_stored"=>"ASC"])->toArray();
				$this->set('arrOrderMaterials',$arrOrderMaterials);

			}elseif(empty($data['col_num'])){//m_gradeで絞込み

				$arrOrderMaterials = $this->OrderMaterials->find()
				->where(['flg !=' => 1, 'grade' => $data['m_grade']])->order(["date_stored"=>"ASC"])->toArray();
				$this->set('arrOrderMaterials',$arrOrderMaterials);

			}else{//col_num、m_gradeで絞込み

				$arrOrderMaterials = $this->OrderMaterials->find()
				->where(['flg !=' => 1, 'grade' => $data['m_grade'], 'color' => $data['col_num']])->order(["date_stored"=>"ASC"])->toArray();
				$this->set('arrOrderMaterials',$arrOrderMaterials);

			}

			$arrGyousya = [
				'0' => '連絡なし',
				'1' => '済',
				'2' => 'メーカー回答待ち',
				'3' => '納期変更済み'
							];
			$this->set('arrGyousya',$arrGyousya);

			$arrFlag = [
				'0' => '-----',
				'1' => '入荷済'
							];
			$this->set('arrFlag',$arrFlag);

		}

		public function nyuukonoukikousin()
		{
			$OrderMaterials = $this->OrderMaterials->newEntity();
			$this->set('OrderMaterials',$OrderMaterials);

			$session = $this->request->getSession();
			$datasession = $session->read();

			if(!isset($datasession['Auth'])){
				return $this->redirect(['action' => 'menu',
				's' => ['mess' => "セッションが切れました。この画面からやり直してください。"]]);
			}

			$data = $this->request->getData();

			$num = array_keys($data, '更新');
			$num = $num[0];

			$date_stored = $data['date_stored'.$num]['year']."-".$data['date_stored'.$num]['month']."-".$data['date_stored'.$num]['day'];
			$num_lot = $data['num_lot'.$num];
			$check_flag = $data['check_flag'.$num];
			$flg = $data['flg'.$num];
/*
			echo "<pre>";
			print_r($datasession['Auth']['User']['staff_id']);
			echo "</pre>";
*/
			$motoOrderMaterials = $this->OrderMaterials->find()
			->where(['id' => $data['id']])->toArray();
			$moto_id_order = $motoOrderMaterials[0]->id_order;

			$OrderMaterial = $this->OrderMaterials->patchEntity($OrderMaterials, $data);
			$connection = ConnectionManager::get('default');//トランザクション1
			 // トランザクション開始2
			 $connection->begin();//トランザクション3
			 try {//トランザクション4
				 if ($this->OrderMaterials->updateAll(//検査終了時間の更新
					 ['date_stored' => $date_stored, 'num_lot' => $num_lot, 'check_flag' => $check_flag,
					  'flg' => $flg, 'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $datasession['Auth']['User']['staff_id']],
					 ['id'  => $data['id']]
				 )){

					 //旧DBに単価登録
					 $connection = ConnectionManager::get('sakaeMotoDB');
					 $table = TableRegistry::get('order_material');
					 $table->setConnection($connection);

					 $updater = "UPDATE order_material set date_stored ='".$date_stored."', num_lot ='".$num_lot."',
					  check_flag ='".$check_flag."', flg ='".$flg."', updated_at ='".date('Y-m-d H:i:s')."', updated_staff ='".$datasession['Auth']['User']['staff_id']."'
					 where id ='".$moto_id_order."'";
					 $connection->execute($updater);

					 $connection = ConnectionManager::get('default');//新DBに戻る
					 $table->setConnection($connection);

					$mes = "※更新されました。";
					$this->set('mes',$mes);
					$connection->commit();// コミット5

			 } else {

				 $mes = "※更新されませんでした";
				 $this->set('mes',$mes);
				 $this->Flash->error(__('The date could not be saved. Please, try again.'));
				 throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6

			 }

		 } catch (Exception $e) {//トランザクション7
		 //ロールバック8
			 $connection->rollback();//トランザクション9
		 }//トランザクション10

		 $arrOrderMaterials = $this->OrderMaterials->find()
		 ->where(['flg !=' => 1])->order(["date_stored"=>"ASC"])->toArray();
		 $this->set('arrOrderMaterials',$arrOrderMaterials);

		 $arrGyousya = [
			 '0' => '連絡なし',
			 '1' => '済',
			 '2' => 'メーカー回答待ち',
			 '3' => '納期変更済み'
						 ];
		 $this->set('arrGyousya',$arrGyousya);

		 $arrFlag = [
			 '0' => '-----',
			 '1' => '入荷済'
						 ];
		 $this->set('arrFlag',$arrFlag);

		}

		public function csvtest()
		{
			$OrderMaterials = $this->OrderMaterials->newEntity();
			$this->set('OrderMaterials',$OrderMaterials);
		}

		public function csvtest1d()
		{
			$OrderMaterials = $this->OrderMaterials->newEntity();
			$this->set('OrderMaterials',$OrderMaterials);

			$Data=$this->request->query('s');
			if(isset($Data["mess"])){
				$mess = $Data["mess"];
				$this->set('mess',$mess);
			}else{
				$mess = "";
				$this->set('mess',$mess);
			}

		}

		public function csvtest1dsyuturyoku()
		{
			$OrderMaterials = $this->OrderMaterials->newEntity();
			$this->set('OrderMaterials',$OrderMaterials);

			$data = $this->request->getData();
			$date1 = $data['date1d']['year']."-".$data['date1d']['month']."-".$data['date1d']['day'];
			$date1d = $data['date1d']['year']."-".$data['date1d']['month']."-".$data['date1d']['day']." 08:00:00";
			$date1d0 = strtotime($date1d);
			$date1d0 = date('Y-m-d', strtotime('+1 day', $date1d0));
			$date1d0 = $date1d0." 07:59:59";

			$ScheduleKouteis = $this->ScheduleKouteis->find()
			->where(['datetime >=' => $date1d, 'datetime <=' => $date1d0])->toArray();

			if(isset($ScheduleKouteis[0])){

        foreach($ScheduleKouteis as $key => $row ) {
          $tmp_seikeiki[$key] = $row["seikeiki"];
          $tmp_datetime[$key] = $row["datetime"];
        }

				array_multisort($tmp_seikeiki, SORT_ASC, $tmp_datetime, SORT_ASC, $ScheduleKouteis);

				$time = $ScheduleKouteis[0]->datetime->format('H:i');

			}

			$arrScheduleKoutei_csv = array();
			for($k=0; $k<count($ScheduleKouteis); $k++){

				$Product = $this->Products->find()->where(['product_code' => $ScheduleKouteis[$k]["product_code"]])->toArray();
				$product_name = $Product[0]->product_name;

				$arrScheduleKoutei_csv[] = [
					'seikeiki' => $ScheduleKouteis[$k]["seikeiki"]."号機",
					'time' => $ScheduleKouteis[$k]->datetime->format('H:i'),
					'product_code' => $ScheduleKouteis[$k]["product_code"],
					'product_name' => $product_name,
					'tantou' => $ScheduleKouteis[$k]["tantou"]."　"
			 ];

			}

			$this->request->session()->destroy();// セッションの破棄
			session_start();

			for($k=0; $k<count($ScheduleKouteis); $k++){

				$Product = $this->Products->find()->where(['product_code' => $ScheduleKouteis[$k]["product_code"]])->toArray();
				$product_name = $Product[0]->product_name;

				$_SESSION['ScheduleKoutei_csv'][$k] = array(
					'seikeiki' => $ScheduleKouteis[$k]["seikeiki"]."号機",
					'time' => $ScheduleKouteis[$k]->datetime->format('H:i'),
					'product_code' => $ScheduleKouteis[$k]["product_code"],
					'product_name' => $product_name,
					'tantou' => $ScheduleKouteis[$k]["tantou"]."　"
				);

			 }
/*
			echo "<pre>";
			print_r($_SESSION['ScheduleKoutei_csv']);
			echo "</pre>";
*/

			$mes = "「http://192.168.4.246/genryous/csvtest1dApi/api/test.xml」にアクセスしてください。（ここをクリック）";
			$this->set('mes',$mes);
		}

		public function csvtest1dApi()
		{
			//http://localhost:5000/genryous/csvtest1dApi/api/test.xml

			$day = substr(Router::reverse($this->request, false), -14, 10);//urlの取得（use Cake\Routing\Routerが必要）
/*
			echo "<pre>";
			print_r($day);
			echo "</pre>";
*/
			$date1d = $day." 08:00:00";
			$date1d0 = strtotime($date1d);
			$date1d0 = date('Y-m-d', strtotime('+1 day', $date1d0));
			$date1d0 = $date1d0." 07:59:59";

			$ScheduleKouteis = $this->ScheduleKouteis->find()
			->where(['datetime >=' => $date1d, 'datetime <=' => $date1d0])->toArray();

			if(isset($ScheduleKouteis[0])){

        foreach($ScheduleKouteis as $key => $row ) {
          $tmp_seikeiki[$key] = $row["seikeiki"];
          $tmp_datetime[$key] = $row["datetime"];
        }

				array_multisort($tmp_seikeiki, SORT_ASC, $tmp_datetime, SORT_ASC, $ScheduleKouteis);

				$time = $ScheduleKouteis[0]->datetime->format('H:i');

			}

			$arrScheduleKoutei_csv = array();
			for($k=0; $k<count($ScheduleKouteis); $k++){

				$Product = $this->Products->find()->where(['product_code' => $ScheduleKouteis[$k]["product_code"]])->toArray();
	      $product_name = $Product[0]->product_name;

				$arrScheduleKoutei_csv[] = [
					'seikeiki' => $ScheduleKouteis[$k]["seikeiki"]."号機",
					'time' => $ScheduleKouteis[$k]->datetime->format('H:i'),
					'product_code' => $ScheduleKouteis[$k]["product_code"],
					'product_name' => $product_name,
					'tantou' => $ScheduleKouteis[$k]["tantou"]."　"
			 ];

			}

			$this->set([
					'sample_list' => $arrScheduleKoutei_csv,
					'_serialize' => ['sample_list']
			]);

		}

		public function csvtest1w()
		{
			$OrderMaterials = $this->OrderMaterials->newEntity();
			$this->set('OrderMaterials',$OrderMaterials);

			$Data=$this->request->query('s');
			if(isset($Data["mess"])){
				$mess = $Data["mess"];
				$this->set('mess',$mess);
			}else{
				$mess = "";
				$this->set('mess',$mess);
			}

		}

		public function csvtest1wsyuturyoku()
		{
			$OrderMaterials = $this->OrderMaterials->newEntity();
			$this->set('OrderMaterials',$OrderMaterials);

			$data = $this->request->getData();
			$date1 = $data['date1w']['year']."-".$data['date1w']['month']."-".$data['date1w']['day'];
			$date1w = $data['date1w']['year']."-".$data['date1w']['month']."-".$data['date1w']['day']." 08:00:00";
			$date1w0 = strtotime($date1w);
			$date1w0 = date('Y-m-d', strtotime('+7 day', $date1w0));
			$date1w0 = $date1w0." 07:59:59";

			$ScheduleKouteis = $this->ScheduleKouteis->find()
			->where(['datetime >=' => $date1w, 'datetime <=' => $date1w0])->toArray();

			for($k=0; $k<count($ScheduleKouteis); $k++){

				$day = $ScheduleKouteis[$k]->datetime->format('j');
				$ScheduleKouteis[$k]['present_kensahyou'] = $day;

			}

			if(isset($ScheduleKouteis[0])){

				foreach($ScheduleKouteis as $key => $row ) {
					$tmp_day[$key] = $row["present_kensahyou"];
					$tmp_seikeiki[$key] = $row["seikeiki"];
  //        $tmp_datetime[$key] = $row["datetime"];
        }

				array_multisort($tmp_day, SORT_ASC, $tmp_seikeiki, SORT_ASC, $ScheduleKouteis);
	//			array_multisort($tmp_day, SORT_ASC, $tmp_seikeiki, SORT_ASC, $tmp_datetime, SORT_ASC, $ScheduleKouteis);

				$time = $ScheduleKouteis[0]->datetime->format('H:i');

			}

			$arrScheduleKoutei_csv = array();
			for($k=0; $k<count($ScheduleKouteis); $k++){

				$Product = $this->Products->find()->where(['product_code' => $ScheduleKouteis[$k]["product_code"]])->toArray();
				$product_name = $Product[0]->product_name;

				$arrScheduleKoutei_csv[] = [
					'day' => $ScheduleKouteis[$k]->datetime->format('j'),//0なしの日付
					'seikeiki' => $ScheduleKouteis[$k]["seikeiki"]."号機",
					'time' => $ScheduleKouteis[$k]->datetime->format('H:i'),
					'product_code' => $ScheduleKouteis[$k]["product_code"],
					'product_name' => $product_name,
					'tantou' => $ScheduleKouteis[$k]["tantou"]."　"
			 ];

			}

			$this->request->session()->destroy();// セッションの破棄
			session_start();

			for($k=0; $k<count($ScheduleKouteis); $k++){

				$Product = $this->Products->find()->where(['product_code' => $ScheduleKouteis[$k]["product_code"]])->toArray();
				$product_name = $Product[0]->product_name;

				$_SESSION['ScheduleKoutei_csv'][$k] = array(
					'day' => $ScheduleKouteis[$k]->datetime->format('j'),//0なしの日付
					'seikeiki' => $ScheduleKouteis[$k]["seikeiki"]."号機",
					'time' => $ScheduleKouteis[$k]->datetime->format('H:i'),
					'product_code' => $ScheduleKouteis[$k]["product_code"],
					'product_name' => $product_name,
					'tantou' => $ScheduleKouteis[$k]["tantou"]."　"
				);

			 }

			 $mes = "「http://192.168.4.246/genryous/csvtest1wApi/api/test.xml」にアクセスしてください。（ここをクリック）";
			 $this->set('mes',$mes);

		}

		public function csvtest1wApi()
		{
			//http://localhost:5000/genryous/csvtest1dApi/api/test.xml
/*
			$session = $this->request->getSession();
			$data = $session->read();

			if(!isset($data["ScheduleKoutei_csv"])){
				return $this->redirect(['action' => 'csvtest1w',
				's' => ['mess' => "セッションが切れました。この画面からやり直してください。"]]);
			}

			$this->set([
					'sample_list' => $data['ScheduleKoutei_csv'],
					'_serialize' => ['sample_list']
			]);
*/
			$day = substr(Router::reverse($this->request, false), -14, 10);//urlの取得（use Cake\Routing\Routerが必要）

			$date1w = $day." 08:00:00";
			$date1w0 = strtotime($date1w);
			$date1w0 = date('Y-m-d', strtotime('+7 day', $date1w0));
			$date1w0 = $date1w0." 07:59:59";

			$ScheduleKouteis = $this->ScheduleKouteis->find()
			->where(['datetime >=' => $date1w, 'datetime <=' => $date1w0])->toArray();

			for($k=0; $k<count($ScheduleKouteis); $k++){

				$day = $ScheduleKouteis[$k]->datetime->format('Y-m-j');
				$ScheduleKouteis[$k]['present_kensahyou'] = $day;

			}

			if(isset($ScheduleKouteis[0])){

        foreach($ScheduleKouteis as $key => $row ) {
					$tmp_day[$key] = $row["present_kensahyou"];
					$tmp_seikeiki[$key] = $row["seikeiki"];
  //        $tmp_datetime[$key] = $row["datetime"];
        }

				array_multisort($tmp_day, SORT_ASC, $tmp_seikeiki, SORT_ASC, $ScheduleKouteis);
	//			array_multisort($tmp_day, SORT_ASC, $tmp_seikeiki, SORT_ASC, $tmp_datetime, SORT_ASC, $ScheduleKouteis);

				$time = $ScheduleKouteis[0]->datetime->format('H:i');

			}

			$arrScheduleKoutei_csv = array();
			for($k=0; $k<count($ScheduleKouteis); $k++){

				$Product = $this->Products->find()->where(['product_code' => $ScheduleKouteis[$k]["product_code"]])->toArray();
				$product_name = $Product[0]->product_name;

				$arrScheduleKoutei_csv[] = [
					'day' => $ScheduleKouteis[$k]->datetime->format('j'),//0なしの日付
					'seikeiki' => $ScheduleKouteis[$k]["seikeiki"]."号機",
					'time' => $ScheduleKouteis[$k]->datetime->format('H:i'),
					'product_code' => $ScheduleKouteis[$k]["product_code"],
					'product_name' => $product_name,
					'tantou' => $ScheduleKouteis[$k]["tantou"]."　"
			 ];

			}

			$this->set([
					'sample_list' => $arrScheduleKoutei_csv,
					'_serialize' => ['sample_list']
			]);

		}

		public function gazoutest()
		{
			$OrderMaterials = $this->OrderMaterials->newEntity();
			$this->set('OrderMaterials',$OrderMaterials);
		}

		public function gazouhyoujitest()
		{
			$OrderMaterials = $this->OrderMaterials->newEntity();
			$this->set('OrderMaterials',$OrderMaterials);

			if ($this->request->is('post')) {

				$fileName =$_FILES['upfile']['tmp_name'];

				if($_FILES['upfile']['size']>0)
				{
					if($_FILES['upfile']['size']>1000000){
							echo '画像サイズが大き過ぎます';
						}else{
							move_uploaded_file($_FILES['upfile']["tmp_name"],"img/gazoutest/".$_FILES['upfile']["name"]);//ローカル
	//						move_uploaded_file($fileName['tmp_name'],"/home/centosuser/".$_FILES['upfile']["name"]);//192
						}
					}

			}
/*
			echo "<pre>";
			print_r($_FILES['upfile']["name"]);
			echo "</pre>";
*/
			$gif1 = "gazoutest/".$_FILES['upfile']["name"];//ローカル
			$this->set('gif1',$gif1);

		}


	}
