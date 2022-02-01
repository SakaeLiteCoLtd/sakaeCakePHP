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

   public function classProductsmoto($date16)
  {
    $arrProducts = $_SESSION['zaikoarrProducts'];

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

  public function classStockProducts($arrStockProductsmoto)//StockProductsの並び替え
  {
    $tmp_product_array = array();
    $tmp_date_stock_array = array();
    foreach($arrStockProductsmoto as $key => $row ) {
      $tmp_product_array[$key] = $row["product_code"];
      $tmp_date_stock_array[$key] = $row["date_stock"];
    }

    if(count($arrStockProductsmoto) > 0){
      array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_stock_array ), SORT_ASC, SORT_NUMERIC, $arrStockProductsmoto);
    }

    $arrStockProducts = $arrStockProductsmoto;

     return $arrStockProducts;
  }

  public function classSyoyouKeikakus($arrSyoyouKeikakusmoto)//並べかえ
  {
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

  public function classSeisans($arrSeisansmoto)//並べかえ
  {
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

  public function classSeisanskadou($k)//並べかえ
  {
    $KadouSeikeis = $_SESSION['zaikoKadouSeikeis'];
    $arrSeisans = $_SESSION['zaikoarrSeisans'];

    $Katakouzous = $this->Katakouzous->find()->where(['product_code' => $KadouSeikeis[$k]["product_code"]])->toArray();

    $starting_tm = substr($KadouSeikeis[$k]['starting_tm'], 0, 10);
    $dateseikei = strtotime(substr($KadouSeikeis[$k]['starting_tm'], 10));

    if($dateseikei < strtotime(" 08:00:00")){
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
