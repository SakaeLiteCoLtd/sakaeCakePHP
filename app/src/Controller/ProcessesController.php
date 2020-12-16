<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション
use App\myClass\Logins\htmlLogin;//myClassフォルダに配置したクラスを使用

class ProcessesController extends AppController
	{

		public function initialize()
		{
		 parent::initialize();
		 $this->ScheduleKouteis = TableRegistry::get('scheduleKouteis');
		 $this->Products = TableRegistry::get('products');
		}

		public function loginform()//社員IDの登録
    {

    }

		public function login()//ログイン
    {

    }

		public function menu()//初期メニュー画面
    {

			$checkMobile = 0;
			if ($this->request->is('mobile')) {
			    if ($this->request->is('tablet')) {
						$this->viewBuilder()->theme('Sp');
			//			echo "<pre>";
			//			print_r("タブレットです");
			//			echo "</pre>";
			    } else {
						$this->viewBuilder()->theme('Sp');
			//			echo "<pre>";
			//			print_r("タブレットじゃないモバイルです");
			//			echo "</pre>";
			    }
			} else {
	//			echo "<pre>";
	//			print_r("PCです");
	//			echo "</pre>";
				$checkMobile = 1;
			}
			$this->set('checkMobile',$checkMobile);

    }

		public function menukatagae()//型替えのメニュー画面
    {

    }

		public function katagaeitiran()//当日の型替え一覧
    {
			$scheduleKouteis = $this->ScheduleKouteis->newEntity();
			$this->set('scheduleKouteis',$scheduleKouteis);

			$Data=$this->request->query();

			if(isset($Data["kousin"])){//更新ボタンを押した場合
/*
				echo "<pre>";
				print_r($Data);
				echo "</pre>";
*/
			}elseif(isset($this->request->getData()["keisoku"])){

				$data = $this->request->getData();
				$data = array_keys($data, '計測');

				$arrdate = explode("_",$data[0]);//切り離し

				return $this->redirect(['action' => 'katagaekeisoku',
				's' => ['returndata' => $arrdate[1]]]);

			}

				$today = date('Y-m-d');
				$today08 = $today." 08:00:00";
				$today = strtotime($today);
				$tomoday = date('Y-m-d', strtotime('+1 day', $today));
				$tomoday07 = $tomoday." 07:59:59";

				//旧DB参照
				$connection = ConnectionManager::get('DB_ikou_test');
				$table = TableRegistry::get('scheduleKoutei');
				$table->setConnection($connection);

				$sql = "SELECT datetime,seikeiki,product_id,present_kensahyou,product_name,tantou FROM schedule_koutei".
							" where datetime >= '".$today08."' and datetime <= '".$tomoday07."' order by datetime asc";
				$connection = ConnectionManager::get('DB_ikou_test');
				$scheduleKoutei = $connection->execute($sql)->fetchAll('assoc');

				$connection = ConnectionManager::get('default');
				$table->setConnection($connection);

				$arrTouroku = array();
	      for($i=0; $i<count($scheduleKoutei); $i++){//新DBにデータが存在しなければ新DBに保存するための配列に追加する

	        $ScheduleKouteiData = $this->ScheduleKouteis->find()->where(['datetime' => $scheduleKoutei[$i]["datetime"], 'seikeiki' => $scheduleKoutei[$i]["seikeiki"]])->toArray();

	        if(!isset($ScheduleKouteiData[0])){

	          $arrTouroku[] = [
	            'datetime' => $scheduleKoutei[$i]["datetime"],
	            'seikeiki' => $scheduleKoutei[$i]["seikeiki"],
	            'product_code' => $scheduleKoutei[$i]["product_id"],
	            'present_kensahyou' => $scheduleKoutei[$i]["present_kensahyou"],
	            'product_name' => $scheduleKoutei[$i]["product_name"],
	            'tantou' => $scheduleKoutei[$i]["tantou"]
	          ];

	        }

			}
/*
			echo "<pre>";
			print_r($arrTouroku);
			echo "</pre>";
*/
			if(isset($arrTouroku[0])){//登録するデータがある場合は一括登録

        $ScheduleKouteis = $this->ScheduleKouteis->patchEntities($this->ScheduleKouteis->newEntity(), $arrTouroku);
        $connection = ConnectionManager::get('default');//トランザクション1
        // トランザクション開始2
        $connection->begin();//トランザクション3
        try {//トランザクション4
          if ($this->ScheduleKouteis->saveMany($ScheduleKouteis)){
            $connection->commit();// コミット5
          } else {
            throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
          }
        } catch (Exception $e) {//トランザクション7
        //ロールバック8
          $connection->rollback();//トランザクション9
        }//トランザクション10
      }

			$arrScheduleKouteis = $this->ScheduleKouteis->find()
			->where(['datetime >' => $today08, 'datetime <=' => $tomoday07])->order(["seikeiki"=>"ASC"])->toArray();
			$this->set('arrScheduleKouteis',$arrScheduleKouteis);

    }

		public function katagaekeisoku()//計測
    {

			$Data=$this->request->query();
			$scheduleId = $Data["s"]["returndata"];

			echo "<pre>";
			print_r($scheduleId);
			echo "</pre>";

    }

	}
