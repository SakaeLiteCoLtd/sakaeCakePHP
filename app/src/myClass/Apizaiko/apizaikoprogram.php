<?php
namespace App\myClass\Apizaiko;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う

class apizaikoprogram extends AppController
{
     public function initialize()
    {
        parent::initialize();
        $this->AssembleProducts = TableRegistry::get('assembleProducts');
        $this->Customers = TableRegistry::get('customers');
        $this->Konpous = TableRegistry::get('konpous');
        $this->ResultZensuHeads = TableRegistry::get('resultZensuHeads');
        $this->ScheduleKouteis = TableRegistry::get('scheduleKouteis');
        $this->Products = TableRegistry::get('products');
        $this->OrderEdis = TableRegistry::get('orderEdis');
        $this->StockProducts = TableRegistry::get('stockProducts');
        $this->SyoyouKeikakus = TableRegistry::get('syoyouKeikakus');
        $this->KadouSeikeis = TableRegistry::get('kadouSeikeis');
        $this->Katakouzous = TableRegistry::get('katakouzous');
        $this->Customers = TableRegistry::get('customers');
        $this->RironStockProducts = TableRegistry::get('rironStockProducts');
        $this->LabelSetikkatsues = TableRegistry::get('labelSetikkatsues');
    }

    public function classProductsmototarget()//ターゲット日以降
   {
     $arrProducts = $_SESSION['zaikoarrProductstarget'];

     $arrProductsmoto = array();//対象の製品全部の器を作っておく（OrderEdisに存在しないものも表示するため）
     for($k=0; $k<count($arrProducts); $k++){

       $arrProductsmoto[] = [
         'date_order' => "",
         'num_order' => "",
         'product_code' => $arrProducts[$k]["product_code"],
         'product_name' => $arrProducts[$k]["product_name"],
         'price' => "",
         'date_deliver' => "",
         'amount' => "",
         'denpyoumaisu' => "",
         'riron_zaiko_check' => 0
      ];

     }

     return $arrProductsmoto;

   }

   public function classProductsmoto($sheet_date)
  {
    $date16 = $_SESSION['date16'.$sheet_date];
    $arrProducts = $_SESSION['zaikoarrProducts'.$sheet_date];

    $arrProductsmoto = array();//対象の製品全部の器を作っておく（OrderEdisに存在しないものも表示するため）

    $RironStockProducts = $this->RironStockProducts->find()->select('product_code')
    ->where(['date_culc' => $date16])->toArray();

    for($k=0; $k<count($arrProducts); $k++){

      $riron_check = 0;

      $key = array_search($arrProducts[$k]["product_code"], array_column($RironStockProducts, 'product_code'));//配列の検索
      if(strlen($key) > 0){
        $riron_check = 1;//登録されていれば「１」
      }

      $arrProductsmoto[] = [
        'date_order' => "",
        'num_order' => "",
        'product_code' => $arrProducts[$k]["product_code"],
        'product_name' => $arrProducts[$k]["product_name"],
        'price' => "",
        'date_deliver' => "",
        'amount' => "",
        'denpyoumaisu' => "",
        'riron_zaiko_check' => $riron_check
     ];

    }

    return $arrProductsmoto;

  }

  public function classResultZensuHeads($date1_datenext1)
 {
   $arrdate1_datenext1 = explode("_",$date1_datenext1);
   $date1 = $arrdate1_datenext1[0];
   $datenext1 = $arrdate1_datenext1[1];

   $arrAssembleProducts = array();//ここから組立品
   $ResultZensuHeads = $this->ResultZensuHeads->find()//組立品の元データを配列として出しておく（ループで取り出すと時間がかかる）
   ->where(['datetime_finish >=' => $date1." 08:00:00", 'datetime_finish <' => $datenext1." 08:00:00", 'count_inspection' => 1, 'delete_flag' => 0])
   ->order(["datetime_finish"=>"DESC"])->toArray();

   $arrResultZensuHeadsmoto = array();
   for($k=0; $k<count($ResultZensuHeads); $k++){
     $arrResultZensuHeadsmoto[] = [//重複も含めて全て配列に追加
       'product_code' => $ResultZensuHeads[$k]["product_code"],
       'datetime_finish' => $ResultZensuHeads[$k]["datetime_finish"]->format('Y-m-d'),
       'count' => 1
    ];
   }

   $product_code_moto = array();//ここから配列の並び変え
   $datetime_finish_moto = array();
   foreach ($arrResultZensuHeadsmoto as $key => $value) {
      $product_code[$key] = $value['product_code'];
      $datetime_finish[$key] = $value["datetime_finish"];
    }
    if(isset($datetime_finish)){
      array_multisort($product_code, array_map("strtotime", $datetime_finish), SORT_ASC, SORT_NUMERIC, $arrResultZensuHeadsmoto);
    }
    $countZensuHeadsmotomax = count($arrResultZensuHeadsmoto);

   //同一の$arrResultZensuHeadsmotoは一つにまとめ、countを更新
   for($l=0; $l<count($arrResultZensuHeadsmoto); $l++){
     for($m=$l+1; $m<$countZensuHeadsmotomax; $m++){
       if(isset($arrResultZensuHeadsmoto[$m]["product_code"])){
         if($arrResultZensuHeadsmoto[$l]["product_code"] == $arrResultZensuHeadsmoto[$m]["product_code"] && $arrResultZensuHeadsmoto[$l]["datetime_finish"] == $arrResultZensuHeadsmoto[$m]["datetime_finish"]){
           $count = $arrResultZensuHeadsmoto[$l]["count"] + $arrResultZensuHeadsmoto[$m]["count"];
           $arrResultZensuHeadsmoto[$l]["count"] = $count;
           unset($arrResultZensuHeadsmoto[$m]);
         }
       }
     }
     $arrResultZensuHeadsmoto = array_values($arrResultZensuHeadsmoto);
   }

   return $arrResultZensuHeadsmoto;

 }

 public function classOrderEdis($sheet_date)//arrOrderEdisの並び替え
 {
   $arrProductsmoto = $_SESSION['zaikoarrProductsmoto'.$sheet_date];
   $arrOrderEdismoto = $_SESSION['zaikoarrOrderEdismoto'.$sheet_date];

   $countmax = count($arrOrderEdismoto);
   //同一のproduct_code、date_deliverの注文は一つにまとめ、amountとdenpyoumaisuを更新
   for($l=0; $l<count($arrOrderEdismoto); $l++){
     for($m=$l+1; $m<$countmax; $m++){
       if(isset($arrOrderEdismoto[$m]["product_code"])){
         if($arrOrderEdismoto[$l]["product_code"] == $arrOrderEdismoto[$m]["product_code"] && $arrOrderEdismoto[$l]["date_deliver"] == $arrOrderEdismoto[$m]["date_deliver"]){
           $amount = (int)$arrOrderEdismoto[$l]["amount"] + (int)$arrOrderEdismoto[$m]["amount"];
           $denpyoumaisu = $arrOrderEdismoto[$l]["denpyoumaisu"] + $arrOrderEdismoto[$m]["denpyoumaisu"];
           $arrOrderEdismoto[$l]["amount"] = $amount;
           $arrOrderEdismoto[$l]["denpyoumaisu"] = $denpyoumaisu;
           unset($arrOrderEdismoto[$m]);
         }
       }
     }
     $arrOrderEdismoto = array_values($arrOrderEdismoto);
   }
   $arrOrderEdismoto = array_merge($arrOrderEdismoto, $arrProductsmoto);

   //並べかえ
   $tmp_product_array = array();
   $tmp_date_deliver_array = array();
   foreach($arrOrderEdismoto as $key => $row ) {
     $tmp_product_array[$key] = $row["product_code"];
     $tmp_date_deliver_array[$key] = $row["date_deliver"];
   }

   if(count($arrOrderEdismoto) > 0){
     array_multisort($tmp_product_array, array_map("strtotime", $tmp_date_deliver_array), SORT_ASC, SORT_NUMERIC, $arrOrderEdismoto);
   }

   $arrOrderEdis = $arrOrderEdismoto;

    return $arrOrderEdis;
 }

  public function classStockProducts($sheet_date)//StockProductsの並び替え
  {
    $arrStockProductsmoto = $_SESSION['zaikoarrStockProductsmoto'.$sheet_date];

    $tmp_product_array = array();
    $tmp_date_stock_array = array();
    foreach($arrStockProductsmoto as $key => $row ) {
      $tmp_product_array[$key] = $row["product_code"];
      $tmp_date_stock_array[$key] = $row["date_stock"];
    }

    if(count($arrStockProductsmoto) > 0){
      array_multisort($tmp_product_array, array_map("strtotime", $tmp_date_stock_array), SORT_ASC, SORT_NUMERIC, $arrStockProductsmoto);
    }

    $arrStockProducts = $arrStockProductsmoto;

     return $arrStockProducts;
  }

  public function classSyoyouKeikakus($sheet_date)//並べかえ
  {
    $arrSyoyouKeikakusmoto = $_SESSION['zaikoarrSyoyouKeikakusmoto'.$sheet_date];

    $tmp_product_array = array();
    $tmp_date_deliver_array = array();
    foreach($arrSyoyouKeikakusmoto as $key => $row ) {
      $tmp_product_array[$key] = $row["product_code"];
      $tmp_date_deliver_array[$key] = $row["date_deliver"];
    }

    if(count($arrSyoyouKeikakusmoto) > 0){
      array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_deliver_array ), SORT_ASC, SORT_NUMERIC, $arrSyoyouKeikakusmoto);
    }

    $arrSyoyouKeikakus = $arrSyoyouKeikakusmoto;

     return $arrSyoyouKeikakus;
  }

  public function classSeisans($sheet_date)//並べかえ
  {
    $arrSeisansmoto = $_SESSION['zaikoarrSeisansmoto'.$sheet_date];

    $tmp_product_array2 = array();
    $tmp_dateseikei_array = array();
    foreach($arrSeisansmoto as $key => $row ) {
      $tmp_product_array2[$key] = $row["product_code"];
      $tmp_dateseikei_array[$key] = $row["dateseikei"];
    }

    if(count($arrSeisansmoto) > 0){
      array_multisort($tmp_product_array2, $tmp_dateseikei_array, SORT_ASC, SORT_NUMERIC, $arrSeisansmoto);
    }

    $arrSeisans = $arrSeisansmoto;

     return $arrSeisans;
  }

  public function classSeisanskadou($num_sheet_date)
  {
    $arrnum_sheet_date = explode("~",$num_sheet_date);
    $k = $arrnum_sheet_date[0];
    $sheet_date = $arrnum_sheet_date[1];

    $KadouSeikeis = $_SESSION['zaikoKadouSeikeis'.$sheet_date];
    $arrSeisans = $_SESSION['zaikoarrSeisans'.$sheet_date];

    $Katakouzous = $this->Katakouzous->find()->where(['product_code' => $KadouSeikeis[$k]["product_code"]])->toArray();

    $starting_tm = substr($KadouSeikeis[$k]['starting_tm'], 0, 10);
    $dateseikei = strtotime(substr($KadouSeikeis[$k]['starting_tm'], 10));

    if($dateseikei < strtotime(" 08:00:00")){//8時未満であれば前日の成形
      $starting_tm = strtotime($starting_tm);
      $nippouday = date('Y/m/d', strtotime('-1 day', $starting_tm));
    }else{
      $nippouday = substr($KadouSeikeis[$k]['starting_tm'], 0, 10);
    }

    if(isset($Katakouzous[0])){
      $torisu = $Katakouzous[0]["torisu"];
    }else{
      $torisu = "Katakouzousテーブルに登録なし";
    }

    $arrSeisans[] = [
      'dateseikei' => $nippouday,
      'product_code' => $KadouSeikeis[$k]["product_code"],
      'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
      'torisu' => $torisu
   ];

//セット取りの場合はもう一方も配列に追加
   $LabelSetikkatsu1 = $this->LabelSetikkatsues->find()->where(['product_id1' => $KadouSeikeis[$k]['product_code'], 'kind_set_assemble' => 0])->toArray();
   $LabelSetikkatsu2 = $this->LabelSetikkatsues->find()->where(['product_id2' => $KadouSeikeis[$k]['product_code'], 'kind_set_assemble' => 0])->toArray();

   if(isset($LabelSetikkatsu1[0])){

     $arrSeisans[] = [
      'dateseikei' => $nippouday,
      'product_code' => $LabelSetikkatsu1[0]["product_id2"],
      'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
      'torisu' => $torisu
   ];

   }elseif(isset($LabelSetikkatsu2[0])){

     $arrSeisans[] = [
      'dateseikei' => $nippouday,
      'product_code' => $LabelSetikkatsu2[0]["product_id1"],
      'amount_shot' => $KadouSeikeis[$k]["amount_shot"],
      'torisu' => $torisu
   ];

   }

     return $arrSeisans;
  }

}

?>
