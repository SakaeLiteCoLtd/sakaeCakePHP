<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション
use Cake\Auth\DefaultPasswordHasher;//

class ZzzcsvtorikomisController extends AppController
{

     public function initialize()
     {
			parent::initialize();
			$this->Products = TableRegistry::get('products');
     }

		 public function torikomi()//http://localhost:5000/Zzzcsvtorikomis/torikomi
     {

			 $fp = fopen("hazai/productsMaterial_Fin210720.csv", "r");//csvファイルはwebrootに入れる
			 $fpcount = fopen("hazai/productsMaterial_Fin210720.csv", 'r' );
			 for( $count = 0; fgets( $fpcount ); $count++ );
			 $this->set('count',$count);

			 $arrFp = array();//空の配列を作る
			 $arrFpok = array();//空の配列を作る
			 $arrFpng = array();//空の配列を作る
			 $line = fgets($fp);//ファイル$fpの上の１行を取る（１行目はカラム名）
			 for ($k=1; $k<=$count-1; $k++) {//行数分
			 	$line = fgets($fp);//ファイル$fpの上の１行を取る（２行目から）
			 	$sample = explode(',',$line);//$lineを","毎に配列に入れる

			 	$keys=array_keys($sample);
			 	$keys[array_search('0',$keys)]='﻿product_code';//名前の変更
			 	$keys[array_search('1',$keys)]='product_name';
			 	$keys[array_search('2',$keys)]='m_grade';
			 	$keys[array_search('3',$keys)]='col_num';
			 	$keys[array_search('4',$keys)]='delete';
			 	$sample = array_combine($keys, $sample);

			 	unset($sample['delete']);

				$arrFp[] = $sample;//配列に追加する

			 }

			 for($j=0; $j<count($arrFp); $j++){

				 $Products = $this->Products->find()->where(['product_code' => $arrFp[$j]['﻿product_code']])->toArray();

				 if(isset($Products[0])){

					 $arrFpok[] = $arrFp[$j];
/*
					 $this->Products->updateAll(
					 ['m_grade' => $arrFp[$j]['m_grade'], 'col_num' => $arrFp[$j]['col_num'],
					 'updated_staff' => 0, 'updated_at' => date('Y-m-d H:i:s')],
					 ['product_code'   => $arrFp[$j]['﻿product_code']]
					 );
*/
         }else{

					 $arrFpng[] = $arrFp[$j];

         }

       }

			 echo "<pre>";
			 print_r($arrFpng);
			 echo "</pre>";

     }

}
