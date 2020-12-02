<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

use Cake\Routing\Router;//urlの取得

class ApisController extends AppController
	{

		public function initialize()
		{
		 parent::initialize();
		 $this->ScheduleKouteis = TableRegistry::get('scheduleKouteis');
		 $this->Products = TableRegistry::get('products');
		}

		public function xmlday()
		{
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

		public function xmlweek()
		{
			$day = substr(Router::reverse($this->request, false), -14, 10);//urlの取得（use Cake\Routing\Routerが必要）

			$date1w = $day." 08:00:00";
			$date1w0 = strtotime($date1w);
			$date1w0 = date('Y-m-d', strtotime('+7 day', $date1w0));
			$date1w0 = $date1w0." 07:59:59";

			$ScheduleKouteis = $this->ScheduleKouteis->find()
			->where(['datetime >=' => $date1w, 'datetime <=' => $date1w0])->order(["datetime"=>"ASC"])->toArray();

			for($k=0; $k<count($ScheduleKouteis); $k++){

				$day = $ScheduleKouteis[$k]->datetime->format('Y-m-j');
				$ScheduleKouteis[$k]['present_kensahyou'] = $day;

			}

			if(isset($ScheduleKouteis[0])){

        foreach($ScheduleKouteis as $key => $row ) {
					$tmp_day[$key] = $row["present_kensahyou"];
					$tmp_seikeiki[$key] = $row["seikeiki"];
        }

				array_multisort(array_map( "strtotime", $tmp_day ), SORT_ASC, $tmp_seikeiki, SORT_ASC, $ScheduleKouteis);
		//		array_multisort($tmp_seikeiki, SORT_ASC, $ScheduleKouteis);

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

	}
