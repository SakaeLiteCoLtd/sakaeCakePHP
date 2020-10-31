<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション
use App\myClass\Logins\htmlLogin;//myClassフォルダに配置したクラスを使用

class GenryousController extends AppController
	{

		public function initialize()
		{
		 parent::initialize();
		 $this->OrderMaterials = TableRegistry::get('orderMaterials');
		}

		public function menu()
    {

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

    }

		public function nyuukotyouka()
		{
			$OrderMaterials = $this->OrderMaterials->newEntity();
	    $this->set('OrderMaterials',$OrderMaterials);

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
					 $connection = ConnectionManager::get('DB_ikou_test');
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
					 $connection = ConnectionManager::get('DB_ikou_test');
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
		}

		public function nyuukonoukiitiran()
		{
			$OrderMaterials = $this->OrderMaterials->newEntity();
			$this->set('OrderMaterials',$OrderMaterials);

			$OrderMaterials = $this->OrderMaterials->newEntity();
			$this->set('OrderMaterials',$OrderMaterials);

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
					 $connection = ConnectionManager::get('DB_ikou_test');
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
		}

		public function csvtest1w()
		{
			$OrderMaterials = $this->OrderMaterials->newEntity();
			$this->set('OrderMaterials',$OrderMaterials);
		}

	}
