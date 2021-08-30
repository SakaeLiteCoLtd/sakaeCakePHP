<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション
use Cake\Auth\DefaultPasswordHasher;//

use App\myClass\hazaiploglam\htmlhazaicheck;
use App\myClass\Logins\htmlLogin;

use Cake\Routing\Router;//urlの取得
use Cake\Http\Client;//httpの読取に必要

use App\myClass\Rolecheck\htmlRolecheck;

class HazaishiyousController extends AppController {

  public function initialize()
  {
   parent::initialize();
   $this->loadComponent('RequestHandler');
   $this->Staffs = TableRegistry::get('staffs');
   $this->Users = TableRegistry::get('users');
   $this->Products = TableRegistry::get('products');
   $this->PriceMaterials = TableRegistry::get('priceMaterials');
   $this->Materials = TableRegistry::get('materials');
   $this->StockEndMaterials = TableRegistry::get('stockEndMaterials');
   $this->ScheduleKouteis = TableRegistry::get('scheduleKouteis');
  }

  public function menu()
  {
    $stockEndMaterials = $this->StockEndMaterials->newEntity();
    $this->set('stockEndMaterials',$stockEndMaterials);
  }

  public function shiyoukensaku()
  {
    $stockEndMaterials = $this->StockEndMaterials->newEntity();
    $this->set('stockEndMaterials',$stockEndMaterials);
  }

  public function shiyouichiran()
  {
    $stockEndMaterials = $this->StockEndMaterials->newEntity();
    $this->set('stockEndMaterials',$stockEndMaterials);

    $data = $this->request->getData();//postデータを$dataに

    $dateYMD = $data['manu_date']['year']."-".$data['manu_date']['month']."-".$data['manu_date']['day'];
    $this->set('dateYMD',$dateYMD);
    $dateYMD1 = strtotime($dateYMD);
    $dayto = date('Y-m-d', strtotime('+1 day', $dateYMD1));
    $dateYMDto = $dayto;
    $dateHI = date("08:00");
    $dateto = $dateYMDto."T".$dateHI;
    $dateye = $dateYMD."T".$dateHI;

    $daytomo = date('Y-m-d', strtotime('+1 day', $dateYMD1));
    $dateYMDs = mb_substr($dateYMD, 0, 10);
    $dateYMDf = mb_substr($daytomo, 0, 10);

    $scheduleKoutei = $this->ScheduleKouteis->find()
    ->where(['datetime >=' => $dateYMDs, 'datetime <=' => $dateYMDf, 'delete_flag' => 0])->toArray();

    if(count($scheduleKoutei) > 0){
     $seikeiki_array = array();
     $datetime_array = array();
     foreach($scheduleKoutei as $key => $row) {
       $seikeiki_array[$key] = $row["seikeiki"];
       $datetime_array[$key] = $row["datetime"];
     }
     array_multisort($seikeiki_array, SORT_ASC, array_map("strtotime", $datetime_array), SORT_ASC, $scheduleKoutei);
   }

    $arrShiyouhazai = array();

    for($k=0; $k<count($scheduleKoutei); $k++){

      $numarr = count($arrShiyouhazai);

      $arrShiyouhazai[] = [
        'seikeiki' => $scheduleKoutei[$k]["seikeiki"],
        'datetime' => $scheduleKoutei[$k]["datetime"]->format('Y-m-d H:i:s'),
        'product_code' => $scheduleKoutei[$k]["product_code"],
        'product_name' => "",
        'grade_color' => "",
        'lot_num' => "",
        'status_material' => "",
        'amount' => "",
        'num' => 1,
      ];

      $Products = $this->Products->find()
      ->where(['product_code' => $scheduleKoutei[$k]["product_code"], 'delete_flag' => 0])->toArray();

      ${"grade".$k} = "";
      ${"color".$k} = "";
      if(isset($Products[0])){

        ${"grade".$k} = $Products[0]["m_grade"];
        ${"color".$k} = $Products[0]["col_num"];

        $arrShiyouhazai[$numarr]['product_name'] = $Products[0]["product_name"];
        $arrShiyouhazai[$numarr]['grade_color'] = ${"grade".$k}."_".${"color".$k};

      }

      $PriceMaterials = $this->PriceMaterials->find()
      ->where(['grade' => ${"grade".$k}, 'color' => ${"color".$k}, 'delete_flag' => 0])->toArray();

      if(isset($PriceMaterials[0])){

        $StockEndMaterials = $this->StockEndMaterials->find()
        ->where(['price_material_id' => $PriceMaterials[0]["id"], 'product_code' => $scheduleKoutei[$k]["product_code"], 'shiped_staff IS' => NULL, 'delete_flag' => 0])->toArray();
        if(!isset($StockEndMaterials[0])){
          $StockEndMaterials = $this->StockEndMaterials->find()
          ->where(['price_material_id' => $PriceMaterials[0]["id"], 'shiped_staff IS' => NULL, 'delete_flag' => 0])->toArray();
        }

        if(!isset($StockEndMaterials[0])){
          $arrShiyouhazai[$numarr]['grade_color'] = "未使用ロットなし";
        }

        for($j=0; $j<count($StockEndMaterials); $j++){

          if($StockEndMaterials[$j]["status_material"] == 0){
            $status_material = "バージン";
          }elseif($StockEndMaterials[$j]["status_material"] == 1){
            $status_material = "粉砕";
          }else{
            $status_material = "バージン＋粉砕";
          }

          if($j == 0){

            $arrShiyouhazai[$numarr]['lot_num'] = $StockEndMaterials[$j]["lot_num"];
            $arrShiyouhazai[$numarr]['status_material'] = $status_material;
            $arrShiyouhazai[$numarr]['amount'] = $StockEndMaterials[$j]["amount"];
            $arrShiyouhazai[$numarr]['num'] = count($StockEndMaterials);

          }else{

            $arrShiyouhazai[] = [
              'seikeiki' => $scheduleKoutei[$k]["seikeiki"],
              'datetime' => $scheduleKoutei[$k]["datetime"]->format('Y-m-d H:i:s'),
              'product_code' => $scheduleKoutei[$k]["product_code"],
              'product_name' => $Products[0]["product_name"],
              'grade_color' => ${"grade".$k}."_".${"color".$k},
              'lot_num' => $StockEndMaterials[$j]["lot_num"],
              'status_material' => $status_material,
              'amount' => $StockEndMaterials[$j]["amount"],
              'num' => count($StockEndMaterials),
            ];

          }

        }

      }else{

        $arrShiyouhazai[$numarr]['grade_color'] = "未使用ロットなし";

      }

    }
/*
    echo "<pre>";
    print_r($arrShiyouhazai);
    echo "</pre>";
    */
    $this->set('arrShiyouhazai',$arrShiyouhazai);

/*
    if(!isset($_SESSION)){
      session_start();
      header('Expires:-1');
      header('Cache-Control:');
      header('Pragma:');
    }
*/
  }

}
