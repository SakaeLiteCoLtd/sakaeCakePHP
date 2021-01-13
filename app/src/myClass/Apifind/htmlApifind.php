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
    }

    public function Assemble($arrAssembleProducts)
   {

     /*//controllerへ
     						//組立品呼び出し//クラス使用
     						$arrAssembleProducts[10000] = [
     							'product_code' => $OrderEdis[$k]["product_code"],
     							'kensabi' => $date1,
     							'amount' => 0
     					 ];

     						$htmlApifind = new htmlApifind();//クラスを使用
     						$arrAssembleProducts = $htmlApifind->Assemble($arrAssembleProducts);//クラスを使用
     */


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


}

?>
