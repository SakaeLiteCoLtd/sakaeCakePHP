<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

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

		public function nyuukomenu()
    {

    }

		public function nyuukotyouka()
		{

		}

		public function nyuukominyuuka()
		{

		}

		public function nyuukonouki()
		{

		}

	}
