<?php
namespace App\myClass\Apifind;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

class htmlApifind extends AppController
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
    }

    public function Assemble($arrAssembleProducts)
   {
       $product_code = $arrAssembleProducts["10000"]["product_code"];
       $date1 = $arrAssembleProducts["10000"]["kensabi"];
       $date1st = strtotime($date1);
       $datenext1 = date('Y-m-d', strtotime('+1 month', $date1st));//選択した月の次の月の初日

       $ResultZensuHeads = $this->ResultZensuHeads->find()
       ->where(['product_code' => $product_code, 'datetime_finish >=' => $date1." 00:00:00", 'datetime_finish <' => $datenext1." 00:00:00"])
       ->order(["datetime_finish"=>"DESC"])->toArray();

       if(isset($ResultZensuHeads[0])){//検査している場合
                                                                         //child_pid変更
           $AssembleProducts = $this->AssembleProducts->find()->where(['product_code' => $product_code, 'self_assemble' => 1, 'status_self_assemble' => 0])->toArray();

           if(isset($AssembleProducts[0])){//AssembleProductsが存在する場合

             $diff = floor((strtotime($datenext1) - $date1st) / (60 * 60 * 24));//1か月の日数を取得

             for($l=0; $l<$diff; $l++){//それぞれの日付に対して

               $datetime_finish = strtotime("+$l day " . $date1);//1日ずつ取得
               $datetime_finish = date("Y-m-d", $datetime_finish);

               $Konpou = $this->Konpous->find()->where(['product_code' => $product_code])->toArray();
               $irisu = $Konpou[0]->irisu;//製品の入数を取得

               $ResultZensuHeadsday = $this->ResultZensuHeads->find()//同じ日付に検査した製品の個数を求める
               ->where(['product_code' => $product_code, 'datetime_finish >=' => $datetime_finish." 00:00:00", 'datetime_finish <=' => $datetime_finish." 23:59:59"])
               ->order(["datetime_finish"=>"DESC"])->toArray();

               if(isset($ResultZensuHeadsday[0])){//同じ日付に検査した製品が存在する場合

                 $amount = $irisu * count($ResultZensuHeadsday);//入数をかけてamountを取得

                  $arrAssembleProducts[] = [//配列$arrAssembleProductsに追加
                    'product_code' => $product_code,
                    'kensabi' => $datetime_finish,
                    'amount' => $amount
                 ];

               }

             }

           }

         $arrAssembleProducts = array_unique($arrAssembleProducts, SORT_REGULAR);//重複の削除
         $arrAssembleProducts = array_values($arrAssembleProducts);//番号の振り直し

         $product_code = array();//ここから配列の並び変え
         $kensabi = array();
         foreach ($arrAssembleProducts as $key => $value) {
            $product_code[$key] = $value['product_code'];
            $kensabi[$key] = $value["kensabi"];
          }

          array_multisort($product_code, array_map( "strtotime", $kensabi ), SORT_ASC, SORT_NUMERIC, $arrAssembleProducts);//品番、検査日順に並び変え

       }

       unset($arrAssembleProducts[10000]);

       for($l=0; $l<count($arrAssembleProducts); $l++){

         if($arrAssembleProducts[$l]["amount"] < 1){

           unset($arrAssembleProducts[$l]);
           $arrAssembleProducts = array_values($arrAssembleProducts);

         }

       }

      return $arrAssembleProducts;
   }

   public function OrderEdis($date16)
  {
    $arrProductsmoto = $_SESSION['classarrProductsmoto'];
    $OrderEdis = $_SESSION['classOrderEdis'];
    $arrOrderEdis = $_SESSION['classarrOrderEdis'];

    //同一のproduct_code、date_deliverの注文は一つにまとめ、amountとdenpyoumaisuを更新
    for($l=0; $l<count($arrOrderEdis); $l++){

      for($m=$l+1; $m<count($arrOrderEdis); $m++){

        if($arrOrderEdis[$l]["product_code"] == $arrOrderEdis[$m]["product_code"] && $arrOrderEdis[$l]["date_deliver"] == $arrOrderEdis[$m]["date_deliver"]){

          $amount = $arrOrderEdis[$l]["amount"] + $arrOrderEdis[$m]["amount"];
          $denpyoumaisu = $arrOrderEdis[$l]["denpyoumaisu"] + $arrOrderEdis[$m]["denpyoumaisu"];

          $arrOrderEdis[$l]["amount"] = $amount;
          $arrOrderEdis[$l]["denpyoumaisu"] = $denpyoumaisu;

          unset($arrOrderEdis[$m]);

        }

      }
      $arrOrderEdis = array_values($arrOrderEdis);

    }

    $arrOrderEdis = array_merge($arrOrderEdis, $arrProductsmoto);

    //並べかえ
    $tmp_product_array = array();
    $tmp_date_deliver_array = array();
    foreach($arrOrderEdis as $key => $row ) {
      $tmp_product_array[$key] = $row["product_code"];
      $tmp_date_deliver_array[$key] = $row["date_deliver"];
    }

    if(count($arrOrderEdis) > 0){
      array_multisort($tmp_product_array, array_map( "strtotime", $tmp_date_deliver_array ), SORT_ASC, SORT_NUMERIC, $arrOrderEdis);
    }

     return $arrOrderEdis;
  }


      public function Productsmoto($date16)
     {
       $arrOrderEdis = array();//注文呼び出し

       $arrProducts = $_SESSION['classarrProducts'];

       $arrProductsmoto = array();
       for($k=0; $k<count($arrProducts); $k++){

         $riron_check = 0;
      //   $date16 = $yaermonth."-16";
         $RironStockProducts = $this->RironStockProducts->find()->where(['product_code' => $arrProducts[$k]["product_code"], 'date_culc' => $date16])->toArray();
         if(isset($RironStockProducts[0])){
           $riron_check = 1;
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


     public function ResultZensuHeadsmoto($dateend)
    {
      $datestart = $_SESSION['classarrdatestart'];

      $ResultZensuHeads = $this->ResultZensuHeads->find()//組立品の元データを出しておく（ループで取り出すと時間がかかる）
      ->where(['datetime_finish >=' => $datestart." 00:00:00", 'datetime_finish <' => $dateend." 00:00:00"])
      ->order(["datetime_finish"=>"DESC"])->toArray();

      $arrResultZensuHeadsmoto = array();
      for($k=0; $k<count($ResultZensuHeads); $k++){

        $arrResultZensuHeadsmoto[] = [
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

      //同一の$arrResultZensuHeadsmotoは一つにまとめ、countを更新
      for($l=0; $l<count($arrResultZensuHeadsmoto); $l++){

        for($m=$l+1; $m<count($arrResultZensuHeadsmoto); $m++){

          if($arrResultZensuHeadsmoto[$l]["product_code"] == $arrResultZensuHeadsmoto[$m]["product_code"] && $arrResultZensuHeadsmoto[$l]["datetime_finish"] == $arrResultZensuHeadsmoto[$m]["datetime_finish"]){

            $count = $arrResultZensuHeadsmoto[$l]["count"] + $arrResultZensuHeadsmoto[$m]["count"];

            $arrResultZensuHeadsmoto[$l]["count"] = $count;

            unset($arrResultZensuHeadsmoto[$m]);

          }

        }
        $arrResultZensuHeadsmoto = array_values($arrResultZensuHeadsmoto);

      }

       return $arrResultZensuHeadsmoto;
    }

}

?>
