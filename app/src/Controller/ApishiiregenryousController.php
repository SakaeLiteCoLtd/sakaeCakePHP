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

class ApishiiregenryousController extends AppController
	{

		public function initialize()
		{
		 parent::initialize();
		 $this->OrderMaterials = TableRegistry::get('orderMaterials');
		 $this->PriceMaterials = TableRegistry::get('priceMaterials');
		 $this->Sppliers = TableRegistry::get('suppliers');
		 $this->AccountMaterialKaikakes = TableRegistry::get('accountMaterialKaikakes');
		 $this->AccountKaikakeElements = TableRegistry::get('accountKaikakeElements');
		}

													     //http://192.168.4.246/Apishiiregenryous/yobidashi/api/2021-7-1_2021-7-31.xml
		public function yobidashi()//http://localhost:5000/Apishiiregenryous/yobidashi/api/2021-7-1_2021-7-31.xml
		{
			$data = Router::reverse($this->request, false);//文字化けする後で2回変換すると日本語OK
			$data = urldecode($data);

			$urlarr = explode("/",$data);//切り離し
			$dataarr = explode("_",$urlarr[4]);//切り離し

			$daysta = $dataarr[0];//日付の取得
			$dayfinarr = explode(".",$dataarr[1]);//切り離し
			$dayfin = $dayfinarr[0];//日付の取得

			$arrLoadShiire = array();
			$arrLoadAccountElementsKaikake = array();

			//ここから$arrLoadShiire
			$OrderMaterials = $this->OrderMaterials->find()
			->where(['real_date_st >=' => $daysta, 'real_date_st <=' => $dayfin, 'delete_flag' => 0])
			->toArray();

			if(count($OrderMaterials) > 0){

 			 $real_date_st_array = array();
			 $grade_array = array();
			 $color_array = array();
 	     foreach($OrderMaterials as $key => $row) {
 	       $real_date_st_array[$key] = $row["real_date_st"];
				 $grade_array[$key] = $row["grade"];
				 $color_array[$key] = $row["color"];
 	     }

 			 array_multisort(array_map("strtotime", $real_date_st_array), SORT_ASC,
			  $grade_array, SORT_ASC, $color_array, SORT_ASC, $OrderMaterials);

		 }
/*
		 $arrPriceMaterials = array();
		 $PriceMaterials = $this->PriceMaterials->find()->where(['delete_flag' => 0])->toArray();
		 for($k=0; $k<count($PriceMaterials); $k++){
			 $arrPriceMaterials[] = [
				 "sup_id" => $PriceMaterials[$k]["id"],
				 "grade_color" => $PriceMaterials[$k]["grade"]."_".$PriceMaterials[$k]["color"],
			 ];
		 }
*/
			$arrSppliers = array();
			$Sppliers = $this->Sppliers->find()->where(['delete_flag' => 0])->toArray();
			for($k=0; $k<count($Sppliers); $k++){
				$arrSppliers[] = [
					"id" => $Sppliers[$k]["id"],
					"name" => $Sppliers[$k]["name"]
				];
			}

		 $arrOrderMaterials = array();
		 for($k=0; $k<count($OrderMaterials); $k++){

			$keyIndex = array_search($OrderMaterials[$k]["sup_id"], array_column($arrSppliers, 'id'));//配列の検索
			$name = $arrSppliers[$keyIndex]["name"];

			$arrOrderMaterials[] = [
				'name' => $name,
				'real_date_st' => $OrderMaterials[$k]->real_date_st->format('Y-m-d'),
				'id_order' => $OrderMaterials[$k]["id_order"],
				'grade' => $OrderMaterials[$k]["grade"],
				'color' => $OrderMaterials[$k]["color"],
				'grade_color' => $OrderMaterials[$k]["grade"]." ".$OrderMaterials[$k]["color"],
				'amount' => $OrderMaterials[$k]["amount"],
				'price' => $OrderMaterials[$k]["price"],
				'sup_id' => $OrderMaterials[$k]["sup_id"],
		 ];

		 }

		 $arrLoadShiire = $arrOrderMaterials;//$arrLoadShiire完成

		 //ここからarrLoadAccountElementsKaikake
		 $AccountMaterialKaikakes = $this->AccountMaterialKaikakes->find()
		 ->where(['date >=' => $daysta, 'date <=' => $dayfin, 'delete_flag' => 0])
		 ->toArray();

		 if(count($AccountMaterialKaikakes) > 0){

			$date_array = array();
			$sup_id_array = array();
			foreach($AccountMaterialKaikakes as $key => $row) {
				$date_array[$key] = $row["date"];
				$sup_id_array[$key] = $row["sup_id"];
			}

			array_multisort(array_map("strtotime", $date_array), SORT_ASC, $sup_id_array, SORT_ASC, $AccountMaterialKaikakes);

		}

		 $arrSppliers = array();
		 $Sppliers = $this->Sppliers->find()->where(['delete_flag' => 0])->toArray();
		 for($k=0; $k<count($Sppliers); $k++){
			 $arrSppliers[] = [
				 "id" => $Sppliers[$k]["id"],
				 "name" => $Sppliers[$k]["name"]
			 ];
		 }

		 $arrAccountKaikakeElements = array();
		 $AccountKaikakeElements = $this->AccountKaikakeElements->find()->where(['delete_flag' => 0])->toArray();
		 for($k=0; $k<count($AccountKaikakeElements); $k++){
			 $arrAccountKaikakeElements[] = [
				 "id" => $AccountKaikakeElements[$k]["id"],
				 "element" => $AccountKaikakeElements[$k]["element"]
			 ];
		 }

		 $arrAccountMaterialKaikakes = array();
		 for($k=0; $k<count($AccountMaterialKaikakes); $k++){

			$keyIndex = array_search($AccountMaterialKaikakes[$k]["sup_id"], array_column($arrSppliers, 'id'));//配列の検索
			$name = $arrSppliers[$keyIndex]["name"];

			$keyIndex = array_search($AccountMaterialKaikakes[$k]["kaikake_element_id"], array_column($arrAccountKaikakeElements, 'id'));//配列の検索
			$element = $arrAccountKaikakeElements[$keyIndex]["element"];

			if($AccountMaterialKaikakes[$k]["kaikake_element_id"] == 1){//前月繰越は1日マイナスする

				$datemoto = strtotime($AccountMaterialKaikakes[$k]->date->format('Y-m-d'));
				$date = date('Y-m-d', strtotime('-1 day', $datemoto));

			}else{

				$date = $AccountMaterialKaikakes[$k]->date->format('Y-m-d');

			}

			if($AccountMaterialKaikakes[$k]["kaikake_element_id"] == 1 || $AccountMaterialKaikakes[$k]["kaikake_element_id"] == 3){//kaikake_element_id=1,3以外の時は金額をマイナスにする

				$kingaku = $AccountMaterialKaikakes[$k]["kingaku"];

			}else{

				$kingaku = $AccountMaterialKaikakes[$k]["kingaku"] * -1;

			}

			$arrAccountMaterialKaikakes[] = [
				'sup_id' => $AccountMaterialKaikakes[$k]["sup_id"],
				'name' => $name,
				'kingaku' => $kingaku,
				'date' => $date,
				'kaikake_element_id' => $AccountMaterialKaikakes[$k]["kaikake_element_id"],
				'element' => $element,
				'num_order' => 0,
		 ];

		 }

		 $arrLoadAccountElementsKaikake = $arrAccountMaterialKaikakes;//$arrLoadAccountElementsKaikake完成
/*
		 echo "<pre>";
		 print_r($arrLoadAccountElementsKaikake);
		 echo "</pre>";
*/
			$this->set([
				'LoadShiire' => $arrLoadShiire,
				'LoadAccountElementsKaikake' => $arrLoadAccountElementsKaikake,
				'_serialize' => ['LoadShiire','LoadAccountElementsKaikake']
			]);
		}

	}
