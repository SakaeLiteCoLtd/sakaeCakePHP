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
   $this->KadouSeikeis = TableRegistry::get('kadouSeikeis');
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

    if(strtotime($dateYMD) < strtotime(date('Y-m-d'))){//過去の日付（KadouSeikeis参照）

      $datecheck = 0;
      $this->set('datecheck',$datecheck);

      $KadouSeikeis = $this->KadouSeikeis->find()
      ->where(['starting_tm >=' => $dateYMDs, 'starting_tm <=' => $dateYMDf])->toArray();

      if(count($KadouSeikeis) > 0){
       $seikeiki_array = array();
       $starting_tm_array = array();
       foreach($KadouSeikeis as $key => $row) {
         $seikeiki_array[$key] = $row["seikeiki"];
         $starting_tm_array[$key] = $row["starting_tm"];
       }
       array_multisort($seikeiki_array, SORT_ASC, array_map("strtotime", $starting_tm_array), SORT_ASC, $KadouSeikeis);
     }

     $arrShiyouhazai = array();

     for($k=0; $k<count($KadouSeikeis); $k++){

       $numarr = count($arrShiyouhazai);

       $arrShiyouhazai[] = [
         'seikeiki' => $KadouSeikeis[$k]["seikeiki"],
         'datetime' => $KadouSeikeis[$k]["starting_tm"]->format('Y-m-d H:i:s'),
         'product_code' => $KadouSeikeis[$k]["product_code"],
         'product_name' => "",
         'grade_color' => "",
         'lot_num' => "",
         'status_material' => "",
         'amount' => "",
         'num' => 1,
         'usedcheck' => "",
       ];

       $Products = $this->Products->find()
       ->where(['product_code' => $KadouSeikeis[$k]["product_code"], 'delete_flag' => 0])->toArray();

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

         $StockEndMaterialused = $this->StockEndMaterials->find()//使用の場合
         ->where(['price_material_id' => $PriceMaterials[0]["id"], 'shiped_at >=' => $dateYMDs, 'shiped_at <=' => $dateYMDf, 'delete_flag' => 0])->toArray();

         $countcheck = 0;

         for($j=0; $j<count($StockEndMaterialused); $j++){

           if($StockEndMaterialused[$j]["status_material"] == 0){
             $status_material = "バージン";
           }elseif($StockEndMaterialused[$j]["status_material"] == 1){
             $status_material = "粉砕";
           }else{
             $status_material = "バージン＋粉砕";
           }

           if($j == 0){

             $countcheck = 1;

             $arrShiyouhazai[$numarr]['lot_num'] = $StockEndMaterialused[$j]["lot_num"];
             $arrShiyouhazai[$numarr]['status_material'] = $status_material;
             $arrShiyouhazai[$numarr]['amount'] = $StockEndMaterialused[$j]["amount"];
             $arrShiyouhazai[$numarr]['usedcheck'] = "使用";

           }else{

             $arrShiyouhazai[] = [
               'seikeiki' => $KadouSeikeis[$k]["seikeiki"],
               'datetime' => $KadouSeikeis[$k]["starting_tm"]->format('Y-m-d H:i:s'),
               'product_code' => $KadouSeikeis[$k]["product_code"],
               'product_name' => $Products[0]["product_name"],
               'grade_color' => ${"grade".$k}."_".${"color".$k},
               'lot_num' => $StockEndMaterialused[$j]["lot_num"],
               'status_material' => $status_material,
               'amount' => $StockEndMaterialused[$j]["amount"],
               'num' => 1,
               'usedcheck' => "使用",
             ];

           }

         }

         $StockEndMaterialnuused = $this->StockEndMaterials->find()//未使用の場合
         ->where(['price_material_id' => $PriceMaterials[0]["id"], 'import_tab_at <=' => $dateYMDs, 'delete_flag' => 0,
         'OR' => [['shiped_at >' => $dateYMDf], ['shiped_at IS' => NULL]]])->toArray();

         for($j=0; $j<count($StockEndMaterialnuused); $j++){

           if($StockEndMaterialnuused[$j]["status_material"] == 0){
             $status_material = "バージン";
           }elseif($StockEndMaterialnuused[$j]["status_material"] == 1){
             $status_material = "粉砕";
           }else{
             $status_material = "バージン＋粉砕";
           }

           if($countcheck == 0 && $j == 0){

             $arrShiyouhazai[$numarr]['lot_num'] = $StockEndMaterialnuused[$j]["lot_num"];
             $arrShiyouhazai[$numarr]['status_material'] = $status_material;
             $arrShiyouhazai[$numarr]['amount'] = $StockEndMaterialnuused[$j]["amount"];
             $arrShiyouhazai[$numarr]['usedcheck'] = "未使用";

           }else{

             $arrShiyouhazai[] = [
               'seikeiki' => $KadouSeikeis[$k]["seikeiki"],
               'datetime' => $KadouSeikeis[$k]["starting_tm"]->format('Y-m-d H:i:s'),
               'product_code' => $KadouSeikeis[$k]["product_code"],
               'product_name' => $Products[0]["product_name"],
               'grade_color' => ${"grade".$k}."_".${"color".$k},
               'lot_num' => $StockEndMaterialnuused[$j]["lot_num"],
               'status_material' => $status_material,
               'amount' => $StockEndMaterialnuused[$j]["amount"],
               'num' => 1,
               'usedcheck' => "未使用",
             ];

           }

         }

         if(!isset($StockEndMaterialused[0]) && !isset($StockEndMaterialnuused[0])){
           $arrShiyouhazai[$numarr]['grade_color'] = "未使用ロットなし";
         }

       }else{

         $arrShiyouhazai[$numarr]['grade_color'] = "未使用ロットなし";

       }

     }

    }else{//当日以降（ScheduleKouteis参照）

      $datecheck = 1;
      $this->set('datecheck',$datecheck);

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
          ->where(['price_material_id' => $PriceMaterials[0]["id"], 'shiped_staff IS' => NULL, 'delete_flag' => 0])->toArray();

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

    }
/*
    echo "<pre>";
    print_r($arrShiyouhazai);
    echo "</pre>";
    */
    $this->set('arrShiyouhazai',$arrShiyouhazai);

    if(!isset($_SESSION)){
      session_start();
      header('Expires:-1');
      header('Cache-Control:');
      header('Pragma:');
    }

  }

  public function kensakuform()
  {
    $stockEndMaterials = $this->StockEndMaterials->newEntity();
    $this->set('stockEndMaterials',$stockEndMaterials);

    $Material_list = $this->PriceMaterials->find()
    ->where(['delete_flag' => 0])->toArray();
    $arrMaterial_list = array();
    for($j=0; $j<count($Material_list); $j++){
      array_push($arrMaterial_list,$Material_list[$j]["grade"]."_".$Material_list[$j]["color"]);
    }
    $arrMaterial_list = array_unique($arrMaterial_list);
    $arrMaterial_list = array_values($arrMaterial_list);
    $this->set('arrMaterial_list', $arrMaterial_list);
  }

  public function kensakuichiran()
  {
    $stockEndMaterials = $this->StockEndMaterials->newEntity();
    $this->set('stockEndMaterials',$stockEndMaterials);

    $data = $this->request->getData();
    echo "<pre>";
    print_r($data);
    echo "</pre>";

    $datesta = $data['date_sta']['year']."-".$data['date_sta']['month']."-".$data['date_sta']['day']."T00:00:00";
    $this->set('datesta',$datesta);
    $datefin = $data['date_fin']['year']."-".$data['date_fin']['month']."-".$data['date_fin']['day'];
    $this->set('datefin',$datefin);
    $datefin = strtotime($datefin);
    $datefin = date('Y-m-d', strtotime('+1 day', $datefin))."T00:00:00";

    $grade_color = explode('_', $data["materialgrade_color"]);
    $grade = $grade_color[0];
    $color = $grade_color[1];

    $PriceMaterials = $this->PriceMaterials->find()
    ->where(['grade' => $grade, 'color' => $color, 'delete_flag' => 0])->toArray();

    if(isset($PriceMaterials[0])){

      $StockEndMaterials = $this->StockEndMaterials->find()
      ->where(['price_material_id' => $PriceMaterials[0]["id"], 'shiped_at >=' => $datesta, 'shiped_at <=' => $datefin, 'delete_flag' => 0])->toArray();

      echo "<pre>";
      print_r($StockEndMaterials);
      echo "</pre>";

    }

  }

}
