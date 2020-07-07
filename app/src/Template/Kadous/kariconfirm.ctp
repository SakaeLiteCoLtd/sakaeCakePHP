<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff[]|\Cake\Collection\CollectionInterface $staffs
 */
 use Cake\ORM\TableRegistry;//独立したテーブルを扱う
 use Cake\Datasource\ConnectionManager;//トランザクション

$this->GenjyouSeikeikis = TableRegistry::get('genjyouSeikeikis');
$this->Products = TableRegistry::get('products');//productsテーブルを使う
$this->Konpous = TableRegistry::get('konpous');//productsテーブルを使う

//$this->KariKadouSeikeis = TableRegistry::get('kariKadouSeikeis');

?>
        <?php
          $username = $this->request->Session()->read('Auth.User.username');

          header('Expires:-1');
          header('Cache-Control:');
          header('Pragma:');
          echo $this->Form->create($KariKadouSeikeis, ['url' => ['action' => 'karipreadd']]);

?>

<?php
 use App\myClass\Kadous\htmlKadoumenu;//myClassフォルダに配置したクラスを使用
 $htmlKadoumenu = new htmlKadoumenu();
 $htmlKadoumenus = $htmlKadoumenu->Kadoumenus();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlKadoumenus;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">

  <br>
  <br>
<br>

<?php   /*ここから１号機*/    ?>

 <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
   <caption style="text-align: left">１号機</caption>
   <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
     <tr style="border-bottom: 0px;border-width: 0px">
       <td width="250" height="60" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
       <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
       <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">ショット数</strong></div></td>
       <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">理論ショット数</strong></div></td>
       <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">達成率</strong></div></td>
     </tr>


 <?php
 $j = 1;

 for($i=1; $i<=${"n".$j}; $i++){//１号機
       echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
       echo "<td rowspan='2'  height='10' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
       echo ${"product_code".$j.$i};
       echo "</div></td>\n";
       echo "</strong></div></td>\n";
       echo "<td colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
       echo ${"kadoujikan".$j.$i}/3600;
       echo "</div></td>\n";
       echo "<td rowspan='2' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
       echo ${"amount_shot".$j.$i};
       echo "</div></td>\n";
       echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
       echo ${"riron_shot".$j.$i};
       echo "</div></td>\n";
       echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'><div align='center' style='font-size: 18pt; color:red'>\n";
       echo ${"accomp_rate".$j.$i}."%";
       echo "</div></td>\n";
       echo "</tr>\n";
       echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
       echo "</tr>\n";
   }
  ?>
 </table>
 <br>
 <br>

 <?php
   $session = $this->request->getSession();

   for($i=1; $i<=${"n".$j}; $i++){
     ${"starting_tm".$j.$i} = substr(${"starting_tm".$j.$i}, 0, 10)." ".substr(${"starting_tm".$j.$i}, 11, 5);
     ${"finishing_tm".$j.$i} = substr(${"finishing_tm".$j.$i}, 0, 10)." ".substr(${"finishing_tm".$j.$i}, 11, 5);
     $m = $i;

     //ビッグDB参照
     $connection = ConnectionManager::get('big_DB');
     $table = TableRegistry::get('shotdata_sensors');
     $table->setConnection($connection);

     $sql = "SELECT lot_num FROM shotdata_sensors".
           " where datetime >= '".${"starting_tm".$j.$i}."' and datetime <= '".${"finishing_tm".$j.$i}."' and seikeiki =".$j." and product_code ='".${"product_code".$j.$i}."' order by datetime asc";
     $connection = ConnectionManager::get('big_DB');
     ${"shotdata_sensors".$j.$i} = $connection->execute($sql)->fetchAll('assoc');

     if(isset(${"shotdata_sensors".$j.$i}[0])){
       ${"count_lot".$j.$i} = count(${"shotdata_sensors".$j.$i}) - 1;
       ${"first_lot_num".$j.$i} = ${"shotdata_sensors".$j.$i}[0]['lot_num'];
       ${"last_lot_num".$j.$i} = ${"shotdata_sensors".$j.$i}[${"count_lot".$j.$i}]['lot_num'];
     }else{
       ${"first_lot_num".$j.$i} = "";
       ${"last_lot_num".$j.$i} = "";
     }

     $connection = ConnectionManager::get('default');
     $table->setConnection($connection);

     $Product = $this->Products->find()->where(['product_code' => ${"product_code".$j.$i}])->toArray();

     if(($Product[0]->torisu) > 0){
       $torisu = $Product[0]->torisu;
       $Konpou = $this->Konpous->find()->where(['product_code' => ${"product_code".$j.$i}])->toArray();

         if(($Konpou[0]->irisu) > 0){
           $irisu = $Konpou[0]->irisu;

           ${"sum_predict_lot_num".$j.$i} = ceil((${"amount_shot".$j.$i} * $torisu) / $irisu);//kadou\Select_yobidashi.class.php　$sumLot参照
/*
           echo "<pre>";
           print_r("sum_predict_lot_num =".${"amount_shot".$j.$i}." * ".$torisu." / ".$irisu);
           echo "</pre>";
*/
         }else{

           echo "<pre>";
           print_r(${"product_code".$j.$i}."のirisuがKonpousテーブルに登録されていません※sum_predict_lot_num以外はこのまま登録できます");
           echo "</pre>";
           ${"sum_predict_lot_num".$j.$i} = "";

         }

     }else{

       echo "<pre>";
       print_r(${"product_code".$j.$i}."のtorisuがProductsテーブルに登録されていません※sum_predict_lot_num以外はこのまま登録できます");
       echo "</pre>";

       ${"sum_predict_lot_num".$j.$i} = "";
     }


     $GenjyouSeikeiki= $this->GenjyouSeikeikis->find()->where(['seikeiki' => $j])->toArray();
     $seikeiki_code = $GenjyouSeikeiki[0]->seikeiki_code;

     $_SESSION["karikadouseikei"][$i] = array(
       'product_code' => ${"product_code".$j.$i},
       'seikeiki' => $j,
       'seikeiki_code' => $seikeiki_code,
       'starting_tm' => ${"starting_tm".$j.$i},
       'finishing_tm' => ${"finishing_tm".$j.$i},
       'cycle_shot' => ${"cycle_shot".$j.$i},
       'amount_shot' => ${"amount_shot".$j.$i},
       'accomp_rate' => ${"accomp_rate".$j.$i}/100,
       "present_kensahyou" => 0,
       'first_lot_num' => ${"first_lot_num".$j.$i},
       "last_lot_num" => ${"last_lot_num".$j.$i},
       "sum_predict_lot_num" => ${"sum_predict_lot_num".$j.$i},
     );
   }
/*
   echo "<pre>";
   print_r($_SESSION["karikadouseikei"]);
   echo "</pre>";
*/
  ?>

<?php   /*ここまで１号機*/    ?>

<?php   /*ここから２号機*/    ?>

   <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
     <caption style="text-align: left">２号機</caption>
     <tbody border="2" bordercolor="#E6FFFF" bgcolor="#ffc0cb" style="border-bottom: solid;border-width: 1px">
       <tr style="border-bottom: 0px;border-width: 0px">
         <td width="250" height="60" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">ショット数</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">理論ショット数</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">達成率</strong></div></td>
       </tr>


   <?php
   $j = 2;

   for($i=1; $i<=${"n".$j}; $i++){//２号機
         echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
         echo "<td rowspan='2'  height='10' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"product_code".$j.$i};
         echo "</div></td>\n";
         echo "</strong></div></td>\n";
         echo "<td colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"kadoujikan".$j.$i}/3600;
         echo "</div></td>\n";
         echo "<td rowspan='2' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"amount_shot".$j.$i};
         echo "</div></td>\n";
         echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"riron_shot".$j.$i};
         echo "</div></td>\n";
         echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'><div align='center' style='font-size: 18pt; color:red'>\n";
         echo ${"accomp_rate".$j.$i}."%";
         echo "</div></td>\n";
         echo "</tr>\n";
         echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
         echo "</tr>\n";
     }
    ?>
   </table>
   <br>
   <br>

   <?php

     for($i=1; $i<=${"n".$j}; $i++){
       ${"starting_tm".$j.$i} = substr(${"starting_tm".$j.$i}, 0, 10)." ".substr(${"starting_tm".$j.$i}, 11, 5);
       ${"finishing_tm".$j.$i} = substr(${"finishing_tm".$j.$i}, 0, 10)." ".substr(${"finishing_tm".$j.$i}, 11, 5);

       if(isset($m)){
         $m = $m + 1;
       }else{
         $m = 1;
       }

       //ビッグDB参照
       $connection = ConnectionManager::get('big_DB');
       $table = TableRegistry::get('shotdata_sensors');
       $table->setConnection($connection);

       $sql = "SELECT lot_num FROM shotdata_sensors".
             " where datetime >= '".${"starting_tm".$j.$i}."' and datetime <= '".${"finishing_tm".$j.$i}."' and seikeiki =".$j." and product_code ='".${"product_code".$j.$i}."' order by datetime asc";
       $connection = ConnectionManager::get('big_DB');
       ${"shotdata_sensors".$j.$i} = $connection->execute($sql)->fetchAll('assoc');

       if(isset(${"shotdata_sensors".$j.$i}[0])){
         ${"count_lot".$j.$i} = count(${"shotdata_sensors".$j.$i}) - 1;
         ${"first_lot_num".$j.$i} = ${"shotdata_sensors".$j.$i}[0]['lot_num'];
         ${"last_lot_num".$j.$i} = ${"shotdata_sensors".$j.$i}[${"count_lot".$j.$i}]['lot_num'];
       }else{
         ${"first_lot_num".$j.$i} = "";
         ${"last_lot_num".$j.$i} = "";
       }

       $connection = ConnectionManager::get('default');
       $table->setConnection($connection);

       $Product = $this->Products->find()->where(['product_code' => ${"product_code".$j.$i}])->toArray();
       if(($Product[0]->torisu) > 0){
         $torisu = $Product[0]->torisu;
         $Konpou = $this->Konpous->find()->where(['product_code' => ${"product_code".$j.$i}])->toArray();

           if(($Konpou[0]->irisu) > 0){
             $irisu = $Konpou[0]->irisu;

             ${"sum_predict_lot_num".$j.$i} = ceil((${"amount_shot".$j.$i} * $torisu) / $irisu);

           }else{

             echo "<pre>";
             print_r(${"product_code".$j.$i}."のirisuがKonpousテーブルに登録されていません※sum_predict_lot_num以外はこのまま登録できます");
             echo "</pre>";
             ${"sum_predict_lot_num".$j.$i} = "";

           }

       }else{

         echo "<pre>";
         print_r(${"product_code".$j.$i}."のtorisuがProductsテーブルに登録されていません※sum_predict_lot_num以外はこのまま登録できます");
         echo "</pre>";

         ${"sum_predict_lot_num".$j.$i} = "";
       }


       $GenjyouSeikeiki= $this->GenjyouSeikeikis->find()->where(['seikeiki' => $j])->toArray();
       $seikeiki_code = $GenjyouSeikeiki[0]->seikeiki_code;

       $_SESSION["karikadouseikei"][$m] = array(
         'product_code' => ${"product_code".$j.$i},
         'seikeiki' => $j,
         'seikeiki_code' => $seikeiki_code,
         'starting_tm' => ${"starting_tm".$j.$i},
         'finishing_tm' => ${"finishing_tm".$j.$i},
         'cycle_shot' => ${"cycle_shot".$j.$i},
         'amount_shot' => ${"amount_shot".$j.$i},
         'accomp_rate' => ${"accomp_rate".$j.$i}/100,
         "present_kensahyou" => 0,
         'first_lot_num' => ${"first_lot_num".$j.$i},
         "last_lot_num" => ${"last_lot_num".$j.$i},
         "sum_predict_lot_num" => ${"sum_predict_lot_num".$j.$i},
       );

     }
/*
     echo "<pre>";
     print_r($_SESSION["karikadouseikei"]);
     echo "</pre>";
*/
    ?>

<?php   /*ここまで２号機*/    ?>

<?php   /*ここから３号機*/    ?>

   <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
     <caption style="text-align: left">３号機</caption>
     <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
       <tr style="border-bottom: 0px;border-width: 0px">
         <td width="250" height="60" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">ショット数</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">理論ショット数</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">達成率</strong></div></td>
       </tr>


   <?php
   $j = 3;

   for($i=1; $i<=${"n".$j}; $i++){//3号機
         echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
         echo "<td rowspan='2'  height='10' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"product_code".$j.$i};
         echo "</div></td>\n";
         echo "</strong></div></td>\n";
         echo "<td colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"kadoujikan".$j.$i}/3600;
         echo "</div></td>\n";
         echo "<td rowspan='2' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"amount_shot".$j.$i};
         echo "</div></td>\n";
         echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"riron_shot".$j.$i};
         echo "</div></td>\n";
         echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'><div align='center' style='font-size: 18pt; color:red'>\n";
         echo ${"accomp_rate".$j.$i}."%";
         echo "</div></td>\n";
         echo "</tr>\n";
         echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
         echo "</tr>\n";
     }
    ?>
   </table>
   <br>
   <br>

   <?php

     for($i=1; $i<=${"n".$j}; $i++){
       ${"starting_tm".$j.$i} = substr(${"starting_tm".$j.$i}, 0, 10)." ".substr(${"starting_tm".$j.$i}, 11, 5);
       ${"finishing_tm".$j.$i} = substr(${"finishing_tm".$j.$i}, 0, 10)." ".substr(${"finishing_tm".$j.$i}, 11, 5);
       if(isset($m)){
         $m = $m + 1;
       }else{
         $m = 1;
       }
       //ビッグDB参照
       $connection = ConnectionManager::get('big_DB');
       $table = TableRegistry::get('shotdata_sensors');
       $table->setConnection($connection);

       $sql = "SELECT lot_num FROM shotdata_sensors".
             " where datetime >= '".${"starting_tm".$j.$i}."' and datetime <= '".${"finishing_tm".$j.$i}."' and seikeiki =".$j." and product_code ='".${"product_code".$j.$i}."' order by datetime asc";
       $connection = ConnectionManager::get('big_DB');
       ${"shotdata_sensors".$j.$i} = $connection->execute($sql)->fetchAll('assoc');

       if(isset(${"shotdata_sensors".$j.$i}[0])){
         ${"count_lot".$j.$i} = count(${"shotdata_sensors".$j.$i}) - 1;
         ${"first_lot_num".$j.$i} = ${"shotdata_sensors".$j.$i}[0]['lot_num'];
         ${"last_lot_num".$j.$i} = ${"shotdata_sensors".$j.$i}[${"count_lot".$j.$i}]['lot_num'];
       }else{
         ${"first_lot_num".$j.$i} = "";
         ${"last_lot_num".$j.$i} = "";
       }

       $connection = ConnectionManager::get('default');
       $table->setConnection($connection);

       $Product = $this->Products->find()->where(['product_code' => ${"product_code".$j.$i}])->toArray();
       if(($Product[0]->torisu) > 0){
         $torisu = $Product[0]->torisu;
         $Konpou = $this->Konpous->find()->where(['product_code' => ${"product_code".$j.$i}])->toArray();

           if(($Konpou[0]->irisu) > 0){
             $irisu = $Konpou[0]->irisu;

             ${"sum_predict_lot_num".$j.$i} = ceil((${"amount_shot".$j.$i} * $torisu) / $irisu);

           }else{

             echo "<pre>";
             print_r(${"product_code".$j.$i}."のirisuがKonpousテーブルに登録されていません※sum_predict_lot_num以外はこのまま登録できます");
             echo "</pre>";
             ${"sum_predict_lot_num".$j.$i} = "";

           }

       }else{

         echo "<pre>";
         print_r(${"product_code".$j.$i}."のtorisuがProductsテーブルに登録されていません※sum_predict_lot_num以外はこのまま登録できます");
         echo "</pre>";

         ${"sum_predict_lot_num".$j.$i} = "";
       }


       $GenjyouSeikeiki= $this->GenjyouSeikeikis->find()->where(['seikeiki' => $j])->toArray();
       $seikeiki_code = $GenjyouSeikeiki[0]->seikeiki_code;

       $_SESSION["karikadouseikei"][$m] = array(
         'product_code' => ${"product_code".$j.$i},
         'seikeiki' => $j,
         'seikeiki_code' => $seikeiki_code,
         'starting_tm' => ${"starting_tm".$j.$i},
         'finishing_tm' => ${"finishing_tm".$j.$i},
         'cycle_shot' => ${"cycle_shot".$j.$i},
         'amount_shot' => ${"amount_shot".$j.$i},
         'accomp_rate' => ${"accomp_rate".$j.$i}/100,
         "present_kensahyou" => 0,
         'first_lot_num' => ${"first_lot_num".$j.$i},
         "last_lot_num" => ${"last_lot_num".$j.$i},
         "sum_predict_lot_num" => ${"sum_predict_lot_num".$j.$i},
       );

     }
/*
     echo "<pre>";
     print_r($_SESSION["karikadouseikei"]);
     echo "</pre>";
*/
    ?>

<?php   /*ここまで3号機*/    ?>

<?php   /*ここから4号機*/    ?>

   <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
     <caption style="text-align: left">４号機</caption>
     <tbody border="2" bordercolor="#E6FFFF" bgcolor="#ffc0cb" style="border-bottom: solid;border-width: 1px">
       <tr style="border-bottom: 0px;border-width: 0px">
         <td width="250" height="60" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">ショット数</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">理論ショット数</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">達成率</strong></div></td>
       </tr>


   <?php
   $j = 4;

   for($i=1; $i<=${"n".$j}; $i++){//4号機
         echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
         echo "<td rowspan='2'  height='10' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"product_code".$j.$i};
         echo "</div></td>\n";
         echo "</strong></div></td>\n";
         echo "<td colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"kadoujikan".$j.$i}/3600;
         echo "</div></td>\n";
         echo "<td rowspan='2' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"amount_shot".$j.$i};
         echo "</div></td>\n";
         echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"riron_shot".$j.$i};
         echo "</div></td>\n";
         echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'><div align='center' style='font-size: 18pt; color:red'>\n";
         echo ${"accomp_rate".$j.$i}."%";
         echo "</div></td>\n";
         echo "</tr>\n";
         echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
         echo "</tr>\n";
     }
    ?>
   </table>
   <br>
   <br>

   <?php

     for($i=1; $i<=${"n".$j}; $i++){
       ${"starting_tm".$j.$i} = substr(${"starting_tm".$j.$i}, 0, 10)." ".substr(${"starting_tm".$j.$i}, 11, 5);
       ${"finishing_tm".$j.$i} = substr(${"finishing_tm".$j.$i}, 0, 10)." ".substr(${"finishing_tm".$j.$i}, 11, 5);
       if(isset($m)){
         $m = $m + 1;
       }else{
         $m = 1;
       }
       //ビッグDB参照
       $connection = ConnectionManager::get('big_DB');
       $table = TableRegistry::get('shotdata_sensors');
       $table->setConnection($connection);

       $sql = "SELECT lot_num FROM shotdata_sensors".
             " where datetime >= '".${"starting_tm".$j.$i}."' and datetime <= '".${"finishing_tm".$j.$i}."' and seikeiki =".$j." and product_code ='".${"product_code".$j.$i}."' order by datetime asc";
       $connection = ConnectionManager::get('big_DB');
       ${"shotdata_sensors".$j.$i} = $connection->execute($sql)->fetchAll('assoc');

       if(isset(${"shotdata_sensors".$j.$i}[0])){
         ${"count_lot".$j.$i} = count(${"shotdata_sensors".$j.$i}) - 1;
         ${"first_lot_num".$j.$i} = ${"shotdata_sensors".$j.$i}[0]['lot_num'];
         ${"last_lot_num".$j.$i} = ${"shotdata_sensors".$j.$i}[${"count_lot".$j.$i}]['lot_num'];
       }else{
         ${"first_lot_num".$j.$i} = "";
         ${"last_lot_num".$j.$i} = "";
       }

       $connection = ConnectionManager::get('default');
       $table->setConnection($connection);

       $Product = $this->Products->find()->where(['product_code' => ${"product_code".$j.$i}])->toArray();
       if(($Product[0]->torisu) > 0){
         $torisu = $Product[0]->torisu;
         $Konpou = $this->Konpous->find()->where(['product_code' => ${"product_code".$j.$i}])->toArray();

           if(($Konpou[0]->irisu) > 0){
             $irisu = $Konpou[0]->irisu;

             ${"sum_predict_lot_num".$j.$i} = ceil((${"amount_shot".$j.$i} * $torisu) / $irisu);

           }else{

             echo "<pre>";
             print_r(${"product_code".$j.$i}."のirisuがKonpousテーブルに登録されていません※sum_predict_lot_num以外はこのまま登録できます");
             echo "</pre>";
             ${"sum_predict_lot_num".$j.$i} = "";

           }

       }else{

         echo "<pre>";
         print_r(${"product_code".$j.$i}."のtorisuがProductsテーブルに登録されていません※sum_predict_lot_num以外はこのまま登録できます");
         echo "</pre>";

         ${"sum_predict_lot_num".$j.$i} = "";
       }


       $GenjyouSeikeiki= $this->GenjyouSeikeikis->find()->where(['seikeiki' => $j])->toArray();
       $seikeiki_code = $GenjyouSeikeiki[0]->seikeiki_code;

       $_SESSION["karikadouseikei"][$m] = array(
         'product_code' => ${"product_code".$j.$i},
         'seikeiki' => $j,
         'seikeiki_code' => $seikeiki_code,
         'starting_tm' => ${"starting_tm".$j.$i},
         'finishing_tm' => ${"finishing_tm".$j.$i},
         'cycle_shot' => ${"cycle_shot".$j.$i},
         'amount_shot' => ${"amount_shot".$j.$i},
         'accomp_rate' => ${"accomp_rate".$j.$i}/100,
         "present_kensahyou" => 0,
         'first_lot_num' => ${"first_lot_num".$j.$i},
         "last_lot_num" => ${"last_lot_num".$j.$i},
         "sum_predict_lot_num" => ${"sum_predict_lot_num".$j.$i},
   );

     }
/*
     echo "<pre>";
     print_r($_SESSION["karikadouseikei"]);
     echo "</pre>";
*/
    ?>

<?php   /*ここまで4号機*/    ?>

<?php   /*ここから5号機*/    ?>

   <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
     <caption style="text-align: left">５号機</caption>
     <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
       <tr style="border-bottom: 0px;border-width: 0px">
         <td width="250" height="60" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">ショット数</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">理論ショット数</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">達成率</strong></div></td>
       </tr>


   <?php
   $j = 5;

   for($i=1; $i<=${"n".$j}; $i++){//5号機
         echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
         echo "<td rowspan='2'  height='10' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"product_code".$j.$i};
         echo "</div></td>\n";
         echo "</strong></div></td>\n";
         echo "<td colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"kadoujikan".$j.$i}/3600;
         echo "</div></td>\n";
         echo "<td rowspan='2' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"amount_shot".$j.$i};
         echo "</div></td>\n";
         echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"riron_shot".$j.$i};
         echo "</div></td>\n";
         echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'><div align='center' style='font-size: 18pt; color:red'>\n";
         echo ${"accomp_rate".$j.$i}."%";
         echo "</div></td>\n";
         echo "</tr>\n";
         echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
         echo "</tr>\n";
     }
    ?>
   </table>
   <br>
   <br>

   <?php

     for($i=1; $i<=${"n".$j}; $i++){
       ${"starting_tm".$j.$i} = substr(${"starting_tm".$j.$i}, 0, 10)." ".substr(${"starting_tm".$j.$i}, 11, 5);
       ${"finishing_tm".$j.$i} = substr(${"finishing_tm".$j.$i}, 0, 10)." ".substr(${"finishing_tm".$j.$i}, 11, 5);
       if(isset($m)){
         $m = $m + 1;
       }else{
         $m = 1;
       }
       //ビッグDB参照
       $connection = ConnectionManager::get('big_DB');
       $table = TableRegistry::get('shotdata_sensors');
       $table->setConnection($connection);

       $sql = "SELECT lot_num FROM shotdata_sensors".
             " where datetime >= '".${"starting_tm".$j.$i}."' and datetime <= '".${"finishing_tm".$j.$i}."' and seikeiki =".$j." and product_code ='".${"product_code".$j.$i}."' order by datetime asc";
       $connection = ConnectionManager::get('big_DB');
       ${"shotdata_sensors".$j.$i} = $connection->execute($sql)->fetchAll('assoc');

       if(isset(${"shotdata_sensors".$j.$i}[0])){
         ${"count_lot".$j.$i} = count(${"shotdata_sensors".$j.$i}) - 1;
         ${"first_lot_num".$j.$i} = ${"shotdata_sensors".$j.$i}[0]['lot_num'];
         ${"last_lot_num".$j.$i} = ${"shotdata_sensors".$j.$i}[${"count_lot".$j.$i}]['lot_num'];
       }else{
         ${"first_lot_num".$j.$i} = "";
         ${"last_lot_num".$j.$i} = "";
       }

       $connection = ConnectionManager::get('default');
       $table->setConnection($connection);

       $Product = $this->Products->find()->where(['product_code' => ${"product_code".$j.$i}])->toArray();
       if(($Product[0]->torisu) > 0){
         $torisu = $Product[0]->torisu;
         $Konpou = $this->Konpous->find()->where(['product_code' => ${"product_code".$j.$i}])->toArray();

           if(($Konpou[0]->irisu) > 0){
             $irisu = $Konpou[0]->irisu;

             ${"sum_predict_lot_num".$j.$i} = ceil((${"amount_shot".$j.$i} * $torisu) / $irisu);

           }else{

             echo "<pre>";
             print_r(${"product_code".$j.$i}."のirisuがKonpousテーブルに登録されていません※sum_predict_lot_num以外はこのまま登録できます");
             echo "</pre>";
             ${"sum_predict_lot_num".$j.$i} = "";

           }

       }else{

         echo "<pre>";
         print_r(${"product_code".$j.$i}."のtorisuがProductsテーブルに登録されていません※sum_predict_lot_num以外はこのまま登録できます");
         echo "</pre>";

         ${"sum_predict_lot_num".$j.$i} = "";
       }


       $GenjyouSeikeiki= $this->GenjyouSeikeikis->find()->where(['seikeiki' => $j])->toArray();
       $seikeiki_code = $GenjyouSeikeiki[0]->seikeiki_code;

       $_SESSION["karikadouseikei"][$m] = array(
         'product_code' => ${"product_code".$j.$i},
         'seikeiki' => $j,
         'seikeiki_code' => $seikeiki_code,
         'starting_tm' => ${"starting_tm".$j.$i},
         'finishing_tm' => ${"finishing_tm".$j.$i},
         'cycle_shot' => ${"cycle_shot".$j.$i},
         'amount_shot' => ${"amount_shot".$j.$i},
         'accomp_rate' => ${"accomp_rate".$j.$i}/100,
         "present_kensahyou" => 0,
         'first_lot_num' => ${"first_lot_num".$j.$i},
         "last_lot_num" => ${"last_lot_num".$j.$i},
         "sum_predict_lot_num" => ${"sum_predict_lot_num".$j.$i},
     );

     }
/*
     echo "<pre>";
     print_r($_SESSION["karikadouseikei"]);
     echo "</pre>";
*/
    ?>

<?php   /*ここまで5号機*/    ?>

<?php   /*ここから6号機*/    ?>

   <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
     <caption style="text-align: left">６号機</caption>
     <tbody border="2" bordercolor="#E6FFFF" bgcolor="#ffc0cb" style="border-bottom: solid;border-width: 1px">
       <tr style="border-bottom: 0px;border-width: 0px">
         <td width="250" height="60" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">ショット数</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">理論ショット数</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">達成率</strong></div></td>
       </tr>


   <?php
   $j = 6;

   for($i=1; $i<=${"n".$j}; $i++){//6号機
         echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
         echo "<td rowspan='2'  height='10' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"product_code".$j.$i};
         echo "</div></td>\n";
         echo "</strong></div></td>\n";
         echo "<td colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"kadoujikan".$j.$i}/3600;
         echo "</div></td>\n";
         echo "<td rowspan='2' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"amount_shot".$j.$i};
         echo "</div></td>\n";
         echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"riron_shot".$j.$i};
         echo "</div></td>\n";
         echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'><div align='center' style='font-size: 18pt; color:red'>\n";
         echo ${"accomp_rate".$j.$i}."%";
         echo "</div></td>\n";
         echo "</tr>\n";
         echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
         echo "</tr>\n";
     }
    ?>
   </table>
   <br>
   <br>

   <?php

     for($i=1; $i<=${"n".$j}; $i++){
       ${"starting_tm".$j.$i} = substr(${"starting_tm".$j.$i}, 0, 10)." ".substr(${"starting_tm".$j.$i}, 11, 5);
       ${"finishing_tm".$j.$i} = substr(${"finishing_tm".$j.$i}, 0, 10)." ".substr(${"finishing_tm".$j.$i}, 11, 5);
       if(isset($m)){
         $m = $m + 1;
       }else{
         $m = 1;
       }
       //ビッグDB参照
       $connection = ConnectionManager::get('big_DB');
       $table = TableRegistry::get('shotdata_sensors');
       $table->setConnection($connection);

       $sql = "SELECT lot_num FROM shotdata_sensors".
             " where datetime >= '".${"starting_tm".$j.$i}."' and datetime <= '".${"finishing_tm".$j.$i}."' and seikeiki =".$j." and product_code ='".${"product_code".$j.$i}."' order by datetime asc";
       $connection = ConnectionManager::get('big_DB');
       ${"shotdata_sensors".$j.$i} = $connection->execute($sql)->fetchAll('assoc');

       if(isset(${"shotdata_sensors".$j.$i}[0])){
         ${"count_lot".$j.$i} = count(${"shotdata_sensors".$j.$i}) - 1;
         ${"first_lot_num".$j.$i} = ${"shotdata_sensors".$j.$i}[0]['lot_num'];
         ${"last_lot_num".$j.$i} = ${"shotdata_sensors".$j.$i}[${"count_lot".$j.$i}]['lot_num'];
       }else{
         ${"first_lot_num".$j.$i} = "";
         ${"last_lot_num".$j.$i} = "";
       }

       $connection = ConnectionManager::get('default');
       $table->setConnection($connection);

       $Product = $this->Products->find()->where(['product_code' => ${"product_code".$j.$i}])->toArray();
       if(($Product[0]->torisu) > 0){
         $torisu = $Product[0]->torisu;
         $Konpou = $this->Konpous->find()->where(['product_code' => ${"product_code".$j.$i}])->toArray();

           if(($Konpou[0]->irisu) > 0){
             $irisu = $Konpou[0]->irisu;

             ${"sum_predict_lot_num".$j.$i} = ceil((${"amount_shot".$j.$i} * $torisu) / $irisu);

           }else{

             echo "<pre>";
             print_r(${"product_code".$j.$i}."のirisuがKonpousテーブルに登録されていません※sum_predict_lot_num以外はこのまま登録できます");
             echo "</pre>";
             ${"sum_predict_lot_num".$j.$i} = "";

           }

       }else{

         echo "<pre>";
         print_r(${"product_code".$j.$i}."のtorisuがProductsテーブルに登録されていません※sum_predict_lot_num以外はこのまま登録できます");
         echo "</pre>";

         ${"sum_predict_lot_num".$j.$i} = "";
       }


       $GenjyouSeikeiki= $this->GenjyouSeikeikis->find()->where(['seikeiki' => $j])->toArray();
       $seikeiki_code = $GenjyouSeikeiki[0]->seikeiki_code;

       $_SESSION["karikadouseikei"][$m] = array(
         'product_code' => ${"product_code".$j.$i},
         'seikeiki' => $j,
         'seikeiki_code' => $seikeiki_code,
         'starting_tm' => ${"starting_tm".$j.$i},
         'finishing_tm' => ${"finishing_tm".$j.$i},
         'cycle_shot' => ${"cycle_shot".$j.$i},
         'amount_shot' => ${"amount_shot".$j.$i},
         'accomp_rate' => ${"accomp_rate".$j.$i}/100,
         "present_kensahyou" => 0,
         'first_lot_num' => ${"first_lot_num".$j.$i},
         "last_lot_num" => ${"last_lot_num".$j.$i},
         "sum_predict_lot_num" => ${"sum_predict_lot_num".$j.$i},
     );

     }
/*
     echo "<pre>";
     print_r($_SESSION["karikadouseikei"]);
     echo "</pre>";
*/
    ?>

<?php   /*ここまで6号機*/    ?>

<?php   /*ここから7号機*/    ?>

   <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
     <caption style="text-align: left">７号機</caption>
     <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
       <tr style="border-bottom: 0px;border-width: 0px">
         <td width="250" height="60" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">ショット数</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">理論ショット数</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">達成率</strong></div></td>
       </tr>


   <?php
   $j = 7;

   for($i=1; $i<=${"n".$j}; $i++){//7号機
         echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
         echo "<td rowspan='2'  height='10' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"product_code".$j.$i};
         echo "</div></td>\n";
         echo "</strong></div></td>\n";
         echo "<td colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"kadoujikan".$j.$i}/3600;
         echo "</div></td>\n";
         echo "<td rowspan='2' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"amount_shot".$j.$i};
         echo "</div></td>\n";
         echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"riron_shot".$j.$i};
         echo "</div></td>\n";
         echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'><div align='center' style='font-size: 18pt; color:red'>\n";
         echo ${"accomp_rate".$j.$i}."%";
         echo "</div></td>\n";
         echo "</tr>\n";
         echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
         echo "</tr>\n";
     }
    ?>
   </table>
   <br>
   <br>

   <?php

     for($i=1; $i<=${"n".$j}; $i++){
       ${"starting_tm".$j.$i} = substr(${"starting_tm".$j.$i}, 0, 10)." ".substr(${"starting_tm".$j.$i}, 11, 5);
       ${"finishing_tm".$j.$i} = substr(${"finishing_tm".$j.$i}, 0, 10)." ".substr(${"finishing_tm".$j.$i}, 11, 5);
       if(isset($m)){
         $m = $m + 1;
       }else{
         $m = 1;
       }
       //ビッグDB参照
       $connection = ConnectionManager::get('big_DB');
       $table = TableRegistry::get('shotdata_sensors');
       $table->setConnection($connection);

       $sql = "SELECT lot_num FROM shotdata_sensors".
             " where datetime >= '".${"starting_tm".$j.$i}."' and datetime <= '".${"finishing_tm".$j.$i}."' and seikeiki =".$j." and product_code ='".${"product_code".$j.$i}."' order by datetime asc";
       $connection = ConnectionManager::get('big_DB');
       ${"shotdata_sensors".$j.$i} = $connection->execute($sql)->fetchAll('assoc');

       if(isset(${"shotdata_sensors".$j.$i}[0])){
         ${"count_lot".$j.$i} = count(${"shotdata_sensors".$j.$i}) - 1;
         ${"first_lot_num".$j.$i} = ${"shotdata_sensors".$j.$i}[0]['lot_num'];
         ${"last_lot_num".$j.$i} = ${"shotdata_sensors".$j.$i}[${"count_lot".$j.$i}]['lot_num'];
       }else{
         ${"first_lot_num".$j.$i} = "";
         ${"last_lot_num".$j.$i} = "";
       }

       $connection = ConnectionManager::get('default');
       $table->setConnection($connection);

       $Product = $this->Products->find()->where(['product_code' => ${"product_code".$j.$i}])->toArray();
       if(($Product[0]->torisu) > 0){
         $torisu = $Product[0]->torisu;
         $Konpou = $this->Konpous->find()->where(['product_code' => ${"product_code".$j.$i}])->toArray();

           if(($Konpou[0]->irisu) > 0){
             $irisu = $Konpou[0]->irisu;

             ${"sum_predict_lot_num".$j.$i} = ceil((${"amount_shot".$j.$i} * $torisu) / $irisu);

           }else{

             echo "<pre>";
             print_r(${"product_code".$j.$i}."のirisuがKonpousテーブルに登録されていません※sum_predict_lot_num以外はこのまま登録できます");
             echo "</pre>";
             ${"sum_predict_lot_num".$j.$i} = "";

           }

       }else{

         echo "<pre>";
         print_r(${"product_code".$j.$i}."のtorisuがProductsテーブルに登録されていません※sum_predict_lot_num以外はこのまま登録できます");
         echo "</pre>";

         ${"sum_predict_lot_num".$j.$i} = "";
       }


       $GenjyouSeikeiki= $this->GenjyouSeikeikis->find()->where(['seikeiki' => $j])->toArray();
       $seikeiki_code = $GenjyouSeikeiki[0]->seikeiki_code;

       $_SESSION["karikadouseikei"][$m] = array(
         'product_code' => ${"product_code".$j.$i},
         'seikeiki' => $j,
         'seikeiki_code' => $seikeiki_code,
         'starting_tm' => ${"starting_tm".$j.$i},
         'finishing_tm' => ${"finishing_tm".$j.$i},
         'cycle_shot' => ${"cycle_shot".$j.$i},
         'amount_shot' => ${"amount_shot".$j.$i},
         'accomp_rate' => ${"accomp_rate".$j.$i}/100,
         "present_kensahyou" => 0,
         'first_lot_num' => ${"first_lot_num".$j.$i},
         "last_lot_num" => ${"last_lot_num".$j.$i},
         "sum_predict_lot_num" => ${"sum_predict_lot_num".$j.$i},
     );

     }
/*
     echo "<pre>";
     print_r($_SESSION["karikadouseikei"]);
     echo "</pre>";
*/
    ?>

<?php   /*ここまで7号機*/    ?>

<?php   /*ここから8号機*/    ?>

   <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
     <caption style="text-align: left">８号機</caption>
     <tbody border="2" bordercolor="#E6FFFF" bgcolor="#ffc0cb" style="border-bottom: solid;border-width: 1px">
       <tr style="border-bottom: 0px;border-width: 0px">
         <td width="250" height="60" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">ショット数</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">理論ショット数</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">達成率</strong></div></td>
       </tr>


   <?php
   $j = 8;

   for($i=1; $i<=${"n".$j}; $i++){//８号機
         echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
         echo "<td rowspan='2'  height='10' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"product_code".$j.$i};
         echo "</div></td>\n";
         echo "</strong></div></td>\n";
         echo "<td colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"kadoujikan".$j.$i}/3600;
         echo "</div></td>\n";
         echo "<td rowspan='2' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"amount_shot".$j.$i};
         echo "</div></td>\n";
         echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"riron_shot".$j.$i};
         echo "</div></td>\n";
         echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'><div align='center' style='font-size: 18pt; color:red'>\n";
         echo ${"accomp_rate".$j.$i}."%";
         echo "</div></td>\n";
         echo "</tr>\n";
         echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
         echo "</tr>\n";
     }
    ?>
   </table>
   <br>
   <br>

   <?php

     for($i=1; $i<=${"n".$j}; $i++){
       ${"starting_tm".$j.$i} = substr(${"starting_tm".$j.$i}, 0, 10)." ".substr(${"starting_tm".$j.$i}, 11, 5);
       ${"finishing_tm".$j.$i} = substr(${"finishing_tm".$j.$i}, 0, 10)." ".substr(${"finishing_tm".$j.$i}, 11, 5);
       if(isset($m)){
         $m = $m + 1;
       }else{
         $m = 1;
       }
       //ビッグDB参照
       $connection = ConnectionManager::get('big_DB');
       $table = TableRegistry::get('shotdata_sensors');
       $table->setConnection($connection);

       $sql = "SELECT lot_num FROM shotdata_sensors".
             " where datetime >= '".${"starting_tm".$j.$i}."' and datetime <= '".${"finishing_tm".$j.$i}."' and seikeiki =".$j." and product_code ='".${"product_code".$j.$i}."' order by datetime asc";
       $connection = ConnectionManager::get('big_DB');
       ${"shotdata_sensors".$j.$i} = $connection->execute($sql)->fetchAll('assoc');

       if(isset(${"shotdata_sensors".$j.$i}[0])){
         ${"count_lot".$j.$i} = count(${"shotdata_sensors".$j.$i}) - 1;
         ${"first_lot_num".$j.$i} = ${"shotdata_sensors".$j.$i}[0]['lot_num'];
         ${"last_lot_num".$j.$i} = ${"shotdata_sensors".$j.$i}[${"count_lot".$j.$i}]['lot_num'];
       }else{
         ${"first_lot_num".$j.$i} = "";
         ${"last_lot_num".$j.$i} = "";
       }

       $connection = ConnectionManager::get('default');
       $table->setConnection($connection);

       $Product = $this->Products->find()->where(['product_code' => ${"product_code".$j.$i}])->toArray();
       if(($Product[0]->torisu) > 0){
         $torisu = $Product[0]->torisu;
         $Konpou = $this->Konpous->find()->where(['product_code' => ${"product_code".$j.$i}])->toArray();

           if(($Konpou[0]->irisu) > 0){
             $irisu = $Konpou[0]->irisu;

             ${"sum_predict_lot_num".$j.$i} = ceil((${"amount_shot".$j.$i} * $torisu) / $irisu);

           }else{

             echo "<pre>";
             print_r(${"product_code".$j.$i}."のirisuがKonpousテーブルに登録されていません※sum_predict_lot_num以外はこのまま登録できます");
             echo "</pre>";
             ${"sum_predict_lot_num".$j.$i} = "";

           }

       }else{

         echo "<pre>";
         print_r(${"product_code".$j.$i}."のtorisuがProductsテーブルに登録されていません※sum_predict_lot_num以外はこのまま登録できます");
         echo "</pre>";

         ${"sum_predict_lot_num".$j.$i} = "";
       }


       $GenjyouSeikeiki= $this->GenjyouSeikeikis->find()->where(['seikeiki' => $j])->toArray();
       $seikeiki_code = $GenjyouSeikeiki[0]->seikeiki_code;

       $_SESSION["karikadouseikei"][$m] = array(
         'product_code' => ${"product_code".$j.$i},
         'seikeiki' => $j,
         'seikeiki_code' => $seikeiki_code,
         'starting_tm' => ${"starting_tm".$j.$i},
         'finishing_tm' => ${"finishing_tm".$j.$i},
         'cycle_shot' => ${"cycle_shot".$j.$i},
         'amount_shot' => ${"amount_shot".$j.$i},
         'accomp_rate' => ${"accomp_rate".$j.$i}/100,
         "present_kensahyou" => 0,
         'first_lot_num' => ${"first_lot_num".$j.$i},
         "last_lot_num" => ${"last_lot_num".$j.$i},
         "sum_predict_lot_num" => ${"sum_predict_lot_num".$j.$i},
   );

     }
/*
     echo "<pre>";
     print_r($_SESSION["karikadouseikei"]);
     echo "</pre>";
*/
    ?>

<?php   /*ここまで８号機*/    ?>

<?php   /*ここから9号機*/    ?>

   <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
     <caption style="text-align: left">９号機</caption>
     <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
       <tr style="border-bottom: 0px;border-width: 0px">
         <td width="250" height="60" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">ショット数</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">理論ショット数</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">達成率</strong></div></td>
       </tr>


   <?php
   $j = 9;

   for($i=1; $i<=${"n".$j}; $i++){//7号機
         echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
         echo "<td rowspan='2'  height='10' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"product_code".$j.$i};
         echo "</div></td>\n";
         echo "</strong></div></td>\n";
         echo "<td colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"kadoujikan".$j.$i}/3600;
         echo "</div></td>\n";
         echo "<td rowspan='2' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"amount_shot".$j.$i};
         echo "</div></td>\n";
         echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"riron_shot".$j.$i};
         echo "</div></td>\n";
         echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'><div align='center' style='font-size: 18pt; color:red'>\n";
         echo ${"accomp_rate".$j.$i}."%";
         echo "</div></td>\n";
         echo "</tr>\n";
         echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
         echo "</tr>\n";
     }
    ?>
   </table>
   <br>
   <br>

   <?php

     for($i=1; $i<=${"n".$j}; $i++){
       ${"starting_tm".$j.$i} = substr(${"starting_tm".$j.$i}, 0, 10)." ".substr(${"starting_tm".$j.$i}, 11, 5);
       ${"finishing_tm".$j.$i} = substr(${"finishing_tm".$j.$i}, 0, 10)." ".substr(${"finishing_tm".$j.$i}, 11, 5);
       if(isset($m)){
         $m = $m + 1;
       }else{
         $m = 1;
       }
       //ビッグDB参照
       $connection = ConnectionManager::get('big_DB');
       $table = TableRegistry::get('shotdata_sensors');
       $table->setConnection($connection);

       $sql = "SELECT lot_num FROM shotdata_sensors".
             " where datetime >= '".${"starting_tm".$j.$i}."' and datetime <= '".${"finishing_tm".$j.$i}."' and seikeiki =".$j." and product_code ='".${"product_code".$j.$i}."' order by datetime asc";
       $connection = ConnectionManager::get('big_DB');
       ${"shotdata_sensors".$j.$i} = $connection->execute($sql)->fetchAll('assoc');

       if(isset(${"shotdata_sensors".$j.$i}[0])){
         ${"count_lot".$j.$i} = count(${"shotdata_sensors".$j.$i}) - 1;
         ${"first_lot_num".$j.$i} = ${"shotdata_sensors".$j.$i}[0]['lot_num'];
         ${"last_lot_num".$j.$i} = ${"shotdata_sensors".$j.$i}[${"count_lot".$j.$i}]['lot_num'];
       }else{
         ${"first_lot_num".$j.$i} = "";
         ${"last_lot_num".$j.$i} = "";
       }

       $connection = ConnectionManager::get('default');
       $table->setConnection($connection);

       $Product = $this->Products->find()->where(['product_code' => ${"product_code".$j.$i}])->toArray();
       if(($Product[0]->torisu) > 0){
         $torisu = $Product[0]->torisu;
         $Konpou = $this->Konpous->find()->where(['product_code' => ${"product_code".$j.$i}])->toArray();

           if(($Konpou[0]->irisu) > 0){
             $irisu = $Konpou[0]->irisu;

             ${"sum_predict_lot_num".$j.$i} = ceil((${"amount_shot".$j.$i} * $torisu) / $irisu);

           }else{

             echo "<pre>";
             print_r(${"product_code".$j.$i}."のirisuがKonpousテーブルに登録されていません※sum_predict_lot_num以外はこのまま登録できます");
             echo "</pre>";
             ${"sum_predict_lot_num".$j.$i} = "";

           }

       }else{

         echo "<pre>";
         print_r(${"product_code".$j.$i}."のtorisuがProductsテーブルに登録されていません※sum_predict_lot_num以外はこのまま登録できます");
         echo "</pre>";

         ${"sum_predict_lot_num".$j.$i} = "";
       }

       $GenjyouSeikeiki= $this->GenjyouSeikeikis->find()->where(['seikeiki' => $j])->toArray();
       $seikeiki_code = $GenjyouSeikeiki[0]->seikeiki_code;

       $_SESSION["karikadouseikei"][$m] = array(
         'product_code' => ${"product_code".$j.$i},
         'seikeiki' => $j,
         'seikeiki_code' => $seikeiki_code,
         'starting_tm' => ${"starting_tm".$j.$i},
         'finishing_tm' => ${"finishing_tm".$j.$i},
         'cycle_shot' => ${"cycle_shot".$j.$i},
         'amount_shot' => ${"amount_shot".$j.$i},
         'accomp_rate' => ${"accomp_rate".$j.$i}/100,
         "present_kensahyou" => 0,
         'first_lot_num' => ${"first_lot_num".$j.$i},
         "last_lot_num" => ${"last_lot_num".$j.$i},
         "sum_predict_lot_num" => ${"sum_predict_lot_num".$j.$i},
       );

     }
     /*
     echo "<pre>";
     print_r($_SESSION["karikadouseikei"]);
     echo "</pre>";
*/
    ?>

<?php   /*ここまで9号機*/    ?>

  <br>

  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr bgcolor="#E6FFFF" >
    <td align="center" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="center"><?= $this->Form->submit(__('登録'), array('name' => 'touroku', 'value'=>"1")); ?></div></td>
  </tr>
  </table>

  <br>
